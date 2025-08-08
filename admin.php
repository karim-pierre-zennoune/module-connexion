<!-- Une page d’administration (admin.php) :
Cette page est accessible UNIQUEMENT pour l’utilisateur “admin”. Elle permet
de lister l’ensemble des informations des utilisateurs présents dans la base de
données. -->


<?php require_once "./dbmanager.php" ?>

<?php
session_start();
if (!isset($_SESSION["lodin"]) && $_SESSION["login"] !== "admin") {
    ?>
    <div class="warning">This page is only available for the administrator</div>
    <div class="warning">Redirecting to connexion page</div>
    <?php
    header("refresh:5; url=./connexion.php");
    exit();
}


$ret = DbManager::getFullDbDump();

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