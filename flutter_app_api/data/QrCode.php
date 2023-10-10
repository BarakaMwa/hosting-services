<?php

class QrCode
{

    public $vendor_id;
    public $product_id;
    public $image_blob;
    public $image_link;
    public $active;
    public $qr_id;

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM QR_code";
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM QR_code WHERE active = $active";
    }

    /**
     * @param int $qr_id
     * @return string
     */
    final public function getById(int $qr_id): string
    {
        return "SELECT * FROM QR_code WHERE qr_id = $qr_id";
    }

    /**
     * @param int $qr_id
     * @return string
     */
    final public function deleteById(int $qr_id): string
    {
        return "DELETE FROM QR_code WHERE qr_id = $qr_id";
    }


    /**
     * @param int $active
     * @param int $qr_id
     * @return string
     */
    final public function getByIdAndActive(int $active, int $qr_id): string
    {
        return "SELECT * FROM QR_code WHERE active = $active and qr_id = $qr_id";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insert(array $result): string
    {
        return "INSERT INTO QR_code (vendor_id, product_id, image_blob, image_link, active) 
               VALUES ( " . $result['vendor_id'] . ", '" . $result["product_id"] . "', '" . $result["image_blob"] . "', '" . $result["image_link"] . "', " . $result['active'] . ")";
    }

    /**
     * @param int $vendor_id
     * @param int $productId
     * @param string $image_blob
     * @param string $image_link
     * @param int $active
     * @param int $qr_id
     * @return string
     */
    final public function update(int $vendor_id, int $productId, string $image_blob, string $image_link, int $active, int $qr_id): string
    {
        return "UPDATE QR_code SET vendor_id=$vendor_id, product_id='" . $productId . "', image_blob='" . $image_blob . "', image_link='" . $image_link . "', active=$active WHERE qr_id=$qr_id";
    }


}