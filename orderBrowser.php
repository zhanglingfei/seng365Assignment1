<?php
require_once ('dbinit.php');
require_once('orderDetails.php');
require_once ('order.php');
require_once ('customer.php');

/* Return HTML to display a combo box with the given label
 * (which is also used for both the name and the id of the select
 * element), filling it with the contents of the given map
 * (which is an associative id => name array).
 * Used for selecting elements from a table.
 * $selectedRowId is the id of the row to select in the combo box.
 */

function comboBoxHtml($label, $map, $selectedRowId) {
    $html = "<select id='$label' name='$label'";
    $html .= " size=10>";
    foreach ($map as $id => $name) {
        if ($id === intval($selectedRowId)) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $html .= "<option value='$id' $selected>$name</option>\n";
    }
    $html .= "</select>\n";
    return $html;
}

function modifyOrderDetails($order) {
    $orderArray = array();
    foreach ($order as $field => $value) {
        $orderArray["$field"] = $value;
    }

    $customerId = $order->customerId;
    $customerName = Customer::readCustomerName($customerId);
    $custNameArray = array("customerName" => $customerName);
    
    $orderDetails = OrderDetails::readDetails($order->id);
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

//$isReload = isset($_POST['productLines']) && isset($_POST['products']);

// Get a map from ProductId to ProductName for all products in the current
// category, for use with the Product combo box.

$orderMap = Order::listAll();

// Get the currently-selected product details from the Products table.
// The currently product is taken from the combobox on a reload or
// as the first item in the map otherwise.

$orderId = array_shift(array_keys($orderMap));

//if ($isReload && $_POST['whatChanged'] === 'Products') {
//    $prodId = $_POST['products'];
//} else {
//    $prodId = array_shift(array_keys($productMap));
//}

$order = Order::read($orderId);
$orderArray = modifyOrderDetails($order);


// =========== THE MAIN FORM =================
$title = "Orders";
require_once('generalHeadHTML.php');
require_once('menuHTML.php');
require_once('orderBrowserHTML.php');
?>
