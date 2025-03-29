<?php
session_start();
include '../includes/header.php';
?>

<div style="height:85vh;" class=" flex flex-col justify-center items-center bg-gray-50">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md text-center">
        <div class="text-red-500 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Access Denied</h2>
        <p class="text-gray-600 mb-6">You don't have permission to access this page. Please contact the administrator if you believe this is an error.</p>
        
        <div class="flex justify-center space-x-4">
            <a href="../public/index.php" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Return Home
            </a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../auth/login.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

