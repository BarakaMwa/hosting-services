<?php

namespace Services;


//require_once '../RemoteDatabase.php';
require_once '../connection-local.php';

use PHPMailer\PHPMailer\PHPMailer;
use App\Database\LocalDatabase;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PDO;

class UserService
{

    private $conn;

    public function __construct()
    {
        $localDatabase = new LocalDatabase();
        $database = $localDatabase;
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

    public function login($email, $upass)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Users WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id" => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['isLoggedIn'] = false;
            if ($stmt->rowCount() == 1) {
                if ($userRow['userStatus'] == "Y") {
                    if ($userRow['userPass'] == md5($upass)) {
                        $_SESSION['userSessionId'] = $userRow['userId'];
                        $_SESSION['isLoggedIn'] = true;
//                        $_SESSION['userType'] = $userRow['userId'];
                        return true;
                    } else {
                        header("Location: ../login/index.php?error");
                        exit;
                    }
                } else {
                    header("Location: ../login/index.php?inactive");
                    exit;
                }
            } else {
                header("Location: ../login/index.php?error");
                exit;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }


    public function is_logged_in()
    {
        if ($_SESSION['isLoggedIn']) {
            return true;
        }
        return false;
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();
//        $_SESSION['userSessionId'] = false;
    }

    function send_mail($email, $message, $subject)
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
}