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
    <h1>Reports & Analytics</h1>

    <div class="table-controls">
        <div class="filters">
            <div class="input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="reportSearch" placeholder="Search reports..." class="table-search"
                    onkeyup="filterTableBySearch('reportSearch', 'reportsTable')">
            </div>
        </div>

        <button onclick="exportTableToCSV('reportsTable', 'monthly_reports.csv')" class="btn-export">
            <i class="fas fa-download"></i> Export CSV
        </button>
    </div>

    <div class="table-responsive">
        <table id="reportsTable">
            <thead>
                <tr>
                    <th onclick="sortTableByColumn('reportsTable', 0)">Month</th>
                    <th onclick="sortTableByColumn('reportsTable', 1)">Total Sales</th>
                    <th onclick="sortTableByColumn('reportsTable', 2)">Orders Completed</th>
                    <th onclick="sortTableByColumn('reportsTable', 3)">Shirts Given (Promo)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>April 2025</td>
                    <td>₱32,500.00</td>
                    <td>58</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>March 2025</td>
                    <td>₱28,000.00</td>
                    <td>49</td>
                    <td>3</td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<!-- Centralized JS functions -->
<script src="/assets/js/tables.js"></script>

<?php require_once '../../includes/footer.php'; ?>
