<?php
session_start();
require_once '../class.user.php';

$reg_user = new User();

if ($reg_user->is_logged_in() != "") {
    $response['status'] = "success";
    $response['success'] = true;
    $response['message'] = "Logged In";

    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $code = md5(uniqid(rand(), true));

    $stmt = $reg_user->runQuery("SELECT * FROM Users WHERE userEmail=:email_id");
    $stmt->execute(array(":email_id" => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        $msg = "Sorry !email already exists , Please Try another one";

        $response["success"] = false;
        $response["status"] = "error";
    } else if ($reg_user->register($username, $email, $password, $code)) {
        $id = $reg_user->lasdID();
        $key = base64_encode($id);
        $id = $key;

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

    } else {
        $msg = "sorry , Query could no execute...";
        $response["success"] = false;
        $response["status"] = "error";
    }
    $response["message"] = $msg;
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}
?>