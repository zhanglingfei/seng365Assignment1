<?php
/*
 * Allows user to browser orders by customer name and then order number
 * and to view the order's details and lines.
 *
 * Uses AJAX to fetch a new orders list whenever the customer changes, 
 * and a new set of order details and order lines whenever the 
 * order changes, encoding the data in JSON.
 *
 * Code based off of nwproductbrowser4.php from lab 5, with alterations.
 */
 
require_once ('dbinit.php');
require_once('orderDetails.php');
require_once ('order.php');

/* Return HTML to display a combo box with the specified "label" 
 * used for both the name and the id of the select
 * element, filling it with the contents of the given map
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
        $html .= "<option value='" . htmlspecialchars($id) . "' $selected>" . 
                htmlspecialchars($name) . "</option>\n";
    }
    $html .= "</select>\n";
    return $html;
}

// Get from the database a map from customerId to customerName, for use
// with the Customers combo box. The current customer is taken to
// be the currently selected one on a reload, or the first customer
// in the map otherwise.

$customerMap = Order::listAllCustomers();
$customerId = array_shift(array_keys($customerMap));

// Get from the database a map from orderId to orderNumber, for use
// with the Orders combo box. The current order is taken to
// be the currently selected one on a reload, or the first order
// in the map otherwise.

$orderMap = Order::listAll($customerId);
$orderId = array_shift(array_keys($orderMap));

// Get from the database the details of the currently selected order
// and the lines of the order for use in the OrderDetails and 
// OrderLines tables, respectively.

$order = Order::readColumns($orderId);
$orderLines = OrderDetails::getOrderLines($orderId);

// =========== THE MAIN FORM =================
$title = "Orders";
require_once('headerHTML.php');
require_once('orderBrowserHTML.php');
require_once('footerHTML.php');
?>
