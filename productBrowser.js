/**
 * JavaScript for nwproductbrowser2.php
 */

(function () {
    'use strict';
    /*jslint browser: true, devel: true, indent: 4, maxlen: 80 */

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