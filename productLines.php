<?php
/*
 * Declare the ProductLines class, representing a row of the productLines table.
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
class ProductLines {
    public $id;
    public $productLine;
    public $textDescription;
    public $htmlDescription;
    public $image;

    /*
     * Return a ProductLine object read from the database for the given productLine.
     * Throws an exception if no such product exists in the database.
     */
    public static function read($id) {
        global $DB;
        $prod = new ProductLines();
        $sql = "SELECT * FROM ProductLines WHERE id='$id'";
        $result = $DB->query($sql);
        ProductLines::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("Product ID $id not found in database");
        }

        $prod->load($result->fetch_array(MYSQLI_ASSOC));
        return $prod;
    }


    /** Return an associative array id=>productName for all productLines in the
     *  database, or all matching a given categoryId (if given).
     * @global mysqli $DB
     * @return associative array mapping productId to product, ordered by name
     */
    public static function listAll() {
        global $DB;
        $sql = "SELECT id, productLine FROM ProductLines ORDER BY productLine";
        $result = $DB->query($sql);
        ProductLines::checkResult($result);
        $list = array();
        while (($row = $result->fetch_object()) !== NULL) {
            $list[$row->id] = $row->productLine;
        }
        return $list;
    }


    /** Return an array of all products in the database, for use by
     *  nwproductBrowser3.
     * @global mysqli $DB
     * @return an array of Product objects containing all products, ordered
     * by name.
     */
    public static function getAllProductLines() {
        global $DB;
        $sql = "SELECT * FROM ProductLines ORDER BY productLine";
        $result = $DB->query($sql);
        ProductLines::checkResult($result);
        $list = array();
        while (($row = $result->fetch_array(MYSQLI_ASSOC)) !== NULL) {
            $prod = new ProductLines();
            $prod->load($row);
            $list[] = $row;
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

