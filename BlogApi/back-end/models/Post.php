<?php

class Post
{
    //Database
    private $conn;
    private $table = 'posts'; //Database nom de la table

    //Propriétés de la DB
    public $id;
    public $title;
    public $category_id;
    public $category_name;
    public $body;
    public $author;
    public $created_at;
    public $updated_at;

    //Constructeur avec DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Obtenir les posts
    public function read()
    {
        //Création de la requête
        $query = 'SELECT
            c.name as category_name,
            p.id,
            p.title,
            p.body,
            p.author,
            p.created_at,
            p.updated_at
            FROM ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.category_id
            ORDER BY
                p.created_at DESC';

        //Préparation de la requête
        $req = $this->conn->prepare($query);

        //Exécution de la requête
        $req->execute();

        return $req;
    }

    //Obtenir un seul post
    public function read_single()
    {
        //Création de la requête
        $query = 'SELECT
            c.name as category_name,
            p.id,
            p.title,
            p.body,
            p.author,
            p.created_at,
            p.updated_at
            FROM ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT 0,1';

        //Préparation de la requête
        $req = $this->conn->prepare($query);

        //Liaison de l'id
        $req->bindParam(1, $this->id);

        //Exécution de la requête
        $req->execute();

        $row = $req->fetch(PDO::FETCH_ASSOC);

        //Définir les propriétés
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];
    }

    //Créer un post
    public function create()
    {
        //Création de la requête
        $query = 'INSERT INTO ' . $this->table . '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';

        //Préparation de la requête
        $req = $this->conn->prepare($query);

        //Nettoyer les données pour sécuriser la DB
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //Liaison des données
        $req->bindParam(':title', $this->title);
        $req->bindParam(':body', $this->body);
        $req->bindParam(':author', $this->author);
        $req->bindParam(':category_id', $this->category_id);

        //Exécution de la requête
        if ($req->execute()) {
            return true;
        }

        //Afficher l'erreur si la requête ne s'exécute pas
        printf("Erreur: %s.\n", $req->error);
        return false;
    }

    //Mettre à jour un post
    public function update()
    {
        //Création de la requête
        $query = 'UPDATE ' . $this->table . '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            WHERE
                id = :id';

        //Préparation de la requête
        $req = $this->conn->prepare($query);

        //Nettoyer les données pour sécuriser la DB
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Liaison des données
        $req->bindParam(':title', $this->title);
        $req->bindParam(':body', $this->body);
        $req->bindParam(':author', $this->author);
        $req->bindParam(':category_id', $this->category_id);
        $req->bindParam(':id', $this->id);

        //Exécution de la requête
        if ($req->execute()) {
            return true;
        } else {
            //Afficher l'erreur si la requête ne s'exécute pas
            $errorInfo = $req->errorInfo();
            printf("Erreur: %s.\n", $errorInfo[2]);
        };
    }

    //Supprimer un post
    public function delete()
    {
        //Création de la requête
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        //Préparation de la requête
        $req = $this->conn->prepare($query);

        //Nettoyer les données pour sécuriser la DB
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Liaison des données
        $req->bindParam(':id', $this->id);

        //Exécution de la requête
        if ($req->execute()) {
            return true;
        } else {
            //Afficher l'erreur si la requête ne s'exécute pas
            printf("Erreur: %s.\n", $req->error);
            return false;
        }
    }
}
