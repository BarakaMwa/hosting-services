<?php

namespace Data;
class Payments
{
    public $payment_id;
    public $vendorId;
    public $amount;
    public $payment_date;
    public $active;
    /**
     * @var mixed|string
     */
    private $table;


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
     * @param int $payment_id
     * @return string
     */
    final public function getById(int $payment_id): string
    {
        return "SELECT * FROM $this->table WHERE payment_id = $payment_id";
    }

    /**
     * @param int $cartId
     * @return string
     */
    final public function deleteById(int $cartId): string
    {
        return "DELETE FROM $this->table WHERE payment_id = $cartId";
    }


    /**
     * @param int $active
     * @param int $cartId
     * @return string
     */
    final public function getByIdAndActive(int $active, int $cartId): string
    {
        return "SELECT * FROM $this->table WHERE active = $active and payment_id = $cartId";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insert(array $result): string
    {
        return "INSERT INTO $this->table (vendorId, payment_date, amount, active) 
               VALUES ( " . $result['vendorId'] . ", '" . $result["payment_date"] . "',
                '" . $result["amount"] . "', " . $result['active'] . ")";
    }

    /**
     * @param int $vendorId
     * @param int $productId
     * @param float $amount
     * @param int $active
     * @param int $cartId
     * @return string
     */
    final public function update(int $vendorId, int $productId, float $amount, int $active, int $cartId): string
    {
        return "UPDATE $this->table SET vendorId=$vendorId, payment_date='" . $productId . "', amount='" . $amount . "', active=$active WHERE payment_id=$cartId";
    }


}