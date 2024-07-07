<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
require_once '../../../RemoteDatabase.php';
//require_once '../../../LocalDatabase.php';

require_once '../../../errors/Responses.php';

$response = array();
$status = false;
$responses = new Responses();
const INVOICE = "Invoice";
const INVOICE_ENTRIES = "Invoice Entries";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

    $database = new LocalDatabase();
    $db = $database->dbConnection();
    $invoice = $database -> invoice;
    $invoice_entries = $database -> invoiceEntries;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $invoiceId = 0;
    $data= array();

    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $invoiceId = $_POST['id'];
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $invoiceId = $_GET['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }

        $sql_invoice = $invoice->getById($invoiceId);
        $sql_entries = $invoice_entries->getByInvoiceId($invoiceId);

        if (isset($_POST["active"]) && !empty($_POST["active"])) {

            (int)$active = $_POST["active"];

            $sql_invoice = $invoice->getByIdAndActive($active, $invoiceId);
            $sql_entries = $invoice_entries->getByInvoiceId($invoiceId);

        } else if (isset($_GET["active"]) && !empty($_GET["active"])) {

            (int)$active = $_GET["active"];

            $sql_invoice = $invoice->getByIdAndActive($active, $invoiceId);
            $sql_entries = $invoice_entries->getByInvoiceId($invoiceId);

        }

        $result['invoice'] = $database->runSelectOneQuery($sql_invoice, $db);
        $result['entries'] = $database->runSelectAllQuery($sql_entries, $db);

        /* foreach ($result as $row) {
             $encrypted = encrypt($row['invoiceId'],$ciphering,$encryption_iv,$options);
             $row["invoiceId"] = $encrypted;
             $row["0"] = $encrypted;
         }*/

        $responses->successDataRetrieved($response, $result, INVOICE );
    } catch (JsonException $e) {
        $responses->errorInsertingData($response, $e, INVOICE);
    }

} else {

        $responses->errorInvalidRequest($response);
}


