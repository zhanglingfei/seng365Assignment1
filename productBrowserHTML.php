<!---
Main body of HTML for product browser; includes end tags for body and html.
The file 'headerHTML.php' must be included before this file.
Code based off of nwproductbrowser2.php from lab 4.
-->

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
                <?php foreach ($product as $key => $value) { ?>
                	<tr>
                		<?php if ($key === "productLineId") { ?>
                    		<th>productLine</th>
                    		<td><?php echo htmlspecialchars($prodLineName); ?></tr>
                    	<?php } else { ?>
                        	<th><?php echo htmlspecialchars($key); ?></th>
	                        <td><?php echo htmlspecialchars($value); ?></td>
	                    <?php } ?>
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
