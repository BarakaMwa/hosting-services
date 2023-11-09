<?php

require_once '../headers-api.php';
session_start();
require_once '../class.user.php';
require_once '../constants/Utils.php';
require_once '../class.devices.php';
$user_login = new UserService();
$response = array();
$status = false;
$utils = new Utils();
$devices = new Devices();

if ($user_login->is_logged_in() != "") {
    $response['status'] = "success";
    $response['success'] = true;
    $response['message'] = "Logged In";

    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($user_login->login($email, $password)) {

        $userDetails = $user_login->getUserDetailsByEmail($email);
        $userLogins = $user_login->getUserLogins($email);
        $userDevices = $devices->getAllByUserId((int)$userLogins['userID']);
        $userTopDevices = $devices->getTopFiveDevicesByUserId((int)$userLogins['userID']);

        $response["success"] = true;
        $response["status"] = "success";
        $response["message"] = "Login successful";
//        $userDetails['userID'] = $utils->encryptString($userDetails['userID']);
        $response["userId"] = $userLogins['userID'];
        $response["userDetails"] = $userDetails;
        $response["userLogins"] = $userLogins;
        $response["userDevices"] = $userDevices;
        $response["userTopDevices"] = $userTopDevices;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();

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
