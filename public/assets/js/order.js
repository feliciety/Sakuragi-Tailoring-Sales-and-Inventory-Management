function viewOrder(orderId) {
    // Show modal
    document.getElementById('orderModal').style.display = 'block';
    document.getElementById('modalOrderId').textContent = 'ORD-' + orderId;
    
    // Show loading state
    document.getElementById('orderModalContent').innerHTML = `
        <div class="loading-indicator">
            <div class="spinner"></div>
            <p>Loading order details...</p>
        </div>
    `;
    
    // Fetch order details
    fetch('../../../dashboards/customer/fetch_order_details.php?id=' + orderId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log("Order data:", data); // Debug
            if (data.success) {
                displayOrderDetails(data.order);
            } else {
                document.getElementById('orderModalContent').innerHTML = 
                    `<div class="alert alert-danger">Error loading order details: ${data.error}</div>`;
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            document.getElementById('orderModalContent').innerHTML = 
                `<div class="alert alert-danger">Error loading order details: ${error.message}</div>`;
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
        <div class="order-status-section mb-4">
            <div class="status-card ${order.status.toLowerCase()}">
                <div class="icon-wrapper">
                    ${getStatusIcon(order.status)}
                </div>
                <div class="status-details">
                    <h6>Status: <span class="status-text">${order.status}</span></h6>
                    <p>Payment: <span class="payment-status ${order.payment_status.toLowerCase()}">${order.payment_status}</span></p>
                    <p>Expected Completion: ${order.expected_completion ? formatDate(order.expected_completion) : 'To be determined'}</p>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h6>Order Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Service:</strong> ${order.service_name}</p>
                        <p><strong>Category:</strong> ${order.service_category}</p>
                        ${order.employee_name ? 
                            `<p><strong>Assigned Staff:</strong> ${order.employee_name}</p>` : 
                            `<p><strong>Assigned Staff:</strong> <span class="text-muted">Not yet assigned</span></p>`
                        }
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total Price:</strong> ₱${parseFloat(order.total_price).toFixed(2)}</p>
                        <p><strong>Order Date:</strong> ${formatDate(order.order_date)}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                <h6>Order Items</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
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
    
    if (order.items && order.items.length > 0) {
        order.items.forEach((item, index) => {
            html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.size}</td>
                    <td>${item.quantity}</td>
                    <td>₱${parseFloat(item.unit_price).toFixed(2)}</td>
                    <td>₱${parseFloat(item.subtotal).toFixed(2)}</td>
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
        </div>`;
    
    // Payment Information
    if (order.payment) {
        html += `
        <!-- Payment Information -->
        <div class="card">
            <div class="card-header">
                <h6>Payment Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Payment Date:</strong> ${formatDate(order.payment.payment_date)}</p>
                        <p><strong>Amount:</strong> ₱${parseFloat(order.payment.amount).toFixed(2)}</p>
                        <p><strong>Status:</strong> ${order.payment.status}</p>
                    </div>
                    <div class="col-md-6">
                        ${order.payment.reference_number ? 
                            `<p><strong>Reference #:</strong> ${order.payment.reference_number}</p>` : ''}
                        ${order.payment.proof_file_path ? 
                            `<p><strong>Payment Proof:</strong> <a href="../../public/${order.payment.proof_file_path}" target="_blank">View Receipt</a></p>` : ''}
                    </div>
                </div>
            </div>
        </div>`;
    }
    
    modalContent.innerHTML = html;
}

// Helper function to format dates
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
}

// Helper function to get appropriate icon for status
function getStatusIcon(status) {
    switch(status) {
        case 'Pending':
            return '<i class="fas fa-clock"></i>';
        case 'In Progress':
            return '<i class="fas fa-cog fa-spin"></i>';
        case 'Completed':
            return '<i class="fas fa-check-circle"></i>';
        case 'Cancelled':
            return '<i class="fas fa-times-circle"></i>';
        default:
            return '<i class="fas fa-info-circle"></i>';
    }
}