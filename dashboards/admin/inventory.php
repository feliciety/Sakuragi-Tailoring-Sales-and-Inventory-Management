<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once '../../includes/header.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once '../../includes/sidebar_admin.php';
require_once __DIR__ . '/../../controller/InventoryController.php';
?>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="/../public/assets/css/adminInventory.css" />';
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
                <?php foreach ($inventoryItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['item_name']) ?></td>
                        <td><?= htmlspecialchars($item['category']) ?></td>
                        <td><?= htmlspecialchars($item['supplier_name']) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td><?= htmlspecialchars($item['last_updated']) ?></td>
                        <td><span class="status <?= $item['status'] === 'Low' ? 'absent' : 'employed' ?>">
                            <?= htmlspecialchars($item['status']) ?>
                        </span></td>
                        <td class="action-buttons">
                            <button class="edit" onclick="openEditModal(<?= $item[
                                'inventory_id'
                            ] ?>, '<?= htmlspecialchars($item['item_name'], ENT_QUOTES) ?>', <?= $item['quantity'] ?>)">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Edit Quantity</h2>
        <form id="editForm" method="POST" action="inventory.php">
            <input type="hidden" name="inventory_id" id="inventory_id">
            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" id="item_name" name="item_name" readonly>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="btn-save">Save Changes</button>
        </form>
    </div>
</div>


<?php require_once '../../includes/footer.php'; ?>
