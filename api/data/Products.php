<?php

class Products{


    public $product_id;
    public $vendor_id;
    public $price;
    public $product_name;
    public $product_description;
    public $active;
    /**
     * @return string
     */
    public function getGetAll(): string
    {
        return "SELECT * FROM Products";
    }

    /**
     * @param int $active
     * @return string
     */
    public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Products WHERE active = $active";
    }

    /**
     * @param int $product_id
     * @return string
     */
    public function getById(int $product_id): string
    {
        return "SELECT * FROM Products WHERE product_id = $product_id";
    }

    /**
     * @param int $product_id
     * @return string
     */
    public function deleteById(int $product_id): string
    {
        return "DELETE FROM Products WHERE product_id = $product_id";
    }
    /**
     * @param int $active
     * @param int $product_Id
     * @return string
     */
    public function getByIdAndActive(int $active, int $product_Id): string
    {
        return "SELECT * FROM `Products` WHERE `active` = $active and `product_id` = $product_Id";
    }


    /**
     * @param int $vendor_id
     * @param string $product_name
     * @param string $product_description
     * @param int $active
     * @param int $product_Id
     * @return string
     */
    public function updateProduct(int $vendor_id, string $product_name, string $product_description, int $active, int $product_Id): string
    {
        return "UPDATE Products SET vendor_id=$vendor_id, product_name='" . $product_name . "', product_description='" . $product_description . "', active, price=$active WHERE product_id=$product_Id";
    }

    /**
     * @param array $result
     * @return string
     */
    public function insert(array $result): string
    {
        return "INSERT INTO Vendors (vendor_id, product_name, product_description, active, price) 
               VALUES ( " . $result['vendor_id'] . ", '" . $result["product_name"] . "', '" . $result["product_description"] . "', " . $result['active'] . ", " . $result['price'] . ")";
    }
    
}