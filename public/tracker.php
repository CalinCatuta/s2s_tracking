<?php
header("Content-Type: application/json");
require_once "../config/db.php"; // Include DB connection

$click_id = $_GET['click_id'] ?? null;

// I insert data into MySQL using PDO if click_id exist.
// Common Errors - SQLSTATE[HY000]: General error → Check if table exists.
if ($click_id) {
    // Why use PDO - Prevents SQL Injection (More Secure Than mysqli_query())
    // (If you insert user input directly, hackers can send malicious SQL commands) $query = "SELECT * FROM users WHERE email = '$email'";  // BAD
    
    // With PDO prepared statements, user input is sanitized automatically
    // (stmt = statement) When you prepare a database query with PDO, it returns a "statement object" $stmt to keep the code clean and readable.
    $stmt = $pdo->prepare("INSERT INTO clicks (click_id) VALUES (:click_id)");
    $stmt->execute(["click_id" => $click_id]); // SAFE

    $response = ["status" => "success", "message" => "Click ID stored"];
} else {
    $response = ["status" => "error", "message" => "No click ID provided"];
}

echo json_encode($response);
