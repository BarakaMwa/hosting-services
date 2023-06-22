<?php

class Vendor
{

    private $vendor_id;
    private $user_id;
    private $vendor_name;
    private $vendor_email;
    private $active;

    /**
     * @param $sql
     * @param $db
     * @return mixed
     */
    public function runSelectAllQuery($sql, $db)
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
//    return $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    /**
     * @param $sql
     * @param $db
     * @return void
     */
    public function runUpdateQuery($sql, $db): void
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
//    return $stmt->setFetchMode(PDO::FETCH_ASSOC);
//        return $stmt->fetchAll();
    }

    /**
     * @param $sql
     * @param $db
     * @return void
     */
    public function runDeleteQuery($sql, $db): void
    {
        $stmt = $db->prepare($sql);
        $stmt->execute();
//    return $stmt->setFetchMode(PDO::FETCH_ASSOC);
//        return $stmt->fetchAll();
    }
    /**
     * @return string
     */
    public function getGetAll(): string
    {
        return "SELECT * FROM Vendors";
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
        return "SELECT * FROM `Vendors` WHERE vendor_id = $vendor_id";
    }

    /**
     * @param bool $active
     * @param int $vendor_Id
     * @return string
     */
    public function getByIdAndActive(bool $active,int $vendor_Id): string
    {
        return "SELECT * FROM Vendors WHERE active = $active and vendor_id = $vendor_Id";
    }


    /**
     * @param int $user_id
     * @param string $vendor_name
     * @param string $vendor_email
     * @param bool $active
     * @param int $vendor_Id
     * @return string
     */
    public function updateVendor(int $user_id, string $vendor_name, string $vendor_email, bool $active, int $vendor_Id): string
    {
        return "UPDATE Vendors v SET v.user_id      = $user_id,    v.vendor_name  = '".$vendor_name."',    v.vendor_email = '".$vendor_email."',   v.active = $active WHERE v.vendor_id = $vendor_Id";
    }
}