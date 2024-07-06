<?php
namespace Data;
class Devices
{

    private $table = __CLASS__;
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


    public function __construct()
    {}

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM ".$this->table;
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM ".$this->table." WHERE active = $active";
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