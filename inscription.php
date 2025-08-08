<!-- Une page contenant un formulaire d’inscription (inscription.php) :
Le formulaire doit contenir l’ensemble des champs présents dans la table
“utilisateurs” (sauf “id”) + une confirmation de mot de passe. Dès qu’un
utilisateur remplit ce formulaire, les données sont insérées dans la base de
données et l’utilisateur est redirigé vers la page de connexion. -->

<?php require_once "./dbmanager.php" ?>

<?php

$form_ready = true;
if (isset($_POST["submit"]) && $_POST["submit"] == "Envoyer") {
    $field_list = ["login", "prenom", "nom", "password", "password-confirm"];
    $error_messages = [];

    foreach ($field_list as $field) {
        if (!(isset($_POST[$field]) && !empty(trim($_POST[$field])))) {
            $form_ready = false;
            $error_messages[] = "field " . $field . " cannot be empty.<br/>";
        }
    }

    if (
        !(isset($_POST["password"]) && isset($_POST["password-confirm"])
            && trim($_POST["password"]) === trim($_POST["password-confirm"]))
    ) {
        $form_ready = false;
        $error_messages[] = "passwords don't match.<br/>";
    }

    if ($form_ready) {
        // $db = new DbManager();
        $err = DbManager::addUser(
            htmlspecialchars($_POST["login"]),
            htmlspecialchars($_POST["prenom"]),
            htmlspecialchars($_POST["nom"]),
            htmlspecialchars($_POST["password"])
        );
        if ($err !== "") {
            $form_ready = false;
            $error_messages[] = $err;
        } else {

            header("Location: ./connexion.php");
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
    <link href="./style.css" rel="stylesheet" />

    <title>Inscription</title>
</head>

<body>
    <?php include "navbar.php"; ?>

    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label for="form-login" hidden>login</label>
                <div><input id="form-login" type="text" name="login" placeholder="login" autofocus></div>
            </div>
            <div>
                <label for="form-prenom" hidden>prenom</label>
                <div><input id="form-prenom" type="text" name="prenom" placeholder="prenom">
                </div>
            </div>
            <div>
                <label for="form-nom" hidden>nom</label>
                <div><input id="form-nom" type="text" name="nom" placeholder="nom"></div>
            </div>
            <div>
                <label for="form-password" hidden>password</label>
                <div><input id="form-password" type="text" name="password" placeholder="password">
                </div>
            </div>
            <div>
                <label for="form-password-confirm" hidden>confirm password</label>
                <div><input id="form-password-confirm" type="text" name="password-confirm"
                        placeholder="confirm password">
                </div>
            </div>
            <input type="submit" name="submit">
        </form>
    </div>


    <div>

        <?php
        if (!$form_ready) {
            foreach ($error_messages as $err) { ?>
                <p> <?= $err ?> </p> <?php
            }
        }
        ?>


    </div>


</body>

</html>