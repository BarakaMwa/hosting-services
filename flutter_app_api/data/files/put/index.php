<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
require_once '../../../connection.php';
//require_once '../../../connection-local.php';

require_once '../../../constants/Utils.php';
require_once '../../../errors/Responses.php';


$response = array();
$status = false;
$utils = new Utils();
$responses = new Responses();
const Entity = "Files";
const TARGET_DIR = "../uploads/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = array();
    $database = new LocalDatabase();
    $db = $database->dbConnection();
    $file = $database->file;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;
    $files = $_FILES;
    try {

        $filesData = checkFile($utils, $responses, $files);

        $result = insertingFileEdit($db, $file, $data, $filesData);

    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

    $responses->successDataInsert($response, $result, Entity);

} else {
    $responses->errorInvalidRequest($response);
}

/**
 * @param PDO|null $db
 * @param Files $file
 * @param array $data
 * @return array
 * @throws JsonException
 */
function insertingFileEdit(?PDO $db, Files $file, array $data, array $filesData): array
{
    $database = new LocalDatabase();

    $result = checkIfPostValuesAreSetAndInsert($data, $filesData);

    $sql = $file->insertFile($result);

    $database->runQuery($sql, $db);

    return $result;
}

/**
 * @param array $data
 * @param array $filesData
 * @return array
 * @throws JsonException
 */
function checkIfPostValuesAreSetAndInsert(array $data, array $filesData): array
{
//todo for testing
    $responses = new Responses();
    $utils = new Utils();

    $result = checkPostInputs($data, $utils, $responses, $filesData);

    return array("file_size" => $result["file_size"], "file_name" => $result["file_name"],
        "file_type" => $result["file_type"], "file_blob" => $result["file_blob"],
        "active" => $result["active"], "productId" => $result["productId"],
        "file_link" => $result["file_link"], "vendorId" => $result["vendorId"]);
}

/**
 * @param array $data
 * @param Utils $utils
 * @param Responses $responses
 * @param array $filesData
 * @return array
 * @throws JsonException
 */
function checkPostInputs(array $data, Utils $utils, Responses $responses, array $filesData): array
{

    $active = 1;
    (int)$vendorId = $data["vendorId"];
    (int)$productId = $data["productId"];
    (string)$file_name = $filesData["file_name"];
    (string)$file_type = $filesData["file_type"];
    (string)$file_link = $filesData["file_link"];
    (string)$file_blob = $filesData["file_blob"];
    (int)$file_size = $filesData["file_size"];

    if (isset($filesData['file_name']) && !empty($filesData['file_name'])) {
//        class if number
        $file_name = $utils->cleanString($file_name);
    } else {
        $responses->warningInput('Files Name is required');
    }

    if (isset($filesData['file_type']) && !empty($filesData['file_type'])) {
//        class if number
        $file_type = $utils->cleanString($file_type);
    } else {
        $responses->warningInput('Files Type is required');
    }

    $file_link = null;
    if (isset($filesData['file_link']) && !empty($filesData['file_link'])) {
//        class if number
        $file_link = $utils->cleanString($filesData['file_link']);
    }

    if (isset($filesData['file_size']) && !empty($filesData['file_size'])) {
//        class if number
        $file_size = $utils->cleanString($file_size);
    } else {
        $responses->warningInput('Files Size is required');
    }

    $file_blob = null;
    if (isset($filesData['file_blob']) && !empty($filesData['file_blob'])) {
//        class if number
        $file_blob = $utils->cleanString($filesData['file_blob']);
    }

    if (isset($data['productId']) && !empty($data['productId'])) {
//        class if number
        $productId = $utils->cleanString($productId);
    } else {
        $responses->warningInput('Products is required');
    }

    if (isset($data['vendorId']) && !empty($data['vendorId'])) {
//        class if number
        $vendorId = $utils->cleanString($vendorId);
    } else {
        $responses->warningInput('Vendors is required');
    }

    if (isset($data['active']) && !empty($data['active'])) {
        $active = $data['active'];
//        class if number
    }

    return array("file_size" => $file_size, "file_name" => $file_name,
        "active" => $active, "file_type" => $file_type,
        "file_blob" => $file_blob, "file_link" => $file_link,
        "productId" => $productId, "vendorId" => $vendorId);
}


/**
 * @param Utils $utils
 * @param Responses $responses
 * @param array $files
 * @return array
 * @throws JsonException
 * @throws Exception
 */
function checkFile(Utils $utils, Responses $responses, array $files): array
{
    $newFileName = $utils->generateRandomString(32);
// Check if file already exists
    $fileName = $files["file_upload"]["name"];
    $tempDir = $files["file_upload"]["tmp_name"];
    $newFilePath = TARGET_DIR . basename($fileName);
    $mime_type = mime_content_type($tempDir);
    $fileType = strtolower(pathinfo($newFilePath, PATHINFO_EXTENSION));
// Check file size
    $fileSize = $files["file_upload"]["size"];

    if ($fileSize > 500000) {
        $responses->warningFileInput("Sorry, your file is too large.");
    }

// Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
         && $fileType != "pdf") {
        $responses->warningFileInput("Sorry, only pdf, jpeg, jpg and png files are supported");
    }

    $temp = explode(".", $fileName);
    $newFile = $newFileName . '.' . end($temp);
    $target_file =TARGET_DIR.$newFile;
    $file_content = file_get_contents($tempDir);
    $file_blob = base64_encode($file_content);

    uploadFIle($tempDir, $target_file, $responses);

    return array("file_size" => $fileSize, "file_name" => $newFile, "file_type" => $mime_type, "file_link" => $target_file, "file_blob" => $file_blob);
}

/**
 * @param string $tempDir
 * @param string $target_file
 * @param Responses $responses
 * @return void
 * @throws JsonException
 */
function uploadFIle(string $tempDir, string $target_file, Responses $responses): bool
{
// if everything is ok, try to upload file{
    if (move_uploaded_file($tempDir, $target_file)) {
        return true;
    } else {
        unlink($target_file);
        $responses->warningFileInput("Sorry, there was an error uploading your file.");
    }
}
