<?php

require_once 'Database.php';

class Favoris
{
    private $id;
    private $livre_id;
    private $user_id;
    private $pdo;

    public function __construct($id = null, $livre_id = null, $user_id = null)
    {
        $this->id = $id;
        $this->livre_id = $livre_id;
        $this->user_id = $user_id;
        $db = new Database();
        $this->pdo = $db->pdo;
    }

    public function getFavoris()
    {
        $sqlQuery = "SELECT * FROM livres INNER JOIN favoris ON favoris.livre_id = livres.id_livre INNER JOIN utilisateurs ON favoris.utilisateur_id = utilisateurs.id_user WHERE utilisateurs.id_user = :id";
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute(['id' => $this->user_id]);
        return $stmt->fetchAll();
    }

    public function addFavoris()
    {
        $sqlQuery = 'INSERT INTO favoris (livre_id, utilisateur_id) VALUES (:livre_id, :id)';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            'livre_id' => $this->livre_id,
            'id' => $this->user_id
        ]);
    }

    public function removeFavoris()
    {
        $sqlQuery = 'DELETE FROM favoris WHERE id_favoris = :id;';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute(['id' => $this->id]);
    }
}