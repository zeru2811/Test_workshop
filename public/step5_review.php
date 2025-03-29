<div class="step-content active" id="step5">
    <h2 class="text-xl font-semibold mb-6">Review & Confirm</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <div class="bg-gray-50 rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-medium text-gray-700 mb-2">Vehicle Information</h3>
                <p class="text-gray-600">
                    <?= htmlspecialchars($_SESSION['booking_data']['make'] ?? '') ?> 
                    <?= htmlspecialchars($_SESSION['booking_data']['model'] ?? '') ?> 
                    (<?= htmlspecialchars($_SESSION['booking_data']['year'] ?? '') ?>)
                </p>
                <p class="text-gray-600">
                    Mileage: <?= htmlspecialchars($_SESSION['booking_data']['mileage'] ?? 'N/A') ?>
                </p>
            </div>

            <div>
                <h3 class="font-medium text-gray-700 mb-2">Selected Services</h3>
                <div id="reviewServices" class="space-y-2">
                    <?php 
                    $totalAmount = 0;
                    if (!empty($_SESSION['booking_data']['services'])):
                        foreach ($_SESSION['booking_data']['services'] as $serviceId):
                            $service = array_filter($services, fn($s) => $s['ServiceID'] == $serviceId);
                            if (!empty($service)):
                                $service = current($service);
                                $totalAmount += $service['BasePrice'];
                    ?>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600"><?= htmlspecialchars($service['Name']) ?></span>
                            <span class="font-medium">$<?= number_format($service['BasePrice'], 2) ?></span>
                        </div>
                    <?php 
                            endif;
                        endforeach;
                    endif; 
                    ?>
                </div>
            </div>

            <div>
                <h3 class="font-medium text-gray-700 mb-2">Appointment Time</h3>
                <p class="text-gray-600">
                    <?php if (!empty($_SESSION['booking_data']['date']) && !empty($_SESSION['booking_data']['time'])): ?>
                        <?= date('F j, Y', strtotime($_SESSION['booking_data']['date'])) ?> at 
                        <?= date('g:i A', strtotime($_SESSION['booking_data']['time'])) ?>
                    <?php endif; ?>
                </p>
            </div>

            <div>
                <h3 class="font-medium text-gray-700 mb-2">Contact Information</h3>
                <p class="text-gray-600"><?= htmlspecialchars($_SESSION['booking_data']['contact_name'] ?? '') ?></p>
                <p class="text-gray-600"><?= htmlspecialchars($_SESSION['booking_data']['contact_email'] ?? '') ?></p>
                <p class="text-gray-600"><?= htmlspecialchars($_SESSION['booking_data']['contact_phone'] ?? '') ?></p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t">
            <div class="flex items-center justify-between">
                <span class="text-lg font-medium">Total Amount:</span>
                <span class="text-xl font-semibold text-primary">$<?= number_format($totalAmount, 2) ?></span>
            </div>
        </div>
    </div>

    <div class="flex items-start mb-6">
        <input type="checkbox" class="mt-1" id="terms" name="terms" required />
        <label for="terms" class="ml-2 text-sm text-gray-600">
            I agree to the terms and conditions and understand that my appointment is subject to confirmation.
        </label>
    </div>
    <input type="hidden" name="confirm_booking" value="1">
</div>