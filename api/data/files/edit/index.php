<?php
//todo validation
const Entity = "Files";
require_once '../../../headers-api.php';
session_start();
require_once '../../../connection.php';
//require_once '../../../LocalDatabase.php';
require_once '../../../errors/Responses.php';

$response = array();
$status = false;
$responses = new Responses();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = array();
    $database = new LocalDatabase();
    $db = $database->dbConnection();
    $file = $database->file;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;

//    todo: for testing

    try {
        updatingImageEdit($db, $file, $response, $responses, $data);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $file_Id
 * @param PDO|null $db
 * @param array $data
 * @return array
 * @throws JsonException
 */
function checkIfPostValuesAreSetAndEdit(int $file_Id, ?PDO $db, array $data): array
{
    $database = new LocalDatabase();
    $file = $database->file;
    $sql = $file->getById($file_Id);
    $result = $database->runSelectOneQuery($sql, $db);

//    todo for testing

    (int)$active = $result['active'];
    if (isset($data['active']) && !empty($data['active'])) {
        $active = $data['active'];
    }

    (int)$vendorId = $result['vendorId'];
    if (isset($data['vendorId']) && !empty($data['vendorId'])) {
        $vendorId = $data['vendorId'];
    }

    $file_type = $result['file_type'];
    if (isset($data['file_type']) && !empty($data['file_type'])) {
        $file_type = $data['file_type'];
    }

    (int)$file_size = $result['file_size'];
    if (isset($data['file_size']) && !empty($data['file_size'])) {
        $file_size = $data['file_size'];
    }

    $file_blob = null;
    if (isset($data['file_blob']) && !empty($data['file_blob'])) {
        $file_blob = $data['file_blob'];
    }

    $file_link = null;
    if (isset($data['file_link']) && !empty($data['file_link'])) {
        $file_link = $data['file_link'];
    }

    (int)$productId = $result['productId'];
    if (isset($data['productId']) && !empty($data['productId'])) {
        $productId = $data['productId'];
    }

    $file_name = $result['file_name'];
    if (isset($data['file_name']) && !empty($data['file_name'])) {
        $file_name = $data['file_name'];
    }

    return array("file_id" => $file_Id, "file_name" => $file_name,
        "file_type" => $file_type, "file_size" => $file_size,
        "file_blob" => $file_blob, "active" => $active,
        "file_link" => $file_link, "productId" => $productId,
        "vendorId" => $vendorId);
}


/**
 * @param PDO|null $db
 * @param Files $file
 * @param array $response
 * @param Responses $responses
 * @param array $data
 * @return void
 * @throws JsonException
 */
function updatingImageEdit(?PDO $db, Files $file, array $response, Responses $responses, array $data): void
{
    $database = new LocalDatabase();
    $result = array();
    if (isset($data['id']) && !empty($data['id'])) {
        $file_Id = $data['id'];

        $result = checkIfPostValuesAreSetAndEdit($file_Id, $db, $data);

//        todo for testing

        $sql = $file->update((string)$result['file_blob'], (int)$result['file_size'],
            (string)$result['file_link'], (string)$result['file_type'],
            (string)$result['file_name'], (int)$result['active'],
            (int)$file_Id);


        $database->runQuery($sql, $db);

    } else {
        $responses->errorInvalidRequest($response);
    }

//    todo encrypt
    /* foreach ($result as $row) {
         $encrypted = encrypt($row['file_id'],$ciphering,$encryption_iv,$options);
         $row["file_id"] = $encrypted;
         $row["0"] = $encrypted;
     }*/

    $responses->successDataUpdated($response, $result, Entity);
}


