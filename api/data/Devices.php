<?php

class Devices
{

    private $Table = __CLASS__;
    public $DeviceID;
    public $Manufacturer;
    public $Model;
    public $OS;
    public $OSVersion;
    public $ScreenSize;
    public $StorageCapacity;
    public $RAM;
    public $IMEI;
    public $SerialNumber;
    public $PurchaseDate;
    public $Price;
    public $Location;
    public $UserId;
    public $DateCreated;
    public $Status;

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
        return "SELECT * FROM Device WHERE DeviceID = $device_id";
    }

}