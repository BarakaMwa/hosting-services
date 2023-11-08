<?php

class Cart
{

    public $user_id;
    public $product_id;
    public $quantity;
    public $active;
    public $cart_id;

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM Cart";
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Cart WHERE active = $active";
    }

    /**
     * @param int $cart_id
     * @return string
     */
    final public function getById(int $cart_id): string
    {
        return "SELECT * FROM Cart WHERE cart_id = $cart_id";
    }

    /**
     * @param int $cartId
     * @return string
     */
    final public function deleteById(int $cartId): string
    {
        return "DELETE FROM Cart WHERE cart_id = $cartId";
    }


    /**
     * @param int $active
     * @param int $cartId
     * @return string
     */
    final public function getByIdAndActive(int $active, int $cartId): string
    {
        return "SELECT * FROM Cart WHERE active = $active and cart_id = $cartId";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insert(array $result): string
    {
        return "INSERT INTO Cart (user_id, product_id, quantity, active) 
               VALUES ( " . $result['user_id'] . ", '" . $result["product_id"] . "', '" . $result["quantity"] . "', " . $result['active'] . ")";
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
        return "UPDATE Cart SET user_id=$user_id, product_id='" . $productId . "', quantity='" . $quantity . "', active=$active WHERE cart_id=$cartId";
    }


}
