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
$success = '';

// Initialize step
$step = $_GET['step'] ?? 1;
if (!isset($_SESSION['booking_data'])) {
    $_SESSION['booking_data'] = [];
}

// Get available services from database
$services = [];
try {
    $stmt = $pdo->query("SELECT * FROM Services");
    $services = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Failed to load services: " . $e->getMessage();
}

// Get user's vehicles
$userVehicles = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM Vehicle WHERE UserID = ?");
    $stmt->execute([$userId]);
    $userVehicles = $stmt->fetchAll();
} catch (PDOException $e) {
    // Ignore error if no vehicles exist yet
}

include '../includes/header.php';
?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 text-center">Book Your Service Appointment</h1>
        <p class="text-gray-600 text-center mt-2">Complete the following steps to schedule your vehicle service</p>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <?php include 'includes/progress_bar.php'; ?>
        
        <form method="POST" action="process_booking.php">
            <input type="hidden" name="step" value="<?= $step ?>">
            
            <?php
            // Include the appropriate step file
            switch ($step) {
                case 1:
                    include 'step1_vehicle.php';
                    break;
                case 2:
                    include 'step2_services.php';
                    break;
                case 3:
                    include 'step3_datetime.php';
                    break;
                case 4:
                    include 'step4_contact.php';
                    break;
                case 5:
                    include 'step5_review.php';
                    break;
                default:
                    include 'step1_vehicle.php';
            }
            ?>
            
            <div class="flex justify-between mt-8">
                <?php if ($step > 1): ?>
                    <a href="?step=<?= $step - 1 ?>" class="px-6 py-2 border rounded-button text-gray-700 hover:bg-gray-50">
                        Previous
                    </a>
                <?php else: ?>
                    <div></div> <!-- Empty div for spacing -->
                <?php endif; ?>
                
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-button hover:bg-primary/90">
                    <?= $step == 5 ? 'Confirm Booking' : 'Next' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Mobile Menu Toggle
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.classList.toggle('hidden');
    }

    // Service Selection
    function toggleServiceSelection(element, serviceId) {
        const checkbox = element.querySelector('.service-checkbox div');
        const hiddenInput = element.querySelector('input[type="checkbox"]');
        
        checkbox.classList.toggle('hidden');
        hiddenInput.checked = !hiddenInput.checked;
        element.classList.toggle('border-primary');
    }

    // Time Selection
    function selectTime(element, time) {
        // Remove selection from all buttons
        document.querySelectorAll('button[onclick^="selectTime"]').forEach(btn => {
            btn.classList.remove('border-primary', 'text-primary');
            btn.classList.add('text-gray-700');
        });
        
        // Select this one
        element.classList.remove('text-gray-700');
        element.classList.add('border-primary', 'text-primary');
        
        // Update the hidden radio input
        document.querySelector(`input[name="time"][value="${time}"]`).checked = true;
    }

    // Saved Vehicle Selection
    function selectSavedVehicle(vehicle) {
        document.querySelector('select[name="make"]').value = vehicle.Make;
        document.querySelector('input[name="model"]').value = vehicle.Model;
        document.querySelector('select[name="year"]').value = vehicle.Year;
        document.querySelector('input[name="mileage"]').value = vehicle.Mileage;
    }
</script>

<?php include '../includes/footer.php'; ?>