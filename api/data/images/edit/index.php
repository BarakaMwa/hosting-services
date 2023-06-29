<?php
//todo validation
const Entity = "Image";
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';
require_once '../../../errors/Responses.php';

$response = array();
$status = false;
$responses = new Responses();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $image = $database->image;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;

//    todo: for testing

    try {
        updatingImageEdit($db, $image, $response, $responses, $data);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $image_Id
 * @param PDO|null $db
 * @param array $data
 * @return array
 * @throws JsonException
 */
function checkIfPostValuesAreSetAndEdit(int $image_Id, ?PDO $db, array $data): array
{
    $database = new Database();
    $image = $database->image;
    $sql = $image->getById($image_Id);
    $result = $database->runSelectOneQuery($sql, $db);

//    todo for testing

    (int)$active = $result['active'];
    if (isset($data['active']) && !empty($data['active'])) {
        $active = $data['active'];
    }

    (int)$vendor_id = $result['vendor_id'];
    if (isset($data['vendor_id']) && !empty($data['vendor_id'])) {
        $vendor_id = $data['vendor_id'];
    }

    $image_type = $result['image_type'];
    if (isset($data['image_type']) && !empty($data['image_type'])) {
        $image_type = $data['image_type'];
    }

    (int)$image_size = $result['image_size'];
    if (isset($data['image_size']) && !empty($data['image_size'])) {
        $image_size = $data['image_size'];
    }

    $image_blob = $result['image_blob'];
    if (isset($data['image_blob']) && !empty($data['image_blob'])) {
        $image_blob = $data['image_blob'];
    }

    $image_link = $result['image_link'];
    if (isset($data['image_link ']) && !empty($data['image_link'])) {
        $image_link = $data['image_link'];
    }

    (int)$product_id = $result['product_id'];
    if (isset($data['product_id']) && !empty($data['product_id'])) {
        $product_id = $data['product_id'];
    }

    $image_name = $result['image_name'];
    if (isset($data['image_name']) && !empty($data['image_name'])) {
        $image_name = $data['image_name'];
    }

    return array("image_name" => $image_name, "image_type" => $image_type, "image_size" => $image_size, "image_blob" => $image_blob, "active" => $active, 'image_link' => $image_link, "product_id" => $product_id, "vendor_id" => $vendor_id);
}


/**
 * @param PDO|null $db
 * @param Image $image
 * @param array $response
 * @param Responses $responses
 * @param array $data
 * @return void
 * @throws JsonException
 */
function updatingImageEdit(?PDO $db, Image $image, array $response, Responses $responses, array $data): void
{
    $database = new Database();
    $result = array();
    if (isset($data['id']) && !empty($data['id'])) {
        $image_Id = $data['id'];

        $result = checkIfPostValuesAreSetAndEdit($image_Id, $db, $data);

//        todo for testing

        $sql = $image->updateImage((string)$result['image_blob'], (int)$result['image_size'], (string)$result['image_link'], (string)$result['image_type'], (string)$result['image_name'], (int)$result['active'], (int)$image_Id);


        $database->runQuery($sql, $db);

    } else {
        $responses->errorInvalidRequest($response);
    }

//    todo encrypt
    /* foreach ($result as $row) {
         $encrypted = encrypt($row['image_id'],$ciphering,$encryption_iv,$options);
         $row["image_id"] = $encrypted;
         $row["0"] = $encrypted;
     }*/

    $responses->successDataUpdated($response, $result, Entity);
}


