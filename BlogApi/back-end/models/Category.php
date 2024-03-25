<?php

class Category
{
    private $conn;
    private $table = 'categories';
    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 'SELECT
            id,
            name
            FROM ' . $this->table . '
            ORDER BY
                name ASC';

        $req = $this->conn->prepare($query);
        $req->execute();

        return $req;
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
            SET
                name = :name';

        $req = $this->conn->prepare($query);
        $req->bindParam(':name', $this->name);
        $req->execute();

        return $req;
    }
}
