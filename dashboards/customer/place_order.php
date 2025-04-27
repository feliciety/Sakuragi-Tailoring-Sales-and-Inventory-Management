<?php
session_start();
include '../../includes/session_check.php';
include '../../includes/customer_header.php';
include '../../includes/customer_sidebar.php';
?>

<!-- Include your modern styles -->
<link rel="stylesheet" href="../../public/assets/css/place_order.css">
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
        <h3 class="fw-semibold text-center mb-4">📝 Sakuragi Custom Order Process</h3>

        <!-- Custom Animated Stepper -->
        <div class="progress-container position-relative">
            <div class="progress-bar-fill"></div>

            <div class="progress-step">
                <div class="step-circle">1</div>
                <div class="step-label">Service</div>
            </div>
            <div class="progress-step">
                <div class="step-circle">2</div>
                <div class="step-label">Upload</div>
            </div>
            <div class="progress-step">
                <div class="step-circle">3</div>
                <div class="step-label">Customize</div>
            </div>
            <div class="progress-step">
                <div class="step-circle">4</div>
                <div class="step-label">Summary</div>
            </div>
            <div class="progress-step">
                <div class="step-circle">5</div>
                <div class="step-label">Payment</div>
            </div>
            <div class="progress-step">
                <div class="step-circle">6</div>
                <div class="step-label">Done</div>
            </div>
        </div>

        <!-- Step Content -->
        <div class="step-content mt-5">
            <div id="step1" class="step-box active">
                <?php include 'place_order_steps/step1_services.php'; ?>
            </div>
            <div id="step2" class="step-box">
                <?php include 'place_order_steps/step2_uploads.php'; ?>
            </div>
            <div id="step3" class="step-box">
                <?php include 'place_order_steps/step3_customize.php'; ?>
            </div>
            <div id="step4" class="step-box">
                <?php include 'place_order_steps/step4_summary.php'; ?>
            </div>
            <div id="step5" class="step-box">
                <?php include 'place_order_steps/step5_payment.php'; ?>
            </div>
            <div id="step6" class="step-box">
                <?php include 'place_order_steps/step6_success.php'; ?>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="d-flex justify-content-between mt-4">
            <button class="btn btn-outline-secondary" id="prevBtn" onclick="prevStep()">Back</button>
            <button class="btn btn-primary" id="nextBtn" onclick="nextStep()">Next</button>
        </div>
    </div>
</div>

<!-- JS Logic -->
<script>
function startOrder() {
    document.getElementById('orderLanding').classList.add('d-none');
    document.getElementById('orderFormWizard').classList.remove('d-none');
}
</script>

<script src="../../public/assets/js/orderStepper.js"></script>
<script src="../../public/assets/js/excelPreview.js"></script>

<?php include '../../includes/customer_footer.php'; ?>
