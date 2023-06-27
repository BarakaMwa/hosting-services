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


if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {

    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $vendor = $database->vendor;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    todo: for testing
//    $_POST['id'] = 5;

    try {
        updatingVendorEdit($db, $vendor, $response, $responses);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e);
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $vendor_Id
 * @param PDO|null $db
 * @return array
 */
function checkIfPostValuesAreSetAndEdit(int $vendor_Id, ?PDO $db): array
{
    $database = new Database();
    $vendor = $database->vendor;
    $sql = $vendor->getById($vendor_Id);
    $result = $database->runSelectOneQuery($sql, $db);

//    todo for testing
//    echo $result['active'];
    $vendor_name = $result['vendor_name'];
    if (isset($_POST['vendor_name']) && !empty($_POST['vendor_name'])) {
        $vendor_name = $_POST['vendor_name'];
    }

    (int)$active = $result['active'];
    if (isset($_POST['active']) && !empty($_POST['active'])) {
        $active = $_POST['active'];
    }

    $vendor_email = $result['vendor_email'];
    if (isset($_POST['vendor_email']) && !empty($_POST['vendor_email'])) {
        $vendor_email = $_POST['vendor_email'];
    }

    $user_id = $result['user_id'];
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    }

    return array("vendor_name" => $vendor_name, "active" => $active, "vendor_email" => $vendor_email, "user_id" => $user_id);
}


/**
 * @param PDO|null $db
 * @param Vendor $vendor
 * @param array $response
 * @param Responses $responses
 * @return void
 * @throws JsonException
 */
function updatingVendorEdit(?PDO $db, Vendor $vendor, array $response, Responses $responses): void
{
    $database=new Database();
    $result = array();
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $vendor_Id = $_POST['id'];

        $result = checkIfPostValuesAreSetAndEdit($vendor_Id, $db);

//        todo for testing
//        $result['vendor_name'] = "BArakar";

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

    $responses->successDataRetrieved($response, $result,"Cart");
}


