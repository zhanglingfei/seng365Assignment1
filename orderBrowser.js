/*
 * The JavaScript for the AJAX'd version of the NW Product Browser,
 * using JSON for data transfers.
 */

(function () {
    'use strict';
    /*jslint browser: true, devel: true, indent: 4, maxlen: 80 */

    var REQUEST_COMPLETE = 4,      // ReadyState of XMLHttpRequest when done
        OK = 200,                  // HTTP response OK code
        orderLinesXHR = null,
        orderListXHR = null,
        orderDetailsXHR = null;  // XMLHttpRequest for product details
    
    
    // Adds a (text, value) option to a select element
    function addOption(selectbox, text, value) {
        var option = document.createElement("option");
        option.text = text;
        option.value = value;
        selectbox.options.add(option);
    }
    
    function orderLinesArrived() {
        var orderLines, orderLinesTable, i, j, rows, cells, line;
        
        if (orderDetailsXHR.readyState === REQUEST_COMPLETE &&
                orderDetailsXHR.status === OK) {
            
            orderLines = JSON.parse(orderLinesXHR.responseText);
            orderLinesTable = document.getElementById("OrderLines");
            rows = orderLinesTable.rows;
            
            for (i = 1; i < rows.length; i += 1) {
                line = orderLines[i];
                cells = rows[i].cells;
                for (j = 0; j < cells.length; j += 1) {
                    cells[j].innerHTML = line[rows[0].cells[j].innerHTML];
                }
            }
        }
    }
    
    function loadOrderLines() {
        var orderID = document.getElementById("orders").value,
            resource = "orderlinesjson.php?orderId=" + orderID;

        orderLinesXHR = new XMLHttpRequest();
        orderLinesXHR.onreadystatechange = orderLinesArrived;
        orderLinesXHR.open("GET", resource, true);
        orderLinesXHR.send();   
    }
    
    // Called asynchronously as the state of the
    // productDetailsXHR for the currently select product details changes.
    function orderDetailsArrived() {
        // That's odd. Where did the body of this function go this time?
        var order, orderTable, rows, cells, i;

        if (orderDetailsXHR.readyState === REQUEST_COMPLETE &&
                orderDetailsXHR.status === OK) {

            order = JSON.parse(orderDetailsXHR.responseText);
            orderTable = document.getElementById("OrderDetails");
            rows = orderTable.rows;

            for (i = 0; i < rows.length; i += 1) {
                cells = rows[i].cells;
                cells[1].innerHTML = order[cells[0].innerHTML];
            }
        }
        loadOrderLines();
    }
    
    // Called by the category combo box's onChange event.
    // Initiates an XMLHttpRequest to obtain the list of product
    // names and IDs required to update the Products combo box.
    function loadOrderDetails() {
        var orderID = document.getElementById("orders").value,
            resource = "orderinfojson.php?orderId=" + orderID;

        orderDetailsXHR = new XMLHttpRequest();
        orderDetailsXHR.onreadystatechange = orderDetailsArrived;
        orderDetailsXHR.open("GET", resource, true);
        orderDetailsXHR.send();
    } 
    
        // Called asynchronously as the state of the
    // XMLHttpRequest for a new product list changes.
    function newOrderListArrived() {
        var orderCombo, orderList, order, i;
        if (orderListXHR.readyState  === REQUEST_COMPLETE &&
                orderListXHR.status  === OK) {

            orderList = JSON.parse(orderListXHR.responseText);
            orderCombo = document.getElementById("orders");

            // Delete all existing entries in the Products combo box
            while (orderCombo.options.length > 0) {
                orderCombo.remove(0);
            }

            for (i = 0; i < orderList.length; i += 1) {
                order = orderList[i];
                addOption(orderCombo, order.orderNumber, order.id);
            }

            orderCombo.selectedIndex = 0;
            loadOrderDetails();
        }
    }
    
        // Called by the category combo box's onChange event.
    // Initiates an XMLHttpRequest to obtain the list of product
    // names and IDs required to update the Products combo box.
    function customerChanged() {
        var orderCombo = document.getElementById("orders"),
            customerID = document.getElementById("customers").value,
            resource = "customerordersjson.php?customerId=" + customerID;

        // Clear out the Products combo box
        while (orderCombo.options.length > 0) {
            orderCombo.remove(0);
        }

        orderListXHR = new XMLHttpRequest();
        orderListXHR.onreadystatechange = newOrderListArrived;
        orderListXHR.open("GET", resource, true);
        orderListXHR.send();
    }

        
    /* Initialisation: bind the event handlers and kick it into life by calling
    * categoryChanged().
    */
    window.onload = function () {
        document.getElementById('customers').onclick = customerChanged;
        document.getElementById('orders').onclick = loadOrderDetails;
        customerChanged();
    };

}());