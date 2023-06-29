<?php

class Image
{

    public $image_id = 0;
    public $vendor_id = 0;
    public $product_id = 0;
    public $images_blob = null;
    public $image_link = null;
    public $image_type = null;
    public $active = 1;
    public $image_name = "image_name";
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
        return "SELECT * FROM Images WHERE active = $active and image_id = $image_Id";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insertNewImage(array $result): string
    {
        return "INSERT INTO Images (vendor_id, product_id, image_blob, active,image_size, image_link, image_type) 
               VALUES ( " . $result['vendor_id'] . ", '" . $result["product_id"] . "', '" . $result["image_blob"] . "', " . $result['active'] . ", '" . $result['image_size'] . "', '" . $result['image_link'] . "', '" . $result['image_type'] . "')";
    }

    /**
     * @param string $image_blob
     * @param int $image_size
     * @param string $image_link
     * @param string $image_type
     * @param string $image_name
     * @param int $active
     * @param int $image_id
     * @return string
     */
    final public function updateImage(string $image_blob, int $image_size, string $image_link, string $image_type, string $image_name, int $active, int $image_id): string
    {
        return "UPDATE Images SET image_blob='" . $image_blob . "', image_size='" . $image_size . "',image_link='" . $image_link . "',image_type='" . $image_type . "',image_name='" . $image_name . "', active=$active WHERE image_id=$image_id";
    }

}