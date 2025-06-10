<?php
include '../config/db.php';
session_start();

// Redirect if not admin (uncomment when ready)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (($_SESSION['user_type'] ?? '') !== 'workshop') {
    header("Location: ../auth/unauthorized.php");
    exit();
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $bookingId = $_POST['booking_id'];
    $newStatus = $_POST['status'];

    try {
        // Build dynamic update query
        $updates = ["Status = ?"];
        $params = [$newStatus];

        // Set timestamps based on status
        if ($newStatus == 'Confirmed') {
            $updates[] = "ConfirmationDateTime = NOW()";
        } elseif ($newStatus == 'Completed') {
            $updates[] = "CompletionDateTime = NOW()";

            // Update final price if provided
            if (isset($_POST['final_price']) && is_numeric($_POST['final_price'])) {
                $updates[] = "FinalPrice = ?";
                $params[] = $_POST['final_price'];
            }
        }

        $params[] = $bookingId;
        $sql = "UPDATE Booking SET " . implode(', ', $updates) . " WHERE BookingID = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $_SESSION['success'] = "Booking status updated successfully!";
        header("Location: status_management.php");
        exit();
    } catch (PDOException $e) {
        $error = "Error updating status: " . $e->getMessage();
    }
}

// Get all bookings with workshop information
$bookings = [];
try {
    $stmt = $pdo->query("
        SELECT b.*, v.Make, v.Model, v.Year, w.WorkshopName AS WorkshopName,
               GROUP_CONCAT(s.Name SEPARATOR ', ') AS Services
        FROM Booking b
        JOIN Vehicle v ON b.CustomerID = v.UserID
        JOIN Workshop w ON b.WorkshopID = w.WorkshopID
        LEFT JOIN BookingServices bs ON b.BookingID = bs.BookingID
        LEFT JOIN Services s ON bs.ServiceID = s.ServiceID
        WHERE b.source = 'book'
        GROUP BY b.BookingID
        ORDER BY b.BookingID DESC
    ");
    $bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error fetching bookings: " . $e->getMessage();
}

include '../includes/header.php';
?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Booking Status Management</h1>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <?php if (empty($bookings)): ?>
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No bookings found</h3>
                <p class="mt-1 text-sm text-gray-500">There are currently no bookings to display.</p>
                <!-- <div class="mt-6">
                    <a href="book.php" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Create New Booking
                    </a>
                </div> -->
            </div>
        <?php else: ?>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Vehicle</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Services</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Date & Time</th>
                        <!-- <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Workshop</th> -->
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Est. Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Final Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($bookings as $booking): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">#<?= $booking['BookingID'] ?></td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= htmlspecialchars($booking['Make']) ?> <?= htmlspecialchars($booking['Model']) ?> (<?= $booking['Year'] ?>)
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">
                                <?= htmlspecialchars($booking['Services']) ?>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('M j, Y g:i A', strtotime($booking['BookingDateTime'])) ?>
                            </td>
                           
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                Ks<?= number_format($booking['EstimatedPrice'] ?? 0, 2) ?>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $booking['FinalPrice'] ? 'Ks' . number_format($booking['FinalPrice'], 2) : '-' ?>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?= $booking['Status'] == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' ?>
                                <?= $booking['Status'] == 'Confirmed' ? 'bg-blue-100 text-blue-800' : '' ?>
                                <?= $booking['Status'] == 'Completed' ? 'bg-green-100 text-green-800' : '' ?>">
                                    <?= $booking['Status'] ?>
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <form method="POST" class="flex flex-col space-y-2">
                                    <input type="hidden" name="booking_id" value="<?= $booking['BookingID'] ?>">
                                    <select name="status" class="border rounded px-2 py-1 text-sm">
                                        <option value="Pending" <?= $booking['Status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Confirmed" <?= $booking['Status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                        <option value="Completed" <?= $booking['Status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                    </select>

                                    <?php if ($booking['Status'] == 'Completed' || $_POST['status'] == 'Completed'): ?>
                                        <input type="number" name="final_price" step="0.01" min="0"
                                            value="<?= $booking['FinalPrice'] ?? '' ?>"
                                            placeholder="Final price"
                                            class="border rounded px-2 py-1 text-sm w-full">
                                    <?php endif; ?>

                                    <button type="submit" name="update_status" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<div class="fixed bottom-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-xs">
    Refreshing in <span id="countdown">10</span>s
</div>

<?php include '../includes/footer.php'; ?>