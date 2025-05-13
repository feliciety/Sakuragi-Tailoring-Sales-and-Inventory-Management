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

// Fetch customer's orders from the database
try {
    $stmt = $pdo->prepare("
        SELECT 
            o.order_id, 
            o.order_date, 
            o.status, 
            o.payment_status,
            o.expected_completion,
            s.service_name,
            s.service_category,
            u.full_name AS employee_name,
            COUNT(od.order_detail_id) AS item_count,
            SUM(od.quantity) AS total_quantity
        FROM 
            orders o
        JOIN 
            services s ON o.service_id = s.service_id
        LEFT JOIN 
            users u ON o.employee_id = u.user_id
        LEFT JOIN
            order_details od ON o.order_id = od.order_id
        WHERE 
            o.user_id = :user_id
        GROUP BY
            o.order_id
        ORDER BY 
            o.order_date DESC
    ");

    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error
    error_log('Error fetching orders: ' . $e->getMessage());
    $orders = [];
}
?>

<main class="main-content">
    <h5 class="page-title">My Orders</h5>
    <p class="page-subtext">Track your orders, design type, status, and staff handling them.</p>

    <div class="my-orders-container">
        <div class="table-wrapper">
            <table class="my-orders-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Service</th>
                        <th>Design Type</th>
                        <th>Total Items</th>
                        <th>Assigned Staff</th>
                        <th>Expected Completion</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Check</th>
                    </tr>
                </thead>                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="10" class="text-center">No orders found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#ORD-<?= $order['order_id'] ?></td>
                                <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                                <td><?= htmlspecialchars($order['service_name']) ?></td>
                                <td><?= $order['service_category'] === 'Embroidery' ||
                                $order['service_category'] === 'Screen Printing'
                                    ? 'Standard'
                                    : 'N/A' ?></td>
                                <td><?= $order['total_quantity'] ?? 0 ?></td>
                                <td><?= $order['employee_name']
                                    ? htmlspecialchars($order['employee_name'])
                                    : '<span class="text-muted">Not yet assigned</span>' ?></td>
                                <td><?= $order['expected_completion']
                                    ? date('M d, Y', strtotime($order['expected_completion']))
                                    : 'To be determined' ?></td>
                                <td><span class="badge status <?= strtolower($order['status']) ?>"><?= $order[
    'status'
] ?></span></td>
                                <td><span class="badge status <?= strtolower($order['payment_status']) ?>"><?= $order[
    'payment_status'
] ?></span></td>                                <td>
                                    <button type="button" class="btn-view" onclick="viewOrder(<?= $order[
                                        'order_id'
                                    ] ?>)">View</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>


