<?php
// Get query parameters
$click_id = $_GET["click_id"] ?? null;
$payout = $_GET["payout"] ?? null;

// Log the request (optional)
$log_entry = date("Y-m-d H:i:s") . " - Received Postback: Click ID: $click_id, Payout: $payout" . PHP_EOL;
file_put_contents("../logs/postback.log", $log_entry, FILE_APPEND);

// Simulate a response
if ($click_id) {
    echo json_encode(["status" => "success", "message" => "Postback received", "click_id" => $click_id, "payout" => $payout]);
} else {
    echo json_encode(["status" => "error", "message" => "Missing click_id"]);
}
?>
