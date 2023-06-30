<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';

require_once '../../../errors/Responses.php';

$response = array();
$status = false;
$responses = new Responses();
const Entity = "Invoice";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

    $database = new Database();
    $db = $database->dbConnection();
    $invoice = $database -> invoice;
    $invoice_entries = $database -> invoice_entries;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $invoice_id = 0;

    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $invoice_id = $_POST['id'];
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $invoice_id = $_GET['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }

        $sql_invoice = $invoice->getById($invoice_id);
        $sql_invoice_entries = $invoice_entries->getByInvoiceId($invoice_id);

        if (isset($_POST["active"]) && !empty($_POST["active"])) {

            (int)$active = $_POST["active"];

            $sql_invoice = $invoice->getByIdAndActive($active, $invoice_id);
        } else if (isset($_GET["active"]) && !empty($_GET["active"])) {

            (int)$active = $_GET["active"];

            $sql_invoice = $invoice->getByIdAndActive($active, $invoice_id);
        }

        $result['invoice'] = $database->runSelectOneQuery($sql_invoice, $db);
        $result['invoice_entries'] = $database->runSelectOneQuery($sql_invoice, $db);

        /* foreach ($result as $row) {
             $encrypted = encrypt($row['invoice_id'],$ciphering,$encryption_iv,$options);
             $row["invoice_id"] = $encrypted;
             $row["0"] = $encrypted;
         }*/

        $responses->successDataRetrieved($response, $result, Entity );
    } catch (JsonException $e) {
        $responses->errorInsertingData($response, $e, Entity);
    }

} else {

        $responses->errorInvalidRequest($response);
}


