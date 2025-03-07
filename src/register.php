<?php
session_start();
require_once('bdd.php');

$error = [];

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Vérification de la validité de l'adresse e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Adresse e-mail invalide.";
    }

    // Vérification de la force du mot de passe
    $password_pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    if (!preg_match($password_pattern, $password)) {
        $error[] = "Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.";
    }

    if ($password !== $password_confirm) {
        $error[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($error)) {
        $connexion = getDb();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute();
        header('Location: index.php');
        exit();
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Megacasting - Inscription</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Inscription :</h1>
    <?php if (!empty($error)) { ?>
        <?php foreach ($error as $e) { ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($e) ?>
            </div>
        <?php } ?>
    <?php } ?>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirmer le mot de passe :</label>
            <input type="password" class="form-control" name="password_confirm" required>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
        <a href="index.php">Se connecter</a>
    </form>
</div>
</body>
</html>