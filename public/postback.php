<?php
header("Content-Type: application/json");

$click_id = $_GET['click_id'] ?? null;

if ($click_id) {
    // Simulated external API (replace with real URL)
    $url = "http://localhost/s2s_tracking/public/postback.php?click_id=" . urlencode($click_id);

    // Use cURL to send request
    // cURL (Client URL Library) is a built-in PHP tool used to send and receive data from other servers over HTTP or HTTPS.
    // It lets you make API requests (GET, POST) from your PHP backend without a browser.

    // initialize a request
    $ch = curl_init($url);
    // Then, we set options (e.g., response type, headers, timeout)
    // Why we use RETURNTRANSFER (If you don’t set this option, curl_exec() will output the response to the page instead of storing it in a variable)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    // Finally, we execute the request and close it
    $response = curl_exec($ch);
    curl_close($ch);

    // Common Errors -  curl_exec() returns false → Check with curl_error($ch).
    echo json_encode(["status" => "success", "message" => "Postback sent"]);
} else {
    echo json_encode(["status" => "error", "message" => "No click ID provided"]);
}
