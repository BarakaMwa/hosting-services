<?php

require_once '../headers-api.php';
require_once '../../services/UserService.php';
require_once '../../constants/Utils.php';
require_once '../../services/DevicesService.php';
require_once '../../services/TrusteesService.php';

session_start();

use Services\UserService;
use Services\DevicesService;
use Services\TrusteesService;
use Constants\Utils;

$userService = new Services\UserService();
$response = array();
$status = false;
$utils = new Constants\Utils();
$deviceService = new Services\DevicesService();
$trusteeService = new Services\TrusteesService();

if ($userService->is_logged_in()) {
    $response['status'] = "success";
    $response['success'] = true;
    $response['message'] = "Logged In";

    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($userService->login($email, $password)) {

        $userDetails = $userService->getUserDetailsByEmail($email);
        $userLogins = $userService->getUserLogins($email);
        $userDevices = $deviceService->getAllByUserId((int)$userLogins['userId']);
        $userDevicesSize = $deviceService->getTotalByUserId((int)$userLogins['userId']);
        $userTopDevices = $deviceService->getTopByUserId((int)$userLogins['userId'],5);
        $userTrustees = $trusteeService->getAllByUserId((int)$userLogins['userId']);
        $userTrusteesSize = $trusteeService->getTotalByUserId((int)$userLogins['userId']);
        $userTopTrustees = $trusteeService->getTopByUserId((int)$userLogins['userId'],5);

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
} else {
    $response["success"] = false;
    $response["status"] = "error";
    $response["message"] = "Invalid Request";
}
echo json_encode($response, JSON_THROW_ON_ERROR);
exit();
