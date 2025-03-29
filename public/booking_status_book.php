<?php
include '../config/db.php';
session_start();

// Redirect if not logged in or missing booking ID
if (!isset($_GET['booking_id']) || !isset($_SESSION['user_id'])) {
    header("Location: book.php");
    exit();
}

$_SESSION['booking_source'] = 'book';

$bookingId = (int)$_GET['booking_id'];
$userId = (int)$_SESSION['user_id'];
$userType = $_SESSION['user_type'] ?? 'customer';
$error = null;
$booking = null;


try {
    // Base query with all necessary joins
    $query = "
        SELECT b.*, 
               v.Make, v.Model, v.Year, 
               w.WorkshopName, w.Address AS WorkshopAddress,
               u.FullName AS CustomerName, u.PhoneNumber AS CustomerPhone,
               uw.PhoneNumber AS WorkshopPhone, uw.Email AS WorkshopEmail,
               GROUP_CONCAT(s.Name SEPARATOR ', ') AS Services,
               SUM(s.BasePrice) AS EstimatedPrice
        FROM Booking b
        JOIN Users u ON b.CustomerID = u.UserID
        JOIN Vehicle v ON u.UserID = v.UserID
        JOIN Workshop w ON b.WorkshopID = w.WorkshopID
        JOIN Users uw ON w.UserID = uw.UserID  
        LEFT JOIN BookingServices bs ON b.BookingID = bs.BookingID
        LEFT JOIN Services s ON bs.ServiceID = s.ServiceID
        WHERE b.BookingID = ? 
        AND (b.CustomerID = ? OR w.UserID = ?)
        GROUP BY b.BookingID
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$bookingId, $userId, $userId]);
    $booking = $stmt->fetch();

    if (!$booking) {
        // Additional check to see if booking exists but user doesn't have access
        $checkStmt = $pdo->prepare("SELECT BookingID FROM Booking WHERE BookingID = ?");
        $checkStmt->execute([$bookingId]);
        if (!$checkStmt->fetch()) {
            throw new Exception("Booking #$bookingId not found in system");
        } else {
            throw new Exception("You don't have permission to view this booking");
        }
    }

    // Format prices for display
    $booking['EstimatedPrice'] = $booking['EstimatedPrice'] ? number_format($booking['EstimatedPrice'], 2) : 'N/A';
    $booking['FinalPrice'] = $booking['FinalPrice'] ? number_format($booking['FinalPrice'], 2) : 'N/A';

} catch (PDOException $e) {
    // For debugging - show full error details
    $error = "Database Error: " . $e->getMessage() . "<br>";
    $error .= "Query: " . str_replace(["\n", "\r", "\t"], ' ', $query) . "<br>";
    $error .= "Parameters: " . print_r([$bookingId, $userId, $userId], true);

    // Log the complete error
    error_log("Full Error Details: " . $error);
} catch (Exception $e) {
    $error = $e->getMessage();
}
// In your functions.php or at the top of your file
function formatPhoneForWhatsApp($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    // For Myanmar numbers (replace with your country code if needed)
    if (substr($phone, 0, 1) === '0') {
        return '95' . substr($phone, 1);
    }
    return $phone;
}

function formatPhoneForViber($phone) {
    return formatPhoneForWhatsApp($phone);
}

