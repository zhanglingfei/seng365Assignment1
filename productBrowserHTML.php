<?php

require_once('dbinit.php');

function prodLineSelectBoxHtml($label, $map, $selectedRowId) {
    $html = "<p>$label: ";
    $html .= "<select id='$label' name='$label' size = 10>";
    foreach ($map as $id => $name) {
        $selected = $id === intval($selectedRowId) ? 'selected' : '';
        $html .= "<option value='$id' $selected>$name</option>\n";
    }
    $html .= "</select>\n</p>";
    return $html;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Classic Models Products</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <link rel="stylesheet" type="text/css" href="nwstyles.css" >
    </head>

    <h1>Classic Models: Products</h1>

    <?php
    echo prodLineSelectBoxHtml('ProductLines', $categoryMap, $catId);
    echo comboBoxHtml('Product', $productMap, $prodId);
    ?>
    <h2>Selected Product</h2>
    <table id='ProductDetails'>
        <?php foreach ($product as $field => $value) { ?>
            <tr>
                <td><?php echo $field; ?></td>
                <td><?php echo $value; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>

    <script type='text/javascript' src="nwproductbrowser4.js" ></script>

</body>
</html>