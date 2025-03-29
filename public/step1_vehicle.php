<div class="step-content active" id="step1">
    <h2 class="text-xl font-semibold mb-6">Vehicle & Workshop Information</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($userVehicles)): ?>
        <div class="mb-6">
            <h3 class="text-lg font-medium mb-3">Your Saved Vehicles</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($userVehicles as $vehicle): ?>
                    <div class="border rounded-lg p-4 cursor-pointer hover:border-primary"
                         onclick="selectSavedVehicle(<?= htmlspecialchars(json_encode($vehicle)) ?>)">
                        <h4 class="font-medium"><?= htmlspecialchars($vehicle['Make']) ?> <?= htmlspecialchars($vehicle['Model']) ?></h4>
                        <p class="text-sm text-gray-600">Year: <?= htmlspecialchars($vehicle['Year']) ?></p>
                        <p class="text-sm text-gray-600">Mileage: <?= htmlspecialchars($vehicle['Mileage']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="text-center text-gray-500 mt-4">- OR -</p>
        </div>
    <?php endif; ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Make*</label>
            <select name="make" class="w-full px-4 py-2 border rounded-button" required>
                <option value="">Select Make</option>
                <!-- International Brands -->
                <option value="Toyota" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Toyota' ? 'selected' : '' ?>>Toyota</option>
                <option value="Honda" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Honda' ? 'selected' : '' ?>>Honda</option>
                <option value="Suzuki" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Suzuki' ? 'selected' : '' ?>>Suzuki</option>
                <option value="Mitsubishi" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Mitsubishi' ? 'selected' : '' ?>>Mitsubishi</option>
                <option value="Nissan" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Nissan' ? 'selected' : '' ?>>Nissan</option>
                <option value="Isuzu" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Isuzu' ? 'selected' : '' ?>>Isuzu</option>
                <option value="Ford" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Ford' ? 'selected' : '' ?>>Ford</option>
                <option value="Hyundai" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Hyundai' ? 'selected' : '' ?>>Hyundai</option>
                <option value="Kia" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Kia' ? 'selected' : '' ?>>Kia</option>
                <option value="Mazda" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Mazda' ? 'selected' : '' ?>>Mazda</option>
    
                <!-- Luxury Brands -->
                <option value="BMW" <?= ($_SESSION['booking_data']['make'] ?? '') == 'BMW' ? 'selected' : '' ?>>BMW</option>
                <option value="Mercedes-Benz" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Mercedes-Benz' ? 'selected' : '' ?>>Mercedes-Benz</option>
                <option value="Lexus" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Lexus' ? 'selected' : '' ?>>Lexus</option>
                <option value="Audi" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Audi' ? 'selected' : '' ?>>Audi</option>
    
                <!-- Commercial Vehicles -->
                <option value="Hino" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Hino' ? 'selected' : '' ?>>Hino</option>
                <option value="Fuso" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Fuso' ? 'selected' : '' ?>>Fuso</option>
    
                <!-- Chinese Brands Popular in Myanmar -->
                <option value="Changan" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Changan' ? 'selected' : '' ?>>Changan</option>
                <option value="Chery" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Chery' ? 'selected' : '' ?>>Chery</option>
                <option value="BAIC" <?= ($_SESSION['booking_data']['make'] ?? '') == 'BAIC' ? 'selected' : '' ?>>BAIC</option>
                <option value="GAC" <?= ($_SESSION['booking_data']['make'] ?? '') == 'GAC' ? 'selected' : '' ?>>GAC</option>
    
                <!-- Other -->
                <option value="Other" <?= ($_SESSION['booking_data']['make'] ?? '') == 'Other' ? 'selected' : '' ?>>Other (Specify in Model)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Model*</label>
            <input type="text" name="model" class="w-full px-4 py-2 border rounded-button" 
                   value="<?= htmlspecialchars($_SESSION['booking_data']['model'] ?? '') ?>" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Year*</label>
            <select name="year" class="w-full px-4 py-2 border rounded-button" required>
                <option value="">Select Year</option>
                <?php for ($y = date('Y'); $y >= date('Y') - 20; $y--): ?>
                    <option value="<?= $y ?>" <?= ($_SESSION['booking_data']['year'] ?? '') == $y ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Current Mileage</label>
            <input type="number" name="mileage" class="w-full px-4 py-2 border rounded-button" 
                   value="<?= htmlspecialchars($_SESSION['booking_data']['mileage'] ?? '') ?>" 
                   placeholder="Enter mileage">
        </div>

        <!-- Workshop Selection -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Workshop*</label>
            <select name="workshop_id" class="w-full px-4 py-2 border rounded-button" required>
                <option value="">Select Workshop</option>
                <?php
                $workshops = $pdo->query("SELECT * FROM Workshop")->fetchAll();
                foreach ($workshops as $workshop): 
                    $selected = ($_SESSION['booking_data']['workshop_id'] ?? '') == $workshop['WorkshopID'] ? 'selected' : '';
                ?>
                    <option value="<?= $workshop['WorkshopID'] ?>" <?= $selected ?>>
                        <?= htmlspecialchars($workshop['WorkshopName']) ?> - <?= htmlspecialchars($workshop['Address']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<script>
    function selectSavedVehicle(vehicle) {
        document.querySelector('select[name="make"]').value = vehicle.Make;
        document.querySelector('input[name="model"]').value = vehicle.Model;
        document.querySelector('select[name="year"]').value = vehicle.Year;
        document.querySelector('input[name="mileage"]').value = vehicle.Mileage;
    }
</script>