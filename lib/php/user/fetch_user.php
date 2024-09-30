<?php
session_start();
include_once '../database_handler/connection.php';


if (isset($_POST['user_id'])) {
    $output = array();
    $select = $pdo->prepare(
        "SELECT * FROM users WHERE user_id = '".$_POST["user_id"]."' LIMIT 1"
    );
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
        $output["firstname"] = $row["firstname"];
        $output["lastname"] = $row["lastname"];
        $output["middlename"] = $row["middlename"];
        $output["department"] = $row["department"];
        $output["year_group"] = $row["year_group"];
        $output["section"] = $row["section"];
        $output["mv_file"] = $row["mv_file"];
        $output["body_number"] = $row["body_number"];
        $output["vehicle_type"] = $row["vehicle_type"];
        $output["user_name"] = $row["firstname"] . ' '. $row["lastname"];
        $output["name"] = $row["firstname"] . ' ' . $row["middlename"] . ' ' . $row["lastname"];
        $output["year_section"] = $row["year_group"] . ' Section ' . $row["section"];

    }
    echo json_encode($output);
}
