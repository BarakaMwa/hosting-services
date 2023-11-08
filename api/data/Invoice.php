<?php

class Invoice{
    /**
     * @return string
     */
    final public function getGetAll(): string
    {
        return "SELECT * FROM Invoices";
    }

    /**
     * @param int $active
     * @return string
     */
    final public function getAllByActive(int $active): string
    {
        return "SELECT * FROM Invoices WHERE active = $active";
    }

    /**
     * @param int $invoiceId
     * @return string
     */
    final public function getById(int $invoiceId): string
    {
        return "SELECT * FROM Invoices WHERE invoiceId = $invoiceId";
    }

    /**
     * @param int $invoiceId
     * @return string
     */
    final public function deleteById(int $invoiceId): string
    {
        return "DELETE FROM Invoices WHERE invoiceId = $invoiceId";
    }


    /**
     * @param int $active
     * @param int $invoice_Id
     * @return string
     */
    final public function getByIdAndActive(int $active, int $invoice_Id): string
    {
        return "SELECT * FROM Invoices WHERE active = $active and invoiceId = $invoice_Id";
    }

    /**
     * @param array $result
     * @return string
     */
    final public function insert(array $result): string
    {
        return "INSERT INTO Invoices (vendor_id, product_id, 
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
     * @param int $invoiceId
     * @return string
     */
    final public function update(string $invoice_blob, int $invoice_size,
                                 string $invoice_link, string $invoice_type,
                                 string $invoice_name, int $active,
                                 int    $invoiceId): string
    {
        return "UPDATE Invoices 
SET 
    invoice_blob='" . $invoice_blob . "', invoice_size='" . $invoice_size . "',
    invoice_link='" . $invoice_link . "',invoice_type='" . $invoice_type . "',
    invoice_name='" . $invoice_name . "', active=$active 
    WHERE invoiceId=$invoiceId";
    }

    /**
     * @param array $result
     * @return string
     */
    public function insertInvoice(array $result): string
    {
        return "INSERT INTO Invoices (vendor_id, product_id, 
                   invoice_blob, active,
                   invoice_size, invoice_link,
                   invoice_name,invoice_type) 
               VALUES ( " . $result['vendor_id'] . ", '" . $result["product_id"] . "', 
               '" . $result["invoice_blob"] . "', " . $result['active'] . ",
                '" . $result['invoice_size'] . "', '" . $result['invoice_link'] . "',
                 '" . $result['invoice_name'] . "','" . $result['invoice_type'] . "')";
    }

}