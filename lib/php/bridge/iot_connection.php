<?php

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

    // Display the received IP address
    echo "Received IP Address: " . htmlspecialchars($newIpAddress) . "<br>";

    // Save the new IP address by overwriting the file
    file_put_contents($file, $newIpAddress . PHP_EOL, LOCK_EX);

    // Use the new IP address as the last known IP for further actions
    $lastIpAddress = $newIpAddress;
}

// Use the last IP address to construct the NodeMCU URL
if (isset($_POST['qr_data'])) {
    if ($lastIpAddress) {
        $qr_data = $_POST['qr_data'];
        $user_id = $_SESSION['user_id'];
        $today = date('Y-m-d');
        $mv = $_SESSION['mv_file'];
        $timezone = new DateTimeZone('Asia/Manila');  // Change to the timezone you need
        $date = new DateTime('now', $timezone);

        // Get the timestamp (number of seconds since Unix epoch)
        $timestamp_now = $date->getTimestamp();

        $select = $pdo->prepare("SELECT * FROM system_data WHERE data_value= :qr_data LIMIT 1");
        $select->bindParam(':qr_data', $qr_data);
        $select->execute();
        if ($select->rowCount() > 0) {
            $result = $select->fetch(PDO::FETCH_ASSOC);

            $select_parking = $pdo->prepare("SELECT * FROM parking_log WHERE parking_date= :today AND user_id = :user_id");
            $select_parking->bindParam(':today', $today);
            $select_parking->bindParam(':user_id', $user_id);
            if ($select_parking->execute()) {
                $parking_result = $select_parking->fetch(PDO::FETCH_ASSOC);
                if ($result['system_function'] == 'login_qr' && $select_parking->rowCount() > 0 && $parking_result['time_out'] != '') {
                    $insert_parking = $pdo->prepare("INSERT INTO parking_log(user_id, user_mv_file, time_in, username, parking_date,vehicle_type) values(:id, :mv, :timestamp_now, :user, :today, :vehicle_type)");
                    $insert_parking->bindParam(':id', $user_id);
                    $insert_parking->bindParam(':mv', $mv);
                    $insert_parking->bindParam(':timestamp_now', $timestamp_now);
                    $insert_parking->bindParam(':user', $_SESSION['user_name']);
                    $insert_parking->bindParam(':today', $today);
                    $insert_parking->bindParam(':vehicle_type', $_SESSION['vehicle_type']);
                    $insert_parking->execute();
                    $dataToSend = 'Login';
                } elseif ($result['system_function'] == 'logout_qr' && $select_parking->rowCount() > 0 && $parking_result['time_out'] == '') {
                    $dataToSend = 'Logout';
                }
            }



            $nodeMcuUrl = "http://$lastIpAddress/?data=" . urlencode($dataToSend);

            // Sending data to NodeMCU
            $response = @file_get_contents($nodeMcuUrl);

        }
    } else {
        echo "Node MCU Hardware is not yet setup";
    }

}

