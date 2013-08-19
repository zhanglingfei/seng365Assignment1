<?php
header("Content-type: application/json; charset=utf-8");
// The handler for the ProductList XMLHttpRequest but this time
// returning JSON-encoded data.

require_once('dbinit.php');
require_once('order.php');
require_once('orderdetails.php');
require_once('customer.php');
require_once('product.php');

if (!isset($_GET['orderId']) || !is_numeric($orderId = $_GET['orderId'])) {
    die("Bad parameter");
}

function modifyOrderDetails($order) {
    $orderArray = array();
    foreach ($order as $field => $value) {
        $orderArray["$field"] = $value;
    }

    $customerId = $order->customerId;
    $customerName = Customer::readCustomerName($customerId);
    $custNameArray = array("customerName" => $customerName);
    
    $orderDetails = OrderDetails::readDetails($orderId);
    $detailsArray = array();
    foreach ($orderDetails as $field => $value) {
        $detailsArray["$field"] = $value;
    }
    
    $productId = $orderDetails->productId;
    $productName = Product::read($productId)->productName;
    $prodNameArray = array("ProductName" => $productName);
    
    $arr1 = array_slice($orderArray, 1, 6);
    $arr2 = array_slice($detailsArray, 3, 2);

    $newArray = array_merge($arr1, $custNameArray, $prodNameArray, $arr2);

    return $newArray;
}

$order = Order::read($_GET['orderId']);
$orderArray = modifyOrderDetails($order);
echo json_encode($orderArray);