<!--
html for title and menu of all pages.

Note that footerHTML.php must be included after this file (possibly with other
files in between) in order to close the body and head tags.
-->

<!DOCTYPE html>
<html>
    <head>
        <title>Classic Models: <?php echo $title ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="headerstyle.css">
    </head>
    <body>
        <h1>Classic Models: <?php echo $title ?></h1>
        <p id='menu'>
            <a HREF='productBrowser.php'>Products</a>
            <a HREF='orderBrowser.php'>Orders</a>
            <a HREF='aboutSite.php'>About this Site</a>
        </p>
        <p></p>