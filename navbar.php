<?php require_once "./sessionmanager.php" ?>


<?php


// var_dump(parse_url($_SERVER['PHP_SELF']));
// echo "<br/>";

// var_dump(pathinfo($_SERVER['PHP_SELF']));
$filename = pathinfo($_SERVER['PHP_SELF'])['filename'];
// echo "<br/>";
// echo basename(__FILE__, '.php');


if (isset($_SESSION["id"])) { ?>
    <ul class="topnav">
        <li><a class="<?= $filename === "index" ? "active" : "" ?>" href="./index.php">Home</a></li>
        <li><a class="<?= $filename === "profil" ? "active" : "" ?>" href="./profil.php">Profile</a></li>
        <li><a class="<?= $filename === "changepassword" ? "active" : "" ?>" href="./changepassword.php">ChangePW</a></li>
        <?php if (isset($_SESSION["login"]) && $_SESSION["login"] === "admin") { ?>
            <li><a class="<?= $filename === "admin" ? "active" : "" ?>" href="./admin.php">Admin</a></li>

        <?php } ?>


        <li class="right"><a href="./disconnect">Logout</a></li>
    </ul>

<?php } else { ?>
    <ul class="topnav">
        <li><a class="<?= $filename === "index" ? "active" : "" ?>" href="./index.php">Home</a></li>
        <li><a class="<?= $filename === "inscription" ? "active" : "" ?>" href="./inscription.php">Register</a></li>


        <li class="right"><a class="<?= $filename === "connexion" ? "active" : "" ?>" href="./connexion.php">Login</a></li>
    </ul>

<?php } ?>