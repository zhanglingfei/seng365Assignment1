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
        $selected = $id === intval($selectedRowId) ? 'selected' : '';
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
    
    $prodLineName = ProductLines::read($prodLineId) -> productLine;
    $prodLineArray = array("ProductLine"=>$prodLineName);
    
    $prodArrayBegin = array_slice($prodArray, 1, 2);
    $prodArrayEnd = array_slice($prodArray, 4, 6);
            
    $newArray = array_merge($prodArrayBegin, $prodLineArray, $prodArrayEnd);
    $newArray['MSRP'] = $prodArray['mSRP'];
    
    return $newArray;
}

// Get from the database a map from CategoryId to Category Name, for use
// with the Category combo box. The initial category is just the first one.
// Thereafter the JavaScript looks after everything.

$prodLinesMap = ProductLines::listAll();
$prodLinesIds = array_keys($prodLinesMap);
$prodLineId = $prodLinesIds[0];

// Get a map from ProductId to ProductName for all products in the current
// category, for use with the Product combo box.

$productMap = Product::listAll($prodLineId);

// The currently selected product is just the first product in the first category

$prodIds = array_keys($productMap);
$prodId = $prodIds[0];
$product = Product::read($prodId);

$prodArray = modifyProductDetails($product, $prodLineId);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Classic Models Products</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1>Classic Models: Products</h1>
        <table id="ComboBoxes">
            <tr>
                <th>Product Lines</th>
                <th>Products</th>
            </tr>
            <tr>
                <td>
                    <?php 
                    echo comboBoxHtml('Product Lines', $prodLinesMap, $prodLineId);
                    ?>
                </td>
                <td>
                    <?php
                    echo comboBoxHtml('Products', $productMap, $prodId);
                    ?>
                </td>
            </tr>
        </table>
        
        <h2>Selected Product</h2>
        
        <table id="SelectedProduct" border="1">
            <?php foreach ($prodArray as $key => $value) { ?>
                <tr>
                    <td><?php echo $key?></td>
                    <td><?php echo $value?></td>
                </tr>
            <?php } ?>
        </table>
 
    </body>
</html>