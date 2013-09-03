<?php
/* This file should be included once at the start of a database-using script.
 * It establishes the connection to the database, setting up a global
 * database object $DB, which is a connection to the database defined
 * within the code below.
 *
 * It also provides the option of turning on extra debugging capabilities.
 * 
 * This file is taken directly from the labs.
 */

define('DEBUGGING', true);

if (defined('DEBUGGING') && DEBUGGING) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1'); // Only if debugging!
}

define('SERVER', 'mysql.cosc.canterbury.ac.nz');
define('USERNAME', 'sjm348');
define('PASSWORD', '69321848');
define('DATABASE', USERNAME);  // Database name usually same as username

function connectDb() {
    $db = new mysqli(SERVER, USERNAME, PASSWORD);
    if ($db->connect_error) {
        die('Could not connect to MySQL server');
    }

    if (!$db->select_db(DATABASE)) {
        die('Could not select database');
    }
    $db->set_charset('utf8');  // Make sure we talk utf-8 to the server
    return $db;
}


$DB = connectDb();


