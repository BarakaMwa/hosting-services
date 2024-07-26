<?php
//todo validation
require_once '../../headers-api.php';
require_once '../../../Database/LocalDatabase.php';
require_once '../../../Responses/Responses.php';

session_start();

use Database\LocalDatabase;
use Responses\Responses;

$response = array();
$status = false;
$responses = new Responses();

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] = 'GET') {

    try {
        $database = new LocalDatabase();
        $db = $database->dbConnection();
        $cart = $database->cart;

        $Entity = $cart->getClassName();

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = $cart->getGetAll();

//    $_POST['active'] = 0;

        if (isset($_POST["active"]) && !empty($_POST["active"])) {

            (int)$active = $_POST["active"];

            $sql = $cart->getAllByActive($active);
        }

        $result = $database->runSelectAllQuery($sql, $db);


//    todo encrypt
        /* foreach ($result as $row) {
             $encrypted = encrypt($row['vendorId'],$ciphering,$encryption_iv,$options);
             $row["vendorId"] = $encrypted;
             $row["0"] = $encrypted;
         }*/

        $responses->successDataRetrieved($response, $result, $Entity);


    } catch (Exception $ex) {
        $responses->failedOperation($ex);
    }

} else {

    $responses->errorInvalidRequest($response);
}

