<?php
//todo validation
require_once '../../../headers-api.php';
require_once '../../../../Database/LocalDatabase.php';
require_once '../../../../Responses/Responses.php';
session_start();

use Database\LocalDatabase;
use Responses\Responses;

$response = array();
$responses = new Responses();
$status = false;
try {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $result = array();
        $database = new LocalDatabase();
        $db = $database->dbConnection();
        $cartItems = $database->cartItems;
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $data = $_POST;
        $entity = $cartItems->getClassName();
//    todo: for testing
        $cartItemId = 0;

        try {

            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $cartItemId = $_POST['id'];
            }
            /*else {
                $responses->errorInvalidRequest($response);
            }*/
            $cartItems->id = $cartItemId;

            updatingCartDelete($db, $cartItems, $response, $responses, $data, $entity);

        } catch (JsonException $e) {
            $responses->errorUpDating($response, $e, $entity);
        }

    } else {

        $responses->errorInvalidRequest($response);
    }
} catch (Exception $ex) {
    $responses->failedOperation($ex);
}


/**
 * @param int $cart_item_id
 * @param PDO|null $db
 * @param array $data
 * @param string $Entity
 * @return array
 * @throws JsonException
 */
function
checkIfPostValuesAreSetAndDeactivate(int $cart_item_id, ?PDO $db, array $data, string $Entity): array
{
    $database = new LocalDatabase();
    $cartItems = $database->cartItems;
    $sql = $cartItems->getById($cart_item_id);
    $result = $database->runSelectOneQuery($sql, $db);

//    todo for testing

    (int)$active = $result['active'];
    if ($active === 0 || $active === false) {
        $responses = new Responses();
        $response = array();
        $responses->warningAlreadyDeleted($response, $result, $Entity);
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

    return array("productId" => (int)$productId, "active" => (int)$active, "quantity" => (float)$quantity, "user_id" => (int)$user_id, "cart_id" => $$cart_item_id);
}


/**
 * @param PDO|null $db
 * @param Data\Cart_Items $cart_Items
 * @param array $response
 * @param Responses $responses
 * @param array $data
 * @return void
 * @throws JsonException
 */
function updatingCartDelete(?PDO $db, Data\Cart_Items $cart_Items, array $response, Responses $responses, array $data, string $entity): void
{
    $result = array();
    if ($cart_Items->id !== null && $cart_Items->id !== 0) {
        $cart_item_id = $cart_Items->id;

        $result = checkIfPostValuesAreSetAndDeactivate($cart_item_id, $db, $data, $entity);

        $sql = $cart_Items->update((int)$result['user_id'], (int)$result['productId'], (float)$result['quantity'], (int)$result['active'], (int)$cart_item_id);

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

