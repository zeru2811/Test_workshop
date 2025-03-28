<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = trim($_POST['phone']);
    $userType = 'customer';

    try {
        $stmt = $pdo->prepare("INSERT INTO Users (FullName, Email, Password, PhoneNumber, UserType) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $phone, $userType]);
        
        header("Location: login.php?registered=1");
        exit();
    } catch (PDOException $e) {
        // $error = "Registration failed: " . (strpos($e->getMessage(), 'Duplicate entry') ? "Email already exists" : "Database error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration | Auto Workshop</title>
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
        .password-strength {
            height: 4px;
            transition: all 0.3s;
        }
    </style>
</head>
<body class="bg-auth min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg card-shadow overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-500 py-4 px-6">
                <div class="flex items-center justify-center">
                    <i class="fas fa-user-plus text-white text-3xl mr-3"></i>
                    <h1 class="text-2xl font-bold text-white">Create Account</h1>
                </div>
                <p class="text-indigo-100 text-center mt-1">Join our auto workshop community</p>
            </div>
            
            <!-- Form -->
            <div class="p-6">
                <?php if (isset($error)): ?>
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="space-y-4">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
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
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
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
                    
                    <!-- Password -->
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
                        <div class="mt-1 flex space-x-1">
                            <div id="strength-bar-1" class="password-strength w-1/4 bg-gray-200 rounded"></div>
                            <div id="strength-bar-2" class="password-strength w-1/4 bg-gray-200 rounded"></div>
                            <div id="strength-bar-3" class="password-strength w-1/4 bg-gray-200 rounded"></div>
                            <div id="strength-bar-4" class="password-strength w-1/4 bg-gray-200 rounded"></div>
                        </div>
                        <p id="password-hint" class="text-xs text-gray-500 mt-1">Use 8+ characters with a mix of letters, numbers & symbols</p>
                    </div>
                    
                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input type="tel" id="phone" name="phone"
                                   class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md input-focus focus:outline-none"
                                   placeholder="+959 123 456 789"
                                   value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                        </div>
                    </div>
                    
                    <!-- Terms Checkbox -->
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Account
                        </button>
                    </div>
                </form>
                
                <!-- Social Login -->
                <!-- <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">
                                Or sign up with
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fab fa-google text-red-500"></i>
                            <span class="ml-2">Google</span>
                        </a>
                        
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fab fa-facebook-f text-blue-600"></i>
                            <span class="ml-2">Facebook</span>
                        </a>
                    </div>
                </div>
            </div> -->
            
            <!-- Footer -->
            <div class="bg-white-50 px-6 py-4">
                <div class="text-sm text-center text-gray-600">
                    Already have an account? 
                    <a href="login.php" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Sign in
                    </a>
                    <!-- <span class="mx-1">·</span>
                    <a href="workshop_register.php" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Register as Workshop
                    </a> -->
                    <p  style="font-size: 10px;color:#ccc" class="mt-0">© <?= date('Y') ?> Auto Workshop. All rights reserved.</p>
                </div>
            </div>
        </div>
        
        
    </div>

    <script>
    // Password strength indicator
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const strengthBars = [
            document.getElementById('strength-bar-1'),
            document.getElementById('strength-bar-2'),
            document.getElementById('strength-bar-3'),
            document.getElementById('strength-bar-4')
        ];
        
        // Reset all bars
        strengthBars.forEach(bar => {
            bar.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-green-500');
            bar.classList.add('bg-gray-200');
        });
        
        if (password.length === 0) return;
        
        // Very weak (just 1-3 chars)
        if (password.length < 4) {
            strengthBars[0].classList.remove('bg-gray-200');
            strengthBars[0].classList.add('bg-red-500');
            return;
        }
        
        // Weak (4+ chars)
        strengthBars[0].classList.remove('bg-gray-200');
        strengthBars[0].classList.add('bg-red-500');
        strengthBars[1].classList.remove('bg-gray-200');
        strengthBars[1].classList.add('bg-red-500');
        
        // Medium (6+ chars with some complexity)
        if (password.length >= 6 && /[0-9]/.test(password)) {
            strengthBars[2].classList.remove('bg-gray-200');
            strengthBars[2].classList.add('bg-yellow-500');
        }
        
        // Strong (8+ chars with numbers and special chars)
        if (password.length >= 8 && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
            strengthBars[3].classList.remove('bg-gray-200');
            strengthBars[3].classList.add('bg-green-500');
        }
    });
    </script>
</body>
</html>