<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'connection.php';
//require_once 'connection-local.php';

class User
{

    private $conn;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    public function lasdID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }

    public function register($uname, $email, $upass, $code)
    {
        try {
            $password = md5($upass);
            $stmt = $this->conn->prepare("INSERT INTO Users(userName,userEmail,userPass,tokenCode) 
                                                VALUES(:userName, :userEmail, :userPassword, :activeCode)");
            $stmt->bindparam(":userName", $uname);
            $stmt->bindparam(":userEmail", $email);
            $stmt->bindparam(":userPassword", $password);
            $stmt->bindparam(":activeCode", $code);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function registerUserDetails($userEmail, $firstName, $lastName, $nrc, $gender, $phone)
    {
        try {

            $stmt = $this->conn->prepare("INSERT INTO userDetails(userEmail,firstName,lastName,nrc,gender,phone) 
                                                VALUES(:userEmail, :firstName, :lastName, :nrc, :gender, :phone)");
            $stmt->bindparam(":userEmail", $userEmail);
            $stmt->bindparam(":firstName", $firstName);
            $stmt->bindparam(":lastName", $lastName);
            $stmt->bindparam(":nrc", $nrc);
            $stmt->bindparam(":gender", $gender);
            $stmt->bindparam(":phone", $phone);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function login($email, $upass): bool
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Users WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id" => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 1) {
                if ($userRow['userStatus'] == "Y") {
                    if ($userRow['userPass'] == md5($upass)) {
                        $_SESSION['userSessionId'] = $userRow['userId'];
                        return true;
                    } else {
//                        header("Location: ../login/index.php?error");
                        return false;
                    }
                } else {
//                    header("Location: ../login/index.php?inactive");
                    return false;
                }
            } else {
//                header("Location: ../login/index.php?error");
                return false;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public function is_logged_in(): bool
    {
        if (isset($_SESSION['userSessionId'])) {
            return true;
        }
        return false;
    }

    public function redirect($url): void
    {
        header("Location: $url");
    }

    public function logout(): void
    {
        session_destroy();
        $_SESSION['userSessionId'] = false;
    }

    public function send_mail($email, $message, $subject): void
    {


        require 'mailer/src/Exception.php';
        require 'mailer/src/PHPMailer.php';
        require 'mailer/src/SMTP.php';
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Host = "smtp.titan.email";
        $mail->Port = 465;
        $mail->AddAddress($email);
        $mail->Username = "info@infyenterprise.com";
        $mail->Password = "2SU!cwD@j!3.hTX";
        $mail->SetFrom('info@infyenterprise.com', 'Infy Enterprise');
        $mail->AddReplyTo("info@infyenterprise.com", "Infy Enterprise");
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }


    public function get_user_Details($email): array
    {
        $userRow = array();
        try {
            $stmt = $this->conn->prepare("SELECT * FROM userDetails WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id" => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $userRow;
    }


    public function get_user_Logins($email): array
    {
        $userRow = array();
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Users WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id" => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $userRow;
    }


}