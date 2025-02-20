<?php
// This script retrieves all data from two database tables, clicks and conversions, and returns the data as a JSON response.

// This allows the script to access the database using the $pdo connection
require_once "../config/db.php"; // Include DB connection

// This runs a SQL query to retrieve all rows from the clicks table.
$stmt = $pdo->query("SELECT * FROM clicks");
// This converts the result into an associative array, meaning the column names become keys (id, click_id, offer_id).
$clicks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM conversions");
$conversions = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Converts both clicks and conversions arrays into JSON format.
// Sends the JSON response to the client (Postman, frontend, or another system).
echo json_encode([
    "clicks" => $clicks,
    "conversions" => $conversions
]);
?>
