<?php
class Database
{
    // configuration de la base de données
    private $host = 'localhost';
    private $db = 'bibliotheque';
    private $user = 'Lucas';
    private $password = 'password';
    private $charset = 'utf8mb4';
    public $pdo;

    public function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $option = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->password, $option);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

    }
}