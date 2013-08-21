<p>
    <?php
    echo comboBoxHtml('customers', $customerMap, $customerId);
    echo comboBoxHtml('orders', $orderMap, $orderId);
    ?>
</p>
<h2>Order Details</h2>

<table id='OrderDetails' border="1" style="border-collapse:collapse">
    <?php foreach ($order as $field => $value) {
        if ($value !== null) {?>
            <tr>
                <td><?php echo $field; ?></td>
                <td><?php echo $value; ?></td>
            </tr>
        <?php
        }
    }
    ?>
</table>

<script type='text/javascript' src="orderBrowser.js" ></script>

</body>
</html>