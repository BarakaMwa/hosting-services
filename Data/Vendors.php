<?php

namespace Data;

class Vendors
{

    public $table;

    public $vendorId;
    public $user_id;
    public $vendor_name;
    public $vendor_email;
    public $active;

    public function __construct()
    {

        $this->table = get_class($this);
        $array = explode("\\", $this->table);
        $this->table = $array[1];
    }

    /**
     *
     * @param int|null $vendorId
     * @param int $user_id
     * @param string $vendor_email
     * @param string $vendor_name
     * @param int $active
     */
    public function createVendor(int $vendorId, int $user_id, string $vendor_email, string $vendor_name, int $active)
    {
        $this->vendorId = $vendorId;
        $this->user_id = $user_id;
        $this->active = $active;
        $this->vendor_name = $vendor_name;
        $this->vendor_email = $vendor_email;
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
        return "SELECT * FROM $this->table WHERE active = $active";
    }

    /**
     * @param int $vendorId
     * @return string
     */
    public function getById(int $vendorId): string
    {
        return "SELECT * FROM $this->table WHERE vendorId = $vendorId";
    }

    /**
     * @param int $vendorId
     * @return string
     */
    public function deleteById(int $vendorId): string
    {
        return "DELETE FROM $this->table WHERE vendorId = $vendorId";
    }

    /**
     * @param int $active
     * @param int $vendor_Id
     * @return string
     */
    public function getByIdAndActive(int $active, int $vendor_Id): string
    {
        return "SELECT * FROM $this->table WHERE `active` = $active and `vendorId` = $vendor_Id";
    }


    /**
     * @param int $user_id
     * @param string $vendor_name
     * @param string $vendor_email
     * @param int $active
     * @param int $vendor_Id
     * @return string
     */
    public function update(int $user_id, string $vendor_name, string $vendor_email, int $active, int $vendor_Id): string
    {
        return "UPDATE $this->table SET user_id=$user_id, vendor_name='" . $vendor_name . "', vendor_email='" . $vendor_email . "', active=$active WHERE vendorId=$vendor_Id";
    }

//    /**
//     * @param string $sql
//     * @param PDO|null $db
//     * @return void
//     */
//    public function runInsertQuery(string $sql, ?PDO $db): void
//    {
//        $stmt = $db->prepare($sql);
//        $stmt->execute();
//    }

    /**
     * @param array $result
     * @return string
     */
    public function insert(array $result): string
    {
        return "INSERT INTO $this->table (user_id, vendor_name, vendor_email, active) 
               VALUES ( " . $result['user_id'] . ", '" . $result["vendor_email"] . "', '" . $result["vendor_email"] . "', " . $result['active'] . ")";
    }
}