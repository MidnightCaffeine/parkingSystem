<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?php if ($page != 'Home') {
                echo 'collapsed';
            } ?>" href="home.php">
                <i class="bi bi-grid"></i>
                <span>
                    <?php
                    if (isset($_SESSION['user_type'])) {
                        echo 'Dashboard';
                    } else {
                        echo 'Scan QR';
                    }
                    ?>
                </span>
            </a>
        </li>


        <?php
        if (isset($_SESSION['user_type'])) {
            ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-building"></i>
                    <span>Manage</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    
                    <li>
                        <a href="users.php">
                            <i class="bi bi-circle"></i>
                            <span>Users</span>
                        </a>
                    </li>

                    <li>
                        <a href="icons-remix.html">
                            <i class="bi bi-circle"></i>
                            <span>Remix Icons</span>
                        </a>
                    </li>
                    <li> <a href="icons-boxicons.html"> <i class="bi bi-circle"></i><span>Boxicons</span> </a></li>
                </ul>
            </li>

            <?php
        }
        ?>

        <?php
        if (isset($_SESSION['user_type'])) {
            ?>
            <li class="nav-item">
                <a class="nav-link <?php if ($page != 'Backup And Restore') {
                    echo 'collapsed';
                } ?>" href="backupAndRestore.php">
                    <i class="bi bi-hdd-stack"></i>
                    <span>Backup and restore</span>
                </a>
            </li>
            <?php
        }
        ?>


    </ul>
</aside>