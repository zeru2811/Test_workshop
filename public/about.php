<?php include '../includes/header.php'; ?>

<div class="bg-gradient-to-r from-blue-50 to-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4" data-translate="aboutUs">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-400">Our Story</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Pioneering automotive excellence in Myanmar since 2012
            </p>
        </div>

        <!-- Content Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                <!-- Image Column -->
                <div class="h-80 md:h-full">
                    <img src="../image.png" alt="Our workshop team" 
                         class="w-full h-full object-cover">
                </div>
                
                <!-- Text Column -->
                <div class="p-8 md:p-12">
                    <div class="prose prose-lg max-w-none">
                        <div class="flex items-center mb-6">
                            <div class="h-1 w-12 bg-blue-500 mr-4"></div>
                            <h2 class="text-2xl font-bold text-gray-900">Our Humble Beginnings</h2>
                        </div>
                        
                        <p class="text-gray-600 mb-6">
                            What started as a small two-bay garage in downtown Yangon has grown into Myanmar's 
                            most trusted auto service network. Founded by master mechanic U Aung Ko in 2012, 
                            we began with a simple mission: to provide honest, reliable car care at fair prices.
                        </p>
                        
                        <div class="flex items-center mb-6 mt-10">
                            <div class="h-1 w-12 bg-blue-500 mr-4"></div>
                            <h2 class="text-2xl font-bold text-gray-900">Our Mission Today</h2>
                        </div>
                        
                        <p class="text-gray-600 mb-6">
                            We combine cutting-edge diagnostic technology with old-fashioned craftsmanship. 
                            Every vehicle we service receives the same care we'd give our own cars, because 
                            to us, you're not just a customer - you're part of our automotive family.
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4 mt-8">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-blue-600 font-bold text-2xl">10+</p>
                                <p class="text-gray-600">Years Experience</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-blue-600 font-bold text-2xl">50+</p>
                                <p class="text-gray-600">Certified Technicians</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="mt-20">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                Our Core <span class="text-blue-600">Values</span>
            </h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-medal text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Uncompromising Quality</h3>
                    <p class="text-gray-600">
                        We use only manufacturer-approved parts and follow strict service protocols. 
                        Every repair comes with a 12-month warranty for your peace of mind.
                    </p>
                </div>
                
                <!-- Value 2 -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-hand-holding-heart text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Honest Service</h3>
                    <p class="text-gray-600">
                        No hidden fees, no unnecessary repairs. We provide transparent diagnostics 
                        and clear explanations before any work begins.
                    </p>
                </div>
                
                <!-- Value 3 -->
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Community Focus</h3>
                    <p class="text-gray-600">
                        We train local technicians, source materials locally, and actively support 
                        road safety initiatives across Myanmar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>