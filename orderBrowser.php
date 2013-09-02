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
        $html .= "<option value='" . htmlspecialchars($id) . "' $selected>" . 
                htmlspecialchars($name) . "</option>\n";
    }
    $html .= "</select>\n";
    return $html;
}


$customerMap = Order::listAllCustomers();
$customerId = array_shift(array_keys($customerMap));

// Get a map from ProductId to ProductName for all products in the current
// category, for use with the Product combo box.

$orderMap = Order::listAll($customerId);
$orderId = array_shift(array_keys($orderMap));

$order = Order::readColumns($orderId);
$orderLines = OrderDetails::getOrderLines($orderId);

// =========== THE MAIN FORM =================
$title = "Orders";
require_once('headerHTML.php');
require_once('orderBrowserHTML.php');
?>
