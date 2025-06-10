<?php 
include '../includes/header.php';
require_once '../config/db.php'; // Database connection
?>

<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Our Vehicle Service Network</h1>
    
    <!-- Service Overview -->
    <div class="bg-blue-50 rounded-lg p-6 mb-12">
        <div class="md:flex items-center">
            <div class="md:w-1/3 text-center mb-6 md:mb-0 mr-4 rounded">
                <img src="../image.png" alt="" class="rounded">
            </div>
            <div class="md:w-2/3">
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Connecting You to Quality Service</h2>
                <p class="text-gray-700 mb-4">
                    We partner with trusted workshops across Mandalay to bring you convenient, 
                    reliable vehicle maintenance services. Our platform makes it easy to find, 
                    book, and manage your vehicle services with our network partners.
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">200+ Partner Workshops</span>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">24/7 Booking</span>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Quality Guaranteed</span>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">How Our Service Works</h2>
    <div class="grid md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-blue-600 text-3xl mb-3">1</div>
            <h3 class="font-semibold text-lg mb-2">Tell Us Your Needs</h3>
            <p class="text-gray-600">
                Describe your vehicle service requirements through our app, website, or hotline.
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-blue-600 text-3xl mb-3">2</div>
            <h3 class="font-semibold text-lg mb-2">We Match You</h3>
            <p class="text-gray-600">
                Our system connects you with the best workshop for your specific needs.
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="text-blue-600 text-3xl mb-3">3</div>
            <h3 class="font-semibold text-lg mb-2">Seamless Service</h3>
            <p class="text-gray-600">
                Enjoy convenient booking, transparent pricing, and quality service.
            </p>
        </div>
    </div>

    <!-- Service Benefits -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Why Use Our Service?</h2>
    <div class="grid md:grid-cols-2 gap-6 mb-12">
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <div class="flex items-start">
                <div class="text-green-500 text-xl mr-4 mt-1">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-2">Verified Workshops</h3>
                    <p class="text-gray-600">
                        All partner workshops are thoroughly vetted for quality standards, 
                        equipment, and technician qualifications.
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <div class="flex items-start">
                <div class="text-green-500 text-xl mr-4 mt-1">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-2">Price Transparency</h3>
                    <p class="text-gray-600">
                        Get upfront pricing with no hidden fees. We negotiate fair rates 
                        with our partner workshops.
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <div class="flex items-start">
                <div class="text-green-500 text-xl mr-4 mt-1">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-2">Service Guarantee</h3>
                    <p class="text-gray-600">
                        We stand behind every service booked through our platform with 
                        a 30-day satisfaction guarantee.
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <div class="flex items-start">
                <div class="text-green-500 text-xl mr-4 mt-1">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-2">Convenient Booking</h3>
                    <p class="text-gray-600">
                        Book services anytime through our mobile app or website, with 
                        flexible scheduling options.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .service-icon {
          display: none; /* Hide the SVG container but keep symbols available */
        }

        .service-card:hover svg {
          transform: scale(1.1);
          transition: transform 0.3s ease;
        }
    </style>


    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Our Professional Automotive Services</h1>
    
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $services = [
                [
                    'id' => 'oil',
                    'icon' => 'oil-change',
                    'name' => 'Premium Oil Change',
                    'desc' => 'Complete oil and filter replacement using top-tier synthetic oils.',
                    'features' => ['Full synthetic options', 'Oil filter included', 'Multi-point inspection'],
                    'details' => 'Our premium oil change service includes up to 5 quarts of full synthetic oil, a premium oil filter replacement, and a 15-point vehicle inspection. Recommended every 5,000 miles or 6 months.',
                    'price' => '$69.99'
                ],
                [
                    'id' => 'brake',
                    'icon' => 'brake-service',
                    'name' => 'Brake System Service',
                    'desc' => 'Comprehensive brake inspection and repair.',
                    'features' => ['Pad replacement', 'Rotor resurfacing', 'Fluid flush'],
                    'details' => 'Complete brake system service includes inspection of pads, rotors, calipers, and fluid. We replace worn components and resurface rotors when possible. Brake fluid flush removes moisture and maintains optimal performance.',
                    'price' => 'Starting at $129.99'
                ],
                [
                    'id' => 'tire',
                    'icon' => 'tire-service',
                    'name' => 'Tire Care Package',
                    'desc' => 'Complete tire services including rotation and balancing.',
                    'features' => ['Extended tire life', 'Improved fuel efficiency', 'Enhanced safety'],
                    'details' => 'Our tire care package includes rotation, balancing, pressure adjustment, and visual inspection for wear and damage. Proper tire maintenance can extend tire life by up to 20% and improve gas mileage.',
                    'price' => '$39.99'
                ],
                [
                    'id' => 'engine',
                    'icon' => 'engine-service',
                    'name' => 'Engine Diagnostics',
                    'desc' => 'Computer diagnostics for engine performance issues.',
                    'features' => ['Check engine light', 'Performance tuning', 'Emissions testing'],
                    'details' => 'Using advanced OBD-II scanners, we read and interpret trouble codes to diagnose engine issues. Service includes code reading, diagnosis, and recommended solutions. We can also clear warning lights after repairs.',
                    'price' => '$49.99 (waived with repair)'
                ]
            ];
        
            foreach ($services as $service): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="p-6">
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?= $service['name'] ?></h3>
                    <p class="text-gray-600 mb-4"><?= $service['desc'] ?></p>
                
                    <ul class="space-y-2 mb-6">
                        <?php foreach($service['features'] as $feature): ?>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700"><?= $feature ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                
                    <!-- Modal Trigger Button -->
                    <button 
                        onclick="openModal('<?= $service['id'] ?>')"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300"
                    >
                        Learn More
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal Backdrop -->
    <div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden"></div>

    <?php foreach ($services as $service): ?>
    <!-- Modal for <?= $service['name'] ?> -->
    <div id="<?= $service['id'] ?>Modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center">
                        
                        <h3 class="text-2xl font-bold text-gray-800"><?= $service['name'] ?></h3>
                    </div>
                    <button 
                        onclick="closeModal('<?= $service['id'] ?>')"
                        class="text-gray-500 hover:text-gray-700"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            
                <div class="grid md:grid-cols-1 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Service Details</h4>
                        <p class="text-gray-600 mb-4"><?= $service['details'] ?></p>
                    
                        <h4 class="font-semibold text-gray-800 mb-2">Key Benefits</h4>
                        <ul class="space-y-2">
                            <?php foreach($service['features'] as $feature): ?>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-700"><?= $feature ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                
                
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script>
    // Modal functions
    function openModal(serviceId) {
        document.getElementById('modalBackdrop').classList.remove('hidden');
        document.getElementById(serviceId + 'Modal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(serviceId) {
        document.getElementById('modalBackdrop').classList.add('hidden');
        document.getElementById(serviceId + 'Modal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close modal when clicking on backdrop
    document.getElementById('modalBackdrop').addEventListener('click', function() {
        this.classList.add('hidden');
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.classList.add('hidden');
        });
        document.body.classList.remove('overflow-hidden');
    });
    </script>


    <!-- Call to Action -->
    <div class="bg-blue-600 rounded-lg p-8 text-center text-white">
        <h2 class="text-2xl font-bold mb-3">Ready to Experience Better Vehicle Service?</h2>
        <p class="mb-6 max-w-2xl mx-auto">
            Join thousands of satisfied customers who trust us to connect them with 
            Mandalay's best vehicle service providers.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="/book-now" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition">
                Book Service Now
            </a>
            <a href="/contact" class="bg-transparent border border-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                Contact Our Team
            </a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>