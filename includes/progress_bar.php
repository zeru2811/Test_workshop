<div class="flex justify-between items-center mb-8">
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <div class="flex-1 flex items-center">
            <div class="w-8 h-8 <?= $i <= $step ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600' ?> rounded-full flex items-center justify-center font-semibold">
                <?= $i ?>
            </div>
            <?php if ($i < 5): ?>
                <div class="ml-4 flex-1 h-1 bg-gray-200 relative">
                    <div class="absolute left-0 top-0 h-full bg-primary transition-all" 
                         style="width: <?= $i < $step ? '100%' : '0%' ?>"></div>
                </div>
            <?php endif; ?>
        </div>
    <?php endfor; ?>
</div>