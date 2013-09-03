<!---
Main body of HTML for product browser; includes end tags for body and html.
The file 'headerHTML.php' must be included before this file.
Code based off of nwproductbrowser4.php from lab 5.
-->

<table id="OrderComboBoxes">
    <tr>
        <th>Customers</th>
        <th>Orders</th>
    </tr>
    <tr>
        <td>
            <?php
            echo comboBoxHtml('customers', $customerMap, $customerId);
            ?>
        </td>
        <td>
            <?php
            echo comboBoxHtml('orders', $orderMap, $orderId);
            ?>
        </td>
    </tr>
</table>

<h2>Order Details</h2>

<table id='OrderDetails' border="1" style="border-collapse:collapse">
    <?php foreach ($order as $field => $value) {
        if ($value !== null) {
            ?>
            <tr>
                <th><?php echo htmlspecialchars($field); ?></th>
                <td><?php echo htmlspecialchars($value); ?></td>
            </tr>
            <?php
        }
    }
    ?>
</table>

<h3>Order Lines</h3>

<table id='OrderLines' border="1" style="border-collapse:collapse">
        <?php $headers = $orderLines[0]; ?>
    <tr>
        <?php foreach ($headers as $field => $value) { ?>
            <th><?php echo htmlspecialchars($field); ?></th>
        <?php } ?>
    </tr>

        <?php foreach ($orderLines as $line) { ?>
        <tr>
            <?php foreach ($line as $value) { ?>
                <td><?php echo htmlspecialchars($value); ?></td>
            <?php } ?>
        </tr>
        <?php } ?>
</table>

<script type='text/javascript' src="orderBrowser.js" ></script>