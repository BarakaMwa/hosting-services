<?php
session_start();
require_once '../class.user.php';
$user_home = new USER();

if (!$user_home->is_logged_in()) {
    $user_home->redirect('../logout/index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$page_index = "active"
?>

<!DOCTYPE html>
<html class="">

<head>
    <title>Hosted Services<?php echo $row['userEmail']; ?></title>
    <?php include_once "stylesheets.css.php" ?>

    <?php include_once "javascript.js.php" ?>

</head>

<body>
<div class="main-wrapper">
    <div class="header">
        <?php include_once "header.php" ?>
    </div>
    <div class="sidebar" id="sidebar">
        <?php include_once "sidebar.php" ?>
    </div>
    <div class="page-wrapper">

    </div>
</div>

</body>

</html>