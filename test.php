<?php
session_start();

if (!empty($_SESSION)) {
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
} else {
    echo "No session variables are set.";
}