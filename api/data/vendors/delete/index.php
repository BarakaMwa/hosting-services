<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';

require_once '../../../errors/Responses.php';

$response = array();
$responses = new Responses();
$status = false;
const ENTITY = "Vendor";

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {


    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    todo: for testing

    $vendor_id = 0;
    try {
        $vendor = $database->vendor;
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $vendor_id = $_POST['id'];
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $vendor_id = $_GET['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }
        $vendor->vendor_id = $vendor_id;

        $sql = $vendor->getById($vendor_id);
        $result = $database->runSelectOneQuery($sql, $db);

        if ((int)$result['active'] === 0) {
            $responses->warningAlreadyDeleted($response, $result, ENTITY);
        }

        updatingVendorDelete($db, $vendor, $response, $responses);

    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, ENTITY);
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $vendor_Id
 * @param PDO|null $db
 * @return array
 * @throws JsonException
 */
function checkIfPostValuesAreSetAndDeactivate(int $vendor_Id, ?PDO $db): array
{
    $responses = new Responses();
    $database = new Database();
    $vendor = $database->vendor;
    $sql = $vendor->getById($vendor_Id);
    $result = $database->runSelectOneQuery($sql, $db);

//    todo for testing

    (string)$vendor_name = $result['vendor_name'];
    if (isset($_POST['vendor_name']) && !empty($_POST['vendor_name'])) {
        $vendor_name = $_POST['vendor_name'];
    }

    $active = (int)$result['active'];
    if ($active === 0 || $active == false){
        $response = array();
        $responses->warningAlreadyDeleted($response,$result,ENTITY);
    }

//    todo for testing
        $active = 0;

    (string)$vendor_email = $result['vendor_email'];
    if (isset($_POST['vendor_email']) && !empty($_POST['vendor_email'])) {
        $vendor_email = $_POST['vendor_email'];
    }

    (int)$user_id = $result['user_id'];
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    }

    return array("vendor_name" => $vendor_name, "active" => $active, "vendor_email" => $vendor_email, "user_id" => $user_id, "vendor_id" => $vendor_Id);
}


/**
 * @param PDO|null $db
 * @param Vendor $vendor
 * @param array $response
 * @param Responses $responses
 * @return void
 * @throws JsonException
 */
function updatingVendorDelete(?PDO $db, Vendor $vendor, array $response, Responses $responses): void
{
    $result = array();
    if ($vendor->vendor_id !== 0) {

        $vendor_Id = $vendor->vendor_id;
//        $vendor_Id = $vendor_id;
        $result = checkIfPostValuesAreSetAndDeactivate($vendor_Id, $db);

        $sql = $vendor->updateVendor((int)$result['user_id'], (string)$result['vendor_name'], (string)$result['vendor_email'], (int)$result['active'], (int)$vendor_Id);

        $database = new Database();
        $database->runQuery($sql, $db);

    } else {
        $responses->errorInvalidRequest($response);
    }

//    todo encrypt
    /* foreach ($result as $row) {
         $encrypted = encrypt($row['vendor_id'],$ciphering,$encryption_iv,$options);
         $row["vendor_id"] = $encrypted;
         $row["0"] = $encrypted;
     }*/

    $responses->successDataDeactivated($response, $result, ENTITY);
}

