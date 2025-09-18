<!-- Une page d’administration (admin.php) :
Cette page est accessible UNIQUEMENT pour l’utilisateur “admin”. Elle permet
de lister l’ensemble des informations des utilisateurs présents dans la base de
données. -->

<?php require_once "./managers/sessionmanager.php" ?>

<?php


if (!SessionManager::is_admin()) {
    ?>
    <div class="warning">This page is only available for the administrator</div>
    <div class="warning">Redirecting to home page</div>
    <?php
    header("refresh:5; url=./index.php");
    exit();
}

$ret = DbManager::getAllUsers();

if (!$ret['result']) { ?>
    <div class="warning"> ERROR: <?= $ret['error'] ?> </div>
    <?php
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet" />


    <title>Admin</title>
</head>

<body>
    <?php include "navbar.php"; ?>

    <table>
        <thead>
            <tr>
                <?php foreach ($ret['data'] as $row) { ?>
                    <?php foreach ($row as $key => $value) { ?>
                        <th> <?= $key ?> </th>
                    <?php }
                    break;
                } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ret['data'] as $row) { ?>
                <tr>
                    <?php foreach ($row as $cell) { ?>
                        <td><?= $cell ?></td>
                    <?php } ?>
                </tr>

            <?php } ?>
        </tbody>
    </table>
</body>

</html>