<?php
include '../config/db.php';

$booking_id = $_GET['booking_id'] ?? null;
if (!$booking_id) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Missing booking ID']);
    exit();
}

$stmt = $pdo->prepare("SELECT Status FROM Booking WHERE BookingID = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if (!$booking) {
    header('HTTP/1.1 404 Not Found');
    echo json_encode(['error' => 'Booking not found']);
    exit();
}

header('Content-Type: application/json');
echo json_encode(['status' => $booking['Status']]);
?>