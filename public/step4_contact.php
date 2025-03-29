<div class="step-content active" id="step4">
    <h2 class="text-xl font-semibold mb-6">Contact Information</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name*</label>
            <input type="text" name="contact_name" class="w-full px-4 py-2 border rounded-button" 
                   value="<?= htmlspecialchars($_SESSION['booking_data']['contact_name'] ?? '') ?>" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address*</label>
            <input type="email" name="contact_email" class="w-full px-4 py-2 border rounded-button" 
                   value="<?= htmlspecialchars($_SESSION['booking_data']['contact_email'] ?? '') ?>" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number*</label>
            <input type="tel" name="contact_phone" class="w-full px-4 py-2 border rounded-button" 
                   value="<?= htmlspecialchars($_SESSION['booking_data']['contact_phone'] ?? '') ?>" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Special Instructions</label>
            <textarea name="special_instructions" class="w-full px-4 py-2 border rounded-button" rows="4"><?= 
                htmlspecialchars($_SESSION['booking_data']['special_instructions'] ?? '') 
            ?></textarea>
        </div>
    </div>
</div>