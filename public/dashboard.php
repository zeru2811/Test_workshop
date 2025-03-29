<?php
include '../config/db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Check if user is a workshop
if (($_SESSION['user_type'] ?? '') !== 'workshop') {
    header("Location: ../auth/unauthorized.php");
    exit();
}

// Get workshop info for the logged-in user
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT WorkshopID, WorkshopName FROM Workshop WHERE UserID = ?");
$stmt->execute([$userId]);
$workshop = $stmt->fetch();

if (!$workshop) {
    header("Location: ../auth/login.php");
    exit();
}

$workshop_id = $workshop['WorkshopID'];
$workshop_name = $workshop['WorkshopName'];


// Get bookings with workshop name
$stmt = $pdo->prepare("SELECT b.*, u.FullName, u.PhoneNumber, w.WorkshopName
                     FROM Booking b
                     JOIN Users u ON b.CustomerID = u.UserID
                     JOIN Workshop w ON b.WorkshopID = w.WorkshopID
                     WHERE b.WorkshopID = ? AND b.source = 'index' AND b.Status IN ('Pending', 'Confirmed') 
                     ORDER BY b.BookingID DESC");
$stmt->execute([$workshop_id]);
$bookings = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<div class="container mx-auto p-6">
    <!-- Show workshop name in heading -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold"><?= htmlspecialchars($workshop_name) ?> Bookings</h2>
        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">
            Workshop Dashboard
        </span>
    </div>

    <?php if (empty($bookings)): ?>
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-xl font-medium text-gray-700 mt-3">No Active Bookings</h3>
            <p class="text-gray-500 mt-1">You currently have no pending or confirmed bookings.</p>
        </div>
    <?php else: ?>
        <?php foreach ($bookings as $booking): ?>
        <div class="bg-white shadow-md rounded-lg p-6 mb-4 border border-gray-200">
            <div class="flex justify-between items-start mb-2">
                <h3 class="text-lg font-bold text-gray-800">Booking #<?= $booking['BookingID'] ?></h3>
                <span class="px-2 py-1 rounded-md text-sm font-medium
                    <?= $booking['Status'] == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' ?>">
                    <?= $booking['Status'] ?>
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                <div>
                    <p class="text-gray-600"><strong>Customer:</strong></p>
                    <p><?= htmlspecialchars($booking['FullName']) ?></p>
                    <p class="text-gray-500"><?= htmlspecialchars($booking['PhoneNumber']) ?></p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>Workshop:</strong></p>
                    <p><?= htmlspecialchars($booking['WorkshopName']) ?></p>
                </div>
            </div>
            
            <p class="text-gray-700 mb-4"><strong>Service Description:</strong><br>
            <?= !empty($booking['Description']) ? htmlspecialchars($booking['Description']) : 'No description provided' ?></p>
            
            <?php if ($booking['Status'] == 'Pending'): ?>
            <form method="POST" action="/auto_workshop/public/confirm_booking.php" class="mt-4 space-y-3">
                <input type="hidden" name="booking_id" value="<?= $booking['BookingID'] ?>">
                <div>
                    <label class="block text-gray-700 mb-1">Wait Time (minutes):</label>
                    <input type="number" name="wait_time" required 
                           class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Estimated Price (Ks):</label>
                    <input type="number" name="estimated_price" step="0.01" required 
                           class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <button type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition">
                    Confirm Booking
                </button>
            </form>
            <?php elseif ($booking['Status'] == 'Confirmed'): ?>
            <form method="POST" action="/auto_workshop/public/complete_booking.php" class="mt-4">
                <input type="hidden" name="booking_id" value="<?= $booking['BookingID'] ?>">
                <div class="mb-3">
                    <label class="block text-gray-700 mb-1">Final Price (Ks):</label>
                    <input type="number" name="final_price" step="0.01" min="0" required 
                           class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <button type="submit" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md transition">
                    Mark as Completed
                </button>
            </form>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <div class="fixed bottom-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-xs">
        Refreshing in <span id="countdown">10</span>s
    </div>
</div>

<script>
    let seconds = 10;
    const countdownEl = document.getElementById('countdown');
        
    const timer = setInterval(() => {
        seconds--;
        countdownEl.textContent = seconds;
            
        if(seconds <= 0) {
            clearInterval(timer);
            window.location.reload();
        }
    }, 1000);
</script>
