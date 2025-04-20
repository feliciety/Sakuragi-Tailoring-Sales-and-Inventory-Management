<?php
include '../../includes/session_check.php';
include '../../includes/customer_header.php';
include '../../includes/customer_sidebar.php';
?>

<link rel="stylesheet" href="../../public/assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container py-4">
    <!-- Landing Intro -->
    <div id="orderLanding" class="text-center py-5">
        <h2 class="fw-bold mb-3">🧵 Welcome to Sakuragi Custom Orders</h2>
        <p class="text-muted">Ready to bring your designs to life? Whether it's embroidery, sublimation, or screen printing — we've got you covered.</p>
        <img src="../../public/assets/images/illustration-tailoring.png" class="img-fluid my-4" style="max-height: 280px;">
        <button class="btn btn-primary px-5 py-2 fw-semibold" onclick="startOrder()">Order Now</button>
    </div>

    <!-- Step-by-step Order Form (Hidden initially) -->
    <div id="orderFormWizard" class="d-none">
        <h3 class="fw-semibold mb-4">📝 Place New Order</h3>

        <ul class="nav nav-pills mb-3" id="order-steps" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#step1">1. Service</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#step2">2. Upload</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#step3">3. Customize</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#step4">4. Summary</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#step5">5. Payment</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#step6">6. Done</button></li>
        </ul>

        <div class="tab-content border rounded-4 p-4 shadow-sm bg-white" id="stepContent">
            <div class="tab-pane fade show active" id="step1"><?php include 'place_order_steps/step1_service.php'; ?></div>
            <div class="tab-pane fade" id="step2"><?php include 'place_order_steps/step2_upload.php'; ?></div>
            <div class="tab-pane fade" id="step3"><?php include 'place_order_steps/step3_customize.php'; ?></div>
            <div class="tab-pane fade" id="step4"><?php include 'place_order_steps/step4_summary.php'; ?></div>
            <div class="tab-pane fade" id="step5"><?php include 'place_order_steps/step5_payment.php'; ?></div>
            <div class="tab-pane fade" id="step6"><?php include 'place_order_steps/step6_success.php'; ?></div>
        </div>
    </div>
</div>

<script>
function startOrder() {
    document.getElementById('orderLanding').classList.add('d-none');
    document.getElementById('orderFormWizard').classList.remove('d-none');
}
</script>

<script src="../../public/assets/js/orderStepper.js"></script>
<script src="../../public/assets/js/excelPreview.js"></script>

<?php include '../../includes/customer_footer.php'; ?>
