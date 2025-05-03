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
    <h1>Inventory Management</h1>

    <div class="table-controls">
        <div class="filters">
            <div class="input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="inventorySearch" placeholder="Search items..."
                    class="table-search"
                    onkeyup="filterTableBySearch('inventorySearch', 'inventoryTable')">
            </div>
            <div class="select-wrapper">
                <i class="fas fa-filter"></i>
                <select id="stockFilter" class="table-filter"
                    onchange="filterTableByStatus('stockFilter', 'inventoryTable')">
                    <option value="">All Stock</option>
                    <option value="low">Low</option>
                    <option value="sufficient">Sufficient</option>
                </select>
            </div>
        </div>

        <button onclick="exportTableToCSV('inventoryTable', 'inventory.csv')" class="btn-export">
            <i class="fas fa-download"></i> Export CSV
        </button>
    </div>

    <div class="table-responsive">
        <table id="inventoryTable">
            <thead>
                <tr>
                    <th onclick="sortTableByColumn('inventoryTable', 0)">Item Name</th>
                    <th onclick="sortTableByColumn('inventoryTable', 1)">Category</th>
                    <th onclick="sortTableByColumn('inventoryTable', 2)">Supplier</th>
                    <th onclick="sortTableByColumn('inventoryTable', 3)">Quantity</th>
                    <th onclick="sortTableByColumn('inventoryTable', 4)">Last Updated</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Red Cotton Fabric</td>
                    <td>Fabric</td>
                    <td>ABC Textiles</td>
                    <td>5</td>
                    <td>2025-05-01</td>
                    <td><span class="status absent">Low</span></td>
                    <td class="action-buttons">
                        <button class="edit"><i class="fas fa-pen"></i></button>
                        <button class="delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>Black Thread</td>
                    <td>Thread</td>
                    <td>XYZ Supplies</td>
                    <td>50</td>
                    <td>2025-04-30</td>
                    <td><span class="status employed">Sufficient</span></td>
                    <td class="action-buttons">
                        <button class="edit"><i class="fas fa-pen"></i></button>
                        <button class="delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<!-- Load centralized table script -->
<script src="/assets/js/tables.js"></script>

<?php require_once '../../includes/footer.php'; ?>
