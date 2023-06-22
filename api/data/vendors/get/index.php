<?php
//todo validation
/*$ciphering ="";
$encryption_iv ="";
$options ="";*/
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';
//require_once '../../../Cipher.php';

$response = array();
$status = false;
$vendor = new Vendor();
$responses = new Responses();


if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->dbConnection();

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $vendor_id = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $vendor_id = $_POST['id'];
    } else if (isset($_GET['id']) && !empty($_GET['id'])) {
        $vendor_id = $_GET['id'];
    } else {
        $responses->errorInvalidRequest($response);
    }


    $sql = $vendor->getById($vendor_id);

//    $_POST['active'] = 1;

    if (isset($_POST["active"]) && !empty($_POST["active"])) {

        (int)$active = $_POST["active"];

        $sql = $vendor->getByIdAndActive($active, $vendor_id);
    }

    $result = $vendor->runSelectAllQuery($sql, $db);

    /* foreach ($result as $row) {
         $encrypted = encrypt($row['vendor_id'],$ciphering,$encryption_iv,$options);
         $row["vendor_id"] = $encrypted;
         $row["0"] = $encrypted;
     }*/


    try {
        $responses->successDataRetrieved($response, $result);
    } catch (JsonException $e) {
        $responses->errorInsertingData($response, $e);
    }

} else {

    try {
        $responses->errorInvalidRequest($response);
    } catch (JsonException $e) {
        $responses->errorInsertingData($response, $e);
    }
}


