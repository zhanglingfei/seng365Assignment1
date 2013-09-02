<?php
/*
 * Allows user to browser products by product line and then product name
 * and to view the product's details.
 *
 * Uses a postback to alter variables and update the page.
 * Also implements persistence, keeping track of the last product viewed
 * and displaying it again if there is no postback (eg reload).
 *
 * Code (particularly comboBoxHtml function) based off of 
 * nwproductbrowser2.php from lab 4.
 */

require_once ('dbinit.php');
require_once('productLines.php');
require_once ('product.php');

session_start();

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

$isReload = isset($_POST['productLines']) && isset($_POST['products']);

// Get from the database a map from productLineId to productLineName, for use
// with the Product Lines combo box. The current product line is taken to
// be the currently selected one on a reload, otherwise the one stored in the
// session variable 'productLine', or the first product line in the map if 
// neither of the previous two cases occurs. 

$prodLinesMap = ProductLines::listAll();

if ($isReload) {
    $prodLineId = $_POST['productLines'];
    $_SESSION['productLine'] = $prodLineId;
} else if (isset($_SESSION['productLine'])){
    $prodLineId = $_SESSION['productLine'];
} else {
    $prodLineId = array_shift(array_keys($prodLinesMap));
    $_SESSION['productLine'] = $prodLineId;
}

// Get from the database a map from productId to productName, for use
// with the Products combo box. The current producte is taken to
// be the currently selected one on a reload, otherwise the one stored in the
// session variable 'product', or the first product in the map if neither
// of the previous two cases occurs. 

$productMap = Product::listAll($prodLineId);

if ($isReload && $_POST['whatChanged'] === 'Products') {
    $prodId = $_POST['products'];
    $_SESSION['product'] = $prodId;

} else if (!$isReload && isset($_SESSION['product'])){
    $prodId = $_SESSION['product'];
} else {
    $prodId = array_shift(array_keys($productMap));
    $_SESSION['product'] = $prodId;
}

// Get from the database the details of the currently selected product
// and the productLineName for use with the SelectedProduct table.

$product = Product::read($prodId);
$prodLineName = ProductLines::read($prodLineId)->productLine;


// =========== THE MAIN FORM =================
$title = "Products";
require_once('headerHTML.php');
require_once('productBrowserHTML.php');
?>
