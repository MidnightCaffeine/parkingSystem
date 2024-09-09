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
            <a class="btn btn-primary mb-3" href="backupAndRestore.php" role="button"><i class='bx bx-arrow-back'></i> Go Back</a>
            <div class="container">
                <?php require_once 'lib/php/database_handler/backup.php'; ?>
            </div>
        </section>
    </main>

    <?php

    include_once 'assets/components/footer.php';
    include_once 'assets/components/main_scripts.php';

    ?>

</body>

</html>