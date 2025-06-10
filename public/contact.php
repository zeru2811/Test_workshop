<?php include '../includes/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8" data-translate="contact">Contact Us</h1>
    
    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Send us a message</h2>
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Name</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Message</label>
                    <textarea class="w-full px-3 py-2 border rounded-lg" rows="4"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Send Message</button>
            </form>
        </div>
        
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Contact Information</h2>
            <div class="space-y-4">
                <p class="flex items-center text-gray-600">
                    <i class="fas fa-map-marker-alt text-red-500 mr-3"></i>
                    <span>123 Auto Street, Yangon, Myanmar</span>
                </p>
                <p class="flex items-center text-gray-600">
                    <i class="fas fa-phone text-blue-500 mr-3"></i>
                    <span>09 123 456789</span>
                </p>
                <p class="flex items-center text-gray-600">
                    <i class="fas fa-envelope text-green-500 mr-3"></i>
                    <span>contact@autoworkshop.com</span>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>