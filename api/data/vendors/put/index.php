<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';

$response = array();
$status = false;
$vendor = new Vendor();
$responses = new Responses();


if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        insertingVendorEdit($db, $vendor, $response, $responses);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e);
    }
} else {
    $responses->errorInvalidRequest($response);
}

/**
 * @param PDO|null $db
 * @param Vendor $vendor
 * @param array $response
 * @param Responses $responses
 * @return void
 * @throws JsonException
 */
function insertingVendorEdit(?PDO $db, Vendor $vendor, array $response, Responses $responses)
{
    $result = $_POST;

    $result = checkIfPostValuesAreSetAndInsert($result, $db);

    $sql = $vendor->insertNewVendor($result);

    $vendor->runInsertQuery($sql,$db);
}

function checkIfPostValuesAreSetAndInsert(array $result, ?PDO $db)
{

}