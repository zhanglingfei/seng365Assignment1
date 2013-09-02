<?php
header("Content-type: application/json; charset=utf-8");
// The handler for the OrderDetails XMLHttpRequest returning JSON-encoded data.
// Based off of productdetailsjson.php from lab 5.

require_once('dbinit.php');
require_once('order.php');

if (!isset($_GET['orderId']) || !is_numeric($orderId = $_GET['orderId'])) {
    die("Bad parameter");
}

$order = Order::readColumns($_GET['orderId']);
echo json_encode($order);
