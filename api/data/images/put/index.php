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
const Entity = "File";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $file = $database->file;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;

    try {
        $result = insertingImageEdit($db, $file, $data);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

    $responses->successDataInsert($response, $result, Entity);

} else {
    $responses->errorInvalidRequest($response);
}

/**
 * @param PDO|null $db
 * @param File $file
 * @param array $data
 * @return array
 * @throws JsonException
 */
function insertingImageEdit(?PDO $db, File $file, array $data): array
{
    $database = new Database();

    $result = checkIfPostValuesAreSetAndInsert($data);

    $sql = $file->insertNewImage($result);

    $database->runQuery($sql, $db);

    return $result;
}

/**
 * @param $data
 * @return array
 * @throws JsonException
 */
function checkIfPostValuesAreSetAndInsert($data): array
{
//todo for testing
    $responses = new Responses();
    $utils = new Utils();

    $result = checkPostInputs($data, $utils, $responses);

    return array("file_size" => $result["file_size"], "file_name" => $result["file_name"],
        "file_type" => $result["file_type"], "file_blob" => $result["file_blob"],
        "active" => $result["active"], "product_id" => $result["product_id"],
        "file_link" => $result["file_link"], "vendor_id" => $result["vendor_id"]);
}

/**
 * @param array $data
 * @param Utils $utils
 * @param Responses $responses
 * @return array
 * @throws JsonException
 */
function checkPostInputs(array $data, Utils $utils, Responses $responses): array
{

    $active = 1;
    (int)$vendor_id = $data["vendor_id"];
    (int)$product_id = $data["product_id"];
    (string)$file_name = $data["file_name"];
    (string)$file_type = $data["file_type"];
    (string)$file_link = $data["file_link"];
    (string)$file_blob = $data["file_blob"];
    (int)$file_size = $data["file_size"];

    if (isset($data['file_name']) && !empty($data['file_name'])) {
//        class if number
        $file_name = $utils->cleanString($file_name);
    } else {
        $responses->warningInput('Image Name is required');
    }

    if (isset($data['file_type']) && !empty($data['file_type'])) {
//        class if number
        $file_type = $utils->cleanString($file_type);
    } else {
        $responses->warningInput('Image Type is required');
    }

    $file_link = null;
    if (isset($data['file_link']) && !empty($data['file_link'])) {
//        class if number
        $file_link = $utils->cleanString($file_link);
    }

    if (isset($data['file_size']) && !empty($data['file_size'])) {
//        class if number
        $file_size = $utils->cleanString($file_size);
    } else {
        $responses->warningInput('Image Size is required');
    }
    $file_blob = null;
    if (isset($data['file_blob']) && !empty($data['file_blob'])) {
//        class if number
        $file_blob = $utils->cleanString($file_blob);
    }

    if (isset($data['product_id']) && !empty($data['product_id'])) {
//        class if number
        $product_id = $utils->cleanString($product_id);
    } else {
        $responses->warningInput('Product is required');
    }

    if (isset($data['vendor_id']) && !empty($data['vendor_id'])) {
//        class if number
        $vendor_id = $utils->cleanString($vendor_id);
    } else {
        $responses->warningInput('Vendor is required');
    }

    if (isset($data['active']) && !empty($data['active'])) {
        $active = $data['active'];
//        class if number
    }

    return array("file_size" => $file_size, "file_name" => $file_name, "active" => $active,
        "file_type" => $file_type, "file_blob" => $file_blob, "file_link" => $file_link,
        "product_id" => $product_id, "vendor_id" => $vendor_id);
}