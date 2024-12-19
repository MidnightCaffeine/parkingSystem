<?php
session_start();
require_once '../database_handler/connection.php';

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    exit;
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// SQL query to fetch data
$sql = "SELECT * FROM vehicles WHERE user_id = " . $_SESSION['user_id'];  // Modify with your table name
$stmt = $pdo->query($sql);

// Check if there are rows returned
if ($stmt->rowCount() > 0) {
    // Loop through the result and create <option> tags
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        switch ($row["vehicle_type"]) {
            case 1:
                $vehicle_type = 'Car';
                break;
            case 2:
                $vehicle_type = 'Tricycle';
                break;
            case 3:
                $vehicle_type = 'Motorcycle';
                break;
        }
        echo "<option value='" . $row['vehicle_id'] . "'>" . $vehicle_type . " (MV File: " . $row['mv_file'] . ")" . "</option>";
    }
} else {
    echo "<option value=''>No categories available</option>";
}