<?php

class Cart{

    /**
     * @return string
     */
    public function getGetAll(): string
    {
        return "SELECT * FROM Cart";
    }

    /**
     * @param int $active
     * @return string
     */
    public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Cart WHERE active = $active";
    }

    /**
     * @param int $cart_id
     * @return string
     */
    public function getById(int $cart_id): string
    {
        return "SELECT * FROM Cart WHERE cart_id = $cart_id";
    }

    /**
     * @param int $vendor_id
     * @return string
     */
    public function deleteById(int $cart_id): string
    {
        return "DELETE FROM Cart WHERE vendor_id = $cart_id";
    }



    /**
     * @param int $active
     * @param int $vendor_Id
     * @return string
     */
    public function getByIdAndActive(int $active, int $vendor_Id): string
    {
        return "SELECT * FROM `Cart` WHERE `active` = $active and `vendor_id` = $vendor_Id";
    }

    /**
     * @param array $result
     * @return string
     */
    public function insertNewCart(array $result): string
    {
        return "INSERT INTO Cart (user_id, product_id, quantity, active) 
               VALUES ( " . $result['user_id'] . ", '" . $result["product_id"] . "', '" . $result["quantity"] . "', " . $result['active'] . ")";
    }

    /**
     * @param int $user_id
     * @param string $vendor_name
     * @param string $vendor_email
     * @param int $active
     * @param int $vendor_Id
     * @return string
     */
    public function updateCart(int $user_id, int $product_id, double $quantity, int $active, int $cart_id): string
    {
        return "UPDATE Vendors SET user_id=$user_id, product_id='" . $product_id . "', quantity='" . $quantity . "', active=$active WHERE cart_id=$cart_id";
    }

}
