<?php

require_once '../bridge/iot_connection.php';
$file = '../bridge/ip_addresses.txt';

// Use the last IP address to construct the NodeMCU URL
if ($lastIpAddress) {
    $dataToSend = "Hello NodeMCU";
    $nodeMcuUrl = "http://$lastIpAddress/?data=" . urlencode($dataToSend);

    // Sending data to NodeMCU
    $response = @file_get_contents($nodeMcuUrl);

    if ($response !== FALSE) {
        echo "Data sent to NodeMCU: " . htmlspecialchars($dataToSend);
    } else {
        echo "Error sending data to NodeMCU.";
    }
} else {
    echo "No IP address received.";
}
