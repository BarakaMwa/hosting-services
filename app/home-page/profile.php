<?php
session_start();
require_once '../../Services/UserService.php';
$user_home = new Services\UserService();

if (!$user_home->is_logged_in()) {
    $user_home->redirect('../logout/index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM Users WHERE userId=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSessionId']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>