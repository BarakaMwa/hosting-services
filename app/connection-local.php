<?php

require_once 'data/Vendors.php';
require_once 'data/Carts.php';
require_once 'data/Products.php';
require_once 'data/Invoices.php';
require_once 'data/Devices.php';
require_once 'data/Trustees.php';
require_once 'data/Payments.php';
require_once 'data/QrCodes.php';
require_once 'data/Files.php';
require_once 'errors/Responses.php';

class Database
{

    private $host = "localhost:3306";
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
