<?php
require_once __DIR__ . '../../../../config/db_connect.php';
require_once __DIR__ . '../../../../config/session_handler.php';
?>

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
    <p class="text-muted text-center mb-4">Please complete your payment and upload the proof of payment to proceed.</p>

    <div class="row g-4">
        <!-- Payment Methods & Instructions -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <div id="paymentDetails" class="mt-4">
                        <div class="payment-info">
                            <div class="qr-code text-center mb-3">
                                <img src="../../../public/assets/images/gcash-qr.png" 
                                     alt="GCash QR Code" class="img-fluid gcash-qr-sm">
                            </div>
                            <div class="account-details">
                                <p class="mb-2"><strong>Account Name:</strong> Sakuragi Tailoring</p>
                                <p class="mb-2"><strong>GCash Number:</strong> 09912391238</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        <!-- Payment Proof Upload -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-4">Upload Payment Proof</h6>
                    
                    <div class="upload-instructions alert alert-info mb-4">
                        <p class="mb-2"><strong>Instructions:</strong></p>
                        <ol class="mb-0">
                            <li>Complete your payment using the details provided</li>
                            <li>Take a screenshot of your payment confirmation</li>
                            <li>Upload the screenshot below</li>
                            <li>Click "Complete Order" to submit your order</li>
                        </ol>
                    </div>

                    <div class="payment-upload-area p-4 text-center" id="uploadPlaceholder">
                        <input type="file" id="paymentProof" class="d-none" accept="image/*" onchange="handlePaymentImageUpload(this)">
                        <label for="paymentProof" class="mb-0" style="cursor: pointer;">
                            <div class="mb-3">📸</div>
                            <p class="mb-0">Click to upload payment proof</p>
                            <small class="text-muted d-block">Supported formats: JPG, PNG (Max: 500MB)</small>
                        </label>
                    </div>
                    
                    <div id="paymentImagePreview" class="text-center mt-3 d-none">
                        <img src="" alt="Payment proof preview" class="img-fluid mb-2">
                        <button class="btn btn-danger btn-sm mt-2" onclick="removePaymentImage()">Remove Image</button>
                    </div>
                    
                    <div class="mt-4">
                        <div class="form-group mb-3">
                            <label for="referenceNumber" class="form-label">Reference Number</label>
                            <input type="text" class="form-control" id="referenceNumber" placeholder="Enter payment reference number">
                            <small class="text-muted">Enter the reference number from your GCash transaction</small>
                        </div>
                        
                        <button id="submitOrderBtn" class="btn btn-primary btn-lg w-100 mt-3" disabled onclick="submitOrder()">Complete Order</button>
                        <div id="orderSubmissionStatus" class="alert d-none mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    updatePaymentDetails('GCash');
});

