<?php
//todo validation
require_once '../../headers-api.php';
require_once '../../../Database/LocalDatabase.php';
require_once '../../../Responses/Responses.php';

session_start();

use Responses\Responses;
use Database\LocalDatabase;

$response = array();
$status = false;
$responses = new Responses();
const Entity = "Vendors";

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] = 'GET') {


    $database = new LocalDatabase();
    $db = $database->dbConnection();
    $vendor = $database->vendor;

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $vendor->getGetAll();


    if(isset($_POST["active"]) && !empty($_POST["active"])){

        (int)$active = $_POST["active"];

        $sql = $vendor->getAllByActive($active);
    }elseif (isset($_GET["active"]) && !empty($_GET["active"])){

        (int)$active = $_GET["active"];

        $sql = $vendor->getAllByActive($active);
    }

    $result = $database->runSelectAllQuery($sql, $db);

   /* foreach ($result as $row) {
        $encrypted = encrypt($row['vendorId'],$ciphering,$encryption_iv,$options);
        $row["vendorId"] = $encrypted;
        $row["0"] = $encrypted;
    }*/

    $responses->successDataRetrieved($response, $result, Entity);

} else {

   $responses -> errorInvalidRequest($response);
}


