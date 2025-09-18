<!-- Une page contenant un formulaire de connexion (connexion.php) :
Le formulaire doit avoir deux inputs : “login” et “password”. Lorsque le formulaire
est validé, s’il existe un utilisateur en bdd correspondant à ces informations, alors

l’utilisateur est considéré comme connecté et une (ou plusieurs) variables de
session sont créées. -->

<?php require_once "./managers/sessionmanager.php" ?>

<?php

if (SessionManager::is_logged()) {
    ?>
    <div class="warning">You are already logged in</div>
    <div class="warning">Redirecting to home page</div>
    <?php
    header("refresh:5; url=./index.php");
    exit();
}

$form_ready = true;
if (isset($_POST["submit"]) && $_POST["submit"] == "Envoyer") {
    $field_list = ["login", "password"];
    $error_messages = [];

    foreach ($field_list as $field) {
        if (!(isset($_POST[$field]) && !empty(trim($_POST[$field])))) {
            $form_ready = false;
            $error_messages[] = "field " . $field . " cannot be empty.<br/>";
        }
    }

    if ($form_ready) {
        $ret = SessionManager::login($_POST["login"], $_POST["password"]);
        if (!$ret["result"]) {
            $form_ready = false;
            $error_messages[] = $ret['error'];
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
    <title>Connexion</title>
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
                <label for="form-password" hidden>password</label>
                <div><input id="form-password" type="text" name="password" placeholder="password">
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