<?php
// Include the qrlib file
include 'assets/vendor/phpqrcode/qrlib.php';

if (isset($_POST['qr_text'])) {
    // Sanitize input
    $text = htmlspecialchars(trim($_POST['qr_text']));

    // Check if input is not empty
    if (!empty($text)) {
        // Set the error correction level, pixel size, and frame size
        $ecc = 'H';
        $pixel_Size = 20;
        $frame_Size = 10;

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR</title>
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
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

<body class="bg-light">
    <div class="container mt-5">
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
                            <a id="downloadLink" href="#" download="qr_code.png" class="btn btn-success">Download
                                High-Resolution QR Code</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#qrForm').on('submit', function (e) {
                e.preventDefault();

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
                            $('#downloadLink').attr('href', 'data:image/png;base64,' + response.imageString);
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