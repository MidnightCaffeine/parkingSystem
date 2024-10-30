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
        $dataToSend = $_POST['qr_data'];

        $select = $pdo->prepare("SELECT data_value FROM system_data where data_value= :dataToSend");
        $select->bindParam(':dataToSend', $dataToSend);
        $select->execute();
        if ($select->rowCount() > 0) {
            $nodeMcuUrl = "http://$lastIpAddress/?data=" . urlencode($dataToSend);

            // Sending data to NodeMCU
            $response = @file_get_contents($nodeMcuUrl);

        }
    } else {
        echo "Node MCU Hardware is not yet setup";
    }

}

