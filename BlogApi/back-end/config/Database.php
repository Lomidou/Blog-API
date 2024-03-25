<?php

class connectDB
{
    private $host = "localhost";
    private $db_name = "api";
    private $username = "root";
    private $password = "root";
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $return["success"] = true;
            $return["message"] = "Connexion à la base de données réussie";
        } catch (PDOException $e) {
            $return["success"] = false;
            $return["message"] = "Connexion à la base de données échouée";
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
        return $this->conn;
    }
}
