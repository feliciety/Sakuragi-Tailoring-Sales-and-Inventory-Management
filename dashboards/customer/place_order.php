<?php
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container py-5">
    <!-- 🌟 Landing Section -->
    <section id="orderLanding" class="text-center py-5">
    <h2 class="fw-bold mb-3 text-primary-emphasis">🧵 Welcome to Sakuragi Custom Orders</h2>
    <p class="text-muted mb-4">Ready to bring your designs to life? Whether it's embroidery, sublimation, or screen printing — we've got you covered.</p>

    <!-- ✨ Upgraded Start Button -->
    <button class="start-order-btn" onclick="startOrder()">
        <span class="btn-icon">🚀</span>
        <span class="btn-text">Start Your Order</span>
    </button>
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

    <section id="orderLanding" class="text-center">
<!-- 📌 How to Order Section -->
    <div class="how-to-order text-start mt-5">
        <h3 class="fw-bold text-center mb-4 text-primary">🛠️ How to Place Your Order</h3>
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="p-4 border rounded-4 shadow-sm h-100">
                    <h5 class="fw-semibold mb-2">📋 Step 1: Choose Your Service</h5>
                    <p class="text-muted small">Select the type of tailoring service you need — Embroidery, Sublimation, Screen Printing, Alterations, or Patches.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="p-4 border rounded-4 shadow-sm h-100">
                    <h5 class="fw-semibold mb-2">📂 Step 2: Upload Your Design</h5>
                    <p class="text-muted small">Provide your PSD file for design processing. Make sure your file is clear and final to avoid confusion.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="p-4 border rounded-4 shadow-sm h-100">
                    <h5 class="fw-semibold mb-2">🧵 Step 3: Choose Design Type</h5>
                    <p class="text-muted small">Select <strong>Customizable</strong> if you have a list of names, numbers, or sizes — or <strong>Standard</strong> for the same design and size across all items.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="p-4 border rounded-4 shadow-sm h-100">
                    <h5 class="fw-semibold mb-2">📑 Step 4: Review Order Summary</h5>
                    <p class="text-muted small">Double-check all the details of your order — the service, uploaded files, and design type. Make sure everything is correct before proceeding.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="p-4 border rounded-4 shadow-sm h-100">
                    <h5 class="fw-semibold mb-2">💳 Step 5: Payment</h5>
                    <p class="text-muted small">Select your preferred payment method — GCash, Cash on Pickup, or Walk-in Payment. Upload proof if necessary.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="p-4 border rounded-4 shadow-sm h-100">
                    <h5 class="fw-semibold mb-2">✅ Step 6: Confirmation</h5>
                    <p class="text-muted small">Your order will be submitted successfully! You can track the status of your order through your dashboard.</p>
                </div>
            </div>
        </div>

        <p class="mt-4 text-center text-muted small">
            ℹ️ Need help? Feel free to contact our support team anytime via chat or email!
        </p>
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
