<?php
session_start();
require_once('bdd.php');

// Génération d'un token CSRF si inexistant
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['username'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['csrf_token']) 
    && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password === $password_confirm) {
        $connexion = getDb();
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        $connexion->exec($sql);
        header('Location: index.php');
        exit;
    } else {
        $error[] = "Les mots de passe ne correspondent pas";
    }
}
?>

<html>
<head>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Megacasting - Inscription</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" 
              integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" 
              crossorigin="anonymous">
    </head>
</head>
<body>
<div class="container">
    <h1>Inscription :</h1>
    <?php if (!empty($error)) { ?>
        <?php foreach ($error as $e) { ?>
            <div class="alert alert-danger">
                <?= $e ?>
            </div>
        <?php } ?>
    <?php } ?>
    <form action="register.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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
