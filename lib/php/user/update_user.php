<?php
require_once '../database_handler/connection.php';
session_start();


if (isset($_POST['edit_info'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $department = $_POST['department'];
    $year_group = $_POST['year_group'];
    $section = $_POST['section'];
    $mv_file = $_POST['mv_file'];
    $body_number = $_POST['body_number'];
    $vehicle_type = $_POST['vehicle_type'];
    $user_id = $_POST['user_id'];


    $update = $pdo->prepare("UPDATE users SET firstname = :firstname, lastname = :lastname, middlename = :middlename , department = :department , year_group = :year_group, section = :section, mv_file = :mv_file, body_number = :body_number, vehicle_type = :vehicle_type WHERE user_id = :user_id");

    $update->bindparam('firstname', $firstname);
    $update->bindparam('lastname', $lastname);
    $update->bindparam('middlename', $middlename);
    $update->bindparam('department', $department);
    $update->bindparam('year_group', $year_group);
    $update->bindparam('section', $section);
    $update->bindparam('mv_file', $mv_file);
    $update->bindparam('body_number', $body_number);
    $update->bindparam('vehicle_type', $vehicle_type);
    $update->bindparam('user_id', $user_id);
    $update->execute();

}

if (isset($_POST['approve'])) {
    $user_id = $_POST['user_id'];

    $update = $pdo->prepare("UPDATE users SET user_status = 1 WHERE user_id = :user_id");
    $update->bindparam('user_id', $user_id);
    $update->execute();
}