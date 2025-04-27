<h5 class="mb-3">Step 1: Select a Service</h5>
<p class="text-muted">Choose which service you would like to avail for your custom order.</p>

<div class="row g-4">
<?php
$services = ['Embroidery', 'Sublimation', 'Screen Printing', 'Alterations', 'Patches'];
foreach ($services as $service): ?>
    <div class="col-md-4">
        <div class="service-card" onclick="selectService('<?= $service ?>')">
            <h6 class="fw-bold"><?= $service ?></h6>
            <small>Click to select</small>
        </div>
    </div>
<?php endforeach; ?>
</div>
<input type="hidden" name="selected_service" id="selected_service">
