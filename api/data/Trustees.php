<?php

class Trustees
{
    private $Table = "Trustees";
    public $trusteeId;
    public $userId;
    public $firstName;
    public $lastName;
    public $email;
    public $address;
    public $phoneNumber;
    public $nrc;
    public $trusteeTo;

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM ".$this->Table;
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM ".$this->Table." WHERE active = $active";
    }

    /**
     * @param int $device_id
     * @return string
     */
    final public function getById(int $device_id): string
    {
        return "SELECT * FROM ".$this->Table." WHERE trusteeId = $device_id";
    }

}