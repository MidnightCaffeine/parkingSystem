<?php
$page = "Home";
require_once 'lib/php/database_handler/connection.php';
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once 'assets/components/head.php'; ?>
</head>

<body>
    <?php

    include_once 'assets/components/navigation.php';
    include_once 'assets/components/side_navigation.php';

    ?>
    <main id="main" class="main">
        <section class="section dashboard">
            <h3>Available Parking Slots</h3>
            <div class="row">

                <?php
                include_once 'lib/php/components/available_slots.php';
                if (!isset($_SESSION['user_type'])) {
                    include_once 'lib/php/components/scanner.php';
                }if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Administrator') {
                    include_once 'lib/php/components/register_approve.php';
                }
                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'Guard') {
                    include_once 'lib/php/components/parking_list.php';
                }
                ?>
            </div>
        </section>
    </main>

    <script type="text/javascript" src="assets/js/html5-qrcode.min.js"></script>
    <?php

    include_once 'assets/components/footer.php';
    include_once 'assets/components/main_scripts.php';
    include_once 'lib/php/components/modals.php';
    ?>

</body>

</html>