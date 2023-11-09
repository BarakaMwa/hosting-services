<?php
session_start();
require_once '../services/class.userService.php';
$user = new UserService();
$response = array();

try {
    $user->logout();
    $response["success"] = true;
    $response["status"] = "success";
    $response["message"] = "Logout successful";
    echo json_encode($response, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    $response["success"] = false;
    $response["status"] = "error";
    $response["message"] = "Logout Unsuccessful";
    $response["error"] = $e;
    echo json_encode($response);
}
exit();
