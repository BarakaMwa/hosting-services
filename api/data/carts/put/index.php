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
$responses = new Responses();
const Entity = "Carts";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = array();
    $database = new LocalDatabase();
    $db = $database->dbConnection();
    $cart = $database->cart;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;

    try {
        $result = insertingCartEdit($db, $cart, $data);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

    $responses->successDataInsert($response, $result, Entity);

} else {
    $responses->errorInvalidRequest($response);
}

/**
 * @param PDO|null $db
 * @param Carts $cart
 * @param array $data
 * @return array
 * @throws JsonException
 */
function insertingCartEdit(?PDO $db, Carts $cart, array $data): array
{
    $database = new LocalDatabase();

    $result = checkIfPostValuesAreSetAndInsert($data);

    $sql = $cart->insert($result);

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
    (float)$quantity = $data["quantity"];
    $active = 1;
    $user_id = $data["user_id"];
    $productId = $data["productId"];

    [$quantity, $active, $productId, $user_id] = checkPostInputs((float)$quantity, $utils, $responses, $active, (int)$productId, (int)$user_id);

    return array("quantity" => $quantity, "active" => $active, "productId" => $productId, "user_id" => $user_id);
}

/**
 * @param float $quantity
 * @param Utils $utils
 * @param Responses $responses
 * @param int $active
 * @param int $productId
 * @param int $user_id
 * @return array
 * @throws JsonException
 */
function checkPostInputs(float $quantity, Utils $utils, Responses $responses, int $active, int $productId, int $user_id): array
{
    if (isset($_POST['productId']) && !empty($_POST['productId'])) {
        (string)$productId = $_POST['productId'];
//        check if valid string $cart_name
        $productId = $utils->cleanString($productId);
    } else {
        $responses->warningInput('Products is required');
    }

    if (isset($_POST['active']) && !empty($_POST['active'])) {
        $active = $_POST['active'];
//        class if number
    }

    if (isset($_POST['quantity']) && !empty($_POST['quantity'])) {
        (string)$quantity = $_POST['quantity'];
//        class if email address
        $quantity = $utils->cleanString($quantity);
    } else {
        $responses->warningInput('Quantity is required');
    }

    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
//        check if number
    } else {
        $responses->warningInput('User is required');
    }
    return array((float)$quantity, (int)$active, (int)$user_id, (int)$productId);
}