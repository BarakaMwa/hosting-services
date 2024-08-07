<?php

namespace Data;


class Carts
{
    private $table;
    public $user_id;
    public $productId;
    public $quantity;
    public $active;
    public $id;



    public function __construct()
    {
        $this->table = get_class($this);
        $array = explode("\\", $this->table);
        $this->table = $array[1];
    }
    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM $this->table";
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
        return "INSERT INTO $this->table (user_id, productId, quantity, active) 
               VALUES ( " . $result['user_id'] . ", '" . $result["productId"] . "', '" . $result["quantity"] . "', " . $result['active'] . ")";
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
        return "UPDATE $this->table SET user_id=$user_id, productId='" . $productId . "', quantity='" . $quantity . "', active=$active WHERE cart_id=$cartId";
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


}
