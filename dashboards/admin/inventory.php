<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
?>

<main class="main-content">
    <h1>Inventory Management</h1>

    <div class="table-controls">
        <div class="filters">
            <div class="input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="inventorySearch" placeholder="Search items..." class="table-search" onkeyup="filterInventoryTable()">
            </div>
            <div class="select-wrapper">
                <i class="fas fa-filter"></i>
                <select id="stockFilter" class="table-filter" onchange="filterInventoryStatus()">
                    <option value="">All Stock</option>
                    <option value="low">Low Stock</option>
                    <option value="ok">Sufficient Stock</option>
                </select>
            </div>
        </div>

        <button onclick="exportInventoryToCSV()" class="btn-export">
            <i class="fas fa-download"></i> Export CSV
        </button>
    </div>

    <div class="table-responsive">
        <table id="inventoryTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Item Name</th>
                    <th onclick="sortTable(1)">Category</th>
                    <th onclick="sortTable(2)">Supplier</th>
                    <th onclick="sortTable(3)">Quantity</th>
                    <th onclick="sortTable(4)">Last Updated</th>
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

<?php require_once '../../includes/footer.php'; ?>
