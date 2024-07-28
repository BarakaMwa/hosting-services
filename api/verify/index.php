<?php
require_once '../../Services/UserService.php';

use Services\UserService;

$userService = new UserService();

if (empty($_GET['id']) && empty($_GET['code'])) {
    $userService->redirect('index.php');
}

if (isset($_GET['id'], $_GET['code'])) {
    $id = base64_decode($_GET['id']);
    $code = $_GET['code'];
    $active = 1;
    $status = "ACTIVE";

    $stmt = $userService->runQuery("SELECT userId,active,status FROM Users WHERE userEmail=:uId AND activationCode=:code LIMIT 1");
    $stmt->execute(array(":uId" => $id, ":code" => $code));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        if ($row['status'] !== $status) {
            $stmt = $userService->runQuery("UPDATE Users SET active=:active, status=:status WHERE userEmail=:uId");
            $stmt->bindparam(":status", $status);
            $stmt->bindparam(":uId", $id);
            $stmt->bindparam(":active", $active);
            $stmt->execute();

            $msg = "
             <div class='alert alert-success'>
       <button class='close' data-dismiss='alert'>&times;</button>
       <strong>WoW !</strong>  Your Account is Now Activated : <a href='../login/index.php'>Login here</a>
          </div>
          ";
        } else {
            $msg = "
             <div class='alert alert-warning'>
       <button class='close' data-dismiss='alert'>&times;</button>
       <strong>sorry !</strong>  Your Account is already Activated : <a href='../login/index.php'>Login here</a>
          </div>
          ";
        }
    } else {
        $msg = "
         <div class='alert alert-info'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>sorry !</strong>  No Account Found : <a href='signup.php'>Signup here</a>
      <br>
      ".$id."
      <br>
      ".$code."
      </div>
      ";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Confirm Registration</title>
    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="../assets/styles.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body id="login">
<div class="container">
    <?php if (isset($msg)) {
        echo $msg;
    } ?>
</div> <!-- /container -->
<script src="../vendors/jquery-1.9.1.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>