function handlePaymentImageUpload(input) {
    const file = input.files[0];
    if (!file) return;    // Validate file size (500MB)
    if (file.size > 500 * 1024 * 1024) {
        alert('File size exceeds the maximum limit of 500MB');
        input.value = '';
        return;
    }

    // Validate file type
    if (!file.type.startsWith('image/')) {
        alert('Please upload an image file (JPG or PNG)');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('paymentImagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        const submitBtn = document.getElementById('submitOrderBtn');
        
        preview.querySelector('img').src = e.target.result;
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
        
        // Enable submit button once an image is uploaded
        submitBtn.disabled = false;
        
        // Clear any previous error messages
        const statusBox = document.getElementById('orderSubmissionStatus');
        if (statusBox) {
            statusBox.classList.add('d-none');
        }
    };
    reader.readAsDataURL(file);
}

function removePaymentImage() {
    const input = document.getElementById('paymentProof');
    const preview = document.getElementById('paymentImagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    const submitBtn = document.getElementById('submitOrderBtn');
    
    input.value = '';
    preview.classList.add('d-none');
    preview.querySelector('img').src = '';
    placeholder.classList.remove('d-none');
    
    // Disable submit button when removing the payment image
    submitBtn.disabled = true;
}

function updatePaymentDetails(method) {
    const detailsDiv = document.getElementById('paymentDetails');
    const orderData = JSON.parse(sessionStorage.getItem('orderSummaryData'));
    const amount = orderData?.totals?.grandTotal || 0;
    
    if (method === 'GCash') {
        detailsDiv.innerHTML = `
            <div class="payment-info">
                <div class="qr-code text-center mb-3">
                    <img src="../../../public/assets/images/gcash-qr.png" 
                         alt="GCash QR Code" class="img-fluid gcash-qr-sm">
                </div>
                <div class="account-details">
                    <p class="mb-2"><strong>Account Name:</strong> Sakuragi Tailoring</p>
                    <p class="mb-2"><strong>GCash Number:</strong> 09123456789</p>
                </div>
            </div>`;
    } else {
        detailsDiv.innerHTML = `
            <div class="payment-info">
                <div class="account-details">
                    <p class="mb-2"><strong>Bank:</strong> BDO</p>
                    <p class="mb-2"><strong>Account Name:</strong> Sakuragi Tailoring</p>
                    <p class="mb-2"><strong>Account Number:</strong> 1234 5678 9012</p>
                    <p class="mb-0 text-primary"><strong>Amount to Pay:</strong> ₱${amount.toFixed(2)}</p>
                </div>
            </div>`;
    }
}

function submitOrder() {
    // Disable the submit button to prevent double submissions
    const submitBtn = document.getElementById('submitOrderBtn');
    const statusBox = document.getElementById('orderSubmissionStatus');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
    
    // Get order data from session storage
    const orderData = JSON.parse(sessionStorage.getItem('orderSummaryData'));
    const paymentProof = document.getElementById('paymentProof').files[0];
    const referenceNumber = document.getElementById('referenceNumber').value.trim();
    
    // Validation
    if (!orderData) {
        showOrderStatus('error', 'Order data not found. Please refresh the page and try again.');
        return;
    }
    
    if (!paymentProof) {
        showOrderStatus('error', 'Please upload your payment proof.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Complete Order';
        return;
    }
    
    // Prepare form data for submission
    const formData = new FormData();
    formData.append('orderData', JSON.stringify(orderData));
    formData.append('payment_proof', paymentProof);
    
    if (referenceNumber) {
        formData.append('reference_number', referenceNumber);
        
        // Add reference number to the order data if provided
        const updatedOrderData = {...orderData};
        if (!updatedOrderData.payment) updatedOrderData.payment = {};
        updatedOrderData.payment.referenceNumber = referenceNumber;
        sessionStorage.setItem('orderSummaryData', JSON.stringify(updatedOrderData));
    }
    
    console.log('Submitting order data:', orderData);
    
    // Send to server
    fetch('../../../controller/customerController/submit_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            console.error('Server response not OK:', response.status);
            throw new Error('Server returned error status ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showOrderStatus('success', 'Order submitted successfully!');
            
            // Clear session storage data for this order
            sessionStorage.removeItem('orderSummaryData');
            sessionStorage.removeItem('selectedService');
            sessionStorage.removeItem('uploadedDesign');
            
            // Move to success step after 2 seconds
            setTimeout(() => {
                document.querySelector('.stepper-content').innerHTML = '';
                fetch('step6_success.php')
                    .then(response => response.text())
                    .then(html => {
                        document.querySelector('.stepper-content').innerHTML = html;
                        
                        // Update stepper UI
                        const steps = document.querySelectorAll('.stepper-item');
                        steps.forEach((step, index) => {
                            if (index < 5) { // Mark all previous steps as complete
                                step.classList.remove('active');
                                step.classList.add('completed');
                            } else if (index === 5) { // Mark current step as active
                                step.classList.add('active');
                            }
                        });
                    });
            }, 2000);
        } else {
            showOrderStatus('error', data.error || 'Failed to submit order. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Complete Order';
        }
    })
    .catch(error => {
        console.error('Order submission error:', error);
        showOrderStatus('error', 'Failed to submit order. Please try again.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Complete Order';
    });
}

function showOrderStatus(type, message) {
    const statusBox = document.getElementById('orderSubmissionStatus');
    statusBox.classList.remove('d-none', 'alert-success', 'alert-danger');
    statusBox.classList.add(type === 'success' ? 'alert-success' : 'alert-danger');
    statusBox.textContent = message;
}
</script>

<style>
.payment-container {
    max-width: 850px;
    margin: 0 auto;
}

.payment-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-upload-area:hover {
    border-color: #0B5CF9;
    background-color: #f8f9fa;
}

.gcash-qr-sm {
    max-width: 200px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 8px;
    background: white;
}

.payment-info {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
}

.account-details p {
    font-size: 0.95rem;
}

#paymentImagePreview img {
    max-width: 100%;
    max-height: 300px;
    object-fit: contain;
}

.form-check-input:checked {
    background-color: #0B5CF9;
    border-color: #0B5CF9;
}

}upload-instructions ol {
    padding-left: 1rem;
.upload-instructions ol {
    padding-left: 1rem;
}upload-instructions li {
    margin-bottom: 0.5rem;
.upload-instructions li {
    margin-bottom: 0.5rem;
}upload-instructions li:last-child {
    margin-bottom: 0;
.upload-instructions li:last-child {
    margin-bottom: 0;
}
</style>
</html></body></html>