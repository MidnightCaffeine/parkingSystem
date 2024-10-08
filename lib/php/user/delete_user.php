<?php
session_start();
include_once '../database_handler/connection.php';

if (isset($_POST["user_id"])) {
    $statement = $pdo->prepare(
        "DELETE FROM users WHERE user_id = :id"
    );
    $result = $statement->execute(
        array(':id' => $_POST["user_id"])
    );

    $action = 'Delete user ' . $_POST["user_id"] . ' on the user list';
    $insertLog = $pdo->prepare("INSERT INTO user_logs(user_id, username, action) values(:id, :user, :action)");

    $insertLog->bindParam(':id', $user_id);
    $insertLog->bindParam(':user', $_SESSION['user_name']);
    $insertLog->bindParam(':action', $action);
    $insertLog->execute();
}
