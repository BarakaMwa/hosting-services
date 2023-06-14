<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once './connection.php';

class USER
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

    public function register($uname,$email,$upass,$code)
    {
        try
        {
            $password = md5($upass);
            $stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode) 
                                                VALUES(:user_name, :user_mail, :user_pass, :active_code)");
            $stmt->bindparam(":user_name",$uname);
            $stmt->bindparam(":user_mail",$email);
            $stmt->bindparam(":user_pass",$password);
            $stmt->bindparam(":active_code",$code);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    public function login($email,$upass)
    {
        try
        {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id"=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() == 1)
            {
                if($userRow['userStatus']=="Y")
                {
                    if($userRow['userPass']==md5($upass))
                    {
                        $_SESSION['userSession'] = $userRow['userID'];
                        return true;
                    }
                    else
                    {
                        header("Location: ../login/index.php?error");
                        exit;
                    }
                }
                else
                {
                    header("Location: ../login/index.php?inactive");
                    exit;
                }
            }
            else
            {
                header("Location: ../login/index.php?error");
                exit;
            }
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }


    public function is_logged_in()
    {
        if(isset($_SESSION['userSession']))
        {
            return true;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }

    function send_mail($email,$message,$subject)
    {


        require './mailer/src/Exception.php';
        require './mailer/src/PHPMailer.php';
        require './mailer/src/SMTP.php';
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl/tsl";
        $mail->Host       = "smtp.titan.email";
        $mail->Port       = 465;
        $mail->AddAddress($email);
        $mail->Username="info@infyenterprise.com";
        $mail->Password="2SU!cwD@j!3.hTX";
        $mail->SetFrom('info@infyenterprise.com','Infy Enterprise');
        $mail->AddReplyTo("info@infyenterprise.com","Infy Enterprise");
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }
}