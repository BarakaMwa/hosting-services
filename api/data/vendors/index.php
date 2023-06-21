<?php

require_once '../../headers-api.php';
session_start();
require_once '../../connection.php';

$response = array();
$status = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST' or $_SERVER['REQUEST_METHOD'] == 'GET') {
    $database = new Database();
    $db = $database->dbConnection();

//    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM `Vendors`";

    $result = runQuery($sql, $db);


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
