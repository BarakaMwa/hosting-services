<?php
//todo validation
/*$ciphering ="";
$encryption_iv ="";
$options ="";*/
require_once '../../../headers-api.php';
session_start();
//require_once '../../../connection.php';
require_once '../../../connection-local.php';
//require_once '../../../Cipher.php';

$response = array();
$status = false;


/**
 * @param array $response
 * @return void
 * @throws JsonException
 */
function invalidRequest(array $response): void
{
    $response["message"] = "Invalid Request";
    $response["success"] = false;
    $response["status"] = "error";
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}

/**
 * @param array $response
 * @param $result
 * @return void
 * @throws JsonException
 */
function dataRetrivalSuccess(array $response, $result): void
{
    $response["message"] = "Data Retrieval Success";
    $response["success"] = true;
    $response["status"] = "success";
    $response["data"] = $result;
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->dbConnection();

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $vendor_id = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {

    } else if (isset($_GET['id']) && !empty($_GET['id'])) {

    } else {
        invalidRequest($response);
    }


    $sql = $vendor->getById($vendor_id);

//    $_POST['active'] = 1;

    if (isset($_POST["active"]) and !empty($_POST["active"])) {

        (int)$active = $_POST["active"];

        $sql = $vendor->getByIdAndActive($active, $vendor_id);
    }

    $result = $vendor->runSelectAllQuery($sql, $db);

    /* foreach ($result as $row) {
         $encrypted = encrypt($row['vendor_id'],$ciphering,$encryption_iv,$options);
         $row["vendor_id"] = $encrypted;
         $row["0"] = $encrypted;
     }*/


    try {
        dataRetrivalSuccess($response, $result);
    } catch (JsonException $e) {
        $response["message"] = "Error Occurred";
        $response["success"] = false;
        $response["status"] = "error";
        $response["data"] = "Error: " . $e->getMessage();
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }

} else {

    try {
        invalidRequest($response);
    } catch (JsonException $e) {
        $response["message"] = "Error Occurred";
        $response["success"] = false;
        $response["status"] = "error";
        $response["data"] = "Error: " . $e->getMessage();
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    }
}


