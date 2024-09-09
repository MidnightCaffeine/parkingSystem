<?php
$page = "Restore";
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
            <a class="btn btn-primary" href="backupAndRestore.php" role="button"><i class='bx bx-arrow-back'></i> Go Back</a>
            <div class="container">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="input-group ms-auto">
                        <input type="file" class="form-control" name="backupfile" id="backupfile" aria-describedby="restoreBtn" aria-label="Upload">
                        <button name="restore" class="btn btn-outline-secondary" type="submit" id="restoreBtn">Restore</button>
                    </div>
                </form>
                <div class="row mt-3">
                    <?php require_once 'lib/php/database_handler/restore.php'; ?>
                </div>

            </div>
        </section>
    </main>

    <?php

    include_once 'assets/components/footer.php';
    include_once 'assets/components/main_scripts.php';

    ?>

</body>

</html>