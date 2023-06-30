<?php

class InvoiceEntry
{


    public $entry_id;
    public $invoice_id;
    public $product_id;
    public $quantity;
    public $price;
    public $total_price;

    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM Invoice_Entries";
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Invoice_Entries WHERE active = $active";
    }

    /**
     * @param int $entry_id
     * @return string
     */
    final public function getById(int $entry_id): string
    {
        return "SELECT * FROM Invoice_Entries WHERE entry_id = $entry_id";
    }

    /**
     * @param int $entry_id
     * @return string
     */
    final public function deleteById(int $entry_id): string
    {
        return "DELETE FROM Invoice_Entries WHERE entry_id = $entry_id";
    }


    /**
     * @param int $active
     * @param int $entry_id
     * @return string
     */
    final public function getByIdAndActive(int $active, int $entry_id): string
    {
        return "SELECT * FROM Invoice_Entries WHERE active = $active and entry_id = $entry_id";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insertNewInvoiceEntry(array $result): string
    {
        return "INSERT INTO Invoice_Entries (vendor_id, product_id, 
                   invoice_blob, active,
                   invoice_size, invoice_link,
                   invoice_name,invoice_type) 
               VALUES ( " . $result['vendor_id'] . ", '" . $result["product_id"] . "', 
               '" . $result["invoice_blob"] . "', " . $result['active'] . ",
                '" . $result['invoice_size'] . "', '" . $result['invoice_link'] . "',
                 '" . $result['invoice_name'] . "','" . $result['invoice_type'] . "')";
    }

    /**
     * @param string $invoice_blob
     * @param int $invoice_size
     * @param string $invoice_link
     * @param string $invoice_type
     * @param string $invoice_name
     * @param int $active
     * @param int $entry_id
     * @return string
     */
    final public function updateInvoiceEntry(string $invoice_blob, int $invoice_size,
                                     string $invoice_link, string $invoice_type,
                                     string $invoice_name, int $active,
                                     int    $entry_id): string
    {
        return "UPDATE Invoice_Entries 
SET 
    invoice_blob='" . $invoice_blob . "', invoice_size='" . $invoice_size . "',
    invoice_link='" . $invoice_link . "',invoice_type='" . $invoice_type . "',
    invoice_name='" . $invoice_name . "', active=$active 
    WHERE entry_id=$entry_id";
    }

    /**
     * @param int $invoice_id
     * @return string
     */
    public function getByInvoiceId(int $invoice_id): string
    {
        return "SELECT * FROM Invoice_Entries WHERE invoice_id = $invoice_id";
    }

}