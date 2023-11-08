<?php
session_start();
require_once '../class.user.php';
$user = new USER();
$response = array();
$status = false;

if ($user->is_logged_in() != "") {
    $response["message"] = "Logging You In";
    $response["success"] = true;
    $response["status"] = "success";
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['txtemail'];

    $stmt = $user->runQuery("SELECT userID FROM Users WHERE userEmail=:email LIMIT 1");
    $stmt->execute(array(":email" => $email));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() == 1) {
        $id = base64_encode($row['userID']);
        $code = md5(uniqid(rand(), true));

        $stmt = $user->runQuery("UPDATE Users SET tokenCode=:token WHERE userEmail=:email");
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
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();

} else {
    $response["message"] = "Invalid Request";
    $response["success"] = false;
    $response["status"] = "error";
    echo json_encode($response, JSON_THROW_ON_ERROR);
    exit();
}