<?php
header("Content-type: application/json; charset=utf-8");
// The handler for the ProductList XMLHttpRequest but this time
// returning JSON-encoded data.

require_once('dbinit.php');
require_once ('product.php');
require_once('orderdetails.php');

if (!isset($_GET['orderId']) || !is_numeric($orderId = $_GET['orderId'])) {
    die("Bad parameter");
}

$order = OrderDetails::read($_GET['orderId']);
$productName = Product::read($order->productId)->productName;
$partOrder = array_slice($order, 4, 2);
$orderArray = array_merge(array('productName'=>$productName), $partOrder); 
echo json_encode($orderArray);