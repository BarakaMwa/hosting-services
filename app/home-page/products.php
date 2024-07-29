<?php
session_start();
$products = "active";
?>

<!DOCTYPE html>
<html class="">

<head>
    <title>Hosted Services<?php
        $row = array();
        echo $row['userName']; ?></title>
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
    <div class="page-wrapper" id="app">
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
                                    <h3></h3>
                                    <h6 class="text-muted">All</h6>
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
                                    <h3></h3>
                                    <h6 class="text-muted">Sold</h6>
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
                                    <h3></h3>
                                    <h6 class="text-muted">Out Of Stock</h6>
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
                                    <h3></h3>
                                    <h6 class="text-muted">Deleted</h6>
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
                            <?php include "last_five_payments.php" ?>
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
                                <?php include "five_newest_products.php" ?>
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

<!DOCTYPE html>
<html class="">

<head>
    <title>Hosted Services<?php
        $row = array();
        echo $row['userName']; ?></title>
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
    <div class="page-wrapper" id="app">
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
                                    <h3></h3>
                                    <h6 class="text-muted">All</h6>
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
                                    <h3></h3>
                                    <h6 class="text-muted">Sold</h6>
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
                                    <h3></h3>
                                    <h6 class="text-muted">Out Of Stock</h6>
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
                                    <h3></h3>
                                    <h6 class="text-muted">Deleted</h6>
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
                            <?php include "last_five_payments.php" ?>
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
                                <?php include "five_newest_products.php" ?>
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
