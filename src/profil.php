<?php
session_start();
require_once('bdd.php');
if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $connexion = getDb();
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $req = $connexion->prepare($sql);
    $req->execute();
    $user = $req->fetch();
    if(empty($user)) {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}
?>
<html>
<head>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Megacasting - Profil</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Megacasting</a>
    <div class="ml-auto">
        <a class="nav-link text-danger" href="logout.php">Déconnexion</a>
    </div>
</nav>
<div class="container">
    <h2>Bienvenue : <?= $user['username'] ?></h2>
    <h3>Vos informations :</h3>
    <span>Email : <?= $user['email'] ?></span>
    <a href="deleteAccount.php?id=<?= $user['id'] ?>">Supprimer le compte</a>
</div>
</body>
</html>