<?php

require_once 'data/Vendors.php';
require_once 'data/Cart.php';
require_once 'data/Product.php';
require_once 'data/Invoice.php';
require_once 'data/Devices.php';
require_once 'data/Trustees.php';
require_once 'data/Payments.php';
require_once 'data/QrCodes.php';
require_once 'data/Files.php';
require_once 'errors/Responses.php';

class Database
{

    private $host = "infyenterprise.com";
    private $db_name = "u818699652_test_db";
    private $username = "u818699652_test_db";
    private $password = "bDPPQuJ1UoKfl3f9SzIvSXOT8uNRE0Vy";
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
