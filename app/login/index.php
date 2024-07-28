<?php
session_start();
require_once '../../Services/UserService.php';

use Services\UserService;

$userService = new UserService();

if ($userService->is_logged_in()) {
    $userService->redirect('../home-page/index.php');
}

if (isset($_POST['btn-login'])) {
    $userEmail = trim($_POST['userEmail']);

    $user['userEmail'] = $_POST[$userEmail] = $userEmail;

    if ($userService->login($user)) {
        $userService->redirect('../home-page/index.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Coding Cage</title>
    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
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
    <main role="main" class="inner cover">
        <h1 class="cover-heading">Infy Tech Solutions.</h1>
        <p class="lead">Cover is a one-page template for building simple and beautiful home pages. Download, edit the
            text, and add your own fullscreen background photo to make it your own.</p>
        <p class="lead">
            <!--            <a href="#" class="btn btn-lg btn-secondary">Learn more</a>-->
        </p>
        <div class="row">
            <div class="col-lg-8">
                <div class="jumbotron">
                    <div class="container">
                        <h1 class="display-3 text-primary">Welcome!</h1>
                        <p>This is a template for a simple marketing or informational website. It includes a large
                            callout called a jumbotron and three supporting pieces of content. Use it as a starting
                            point to create something more unique.</p>
                        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

                <?php
                if (isset($_GET['inactive'])) {
                    ?>
                    <div class='alert alert-danger'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        <strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it.
                    </div>
                    <?php
                }
                ?>
                <form class="form-signin" method="post">
                    <?php
                    if (isset($_GET['error'])) {
                        ?>
                        <div class='alert alert-warning'>
                            <button class='close' data-dismiss='alert'>&times;</button>
                            <strong>Wrong Details!</strong>
                        </div>
                        <?php
                    }
                    ?>
                    <h2 class="form-signin-heading">Sign In.</h2>
                    <hr/>
                    <input type="email" class="form-control" placeholder="Email Address" name="userEmail" required/>
                    <input type="password" class="form-control" placeholder="Password" name="userPassword" required/>
                    <hr/>
                    <button class="btn btn-block btn-primary" type="submit" name="btn-login">Sign in</button>
                    <br>
                    <a href="../register/index.php" style="float:right;" type="button" role="button"
                       class="btn btn-block btn-info">Sign Up</a>
                    <br>
                    <a href="../forget-password/index.php" class="btn-link btn">Lost your Password ? </a>
                </form>
            </div>
        </div>
    </main>

    <footer class="mastfoot mt-auto">
        <div class="inner">
            <p>Cover template for <a href="https://getbootstrap.com/">Bootstrap</a>, by <a
                        href="https://twitter.com/mdo">@mdo</a>.</p>
        </div>
    </footer>
</div> <!-- /container -->
<script src="../bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/js/custom.js"></script>
</body>
</html>