<?php


class DbManager
{
    private static $pdo = null;

    public static function addUser($login, $prenom, $nom, $password)
    {
        if (self::$pdo === null) {
            self::connectToDb();
        }

        $sql = "SELECT id FROM utilisateurs WHERE login = :login";
        if ($stmt = self::$pdo->prepare($sql)) {
            $stmt->bindParam(":login", $login, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    return [
                        "result" => false,
                        "error" => "login already exists"
                    ];
                }
            } else {
                throw new Exception('Something went wrong');
            }
            unset($stmt);
        }

        $sql = "INSERT INTO utilisateurs (login, prenom, nom, password) VALUES (:login, :prenom, :nom, :password)";

        if ($stmt = self::$pdo->prepare($sql)) {
            $stmt->bindParam(":login", $login, PDO::PARAM_STR);
            $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
            $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                throw new Exception('Something went wrong');
            }
            unset($stmt);
        }

        return [
            "result" => true,
            "error" => ""
        ];
    }


    public static function passwordCheck($id, $password)
    {
        if (self::$pdo === null) {
            self::connectToDb();
        }

        $sql = "SELECT password FROM utilisateurs WHERE id = :id";
        if ($stmt = self::$pdo->prepare($sql)) {
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {

                        return password_verify($password, $row["password"]);
                        // if (password_verify($password, $row["password"])) {
                        //     return true;
                        // } else {
                        //     return false;
                        // }


                    }

                }

            }
        }
        unset($stmt);

    }

    public static function connectUser($login, $password)
    {
        if (self::$pdo === null) {
            self::connectToDb();
        }


        $sql = "SELECT id, login, password, prenom, nom FROM utilisateurs WHERE login = :login";
        if ($stmt = self::$pdo->prepare($sql)) {
            $stmt->bindParam(":login", $login, PDO::PARAM_STR);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        if (password_verify($password, $row["password"])) {
                            return [
                                "result" => true,
                                "data" => [
                                    "id" => $row["id"],
                                    "login" => $row["login"],
                                    "prenom" => $row["prenom"],
                                    "nom" => $row["nom"],
                                ]
                            ];
                        } else {
                            return [
                                "result" => false,
                                "error" => "Invalid credentials"
                            ];
                        }
                    }

                } else {
                    return [
                        "result" => false,
                        "error" => "Invalid credentials"
                    ];
                }

            }
        }
        unset($stmt);

    }

    public static function updateUserInfos($login, $prenom, $nom, $id)
    {
        if (self::$pdo === null) {
            self::connectToDb();
        }
        $sql = "UPDATE utilisateurs SET login = :login, prenom = :prenom, nom = :nom WHERE id = :id";

        if ($stmt = self::$pdo->prepare($sql)) {
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->bindParam(":login", $login, PDO::PARAM_STR);
            $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
            $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
            $stmt->execute();
            unset($stmt);
        }
    }

    public static function updateUserPassword($password, $newpassword, $id)
    {
        if (self::$pdo === null) {
            self::connectToDb();
        }

        if (self::passwordCheck($id, $password)) {
            $sql = "UPDATE utilisateurs SET password = :password WHERE id = :id";

            if ($stmt = self::$pdo->prepare($sql)) {
                $param_password = password_hash($newpassword, PASSWORD_DEFAULT);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                unset($stmt);
                return [
                    "result" => true,
                    "error" => "Successfully changed password"
                ];
            }
        } else {
            return [
                "result" => false,
                "error" => "Wrong password"
            ];
        }
    }
    private static function connectToDb()
    {
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'moduleconnexion');
        try {
            self::$pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("ERROR: Could not connect. " . $e->getMessage());
        }
    }

    public static function getAllUsers()
    {
        if (self::$pdo === null) {
            self::connectToDb();
        }
        $sql = "SELECT * FROM utilisateurs";
        if ($stmt = self::$pdo->prepare($sql)) {
            if ($stmt->execute()) {
                if ($data = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                    return [
                        "result" => true,
                        "data" => $data
                    ];

                } else {
                    return [
                        "result" => false,
                        "error" => "Could not fetch data"
                    ];
                }
            }
        }
        unset($stmt);
    }

    public static function getUserInfos(int $id)
    {
        if (self::$pdo === null) {
            self::connectToDb();
        }

        $sql = "SELECT * FROM utilisateurs WHERE id = :id";
        if ($stmt = self::$pdo->prepare($sql)) {
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            if ($row = $stmt->fetch()) {
                unset($stmt);
                return [
                    "result" => true,
                    "data" => [
                        "id" => $row["id"],
                        "login" => $row["login"],
                        "prenom" => $row["prenom"],
                        "nom" => $row["nom"],
                    ]
                ];
            } else {
                unset($stmt);
                return [
                    "result" => false,
                    "error" => "Invalid credentials"
                ];
            }
        }
    }

}

?>