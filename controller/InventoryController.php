<?php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../dao/InventoryDAO.php';

// 🔁 Fetch all inventory records
function getInventory($pdo)
{
    $stmt = $pdo->prepare("
    SELECT 
      i.inventory_id,
      i.item_name,
      i.quantity,
      i.reorder_level,
      i.last_updated,
      s.supplier_name,
      t.name AS supply_type
    FROM inventory i
    LEFT JOIN suppliers s ON i.supplier_id = s.supplier_id
    LEFT JOIN supply_types t ON i.supply_type_id = t.supply_type_id
    WHERE i.branch_id = 2
    ORDER BY i.last_updated DESC
  ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 📦 Get all suppliers
function getSuppliers($pdo)
{
    $stmt = $pdo->prepare('SELECT supplier_id, supplier_name FROM suppliers ORDER BY supplier_name');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 📂 Get all supply types (return enum values for category)
function getSupplyTypes($pdo)
{
    // Manually return the enum values for 'category' in inventory
    return [['name' => 'Fabric'], ['name' => 'Thread'], ['name' => 'Ink'], ['name' => 'Accessories']];
}

// ✏️ Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $inventoryDAO = new InventoryDAO($pdo);

    if ($action === 'add') {
        $item_name = $_POST['item_name'];
        $supplier_id = $_POST['supplier_id'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $reorder_level = $_POST['reorder_level'];

        $stmt = $pdo->prepare("
      INSERT INTO inventory (branch_id, item_name, supplier_id, category, quantity, reorder_level)
      VALUES (2, :item_name, :supplier_id, :category, :quantity, :reorder_level)
    ");
        $stmt->execute([
            'item_name' => $item_name,
            'supplier_id' => $supplier_id,
            'category' => $category,
            'quantity' => $quantity,
            'reorder_level' => $reorder_level,
        ]);
        header('Location: ../dashboards/admin/inventory.php');
        exit();
    }

    if ($action === 'edit') {
        $id = $_POST['inventory_id'];
        $item_name = $_POST['item_name'];
        $supplier_id = $_POST['supplier_id'];
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $reorder_level = $_POST['reorder_level'];

        $stmt = $pdo->prepare("
      UPDATE inventory
      SET item_name = :item_name,
          supplier_id = :supplier_id,
          category = :category,
          quantity = :quantity,
          reorder_level = :reorder_level
      WHERE inventory_id = :id
    ");
        $stmt->execute([
            'item_name' => $item_name,
            'supplier_id' => $supplier_id,
            'category' => $category,
            'quantity' => $quantity,
            'reorder_level' => $reorder_level,
            'id' => $id,
        ]);
        header('Location: ../dashboards/admin/inventory.php');
        exit();
    }

    if ($action === 'delete') {
        $id = $_POST['inventory_id'];
        $stmt = $pdo->prepare('DELETE FROM inventory WHERE inventory_id = :id');
        $stmt->execute(['id' => $id]);
        header('Location: ../dashboards/admin/inventory.php');
        exit();
    }

    // Stock In/Out logic
    if ($action === 'stock_in') {
        $inventory_id = $_POST['inventory_id'];
        $quantity = (int) $_POST['quantity'];
        $supplier_id = $_POST['supplier_id'] ?? null;
        $note = $_POST['note'] ?? null;
        $inventoryDAO->updateInventoryQuantity($inventory_id, $quantity, true);
        $inventoryDAO->logStockChange($inventory_id, 'in', $quantity, $supplier_id, $note);
        header('Location: ../dashboards/admin/inventory.php?msg=stockin');
        exit();
    }
    if ($action === 'stock_out') {
        $inventory_id = $_POST['inventory_id'];
        $quantity = (int) $_POST['quantity'];
        $note = $_POST['note'] ?? null;
        $inventoryDAO->updateInventoryQuantity($inventory_id, $quantity, false);
        $inventoryDAO->logStockChange($inventory_id, 'out', $quantity, null, $note);
        header('Location: ../dashboards/admin/inventory.php?msg=stockout');
        exit();
    }
}
