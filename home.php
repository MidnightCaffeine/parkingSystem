<?php
require_once 'lib/php/database_handler/connection.php';
session_start();

// Set the current page for session tracking
$_SESSION['page'] = 'Home';

/**
 * Include role-specific components based on the user type.
 *
 * @param string $userType The type of user from session data.
 */
function includeUserComponents($userType) {
    switch ($userType) {
        case 'User':
            require_once 'lib/php/components/scanner.php';
            break;
        case 'Administrator':
            require_once 'lib/php/components/register_approve.php';
            break;
        case 'Guard':
            require_once 'lib/php/components/parking_list.php';
            break;
        default:
            // Optionally handle unknown user types
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include external head components (meta, styles, etc.) -->
    <?php require_once 'assets/components/head.php'; ?>
</head>

<body>
    <!-- Include navigation bars -->
    <?php
    require_once 'assets/components/navigation.php';
    require_once 'assets/components/side_navigation.php';
    ?>

    <main id="main" class="main">
        <section class="section dashboard">
            <h3>Available Parking Slots</h3>
            <div class="row">
                <?php
                // Include available parking slots
                require_once 'lib/php/components/available_slots.php';

                // Check user type and include appropriate components
                if (isset($_SESSION['user_type'])) {
                    includeUserComponents($_SESSION['user_type']);
                }
                ?>
            </div>
        </section>
    </main>

    <!-- Include scripts and footer -->
    <script type="text/javascript" src="assets/js/html5-qrcode.min.js"></script>
    <?php
    require_once 'assets/components/footer.php';
    require_once 'assets/components/main_scripts.php';
    require_once 'lib/php/components/modals.php';
    ?>
</body>

</html>
