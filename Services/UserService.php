<?php

namespace Services;

require_once(realpath(__DIR__ . '/../Database/LocalDatabase.php'));

use PHPMailer\PHPMailer\PHPMailer;
use Database\LocalDatabase;
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

    /**
     * @param string $sql
     * @return false|\PDOStatement
     */
    public function runQuery(string $sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    /**
     * @return false|string
     */
    public function lastID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }

    /**
     * @param array $user
     * @return false|\PDOStatement|void
     */
    public function register(array $user)
    {
        try {
            $user['userPassword'] = md5($user['userPassword']);
            $stmt = $this->conn->prepare("INSERT INTO Users(userName,userEmail,nrc,gender,phone,firstName,lastName,userPassword, activationCode) 
                                                VALUES(:userName, :userEmail, :nrc, :gender, :phone,:firstName,:lastName,:userPassword,:activationCode)");
            $stmt->bindparam(":userName", $user['userName']);
            $stmt->bindparam(":userEmail", $user['userEmail']);
            $stmt->bindparam(":nrc", $user['nrc']);
            $stmt->bindparam(":gender", $user['gender']);
            $stmt->bindparam(":phone", $user['phone']);
            $stmt->bindparam(":firstName", $user['firstName']);
            $stmt->bindparam(":lastName", $user['lastName']);
            $stmt->bindparam(":userPassword", $user['userPassword']);
            $stmt->bindparam(":activationCode", $user['activationCode']);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * @param array $user
     * @return bool|void
     */
    public function login(array $user)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Users WHERE userEmail=:userEmail");
            $stmt->execute(array(":userEmail" => $user['userEmail']));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['isLoggedIn'] = false;
            if ($stmt->rowCount() === 1) {
                if ($userRow['userStatus'] == "Y") {
                    if ($userRow['userPassword'] === md5($upass)) {
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


    /**
     * @return bool
     */
    public function is_logged_in(): bool
    {
        if ($_SESSION['isLoggedIn']) {
            return true;
        }
        return false;
    }

    /**
     * @param $url
     * @return void
     */
    public function redirect($url): void
    {
        header("Location: $url");
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
//        $_SESSION['userSessionId'] = false;
    }

    /**
     * @throws Exception
     */
    public function sendMail($email, $message, $subject): bool
    {
        try{
            require_once(realpath(__DIR__ . '/../mailer/src/Exception.php'));
            require_once(realpath(__DIR__ . '/../mailer/src/PHPMailer.php'));
            require_once(realpath(__DIR__ . '/../mailer/src/SMTP.php'));
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Host = "smtp.titan.email";
            $mail->Port = 465;
            $mail->AddAddress($email);
            $mail->Username = "info@infyenterprise.com";
            $mail->Password = "Mwakezulah2023@";
            $mail->SetFrom('info@infyenterprise.com', 'Infy Enterprise');
            $mail->AddReplyTo("info@infyenterprise.com", "Infy Enterprise");
            $mail->Subject = $subject;
            $mail->MsgHTML($message);
            $mail->Send();
            return true;
        }catch (Exception $ex){

            echo $ex->getMessage();
            return false;

        }

    }
}