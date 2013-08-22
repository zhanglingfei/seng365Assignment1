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
        if ($value !== null) {?>
            <tr>
                <th><?php echo $field; ?></th>
                <td><?php echo $value; ?></td>
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
        <?php foreach($headers as $field => $value) { ?>
            <th><?php echo $field; ?></th>
        <?php } ?>
    </tr>
    
    <?php foreach ($orderLines as $line) { ?>
    <tr>
        <?php foreach ($line as $value) { ?>
            <td><?php echo $value; ?></td>
        <?php } ?>
    </tr>
    <?php } ?>
</table>

<script type='text/javascript' src="orderBrowser.js" ></script>

</body>
</html>