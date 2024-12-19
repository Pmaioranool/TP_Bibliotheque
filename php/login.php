<?php

require_once('../Models/User.php');


session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['MDP']);

    if (empty($email) || empty($password)) {
        $erreur = "Veuillez remplir tous les champs";
    } else {
        $user = new User(null, null, $email, $password);
        $loggedUser = $user->login();
        if ($loggedUser) {
            $_SESSION['email'] = $loggedUser['email'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Mot de passe incorrect";
            echo $error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <link rel="stylesheet" href="../style.css">

</head>

<body>
    <nav>
        <a href="../index">accueil</a>
    </nav>
    <h1>connexion</h1>
    <form action="login.php" method="post">
        <input type="text" name="email" id="email" placeholder="votre email" required><br>
        <input type="text" name="MDP" id="MDP" placeholder="votre mot de passe" required><br>
        <input type="submit" value="se connecter">
    </form>

</body>

</html>