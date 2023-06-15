<?php

class Database
{

    private $host = "infyenterprise.com";
    private $db_name = "u818699652_test_db";
    private $username = "u818699652_admin";
    private $password = "c23:aoE21rI+";
    public $conn;

    public function dbConnection()
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
