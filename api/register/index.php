<?php
session_start();
require_once '../class.user.php';

$reg_user = new USER();

if ($reg_user->is_logged_in() != "") {
    $response['status'] = "success";
    $response['success'] = true;
    $response['message'] = "Logged In";
//    $user_login->redirect('../home-page/index.php');
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}


if (isset($_POST['btn-signup'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $code = md5(uniqid(rand(), true));

    $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
    $stmt->execute(array(":email_id" => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        $msg = "Sorry !email already exists , Please Try another one";

        $response["success"] = false;
        $response["status"] = "error";
        $response["message"] = $msg;
        echo json_encode($response, JSON_THROW_ON_ERROR);
        exit();
    } else {
        if ($reg_user->register($username, $email, $password, $code)) {
            $id = $reg_user->lasdID();
            $key = base64_encode($id);
            $id = $key;
            $href="https://www.infyenterprise.com/hosting-services/users/verify/index.php?id=".$id."&code=".$code;

            $message = "     
      Hello $username,
      <br /><br />
      Welcome to Infy Enterprise!<br/>
      To complete your registration  please , just click following link<br/>
      <br /><br />
      <a href='https://www.infyenterprise.com/hosting-services/users/verify/index.php?id=$id&code=$code'>Click HERE to Activate :)</a>
      <br/><br />
      Thanks,";

            $subject = "Confirm Registration";

            $reg_user->send_mail($email, $message, $subject);

            $msg = "Success! We've sent an email to $email. Please click on the confirmation link in the email to create your account.";
            $response["success"] = true;
            $response["status"] = "success";
            $response["message"] = $msg;
            echo json_encode($response, JSON_THROW_ON_ERROR);
            exit();

        } else {
            $msg = "sorry , Query could no execute...";
            $response["success"] = false;
            $response["status"] = "error";
            $response["message"] = $msg;
            echo json_encode($response, JSON_THROW_ON_ERROR);
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup | Coding Cage</title>
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
    <?php if (isset($msg)) echo $msg; ?>
    <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Sign Up</h2>
        <hr/>
        <input type="text" class="form-control" placeholder="Username" name="txtuname" required/>
        <input type="email" class="form-control" placeholder="Email address" name="txtemail" required/>
        <input type="password" class="form-control" placeholder="Password" name="txtpass" required/>
        <hr/>
        <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
        <a href="../login/index.php" style="float:right;" class="btn btn-large">Sign In</a>
    </form>

</div> <!-- /container -->
<script src="../vendors/jquery-1.9.1.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>