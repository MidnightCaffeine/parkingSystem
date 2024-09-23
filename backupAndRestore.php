<?php
$page = "Backup And Restore";
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
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <h4 class="card-title ms-4">Backup</h4>
                            <p class="card-text ms-4">Save backup of the database.</p>
                            <div class="d-grid gap-2 ms-4 mb-4 me-4">
                                <a class="btn btn-primary" href="backup.php">Backup</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title ms-4">Restore</h4>
                                <p class="card-text ms-4">Restore data of the database.</p>
                                <div class="d-grid gap-2 ms-4 mb-4 me-4">
                                    <a class="btn btn-primary" href="restore.php">Restore</a>
                                </div>
                            </div>
                        </div>
                    </div>
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