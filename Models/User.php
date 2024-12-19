<?php

require_once 'Database.php';

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $pdo;

    public function __construct($id = null, $name = null, $email = null, $password = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $db = new Database();
        $this->pdo = $db->pdo;
    }

    public function register()
    {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        $sqlQuery = "INSERT INTO utilisateurs (nom, email, password) VALUES (:name, :email, :password);";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $hashedPassword
        ]);
        return true;
    }
    public function login()
    {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'email' => $this->email,
        ]);
        $user = $stmt->fetch();
        if ($user && password_verify($this->password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function getInfos()
    {
        $sqlQuery = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            'email' => $this->email
        ]);

        return $stmt->fetch();
    }

    public function getInfosByID($id)
    {
        $sqlQuery = "SELECT nom FROM utilisateurs WHERE id_user = :id";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function updateInfos($name, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sqlQuery = "UPDATE utilisateurs SET nom = :name, email = :email , password = :password WHERE email = :email";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    public function getId()
    {
        $sqlQuery = "SELECT id_user FROM utilisateurs WHERE email = :email";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            'email' => $this->email
        ]);
        return $stmt->fetch();
    }
}