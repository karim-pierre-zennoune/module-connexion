<?php require_once "./managers/sessionmanager.php" ?>


<?php

$filename = pathinfo($_SERVER['PHP_SELF'])['filename'];

if (isset($_POST["action"]) && $_POST["action"] === "Logout") {
    SessionManager::logout();
}

if (SessionManager::is_logged()) { ?>
    <ul class="topnav">
        <li><a class="<?= $filename === "index" ? "active" : "" ?>" href="./index.php">Home</a></li>
        <li><a class="<?= $filename === "profil" ? "active" : "" ?>" href="./profil.php">Profile</a></li>
        <li><a class="<?= $filename === "changepassword" ? "active" : "" ?>" href="./changepassword.php">ChangePW</a></li>
        <?php if (SessionManager::is_admin()) { ?>
            <li><a class="<?= $filename === "admin" ? "active" : "" ?>" href="./admin.php">Admin</a></li>
        <?php } ?>
        <li class="right">
            <form method="post">
                <input class="logoutbtn" type="submit" name="action" class="button" value="Logout" />
            </form>

        </li>
    </ul>

<?php } else { ?>
    <ul class="topnav">
        <li><a class="<?= $filename === "index" ? "active" : "" ?>" href="./index.php">Home</a></li>
        <li><a class="<?= $filename === "inscription" ? "active" : "" ?>" href="./inscription.php">Register</a></li>
        <li class="right"><a class="<?= $filename === "connexion" ? "active" : "" ?>" href="./connexion.php">Login</a></li>
    </ul>

<?php } ?>