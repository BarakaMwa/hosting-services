<?php

namespace Data;

class EmailNotifications
{
    private $table;
    public $id;
    public $uid;
    public $sender;
    public $seen;
    public $sent;
    public $deleted;
    public $delivered;
    public $subject;
    public $repliedTo;
    public $cc;
    public $bbc;
    public $body;

    public function __construct()
    {
        $this->table = get_class($this);
        $array = explode("\\", $this->table);
        $this->table = $array[1];
    }

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM " . $this->table;
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM " . $this->table . " WHERE active = $active";
    }

    /**
     * @param int $device_id
     * @return string
     */
    final public function getById(int $device_id): string
    {
        return "SELECT * FROM $this->table WHERE DeviceID = $device_id";
    }

}