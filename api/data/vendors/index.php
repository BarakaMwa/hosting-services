<?php

require_once '../../headers-api.php';
session_start();
require_once '../../connection.php';

$response = array();
$status = false;


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $database = new Database();
    $db = $database->dbConnection();

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM Vendors WHERE vendor_id is not null";

    $result = runQuery()->setFetchMode(PDO::FETCH_ASSOC);


    $response["message"] = "Data Retrieval Success";
    $response["success"] = true;
    $response["status"] = "success";
    $response["data"] = $result;
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();

}else{

    $response["message"] = "Invalid Request";
    $response["success"] = false;
    $response["status"] = "error";
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}

function runQuery($sql, $db)
{
    return $db->prepare($sql);
}
