<?php

require_once(realpath(__DIR__ . '/../../services/UserService.php'));
session_start();

use Services\UserService;
require_once(realpath(__DIR__ . '/../../services/EmailNotificationsService.php'));
session_start();

use Services\EmailNotifications;

$usersService = new UserService();
$user = array();

if ($usersService->is_logged_in()) {
    $usersService->redirect('home.php');
}


if (isset($_POST['btn-signup'])) {

    $user = $_POST;
    $valid = array();

    $user['activationCode'] = $code = md5(uniqid(mt_rand(), true));
    /*$valid['user'] = array();
    $valid['status'] = true;
    $valid['msg'] = "";*/

    $valid = validateRegistrationData($user);

     /*print_r($valid);
     exit();*/

    if ($valid['status'] === 0) {
        $msg = "
        <div class='alert alert-info'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Error !</strong>  " . $valid['msg'] . "
     </div>
     ";
    }

    $user = $valid['user'];

//    print_r($valid['user']);
    /*print_r($valid['status']);*/
//    exit();
    $stmt = $usersService->runQuery("SELECT * FROM Users WHERE userEmail=:userEmail");
    $stmt->execute(array(":userEmail" => $user['userEmail']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $emailExists = $stmt->rowCount();

    $stmt = $usersService->runQuery("SELECT * FROM Users WHERE userName=:userName");
    $stmt->execute(array(":userName" => $user['userName']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $userNameExists = $stmt->rowCount();

    $stmt = $usersService->runQuery("SELECT * FROM Users WHERE nrc=:nrc");
    $stmt->execute(array(":nrc" => $user['nrc']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $nrcExists = $stmt->rowCount();

    $stmt = $usersService->runQuery("SELECT * FROM Users WHERE phone=:phone");
    $stmt->execute(array(":phone" => $user['phone']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $phoneExists = $stmt->rowCount();

    if ($userNameExists > 0) {
        $msg = "
        <div class='alert alert-info'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong> " . $user['userName'] . " Username already exists , Please Try another one
     </div>
     ";
    } elseif ($phoneExists > 0) {
        $msg = "
        <div class='alert alert-info'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong> " . $user['phone'] . " Phone Number already exists , Please Try another one
     </div>
     ";
    } elseif ($nrcExists > 0) {
        $msg = "
        <div class='alert alert-info'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong> " . $user['nrc'] . " NRC already exists , Please Try another one
     </div>
     ";
    } elseif ($emailExists > 0) {
        $msg = "
        <div class='alert alert-info'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong> " . $user['userEmail'] . " Email already exists , Please Try another one
     </div>
     ";
    } else if ($user !== null && $usersService->register($user)) {
        $key = base64_encode($user['userEmail']);
        $id = $key;

        $message = "     
  Hello " . $user['userName'] . ",
  <br /><br />
  Welcome to Infy Enterprise!<br/>
  To complete your registration  please , just click following link<br/>
  <br /><br />
  <a href='https://www.infyenterprise.com/hosting-services/app/verify/index.php?id=$id&code=$code'>Click HERE to Activate :)</a>
  <br/><br />
  Thanks,";

        $subject = "Confirm Registration";



        $emailed = $usersService->sendMail($user['userEmail'], $message, $subject);
        if ($emailed === true) {
//
            $msg = "
 <div class='alert alert-success'>
  <button class='close' data-dismiss='alert'>&times;</button>
  <strong>Success!</strong>  We've emailed " . $user['userEmail'] . ".
                Please click on the confirmation link in the email to create your account. 
   </div>
 ";
            $user = array();
        } else {
            $msg = "
 <div class='alert alert-success'>
  <button class='close' data-dismiss='alert'>&times;</button>
  <strong>Error!</strong>  Failed to email " . $user['userEmail'] . ".
   </div>
 ";
        }

    } else {
        $msg = "
 <div class='alert alert-danger'>
  <button class='close' data-dismiss='alert'>&times;</button>
  <strong>Error!</strong>  
               Sorry , Query could no execute.... 
   </div>
 ";
    }
}

/**
 * @param array $user
 * @param bool $validated
 * @return array
 */
function validateRegistrationData(array $user): array
{
    $valid = array();
    $valid['user'] = array();
    $valid['msg'] = '';
    $valid['status'] = 1;
    if (empty($user['userName'])) {
        $valid['status'] = 0;
        $valid['msg'] = "User Name is required";
        return $valid;
    } else {
        if (!preg_match('/^(?=.*[a-zA-Z]).+$/', $user['userName'])) {
            $valid['msg'] = "User Name. Only letters, No white space allowed";
            $valid['status'] = 0;
            return $valid;
        }
        $user['userName'] = cleanData($user['userName']);
    }

    if (empty($user['firstName'])) {
        $valid['status'] = 0;
        $valid['msg'] = "First Name is required";
        return $valid;
    } else {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $user['firstName'])) {
            $valid['msg'] = "First Name. Only letters and white space allowed";
            $valid['status'] = 0;
            return $valid;
        }
        $user['firstName'] = cleanData($user['firstName']);
    }


    if (empty($user['lastName'])) {
        $valid['status'] = 0;
        $valid['msg'] = "Last Name is required";
        return $valid;
    } else {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $user['lastName'])) {
            $valid['msg'] = "Last Name. Only letters and white space allowed";
            $valid['status'] = 0;
            return $valid;
        }
        $user['lastName'] = cleanData($user['lastName']);
    }

    if (empty($user['userEmail'])) {
        $valid['msg'] = "User Email is required";
        $valid['status'] = 0;
        return $valid;
    } else {
        if (!filter_var($user['userEmail'], FILTER_VALIDATE_EMAIL)) {
            $valid['msg'] = "Invalid Email format";
            $valid['status'] = 0;
            return $valid;
        }
        $user['userEmail'] = cleanData($user['userEmail']);
    }

    if (empty($user['userPassword'])) {
        $valid['msg'] = "User Password is required";
        $valid['status'] = 0;
        return $valid;
    } else {
        if ($user['userPassword'] !== $user['confirmPassword']) {
            $valid['msg'] = "Kindly Confirm Password";
            $valid['status'] = 0;
            return $valid;
        }
        if (!preg_match("/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[_@]).+$/", $user['userPassword'])) {
            $valid['msg'] = "Kindly Confirm Password Has at least one underscore (_) or @ sign, at least one number, and at least one letter";
            $valid['status'] = 0;
            return $valid;
        }
        $user['userPassword'] = $user['userPassword'];
    }


    if (empty($user['phone'])) {
        $valid['msg'] = "User Phone Number is required";
        $valid['status'] = 0;
        return $valid;
    } else {
        if (!preg_match('/^\+?\d+$/', $user['phone'])) {
            $valid['msg'] = "User Phone Number. Only Numbers and white space allowed";
            $valid['status'] = 0;
            return $valid;
        }
        $user['phone'] = cleanData($user['phone']);
    }

    if (empty($user['nrc'])) {
        $valid['msg'] = "User NRC Number is required";
        $valid['status'] = 0;
        return $valid;
    } else {
        if (!preg_match("/^(?=.*\d)(?=.*[\/]).+$/", $user['nrc'])) {
            $valid['msg'] = "NRC: Only Numbers, Letters and white space allowed";
            $valid['status'] = 0;
            return $valid;
        }
        $user['nrc'] = cleanData($user['nrc']);
    }

    if (empty($user['gender'])) {
        $valid['msg'] = "User Gender is required";
        $valid['status'] = 0;
        return $valid;
    } else {
        if ($user['gender'] !== "Male" && $user['gender'] !== "Female") {
            $valid['msg'] = "User Gender is required : " . $user['gender'];
            $valid['status'] = 0;
            return $valid;
        }
        $user['gender'] = cleanData($user['gender']);
    }


    $valid['status'] = 1;
    $valid['user'] = $user;
    $valid['msg'] = "Everything Looks Good";
    return $valid;

}

/**
 * @param $data
 * @return string
 */
function cleanData($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup | Coding Cage</title>
    <!-- Bootstrap -->
    <link href="../bootstrap-4/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../bootstrap-4/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="../assets/styles.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        /*
 * Globals
 */

        /* Links */
        a,
        a:focus,
        a:hover {
            color: #fff;
        }

        /* Custom default button */
        .btn-secondary,
        .btn-secondary:hover,
        .btn-secondary:focus {
            color: #333;
            text-shadow: none; /* Prevent inheritance from `body` */
            background-color: #fff;
            border: .05rem solid #fff;
        }


        /*
         * Base structure
         */

        html,
        body {
            height: 100%;
            background-color: #5c9fbf;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            color: #fff;
            text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
            box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
        }

        .cover-container {
            max-width: 42em;
        }


        /*
         * Header
         */
        .masthead {
            margin-bottom: 2rem;
        }

        .masthead-brand {
            margin-bottom: 0;
        }

        .nav-masthead .nav-link {
            padding: .25rem 0;
            font-weight: 700;
            color: rgba(255, 255, 255, .5);
            background-color: transparent;
            border-bottom: .25rem solid transparent;
        }

        .nav-masthead .nav-link:hover,
        .nav-masthead .nav-link:focus {
            border-bottom-color: rgba(255, 255, 255, .25);
        }

        .nav-masthead .nav-link + .nav-link {
            margin-left: 1rem;
        }

        .nav-masthead .active {
            color: #fff;
            border-bottom-color: #fff;
        }

        @media (min-width: 48em) {
            .masthead-brand {
                float: left;
            }

            .nav-masthead {
                float: right;
            }
        }


        /*
         * Cover
         */
        .cover {
            padding: 0 1.5rem;
        }

        .cover .btn-lg {
            padding: .75rem 1.25rem;
            font-weight: 700;
        }

        .form-control {
            color: white;
        }

        /*
         * Footer
         */
        .mastfoot {
            color: rgba(255, 255, 255, .5);
        }
    </style>
    <script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body id="login">
<div class="container">
    <?php if (isset($msg)) {
        echo $msg;
    } ?>
    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <div class="container">
                    <h1 class="display-3 text-primary">Welcome!</h1>
                    <!--<p>This is a template for a simple marketing or informational website. It includes a large
                        callout called a jumbotron and three supporting pieces of content. Use it as a starting
                        point to create something more unique.</p>-->
                    <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">

            <form class="form-signin" method="post">
                <h2 class="form-signin-heading">Sign Up</h2>
                <hr/>
                <input type="text" class="form-control" placeholder="First Name" name="firstName" maxlength="200"
                       required
                       value="<?php echo $user['firstName'] ?>"/>
                <input type="text" class="form-control" placeholder="Last Name" name="lastName" maxlength="200" required
                       value="<?php echo $user['lastName'] ?>"/>
                <input type="text" class="form-control" placeholder="Username" name="userName" maxlength="200" required
                       value="<?php echo $user['userName'] ?>"/>
                <input type="email" class="form-control" placeholder="Email address" name="userEmail" maxlength="250"
                       required
                       value="<?php echo $user['userEmail'] ?>"/>
                <input type="password" class="form-control" placeholder="Password" name="userPassword" maxlength="100"
                       required
                       value="<?php echo $user['userPassword'] ?>"
                />
                <input type="password" class="form-control" placeholder="Confirm Password" name="confirmPassword"
                       maxlength="100" required
                       value="<?php echo $user['confirmPassword'] ?>"
                />
                <input type="text" class="form-control" placeholder="NRC" name="nrc" required
                       value="<?php echo $user['nrc'] ?>"/>
                <input type="text" class="form-control" placeholder="Phone" name="phone" required
                       value="<?php echo $user['phone'] ?>"/>
                <select type="text" class="form-control" placeholder="Gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php echo $user['gender'] === 'Male' ? "selected" : ""; ?>>Male</option>
                    <option value="Female" <?php echo $user['gender'] === 'Female' ? "selected" : ""; ?>>Female</option>
                </select>
                <hr/>
                <button class="btn btn-block btn-primary" type="submit" name="btn-signup">Sign Up</button>
                <a href="../login/index.php" style="float:right;" class="btn btn-block">Sign In</a>
            </form>
        </div>
    </div>

</div> <!-- /container -->
<script src="../vendors/jquery-1.9.1.min.js"></script>
<script src="../bootstrap-4/js/bootstrap.min.js"></script>
</body>
</html>