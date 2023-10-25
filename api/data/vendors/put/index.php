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
const Entity = "Vendor";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $vendor = $database->vendor;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;

    try {
        $result = insertingVendorEdit($db, $vendor, $data);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

    $responses->successDataInsert($response, $result, Entity);

} else {
    $responses->errorInvalidRequest($response);
}

/**
 * @param PDO|null $db
 * @param Vendor $vendor
 * @param array $data
 * @return array
 * @throws JsonException
 */
function insertingVendorEdit(?PDO $db, Vendor $vendor, array $data): array
{
    $database = new Database();

    $result = checkIfPostValuesAreSetAndInsert($data);

    $sql = $vendor->insert($result);

    $database->runQuery($sql, $db);

    return $result;
}

/**
 * @param array $result
 * @return array
 * @throws JsonException
 */
function checkIfPostValuesAreSetAndInsert(array $result): array
{
//todo for testing
    $responses = new Responses();
    $utils = new Utils();
    $vendor_name = $result['vendor_name'];
    $active = 0;
    $user_id = $result['user_id'];
    $vendor_email = $result['vendor_email'];

//    todo for testing

    [$vendor_name, $active, $vendor_email, $user_id] = checkPostInputs($vendor_name, $utils, $responses, $active, $vendor_email, $user_id);

    return array("vendor_name" => $vendor_name, "active" => $active, "vendor_email" => $vendor_email, "user_id" => $user_id);
}

/**
 * @param string $vendor_name
 * @param Utils $utils
 * @param Responses $responses
 * @param int $active
 * @param string $vendor_email
 * @param int $user_id
 * @return array
 * @throws JsonException
 */
function checkPostInputs(string $vendor_name, Utils $utils, Responses $responses, int $active, string $vendor_email, int $user_id): array
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