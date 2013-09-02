/**
 * JavaScript for productBrowser.php
 *
 * Code heavily based off of nwproductbrowser2.js from lab 4.
 */

(function () {
    'use strict';
    /*jslint browser: true, devel: true, indent: 4, maxlen: 80 */

    /*
     * Check which combo box has been clicked, set 'whatChanged',
     * and submit form.
     */
    function bindHandlers() {
        var productLinesCombo = document.getElementById('productLines'),
            productsCombo = document.getElementById('products');

        productLinesCombo.onclick = function () {
            document.getElementById('whatChanged').value = 'Product Lines';
            document.getElementById('browserForm').submit();
        };

        productsCombo.onclick = function () {
            document.getElementById('whatChanged').value = 'Products';
            document.getElementById('browserForm').submit();
        };
    }

    bindHandlers();

// End of the anonymous function
}());
