<?php

    require_once ('dbinit.php');
    require_once('productLines.php');
    require_once ('product.php');
    
    $product = Product::read(1);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Classic Models Products</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <h1>Classic Models: Products</h1>
        <h2>Selected Product</h2>
        
        
        <table id="SelectedProduct" border="1">
            <?php foreach ($product as $field => $value) { ?>
                <tr>
                    <td><?php echo $field?></td>
                    <td><?php echo $value?></td>
                </tr>
            <?php } ?>
        </table>
 
    </body>
</html>