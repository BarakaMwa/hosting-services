<?php

namespace Services;

//require_once '../Database/LocalDatabase.php';
use Database\LocalDatabase;

class TrusteesService
{
    private $conn;

    public function __construct()
    {
        $database = new LocalDatabase();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    /**
     * @return array
     */
    public function getAllTrustees(): array
    {
        $data = array();
        try {
            $stmt = $this->conn->query("SELECT * FROM Trustees");
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $data;
//        return $this->conn;
    }

    /**
     * @param int $Id
     * @return array
     */
    public function getById(int $Id): array
    {
        $data = array();
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Trustees WHERE trusteeId=:trusteeId");
            $stmt->execute(array(":trusteeId" => $Id));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $data;
    }

    /**
     * @param int $Id
     * @return array
     */
    public function getAllByUserId(int $Id): array
    {
        $data = array();
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Trustees WHERE userId=:userId");
            $stmt->execute(array(":userId" => $Id));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $data;
    }


    /**
     * @param int $Id
     * @return int
     */
    public function getTotalByUserId(int $Id): int
    {
        $data = array();
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Trustees WHERE userId=:userId");
            $stmt->execute(array(":userId" => $Id));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return count($data);
    }


    /**
     * @param int $Id
     * @param int $Size
     * @return array
     */
    public function getTopByUserId(int $Id, int $Size): array
    {
        $data = array();
        try {
            $stmt = $this->conn->prepare("SELECT *
                                                    FROM Trustees
                                                    WHERE userId IS NOT NULL and UserId=:UserId
                                                    ORDER BY trusteeId DESC
                                                    LIMIT " . $Size . ";");
            $stmt->execute(array(":UserId" => $Id));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $data;
    }


}
