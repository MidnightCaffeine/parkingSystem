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

        $user_id =  $row['user_id'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_email'] = $email;
        if ($row['user_type'] == 1) {
            $_SESSION['user_type'] = 'Administrator';
            $_SESSION['user_name'] = 'Administrator';
            $_SESSION['user_firstname'] = 'Administrator';
        }
        $action = 'Logged to the system';
        $select = $pdo->prepare("SELECT * FROM user_details WHERE user_id = '$user_id'");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['user_name'] = $row['firstname'] . ' ' . $row['lastname'];
            $_SESSION['user_firstname'] = $row['firstname'];
        };

        $insertLog = $pdo->prepare("INSERT INTO user_logs(user_id, username, action) values(:id, :user, :action)");

        $insertLog->bindParam(':id', $user_id);
        $insertLog->bindParam(':user', $_SESSION['user_name']);
        $insertLog->bindParam(':action', $action);
        $insertLog->execute();

        $can_login = true;
    }
}
?>

<script>
    var login = <?php echo $can_login; ?>;

    if (login == true) {
        Swal.fire({
            title: "Login Successful!",
            text: "Redirecting to home page",
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false,
        });

        setTimeout(function() {
            window.location.replace("home.php"); //will redirect to homepage
        }, 2000); //redirect after 2 seconds
    }
</script>