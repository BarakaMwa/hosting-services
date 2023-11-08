<?php

class Payments
{
    public $payment_id;
    public $vendor_id;
    public $amount;
    public $payment_date;
    public $active;

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM Payments";
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Payments WHERE active = $active";
    }

    /**
     * @param int $payment_id
     * @return string
     */
    final public function getById(int $payment_id): string
    {
        return "SELECT * FROM Payments WHERE payment_id = $payment_id";
    }

    /**
     * @param int $cartId
     * @return string
     */
    final public function deleteById(int $cartId): string
    {
        return "DELETE FROM Payments WHERE payment_id = $cartId";
    }


    /**
     * @param int $active
     * @param int $cartId
     * @return string
     */
    final public function getByIdAndActive(int $active, int $cartId): string
    {
        return "SELECT * FROM Payments WHERE active = $active and payment_id = $cartId";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insert(array $result): string
    {
        return "INSERT INTO Payments (vendor_id, payment_date, amount, active) 
               VALUES ( " . $result['vendor_id'] . ", '" . $result["payment_date"] . "',
                '" . $result["amount"] . "', " . $result['active'] . ")";
    }

    /**
     * @param int $vendor_id
     * @param int $productId
     * @param float $amount
     * @param int $active
     * @param int $cartId
     * @return string
     */
    final public function update(int $vendor_id, int $productId, float $amount, int $active, int $cartId): string
    {
        return "UPDATE Payments SET vendor_id=$vendor_id, payment_date='" . $productId . "', amount='" . $amount . "', active=$active WHERE payment_id=$cartId";
    }


}