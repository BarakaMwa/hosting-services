<?php
session_start();
require_once '../class.user.php';
$user_home = new USER();

if (!$user_home->is_logged_in()) {
    $user_home->redirect('../logout/index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSessionId']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>