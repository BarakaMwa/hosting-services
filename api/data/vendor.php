<?php

class Vendor
{

    private $vendor_id;
    private $user_id;
    private $vendor_name;
    private $vendor_email;
    private $active;


    /**
     * @return string
     */
    public function getGetAll(): string
    {
        return "SELECT * FROM `Vendors`";
    }

    /**
     * @param bool $active
     * @return string
     */
    public function getAllByActive(bool $active): string
    {
        return "SELECT * FROM Vendors WHERE active = $active";
    }

    /**
     * @param int $vendor_id
     * @return string
     */
    public function getAllById(int $vendor_id): string
    {
        return "SELECT * FROM Vendors WHERE vendor_id = $vendor_id";
    }

    /**
     * @param bool $active
     * @param $vendor_Id
     * @return string
     */
    public function getByIdAndActive(bool $active, $vendor_Id): string
    {
        return "SELECT * FROM Vendors WHERE active = $active and vendor_id = $vendor_Id";
    }


    /**
     * @param $user_id
     * @param $vendor_name
     * @param $vendor_email
     * @param $active
     * @param int $vendor_Id
     * @return string
     */
    public function update($user_id, $vendor_name, $vendor_email, $active, int $vendor_Id): string
    {
        $sql = "UPDATE Vendors v
SET v.user_id      = $user_id,
    v.vendor_name  = $vendor_name,
    v.vendor_email = $vendor_email,
    v.active = $active,
WHERE v.vendor_id = $vendor_Id;";
        return $sql;
    }
}