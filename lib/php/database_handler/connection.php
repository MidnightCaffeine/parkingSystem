<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=parking_system', 'root', '');
} catch (PDOException $f) {

    echo $f->getmessage();
}