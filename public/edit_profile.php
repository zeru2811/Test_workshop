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

// Get current user details
$stmt = $pdo->prepare("SELECT * FROM Users WHERE UserID = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    header("Location: ../auth/login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Basic validation
    if (empty($fullName) || empty($email)) {
        $error = "Full name and email are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        try {
            $pdo->beginTransaction();

            // Check if email is being changed to one that already exists
            if ($email !== $user['Email']) {
                $stmt = $pdo->prepare("SELECT UserID FROM Users WHERE Email = ? AND UserID != ?");
                $stmt->execute([$email, $userId]);
                if ($stmt->fetch()) {
                    throw new Exception("Email already in use by another account");
                }
            }

            // Handle password change if requested
            $passwordUpdate = '';
            if (!empty($newPassword)) {
                if (empty($currentPassword)) {
                    throw new Exception("Current password is required to change password");
                }
                
                if (!password_verify($currentPassword, $user['Password'])) {
                    throw new Exception("Current password is incorrect");
                }
                
                if ($newPassword !== $confirmPassword) {
                    throw new Exception("New passwords don't match");
                }
                
                if (strlen($newPassword) < 8) {
                    throw new Exception("Password must be at least 8 characters");
                }
                
                $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
                $passwordUpdate = ", Password = :password";
            }

            // Update user details
            $query = "UPDATE Users SET 
                     FullName = :full_name,
                     Email = :email,
                     PhoneNumber = :phone
                     $passwordUpdate
                     WHERE UserID = :user_id";

            $stmt = $pdo->prepare($query);
            $params = [
                ':full_name' => $fullName,
                ':email' => $email,
                ':phone' => $phone,
                ':user_id' => $userId
            ];

            if (!empty($passwordUpdate)) {
                $params[':password'] = $passwordHash;
            }

            $stmt->execute($params);
            $pdo->commit();

            // Update session with new details
            $_SESSION['user_name'] = $fullName;
            $_SESSION['user_email'] = $email;

            $success = "Profile updated successfully!";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = $e->getMessage();
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mx-auto p-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Profile</h1>
        <a href="account.php" class="text-blue-500 hover:text-blue-700">Back to Account</a>
    </div>

    <?php if ($error): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form method="POST">
            <div class="mb-4">
                <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?= htmlspecialchars($user['FullName']) ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['PhoneNumber']) ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="border-t border-gray-200 pt-4 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                    <input type="password" id="current_password" name="current_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                    <input type="password" id="new_password" name="new_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>