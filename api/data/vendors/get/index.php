<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
require_once '../../../connection.php';
//require_once '../../../connection-local.php';

require_once '../../../errors/Responses.php';
const Entity = "Vendor";

$response = array();
$status = false;
$responses = new Responses();


if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

    $database = new Database();
    $db = $database->dbConnection();
    $vendor = $database -> vendor;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $vendor_id = 0;
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $vendor_id = $_POST['id'];
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $vendor_id = $_GET['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }

        $sql = $vendor->getById($vendor_id);

        if (isset($_POST["active"]) && !empty($_POST["active"])) {

            (int)$active = $_POST["active"];

            $sql = $vendor->getByIdAndActive((int) $active, (int) $vendor_id);
        } else if (isset($_GET["active"]) && !empty($_GET["active"])) {

            (int)$active = $_GET["active"];

            $sql = $vendor->getByIdAndActive($active, $vendor_id);
        }

        $result = $database->runSelectOneQuery($sql, $db);

        /* foreach ($result as $row) {
             $encrypted = encrypt($row['vendor_id'],$ciphering,$encryption_iv,$options);
             $row["vendor_id"] = $encrypted;
             $row["0"] = $encrypted;
         }*/

        $responses->successDataRetrieved($response, $result, Entity);
    } catch (JsonException $e) {
        $responses->errorInsertingData($response, $e, Entity);
    }

} else {

        $responses->errorInvalidRequest($response);
}


