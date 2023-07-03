<?php

require_once '../headers-api.php';
session_start();
require_once '../class.user.php';
$user_login = new USER();
$response = array();
$status = false;

if ($user_login->is_logged_in() != "") {
    $response['status'] = "success";
    $response['success'] = true;
    $response['message'] = "Logged In";
//    $user_login->redirect('../home-page/index.php');
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($user_login->login($email, $password)) {

        $response["success"] = true;
        $response["status"] = "success";
        $response["message"] = "Login successful";
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
//        $user_login->redirect('../home-page/index.php');
    }

    $response["success"] = false;
    $response["status"] = "error";
    $response["message"] = "Invalid logins";
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
} else {
    $response["success"] = false;
    $response["status"] = "error";
    $response["message"] = "Invalid Request";
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}
