<?php
$page = "Home";
require_once 'lib/php/database_handler/connection.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once 'assets/components/head.php';  ?>
</head>

<body>
    <?php

    include_once 'assets/components/navigation.php';
    include_once 'assets/components/side_navigation.php';

    ?>
    <main id="main" class="main">
        <section class="section dashboard">
            <video id="preview" style="background: black; height:80vh; width: 100%;"></video>
            <script>
                const args = {
                    video: document.getElementById('preview')
                };

                window.URL.createObjectURL = (stream) => {
                    args.video.srcObject = stream;
                    return stream;
                };

                const scanner = new Instascan.Scanner(args);


                scanner.addListener('scan', function(content) {
                    alert('Do you want to open this page?: ' + content);
                    window.open(content, "_blank");
                });
                Instascan.Camera.getCameras().then(cameras => {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error("Please enable Camera!");
                    }
                });
            </script>
        </section>
    </main>

    <?php

    include_once 'assets/components/footer.php';
    include_once 'assets/components/main_scripts.php';

    ?>

</body>

</html>