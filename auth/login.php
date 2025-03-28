<?php
include '../config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['user_type'] = $user['UserType'];
        $_SESSION['user_name'] = $user['FullName'];
        
        if ($user['UserType'] === 'workshop') {
            $stmt = $pdo->prepare("SELECT WorkshopID FROM Workshop WHERE UserID = ?");
            $stmt->execute([$user['UserID']]);
            $workshop = $stmt->fetch();
            $_SESSION['workshop_id'] = $workshop['WorkshopID'];
        }
        if (isset($_POST['remember_me'])) {
            // Set cookie to expire in 30 days
            setcookie('remember_user', $user['UserID'], time() + (30 * 24 * 60 * 60), '/');
        }
        
        header("Location: ../public/" . ($user['UserType'] === 'workshop' ? 'dashboard.php' : 'index.php'));
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Auto Workshop</title>
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
            border-color:rgb(99, 170, 241);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
    </style>
</head>
<body class="bg-auth min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg card-shadow overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 py-4 px-6">
                <div class="flex items-center justify-center">
                    <i class="fas fa-car-alt text-white text-3xl mr-3"></i>
                    <h1 class="text-2xl font-bold text-white">Auto Workshop</h1>
                </div>
                <p class="text-indigo-100 text-center mt-1">Sign in to your account</p>
            </div>
            
            <!-- Form -->
            <div class="p-6">
            <?php if (isset($_GET['registered']) || isset($_GET['workshop_registered'])): ?>
                    <style>
                        .alert-message {
                            transition: opacity 0.5s ease-out;
                        }
                    </style>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(function() {
                                const alerts = document.querySelectorAll('.alert-message');
                                alerts.forEach(alert => {
                                    alert.style.opacity = '0';
                                    setTimeout(() => alert.remove(), 500);
                                });
                            }, 5000); 
                        });
                    </script>
                <?php endif; ?>

                <?php if (isset($_GET['registered'])): ?>
                    <div class="alert-message mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        Registration successful! Please login.
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['workshop_registered'])): ?>
                    <div class="alert-message mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        Workshop registration submitted for approval.
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" required
                                   class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md input-focus focus:outline-none"
                                   placeholder="you@example.com">
                        </div>
                    </div>
                    
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
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>
                        
                        <div class="text-sm">
                            <a href="forgot_password.php" class="font-medium text-blue-600 hover:text-indigo-500">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Sign in
                        </button>
                    </div>
                </form>
                
                
            
            <!-- Footer -->
            <div class="bg-white-50 px-6 py-4">
                <div class="text-sm text-center text-gray-600">
                    Don't have an account? 
                    <a href="register.php" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Register as Customer
                    </a>
                    <!-- <span class="mx-1">·</span> -->
                    <!-- <a href="workshop_register.php" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Register as Workshop
                    </a> -->
                    <p style="font-size: 10px;color:#ccc" class="mt-3">© <?= date('Y') ?> Auto Workshop. All rights reserved.</p>
                </div>
            </div>
        </div>
        
        <div class=" text-center text-sm text-gray-600">
            
        </div>
    </div>
</body>
</html>