<!-- Une page permettant de modifier son profil (profil.php) :
Cette page possède un formulaire permettant à l’utilisateur de modifier ses
informations. Ce formulaire est par défaut pré-rempli avec les informations qui
sont actuellement stockées en base de données. -->

<?php require_once "./managers/sessionmanager.php" ?>
<?php require_once "./utils.php" ?>

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
    $field_list = ["form-old-password", "form-new-password", "form-confirm-password"];
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

    if (trim($_POST["form-new-password"]) !== trim($_POST["form-confirm-password"])) {
        $form_ready = false;
        $error_messages[] = "passwords don't match.<br/>";
    }

    if ($form_ready) {
        $ret = DbManager::updateUserPassword(
            $_POST["form-old-password"],
            $_POST["form-new-password"],
            $_SESSION["id"],
        );
        $form_ready = false;
        $error_messages[] = $ret['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet" />


    <title>Change Password</title>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="form-wrapper">
        <div class="form">


            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <div>
                    <label for="form-old-password" hidden>password</label>
                    <div><input id="form-old-password" type="text" name="form-old-password" placeholder="password"
                            autofocus>
                    </div>
                </div>


                <div>
                    <label for="form-new-password" hidden>new password</label>
                    <div><input id="form-new-password" type="text" name="form-new-password" placeholder="new password">
                    </div>
                </div>
                <div>
                    <label for="form-confirm-password" hidden>confirm new password</label>
                    <div><input id="form-confirm-password" type="text" name="form-confirm-password"
                            placeholder="confirm new password"></div>
                </div>
                <input type="submit" name="submit">
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



<!-- <div class="form">

      <div class="input-container ic1">
        <input id="firstname" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="firstname" class="placeholder">First name</label>
      </div>

      <div class="input-container ic2">
        <input id="lastname" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="lastname" class="placeholder">Last name</label>
      </div>

      <div class="input-container ic2">
        <input id="email" class="input" type="text" placeholder=" " />
        <div class="cut cut-short"></div>
        <label for="email" class="placeholder">Email</>
      </div>
      <button type="text" class="submit">submit</button>
    </div> -->




<!-- <div class="form-wrapper">

        <div class="form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label for="form-old-password" hidden>password</label>
                    <div><input id="form-old-password" type="text" name="form-old-password" placeholder="password"
                            autofocus>
                    </div>
                </div>
                <div>
                    <label for="form-new-password" hidden>new password</label>
                    <div><input id="form-new-password" type="text" name="form-new-password" placeholder="new password">
                    </div>
                </div>
                <div>
                    <label for="form-confirm-password" hidden>confirm new password</label>
                    <div><input id="form-confirm-password" type="text" name="form-confirm-password"
                            placeholder="confirm new password"></div>
                </div>
                <input type="submit" name="submit">
            </form>
        </div>

    </div> -->