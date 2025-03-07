<?php
session_start();
require_once('bdd.php');

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $connexion = getDb();
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $req = $connexion->prepare($sql);
    $req->execute();
    $user = $req->fetch();

    if(!empty($user)){
        $_SESSION['user'] = $user;
        header('Location: profil.php?id='.$user['id']);
    }
}
?>
<html>
<head>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Megacasting - Connexion</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
</head>
<body>
<div class="container">
    <h1>Connexion :</h1>
    <form action="/" method="POST">
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Connexion</button>
        <a href="register.php">S'inscrire</a>
    </form>
</div>
</body>
</html>