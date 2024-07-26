<?php

namespace Data;

class User_Details
{
    private $table;
    public function __construct()
    {
        $this->table = get_class($this);
        $array = explode("\\", $this->table);
        $this->table = $array[1];
    }
}