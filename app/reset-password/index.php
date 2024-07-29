<?php

require_once '../../Services/UserService.php';
$user = new Services\UserService();

if (empty($_GET['id']) && empty($_GET['code'])) {
    $user->redirect('index.php');
}

if (isset($_GET['id'], $_GET['code'])) {
    $id = base64_decode($_GET['id']);
    $code = $_GET['code'];

    $stmt = $user->runQuery("SELECT * FROM Users WHERE userId=:uid AND activationCode=:token");
    $stmt->execute(array(":uid" => $id, ":token" => $code));
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 1) {
        if (isset($_POST['btn-reset-pass'])) {
            $pass = $_POST['pass'];
            $cpass = $_POST['confirm-pass'];

            if ($cpass !== $pass) {
                $msg = "<div class='alert alert-warning>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Sorry!</strong>  Password Doesn't match. 
      </div>";
            } else {
                $stmt = $user->runQuery("UPDATE Users SET userPass=:upass WHERE userId=:uid");
                $stmt->execute(array(":upass" => $cpass, ":uid" => $rows['userId']));

                $msg = "<div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      Password Changed.
      </div>";
                header("refresh:5;index.php");
            }
        }
    } else {
        exit;
    }


}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <!-- Bootstrap -->
    <link href="../bootstrap-4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../bootstrap-4/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="../assets/styles.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body id="login">
<div class="container">
    <div class='alert alert-success'>
        <strong>Hello !</strong> <?php echo $rows['userName'] ?> you are here to reset your forgotten password.
    </div>
    <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Password Reset.</h3>
        <hr/>
        <?php
        if (isset($msg)) {
            echo $msg;
        }
        ?>
        <input type="password" class="form-control" placeholder="New Password" name="pass" required/>
        <input type="password" class="form-control" placeholder="Confirm New Password" name="confirm-pass" required/>
        <hr/>
        <button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Reset Your Password</button>

    </form>

</div> <!-- /container -->
<script src="../bootstrap-4/js/jquery-1.9.1.min.js"></script>
<script src="../bootstrap-4/js/bootstrap.min.js"></script>
</body>
</html>