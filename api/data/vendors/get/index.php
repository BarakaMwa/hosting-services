<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
require_once '../../../RemoteDatabase.php';
//require_once '../../../LocalDatabase.php';

require_once '../../../errors/Responses.php';
const Entity = "Vendors";

$response = array();
$status = false;
$responses = new Responses();


if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

    $database = new LocalDatabase();
    $db = $database->dbConnection();
    $vendor = $database -> vendor;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $vendorId = 0;
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $vendorId = $_POST['id'];
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $vendorId = $_GET['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }

        $sql = $vendor->getById($vendorId);

        if (isset($_POST["active"]) && !empty($_POST["active"])) {

            (int)$active = $_POST["active"];

            $sql = $vendor->getByIdAndActive((int) $active, (int) $vendorId);
        } else if (isset($_GET["active"]) && !empty($_GET["active"])) {

            (int)$active = $_GET["active"];

            $sql = $vendor->getByIdAndActive($active, $vendorId);
        }

        $result = $database->runSelectOneQuery($sql, $db);

        /* foreach ($result as $row) {
             $encrypted = encrypt($row['vendorId'],$ciphering,$encryption_iv,$options);
             $row["vendorId"] = $encrypted;
             $row["0"] = $encrypted;
         }*/

        $responses->successDataRetrieved($response, $result, Entity);
    } catch (JsonException $e) {
        $responses->errorInsertingData($response, $e, Entity);
    }

} else {

        $responses->errorInvalidRequest($response);
}


