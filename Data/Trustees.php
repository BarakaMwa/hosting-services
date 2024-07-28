<?php

namespace Data;

class Trustees
{
    private $table;
    public $id;
    public $userId;
    public $firstName;
    public $lastName;
    public $email;
    public $address;
    public $phoneNumber;
    public $nrc;
    public $trusteeTo;
    public $dateCreated;
    public $status;

    public function __construct()
    {
        $this->table = get_class($this);
        $array = explode("\\", $this->table);
        $this->table = $array[1];
    }

    /**
     * @return string
     */
    public function getGetAll(): string
    {
        return "SELECT * FROM $this->table";
    }

    /**
     * @param int $active
     * @return string
     */
    public function getAllByActive(int $active): string
    {
        return "SELECT * FROM $this->table  WHERE active = $active";
    }

    /**
     * @param int $device_id
     * @return string
     */
    final public function getById(int $device_id): string
    {
        return "SELECT * FROM $this->table  WHERE trusteeId = $device_id";
    }

    /**
     * @param int $userId
     * @return string
     */
    final public function getByUserId(int $userId): string
    {
        return "SELECT * FROM $this->table  WHERE userId = $userId";
    }

    /**
     * @param string $sql
     * @param array $search
     * @return string
     */
    final public function searchBy(string $sql, array $search): string
    {
        return $sql . " Where name LIKE '%" . $search['value'] . "%' OR status LIKE '%" . $search['value'] . "%'";
    }

    /**
     * @param string $sql
     * @param int $start
     * @param int $length
     * @return string
     */
    final public function getPage(string $sql, int $start = 0, int $length = 10): string
    {
        return $sql . " LIMIT " . $start . ", " . $length;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        $this->table = get_class($this);
        $array = explode("\\", $this->table);
        $this->table = $array[1];
        return $this->table;
    }

}