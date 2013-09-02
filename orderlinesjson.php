<?php
header("Content-type: application/json; charset=utf-8");
// The handler for the OrderLines XMLHttpRequest returning JSON-encoded data.
// Based off of productlistjson.php from lab 5.

require_once('dbinit.php');
require_once('orderDetails.php');

if (!isset($_GET['orderId']) || !is_numeric($orderId = $_GET['orderId'])) {
    die("Bad parameter");
}

$orderLines = OrderDetails::getOrderLines($_GET['orderId']); 
echo json_encode($orderLines);
