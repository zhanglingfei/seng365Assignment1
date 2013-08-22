<?php
header("Content-type: application/json; charset=utf-8");
// The handler for the ProductList XMLHttpRequest but this time
// returning JSON-encoded data.

require_once('dbinit.php');
require_once('order.php');

if (!isset($_GET['orderId']) || !is_numeric($orderId = $_GET['orderId'])) {
    die("Bad parameter");
}

$order = Order::readColumns($_GET['orderId']);
echo json_encode($order);