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
class Product {
    public $id;
    public $productCode;
    public $productName;
    public $productLineId;
    public $productScale;
    public $productVendor;
    public $productDescription;
    public $quantityInStock;
    public $buyPrice;
    public $MSRP;

    /*
     * Return a Product object read from the database for the given product.
     * Throws an exception if no such product exists in the database.
     */
    public static function read($id) {
        global $DB;
        $prod = new Product();
        $sql = "SELECT * FROM Ass1_Products WHERE id='$id'";
        $result = $DB->query($sql);
        Product::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("Product ID $id not found in database");
        }

        $prod->load($result->fetch_array(MYSQLI_ASSOC));
        return $prod;
    }


    /** Return an associative array id=>productName for all products in the
     *  database, or all matching a given productLineId (if given).
     * @global mysqli $DB
     * @param int $prodLineId
     * @return associative array mapping productId to product, ordered by name
     */
    public static function listAll($prodLineId=NULL) {
        global $DB;
        $sql = "SELECT id, productName FROM Ass1_Products";
        if ($prodLineId) {
            $sql .= " where productLineId = '$prodLineId'";
        }
        $sql .= " ORDER BY productName";
        $result = $DB->query($sql);
        Product::checkResult($result);
        $list = array();
        while (($row = $result->fetch_object()) !== NULL) {
            $list[$row->id] = $row->productName;
        }
        return $list;
    }


    /** Return an array of all products in the database (or the subset
     *  matching the given prodLineegory ID if given), for use by
     *  nwproductBrowser3.
     * @global mysqli $DB
     * @param int $prodLineId  ProductLines ID that products are from (optional)
     * @return an array of Product objects containing all products, ordered
     * by name.
     */
    public static function getAllProducts($prodLineId=NULL) {
        global $DB;
        $sql = "SELECT * FROM Ass1_Products";
        if ($prodLineId) {
            $sql .= " WHERE productLineId = '$prodLineId'";
        }
        $sql .= " ORDER BY productName";
        $result = $DB->query($sql);
        Product::checkResult($result);
        $list = array();
        while (($row = $result->fetch_array(MYSQLI_ASSOC)) !== NULL) {
            $prod = new Product();
            $prod->load($row);
            $list[] = $prod;
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

