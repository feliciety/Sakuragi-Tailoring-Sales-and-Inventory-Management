<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_customer.php';

if (get_user_role() !== ROLE_CUSTOMER) {
    header('Location: /dashboards/employee/dashboard.php');
    exit();
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#ORD-1023</td>
                        <td>May 3, 2025</td>
                        <td>Embroidery</td>
                        <td>Customizable</td>
                        <td>25</td>
                        <td>Maria Santos</td>
                        <td>May 10, 2025</td>
                        <td><span class="badge status pending">Pending</span></td>
                        <td><span class="badge status unpaid">Unpaid</span></td>
                        <td>
                            <button class="btn-view">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
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
</style>
