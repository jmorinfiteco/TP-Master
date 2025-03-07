<?php
session_start();
require_once('bdd.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $connexion = getDb();

    $sql = "SELECT * FROM users WHERE id = :id";
    $req = $connexion->prepare($sql);
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $user = $req->fetch();

    if (empty($user)) {
        header('Location: error.php?code=no_user');
        exit();
    } else {
        $sql = "DELETE FROM users WHERE id = :id";
        $req = $connexion->prepare($sql);
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();

        session_destroy();
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
