<?php
include '../config/db.php';
session_start();

// Verify workshop admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'workshop') {
    die("Error: Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? null;
    $wait_time = $_POST['wait_time'] ?? null;
    $estimated_price = $_POST['estimated_price'] ?? null; // New price field

    if (!$booking_id || !$wait_time || !$estimated_price) { // Added price validation
        die("Error: Missing required fields (booking ID, wait time, or estimated price).");
    }

    try {
        // Verify the booking belongs to this workshop
        $stmt = $pdo->prepare("SELECT b.BookingID FROM Booking b
                             JOIN Workshop w ON b.WorkshopID = w.WorkshopID
                             WHERE b.BookingID = ? AND w.UserID = ?");
        $stmt->execute([$booking_id, $_SESSION['user_id']]);
        if (!$stmt->fetch()) {
            die("Error: Booking not found or not authorized");
        }

        // Update query now includes EstimatedPrice
        $stmt = $pdo->prepare("UPDATE Booking 
                              SET Status = 'Confirmed', 
                                  EstimatedWaitTime = ?,
                                  EstimatedPrice = ?,
                                  ConfirmationDateTime = NOW()
                              WHERE BookingID = ?");
        $stmt->execute([$wait_time, $estimated_price, $booking_id]);
        
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Error: This page only accepts POST requests.");
}
?>