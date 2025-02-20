<?php
$host = "localhost";
$db_name = "s2s_tracking";
$username = "root"; // Default XAMPP MySQL user
$password = ""; // No password in XAMPP by default

// dsn - data source name - a string that has the Associated data structure to describe a connection to a data source (Specifies the database type, host, and database name.)
$dsn = "mysql:host=$host;dbname=$db_name";


// PDO (PHP Data Objects) is a PHP extension that allows secure, flexible database interactions
// It works with multiple databases (MySQL, PostgreSQL, SQLite, etc.), so your code is not limited to MySQL.
try {
    // Create the DB connection
    $pdo = new PDO($dsn, $username, $password);
    // Error Handling Mode - This tells PDO how to handle errors.
    // PDO::ATTR_ERRMODE defines the error reporting mode.
    // PDO::ERRMODE_EXCEPTION means any error will throw an Exception instead of failing silently.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // If an error occurs (e.g., wrong credentials, missing table), PHP will stop execution and display an error message.
    // Without this, PHP may not show database errors, making debugging harder.

    // Handling Connection Failures
} catch (PDOException $e) {
    // If the database fails to connect, PDOException is triggered.
    // Stops execution immediately.
    // Prints the error message so we know what went wrong.
    die("Database connection failed: " . $e->getMessage());
}
