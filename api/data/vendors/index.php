<?php
//todo validation
require_once '../../headers-api.php';
session_start();
//require_once '../../connection.php';
require_once '../../connection-local.php';

$response = array();
$status = false;
$responses = new Responses();
$vendor = new Vendor();

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] = 'GET') {

    $database = new Database();
    $db = $database->dbConnection();

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $vendor->getGetAll();

//    $_POST['active'] = 0;

    if(isset($_POST["active"]) && !empty($_POST["active"])){

        (int)$active = $_POST["active"];

        $sql = $vendor->getAllByActive($active);
    }

    $result = $vendor->runSelectAllQuery($sql, $db);

   /* foreach ($result as $row) {
        $encrypted = encrypt($row['vendor_id'],$ciphering,$encryption_iv,$options);
        $row["vendor_id"] = $encrypted;
        $row["0"] = $encrypted;
    }*/

    $responses->successDataRetrieved($response, $result);

} else {

   $responses -> errorInvalidRequest($response);
}


