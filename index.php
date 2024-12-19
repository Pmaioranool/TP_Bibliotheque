<?php

session_start();

require_once 'Models/Livre.php';
require_once 'Models/User.php';
require_once 'Models/Favoris.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SESSION['email'])) {
    $favoris = htmlspecialchars($_POST['favoris']);

    $userModel = new User(null, null, $_SESSION['email']);
    $id_user = $userModel->getId();

    if ($favoris == 1) {
        $id_livre = htmlspecialchars($_POST['id']);
        $favModel = new Favoris(null, $id_livre, $id_user['id_user']);
        $favModel->addFavoris();

    } else {

        $titre = htmlspecialchars($_POST['titre']);
        $auteur = htmlspecialchars($_POST['auteur']);

        if (empty($titre) || empty($auteur)) {
            $error = "Veuillez remplir tous les champs";
            echo $erreur;
        } else {
            $addLivre = new Livre(null, $titre, $auteur);
            $addLivre->addBook($id_user['id_user']);
            $success = '<p class="success">votre livre a bien été ajouté</p>';
            echo $success;
        }
    }
}

$livreModel = new Livre();
$livres = $livreModel->getAllBook();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav>
        <a href="php/register.php">inscription</a>
        <br>
        <a href="php/login.php">connexion</a>
        <br>
        <a href="php/dashboard.php">dashboard</a>
    </nav>
    <h1>Notre catalogue</h1>
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
                <form action="index.php" method="post">
                    <input type="hidden" name="favoris" value="1">
                    <input type="hidden" name="id" value="<?= $livre['id_livre'] ?>">
                    <input type="submit" value="ajouter en favoris">
                </form>
            </li>
        <?php } ?>
    </ul>
    <h1>Ajouter un livre</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="favoris" value="0">
        <input type="text" name="titre" id="titre" placeholder="titre du livre" required><br>
        <input type="text" name="auteur" id="auteur" placeholder="auteur du livre" required><br>
        <input type="submit" value="ajouter">
    </form>
</body>

</html>