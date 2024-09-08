<?php
$page = "Backup";
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
            <div class="container">
                <?php require_once 'lib/php/database_handler/backup.php';?>
            </div>
        </section>
    </main>

    <?php

    include_once 'assets/components/footer.php';
    include_once 'assets/components/main_scripts.php';

    ?>

</body>

</html>