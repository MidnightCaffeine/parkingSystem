<?php
session_start();
include_once '../database_handler/connection.php';
date_default_timezone_set('Asia/Manila'); // Set timezone to Manila

if (isset($_POST['parking_id'])) {
    $output = array();
    $select = $pdo->prepare(
        "SELECT * FROM system_data WHERE system_id = '" . $_POST["parking_id"] . "' LIMIT 1"
    );
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
        $output["slot_count"] = $row["data_value"];
        $output["description"] = $row["description"];

    }
    echo json_encode($output);
}
if (isset($_POST['fetch'])) {
    $output = array();
    $select = $pdo->prepare(
        "SELECT * FROM system_data"
    );
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {

        switch ($row["system_id"]) {
            case 3:
                $output["motorcycle_slot"] = $row["data_value"];
                break;
            case 4:
                $output["car_slot"] = $row["data_value"];
                break;
            case 5:
                $output["tricycle_slot"] = $row["data_value"];
                break;
        }


    }
    echo json_encode($output);
}

if (isset($_POST['fetch_occupied'])) {

    $today = date('Y-m-d');


    $select = $pdo->prepare("SELECT * FROM parking_log WHERE time_out IS NULL AND vehicle_type= 1");
    // $select->bindParam(':today', $today);
    $select->execute();
    $output["car_slot_occupied"] = $select->rowCount();

    $select = $pdo->prepare("SELECT * FROM parking_log WHERE time_out IS NULL AND vehicle_type= 2");
    // $select->bindParam(':today', $today);
    $select->execute();
    $output["tricycle_slot_occupied"] = $select->rowCount();

    $select = $pdo->prepare("SELECT * FROM parking_log WHERE time_out IS NULL AND vehicle_type= 3");
    // $select->bindParam(':today', $today);
    $select->execute();
    $output["motor_slot_occupied"] = $select->rowCount();


    echo json_encode($output);
}


if (isset($_POST['slot_id'])) {

    $slot_id = $_POST['slot_id'];
    $slot = $_POST['slot'];

    $update = $pdo->prepare("UPDATE system_data SET data_value = :slot WHERE system_id = :slot_id");

    $update->bindparam('slot', $slot);
    $update->bindparam('slot_id', $slot_id);
    $update->execute();

    $output["success"] = "success";
    echo json_encode($output);
}