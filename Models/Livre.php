<?php

require_once 'Database.php';

class Livre
{
    private $id;
    private $titre;
    private $auteur;
    private $pdo;

    public function __construct($id = null, $titre = null, $auteur = null)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $db = new Database();
        $this->pdo = $db->pdo;

    }

    public function getAllBook()
    {
        $sqlQuery = 'SELECT * FROM livres';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute();
        $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $livres;
    }

    public function addBook($id_user)
    {
        $sqlQuery = 'INSERT INTO livres (titre, auteur,id_user ) VALUES (:titre, :auteur,:id_user)';
        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            'titre' => $this->titre,
            'auteur' => $this->auteur,
            'id_user' => $id_user
        ]);
    }


}