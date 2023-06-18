<?php
session_start();
require_once '../class.user.php';
$user_login = new USER();
$response = array();
$status = false;

if ($user_login->is_logged_in() != "") {
    $response['status'] = true;
    $response['message'] = "Logged In";
//    $user_login->redirect('../home-page/index.php');
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}

if ($_SESSION["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['txtemail']);
    $upass = trim($_POST['txtupass']);

    if ($user_login->login($email, $upass)) {

        $response["status"] = true;
        $response["message"] = "Login successful";
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
//        $user_login->redirect('../home-page/index.php');
    }
    $response["status"] = false;
    $response["message"] = "Invalid logins";
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}else{
    $response["status"] = false;
    $response["message"] = "Invalid Requests";
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}
