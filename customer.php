<?php
/*
 * Declare the Product class, representing a row of the products table.
 * Since the database was imported from elsewhere and has capital letters
 * at the start of each field name, an internal tweak is used to convert
 * column names to php lower-case-first format.
 *
 * Implements only the Read function, since we're just implementing a product
 * browser, plus a listAll function that returns a map from productID to
 * productName for all products in the database.
 *
 * This class requires that a global mysqli variable $DB exists.
 */
class Customer {
    public $id;
    public $customerNumber;
    public $customerName;
    public $contactLastName;
    public $contactFirstName;
    public $phone;
    public $addressLine1;
    public $addressLine2;
    public $city;
    public $state;
    public $postalCode;
    public $country;
    public $salesRepEmployeeNumber;
    public $creditLimit;

    /*
     * Return a Product object read from the database for the given product.
     * Throws an exception if no such product exists in the database.
     */
    public static function readCustomerName($id) {
        global $DB;
        $prod = new Customer();
        $sql = "SELECT customerName FROM Ass1_Customers WHERE id='$id'";
        $result = $DB->query($sql);
        Customer::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("Customer ID $id not found in database");
        }

        $prod->load($result->fetch_array(MYSQLI_ASSOC));
        return $prod;
    }
    
    /** Return an associative array id=>customerName for all products in the
     *  database, or all matching a given productLineId (if given).
     * @global mysqli $DB
     * @param int $prodLineId
     * @return associative array mapping productId to product, ordered by name
     */
    public static function listAll($customerId=NULL) {
        global $DB;
        $sql = "SELECT id, customerName FROM Ass1_Customers";
        if ($customerId) {
            $sql .= " where customerId = '$customerId'";
        }
        $sql .= " ORDER BY customerName";
        $result = $DB->query($sql);
        Customer::checkResult($result);
        $list = array();
        while (($row = $result->fetch_object()) !== NULL) {
            $list[$row->id] = $row->customerName;
        }
        return $list;
    }


    // Given a row from the database, copy all database column values
    // into 'this', converting column names to fields names by converting
    // first char to lower case.
    private function load($row) {
        foreach ($row as $field => $value) {
            $fieldName = strtolower($field[0]) . substr($field, 1);
            $this->$fieldName = $value;
        }
    }


    // Check that the result from a DB query was OK
    private static function checkResult($result) {
        global $DB;
        if (!$result) {
            die("DB error ({$DB->error})");
        }
    }
};

