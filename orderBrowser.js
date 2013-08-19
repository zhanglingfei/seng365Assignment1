/*
 * The JavaScript for the AJAX'd version of the NW Product Browser,
 * using JSON for data transfers.
 */

(function () {
    'use strict';
    /*jslint browser: true, devel: true, indent: 4, maxlen: 80 */

    var REQUEST_COMPLETE = 4,      // ReadyState of XMLHttpRequest when done
        OK = 200,                  // HTTP response OK code
        orderDetailsXHR = null;  // XMLHttpRequest for product details
    
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
    }
    
    // Called by the category combo box's onChange event.
    // Initiates an XMLHttpRequest to obtain the list of product
    // names and IDs required to update the Products combo box.
    function orderChanged() {
        var orderID = document.getElementById("order").value,
            resource = "orderdetailsjson.php?orderId=" + orderID;

        orderDetailsXHR = new XMLHttpRequest();
        orderDetailsXHR.onreadystatechange = orderDetailsArrived;
        orderDetailsXHR.open("GET", resource, true);
        orderDetailsXHR.send();
    }   
        
    /* Initialisation: bind the event handlers and kick it into life by calling
    * categoryChanged().
    */
    window.onload = function () {
        document.getElementById('orders').onchange = orderChanged;
        orderChanged();
    };

}());