<?php

require_once '../headers-api.php';
session_start();
require_once '../services/class.userService.php';
require_once '../constants/Utils.php';
require_once '../services/class.devicesService.php';
require_once '../services/class.trusteesService.php';
$user_login = new UserService();
$response = array();
$status = false;
$utils = new Utils();
$devices = new DevicesService();
$trustees = new TrusteesService();

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
        $userDevices = $devices->getAllByUserId((int)$userLogins['userId']);
        $userDevicesSize = $devices->getTotalByUserId((int)$userLogins['userId']);
        $userTopDevices = $devices->getTopByUserId((int)$userLogins['userId'],5);
        $userTrustees = $trustees->getAllByUserId((int)$userLogins['userId']);
        $userTrusteesSize = $trustees->getTotalByUserId((int)$userLogins['userId']);
        $userTopTrustees = $trustees->getTopByUserId((int)$userLogins['userId'],5);

        $response["success"] = true;
        $response["status"] = "success";
        $response["message"] = "Login successful";
//        $userDetails['userId'] = $utils->encryptString($userDetails['userId']);
        $response["userId"] = $userLogins['userId'];
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
