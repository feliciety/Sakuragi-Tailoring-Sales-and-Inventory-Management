<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once '../../middleware/auth_required.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_customer.php';

if (get_user_role() !== ROLE_CUSTOMER) {
    header('Location: /dashboards/employee/dashboard.php');
    exit();
}

// Check if order ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: my_orders.php');
    exit();
}

$order_id = (int) $_GET['id'];

// Fetch order details
try {
    // First check if this order belongs to the logged in user
    $stmt = $pdo->prepare("
        SELECT * FROM orders 
        WHERE order_id = :order_id AND user_id = :user_id
    ");
    $stmt->execute([
        'order_id' => $order_id,
        'user_id' => $_SESSION['user_id'],
    ]);

    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        // Order not found or doesn't belong to this user
        header('Location: my_orders.php');
        exit();
    }

    // Fetch additional order information
    $stmt = $pdo->prepare("
        SELECT 
            s.service_name, 
            s.service_category,
            s.service_price,
            o.status,
            o.payment_status, 
            o.order_date,
            o.expected_completion,
            u.full_name AS employee_name
        FROM 
            orders o
        JOIN 
            services s ON o.service_id = s.service_id
        LEFT JOIN 
            users u ON o.employee_id = u.user_id
        WHERE 
            o.order_id = :order_id
    ");
    $stmt->execute(['order_id' => $order_id]);
    $orderDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get order items
    $stmt = $pdo->prepare("
        SELECT 
            od.*
        FROM 
            order_details od
        WHERE 
            od.order_id = :order_id
    ");
    $stmt->execute(['order_id' => $order_id]);
    $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get payment information
    $stmt = $pdo->prepare("
        SELECT 
            p.*
        FROM 
            payments p
        WHERE 
            p.order_id = :order_id
    ");
    $stmt->execute(['order_id' => $order_id]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error
    error_log('Error fetching order details: ' . $e->getMessage());
    $error = 'Unable to retrieve order details. Please try again later.';
}
?>

<main class="main-content">
    <div class="order-detail-header">
        <h5 class="page-title">Order #ORD-<?= $order_id ?></h5>
        <p class="page-subtext">Placed on <?= date('F d, Y', strtotime($orderDetails['order_date'])) ?></p>
        <a href="my_orders.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Orders</a>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php else: ?>
        <div class="order-detail-container">
            <!-- Order Status -->
            <div class="order-status-section mb-4">
                <div class="status-card <?= strtolower($orderDetails['status']) ?>">
                    <div class="icon-wrapper">
                        <?php if ($orderDetails['status'] == 'Pending'): ?>
                            <i class="fas fa-clock"></i>
                        <?php elseif ($orderDetails['status'] == 'In Progress'): ?>
                            <i class="fas fa-cog fa-spin"></i>
                        <?php elseif ($orderDetails['status'] == 'Completed'): ?>
                            <i class="fas fa-check-circle"></i>
                        <?php elseif ($orderDetails['status'] == 'Cancelled'): ?>
                            <i class="fas fa-times-circle"></i>
                        <?php endif; ?>
                    </div>
                    <div class="status-details">
                        <h6>Status: <span class="status-text"><?= $orderDetails['status'] ?></span></h6>
                        <p>Payment: <span class="payment-status <?= strtolower(
                            $orderDetails['payment_status']
                        ) ?>"><?= $orderDetails['payment_status'] ?></span></p>
                        <?php if ($orderDetails['expected_completion']): ?>
                            <p>Expected Completion: <?= date(
                                'F d, Y',
                                strtotime($orderDetails['expected_completion'])
                            ) ?></p>
                        <?php else: ?>
                            <p>Expected Completion: To be determined</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="order-info-section mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Order Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Service:</strong> <?= htmlspecialchars($orderDetails['service_name']) ?></p>
                                <p><strong>Category:</strong> <?= htmlspecialchars(
                                    $orderDetails['service_category']
                                ) ?></p>
                                <?php if ($orderDetails['employee_name']): ?>
                                    <p><strong>Assigned Staff:</strong> <?= htmlspecialchars(
                                        $orderDetails['employee_name']
                                    ) ?></p>
                                <?php else: ?>
                                    <p><strong>Assigned Staff:</strong> <span class="text-muted">Not yet assigned</span></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Price:</strong> ₱<?= number_format($order['total_price'], 2) ?></p>
                                <p><strong>Order Date:</strong> <?= date(
                                    'F d, Y',
                                    strtotime($orderDetails['order_date'])
                                ) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="order-items-section mb-4">
                <div class="card">
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
                                <tbody>
                                    <?php if (empty($orderItems)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No items found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php
                                        $i = 1;
                                        foreach ($orderItems as $item): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= htmlspecialchars($item['size']) ?></td>
                                                <td><?= $item['quantity'] ?></td>
                                                <td>₱<?= number_format($item['unit_price'], 2) ?></td>
                                                <td>₱<?= number_format($item['subtotal'], 2) ?></td>
                                            </tr>
                                        <?php endforeach;
                                        ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                        <td><strong>₱<?= number_format($order['total_price'], 2) ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <?php if ($payment): ?>
            <div class="payment-section mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6>Payment Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Payment Date:</strong> <?= date(
                                    'F d, Y',
                                    strtotime($payment['payment_date'])
                                ) ?></p>
                                <p><strong>Amount:</strong> ₱<?= number_format($payment['amount'], 2) ?></p>
                                <p><strong>Status:</strong> <?= $payment['status'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <?php if ($payment['reference_number']): ?>
                                    <p><strong>Reference #:</strong> <?= htmlspecialchars(
                                        $payment['reference_number']
                                    ) ?></p>
                                <?php endif; ?>
                                <?php if ($payment['proof_file_path']): ?>
                                    <p><strong>Payment Proof:</strong> 
                                        <a href="/public/<?= $payment[
                                            'proof_file_path'
                                        ] ?>" target="_blank">View Receipt</a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    <?php endif; ?>
</main>

<?php require_once '../../includes/footer.php'; ?>

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
    margin-bottom: 1rem;
}

.btn-back {
    display: block;
    margin: 0 auto 2rem;
    text-align: center;
    color: #0B5CF9;
    text-decoration: none;
    font-weight: 600;
}

.btn-back:hover {
    text-decoration: underline;
}

/* ========== Order Details Container ========== */
.order-detail-container {
    background: #ffffff;
    border-radius: 16px;
    padding: 32px;
    margin: 0 auto;
    max-width: 1000px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.06);
}

