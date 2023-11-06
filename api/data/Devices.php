<?php

class Devices
{

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

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM Devices";
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Devices WHERE active = $active";
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