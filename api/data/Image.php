<?php

class Image
{

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
     * @param int $image_id
     * @return string
     */
    final public function getById(int $image_id): string
    {
        return "SELECT * FROM Images WHERE image_id = $image_id";
    }

    /**
     * @param int $image_id
     * @return string
     */
    final public function deleteById(int $image_id): string
    {
        return "DELETE FROM Images WHERE image_id = $image_id";
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
     * @param int $vendor_id
     * @param int $product_id
     * @param string $image_blob
     * @param int $image_size
     * @param string $image_link
     * @param string $image_type
     * @param int $active
     * @param int $image_id
     * @return string
     */
    final public function updateImage(int $vendor_id, int $product_id, string $image_blob, int $image_size, string $image_link, string $image_type, int $active, int $image_id): string
    {
        return "UPDATE Images SET vendor_id=$vendor_id, product_id='" . $product_id . "', image_blob='" . $image_blob . "', image_size='" . $image_size . "',image_link='" . $image_link . "',image_type='" . $image_type . "', active=$active WHERE image_id=$image_id";
    }

}