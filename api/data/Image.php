<?php

class Image{

    public $image_id = 0;
    public $vendor_id = null;
    public $product_id = null;
    public $images_blob = null;
    public $image_link = null;
    public $image_type = null;
    public $image_size = 0;

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM Images";
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Images WHERE active = $active";
    }

    /**
     * @param int $cart_id
     * @return string
     */
    final public function getById(int $cart_id): string
    {
        return "SELECT * FROM Images WHERE cart_id = $cart_id";
    }

    /**
     * @param int $cart_id
     * @return string
     */
    final public function deleteById(int $cart_id): string
    {
        return "DELETE FROM Images WHERE image_id = $cart_id";
    }


    /**
     * @param int $active
     * @param int $image_Id
     * @return string
     */
    final public function getByIdAndActive(int $active, int $image_Id): string
    {
        return "SELECT * FROM `Images` WHERE `active` = $active and `image_id` = $image_Id";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insertNewImage(array $result): string
    {
        return "INSERT INTO Images (user_id, product_id, quantity, active) 
               VALUES ( " . $result['user_id'] . ", '" . $result["product_id"] . "', '" . $result["quantity"] . "', " . $result['active'] . ")";
    }

    /**
     * @param int $user_id
     * @param int $product_id
     * @param float $quantity
     * @param int $active
     * @param int $cart_id
     * @return string
     */
    final public function updateImage(int $user_id, int $product_id, float $quantity, int $active, int $cart_id): string
    {
        return "UPDATE Images SET user_id=$user_id, product_id='" . $product_id . "', quantity='" . $quantity . "', active=$active WHERE cart_id=$cart_id";
    }
    
}