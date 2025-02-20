<?php
require_once "../config/db.php"; // Include DB connection
require_once "../api/send_postback.php";
// track_conversion Summary of Logic.

// 1️⃣ Check if click_id exists in clicks
// → If not found, return an error.
// 2️⃣ Insert a conversion record with click_id and payout.
// 3️⃣ Send a success message confirming the conversion was tracked.

// Check if click_id isn't provided in req/url
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (!isset($_GET["click_id"]) || empty($_GET["click_id"])) {
        die(json_encode(["status" => "error", "message" => "Missing click_id"]));
    }

    $click_id = $_GET["click_id"];
    $payout = $_GET["payout"] ?? 0.00;

    try {

        // The WHERE clause is used to extract only those records that fulfill a specified condition.
       // It prepares an SQL query to fetch a record from the clicks table where click_id matches the one provided in the request.

        // Use SELECT COUNT(*) Instead of SELECT * || If you just need to know how many clicks an offer received. && In reports & analytics, where you show total clicks/conversions.
        // SELECT - Loads unnecessary data into memory, making the query slow if there are millions of rows. || Returns all columns (id, click_id, offer_id, timestamp, etc.).
        // COUNT - Only returns the number of matching rows (1 number) instead of full data. || Much faster than fetching all columns.
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM clicks WHERE click_id = :click_id");
        $stmt->execute(["click_id" => $click_id]);

        // rowCount() checks how many rows were found in the clicks table.
        // If 0 rows are found, it means the click_id does not exist in the database.
        // Ensures that only tracked clicks can generate conversions.
        if ($stmt->rowCount() == 0) {
            die(json_encode(["status" => "error", "message" => "Invalid click_id"]));
        }
        
        // Inserts a new record into the conversions table, storing.
        // The placeholders (:click_id, :payout) prevent SQL injection and ensure secure query execution.
        $stmt = $pdo->prepare("INSERT INTO conversions (click_id, payout) VALUES (:click_id, :payout)");
        $stmt->execute(["click_id" => $click_id, "payout" => $payout]);

        // When a conversion happens, notify the ad network using cURL.
        sendPostback($click_id, $payout);

        echo json_encode(["status" => "success", "message" => "Conversion tracked!"]);
    } catch (PDOException $e) {
        die(json_encode(["status" => "error", "message" => $e->getMessage()]));
    }
}
?>
