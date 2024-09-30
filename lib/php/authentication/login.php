<?php
session_start();
require_once '../database_handler/connection.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $select = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $select->bindParam(':email', $email);
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $row['password'])) {

        if ($row['status'] != 0) {
            $can_login = 1;

            $user_id = $row['user_id'];
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            if ($row['user_type'] == 1) {
                $_SESSION['user_type'] = 'Administrator';
                $_SESSION['user_name'] = 'Administrator';
                $_SESSION['user_firstname'] = 'Administrator';
            } elseif ($row['user_type'] == 3) {
                $_SESSION['user_type'] = 'Guard';
                $_SESSION['user_name'] = 'Guard';
                $_SESSION['user_firstname'] = 'Guard';
            } else {
                $_SESSION['user_name'] = $row['firstname'] . ' ' . $row['lastname'];
                $_SESSION['user_firstname'] = $row['firstname'];
                if (!isset($_SESSION['user_type'])) {
                    switch ($row['vehicle_type']) {
                        case 1:
                            $_SESSION['vehicle_type'] = 'Car';
                            break;
                        case 2:

                            $_SESSION['vehicle_type'] = 'Tricycle';
                            break;
                        case 3:
                            $_SESSION['vehicle_type'] = 'Motorcyle';
                            break;
                    }
                }

            }

            $action = 'Logged to the system';

            $insertLog = $pdo->prepare("INSERT INTO user_logs(user_id, username, action) values(:id, :user, :action)");

            $insertLog->bindParam(':id', $user_id);
            $insertLog->bindParam(':user', $_SESSION['user_name']);
            $insertLog->bindParam(':action', $action);
            $insertLog->execute();
        } else {
            $can_login = 0;
        }

    }
}
?>

<script>
    var login = <?php echo $can_login; ?>;

    if (login == 1) {
        Swal.fire({
            title: "Login Successful!",
            text: "Redirecting to home page",
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false,
        });

        setTimeout(function () {
            window.location.replace("home.php"); //will redirect to homepage
        }, 2000); //redirect after 2 seconds
    } else {
        Swal.fire({
            title: "Comlete your registration",
            text: "Authenticate your information on the admin to complete",
            icon: "warning",
            showConfirmButton: true,
        });
    }
</script>