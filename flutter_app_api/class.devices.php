<?php

//require_once 'connection-local.php';
require_once 'connection.php';

class Devices
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
        return $this->conn;
    }

    /**
     * @param int $Id
     * @return array
     */
    public function getDeviceById(int $Id): array
    {
        $data = array();
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Devices WHERE device_id=:device_id");
            $stmt->execute(array(":device_id" => $Id));
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
    public function getAllDevicesByUserId(int $Id): array
    {
        $data = array();
        try {
            $stmt = $this->conn->prepare("SELECT * FROM Devices WHERE user_id=:user_id");
            $stmt->execute(array(":user_id" => $Id));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $data;
    }

    /**
     * @param int $Id
     * @return array
     */
    public function getTopFiveDevicesByUserId(int $Id): array
    {
        $data = array();
        try {
            $stmt = $this->conn->prepare("SELECT *
                                                    FROM Devices
                                                    WHERE user_id IS NOT NULL and user_id=:user_id
                                                    ORDER BY device_id DESC
                                                    LIMIT 5;
                                            ");
            $stmt->execute(array(":user_id" => $Id));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetchAll();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $data;
    }
}