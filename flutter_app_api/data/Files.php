<?php

class File
{

    public $file_id = 0;
    public $vendorId = 0;
    public $productId = 0;
    public $file_blob = null;
    public $file_link = null;
    public $file_type = null;
    public $active = 1;
    public $file_name = "file_name";
    public $file_size = 0;

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM Files";
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Files WHERE active = $active";
    }

    /**
     * @param int $file_id
     * @return string
     */
    final public function getById(int $file_id): string
    {
        return "SELECT * FROM Files WHERE file_id = $file_id";
    }

    /**
     * @param int $file_id
     * @return string
     */
    final public function deleteById(int $file_id): string
    {
        return "DELETE FROM Files WHERE file_id = $file_id";
    }


    /**
     * @param int $active
     * @param int $file_Id
     * @return string
     */
    final public function getByIdAndActive(int $active, int $file_Id): string
    {
        return "SELECT * FROM Files WHERE active = $active and file_id = $file_Id";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insert(array $result): string
    {
        return "INSERT INTO Files (vendorId, productId, 
                   file_blob, active,
                   file_size, file_link,
                   file_name,file_type) 
               VALUES ( " . $result['vendorId'] . ", '" . $result["productId"] . "', 
               '" . $result["file_blob"] . "', " . $result['active'] . ",
                '" . $result['file_size'] . "', '" . $result['file_link'] . "',
                 '" . $result['file_name'] . "','" . $result['file_type'] . "')";
    }

    /**
     * @param string $file_blob
     * @param int $file_size
     * @param string $file_link
     * @param string $file_type
     * @param string $file_name
     * @param int $active
     * @param int $file_id
     * @return string
     */
    final public function update(string $file_blob, int $file_size,
                                 string $file_link, string $file_type,
                                 string $file_name, int $active,
                                 int    $file_id): string
    {
        return "UPDATE Files 
SET 
    file_blob='" . $file_blob . "', file_size='" . $file_size . "',
    file_link='" . $file_link . "',file_type='" . $file_type . "',
    file_name='" . $file_name . "', active=$active 
    WHERE file_id=$file_id";
    }

    /**
     * @param array $result
     * @return string
     */
    public function insertFile(array $result): string
    {
        return "INSERT INTO Files (vendorId, productId, 
                   file_blob, active,
                   file_size, file_link,
                   file_name,file_type) 
               VALUES ( " . $result['vendorId'] . ", '" . $result["productId"] . "', 
               '" . $result["file_blob"] . "', " . $result['active'] . ",
                '" . $result['file_size'] . "', '" . $result['file_link'] . "',
                 '" . $result['file_name'] . "','" . $result['file_type'] . "')";
    }

}