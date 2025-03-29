<?php
include '../config/db.php';
$booking_id = $_GET['booking_id'] ?? null;

$_SESSION['booking_source'] = 'index';

if (!$booking_id) {
    die("Error: Missing booking ID");
}

$stmt = $pdo->prepare("SELECT b.*, u.FullName, u.PhoneNumber, w.WorkshopName 
                      FROM Booking b
                      JOIN Users u ON b.CustomerID = u.UserID
                      JOIN Workshop w ON b.WorkshopID = w.WorkshopID
                      WHERE b.BookingID = ?");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if (!$booking) {
    die("Error: Booking not found");
}
?>

<?php include '../includes/header.php'; ?>

<div class="max-w-md mx-auto my-5 p-6 bg-white rounded-lg shadow-md">
    
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Booking Status</h1>

    <div class="space-y-4 mb-6">
        <div class="flex justify-between border-b pb-2">
            <span class="font-medium text-gray-600">Booking ID:</span>
            <span class="text-gray-800"><?= htmlspecialchars($booking['BookingID']) ?></span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span class="font-medium text-gray-600">Customer:</span>
            <span class="text-gray-800"><?= htmlspecialchars($booking['FullName']) ?></span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span class="font-medium text-gray-600">Phone:</span>
            <span class="text-gray-800"><?= htmlspecialchars($booking['PhoneNumber']) ?></span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span class="font-medium text-gray-600">Workshop:</span>
            <span class="text-gray-800"><?= htmlspecialchars($booking['WorkshopName']) ?></span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span class="font-medium text-gray-600">Status:</span>
            <span class="<?=
                            $booking['Status'] == 'Confirmed' ? 'text-green-600 font-semibold' : ($booking['Status'] == 'Completed' ? 'text-blue-600 font-semibold' : 'text-yellow-600 font-semibold')
                            ?>">
                <?= htmlspecialchars($booking['Status']) ?>
            </span>
        </div>
    </div>

    <?php if ($booking['Status'] == 'Confirmed'): ?>
            <div class="bg-blue-50 p-4 rounded-lg mb-4">
                <p class="font-medium text-blue-800">Estimated Wait Time:</p>
                <p class="text-2xl font-bold text-blue-600"><?= htmlspecialchars($booking['EstimatedWaitTime']) ?> minutes</p>
                <?php if (!empty($booking['EstimatedPrice'])): ?>
                <p class="font-medium text-blue-800 mt-2">Estimated Price:</p>
                <p class="text-2xl font-bold text-blue-600">Ks<?= htmlspecialchars(number_format($booking['EstimatedPrice'], 2)) ?></p>
                <?php endif; ?>
                <p class="text-sm text-blue-600 mt-1">Your booking has been confirmed!</p>
            </div>
            <?php elseif ($booking['Status'] == 'Completed'): ?>
        <div class="bg-green-50 p-4 rounded-lg mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="font-medium text-green-800">Service Completed</p>
            </div>
            <?php if (!empty($booking['FinalPrice'])): ?>
            <p class="font-medium text-green-800 mt-2">Final Price:</p>
            <p class="text-2xl font-bold text-green-600">Ks<?= htmlspecialchars(number_format($booking['FinalPrice'], 2)) ?></p>
            <?php endif; ?>
            <p class="text-green-600 mt-2">Thank you for choosing our service!</p>
        </div>
    <?php else: ?>
        <div class="bg-yellow-50 p-4 rounded-lg mb-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-medium text-yellow-800">Pending Confirmation</p>
            </div>
            <p class="text-yellow-600 mt-2">Your booking is being processed. Please check back later.</p>
        </div>
    <?php endif; ?>

    <div class="mt-6 pt-4 border-t border-gray-200">
        <a href="index.php" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Back to dashboard</a>
    </div>
</div>

<div class="fixed bottom-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-xs">
    Refreshing in <span id="countdown">10</span>s
</div>

<?php include '../includes/footer.php'; ?>