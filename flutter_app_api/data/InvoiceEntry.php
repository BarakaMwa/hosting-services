<?php

class InvoiceEntry
{


    public $entryId;
    public $invoiceId;
    public $productId;
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
     * @param int $entryId
     * @return string
     */
    final public function getById(int $entryId): string
    {
        return "SELECT * FROM Invoice_Entries WHERE entryId = $entryId";
    }

    /**
     * @param int $entryId
     * @return string
     */
    final public function deleteById(int $entryId): string
    {
        return "DELETE FROM Invoice_Entries WHERE entryId = $entryId";
    }


    /**
     * @param int $active
     * @param int $entryId
     * @return string
     */
    final public function getByIdAndActive(int $active, int $entryId): string
    {
        return "SELECT * FROM Invoice_Entries WHERE active = $active and entryId = $entryId";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insertInvoiceEntry(array $result): string
    {
        return "INSERT INTO Invoice_Entries (vendorId, productId, 
                   invoice_blob, active,
                   invoice_size, invoice_link,
                   invoice_name,invoice_type) 
               VALUES ( " . $result['vendorId'] . ", '" . $result["productId"] . "', 
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
     * @param int $entryId
     * @return string
     */
    final public function update(string $invoice_blob, int $invoice_size,
                                 string $invoice_link, string $invoice_type,
                                 string $invoice_name, int $active,
                                 int    $entryId): string
    {
        return "UPDATE Invoice_Entries 
SET 
    invoice_blob='" . $invoice_blob . "', invoice_size='" . $invoice_size . "',
    invoice_link='" . $invoice_link . "',invoice_type='" . $invoice_type . "',
    invoice_name='" . $invoice_name . "', active=$active 
    WHERE entryId=$entryId";
    }

    /**
     * @param int $invoiceId
     * @return string
     */
    public function getByInvoiceId(int $invoiceId): string
    {
        return "SELECT * FROM Invoice_Entries WHERE invoiceId = $invoiceId";
    }

    /**
     * @param int $productId
     * @return string
     */
    public function getByProductId(int $productId): string
    {
        return "SELECT * FROM Invoice_Entries WHERE productId = $productId";
    }

}