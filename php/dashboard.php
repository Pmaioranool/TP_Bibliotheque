<?php
session_start();
require_once '../Models/User.php';
require_once '../Models/Livre.php';
require_once '../Models/Favoris.php';


if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: ../index.php');
    exit();
}

$userModel = new User(null, null, $_SESSION['email']);
$user = $userModel->getInfos();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $favoris = htmlspecialchars($_POST['favoris']);

    $userModel = new User(null, null, $_SESSION['email']);
    $id_user = $userModel->getId();

    if ($favoris == 1) {
        $id_favoris = htmlspecialchars($_POST['id']);
        $favModel = new Favoris($id_favoris);
        $favModel->removeFavoris();

    } else {

        $username = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['MDP']);
        $password2 = htmlspecialchars($_POST['MDP2']);

        if ($password != $password2 || empty($password)) {
            $erreur = 'mot de passe différents';
            echo $erreur;
        } else {
            $userModel2 = new User();
            $userModel2->updateInfos($username, $email, $password);
            session_destroy();
            header('Location: ../index.php');
            exit();
        }
    }
}


$favorisModel = new Favoris(null, null, $user['id_user']);
$livres = $favorisModel->getFavoris()
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <nav>
        <a href="../index.php">accueil</a>
        <br>
        <a href="logout.php">se déconnecter</a>
    </nav>
    <h1>bienvenue <?= $user['nom'] ?></h1>

    <h2>Mes favoris</h2>
    <ul id="livres"><?php
    foreach ($livres as $livre) { ?>
            <li>
                <h2><?= $livre['titre'] ?></h2>
                <p>fait par <?= $livre['auteur'] ?></p>
                <?php
                $userModel = new User();
                $userInfos = $userModel->getInfosByID($livre['id_user']);
                ?>
                <p>ajouter par <?= $userInfos['nom'] ?></p>
                <form action="dashboard.php" method="post">
                    <input type="hidden" name="favoris" value="1">
                    <input type="hidden" name="id" value="<?= $livre['id_favoris'] ?>">
                    <input type="submit" value="enlever en favoris">
                </form>
            </li>
        <?php } ?>
    </ul>

    <h2>modifier ses informations</h2>
    <form action="dashboard.php" method="post">
        <input type="hidden" name="favoris" value="0">
        <input type="text" name="nom" id="nom" placeholder="Votre" required value="<?= $user['nom'] ?>"><br>
        <input type="text" name="email" id="email" placeholder="Votre" required value="<?= $user['email'] ?>"><br>
        <input type="text" name="MDP" id="MDP" placeholder="Votre mot de passe" required><br>
        <input type="text" name="MDP2" id="MDP2" placeholder="vérifier votre mot de passe" required><br>
        <input type="submit" value="changer">
    </form>
</body>

</html>