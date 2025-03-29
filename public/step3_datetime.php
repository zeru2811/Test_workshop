<div class="step-content active" id="step3">
    <h2 class="text-xl font-semibold mb-6">Select Date & Time</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Date*</label>
            <input type="date" name="date" class="w-full px-4 py-2 border rounded-button" 
                   min="<?= date('Y-m-d') ?>" 
                   value="<?= htmlspecialchars($_SESSION['booking_data']['date'] ?? '') ?>" 
                   required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Available Time Slots*</label>
            <div class="grid grid-cols-2 gap-4">
                <?php 
                $timeSlots = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00'];
                foreach ($timeSlots as $time): 
                    $displayTime = date('g:i A', strtotime($time));
                    $isSelected = ($_SESSION['booking_data']['time'] ?? '') === $time;
                ?>
                    <button type="button" class="px-4 py-2 border rounded-button 
                        <?= $isSelected ? 'border-primary text-primary' : 'text-gray-700 hover:border-primary hover:text-primary' ?>"
                        onclick="selectTime(this, '<?= $time ?>')">
                        <?= $displayTime ?>
                    </button>
                    <input type="radio" name="time" value="<?= $time ?>" 
                           class="hidden" <?= $isSelected ? 'checked' : '' ?> required>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>