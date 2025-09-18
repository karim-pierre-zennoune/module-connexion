<!-- Une page permettant de modifier son profil (profil.php) :
Cette page possède un formulaire permettant à l’utilisateur de modifier ses
informations. Ce formulaire est par défaut pré-rempli avec les informations qui
sont actuellement stockées en base de données. -->


<?php require_once "./managers/sessionmanager.php" ?>

<?php
if (!SessionManager::is_logged()) {
    ?>
    <div class="warning">You need to be logged in to view this page</div>
    <div class="warning">Redirecting to connexion page</div>
    <?php
    header("refresh:5; url=./connexion.php");
    exit();
}

$form_ready = true;
if (isset($_POST["submit"]) && $_POST["submit"] == "Envoyer") {
    $field_list = ["login", "prenom", "nom"];
    $error_messages = [];

    foreach ($field_list as $field) {
        if (!(isset($_POST[$field]) && !empty(trim($_POST[$field])))) {
            $form_ready = false;
            $error_messages[] = "field " . $field . " cannot be empty.<br/>";
        }
    }

    if ($form_ready) {
        DbManager::updateUserInfos(
            $_POST["login"],
            $_POST["prenom"],
            $_POST["nom"],
            $_SESSION["id"],

        );
        $_SESSION["login"] = $_POST["login"];
        $_SESSION["prenom"] = $_POST["prenom"];
    }
}

$form_prefill = DbManager::getUserInfos($_SESSION["id"]);
if (!$form_prefill["result"]) {
    die();
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
                <div><input id="form-login" type="text" name="login" placeholder="login"
                        value="<?= $form_prefill["data"]["login"] ?>" autofocus></div>
            </div>
            <div>
                <label for="form-prenom" hidden>prenom</label>
                <div><input id="form-prenom" type="text" name="prenom" value="<?= $form_prefill["data"]["prenom"] ?>"
                        placeholder="prenom">
                </div>
            </div>
            <div>
                <label for="form-nom" hidden>nom</label>
                <div><input id="form-nom" type="text" name="nom" value="<?= $form_prefill["data"]["nom"] ?>"
                        placeholder="nom"></div>
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