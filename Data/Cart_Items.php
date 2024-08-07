<?php

namespace Data;

class Cart_Items
{
    private $table;
    public $id;
    public $cart_id;
    public $owner_id;
    public $product_id;
    public $item;
    public $status;
    public $count;
    public $item_price;
    public $total_price;

    /**
     *
     */
    public function __construct()
    {
        $this->table = get_class($this);
        $array = explode("\\", $this->table);
        $this->table = $array[1];
    }


    /**
     * @return string
     */
    public function getClassName(): string
    {
        $this->table = get_class($this);
        $array = explode("\\", $this->table);
        $this->table = $array[1];
        return $this->table;
    }


    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM " . $this->table;
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM $this->table WHERE active = $active";
    }

    /**
     * @param int $cart_id
     * @return string
     */
    final public function getById(int $cart_id): string
    {
        return "SELECT * FROM $this->table WHERE cart_id = $cart_id";
    }

    /**
     * @param int $cartId
     * @return string
     */
    final public function deleteById(int $cartId): string
    {
        return "DELETE FROM $this->table WHERE cart_id = $cartId";
    }


    /**
     * @param int $active
     * @param int $cartId
     * @return string
     */
    final public function getByIdAndActive(int $active, int $cartId): string
    {
        return "SELECT * FROM $this->table WHERE active = $active and cart_id = $cartId";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insert(array $result): string
    {
        return "INSERT INTO $this->table (
                   cart_id,
                   owner_id, 
                   product_id, 
                   item, 
                   status, 
                   count, 
                   item_price, 
                   total_price)
               VALUES ( " . $result['cart_id'] . "
               ," . $result['owner_id'] . "
               , '" . $result["product_id"] . "'
               , '" . $result["item"] . "'
               , '" . $result["status"] . "'
               , '" . $result["count"] . "'
               , '" . $result["item_price"] . "'
               , " . $result['total_price'] . ")";
    }

    /**
     * @param int $user_id
     * @param int $productId
     * @param float $quantity
     * @param int $active
     * @param int $cartId
     * @return string
     */
    final public function update(int $user_id, int $productId, float $quantity, int $active, int $cartId): string
    {
        return "UPDATE 
    $this->table 
SET 
    user_id=$user_id, productId='" . $productId . "', quantity='" . $quantity . "', active=$active WHERE cart_id=$cartId";
    }


}