    <body>
        <h1>Classic Models: <?php echo $title ?></h1>
        <form id='browserForm' action='productBrowser.php' method='post'>
            <table id="ComboBoxes">
                <tr>
                    <th>Product Lines</th>
                    <th>Products</th>
                </tr>
                <tr>
                    <td>
                        <?php
                        echo comboBoxHtml('productLines', $prodLinesMap, $prodLineId);
                        ?>
                    </td>
                    <td>
                        <?php
                        echo comboBoxHtml('products', $productMap, $prodId);
                        ?>
                    </td>
                </tr>
            </table>

            <h2>Selected Product</h2>

            <table id="SelectedProduct" border="1" style="border-collapse:collapse">
                <?php foreach ($prodArray as $key => $value) { ?>
                    <tr>
                        <td><?php echo $key ?></td>
                        <td><?php echo $value ?></td>
                    </tr>
                <?php } ?>
            </table>

            <div>
                <input type='hidden' id='whatChanged' name='whatChanged' />
            </div>

        </form>

        <script src="productBrowser.js" ></script>

    </body>
</html>