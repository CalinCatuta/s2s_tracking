<?php
header("Content-Type: application/json");

// Simulate an API response
$response = [
    "message" => "API is working!",
    "timestamp" => time()
];

echo json_encode($response);
