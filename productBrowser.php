<?php
    $product = array("hi" => "lalala", "2" => "wheeee");
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
        
        
        <table id="SelectedProduct">
            <?php foreach ($product as $field => $value) { ?>
                <tr>
                    <td><?php echo $field?></td>
                    <td><?php echo $value?></td>
                </tr>
            <?php } ?>
        </table>
 
    </body>
</html>