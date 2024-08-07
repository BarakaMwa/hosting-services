<?php
//todo validation

require_once '../../../headers-api.php';
require_once '../../../../Database/LocalDatabase.php';
require_once '../../../../Responses/Responses.php';
session_start();

use Database\LocalDatabase;
use Responses\Responses;

$response = array();
$responses = new Responses();
$status = false;
const ENTITY = "Vendors";

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {


    $result = array();
    $database = new LocalDatabase();
    $db = $database->dbConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    todo: for testing

    $vendorId = 0;
    try {
        $vendor = $database->vendor;
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $vendorId = $_POST['id'];
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $vendorId = $_GET['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }
        $vendor->id = $vendorId;

        $sql = $vendor->getById($vendorId);
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
    $database = new LocalDatabase();
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

    return array("vendor_name" => $vendor_name, "active" => $active, "vendor_email" => $vendor_email, "user_id" => $user_id, "vendorId" => $vendor_Id);
}


/**
 * @param PDO|null $db
 * @param Vendors $vendor
 * @param array $response
 * @param Responses $responses
 * @return void
 * @throws JsonException
 */
function updatingVendorDelete(?PDO $db, Vendors $vendor, array $response, Responses $responses): void
{
    $result = array();
    if ($vendor->vendorId !== 0) {

        $vendor_Id = $vendor->vendorId;
//        $vendor_Id = $vendorId;
        $result = checkIfPostValuesAreSetAndDeactivate($vendor_Id, $db);

        $sql = $vendor->update((int)$result['user_id'], (string)$result['vendor_name'], (string)$result['vendor_email'], (int)$result['active'], (int)$vendor_Id);

        $database = new LocalDatabase();
        $database->runQuery($sql, $db);

    } else {
        $responses->errorInvalidRequest($response);
    }

//    todo encrypt
    /* foreach ($result as $row) {
         $encrypted = encrypt($row['vendorId'],$ciphering,$encryption_iv,$options);
         $row["vendorId"] = $encrypted;
         $row["0"] = $encrypted;
     }*/

    $responses->successDataDeactivated($response, $result, ENTITY);
}

