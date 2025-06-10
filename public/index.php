<?php include '../config/db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (($_SESSION['user_type'] ?? '') !== 'customer') {
    header("Location: ../auth/unauthorized.php");
    exit();
}

?>
<?php include '../includes/header.php'; ?>

<div style="height: 85vh;" class="mb-3 bg-gradient-to-br from-blue-50 to-gray-100 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8">
            <!-- Animated Hero Section -->
            <div class="text-center mb-8">
                <!-- Animated Tools Icon -->
                <div class="mb-6 mx-auto w-40 h-40 relative">
                    <img src="https://cdn-icons-png.flaticon.com/512/2913/2913103.png" 
                         class="absolute w-20 h-20 top-10 left-10 animate-bounce" 
                         style="animation-delay: 0.3s">

                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-2" data-translate="findYourNearestAutoWorkshop">
                    Find Expert Auto Services
                </h1>
                <p class="text-gray-600 mb-6">Select your location to discover top-rated workshops nearby</p>
            </div>
            
            <!-- Search Form -->
            <form method="post" action="select_workshop.php" class="space-y-6">
                <div class="space-y-4">
                    <!-- Location Select -->
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-500 group-hover:text-blue-600 transition-colors" 
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <select
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white hover:border-blue-400 transition-colors"
                            id="townshipSelect"
                            name="township_id"
                            required>
                            <option value="" selected disabled>Select your township</option>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM Township");
                            while ($row = $stmt->fetch()) {
                                echo "<option value='{$row['TownshipID']}'>{$row['TownshipName']}</option>";
                            }
                            ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    
        
                    
                </div>
                
                <!-- Submit Button with Animation -->
                <button
                    type="submit"
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:shadow-md group">
                    <span class="mr-2">Find Workshops</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" 
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
            
            <!-- Trust Indicators -->
            <div class="mt-8 pt-6 border-t border-gray-100">
                <div class="flex justify-center space-x-6">
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="h-5 w-5 text-green-500 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Verified Mechanics</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="h-5 w-5 text-yellow-500 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span>Customer Ratings</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Floating cars animation in background (desktop only) -->
        <div class="hidden md:block fixed bottom-0 left-0 right-0 h-20 overflow-hidden opacity-30">
            <!-- Moving left cars -->
            <div class="absolute -left-20 bottom-8 animate-moveRightSlow">
                <img src="https://cdn-icons-png.flaticon.com/512/744/744465.png" class="h-16 w-16">
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes moveLeft {
        0% { transform: translateX(calc(100vw + 100px)); }
        100% { transform: translateX(-100px); }
    }
    
    .animate-moveRightSlow {
        animation: moveLeft 30s linear infinite;
    }
    
    .animate-bounce {
        animation: bounce 2s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>

<?php include '../includes/footer.php'; ?>