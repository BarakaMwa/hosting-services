<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';

require_once '../../../constants/Utils.php';
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

    try {
        $result = insertingVendorEdit($db, $vendor, $response, $responses);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e);
    }

    $responses->successDataInserted($response, $result);

} else {
    $responses->errorInvalidRequest($response);
}

/**
 * @param PDO|null $db
 * @param Vendor $vendor
 * @param array $response
 * @param Responses $responses
 * @return array
 * @throws JsonException
 */
function insertingVendorEdit(?PDO $db, Vendor $vendor, array $response, Responses $responses): array
{
    $database = new Database();
    $result = $_POST;

    $result = checkIfPostValuesAreSetAndInsert($result, $db);

    $sql = $vendor->insertNewVendor($result);

    $database->runQuery($sql, $db);

    return $result;
}

/**
 * @param array $result
 * @param PDO|null $db
 * @return array
 * @throws JsonException
 */
function checkIfPostValuesAreSetAndInsert(array $result, ?PDO $db): array
{
//todo for testing
    $responses = new Responses();
    $utils = new Utils();
    $vendor_name = "vendor name";
    $active = 0;
    $user_id = 1;
    $vendor_email = 'vendor_email@example.com';

//    todo for testing
    $test = false;
    if ($test === true) {

        [$vendor_name, $active, $vendor_email, $user_id] = checkPostInputs($vendor_name, $utils, $responses, $active, $vendor_email, $user_id);

    }
    return array("vendor_name" => $vendor_name, "active" => $active, "vendor_email" => $vendor_email, "user_id" => $user_id);
}

/**
 * @param $vendor_name
 * @param Utils $utils
 * @param Responses $responses
 * @param $active
 * @param $vendor_email
 * @param $user_id
 * @return array
 * @throws JsonException
 */
function checkPostInputs($vendor_name, Utils $utils, Responses $responses, $active, $vendor_email, $user_id): array
{
    if (isset($_POST['vendor_name']) && !empty($_POST['vendor_name'])) {
        $vendor_name = $_POST['vendor_name'];
//        check if valid string $vendor_name
        $vendor_name = $utils->cleanString($vendor_name);
    } else {
        $responses->warningInput('Vendor Name is required');
    }

    if (isset($_POST['active']) && !empty($_POST['active'])) {
        $active = $_POST['active'];
//        class if number
    }

    if (isset($_POST['vendor_email']) && !empty($_POST['vendor_email'])) {
        $vendor_email = $_POST['vendor_email'];
//        class if email address
        $vendor_email = $utils->cleanString($vendor_email);
    } else {
        $responses->warningInput('Vendor Email is required');
    }

    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
//        check if number
    } else {
        $responses->warningInput('Select User is required');
    }
    return array($vendor_name, $active, $vendor_email, $user_id);
}