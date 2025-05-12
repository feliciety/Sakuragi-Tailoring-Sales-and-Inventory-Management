
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sakuragi Tailoring | Step 5: Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../../public/assets/bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container payment-container">
    <h5 class="mb-3 fw-bold text-center">Step 5: Payment</h5>
    <p class="text-muted text-center mb-4">
        Select your GCash payment method and enter your reference number to confirm your order.
    </p>

    <div class="payment-container sakuragi-card">
        <h5 class="mb-3 text-primary">Pay via GCash</h5>

        <!-- QR Code Section -->
        <div class="gcash-section mt-4">
            <h6 class="mb-3 fw-semibold">GCash QR Code</h6>
            <div class="qr-wrapper text-center">
                <img src="../../../public/assets/images/gcash-qr.png" alt="GCash QR Code" class="gcash-qr-sm mb-3">
            </div>
        </div>

        <!-- Reference Number Input -->
        <div class="mt-4">
            <label for="referenceNumber" class="form-label">GCash Reference Number</label>
            <input type="text" class="form-control" id="referenceNumber" placeholder="Enter reference number">
            <small id="refFeedback" class="text-muted">Enter your GCash transaction number</small>
        </div>

        <!-- Payment Proof Upload -->
        <div class="upload-payment-proof mt-4">
            <h6 class="text-primary mb-3">Upload Payment Screenshot</h6>
            <input type="file" id="paymentProof" class="form-control" accept="image/*" onchange="handlePaymentProof()">
            <div id="paymentPreview" class="mt-3"></div>
        </div>
    </div>
</div>

<style>
.payment-container {
    max-width: 850px;
    margin: 40px auto;
    background: #fff;
    padding: 36px;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
}

.gcash-qr-sm {
    width: 360px;
    height: auto;
    border-radius: 10px;
    border: 1px solid #ddd;
    padding: 10px;
}
</style>

<script>
function handlePaymentProof() {
    const file = document.getElementById('paymentProof').files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('paymentPreview').innerHTML = `
                <img src="${e.target.result}" class="img-fluid mt-3" style="max-height: 300px">
            `;
        };
        reader.readAsDataURL(file);
    }
}
</script>

</body>
</html>