<?php
//todo validation
/*$ciphering ="";
$encryption_iv ="";
$options ="";*/
require_once '../../../headers-api.php';
session_start();
require_once '../../../connection.php';
//require_once '../../../connection-local.php';
//require_once '../../Cipher.php';
//require_once '../vendor.php';

$response = array();
$status = false;
$vendor = new Vendor();


if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {

    $database = new Database();
    $db = $database->dbConnection();
//    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    todo: for testing
    $_POST['id'] = 5;

    $vendor_Id = 0;
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $vendor_Id = $_POST['id'];
    }

    $result = checkIfPostValuesAreSet($vendor_Id, $db);

    $sql = $vendor->updateVendor((int)$result['user_id'], (string)$result['vendor_name'], (string)$result['vendor_email'], (bool) $result['active'], $vendor_Id);

    $result = $vendor->runUpdateQuery($sql, $db);

    /* foreach ($result as $row) {
         $encrypted = encrypt($row['vendor_id'],$ciphering,$encryption_iv,$options);
         $row["vendor_id"] = $encrypted;
         $row["0"] = $encrypted;
     }*/

    $response["message"] = "Data Removal Success";
    $response["success"] = true;
    $response["status"] = "success";
    $response["data"] = $result;
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();

} else {

    $response["message"] = "Invalid Request";
    $response["success"] = false;
    $response["status"] = "error";
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}

/**
 * @param int $vendor_Id
 * @param PDO|null $db
 * @return array
 */
function checkIfPostValuesAreSet(int $vendor_Id, ?PDO $db): array
{
    $vendor = new Vendor();
    $sql = $vendor->getAllById($vendor_Id);
    $result = $vendor->runSelectAllQuery($sql, $db);
    $result = $result[0];
//    echo $result['active'];
    $vendor_name = $result['vendor_name'];
    if (isset($_POST['vendor_name']) && !empty($_POST['vendor_name'])) {
        $vendor_name = $_POST['vendor_name'];
    }

    (bool)$active = $result['active'];
    if (isset($_POST['active']) && !empty($_POST['active'])) {
        $active = $_POST['active'];
    }

    $vendor_email = $result['vendor_email'];
    if (isset($_POST['vendor_email']) && !empty($_POST['vendor_email'])) {
        $vendor_email = $_POST['vendor_email'];
    }

    $user_id = $result['user_id'];
    if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
    }

    return array("vendor_name" => $vendor_name, "active" => $active, "vendor_email" => $vendor_email, "user_id" => $user_id);
}