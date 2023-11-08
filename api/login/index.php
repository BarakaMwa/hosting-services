<?php

require_once '../headers-api.php';
session_start();
require_once '../class.user.php';
require_once '../constants/Utils.php';
//require_once '../../api/data/Devices.php';
//require_once '../../api/data/Trustees.php';
require_once '../class.devices.php';
require_once '../class.trustees.php';
$user_login = new USER();
$response = array();
$status = false;
$utils = new Utils();
$devices = new Devices();
$trustees = new Trustees();

if ($user_login->is_logged_in() != "") {
    $response['status'] = "success";
    $response['success'] = true;
    $response['message'] = "Logged In";
//    $user_login->redirect('../home/index.php');
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
        $userDevicesSize = $devices->getTotalByUserId((int)$userLogins['userID']);
        $userTopDevices = $devices->getTopByUserId((int)$userLogins['userID'],5);
        $userTrustees = $trustees->getAllByUserId((int)$userLogins['userID']);
        $userTrusteesSize = $trustees->getTotalByUserId((int)$userLogins['userID']);
        $userTopTrustees = $trustees->getTopByUserId((int)$userLogins['userID'],5);

        $response["success"] = true;
        $response["status"] = "success";
        $response["message"] = "Login successful";
//        $userDetails['userID'] = $utils->encryptString($userDetails['userID']);
        $response["userId"] = $userLogins['userID'];
        $response["userDetails"] = $userDetails;
        $response["userLogins"] = $userLogins;
        $response["userDevices"] = $userDevices;
        $response["userDevicesSize"] = $userDevicesSize;
        $response["userTopDevices"] = $userTopDevices;
        $response["userTrustees"] = $userTrustees;
        $response["userTrusteesSize"] = $userTrusteesSize;
        $response["userTopTrustees"] = $userTopTrustees;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
//        $user_login->redirect('../home/index.php');
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
