<div class="container">
    <h1>Scan QR to park</h1>
    <div class="section">
        <div id="my-qr-reader">
        </div>
    </div>
</div>

<script>
    function domReady(fn) {
        if (
            document.readyState === "complete" ||
            document.readyState === "interactive"
        ) {
            setTimeout(fn, 1000);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    domReady(function () {

        // If found you qr code
        function onScanSuccess(decodeText, decodeResult) {
            // alert("You Qr is : " + decodeText, decodeResult);
            var qr_data = decodeText, decodeResult;

            htmlscanner.clear();

            $.ajax({
                url: "lib/php/bridge/iot_connection.php",
                method: "POST",
                data: {
                    qr_data,
                },
                success: function (data) {
                    Swal.fire({
                        title: "Successful!",
                        text: "Please wait for the toll gate to open!",
                        icon: "success",
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });

                },
                error: function (xhr, status, error) {
                    // This runs if the server responds with an HTTP error (e.g., 400, 500)
                    Swal.fire({
                        title: "You already parked a vehicle!",
                        text: "Unparked your vehicle first to login!",
                        icon: "error",
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });
                }
            });

        }

        let htmlscanner = new Html5QrcodeScanner(
            "my-qr-reader",
            {
                fps: 10,
                qrbos: 250,
                supportedScanTypes:
                    [
                        Html5QrcodeScanType.SCAN_TYPE_CAMERA
                    ]
            }
        );
        htmlscanner.render(onScanSuccess);
    });
</script>