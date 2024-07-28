<?php

namespace Data;

class Users
{
    private $table;
    private $user_id;
    private $username;
    private $email;
    private $active;
    private $userName;
    private $nrc;
    private $gender;
    private $status;
    private $phone;
    private $firstName;
    private $activationCode;
    private $lastName;

    public function __construct()
    {
        $this->table = get_class($this);
        $array = explode("\\", $this->table);
        $this->table = $array[1];
    }
}