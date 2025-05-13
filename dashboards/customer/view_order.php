<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once '../../middleware/auth_required.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_customer.php';
require_once '../../controller/OrderController.php';

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

// Initialize the OrderController with the PDO connection
$orderController = new OrderController($pdo);

// Fetch order details using the controller
try {
    $result = $orderController->getOrderById($order_id, $_SESSION['user_id']);

    if (!$result) {
        // Order not found or doesn't belong to this user
        header('Location: my_orders.php');
        exit();
    }

    // Extract order data for the view
    $order = $result;
    $orderDetails = $result;
    $orderItems = $result['items'];
    $payment = $result['payment'];
} catch (Exception $e) {
    // Log error
    error_log('Error fetching order details: ' . $e->getMessage());
    $error = 'Unable to retrieve order details. Please try again later.';
}
?>
<link rel="stylesheet" href="../../public/assets/css/order.css">
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
