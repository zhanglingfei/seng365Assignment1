<?php
require_once ('dbinit.php');
require_once('productLines.php');
require_once ('product.php');

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

function modifyProductDetails($product, $prodLineId) {
    $prodArray = array();
    foreach ($product as $field => $value) {
        $prodArray["$field"] = $value;
    }

    $prodLineName = ProductLines::read($prodLineId)->productLine;
    $prodLineArray = array("ProductLine" => $prodLineName);

    $prodArrayBegin = array_slice($prodArray, 1, 2);
    $prodArrayEnd = array_slice($prodArray, 4, 6);

    $newArray = array_merge($prodArrayBegin, $prodLineArray, $prodArrayEnd);
    $newArray['MSRP'] = $prodArray['mSRP'];

    return $newArray;
}

$isReload = isset($_POST['productLines']) && isset($_POST['products']);

// Get from the database a map from CategoryId to Category Name, for use
// with the Category combo box. The current category is taken to
// be the currently selected one on a reload or the first category
// in the map otherwise.

$prodLinesMap = ProductLines::listAll();

if ($isReload) {
    $prodLineId = $_POST['productLines'];
} else {
    $prodLineId = array_shift(array_keys($prodLinesMap));
}

// Get a map from ProductId to ProductName for all products in the current
// category, for use with the Product combo box.

$productMap = Product::listAll($prodLineId);

// Get the currently-selected product details from the Products table.
// The currently product is taken from the combobox on a reload or
// as the first item in the map otherwise.

if ($isReload && $_POST['whatChanged'] === 'Products') {
    $prodId = $_POST['products'];
} else {
    $prodId = array_shift(array_keys($productMap));
}

$product = Product::read($prodId);
$prodArray = modifyProductDetails($product, $prodLineId);


// =========== THE MAIN FORM =================
$title = "Products";
require_once('generalHeadHTML.php');
require_once('menuHTML.php');
require_once('productBrowserHTML.php');
?>
