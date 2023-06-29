<?php
//todo validation
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';

require_once '../../../errors/Responses.php';

$response = array();
$status = false;
$responses = new Responses();
const Entity = "Cart";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

    $database = new Database();
    $db = $database->dbConnection();
    $cart = $database -> cart;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $cart_id = 0;

    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $cart_id = $_POST['id'];
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            $cart_id = $_GET['id'];
        } else {
            $responses->errorInvalidRequest($response);
        }

        $sql = $cart->getById($cart_id);

        if (isset($_POST["active"]) && !empty($_POST["active"])) {

            (int)$active = $_POST["active"];

            $sql = $cart->getByIdAndActive($active, $cart_id);
        } else if (isset($_GET["active"]) && !empty($_GET["active"])) {

            (int)$active = $_GET["active"];

            $sql = $cart->getByIdAndActive($active, $cart_id);
        }

        $result = $database->runSelectOneQuery($sql, $db);

        /* foreach ($result as $row) {
             $encrypted = encrypt($row['cart_id'],$ciphering,$encryption_iv,$options);
             $row["cart_id"] = $encrypted;
             $row["0"] = $encrypted;
         }*/

        $responses->successDataRetrieved($response, $result, CART );
    } catch (JsonException $e) {
        $responses->errorInsertingData($response, $e, CART);
    }

} else {

        $responses->errorInvalidRequest($response);
}

