<?php

$dsn = 'mysql:host=localhost;dbname=rest_api';
    $username = 'root';
    $password = '';
    
    try {
        $db = new PDO($dsn, $username, $password);
        //echo "connected";
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }

    ?>