<!-- Une page contenant un formulaire de connexion (connexion.php) :
Le formulaire doit avoir deux inputs : “login” et “password”. Lorsque le formulaire
est validé, s’il existe un utilisateur en bdd correspondant à ces informations, alors

l’utilisateur est considéré comme connecté et une (ou plusieurs) variables de
session sont créées. -->

<?php require_once "./managers/sessionmanager.php" ?>
<?php require_once "./utils.php" ?>

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

    if (!verify_csrf_token($_POST['csrf_token'])) {
        $form_ready = false;
        $error_messages[] = "Token CSRF invalide";
    }

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

    <div class="errors">
        <?php
        if (!$form_ready) {
            foreach ($error_messages as $err) { ?>
                <p> <?= $err ?> </p> <?php
            }
        }
        ?>
    </div>
    <div class="form-wrapper">
        <div class="form">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <div class="input-container ic1">
                    <input class="input" id="form-login" type="text" name="login" placeholder=" "
                        autocomplete="username" autofocus required>
                    <div class="cut"></div>
                    <label class="placeholder" for="form-login">Login</label>
                </div>
                <div class="input-container ic2">
                    <input class="input" id="form-password" type="password" name="password" placeholder=" "
                        autocomplete="current-password" title="Password" required>
                    <div class="cut">
                    </div>
                    <label class="placeholder" for="form-password">Password</label>
                </div>
                <button type="submit" class="submit" name="submit" value="Envoyer">Submit</button>
            </form>
        </div>
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