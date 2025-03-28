<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // User registration
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = trim($_POST['phone']);
    $userType = 'workshop';

    // Workshop details
    $workshopName = trim($_POST['workshop_name']);
    $address = trim($_POST['address']);
    $townshipId = $_POST['township_id'];

    try {
        $pdo->beginTransaction();
        
        // Create user
        $stmt = $pdo->prepare("INSERT INTO Users (FullName, Email, Password, PhoneNumber, UserType) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $phone, $userType]);
        $userId = $pdo->lastInsertId();
        
        // Create workshop
        $stmt = $pdo->prepare("INSERT INTO Workshop (UserID, WorkshopName, Address, TownshipID) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $workshopName, $address, $townshipId]);
        
        $pdo->commit();
        header("Location: login.php?workshop_registered=1");
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error = "Registration failed: " . (strpos($e->getMessage(), 'Duplicate entry') !== false ? "Email already exists" : "Database error");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Registration | Auto Workshop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .bg-auth {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .input-focus:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        .section-divider {
            border-top: 1px dashed #d1d5db;
            margin: 1.5rem 0;
            position: relative;
        }
        .section-divider::before {
            content: attr(data-title);
            position: absolute;
            top: -0.75rem;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 0 1rem;
            color: #6b7280;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="bg-auth min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-lg card-shadow overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 py-4 px-6">
                <div class="flex items-center justify-center">
                    <i class="fas fa-tools text-white text-3xl mr-3"></i>
                    <h1 class="text-2xl font-bold text-white">Workshop Registration</h1>
                </div>
                <p class="text-indigo-100 text-center mt-1">Register your auto workshop business</p>
            </div>
            
            <!-- Form -->
            <div class="px-6 pt-6 pb-2">
                <?php if (isset($error)): ?>
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="space-y-4">
                    <!-- Account Details Section -->
                    <div class="section-divider" data-title="Account Information"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="name" name="name" required
                                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md input-focus focus:outline-none"
                                       placeholder="John Doe"
                                       value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>">
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" required
                                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md input-focus focus:outline-none"
                                       placeholder="you@example.com"
                                       value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password" required
                                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md input-focus focus:outline-none"
                                       placeholder="••••••••">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" id="phone" name="phone" required
                                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md input-focus focus:outline-none"
                                       placeholder="+959 123 456 789"
                                       value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Workshop Details Section -->
                    <div class="section-divider" data-title="Workshop Information"></div>
                    
                    <div>
                        <label for="workshop_name" class="block text-sm font-medium text-gray-700 mb-1">Workshop Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-store text-gray-400"></i>
                            </div>
                            <input type="text" id="workshop_name" name="workshop_name" required
                                   class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md input-focus focus:outline-none"
                                   placeholder="My Auto Workshop"
                                   value="<?= isset($_POST['workshop_name']) ? htmlspecialchars($_POST['workshop_name']) : '' ?>">
                        </div>
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <input type="text" id="address" name="address" required
                                   class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md input-focus focus:outline-none"
                                   placeholder="123 Main Street, Township"
                                   value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>">
                        </div>
                    </div>
                    
                    <div>
                        <label for="township_id" class="block text-sm font-medium text-gray-700 mb-1">Township</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map text-gray-400"></i>
                            </div>
                            <select id="township_id" name="township_id" required
                                    class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md input-focus focus:outline-none appearance-none">
                                <option value="">Select Township</option>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM Township");
                                while ($row = $stmt->fetch()) {
                                    $selected = isset($_POST['township_id']) && $_POST['township_id'] == $row['TownshipID'] ? 'selected' : '';
                                    echo "<option value='{$row['TownshipID']}' $selected>{$row['TownshipName']}</option>";
                                }
                                ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Terms and Submit -->
                    <div class="pt-4">
                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox" required
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <button type="submit" 
                                class="w-full mt-4 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Register Workshop
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4">
                <div class="text-sm text-center text-gray-600">
                    Already have an account? 
                    <a href="login.php" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Sign in
                    </a>
                    <p style="font-size: 10px;color:#ccc" class="mt-3">© <?= date('Y') ?> Auto Workshop. All rights reserved.</p>
                </div>
            </div>
        </div>
        
       
    </div>
</body>
</html>