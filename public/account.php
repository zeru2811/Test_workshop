<?php
include '../config/db.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

// Get user details
$stmt = $pdo->prepare("SELECT * FROM Users WHERE UserID = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Get booking history
if ($userType === 'customer') {
    $bookingQuery = "SELECT b.*, w.WorkshopName, t.TownshipName 
                   FROM Booking b
                   JOIN Workshop w ON b.WorkshopID = w.WorkshopID
                   JOIN Township t ON w.TownshipID = t.TownshipID
                   WHERE b.CustomerID = ?
                   ORDER BY b.BookingDateTime DESC";
} else { // workshop
    $bookingQuery = "SELECT b.*, u.FullName, u.PhoneNumber 
                   FROM Booking b
                   JOIN Users u ON b.CustomerID = u.UserID
                   WHERE b.WorkshopID = (SELECT WorkshopID FROM Workshop WHERE UserID = ?)
                   ORDER BY b.BookingDateTime DESC";
}

$stmt = $pdo->prepare($bookingQuery);
$stmt->execute([$userId]);
$bookings = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">My Account</h1>
        <a href="../auth/logout.php" class="text-red-500 hover:text-red-700">Logout</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Account Details -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Account Information</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Full Name</p>
                    <p class="font-medium"><?= htmlspecialchars($user['FullName']) ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium"><?= htmlspecialchars($user['Email']) ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium"><?= htmlspecialchars($user['PhoneNumber']) ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Account Type</p>
                    <p class="font-medium capitalize"><?= htmlspecialchars($user['UserType']) ?></p>
                </div>
            </div>
            <a href="edit_profile.php" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit Profile</a>
        </div>

        <!-- Booking History -->
        <div class="md:col-span-2">
            <h2 class="text-xl font-semibold mb-4">Booking History</h2>
            
            <?php if (empty($bookings)): ?>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <p class="text-gray-500">No bookings found</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($bookings as $booking): ?>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    <?php if ($userType === 'customer'): ?>
                                        <?= htmlspecialchars($booking['WorkshopName']) ?> (<?= htmlspecialchars($booking['TownshipName']) ?>)
                                    <?php else: ?>
                                        <?= htmlspecialchars($booking['FullName']) ?> (<?= htmlspecialchars($booking['PhoneNumber']) ?>)
                                    <?php endif; ?>
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    <?= date('M j, Y g:i A', strtotime($booking['BookingDateTime'])) ?>
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                <?= $booking['Status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($booking['Status'] === 'Confirmed' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') ?>">
                                <?= htmlspecialchars($booking['Status']) ?>
                            </span>
                        </div>
                        
                        <p class="mt-3 text-gray-700"><?= htmlspecialchars($booking['Description']) ?></p>
                        
                        <div class="mt-4 flex items-center space-x-3">
                            <?php if ($userType === 'customer'): ?>
                                <a href="booking_status.php?booking_id=<?= $booking['BookingID'] ?>" class="text-blue-500 hover:text-blue-700 text-sm">View Details</a>
                            <?php endif; ?>
                            
                            <?php if ($booking['Status'] === 'Pending' && $userType === 'workshop'): ?>
                                <a href="dashboard.php?booking_id=<?= $booking['BookingID'] ?>" class="text-blue-500 hover:text-blue-700 text-sm">Process Booking</a>
                            <?php endif; ?>
                            
                            <?php if ($booking['Status'] === 'Confirmed' && $userType === 'customer' && $booking['EstimatedWaitTime']): ?>
                                <span class="text-sm text-gray-500">Estimated wait: <?= $booking['EstimatedWaitTime'] ?> minutes</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="fixed bottom-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-xs">
        Refreshing in <span id="countdown">10</span>s
    </div>
</div>



<?php include '../includes/footer.php'; ?>