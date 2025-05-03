<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sakuragi Tailoring | Step 5: Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
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

    <ol class="text-muted mb-4 ps-3">
        <li>Choose full payment or 50% downpayment below.</li>
        <li>Scan the QR code using the GCash app.</li>
        <li>Enter the transaction reference number for confirmation.</li>
    </ol>

    <!-- Payment Options -->
    <div class="downpayment-box mb-4">
        <h6 class="mb-3">Choose Payment Amount:</h6>
        <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="paymentAmount" id="payFull" checked>
            <label class="form-check-label" for="payFull">Pay in full (₱2,400.00)</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="paymentAmount" id="payHalf">
            <label class="form-check-label" for="payHalf">Pay 50% Downpayment (₱1,200.00)</label>
        </div>
    </div>

    <!-- QR Code + Reference Number -->
    <div class="gcash-section mt-4">
    <h6 class="mb-3 fw-semibold">GCash QR Code</h6>
    
    <div class="qr-wrapper text-center">
        <img src="../../../public/assets/images/gcash-qr.png" alt="GCash QR Code" class="gcash-qr-sm mb-3">
        <div class="text-muted small">
            <p class="mb-1 fw-bold">F* AN*E M.</p>
            <p class="mb-1">Mobile No: 097••••702</p>
            <p>User ID: ••••••••X07LH5</p>
        </div>
    </div>

    <label for="referenceNumber" class="form-label mt-4">GCash Reference Number</label>
    <input type="text" class="form-control" id="referenceNumber" placeholder="e.g. G1234ABC56789" oninput="validateReferenceNumber()">
    <small id="refFeedback" class="text-muted mt-1 d-block">Enter your GCash transaction number.</small>
</div>

</div>
</div>

<!-- Bootstrap JS -->
</body>
</html>

<script>
function validateReferenceNumber() {
    const input = document.getElementById('referenceNumber');
    const feedback = document.getElementById('refFeedback');
    const value = input.value.trim();

    const isValid = /^[a-zA-Z0-9]{10,20}$/.test(value);

    if (value === '') {
        input.classList.remove('is-invalid', 'is-valid');
        feedback.textContent = 'Enter your GCash transaction number.';
        feedback.classList.remove('text-danger', 'text-success');
    } else if (!isValid) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        feedback.textContent = 'Invalid format. Must be 10–20 alphanumeric characters.';
        feedback.classList.add('text-danger');
        feedback.classList.remove('text-success');
    } else {
        input.classList.add('is-valid');
        input.classList.remove('is-invalid');
        feedback.textContent = 'Valid GCash reference number.';
        feedback.classList.add('text-success');
        feedback.classList.remove('text-danger');
    }
}
</script>

    <!-- Custom Styles -->
    <style>

.qr-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.gcash-qr-sm {
    width: 360px;
    height: auto;
    border-radius: 10px;
    border: 1px solid #ddd;
    background: #fff;
    padding: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.gcash-section .form-control {
    max-width: 500px;
    margin: 0 auto;
}

            body {
                background-color: #f4f6f9;
                font-family: 'Segoe UI', sans-serif;
            }

        .payment-container {
            max-width: 850px;
            margin: 40px auto;
            background: #fff;
            padding: 36px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        h1, h4 {
            color: #0B5CF9;
            font-weight: 700;
        }

        .nav-tabs .nav-link.active {
            background-color: #0B5CF9;
            color: #fff;
            font-weight: 600;
        }

        .nav-link {
            color: #0B5CF9;
        }

        .tab-pane {
            padding-top: 20px;
        }

        .qr-code img {
            max-width: 100%;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 10px;
            background-color: #fff;
        }

        .downpayment-box {
            margin-top: 30px;
            background-color: #f0f4ff;
            padding: 20px;
            border-radius: 12px;
        }

        .form-check-input:checked {
            background-color: #0B5CF9;
            border-color: #0B5CF9;
        }
    </style>