<?php
require_once "./managers/dbmanager.php";

session_start();
class SessionManager
{

    public static function is_logged()
    {
        return isset($_SESSION["id"]);
    }

    public static function is_admin()
    {
        return isset($_SESSION["login"]) && $_SESSION["login"] === "admin";
    }

    public static function login(string $login, string $password)
    {
        $login = trim($login);
        $password = trim($password);
        $ret = DbManager::connectUser($login, $password);

        if ($ret['result']) {
            session_start();
            $_SESSION['id'] = $ret['data']['id'];
            $_SESSION['login'] = $ret['data']['login'];
            $_SESSION['prenom'] = $ret['data']['prenom'];
            header("Location: ./index.php");
            exit();
        }
        return $ret;
    }

    public static function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ./connexion.php");
        exit();
    }



}


?>