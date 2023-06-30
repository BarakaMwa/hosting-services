<?php
//todo validation
const Entity = "Cart";
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
    $cart = $database->cart;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;

//    todo: for testing

    try {
        updatingCartEdit($db, $cart, $response, $responses, $data);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity );
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $cart_Id
 * @param PDO|null $db
 * @param array $data
 * @return array
 */
function checkIfPostValuesAreSetAndEdit(int $cart_Id, ?PDO $db, array $data): array
{
    $database = new Database();
    $cart = $database->cart;
    $sql = $cart->getById($cart_Id);
    $result = $database->runSelectOneQuery($sql, $db);

//    todo for testing

    $active = $result['active'];
    if (isset($data['active']) && !empty($data['active'])) {
        $active = $data['active'];
    }

    $user_id = $result['user_id'];
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
    }

    return array("product_id" => (int)$product_id, "active" => (int)$active, "quantity" => (double) $quantity, "user_id" => (int)$user_id);
}


/**
 * @param PDO|null $db
 * @param Cart $cart
 * @param array $response
 * @param Responses $responses
 * @param array $data
 * @return void
 * @throws JsonException
 */
function updatingCartEdit(?PDO $db, Cart $cart, array $response, Responses $responses, array $data): void
{
    $database = new Database();
    $result = array();
    if (isset($data['id']) && !empty($data['id'])) {
        $cart_Id = $data['id'];

        $result = checkIfPostValuesAreSetAndEdit($cart_Id, $db, $data);

//        todo for testing

        $sql = $cart->updateCart((int)$result['user_id'], (int)$result['product_id'], (float)$result['quantity'], (int)$result['active'], (int)$cart_Id);


        $database->runQuery($sql, $db);

    } else {
        $responses->errorInvalidRequest($response);
    }

//    todo encrypt
    /* foreach ($result as $row) {
         $encrypted = encrypt($row['cart_id'],$ciphering,$encryption_iv,$options);
         $row["cart_id"] = $encrypted;
         $row["0"] = $encrypted;
     }*/

    $responses->successDataUpdated($response, $result, Entity);
}


