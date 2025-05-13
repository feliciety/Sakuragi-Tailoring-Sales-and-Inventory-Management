<style>
/* ========== Page Headings ========== */
.page-title {
    text-align: center;
    font-size: 2rem;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    color: #0B5CF9;
    font-weight: 700;
}

.page-subtext {
    text-align: center;
    color: #666;
    font-size: 1rem;
    margin-bottom: 2rem;
}

/* ========== Table Container ========== */
.my-orders-container {
    background: #ffffff;
    border-radius: 16px;
    padding: 32px;
    margin: 0 auto;
    max-width: 1200px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.06);
}

.table-wrapper {
    overflow-x: auto;
}

/* ========== Table ========== */
.my-orders-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
    min-width: 1000px;
}

.my-orders-table thead {
    background: linear-gradient(90deg, #0B5CF9, #4D8CFF);
    color: #ffffff;
}

.my-orders-table th,
.my-orders-table td {
    padding: 14px 20px;
    border: 1px solid #e0e6ed;
    text-align: left;
}

.my-orders-table tbody tr:hover {
    background-color: #f5f9ff;
    transition: 0.2s ease;
}

/* ========== Status Badges ========== */
.badge.status {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #fff;
    display: inline-block;
    text-align: center;
    min-width: 80px;
    text-transform: capitalize;
}

.badge.pending { background-color: #f39c12; }
.badge.completed { background-color: #27ae60; }
.badge.cancelled { background-color: #e74c3c; }
.badge.unpaid { background-color: #e74c3c; }
.badge.paid { background-color: #2ecc71; }

/* ========== View Button ========== */
.btn-view {
    background-color: #ffffff;
    color: #0B5CF9;
    border: 2px solid #0B5CF9;
    padding: 6px 14px;
    font-size: 0.85rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-view:hover {
    background-color: #0B5CF9;
    color: #ffffff;
}

/* ========== Modal Styles ========== */
.modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    position: relative;
    background-color: #fff;
    margin: 5% auto;
    padding: 0;
    border-radius: 16px;
    width: 80%;
    max-width: 1000px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2);
    animation: modalFadeIn 0.3s ease;
}

@keyframes modalFadeIn {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
}

.modal-header {
    padding: 20px 24px;
    background: linear-gradient(90deg, #0B5CF9, #4D8CFF);
    color: white;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.close-modal {
    color: white;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}

.close-modal:hover {
    opacity: 0.7;
}

.modal-body {
    padding: 24px;
    max-height: 70vh;
    overflow-y: auto;
}

.order-status-section {
    margin-bottom: 24px;
}

.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 24px;
}

.card-header {
    background: #f6f9fc;
    padding: 16px 24px;
    border-bottom: 1px solid #edf2f7;
    font-weight: 600;
}

.card-body {
    padding: 20px;
}

.modal-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 0;
}

.modal-table th, 
.modal-table td {
    padding: 12px 16px;
    border: 1px solid #e0e6ed;
}

.modal-table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.modal-footer {
    padding: 16px 24px;
    background-color: #f8f9fa;
    border-bottom-left-radius: 16px;
    border-bottom-right-radius: 16px;
    text-align: right;
}

.modal-btn {
    background-color: #0B5CF9;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 10px 20px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.modal-btn:hover {
    background-color: #0949c6;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #fff;
    display: inline-block;
    text-align: center;
}

.status-badge.pending { background-color: #f39c12; }
.status-badge.in-progress { background-color: #3498db; }
.status-badge.completed { background-color: #27ae60; }
.status-badge.cancelled { background-color: #e74c3c; }
.status-badge.paid { background-color: #2ecc71; }
.status-badge.unpaid { background-color: #e74c3c; }
.status-badge.refunded { background-color: #95a5a6; }
</style>

<!-- Order Details Modal -->
<div id="orderModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Order #<span id="modalOrderId"></span></h5>
            <button type="button" class="close-modal" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body" id="orderModalContent">
            <!-- Content will be loaded dynamically -->
            <div class="text-center p-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Loading order details...</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-btn" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>

<script>
// Function to display order details in modal
function viewOrder(orderId) {
    // Show modal
    document.getElementById('orderModal').style.display = 'block';
    document.getElementById('modalOrderId').textContent = 'ORD-' + orderId;
    
    // Fetch order details
    fetch('fetch_order_details.php?id=' + orderId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayOrderDetails(data.order);
            } else {
                document.getElementById('orderModalContent').innerHTML = 
                    '<div class="alert alert-danger">Error loading order details: ' + data.error + '</div>';
            }
        })
        .catch(error => {
            document.getElementById('orderModalContent').innerHTML = 
                '<div class="alert alert-danger">Error loading order details. Please try again later.</div>';
            console.error('Error:', error);
        });
}

// Function to close modal
function closeModal() {
    document.getElementById('orderModal').style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('orderModal');
    if (event.target === modal) {
        closeModal();
    }
}

// Function to display order details in modal
function displayOrderDetails(order) {
    const modalContent = document.getElementById('orderModalContent');
    
    let html = `
        <!-- Order Status -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-1">Status: <span class="status-badge ${order.status.toLowerCase()}">${order.status}</span></p>
                                <p class="mb-1">Payment: <span class="status-badge ${order.payment_status.toLowerCase()}">${order.payment_status}</span></p>
                                <p class="mb-0">Order Date: ${order.order_date}</p>
                            </div>
                            <div>
                                <p class="mb-1">Expected Completion: ${order.expected_completion || 'To be determined'}</p>
                                <p class="mb-0">Assigned Staff: ${order.employee_name || 'Not yet assigned'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Info -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Order Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Service:</strong> ${order.service_name}</p>
                                <p><strong>Category:</strong> ${order.service_category}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Price:</strong> ₱${order.total_price}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Order Items</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="modal-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>`;
    
    // Add order items
    if (order.items && order.items.length > 0) {
        order.items.forEach((item, index) => {
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.size}</td>
                    <td>${item.quantity}</td>
                    <td>₱${parseFloat(item.unit_price).toFixed(2)}</td>
                    <td>₱${order.total_price}</td>
                </tr>`;
        });
    } else {
        html += `<tr><td colspan="5" class="text-center">No items found</td></tr>`;
    }
    
    html += `
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                        <td><strong>₱${parseFloat(order.total_price).toFixed(2)}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    
    // Payment Information
    if (order.payment) {
        html += `
        <!-- Payment Information -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Payment Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Payment Date:</strong> ${order.payment.payment_date}</p>
                                <p><strong>Amount:</strong> ₱${order.total_price}</p>
                                <p><strong>Status:</strong> ${order.payment.status}</p>
                            </div>
                            <div class="col-md-6">
                                ${order.payment.reference_number ? `<p><strong>Reference #:</strong> ${order.payment.reference_number}</p>` : ''}
                                ${order.payment.proof_file_path ? `<p><strong>Payment Proof:</strong> <a href="/public/${order.payment.proof_file_path}" target="_blank">View Receipt</a></p>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    }
    
    modalContent.innerHTML = html;
}
</script>