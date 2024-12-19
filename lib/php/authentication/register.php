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
  $vehicle_type = $_POST['vehicle_type'];


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

      $query = "INSERT into users(email, password, firstname, lastname, middlename, department, year_group, section, mv_file, body_number, vehicle_type) values(:email, :password, :firstname, :lastname, :middlename, :department, :year_group, :section, :mv_file, :body_number, :vehicle_type)";
      $insert = $pdo->prepare($query);
      $insert->bindParam(':email', $email);
      $insert->bindParam(':password', $hashedPassword);
      $insert->bindParam(':firstname', $firstname);
      $insert->bindParam(':firstname', $firstname);
      $insert->bindParam(':lastname', $lastname);
      $insert->bindParam(':middlename', $middlename);
      $insert->bindParam(':department', $department);
      $insert->bindParam(':year_group', $year_group);
      $insert->bindParam(':section', $section);
      $insert->bindParam(':mv_file', $mv_file);
      $insert->bindParam(':body_number', $body_number);
      $insert->bindParam(':vehicle_type', $vehicle_type);
      if ($insert->execute()) {

        $select = $pdo->prepare("SELECT * from users where email= :email");
        $select->bindParam(':email', $email);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        $user_id = $result['user_id '];

        $query = "INSERT INTO vehicles(user_id, mv_file, vehicle_type, body_number) values(:user_id, :mv_file, :vehicle_type, :body_number)";
        $insert = $pdo->prepare($query);
        $insert->bindParam(':user_id ', $user_id);
        $insert->bindParam(':mv_file', $mv_file);
        $insert->bindParam(':vehicle_type', $vehicle_type);
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
