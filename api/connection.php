<?php

require_once 'data/Vendor.php';
require_once 'data/Cart.php';
require_once 'data/Product.php';
require_once 'data/Invoice.php';
require_once 'data/Payment.php';
require_once 'data/QrCode.php';
require_once 'data/Image.php';
require_once 'errors/Responses.php';
//$vendor = new Vendor();
$responses = new Responses();

class Database
{

    private $host = "infyenterprise.com";
    private $db_name = "u818699652_test_db";
    private $username = "u818699652_admin";
    private $password = "c23:aoE21rI+";
    public $conn;

    public $vendor;
    public $cart;
    public $product;
    public $invoice;
    public $payment;
    public $qrCode;
    public $image;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->vendor = new Vendor();
        $this->qrCode = new QrCode();
        $this->product = new Product();
        $this->invoice = new Invoice();
        $this->payment = new Payment();
        $this->image = new Image();
        $this->cart = new Cart();
    }

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

    /**
     * @param $sql
     * @param $db
     * @return mixed
     */
    public function runSelectAllQuery($sql, $db)
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
//    return $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    /**
     * @param $sql
     * @param $db
     * @return mixed
     */
    public function runSelectOneQuery($sql, $db)
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0];
    }

//    /**
//     * @param $sql
//     * @param $db
//     * @return void
//     */
//    public function runUpdateQuery($sql, $db): void
//    {
//        $stmt = $db->prepare($sql);
//        $stmt->execute();
//    }
//
//    /**
//     * @param $sql
//     * @param $db
//     * @return void
//     */
//    public function runDeleteQuery($sql, $db): void
//    {
//        $stmt = $db->prepare($sql);
//        $stmt->execute();
//    }

    /**
     * @param $sql
     * @param $db
     * @return mixed
     */
    public function runQuery($sql, $db)
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }

}
