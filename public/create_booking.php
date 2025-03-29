<?php
include '../config/db.php';
session_start();

// Get current user ID from session
$user_id = $_SESSION['user_id'] ?? null;
$workshop_id = $_POST['workshop_id'] ?? null;
$description = $_POST['description'] ?? null;

if (!$user_id || !$workshop_id || !$description) {
    die("Error: Missing required information");
}

try {
    // Verify user exists and is a customer
    $stmt = $pdo->prepare("SELECT UserID FROM Users WHERE UserID = ? AND UserType = 'customer'");
    $stmt->execute([$user_id]);
    if (!$stmt->fetch()) {
        die("Error: Invalid user or not a customer");
    }

    // Create booking
    $source = (strpos($_SERVER['HTTP_REFERER'], 'book.php') !== false) ? 'book' : 'index';
    $stmt = $pdo->prepare("INSERT INTO Booking (CustomerID, WorkshopID, Description, source) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $workshop_id, $description, $source]);
    $booking_id = $pdo->lastInsertId();

    header("Location: booking_status.php?booking_id=$booking_id");
    exit();
} catch (PDOException $e) {
    die("Booking failed: " . $e->getMessage());
}
?>