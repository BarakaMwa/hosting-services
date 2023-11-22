<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
require_once '../../../connection.php';
//require_once '../../../connection-local.php';

require_once '../../../errors/Responses.php';

$response = array();
$responses = new Responses();
$status = false;
const CART = "Carts";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $result = array();
    $database = new LocalDatabase();
    $db = $database->dbConnection();
    $cart = $database->cart;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = $_POST;

//    todo: for testing

    $cart_Id = 0;
    try {

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $cart_Id = $_POST['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }
        $cart->cart_id = $cart_Id;

        updatingCartDelete($db, $cart, $response, $responses, $data);

    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, Entity);
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $cart_Id
 * @param PDO|null $db
 * @param array $data
 * @return array
 * @throws JsonException
 */
function
checkIfPostValuesAreSetAndDeactivate(int $cart_Id, ?PDO $db, array $data): array
{
    $database = new LocalDatabase();
    $cart = $database->cart;
    $sql = $cart->getById($cart_Id);
    $result = $database->runSelectOneQuery($sql, $db);

//    todo for testing

    (int)$active = $result['active'];
    if ($active === 0 || $active === false) {
        $responses = new Responses();
        $response = array();
        $responses->warningAlreadyDeleted($response, $result, Entity);
    }
    $active = 0;

    $user_id = $result['user_id'];
    if (isset($data['user_id']) && !empty($data['user_id'])) {
        $user_id = $data['user_id'];
    }

    $productId = $result['productId'];
    if (isset($data['productId']) && !empty($data['productId'])) {
        $productId = $data['productId'];
    }

    $quantity = $result['quantity'];
    if (isset($data['quantity']) && !empty($data['quantity'])) {
        $quantity = $data['quantity'];
    }

    return array("productId" => (int)$productId, "active" => (int)$active, "quantity" => (float)$quantity, "user_id" => (int)$user_id, "cart_id" => $cart_Id);
}


/**
 * @param PDO|null $db
 * @param Carts $cart
 * @param array $response
 * @param Responses $responses
 * @param array $data
 * @return void
 * @throws JsonException
 */
function updatingCartDelete(?PDO $db, Carts $cart, array $response, Responses $responses, array $data): void
{
    $result = array();
    if ($cart->cart_id !== null && $cart->cart_id !== 0) {
        $cart_Id = $cart->cart_id;

        $result = checkIfPostValuesAreSetAndDeactivate($cart_Id, $db, $data);

        $sql = $cart->update((int)$result['user_id'], (int)$result['productId'], (float)$result['quantity'], (int)$result['active'], (int)$cart_Id);

        $database = new LocalDatabase();
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

    $responses->successDataDeactivated($response, $result, Entity);
}

