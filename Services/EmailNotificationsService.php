<?php

namespace Services;

class EmailNotificationsService
{
    /**
     * @param array $user
     * @return false|\PDOStatement|void
     */
    public function saveEmail(array $user)
    {
        try {
            $user['userPassword'] = md5($user['userPassword']);
            $stmt = $this->conn->prepare("INSERT INTO EmailNotifications (userName,userEmail,nrc,gender,phone,firstName,lastName,userPassword, activationCode) 
                                                VALUES(:userName, :userEmail, :nrc, :gender, :phone,:firstName,:lastName,:userPassword,:activationCode)");
            $stmt->bindparam(":uid", $user['uid']);
            $stmt->bindparam(":sender", $user['sender']);
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
}