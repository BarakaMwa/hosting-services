<?php

namespace Data;
class Products
{


    public $productId;
    public $vendorId;
    public $price;
    public $product_name;
    public $product_description;
    public $active;

    public function __construct()
    {
    }

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
     * @param int $productId
     * @return string
     */
    public function getById(int $productId): string
    {
        return "SELECT * FROM Products WHERE productId = $productId";
    }

    /**
     * @param int $productId
     * @return string
     */
    public function deleteById(int $productId): string
    {
        return "DELETE FROM Products WHERE productId = $productId";
    }

    /**
     * @param int $active
     * @param int $product_Id
     * @return string
     */
    public function getByIdAndActive(int $active, int $product_Id): string
    {
        return "SELECT * FROM `Products` WHERE `active` = $active and `productId` = $product_Id";
    }


    /**
     * @param int $vendorId
     * @param string $product_name
     * @param string $product_description
     * @param int $active
     * @param int $product_Id
     * @return string
     */
    public function updateProduct(int $vendorId, string $product_name, string $product_description, int $active, int $product_Id): string
    {
        return "UPDATE Products SET vendorId=$vendorId, product_name='" . $product_name . "', product_description='" . $product_description . "', active, price=$active WHERE productId=$product_Id";
    }

    /**
     * @param array $result
     * @return string
     */
    public function insert(array $result): string
    {
        return "INSERT INTO Vendors (vendorId, product_name, product_description, active, price) 
               VALUES ( " . $result['vendorId'] . ", '" . $result["product_name"] . "', '" . $result["product_description"] . "', " . $result['active'] . ", " . $result['price'] . ")";
    }

}