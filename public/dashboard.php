<?php
include '../config/db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Get workshop ID for the logged-in user
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT WorkshopID FROM Workshop WHERE UserID = ?");
$stmt->execute([$userId]);
$workshop = $stmt->fetch();

if ($workshop) {
    $workshop_id = $workshop['WorkshopID'];
} else {
    // No workshop found for this user
    header("Location: ../auth/login.php");
    exit();
}

// Now you can use $workshop_id in your dashboard
?>
<?php include '../includes/header.php'; ?>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Bookings</h2>
    <?php
    $stmt = $pdo->prepare("SELECT b.*, u.FullName, u.PhoneNumber 
                         FROM Booking b
                         JOIN Users u ON b.CustomerID = u.UserID
                         WHERE b.WorkshopID = ? AND b.Status IN ('Pending', 'Confirmed')");
    $stmt->execute([$workshop_id]);
    $bookings = $stmt->fetchAll();
    
    if (empty($bookings)): ?>
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
            <h3 class="text-xl font-medium text-gray-700">No Active Bookings</h3>
            <p class="text-gray-500 mt-1">You currently have no pending or confirmed bookings.</p>
        </div>
    <?php else: 
        foreach ($bookings as $booking): ?>
        <div class="bg-white shadow-md rounded-lg p-6 mb-4 border border-gray-200 my-5 py-5">
            <h3 class="text-lg font-bold text-gray-800 my-2">Booking #<?= $booking['BookingID'] ?></h3>
            <p class="text-gray-700 my-2"><strong>Customer:</strong> <?= $booking['FullName'] ?> (<?= $booking['PhoneNumber'] ?>)</p>
            <p class="text-gray-700 my-2"><strong>Problem:</strong> <?= $booking['Description'] ?></p>
            <p class="text-gray-700 my-2"><strong>Status:</strong> 
                <span class="px-2 py-1 rounded-md my-2"
                    <?= $booking['Status'] == 'Pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-blue-200 text-blue-800' ?>">
                    <?= $booking['Status'] ?>
                </span>
            </p>
            
            <?php if ($booking['Status'] == 'Pending'): ?>
            <form method="POST" action="/auto_workshop/public/confirm_booking.php" class="mt-4">
                <input type="hidden" name="booking_id" value="<?= $booking['BookingID'] ?>">
                <label class="block mb-2 text-gray-700">Wait Time (minutes):
                    <input type="number" name="wait_time" required class="mt-1 p-2 border border-gray-300 rounded-md w-full required">
                </label>
                <label class="block mb-2 text-gray-700">Estimated Price (Ks):
                    <input type="number" name="estimated_price" step="0.01" required class="mt-1 p-2 border border-gray-300 rounded-md w-full required">
                </label>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Confirm</button>
            </form>
            <?php elseif ($booking['Status'] == 'Confirmed'): ?>
            <form method="POST" action="/auto_workshop/public/complete_booking.php" class="mt-4">
                <input type="hidden" name="booking_id" value="<?= $booking['BookingID'] ?>">
                <label class="block mb-2 text-gray-700">Final Price (Ks):
                    <input type="number" name="final_price" step="0.01" min="0" class="mt-1 p-2 border border-gray-300 rounded-md w-full required">
                </label>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mark as Done</button>
            </form>
            <?php endif; ?>
        </div>
        <?php endforeach; 
    endif; ?>
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


