<?php
session_start();
require_once '../class.user.php';
$user = new USER();
$response = array();
$status = false;

if ($user->is_logged_in() != "") {
    $response["message"] = "Logging You In";
    $response["status"] = true;
    return json_encode($response, JSON_THROW_ON_ERROR);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['txtemail'];

    $stmt = $user->runQuery("SELECT userID FROM tbl_users WHERE userEmail=:email LIMIT 1");
    $stmt->execute(array(":email" => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1) {
        $id = base64_encode($row['userID']);
        $code = md5(uniqid(rand(), true));

        $stmt = $user->runQuery("UPDATE tbl_users SET tokenCode=:token WHERE userEmail=:email");
        $stmt->execute(array(":token" => $code, "email" => $email));

        $message = "Hello , $email
       <br /><br />
       We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore                   this email,
       <br /><br />
       Click Following Link To Reset Your Password 
       <br /><br />
       <a href='../reset-password/index.php?id=$id&code=$code'>click here to reset your password</a>
       <br /><br />
       thank you :)";
        $subject = "Password Reset";
        $user->send_mail($email, $message, $subject);

        $msg = "We've sent an email to $email. Please click on the password reset link in the email to generate new password.";

        $response['status'] = true;
        $response['message'] = $msg;
    } else {
        $msg = "Sorry! this email not found.";
        $response['status'] = false;
        $response['message'] = $msg;
    }
    return json_encode($response, JSON_THROW_ON_ERROR);
} else {
    $response["message"] = "Invalid Request";
    $response["status"] = false;
    return json_encode($response, JSON_THROW_ON_ERROR);
}
?>

<!-- <!DOCTYPE html>
<html> -->
<!--<head>-->
<!--    <title>Forgot Password</title>-->
<!--    <!-- Bootstrap -->-->
<!--    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">-->
<!--    <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">-->
<!--    <link href="../assets/styles.css" rel="stylesheet" media="screen">-->
<!--    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->-->
<!--    <!--[if lt IE 9]>-->
<!--    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>-->
<!--    <![endif]-->-->
<!--</head>-->
<!--<body id="login">-->
<!--<div class="container">-->
<!---->
<!--    <form class="form-signin" method="post">-->
<!--        <h2 class="form-signin-heading">Forgot Password</h2>-->
<!--        <hr/>-->
<!---->
<!--        --><?php
//        if (isset($msg)) {
//            echo $msg;
//        } else {
//            ?>
<!--            <div class='alert alert-info'>-->
<!--                Please enter your email address. You will receive a link to create a new password via email.!-->
<!--            </div>-->
<!--            --><?php
//        }
//        ?>
<!---->
<!--        <input type="email" class="form-control" placeholder="Email address" name="txtemail" required/>-->
<!--        <hr/>-->
<!--        <button class="btn btn-danger btn-primary" type="submit" name="btn-submit">Generate new Password</button>-->
<!--        <a href="../register/index.php" class="btn btn-info btn-primary" type="button">Sign Up</a>-->
<!--        <a href="../login/index.php" class="btn btn-light btn-primary" type="button">Sign In</a>-->
<!--    </form>-->
<!---->
<!--</div> <!-- /container -->-->
<!--<script src="../bootstrap/js/jquery-1.9.1.min.js"></script>-->
<!--<script src="../bootstrap/js/bootstrap.min.js"></script>-->
<!--</body>-->
<!--</html>-->