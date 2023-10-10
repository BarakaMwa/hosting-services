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

$stmt = $user_home->runQuery("SELECT COUNT(userID) as Total FROM tbl_users");
$stmt->execute();
$user_count = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $user_home->runQuery("SELECT COUNT(product_id) as Total FROM products");
$stmt->execute();
$product_count = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $user_home->runQuery("SELECT COUNT(invoice_id) as Total FROM invoices");
$stmt->execute();
$invoice_count = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $user_home->runQuery("SELECT SUM(amount) as Total FROM payments");
$stmt->execute();
$total_payments = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $user_home->runQuery("SELECT SUM(amount) as Total FROM payments");
$stmt->execute();
$total_payments = $stmt->fetch(PDO::FETCH_ASSOC);

$page_index = "active"
?>

<!DOCTYPE html>
<html class="">

<head>
    <title>Hosted Services<?php echo $row['userName']; ?></title>
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
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col-12">
                        <h3 class="page-title">Welcome <?php echo $row['userName']; ?>!</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
<span class="dash-widget-icon bg-primary">
<i class="far fa-user"></i>
</span>
                                <div class="dash-widget-info">
                                    <h3><?php echo $user_count["Total"]?></h3>
                                    <h6 class="text-muted">Users</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
<span class="dash-widget-icon bg-primary">
<i class="fas fa-user-shield"></i>
</span>
                                <div class="dash-widget-info">
                                    <h3><?php echo $product_count["Total"]?></h3>
                                    <h6 class="text-muted">Products</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
<span class="dash-widget-icon bg-primary">
<i class="fas fa-qrcode"></i>
</span>
                                <div class="dash-widget-info">
                                    <h3><?php echo $invoice_count["Total"]?></h3>
                                    <h6 class="text-muted">Invoices</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
<span class="dash-widget-icon bg-primary">
<i class="far fa-credit-card"></i>
</span>
                                <div class="dash-widget-info">
                                    <h3>K<?php echo $total_payments["Total"]?></h3>
                                    <h6 class="text-muted">Payments</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 d-flex">

                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Recent Payments</h4>
                        </div>
                        <div class="card-body">
<!--                            last five payments-->
                            <?php include "last_five_payments.php"?>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 d-flex">

                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h4 class="card-title">Newest Products</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
<!--                                newest_products-->
                                <?php include "five_newest_products.php"?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>