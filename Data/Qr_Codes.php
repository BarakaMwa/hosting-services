<?php

namespace Data;
class Qr_Codes
{

    public $vendorId;
    public $productId;
    public $image_blob;
    public $image_link;
    public $active;
    public $qr_id;


    public function __construct()
    {
    }

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM QrCode";
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM QrCode WHERE active = $active";
    }

    /**
     * @param int $qr_id
     * @return string
     */
    final public function getById(int $qr_id): string
    {
        return "SELECT * FROM QrCode WHERE qr_id = $qr_id";
    }

    /**
     * @param int $qr_id
     * @return string
     */
    final public function deleteById(int $qr_id): string
    {
        return "DELETE FROM QrCode WHERE qr_id = $qr_id";
    }


    /**
     * @param int $active
     * @param int $qr_id
     * @return string
     */
    final public function getByIdAndActive(int $active, int $qr_id): string
    {
        return "SELECT * FROM QrCode WHERE active = $active and qr_id = $qr_id";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insert(array $result): string
    {
        return "INSERT INTO QrCode (vendorId, productId, image_blob, image_link, active) 
               VALUES ( " . $result['vendorId'] . ", '" . $result["productId"] . "', '" . $result["image_blob"] . "', '" . $result["image_link"] . "', " . $result['active'] . ")";
    }

    /**
     * @param int $vendorId
     * @param int $productId
     * @param string $image_blob
     * @param string $image_link
     * @param int $active
     * @param int $qr_id
     * @return string
     */
    final public function update(int $vendorId, int $productId, string $image_blob, string $image_link, int $active, int $qr_id): string
    {
        return "UPDATE QrCode SET vendorId=$vendorId, productId='" . $productId . "', image_blob='" . $image_blob . "', image_link='" . $image_link . "', active=$active WHERE qr_id=$qr_id";
    }


}