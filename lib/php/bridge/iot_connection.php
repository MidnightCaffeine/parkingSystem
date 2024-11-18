<?php
session_start();
require_once '../database_handler/connection.php';
$file = 'ip_addresses.txt';


// Check if the file exists and is readable
$lastIpAddress = '';
if (file_exists($file) && is_readable($file)) {
    // Get the last line (IP address) from the file
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines) {
        $lastIpAddress = trim(end($lines));
        echo "Latest IP Address: " . htmlspecialchars($lastIpAddress) . "<br>";
    } else {
        echo "No IP addresses found in the file.<br>";
    }
} else {
    echo "Error: Unable to read the IP addresses file.<br>";
}

// Only update the file if a new IP address is provided in the GET request
if (isset($_GET['ip']) && !empty($_GET['ip'])) {
    $newIpAddress = $_GET['ip'];

    // Validate the IP address
    if (filter_var($newIpAddress, FILTER_VALIDATE_IP)) {
        echo "Received IP Address: " . htmlspecialchars($newIpAddress) . "<br>";
        // Save the new IP address by overwriting the file
        file_put_contents($file, $newIpAddress . PHP_EOL, LOCK_EX);
        $lastIpAddress = $newIpAddress;
    } else {
        echo "Error: Invalid IP address.<br>";
    }
}

// Use the last IP address to construct the NodeMCU URL
if (isset($_POST['qr_data'])) {
    if ($lastIpAddress) {

        $dataToSend = '';
        $qr_data = $_POST['qr_data'];
        $user_id = $_SESSION['user_id'];
        $today = date('Y-m-d');
        $mv = $_SESSION['mv_file'];
        $timezone = new DateTimeZone('Asia/Manila');  // Change to the timezone you need
        $date = new DateTime('now', $timezone);

        // Get the timestamp (number of seconds since Unix epoch)
        $timestamp_now = $date->getTimestamp();
        $now = date('Y-m-d H:i:s', $timestamp_now);


        switch ($_SESSION['vehicle_type']) {
            case 'Car':
                $vehicle_type = 1;
                break;
            case 'Tricycle':
                $vehicle_type = 2;
                break;
            case 'Motorcycle':
                $vehicle_type = 3;
                break;
        }

        $select = $pdo->prepare("SELECT * FROM system_data WHERE data_value = :qr_data LIMIT 1");
        $select->bindParam(':qr_data', $qr_data);
        $select->execute();
        if ($select->rowCount() > 0) {
            $result = $select->fetch(PDO::FETCH_ASSOC);

            // Check if there's already an active log for today (time_out IS NULL)
            $select_parking = $pdo->prepare("SELECT * FROM parking_log WHERE parking_date = :today AND user_id = :user_id AND time_out IS NULL");
            $select_parking->bindParam(':today', $today);
            $select_parking->bindParam(':user_id', $user_id);
            $select_parking->execute();

            // If there's already an active session for today, prevent logging in again
            if ($select_parking->rowCount() > 0) {
                echo "You already have an active session. Please log out first before logging in again.<br>";
                return; // Stop the execution here if there's an active session
            }

            // If no active session exists, proceed to insert a new login record
            if ($result['system_function'] == 'login_qr') {
                // Insert a new log for the login action
                $insert_parking = $pdo->prepare("INSERT INTO parking_log(user_id, user_mv_file, username, parking_date, vehicle_type) 
                    VALUES(:id, :mv, :user, :today, :vehicle_type)");
                $insert_parking->bindParam(':id', $user_id);
                $insert_parking->bindParam(':mv', $mv);
                $insert_parking->bindParam(':user', $_SESSION['user_name']);
                $insert_parking->bindParam(':today', $today);
                $insert_parking->bindParam(':vehicle_type', $vehicle_type);

                try {
                    $insert_parking->execute();
                    $dataToSend = 'Login';
                } catch (PDOException $e) {
                    echo "Error inserting data: " . $e->getMessage() . "<br>";
                }
            }

            // Handle logout logic
            if ($result['system_function'] == 'logout_qr') {
                // Check if an active parking log exists to log out
                $select_parking = $pdo->prepare("SELECT * FROM parking_log WHERE parking_date = :today AND user_id = :user_id AND time_out IS NULL");
                $select_parking->bindParam(':today', $today);
                $select_parking->bindParam(':user_id', $user_id);
                $select_parking->execute();

                if ($select_parking->rowCount() > 0) {
                    // Update the time_out field to mark logout time
                    $update_parking = $pdo->prepare("UPDATE parking_log SET time_out = :time_out WHERE user_id = :user_id AND parking_date = :today AND time_out IS NULL");
                    $update_parking->bindParam(':time_out', $now);
                    $update_parking->bindParam(':user_id', $user_id);
                    $update_parking->bindParam(':today', $today);

                    try {
                        $update_parking->execute();
                        echo "User logged out successfully.<br>";
                        $dataToSend = 'Logout';
                    } catch (PDOException $e) {
                        echo "Error updating log: " . $e->getMessage() . "<br>";
                    }

                    
                } else {
                    // If there's no active parking log, prevent updating logout
                    echo "No active parking log found for today. You cannot log out.<br>";
                }
            }

            // Construct the NodeMCU URL
            $nodeMcuUrl = "http://$lastIpAddress/?data=" . urlencode($dataToSend);

            // Sending data to NodeMCU
            $response = @file_get_contents($nodeMcuUrl);

            // Optionally handle the response from NodeMCU
            if ($response === FALSE) {
                echo "Error communicating with NodeMCU.<br>";
            }
        }
    } else {
        echo "Node MCU Hardware is not yet set up.<br>";
    }
}
?>