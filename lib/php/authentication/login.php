<?php
session_start();
require_once '../database_handler/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

if (isset($_POST['login'])) {
    // Sanitize user input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $can_login = 2; // Invalid input
    } else {
        $select = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $select->bindParam(':email', $email);
        $select->execute();
        $row = $select->fetch(PDO::FETCH_ASSOC);

        if ($select->rowCount() > 0 && password_verify($password, $row['password'])) {
            if ($row['user_status'] != 0) {
                $can_login = 1;

                $user_id = $row['user_id'];
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $email;

                // Handle user type
                switch ($row['user_type']) {
                    case 1:
                        $_SESSION['user_type'] = 'Administrator';
                        $_SESSION['user_name'] = 'Administrator';
                        $_SESSION['user_firstname'] = 'Administrator';
                        break;
                    case 3:
                        $_SESSION['user_type'] = 'Guard';
                        $_SESSION['user_name'] = 'Guard';
                        $_SESSION['user_firstname'] = 'Guard';
                        break;
                    case 2:
                        $_SESSION['user_type'] = 'User';
                        $_SESSION['user_name'] = $row['firstname'] . ' ' . $row['lastname'];
                        $_SESSION['user_firstname'] = $row['firstname'];

                        // Set vehicle type
                        switch ($row['vehicle_type']) {
                            case 1:
                                $_SESSION['vehicle_type'] = 'Car';
                                break;
                            case 2:
                                $_SESSION['vehicle_type'] = 'Tricycle';
                                break;
                            case 3:
                                $_SESSION['vehicle_type'] = 'Motorcycle';
                                break;
                        }
                        break;
                }

                // Log user action
                $action = 'Logged into the system';
                $insertLog = $pdo->prepare("INSERT INTO user_logs(user_id, username, action) values(:id, :user, :action)");
                $insertLog->bindParam(':id', $user_id);
                $insertLog->bindParam(':user', $_SESSION['user_name']);
                $insertLog->bindParam(':action', $action);
                $insertLog->execute();

            } else {
                $can_login = 0; // Inactive user
            }
        } else {
            $can_login = 2; // Invalid credentials
        }
    }
}
?>

<script>
    var login = <?= json_encode($can_login); ?>;

    if (login == 1) {
        Swal.fire({
            title: "Login Successful!",
            text: "Redirecting to home page",
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false,
        }).then(() => {
            window.location.replace("home.php");
        });

    } else if (login == 0) {
        Swal.fire({
            title: "Account Inactive",
            text: "Please contact the administrator to activate your account.",
            icon: "warning",
            showConfirmButton: true,
        });

    } else if (login == 2) {
        Swal.fire({
            title: "Login Failed",
            text: "Email or Password is incorrect",
            icon: "error",
            showConfirmButton: true,
        });
    }
</script>