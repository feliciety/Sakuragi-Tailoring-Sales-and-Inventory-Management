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
            <div class="service-card text-center p-4 h-100" onclick="selectService('<?= $service ?>', this)">
                <div class="service-icon mb-3"><?= $icon ?></div>
                <h6 class="fw-bold mb-2"><?= $service ?></h6>
                <small class="text-muted">Click to select</small>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<input type="hidden" name="selected_service" id="selected_service">

<style>
    .service-card {
    background: #ffffff;
    border: 2px solid transparent;
    border-radius: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(11, 92, 249, 0.08);
    cursor: pointer;
    transform: scale(1);
}

.service-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(11, 92, 249, 0.15);
    border-color: rgba(11, 92, 249, 0.2);
}

.service-card.selected {
    border-color: #0B5CF9;
    background: linear-gradient(135deg, #e8f0ff, #ffffff);
    box-shadow: 0 0 0 3px rgba(11, 92, 249, 0.25);
    transform: scale(1.03);
}

.service-icon {
    font-size: 48px;
    transition: transform 0.3s ease;
}

.service-card:hover .service-icon {
    transform: scale(1.2);
}

</style>