include '../includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($error) ?>
            <p class="mt-2 text-sm">Need help? Contact our support team.</p>
        </div>
        <a href="index.php" class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Return Home
        </a>
    <?php elseif ($booking): ?>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Booking #<?= $booking['BookingID'] ?>
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Created on <?= date('M j, Y', strtotime($booking['BookingDateTime'])) ?>
                        </p>
                    </div>
                    <span class="mt-2 sm:mt-0 px-3 py-1 rounded-full text-sm font-medium 
                        <?= $booking['Status'] == 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' ?>
                        <?= $booking['Status'] == 'Confirmed' ? 'bg-blue-100 text-blue-800' : '' ?>
                        <?= $booking['Status'] == 'Completed' ? 'bg-green-100 text-green-800' : '' ?>">
                        <?= $booking['Status'] ?>
                    </span>
                </div>
            </div>
            
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <!-- Vehicle Information -->
                    <div class="sm:col-span-1">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Vehicle Details</h4>
                        <div class="space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Make & Model</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?= htmlspecialchars($booking['Make']) ?> <?= htmlspecialchars($booking['Model']) ?> (<?= $booking['Year'] ?>)
                                </dd>
                            </div>
                            <?php if ($userType === 'workshop'): ?>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Customer</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?= htmlspecialchars($booking['CustomerName']) ?>
                                        <br><?= htmlspecialchars($booking['CustomerPhone']) ?>
                                    </dd>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Workshop Information -->
                    <div class="sm:col-span-1">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Workshop Details</h4>
                        <div class="space-y-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Workshop</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?= htmlspecialchars($booking['WorkshopName']) ?>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?= htmlspecialchars($booking['WorkshopAddress']) ?>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Contact</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?= htmlspecialchars($booking['WorkshopPhone']) ?>
                                </dd>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="sm:col-span-2">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Booking Details</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Appointment Time</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?= date('F j, Y g:i A', strtotime($booking['BookingDateTime'])) ?>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Services</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?= htmlspecialchars($booking['Services']) ?>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Special Instructions</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?= !empty($booking['Description']) ? htmlspecialchars($booking['Description']) : 'None provided' ?>
                                </dd>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="sm:col-span-2 border-t border-gray-200 pt-4">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Pricing</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Estimated Price</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    Ks<?= $booking['EstimatedPrice'] ?>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Final Price</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?= $booking['FinalPrice'] !== 'N/A' ? 'Ks' . $booking['FinalPrice'] : 'Not finalized' ?>
                                </dd>
                            </div>
                            <?php if ($booking['EstimatedWaitTime']): ?>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estimated Time</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <?= $booking['EstimatedWaitTime'] ?> minutes
                                    </dd>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3">
            <a href="<?= $userType === 'customer' ? 'account.php' : 'index.php' ?>" 
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                Back to <?= $userType === 'customer' ? 'My Bookings' : 'Dashboard' ?>
            </a>
            
            <?php if ($userType === 'workshop' && $booking['Status'] === 'Pending'): ?>
                <a href="confirm_booking.php?id=<?= $booking['BookingID'] ?>" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Process Booking
                </a>
            <?php endif; ?>
            
            <?php if ($booking['Status'] === 'Confirmed'): ?>
            <!-- Button trigger -->
            <button onclick="openContactModal(<?= $booking['BookingID'] ?>, <?= $booking['WorkshopID'] ?>)" 
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Contact Workshop
            </button>

            <!-- Modal -->
            <div id="contact-modal-<?= $booking['BookingID'] ?>" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-96">
                    <h3 class="text-lg font-bold mb-4">Contact Workshop</h3>

                    <div class="space-y-3">
                        <!-- Phone Call -->
                        <a href="tel:<?= htmlspecialchars($booking['WorkshopPhone']) ?>" 
                           class="flex items-center p-3 bg-gray-100 rounded hover:bg-gray-200">
                           <i class="fas fa-phone text-blue-600 mr-3"></i>
                           <span>Call: <?= htmlspecialchars($booking['WorkshopPhone']) ?></span>
                        </a>
            
                        <!-- WhatsApp -->
                        <!-- <a href="https://wa.me/<?= formatPhoneForWhatsApp($booking['WorkshopPhone']) ?>" 
                           class="flex items-center p-3 bg-gray-100 rounded hover:bg-gray-200">
                           <i class="fab fa-whatsapp text-green-600 mr-3"></i>
                           <span>WhatsApp Chat</span>
                        </a> -->
            
                        <!-- Viber -->
                        <a href="viber://add?number=<?= formatPhoneForViber($booking['WorkshopPhone']) ?>" 
                           class="flex items-center p-3 bg-gray-100 rounded hover:bg-gray-200">
                           <i class="fab fa-viber text-purple-600 mr-3"></i>
                           <span>Viber Chat</span>
                        </a>
            
                        <!-- Email (if available) -->
                        <?php if (!empty($booking['WorkshopEmail'])): ?>
                        <a href="mailto:<?= htmlspecialchars($booking['WorkshopEmail']) ?>" 
                           class="flex items-center p-3 bg-gray-100 rounded hover:bg-gray-200">
                           <i class="fas fa-envelope text-red-600 mr-3"></i>
                           <span>Email: <?= htmlspecialchars($booking['WorkshopEmail']) ?></span>
                        </a>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button onclick="closeContactModal(<?= $booking['BookingID'] ?>)" 
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            Close
                        </button>
                    </div>
                </div>
            </div>

            <script>
            function openContactModal(bookingId, workshopId) {
                document.getElementById(`contact-modal-${bookingId}`).classList.remove('hidden');
            }
            function closeContactModal(bookingId) {
                document.getElementById(`contact-modal-${bookingId}`).classList.add('hidden');
            }
            </script>
            <?php endif; ?>
        </div>
        
    <?php endif; ?>
</div>

<div class="fixed bottom-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-xs">
    Refreshing in <span id="countdown">10</span>s
</div>

<?php include '../includes/footer.php'; ?>