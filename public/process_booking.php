<?php
include '../config/db.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$error = '';

// Helper functions
function calculateEstimatedWaitTime($serviceIds, $pdo) {
    if (empty($serviceIds)) return 0;
    $placeholders = implode(',', array_fill(0, count($serviceIds), '?'));
    $stmt = $pdo->prepare("SELECT SUM(Duration) FROM Services WHERE ServiceID IN ($placeholders)");
    $stmt->execute($serviceIds);
    return $stmt->fetchColumn() ?? 0;
}

function calculateEstimatedPrice($serviceIds, $pdo) {
    if (empty($serviceIds)) return 0;
    $placeholders = implode(',', array_fill(0, count($serviceIds), '?'));
    $stmt = $pdo->prepare("SELECT SUM(BasePrice) FROM Services WHERE ServiceID IN ($placeholders)");
    $stmt->execute($serviceIds);
    return $stmt->fetchColumn() ?? 0;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $step = $_POST['step'] ?? 1;
   
    if ($step == 1) {
        // Validate required fields
        if (empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['workshop_id'])) {
            $_SESSION['error'] = "Please fill all required fields";
            header("Location: book.php?step=1");
            exit();
        }

        // Store data in session
        $_SESSION['booking_data'] = [
            'make' => $_POST['make'],
            'model' => $_POST['model'],
            'year' => $_POST['year'],
            'mileage' => $_POST['mileage'] ?? null,
            'workshop_id' => $_POST['workshop_id']
        ];

        header("Location: book.php?step=2");
        exit();
    } 
    elseif ($step == 2) {
        $_SESSION['booking_data']['services'] = $_POST['services'] ?? [];
        header("Location: book.php?step=3");
        exit();
    } 
    elseif ($step == 3) {
        // Validate date and time
        if (empty($_POST['date']) || empty($_POST['time'])) {
            $_SESSION['error'] = "Please select both date and time";
            header("Location: book.php?step=3");
            exit();
        }

        // Validate date is in the future
        $selectedDate = strtotime($_POST['date']);
        if ($selectedDate < strtotime('today')) {
            $_SESSION['error'] = "Please select a future date";
            header("Location: book.php?step=3");
            exit();
        }

        $_SESSION['booking_data']['date'] = $_POST['date'];
        $_SESSION['booking_data']['time'] = $_POST['time'];
        header("Location: book.php?step=4");
        exit();
    } 
    elseif ($step == 4) {
        // Validate contact information
        $required = ['contact_name', 'contact_email', 'contact_phone'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = "Please fill all required contact information";
                header("Location: book.php?step=4");
                exit();
            }
        }

        // Validate email format
        if (!filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Please enter a valid email address";
            header("Location: book.php?step=4");
            exit();
        }

        $_SESSION['booking_data']['contact_name'] = $_POST['contact_name'];
        $_SESSION['booking_data']['contact_email'] = $_POST['contact_email'];
        $_SESSION['booking_data']['contact_phone'] = $_POST['contact_phone'];
        $_SESSION['booking_data']['special_instructions'] = $_POST['special_instructions'] ?? '';
        header("Location: book.php?step=5");
        exit();
    } 
    elseif ($step == 5 && isset($_POST['confirm_booking'])) {
        // Final validation
        if (empty($_POST['terms'])) {
            $_SESSION['error'] = "You must agree to the terms and conditions";
            header("Location: book.php?step=5");
            exit();
        }

        try {
            $pdo->beginTransaction();

            // 1. Save vehicle if not already exists
            $stmt = $pdo->prepare("SELECT VehicleID FROM Vehicle WHERE UserID = ? AND Make = ? AND Model = ? AND Year = ?");
            $stmt->execute([$userId, $_SESSION['booking_data']['make'], $_SESSION['booking_data']['model'], $_SESSION['booking_data']['year']]);
            $vehicle = $stmt->fetch();

            if (!$vehicle) {
                $stmt = $pdo->prepare("INSERT INTO Vehicle (UserID, Make, Model, Year, Mileage) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([
                    $userId,
                    $_SESSION['booking_data']['make'],
                    $_SESSION['booking_data']['model'],
                    $_SESSION['booking_data']['year'],
                    $_SESSION['booking_data']['mileage']
                ]);
                $vehicleId = $pdo->lastInsertId();
            } else {
                $vehicleId = $vehicle['VehicleID'];
            }

            // 2. Create booking with all new fields
            $bookingDateTime = date('Y-m-d H:i:s', strtotime($_SESSION['booking_data']['date'] . ' ' . $_SESSION['booking_data']['time']));
            $estimatedWaitTime = calculateEstimatedWaitTime($_SESSION['booking_data']['services'], $pdo);
            $estimatedPrice = calculateEstimatedPrice($_SESSION['booking_data']['services'], $pdo);
            
            $source = (strpos($_SERVER['HTTP_REFERER'], 'book.php') !== false) ? 'book' : 'index';
            $stmt = $pdo->prepare("INSERT INTO Booking (
                CustomerID, WorkshopID, Description, BookingDateTime, Status,
                EstimatedWaitTime, EstimatedPrice, source
            ) VALUES (?, ?, ?, ?, 'Pending', ?, ?, ?)");
            
            $stmt->execute([
                $userId,
                $_SESSION['booking_data']['workshop_id'],
                $_SESSION['booking_data']['special_instructions'],
                $bookingDateTime,
                $estimatedWaitTime,
                $estimatedPrice,
                $source
            ]);
            $bookingId = $pdo->lastInsertId();

            // 3. Add booking services
            foreach ($_SESSION['booking_data']['services'] as $serviceId) {
                $stmt = $pdo->prepare("INSERT INTO BookingServices (BookingID, ServiceID) VALUES (?, ?)");
                $stmt->execute([$bookingId, $serviceId]);
            }

            $pdo->commit();

            // Clear session data
            unset($_SESSION['booking_data']);

            // Redirect to confirmation
            header("Location: booking_status_book.php?booking_id=$bookingId");
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['error'] = "Booking failed: " . $e->getMessage();
            header("Location: book.php?step=5");
            exit();
        }
    }
    
    // Move to next step
    $nextStep = $step < 5 ? $step + 1 : $step;
    header("Location: book.php?step=$nextStep");
    exit();
} else {
    header("Location: book.php");
    exit();
}