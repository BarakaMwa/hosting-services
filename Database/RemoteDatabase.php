<?php

namespace Database;

require_once './../data/Vendors.php';
use Data\Vendors;
require_once './../data/Carts.php';
use Data\Carts;
require_once './../data/Products.php';
use Data\Products;
require_once './../data/Invoices.php';
use Data\Invoices;
require_once './../data/Invoice_Entries.php';
use Data\Invoice_Entries;
require_once './../data/Devices.php';
use Data\Devices;
require_once './../data/Trustees.php';
use Data\Trustees;
require_once './../data/Payments.php';
use Data\Payments;
require_once './../data/Qr_Codes.php';
use Data\Qr_Codes;
require_once './../data/Files.php';
use Data\Files;
require_once './../Responses/Responses.php';
use Responses\Responses;

class RemoteDatabase
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
    public $payment;
    public $qrCode;
    public $file;
    public $device;
    public $trustee;
    public $responses;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->vendor = new Vendors();
        $this->qrCode = new Qr_Codes();
        $this->product = new Products();
        $this->invoice = new Invoices();
        $this->invoiceEntry = new Invoice_Entries();
        $this->payment = new Payments();
        $this->device = new Devices();
        $this->trustee = new Trustees();
        $this->file = new Files();
        $this->cart = new Carts();
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
