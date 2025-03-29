<div class="step-content active" id="step2">
    <h2 class="text-xl font-semibold mb-6">Select Services</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($services as $service): ?>
            <div class="border rounded-lg p-4 cursor-pointer hover:border-primary service-item"
                 onclick="toggleServiceSelection(this, <?= $service['ServiceID'] ?>)">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                        <i class="ri-oil-line text-primary text-2xl"></i>
                    </div>
                    <div class="w-6 h-6 border-2 rounded-full flex items-center justify-center service-checkbox">
                        <div class="w-3 h-3 bg-primary rounded-full 
                            <?= in_array($service['ServiceID'], $_SESSION['booking_data']['services'] ?? []) ? '' : 'hidden' ?>"></div>
                    </div>
                </div>
                <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($service['Name']) ?></h3>
                <p class="text-gray-600 text-sm mb-4"><?= htmlspecialchars($service['Description']) ?></p>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600"><?= htmlspecialchars($service['Duration']) ?></span>
                    <span class="font-semibold">$<?= number_format($service['BasePrice'], 2) ?></span>
                </div>
                <input type="checkbox" name="services[]" value="<?= $service['ServiceID'] ?>" 
                       class="hidden" <?= in_array($service['ServiceID'], $_SESSION['booking_data']['services'] ?? []) ? 'checked' : '' ?>>
            </div>
        <?php endforeach; ?>
    </div>
</div>