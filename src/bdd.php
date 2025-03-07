<?php
function getDb()
{
    try {
        $conn = new PDO("mysql:host=db;dbname=app_db", 'app_user', 'Not24get');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "La connexion a échoué " . $e->getMessage();
        return null;
    }
}
?>