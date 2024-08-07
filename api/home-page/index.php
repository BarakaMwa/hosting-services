<?php
session_start();
require_once '../UserService.php';
$user_home = new UserService();

if (!$user_home->is_logged_in()) {
    $user_home->redirect('../logout/index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM Users WHERE userId=:uid");
$stmt->execute(array(":uid" => $_SESSION['userSessionId']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html class="no-js">

<head>
    <title><?php echo $row['userName']; ?></title>
    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="../assets/styles.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">Member Home</a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i
                                    class="icon-user"></i>
                            <?php echo $row['userName']; ?> <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="../logout/" class="text-danger">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav">
                    <li class="active">
                        <a href="#">Hosted Services</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Tutorials <b class="caret"></b>

                        </a>
                        <ul class="dropdown-menu" id="menu1">
                            <li><a href="https://codingcage.com/search/label/PHP OOP">PHP OOP</a></li>
                            <li><a href="https://codingcage.com/search/label/PDO">PHP PDO</a></li>
                            <li><a href="https://codingcage.com/search/label/jQuery">jQuery</a></li>
                            <li><a href="https://codingcage.com/search/label/Bootstrap">Bootstrap</a></li>
                            <li><a href="https://codingcage.com/search/label/CRUD">CRUD</a></li>
                        </ul>
                    </li>


                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>

<!--/.fluid-container-->
<script src="../bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/scripts.js"></script>

</body>

</html>