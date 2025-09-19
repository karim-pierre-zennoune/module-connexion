<!-- Une page contenant un formulaire d’inscription (inscription.php) :
Le formulaire doit contenir l’ensemble des champs présents dans la table
“utilisateurs” (sauf “id”) + une confirmation de mot de passe. Dès qu’un
utilisateur remplit ce formulaire, les données sont insérées dans la base de
données et l’utilisateur est redirigé vers la page de connexion. -->

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
    $field_list = ["login", "prenom", "nom", "password", "password-confirm"];
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

    if (
        !(isset($_POST["password"]) && isset($_POST["password-confirm"])
            && trim($_POST["password"]) === trim($_POST["password-confirm"]))
    ) {
        $form_ready = false;
        $error_messages[] = "passwords don't match.<br/>";
    }

    if ($form_ready) {
        $ret = DbManager::addUser(
            htmlspecialchars($_POST["login"]),
            htmlspecialchars($_POST["prenom"]),
            htmlspecialchars($_POST["nom"]),
            htmlspecialchars($_POST["password"])
        );
        if (!$ret['result']) {
            $form_ready = false;
            $error_messages[] = $ret['error'];
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

    <div class="form-wrapper">
        <div class="form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">


                <div class="input-container ic1">
                    <input class="input" id="form-login" type="text" name="login" placeholder=" " title="Login"
                        autocomplete="username" autofocus required>
                    <div class="cut">
                    </div>
                    <label class="placeholder" for="form-login">Login</label>
                </div>


                <div class="input-container ic2">
                    <input class="input" id="form-prenom" type="text" name="prenom" placeholder=" " title="Prenom"
                        required>
                    <div class="cut">
                    </div>
                    <label class="placeholder" for="form-prenom">Prenom</label>
                </div>

                <div class="input-container ic2">
                    <input class="input" id="form-nom" type="text" name="nom" placeholder=" " title="Nom" required>
                    <div class="cut">
                    </div>
                    <label class="placeholder" for="form-nom">Nom</label>
                </div>

                <div class="input-container ic2">
                    <input class="input" id="form-password" type="password" name="password" placeholder=" "
                        title="Password" autocomplete="new-password" required>
                    <div class="cut">
                    </div>
                    <label class="placeholder" for="form-password">Password</label>
                </div>

                <div class="input-container ic2">
                    <input class="input" id="form-password-confirm" type="password" name="password-confirm"
                        placeholder=" " autocomplete="new-password" title="New Password" required>
                    <div class="cut">
                    </div>
                    <label class="placeholder" for="form-password-confirm">Confirm Password</label>
                </div>

                <button type="submit" class="submit" name="submit" value="Envoyer">Submit</button>
                <!-- <input type="submit" name="submit"> -->
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