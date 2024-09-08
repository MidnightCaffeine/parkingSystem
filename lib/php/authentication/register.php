<?php
session_start();
require_once '../database_handler/connection.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  exit;
}

if (isset($_POST['signUp'])) {

  $firstname = ucwords(strtolower($_POST['register_firstname']));
  $lastname = ucwords(strtolower($_POST['register_lastname']));
  $middlename = ucwords(strtolower($_POST['register_middlename']));
  $email = $_POST['register_email'];
  $department = $_POST['department'];
  $year_group = $_POST['year_group'];
  $section = $_POST['section'];
  $mv_file = $_POST['mv_file'];
  $body_number = $_POST['body_number'];
  $password = $_POST['register_password'];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


  $select = $pdo->prepare("SELECT email from users where email= :email");
  $select->bindParam(':email', $email);
  if ($select->execute()) {
    if ($select->rowCount() > 0) {
      echo '
    <script type="text/javascript">
      Swal.fire({
        icon: "error",
        title: "This email is already registered!",
        text: "Please use a different email" });
    </script>
      ';
    } else {

      $query = "INSERT into users(email,password) values(:email,:password)";
      $insert = $pdo->prepare($query);
      $insert->bindParam(':email', $email);
      $insert->bindParam(':password', $hashedPassword);
      if ($insert->execute()) {
        $select = $pdo->prepare("SELECT user_id FROM users WHERE email= :email");
        $select->bindParam(':email', $email);
        $select->execute();

        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
          $user_id = $row['user_id'];
        }

        $query = "INSERT into user_details(user_id, firstname, lastname, middlename, department, year_group, section, mv_file, body_number) values(:user_id,:firstname, :lastname, :middlename, :department, :year_group, :section, :mv_file,:body_number)";
        $insert = $pdo->prepare($query);
        $insert->bindParam(':user_id', $user_id);
        $insert->bindParam(':firstname', $firstname);
        $insert->bindParam(':firstname', $firstname);
        $insert->bindParam(':lastname', $lastname);
        $insert->bindParam(':middlename', $middlename);
        $insert->bindParam(':department', $department);
        $insert->bindParam(':year_group', $year_group);
        $insert->bindParam(':section', $section);
        $insert->bindParam(':mv_file', $mv_file);
        $insert->bindParam(':body_number', $body_number);

        if ($insert->execute()) {
          echo '
        <script type="text/javascript">
          Swal.fire({
            icon: "success",
            title: "Registration Successful!",
            text: "Please authenticate the information on the admin to complete the process"
          });
        </script>
      ';
        }
      }
    }
  }
}
