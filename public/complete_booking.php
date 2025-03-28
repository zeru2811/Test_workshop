<?php
include '../config/db.php';
session_start();

// Verify workshop admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'workshop') {
    die("Error: Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? null;
    $final_price = $_POST['final_price'] ?? null; // New final price field
    
    if (!$booking_id) {
        die("Error: Missing booking ID");
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

        // Try with CompletionDateTime and FinalPrice if columns exist
        try {
            $stmt = $pdo->prepare("UPDATE Booking 
                                  SET Status = 'Completed',
                                      CompletionDateTime = NOW(),
                                      FinalPrice = ?
                                  WHERE BookingID = ?");
            $stmt->execute([$final_price, $booking_id]);
        } catch (PDOException $e) {
            // Fallback if columns don't exist
            try {
                $stmt = $pdo->prepare("UPDATE Booking 
                                      SET Status = 'Completed',
                                          CompletionDateTime = NOW()
                                      WHERE BookingID = ?");
                $stmt->execute([$booking_id]);
            } catch (PDOException $e) {
                // Final fallback if only status needs updating
                $stmt = $pdo->prepare("UPDATE Booking 
                                      SET Status = 'Completed'
                                      WHERE BookingID = ?");
                $stmt->execute([$booking_id]);
            }
        }
        
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    die("Error: This page only accepts POST requests.");
}
?>