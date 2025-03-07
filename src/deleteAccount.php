<?php
session_start();
require_once('bdd.php');
$config = require_once 'config.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $connexion = getDb($config);
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $req = $connexion->prepare($sql);
    $req->execute();
    $user = $req->fetch();
    if (empty($user)) {
        echo "Il n'y a pas d'utilisateur avec cet id";
    } else {
        $sql = "DELETE FROM users WHERE id = '$id'";
        $req = $connexion->prepare($sql);
        $req->execute();
        session_destroy();
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}
