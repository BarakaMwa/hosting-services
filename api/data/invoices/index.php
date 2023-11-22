<?php
//todo validation
require_once '../../headers-api.php';
session_start();
require_once '../../connection.php';
//require_once '../../connection-local.php';

require_once '../../errors/Responses.php';

$response = array();
$status = false;
$responses = new Responses();
const Entity = "Invoice";
const Entity_Entry = "Invoice Entry";

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] = 'GET') {


    $database = new LocalDatabase();
    $db = $database->dbConnection();
    $invoice = $database->invoice;

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $invoice->getGetAll();

//    $_POST['active'] = 0;

    if(isset($_POST["active"]) && !empty($_POST["active"])){

        (int)$active = $_POST["active"];

        $sql = $invoice->getAllByActive($active);
    }

    $result = $database->runSelectAllQuery($sql, $db);


//    todo encrypt
   /* foreach ($result as $row) {
        $encrypted = encrypt($row['vendorId'],$ciphering,$encryption_iv,$options);
        $row["vendorId"] = $encrypted;
        $row["0"] = $encrypted;
    }*/

    $responses->successDataRetrieved($response, $result, Entity);

} else {

   $responses -> errorInvalidRequest($response);
}


