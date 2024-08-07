<?php
session_start();
require_once '../../Services/UserService.php';
$user = new Services\UserService();

if ($user->is_logged_in()) {
    $user->redirect('../home-page/index.php');
}

if (isset($_POST['btn-submit'])) {
    $email = $_POST['userName'];

    $stmt = $user->runQuery("SELECT userId FROM Users WHERE userName=:email LIMIT 1");
    $stmt->execute(array(":email" => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() === 1) {
        $id = base64_encode($row['userId']);
        $code = md5(uniqid(rand(), true));

        $stmt = $user->runQuery("UPDATE Users SET activationCode=:token WHERE userName=:email");
        $stmt->execute(array(":token" => $code, "email" => $email));

        $message = "
       Hello , $email
       <br /><br />
       We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore                   this email,
       <br /><br />
       Click Following Link To Reset Your Password 
       <br /><br />
       <a href='../reset-password/index.php?id=$id&code=$code'>click here to reset your password</a>
       <br /><br />
       thank you :)
       ";
        $subject = "Password Reset";

        $user->sendMail($email, $message, $subject);

        $msg = "<div class='alert alert-success'>
     <button class='close' data-dismiss='alert'>&times;</button>
     We've sent an email to $email.
                    Please click on the password reset link in the email to generate new password. 
      </div>";
    } else {
        $msg = "<div class='alert alert-danger'>
     <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry!</strong>  this email not found. 
       </div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
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

    <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Forgot Password</h2>
        <hr/>

        <?php
        if (isset($msg)) {
            echo $msg;
        } else {
            ?>
            <div class='alert alert-info'>
                Please enter your email address. You will receive a link to create a new password via email.!
            </div>
            <?php
        }
        ?>

        <input type="email" class="form-control" placeholder="Email address" name="userName" required/>
        <hr/>
        <button class="btn btn-danger btn-primary" type="submit" name="btn-submit">Generate new Password</button>
        <a href="../register/index.php" class="btn btn-info btn-primary" type="button">Sign Up</a>
        <a href="../login/index.php" class="btn btn-light btn-primary" type="button">Sign In</a>
    </form>

</div> <!-- /container -->
<script src="../bootstrap-4/js/jquery-1.9.1.min.js"></script>
<script src="../bootstrap-4/js/bootstrap.min.js"></script>
</body>
</html>