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
const Entity = "Vendor";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $vendor = $database->vendor;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;
//    todo: for testing

    try {
        $vendor_id = 0;
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $vendor_id = $_POST['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }
        $vendor->vendor_id = $vendor_id;

        updatingVendorEdit($db, $vendor, $response, $responses, $data);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $vendor_Id
 * @param PDO|null $db
 * @param array $data
 * @return array
 */
function checkIfPostValuesAreSetAndEdit(int $vendor_Id, ?PDO $db, array $data): array
{
    $database = new Database();
    $vendor = $database->vendor;
    $vendor->vendor_id = $vendor_Id;
    $sql = $vendor->getById($vendor_Id);
    $result = $database->runSelectOneQuery($sql, $db);

//    todo for testing

    $vendor_name = $result['vendor_name'];
    if (isset($data['vendor_name']) && !empty($data['vendor_name'])) {
        $vendor_name = $data['vendor_name'];
    }

    (int)$active = $result['active'];
    if (isset($data['active']) && !empty($data['active'])) {
        $active = $data['active'];
    }

    $vendor_email = $result['vendor_email'];
    if (isset($data['vendor_email']) && !empty($data['vendor_email'])) {
        $vendor_email = $data['vendor_email'];
    }

    $user_id = $result['user_id'];
    if (isset($data['user_id']) && !empty($data['user_id'])) {
        $user_id = $data['user_id'];
    }

    return array("vendor_name" => $vendor_name, "active" => $active, "vendor_email" => $vendor_email, "user_id" => $user_id);
}


/**
 * @param PDO|null $db
 * @param Vendor $vendor
 * @param array $response
 * @param Responses $responses
 * @param array $data
 * @return void
 * @throws JsonException
 */
function updatingVendorEdit(?PDO $db, Vendor $vendor, array $response, Responses $responses, array $data): void
{
    $database = new Database();
    $result = array();
    if ($vendor->vendor_id != null && $vendor->vendor_id !== 0) {
        $vendor_Id = $vendor->vendor_id;

        $result = checkIfPostValuesAreSetAndEdit($vendor_Id, $db, $data);

//        todo for testing

        $sql = $vendor->updateVendor((int)$result['user_id'], (string)$result['vendor_name'], (string)$result['vendor_email'], (int)$result['active'], $vendor_Id);

        $database->runQuery($sql, $db);

    } else {
        $responses->errorInvalidRequest($response);
    }

    /* foreach ($result as $row) {
         $encrypted = encrypt($row['vendor_id'],$ciphering,$encryption_iv,$options);
         $row["vendor_id"] = $encrypted;
         $row["0"] = $encrypted;
     }*/

    $responses->successDataUpdated($response, $result, Entity);
}


