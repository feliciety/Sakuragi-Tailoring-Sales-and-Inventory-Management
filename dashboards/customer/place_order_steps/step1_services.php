<h5 class="mb-3 fw-bold text-center">Step 1: Select a Service</h5>
<p class="text-muted text-center">Choose the type of service for your custom order. Select one to proceed.</p>

<div class="row g-4 justify-content-center">
    <?php
    $services = [
        'Embroidery' => '🪡',
        'Sublimation' => '🎨',
        'Screen Printing' => '🖨️',
        'Alterations' => '✂️',
        'Patches' => '🧵'
    ];
    foreach ($services as $service => $icon): ?>
        <div class="col-md-4 col-sm-6">
            <div class="service-card text-center p-4 shadow-sm rounded-4 h-100" 
                onclick="selectService('<?= $service ?>', this)">
                <div class="service-icon mb-3"><?= $icon ?></div>
                <h6 class="fw-bold mb-2"><?= $service ?></h6>
                <small class="text-muted">Click to select</small>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<input type="hidden" name="selected_service" id="selected_service">

