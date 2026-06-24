<?php
/**
 * Database connection (MySQLi).
 * Laragon defaults: host=127.0.0.1, user=root, no password.
 */

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'STUDENTMGTDB');

// Throw exceptions on MySQLi errors so we never run on a bad connection.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('Database connection failed: ' . $e->getMessage()
        . '<br>Make sure MySQL is running and you have imported <code>database.sql</code>.');
}
