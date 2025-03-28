<?php
include '../config/db.php';
$township_id = $_POST['township_id'];
$stmt = $pdo->prepare("SELECT * FROM Workshop WHERE TownshipID = ?");
$stmt->execute([$township_id]);
$workshops = $stmt->fetchAll();
?>
<?php include '../includes/header.php'; ?>

<div class="max-w-2xl mx-auto my-8 p-6 bg-white rounded-xl shadow-lg transform transition-all hover:shadow-xl">
    <div class="mb-4">
        <a href="index.php" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back 
        </a>
    </div>
    <!-- Header with animated icon -->
    <div class="flex items-center mb-6">
        <div class="mr-4 p-3 bg-blue-100 rounded-full animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">Select Workshop</h1>
    </div>

    <form method="post" action="create_booking.php" class="space-y-6">
        <input type="hidden" name="township_id" value="<?= $township_id ?>">

        <!-- Workshop Selection Cards -->
        <div class="space-y-4">
            <?php if (empty($workshops)): ?>
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-4 text-gray-600">No workshops found in this area</p>
                </div>
            <?php else: ?>
                <?php foreach ($workshops as $ws): ?>
                    <div class="workshop-card relative flex items-start p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition-all duration-300 hover:shadow-md group">
                        <label class="absolute inset-0 cursor-pointer" for="workshop_<?= $ws['WorkshopID'] ?>"></label>
                        <div class="flex items-center h-5 mt-1 z-10">
                            <input type="radio" 
                                   id="workshop_<?= $ws['WorkshopID'] ?>" 
                                   name="workshop_id" 
                                   value="<?= $ws['WorkshopID'] ?>" 
                                   required
                                   class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                        </div>
                        <div class="ml-4 z-10">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="font-medium text-gray-800 group-hover:text-blue-600"><?= $ws['WorkshopName'] ?></span>
                            </div>
                            <div class="mt-1 flex items-center text-gray-500 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <?= $ws['Address'] ?>
                            </div>
                            <?php if (!empty($ws['Phone'])): ?>
                                <div class="mt-1 flex items-center text-gray-500 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <?= $ws['Phone'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Customer Details Section -->
        <div class="pt-6 border-t border-gray-200">
            <div class="flex items-center mb-4">
                <div class="mr-3 p-2 bg-blue-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Your Problem Details</h2>
            </div>

            <div class="space-y-4">
                

                <div class="relative">
                    <div class="absolute top-3 left-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <textarea name="description" placeholder="Describe your vehicle problem" required rows="4"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
            class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:shadow-md group">
            <span>Book Now</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </form>
</div>

<!-- Floating car animation in background -->
<div class="hidden md:block fixed bottom-0 left-0 right-0 h-20 overflow-hidden opacity-30">
    <!-- Moving left cars -->
    <div class="absolute -left-20 bottom-0 animate-moveRightSlow">
        <img src="https://cdn-icons-png.flaticon.com/512/744/744465.png" class="h-16 w-16">
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
    
    
    .workshop-card:hover {
        transform: translateY(-2px);
    }
    /* Ensure the label doesn't block hover effects */
    .workshop-card label {
        pointer-events: auto;
    }
    .workshop-card > * {
        pointer-events: none;
    }
    .workshop-card input[type="radio"] {
        pointer-events: auto;
    }
</style>

<?php include '../includes/footer.php'; ?>