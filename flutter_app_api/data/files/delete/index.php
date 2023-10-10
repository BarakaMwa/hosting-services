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
const Entity = "File";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $file = $database->file;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;

//    todo: for testing

    $fileId = 0;
    try {

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $fileId = $_POST['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }
        $file->file_id = $fileId;

        updatingImageDelete($db, $file, $response, $responses, $data);

    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $fileId
 * @param PDO|null $db
 * @param array $data
 * @return array
 * @throws JsonException
 */
function
checkIfPostValuesAreSetAndDeactivate(int $fileId, ?PDO $db, array $data): array
{
    $database = new Database();
    $file = $database->file;
    $sql = $file->getById($fileId);
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
 * @param File $file
 * @param array $response
 * @param Responses $responses
 * @param array $data
 * @return void
 * @throws JsonException
 */
function updatingImageDelete(?PDO $db, File $file, array $response, Responses $responses, array $data): void
{
    $result = array();
    if ($file->file_id !== null && $file->file_id !== 0) {
        $file_Id = $file->file_id;

        $result = checkIfPostValuesAreSetAndDeactivate($file_Id, $db, $data);

        $sql = $file->update((string)$result['file_blob'], (int)$result['file_size'],
            (string)$result['file_link'], (string)$result['file_type'],
            (string)$result['file_name'], (int)$result['active'], (int)$file_Id);

        $database = new Database();
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

    $responses->successDataDeactivated($response, $result, Entity);
}

