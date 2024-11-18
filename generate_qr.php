<?php
require_once 'lib/php/database_handler/connection.php';
include 'assets/vendor/phpqrcode/qrlib.php';
session_start();

// Set the current page for session tracking
$_SESSION['page'] = 'Generate QR Code';
include_once 'lib/php/user_check.php';
include_once 'lib/php/only_admin.php';

if (isset($_POST['qr_text'])) {
    // Sanitize input to allow only plain text (letters, numbers, spaces, and some punctuation)
    $text = $_POST['qr_text'];

    // Regular expression to allow only letters, numbers, spaces, and basic punctuation
    if (preg_match('/^[a-zA-Z0-9\s,.\-!?()&]*$/', $text)) {
        $text = htmlspecialchars(trim($text)); // Additional sanitization if needed
    } else {
        // Handle invalid input
        echo json_encode(['error' => 'Input contains invalid characters']);
        exit;
    }

    // Check if input is not empty
    if (!empty($text)) {
        // Set the error correction level, pixel size, and frame size
        $ecc = 'H';
        $pixel_Size = 20;
        $frame_Size = 2;

        // Generate the QR code with larger dimensions
        ob_start();
        QRcode::png($text, null, $ecc, $pixel_Size, $frame_Size);
        $imageString = base64_encode(ob_get_contents());
        ob_end_clean();

        // Return the QR code and the text as JSON response
        echo json_encode([
            'imageString' => $imageString,
            'text' => $text
        ]);
        exit;
    } else {
        // Handle empty input error
        echo json_encode(['error' => 'Input cannot be empty']);
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include external head components (meta, styles, etc.) -->
    <?php require_once 'assets/components/head.php'; ?>
    <style>
        /* Loading bar styles */
        #loading {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        .progress {
            width: 100%;
            height: 20px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: auto;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background-color: #007bff;
            animation: loading 2s linear forwards;
        }

        @keyframes loading {
            0% {
                width: 0;
            }

            100% {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Include navigation bars -->
    <?php
    require_once 'assets/components/navigation.php';
    require_once 'assets/components/side_navigation.php';
    ?>

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="row">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h2 class="text-center mb-4">Generate QR Code</h2>

                                <form id="qrForm">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="qr_text" name="qr_text"
                                            placeholder="Enter text for QR code" required />
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Generate QR Code</button>
                                    </div>
                                </form>

                                <!-- Loading bar -->
                                <div id="loading">
                                    <div class="progress">
                                        <div class="progress-bar"></div>
                                    </div>
                                    <p>Generating QR Code...</p>
                                </div>

                                <div id="qrResult" class="mt-5 text-center" style="display:none;">
                                    <h3>QR Code Preview:</h3>
                                    <img id="qrImage" class="img-fluid mb-3" src="" alt="QR Code">
                                    <p class="fw-bold" id="qrText"></p>
                                    <a id="save_login" href="#" download="qr_code.png" class="btn btn-success">Set As Login</a>
                                    <a id="save_logout" href="#" download="qr_code.png" class="btn btn-success">Set As Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Include scripts and footer -->
    <script type="text/javascript" src="assets/js/html5-qrcode.min.js"></script>
    <?php
    require_once 'assets/components/footer.php';
    require_once 'assets/components/main_scripts.php';
    require_once 'lib/php/components/modals.php';
    ?>
    <script>
        $(document).ready(function () {

            // Save QR code as login
            $('#save_login').click(function () {
                var qr_data_login = $("#qr_text").val();

                $.ajax({
                    url: "lib/php/system/save_qr.php",
                    method: "POST",
                    data: {
                        qr_data_login,
                    },
                    success: function (data) {
                        Swal.fire({
                            title: "Successful!",
                            text: "QR Code Has Been Saved as Login!",
                            icon: "success",
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                        });
                    },
                });
            });
            $('#save_logout').click(function () {
                var qr_data_logout = $("#qr_text").val();

                $.ajax({
                    url: "lib/php/system/save_qr.php",
                    method: "POST",
                    data: {
                        qr_data_logout,
                    },
                    success: function (data) {
                        Swal.fire({
                            title: "Successful!",
                            text: "QR Code Has Been Saved as Logout!",
                            icon: "success",
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                        });
                    },
                });
            });

            // Form submission event
            $('#qrForm').on('submit', function (e) {
                e.preventDefault();

                var qrText = $('#qr_text').val();

                // Regular expression to check for only plain text characters
                var regex = /^[a-zA-Z0-9\s,.\-!?()&]*$/;

                if (!regex.test(qrText)) {
                    alert('Invalid characters detected. Please enter only plain text.');
                    return;
                }

                var formData = $(this).serialize();

                // Show loading bar
                $('#loading').show();

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#loading').hide(); // Hide loading bar
                        if (response.error) {
                            alert(response.error);
                        } else {
                            $('#qrResult').show();
                            $('#qrImage').attr('src', 'data:image/png;base64,' + response.imageString);
                            $('#qrText').text(response.text);
                            $('#save_login').attr('href', 'data:image/png;base64,' + response.imageString);
                            $('#save_logout').attr('href', 'data:image/png;base64,' + response.imageString);
                        }
                    },
                    error: function () {
                        $('#loading').hide(); // Hide loading bar
                        alert('Error generating QR code');
                    }
                });
            });
        });
    </script>
</body>

</html>
