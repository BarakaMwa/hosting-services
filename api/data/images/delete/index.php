<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';

require_once '../../../errors/Responses.php';

$response = array();
$responses = new Responses();
$status = false;
const Entity = "Image";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $image = $database->image;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;

//    todo: for testing

    $imageId = 0;
    try {

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $imageId = $_POST['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }
        $image->image_id = $imageId;

        updatingImageDelete($db, $image, $response, $responses, $data);

    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $imageId
 * @param PDO|null $db
 * @param array $data
 * @return array
 * @throws JsonException
 */
function
checkIfPostValuesAreSetAndDeactivate(int $imageId, ?PDO $db, array $data): array
{
    $database = new Database();
    $image = $database->image;
    $sql = $image->getById($imageId);
    $result = $database->runSelectOneQuery($sql, $db);


//    todo for testing

    $active = $result['active'];

    if ($active === 0 or $active === "0") {
        $responses = new Responses();
        $response = array();
        $responses->warningAlreadyDeleted($response, $result, Entity);
    }
    $result["active"] = 0;

    /*$user_id = $result['user_id'];
    if (isset($data['user_id']) && !empty($data['user_id'])) {
        $user_id = $data['user_id'];
    }

    $product_id = $result['product_id'];
    if (isset($data['product_id']) && !empty($data['product_id'])) {
        $product_id = $data['product_id'];
    }

    $quantity = $result['quantity'];
    if (isset($data['quantity']) && !empty($data['quantity'])) {
        $quantity = $data['quantity'];
    }*/

    return $result;

//    return array("product_id" => (int)$product_id, "active" => (int)$active, "quantity" => (float)$quantity, "user_id" => (int)$user_id);
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
function updatingImageDelete(?PDO $db, Image $image, array $response, Responses $responses, array $data): void
{
    $result = array();
    if ($image->image_id !== null && $image->image_id !== 0) {
        $image_Id = $image->image_id;

        $result = checkIfPostValuesAreSetAndDeactivate($image_Id, $db, $data);

        $sql = $image->updateImage((int)$result['vendor_id'], (int)$result['product_id'], (string)$result['image_blob'], (int)$result['image_size'], (string)$result['image_link'], (string)$result['image_type'], (int)$result['active'], (int)$image_Id);

        $database = new Database();
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

    $responses->successDataDeactivated($response, $result, Entity);
}

