<?php

//require_once '../connection-local.php';
//require_once '../connection.php';

class Vendor
{


    public $vendor_id;
    public $user_id;
    public $vendor_name;
    public $vendor_email;
    public $active;

    /**
     *
     * @param int|null $vendor_id
     * @param int $user_id
     * @param string $vendor_email
     * @param string $vendor_name
     * @param int $active
     */
   /* public function __construct(int $vendor_id, int $user_id, string $vendor_email, string $vendor_name, int $active)
    {
        $this->vendor_id = $vendor_id;
        $this->user_id = $user_id;
        $this->active = $active;
        $this->vendor_name = $vendor_name;
        $this->vendor_email = $vendor_email;
    }*/

    /**
     * @return string
     */
    public function getGetAll(): string
    {
        return "SELECT * FROM Vendors";
    }

    /**
     * @param int $active
     * @return string
     */
    public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Vendors WHERE active = $active";
    }

    /**
     * @param int $vendor_id
     * @return string
     */
    public function getById(int $vendor_id): string
    {
        return "SELECT * FROM Vendors WHERE vendor_id = $vendor_id";
    }

    /**
     * @param int $vendor_id
     * @return string
     */
    public function deleteById(int $vendor_id): string
    {
        return "DELETE FROM Vendors WHERE vendor_id = $vendor_id";
    }

    /**
     * @param int $active
     * @param int $vendor_Id
     * @return string
     */
    public function getByIdAndActive(int $active, int $vendor_Id): string
    {
        return "SELECT * FROM `Vendors` WHERE `active` = $active and `vendor_id` = $vendor_Id";
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
        return "UPDATE Vendors SET user_id=$user_id, vendor_name='" . $vendor_name . "', vendor_email='" . $vendor_email . "', active=$active WHERE vendor_id=$vendor_Id";
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
        return "INSERT INTO Vendors (user_id, vendor_name, vendor_email, active) 
               VALUES ( " . $result['user_id'] . ", '" . $result["vendor_email"] . "', '" . $result["vendor_email"] . "', " . $result['active'] . ")";
    }
}