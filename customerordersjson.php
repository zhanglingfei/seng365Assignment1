<?php
header("Content-type: application/json; charset=utf-8");
// The handler for the ProductList XMLHttpRequest but this time
// returning JSON-encoded data.

require_once('dbinit.php');
require_once('order.php');

if (!isset($_GET['customerId']) || !is_numeric($customerId = $_GET['customerId'])) {
    die("Bad parameter");
}

$orders = Order::getAllOrders($_GET['customerId']);
echo json_encode($orders);