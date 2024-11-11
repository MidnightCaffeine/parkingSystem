<?php
session_start();
require_once '../database_handler/connection.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}

if (isset($_POST['qr_data_login'])) {

    $data = $_POST['qr_data_login'];
    $data = trim($data);
    $data = strip_tags($data);
    $qr_data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $system_function = 'login_qr';
    $description = 'QR data to open entrance gate';

    $select = $pdo->prepare("SELECT * FROM system_data WHERE system_function= :system_function");
    $select->bindParam(':system_function', $system_function);
    $select->execute();
    if ($select->rowCount() > 0) {
        $update = $pdo->prepare("UPDATE system_data SET data_value = :qr_data WHERE system_function = :system_function");
        $update->bindparam('qr_data', $qr_data);
        $update->bindparam('system_function', $system_function);
        $update->execute();
    } else {
        $query = "INSERT into system_data(system_function, data_value, description) values(:email, :qr_data, :description)";
        $insert = $pdo->prepare($query);
        $insert->bindParam(':system_function', $system_function);
        $insert->bindParam(':qr_data', $qr_data);
        $insert->bindParam(':description', $description);
        $insert->execute();
    }

}
if (isset($_POST['qr_data_logout'])) {

    $data = $_POST['qr_data_logout'];
    $data = trim($data);
    $data = strip_tags($data);
    $qr_data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $system_function = 'logout_qr';
    $description = 'QR data to open exit gate';

    $select = $pdo->prepare("SELECT * FROM system_data WHERE system_function= :system_function");
    $select->bindParam(':system_function', $system_function);
    $select->execute();
    if ($select->rowCount() > 0) {
        $update = $pdo->prepare("UPDATE system_data SET data_value = :qr_data WHERE system_function = :system_function");
        $update->bindparam('qr_data', $qr_data);
        $update->bindparam('system_function', $system_function);
        $update->execute();
    } else {
        $query = "INSERT into system_data(system_function, data_value, description) values(:system_function, :qr_data, :description)";
        $insert = $pdo->prepare($query);
        $insert->bindParam(':system_function', $system_function);
        $insert->bindParam(':qr_data', $qr_data);
        $insert->bindParam(':description', $description);
        $insert->execute();
    }

}
