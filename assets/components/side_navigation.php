<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Home or Dashboard -->
        <li class="nav-item">
            <a class="nav-link <?= ($_SESSION['page'] !== 'Home') ? 'collapsed' : '' ?>" href="home.php">
                <i class="bi bi-grid"></i>
                <span>
                    <?= ($_SESSION['user_type'] === 'Administrator' || $_SESSION['user_type'] === 'Guard') ? 'Dashboard' : 'Scan QR'; ?>
                </span>
            </a>
        </li>

        <!-- Guard-specific link: Users -->
        <?php if ($_SESSION['user_type'] === 'Guard'): ?>
            <li class="nav-item">
                <a class="nav-link <?= ($_SESSION['page'] !== 'Users') ? 'collapsed' : '' ?>" href="users.php">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- Administrator-specific links: Manage and Backup & Restore -->
        <?php if ($_SESSION['user_type'] === 'Administrator'): ?>
            <li class="nav-item">
                <a class="nav-link <?= ($_SESSION['page'] === 'Users' || $_SESSION['page'] === 'Generate QR Code' || $_SESSION['page'] === 'System') ? '' : 'collapsed'; ?>" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-building"></i>
                    <span>Manage</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="icons-nav" class="nav-content <?= ($_SESSION['page'] === 'Users' || $_SESSION['page'] === 'Generate QR Code' || $_SESSION['page'] === 'System') ? '' : 'collapse'; ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="users.php" class="<?= ($_SESSION['page'] !== 'Users') ? '' : 'active' ?>">
                            <i class="bi bi-circle"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="system.php" class="<?= ($_SESSION['page'] !== 'System') ? '' : 'active' ?>">
                            <i class="bi bi-circle"></i>
                            <span>System</span>
                        </a>
                    </li>
                    <li>
                        <a href="generate_qr.php" class="<?= ($_SESSION['page'] !== 'Generate QR Code') ? '' : 'active' ?>">
                            <i class="bi bi-circle"></i>
                            <span>Generate QR</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= ($_SESSION['page'] === 'Restore' || $_SESSION['page'] === 'Backup' || $_SESSION['page'] === 'Backup And Restore') ? '' : 'collapsed'; ?>"
                    href="backupAndRestore.php">
                    <i class="bi bi-hdd-stack"></i>
                    <span>Backup and Restore</span>
                </a>
            </li>
        <?php endif; ?>

    </ul>
</aside>