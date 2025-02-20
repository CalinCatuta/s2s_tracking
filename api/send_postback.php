<?php
// This function sends a server-to-server (S2S) postback request to notify an ad network when a conversion occurs. It uses cURL to make an HTTP request.
function sendPostback($click_id, $payout) {
    // Use http_build_query() for safer URL encoding
    $query = http_build_query(["click_id" => $click_id, "payout" => $payout]);
    $postback_url = "http://localhost/s2s_tracking/public/fake_postback.php?" . $query;

    // Initializes a cURL session and sets the request URL ($postback_url).
    // This means cURL will send a request to the ad network at this URL.
    $ch = curl_init($postback_url);
    // Tells cURL to return the response instead of printing it.
    // If true, we can capture the response in a variable.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // If the ad network does not respond in 10 seconds, the request will be canceled to prevent script freezing.
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    // Executes the cURL request (sends the postback to the ad network).
    // The response from the network is stored in $response.
    $response = curl_exec($ch);

    // Check for cURL errors
    if ($response === false) {
        $error = "cURL Error: " . curl_error($ch);
        logPostback($click_id, $payout, "ERROR", $error);
        return $error;
    }   
    
    // Closes the cURL session to free up system resources.
    curl_close($ch);

    // Log the postback request & response
    logPostback($click_id, $payout, "SUCCESS", $response);

    // Returns the response from the ad network (e.g., "OK", "Success", or an error message).
    return $response;
}

// Function to log postbacks
function logPostback($click_id, $payout, $status, $message) {
    $logFile = __DIR__ . "/../logs/postback.log";  // Path to logs folder
    $timestamp = date("Y-m-d H:i:s");  // Get current time

    // Create log entry
    $logEntry = "[$timestamp] Status: $status | Click ID: $click_id | Payout: $payout | Response: $message\n";

    // Write to log file
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}
?>