/* Status Card */
.status-card {
    display: flex;
    align-items: center;
    padding: 16px;
    border-radius: 12px;
    background-color: #f8f9fa;
    margin-bottom: 16px;
    border-left: 5px solid #ccc;
}

.status-card.pending {
    border-left-color: #f39c12;
    background-color: #fff9e6;
}

.status-card.in.progress {
    border-left-color: #3498db;
    background-color: #e6f7ff;
}

.status-card.completed {
    border-left-color: #27ae60;
    background-color: #e6fff0;
}

.status-card.cancelled {
    border-left-color: #e74c3c;
    background-color: #ffebe6;
}

.icon-wrapper {
    background-color: #fff;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 16px;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.status-card.pending .icon-wrapper {
    color: #f39c12;
}

.status-card.in.progress .icon-wrapper {
    color: #3498db;
}

.status-card.completed .icon-wrapper {
    color: #27ae60;
}

.status-card.cancelled .icon-wrapper {
    color: #e74c3c;
}

.status-details h6 {
    margin-bottom: 4px;
    font-weight: 600;
}

.status-text {
    font-weight: 700;
}

.payment-status {
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.9rem;
}

.payment-status.paid {
    background-color: #d4edda;
    color: #155724;
}

.payment-status.pending {
    background-color: #fff3cd;
    color: #856404;
}

.payment-status.refunded {
    background-color: #d1ecf1;
    color: #0c5460;
}

/* Card Styling */
.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 24px;
}

.card-header {
    background: linear-gradient(90deg, #0B5CF9, #4D8CFF);
    color: #ffffff;
    padding: 16px 24px;
    border-bottom: none;
}

.card-header h6 {
    margin-bottom: 0;
    font-weight: 600;
    font-size: 1.1rem;
}

.card-body {
    padding: 24px;
}

/* Table Styling */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 12px 16px;
    border: 1px solid #e0e6ed;
}

.table thead th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.table tfoot {
    background-color: #f8f9fa;
    font-weight: 700;
}

/* Responsive */
@media (max-width: 767px) {
    .order-detail-container {
        padding: 16px;
    }
}
</style>
