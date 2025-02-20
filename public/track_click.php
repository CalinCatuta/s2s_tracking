<?php
require_once "../config/db.php"; // Include DB connection

// Ensures only GET requests are processed.
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    //	Checks if click_id is missing || Checks if click_id is empty ("", 0, etc.). 
    if (!isset($_GET["click_id"]) || empty($_GET["click_id"])) {
        // Returns JSON error and stops execution.
        die(json_encode(["status" => "error", "message" => "Missing click_id"]));
    }

    // get values from URL
    $click_id = $_GET["click_id"];
    $offer_id = $_GET["offer_id"] ?? 0;

    try {
        $stmt = $pdo->prepare("INSERT INTO clicks (click_id, offer_id) VALUES (:click_id, :offer_id)");
        $stmt->execute(["click_id" => $click_id, "offer_id" => $offer_id]);

        echo json_encode(["status" => "success", "message" => "Click tracked!"]);
    } catch (PDOException $e) {
        die(json_encode(["status" => "error", "message" => $e->getMessage()]));
    }
}
?>
