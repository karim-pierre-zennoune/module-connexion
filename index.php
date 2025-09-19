<!-- Une page d’accueil qui présente votre site (index.php) -->



<!-- Une page permettant de modifier son profil (profil.php) :
Cette page possède un formulaire permettant à l’utilisateur de modifier ses
informations. Ce formulaire est par défaut pré-rempli avec les informations qui
sont actuellement stockées en base de données. -->


<?php require_once "./managers/sessionmanager.php" ?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet" />


    <title>Accueil</title>
</head>

<body>

    <?php include "navbar.php"; ?>


    <?php
    if (SessionManager::is_logged() && isset($_SESSION["prenom"])) { ?>

        <p class="warning">Welcome <?= $_SESSION["prenom"] ?> </p>

        <?php
    }
    ?>
    <p>Site du projet Module Connexion de LaPlateforme_</p>


</body>

</html>