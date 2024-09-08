<?php
require_once 'lib/php/database_handler/connection.php';
session_start();
date_default_timezone_set('Asia/Manila');

$action = 'Logged out on the system';
$insertLog = $pdo->prepare("INSERT INTO user_logs(user_id, username, action) values(:id, :user, :action)");

$insertLog->bindParam(':id', $_SESSION['user_id']);
$insertLog->bindParam(':user', $_SESSION['user_name']);
$insertLog->bindParam(':action', $action);
$insertLog->execute();


session_unset();
session_write_close();
session_destroy();

header('location: ./index.php');
