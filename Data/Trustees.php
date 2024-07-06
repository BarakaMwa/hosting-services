<?php

namespace Api\Models;

class Trustees
{
    private const SELECT_FROM = "SELECT * FROM ";
    private $table = __CLASS__;
    public $trusteeId;
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

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return self::SELECT_FROM .$this->table;
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return self::SELECT_FROM .$this->table." WHERE active = $active";
    }

    /**
     * @param int $device_id
     * @return string
     */
    final public function getById(int $device_id): string
    {
        return self::SELECT_FROM .$this->table." WHERE trusteeId = $device_id";
    }

    /**
     * @param int $userId
     * @return string
     */
    final public function getByUserId(int $userId): string
    {
        return self::SELECT_FROM .$this->table." WHERE userId = $userId";
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
     * @param string $start
     * @param string $length
     * @return string
     */
    final public function getPage(string $sql, string $start, string $length): string
    {
        return $sql. " LIMIT ".$start.", ".$length;
    }

}