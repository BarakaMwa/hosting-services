<?php
//todo validation
/*$ciphering ="";
$encryption_iv ="";
$options ="";*/
require_once '../../headers-api.php';
session_start();
//require_once '../../connection.php';
require_once '../../connection-local.php';
//require_once '../../Cipher.php';;

$vendor = new Vendor();

$response = array();
$status = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST' or $_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->dbConnection();

//    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $vendor->getGetAll();

//    $_POST['active'] = 1;

    if(isset($_POST["active"]) and !empty($_POST["active"])){

        $active = $_POST["active"];

        $sql = $vendor->getAllByActive($active);
    }

    $result = runQuery($sql, $db);

   /* foreach ($result as $row) {
        $encrypted = encrypt($row['vendor_id'],$ciphering,$encryption_iv,$options);
        $row["vendor_id"] = $encrypted;
        $row["0"] = $encrypted;
    }*/


    $response["message"] = "Data Retrieval Success";
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

function runQuery($sql, $db)
{
    $stmt = $db->prepare($sql);
    $stmt->execute();
//    return $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
}
