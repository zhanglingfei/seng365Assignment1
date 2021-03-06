<?php
/* 
 * Declare the Order class, representing a row of the Ass1_Orders table.
 * Since the database was imported from elsewhere and has capital letters
 * at the start of each field name, an internal tweak is used to convert
 * column names to php lower-case-first format.
 *
 * This class requires that a global mysqli variable $DB exists.
 * 
 * Code based off of product.php from lab 5, with alterations.
 */
class Order {
    public $id;
    public $orderNumber;
    public $orderDate;
    public $requiredDate;
    public $shippedDate;
    public $status;
    public $comments;
    public $customerId;

    /*
     * Return an Order object read from the database for the given order.
     * Throws an exception if no such order exists in the database.
     */
    public static function read($id) {
        global $DB;
        $id = $DB->real_escape_string($id);
        $prod = new Order();
        $sql = "SELECT * FROM Ass1_Orders WHERE id='$id'";
        $result = $DB->query($sql);
        Order::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("Order ID $id not found in database");
        }

        $prod->load($result->fetch_array(MYSQLI_ASSOC));
        return $prod;
    }
    
    /*
     * Return an Order object read from the database for the given order,
     * containing only the information of particular columns
     * (the rest of the attributes are given a value of NULL).
     * Throws an exception if no such order exists in the database.
     */
    public static function readColumns($id) {
        global $DB;
        $id = $DB->real_escape_string($id);
        $prod = new Order();
        $sql = "SELECT orderDate, requiredDate, shippedDate, status, comments";
        $sql .= " FROM Ass1_Orders WHERE id='$id'";
        $result = $DB->query($sql);
        Order::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("Order ID $id not found in database");
        }

        $prod->load($result->fetch_array(MYSQLI_ASSOC));
        return $prod;
    }


    /** Return an associative array id=>orderNumber for all orders in the
     *  database, or all matching a given customerId (if given).
     * @global mysqli $DB
     * @param int $customerId  Ass1_Customers ID that orders are from (optional)
     * @return associative array mapping orderId to orderNumber, 
     * ordered by orderNumber.
     */
    public static function listAll($customerId=NULL) {
        global $DB;
        $customerId = $DB->real_escape_string($customerId);
        $sql = "SELECT id, orderNumber FROM Ass1_Orders";
        if ($customerId) {
            $sql .= " where customerId = '$customerId'";
        }
        $sql .= " ORDER BY orderNumber";
        $result = $DB->query($sql);
        Order::checkResult($result);
        $list = array();
        while (($row = $result->fetch_object()) !== NULL) {
            $list[$row->id] = $row->orderNumber;
        }
        return $list;
    }

    /** Return an associative array id=>customerName for all customers in the
     *  database who have placed orders.
     * @global mysqli $DB
     * @return associative array mapping customerId to customerName, 
     * ordered by name.
     */
    public static function listAllCustomers() {
        global $DB;
        
        //nested query to determine if customer has orders
        $subquery = "(SELECT * FROM Ass1_Orders";
        $subquery .= " WHERE Ass1_Customers.id = Ass1_Orders.customerId)";
        
        $sql = "SELECT id, customerName";
        $sql .= " FROM Ass1_Customers WHERE EXISTS ";
        $sql .= $subquery;
        $sql .= " ORDER BY customerName";
        $result = $DB->query($sql);
        Order::checkResult($result);
        $list = array();
        while (($row = $result->fetch_object()) !== NULL) {
            $list[$row->id] = $row->customerName;
        }
        return $list;
    }

    /** Return an array of all orders in the database (or the subset
     *  matching the given customerId, if given).
     * @global mysqli $DB
     * @param int $customerId  Ass1_Customers ID that orders are from (optional)
     * @return an array of Order objects containing all orders, ordered
     * by orderNumber.
     */
    public static function getAllOrders($customerId=NULL) {
        global $DB;
        $customerId = $DB->real_escape_string($customerId);
        $sql = "SELECT * FROM Ass1_Orders";
        if ($customerId) {
            $sql .= " WHERE customerId = '$customerId'";
        }
        $sql .= " ORDER BY orderNumber";
        $result = $DB->query($sql);
        Order::checkResult($result);
        $list = array();
        while (($row = $result->fetch_array(MYSQLI_ASSOC)) !== NULL) {
            $prod = new Order();
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

