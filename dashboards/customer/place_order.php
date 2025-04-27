<?php
session_start();
include '../../includes/session_check.php';
include '../../includes/customer_header.php';
include '../../includes/customer_sidebar.php';
?>

<!-- ✅ Global & Step-Specific Styles -->
<link rel="stylesheet" href="../../public/assets/css/place_order.css">
<link rel="stylesheet" href="../../public/assets/css/step1_services.css">
<link rel="stylesheet" href="../../public/assets/css/step2_uploads.css">
<link rel="stylesheet" href="../../public/assets/css/step3_customize.css">
<link rel="stylesheet" href="../../public/assets/css/step4_summary.css">
<link rel="stylesheet" href="../../public/assets/css/step5_payment.css">
<link rel="stylesheet" href="../../public/assets/css/step6_success.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container py-5">
    <!-- 🌟 Landing Section -->
    <section id="orderLanding" class="text-center">
        <h2 class="fw-bold mb-3 text-primary-emphasis">🧵 Welcome to Sakuragi Custom Orders</h2>
        <p class="text-muted mb-4">Ready to bring your designs to life? Whether it's embroidery, sublimation, or screen printing — we've got you covered.</p>
        <img src="../../public/assets/images/illustration-tailoring.png" alt="Tailoring Illustration" class="img-fluid my-4" style="max-height: 250px;">
        <button class="btn btn-primary px-5 py-2 fw-semibold rounded-pill shadow-sm" onclick="startOrder()">✨ Start Your Order</button>
    </section>

    <!-- 🟢 Stepper Wizard -->
    <section id="orderFormWizard" class="d-none">
        <h3 class="fw-bold text-center mb-4">📝 Sakuragi Custom Order Process</h3>

        <!-- 🟣 Animated Progress Indicator -->
        <div class="progress-container position-relative mb-5">
            <div class="progress-bar-fill"></div>
            <?php
            $steps = ['Service', 'Upload', 'Customize', 'Summary', 'Payment', 'Done'];
            foreach ($steps as $index => $label): ?>
                <div class="progress-step">
                    <div class="step-circle"><?= $index + 1 ?></div>
                    <div class="step-label"><?= $label ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 📦 Step Content -->
        <div class="step-content mt-4">
            <div id="step1" class="step-box active"><?php include 'place_order_steps/step1_services.php'; ?></div>
            <div id="step2" class="step-box"><?php include 'place_order_steps/step2_uploads.php'; ?></div>
            <div id="step3" class="step-box"><?php include 'place_order_steps/step3_customize.php'; ?></div>
            <div id="step4" class="step-box"><?php include 'place_order_steps/step4_summary.php'; ?></div>
            <div id="step5" class="step-box"><?php include 'place_order_steps/step5_payment.php'; ?></div>
            <div id="step6" class="step-box"><?php include 'place_order_steps/step6_success.php'; ?></div>
        </div>

        <!-- ⏩ Navigation Buttons -->
        <div class="d-flex justify-content-between align-items-center mt-5">
            <button class="btn btn-outline-secondary btn-sm px-4 rounded-pill" id="prevBtn" onclick="prevStep()">← Back</button>
            <button class="btn btn-primary btn-sm px-4 rounded-pill" id="nextBtn" onclick="nextStep()">Next →</button>
        </div>
    </section>
</div>

<!-- 🚀 JS Logic -->
<script>
function startOrder() {
    document.getElementById('orderLanding').classList.add('d-none');
    document.getElementById('orderFormWizard').classList.remove('d-none');
}
</script>

<script src="../../public/assets/js/orderStepper.js"></script>
<script src="../../public/assets/js/excelPreview.js"></script>

<?php include '../../includes/customer_footer.php'; ?>
