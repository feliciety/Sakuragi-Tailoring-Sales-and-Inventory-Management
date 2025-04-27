<h5 class="mb-3">Step 1: Select a Service</h5>
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

<!-- Navigation Buttons -->
<div class="d-flex justify-content-end mt-4">
    <button class="btn btn-primary" onclick="nextStep()">Next</button>
</div>
