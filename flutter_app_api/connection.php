<?php

require_once 'data/Vendors.php';
require_once 'data/Carts.php';
require_once 'data/Products.php';
require_once 'data/Invoices.php';
require_once 'data/InvoiceEntries.php';
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

    public $vendor;
    public $cart;
    public $product;
    public $invoice;
    public $invoiceEntry;
    public $device;
    public $trustee;
    public $payment;
    public $qrCode;
    public $file;
    public $responses;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->vendor = new Vendors();
        $this->qrCode = new QrCodes();
        $this->product = new Products();
        $this->invoice = new Invoices();
        $this->payment = new Payments();
        $this->file = new Files();
        $this->cart = new Carts();
        $this->device = new DevicesService();
        $this->trustee = new TrusteesService();
        $this->responses = new Responses();
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
     * @throws PDOException
     * @throws JsonException
     * @meta returns all SQL statement results
     */
    public function runSelectAllQuery($sql, $db)
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $count = $this->getCount($stmt);
        if ($count === 0) {
            $this->responses->warningNoResults();
        }

        return $stmt->fetchAll();
    }

    /**
     * @param $sql
     * @param $db
     * @return mixed
     * @meta returns one SQL statement result
     * @throws JsonException
     */
    public function runSelectOneQuery($sql, $db)
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $count = $this->getCount($stmt);
        if ($count === 0) {
            $this->responses->warningNoResults();
        }
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result[0];
    }

    /**
     * @param $sql
     * @param $db
     * @return void
     */
    public function runQuery($sql, $db): void
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }

    /**
     * @param $stmt
     * @return int
     */
    private function getCount($stmt): int
    {
        return $stmt->rowCount();
    }

    /**
     * @param $sql
     * @param $db
     * @return int
     */
    public function getResultCount($sql, $db): int
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }

}
