<?php

//require_once 'connection-local.php';
require_once 'connection.php';

class DevicesService
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

    /**
     * @return array
     */
    public function getAllDevices(): array
    {
        $data = array();
        try {
            $stmt = $this->conn->query("SELECT * FROM Devices");
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
    public function getDeviceById(int $Id): array
    {
        $data = array();
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Devices WHERE DeviceID=:DeviceId");
            $stmt->execute(array(":DeviceId" => $Id));
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
            $stmt = $this->conn->prepare("SELECT * FROM Devices WHERE userId=:UserId");
            $stmt->execute(array(":UserId" => $Id));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
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
            $stmt = $this->conn->prepare("SELECT * FROM Devices WHERE userId=:UserId");
            $stmt->execute(array(":UserId" => $Id));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
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
                                                    FROM Devices
                                                    WHERE UserId IS NOT NULL and UserId=:UserId
                                                    ORDER BY DeviceId DESC
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