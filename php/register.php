<?php

require_once('../Models/User.php');


session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['MDP']);

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs";
    } else {
        $user = new User(null, $username, $email, $password);
        if ($user->register()) {
            header('Location: login.php');
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../style.css">

</head>

<body>
    <nav>
        <a href="../index.php">accueil</a>
    </nav>
    <h1>Inscription</h1>
    <form action="register.php" method="post">
        <input type="text" name="nom" id="nom" placeholder="votre nom" required><br>
        <input type="text" name="email" id="email" placeholder="votre email" required><br>
        <input type="text" name="MDP" id="MDP" placeholder="votre mot de passe" required><br>
        <input type="submit" value="s'inscrire">
    </form>
</body>

</html>