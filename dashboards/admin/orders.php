<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
?>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<main class="main-content">
    <h1>Manage Orders</h1>

    <div class="table-controls">
        <div class="filters">
            <div class="input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="orderSearch" placeholder="Search orders..." class="table-search"
                    onkeyup="filterTableBySearch('orderSearch', 'orderTable')">
            </div>
            <div class="select-wrapper">
                <i class="fas fa-filter"></i>
                <select id="orderStatusFilter" class="table-filter"
                    onchange="filterTableByStatus('orderStatusFilter', 'orderTable')">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <button onclick="exportTableToCSV('orderTable', 'orders.csv')" class="btn-export">
            <i class="fas fa-download"></i> Export CSV
        </button>
    </div>

    <div class="table-responsive">
        <table id="orderTable">
            <thead>
                <tr>
                    <th onclick="sortTableByColumn('orderTable', 0)">Order #</th>
                    <th onclick="sortTableByColumn('orderTable', 1)">Customer</th>
                    <th onclick="sortTableByColumn('orderTable', 2)">Date</th>
                    <th onclick="sortTableByColumn('orderTable', 3)">Total</th>
                    <th onclick="sortTableByColumn('orderTable', 4)">Status</th>
                    <th onclick="sortTableByColumn('orderTable', 5)">Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#1023</td>
                    <td>Maria Santos</td>
                    <td>Apr 28, 2025</td>
                    <td>₱1,250.00</td>
                    <td><span class="status hired">Completed</span></td>
                    <td>Paid</td>
                    <td class="action-buttons">
                        <button class="view"><i class="fas fa-eye"></i></button>
                        <button class="delete"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#1022</td>
                    <td>Juan Dela Cruz</td>
                    <td>Apr 27, 2025</td>
                    <td>₱980.00</td>
                    <td><span class="status employed">Pending</span></td>
                    <td>Unpaid</td>
                    <td class="action-buttons">
                        <button class="view"><i class="fas fa-eye"></i></button>
                        <button class="delete"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<!-- Central table JS logic -->
<script src="/assets/js/tables.js"></script>

<?php require_once '../../includes/footer.php'; ?>
