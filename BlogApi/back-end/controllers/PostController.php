<?php

class PostController
{
    private $conn;
    private $table = 'posts';
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
            ORDER BY
                p.created_at DESC';

        $req = $this->conn->prepare($query);
        $req->execute();

        return $req;
    }

    //Créer un post
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';

        $req = $this->conn->prepare($query);
        $req->bindParam(':title', $this->title);
        $req->bindParam(':body', $this->body);
        $req->bindParam(':author', $this->author);
        $req->bindParam(':category_id', $this->category_id);

        if ($req->execute()) {
            echo json_encode(
                array('message' => 'Post créé')
            );
        } else {
            echo json_encode(
                array('message' => 'Post non créé')
            );
        };
    }

    //Mise à jour d'un post
    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            WHERE
                id = :id';

        $req = $this->conn->prepare($query);
        $req->bindParam(':id', $this->id);
        $req->bindParam(':title', $this->title);
        $req->bindParam(':body', $this->body);
        $req->bindParam(':author', $this->author);
        $req->bindParam(':category_id', $this->category_id);

        if ($req->execute()) {
            echo json_encode(
                array('message' => 'Post mis à jour')
            );
        } else {
            echo json_encode(
                array('message' => 'Post non mis à jour')
            );
        };
    }

    //Supprimer un post
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . 'WHERE id = :id';

        $req = $this->conn->prepare($query);
        $req->bindParam(':id', $this->id);

        if ($req->execute()) {
            echo json_encode(
                array('message' => 'Post supprimé')
            );
        } else {
            echo json_encode(
                array('message' => 'Post non supprimé')
            );
        }
    }
}
