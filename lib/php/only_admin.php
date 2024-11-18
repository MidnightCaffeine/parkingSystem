<?php
if ($_SESSION['user_type'] != 'Administrator') {
    header("Location: error_404.php");
    exit(); 
}
