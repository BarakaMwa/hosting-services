<?php

namespace Database;

require_once(realpath(__DIR__ . '/../Data/Vendors.php'));
use Data\Vendors;
require_once(realpath(__DIR__ . '/../Data/Carts.php'));
use Data\Carts;
require_once(realpath(__DIR__ . '/../Data/Products.php'));
use Data\Products;
require_once(realpath(__DIR__ . '/../Data/Invoices.php'));
use Data\Invoices;
require_once(realpath(__DIR__ . '/../Data/Trustees.php'));
use Data\Trustees;
require_once(realpath(__DIR__ . '/../Data/Devices.php'));
use Data\Devices;
require_once(realpath(__DIR__ . '/../Data/InvoiceEntries.php'));
use Data\InvoiceEntries;
require_once(realpath(__DIR__ . '/../Data/Payments.php'));
use Data\Payments;
require_once(realpath(__DIR__ . '/../Data/QrCodes.php'));
use Data\QrCodes;
require_once(realpath(__DIR__ . '/../Data/Files.php'));
use Data\Files;
require_once(realpath(__DIR__ . '/../Errors/Responses.php'));
use Errors\Responses;

use PDO;

class LocalDatabase
{

    private $host = "localhost:3306";
    private $dBName = "hosted_services";
    private $username = "root";
    private $password = "rootmysql";
    public $conn;

    public $vendor;
    public $device;
    public $cart;
    public $product;
    public $invoice;
    public $invoiceEntries;
    public $payment;
    public $qrCode;
    public $file;
    public $responses;
    public $trustee;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->vendor = new Vendors();
        $this->qrCode = new QrCodes();
        $this->trustee = new Trustees();
        $this->device = new Devices();
        $this->product = new Products();
        $this->invoice = new Invoices();
        $this->invoiceEntries = new InvoiceEntries();
        $this->payment = new Payments();
        $this->file = new Files();
        $this->cart = new Carts();
        $this->responses = new Responses();
    }

    /**
     * @return PDO|null
     */
    public function dbConnection(): ?PDO
    {

        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dBName, $this->username, $this->password);
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
