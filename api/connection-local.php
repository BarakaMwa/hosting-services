<?php

require_once 'data/vendor.php';
class Database
{

    private $host = "localhost:3399";
    private $db_name = "hosted_services";
    private $username = "root";
    private $password = "rootmysql";
    public $conn;

    public function dbConnection(): ?PDO
    {

        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
