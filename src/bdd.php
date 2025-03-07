<?php

$config = require_once 'config.php';

function getDb($config)
{
    $host = $config['DB_HOST'];
    $dbname = $config['DB_NAME'];
    $user = $config['DB_USER'];
    $pass = $config['DB_PASS'];

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "La connexion a échoué : " . $e->getMessage();
        return null;
    }
}
