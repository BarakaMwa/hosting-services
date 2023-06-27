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

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {


    $result = array();
    $database = new Database();
    $db = $database->dbConnection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    todo: for testing
//    $_POST['id'] = 1;

    try {
        $cart = $database->cart;
        updatingCartDelete($db, $cart, $response, $responses);
    } catch (JsonException $e) {
        $responses->errorUpDating($response, $e, "Cart");
    }

} else {

    $responses->errorInvalidRequest($response);
}

/**
 * @param int $cart_Id
 * @param PDO|null $db
 * @return array
 */
function
checkIfPostValuesAreSetAndDeactivate(int $cart_Id, ?PDO $db): array
{
    $database = new Database();
    $cart = $database->cart;
    $sql = $cart->getById($cart_Id);
    $result = $database->runSelectOneQuery($sql, $db);
//    $result = $result[0];

//    todo for testing
//    echo $result['active'];
    $cart_name = $result['cart_name'];
    if (isset($_POST['cart_name']) && !empty($_POST['cart_name'])) {
        $cart_name = $_POST['cart_name'];
    }

    (int)$active = $result['active'];
    if($active === 0 || $active === false) {
        $responses = new Responses();
        $responses->warningAlreadyDeleted();
    }
    $active = 0;

    $user_id = $result['user_id'];
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    }

    $product_id = $result['product_id'];
    if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
    }

    $quantity = $result['quantity'];
    if (isset($_POST['quantity']) && !empty($_POST['quantity'])) {
        $quantity = $_POST['quantity'];
    }

    return array("product_id" => $product_id, "active" => $active, "quantity" => $quantity, "user_id" => $user_id);
}


/**
 * @param PDO|null $db
 * @param Cart $cart
 * @param array $response
 * @param Responses $responses
 * @return void
 * @throws JsonException
 */
function updatingCartDelete(?PDO $db, Cart $cart, array $response, Responses $responses): void
{
    $result = array();
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $cart_Id = $_POST['id'];

        $result = checkIfPostValuesAreSetAndDeactivate($cart_Id, $db);

        $sql = $cart->updateCart((int)$result['user_id'], (int)$result['product_id'], (float)$result['quantity'], (int)$result['active'], (int)$cart_Id);

        $database = new Database();
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

    $responses->successDataDeactivated($response, $result, "Cart");
}

