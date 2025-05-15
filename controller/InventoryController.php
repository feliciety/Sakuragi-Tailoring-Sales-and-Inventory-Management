<?php
require_once __DIR__ . '/../config/db_connect.php';

// Fetch all inventory items
function getInventory($pdo) {
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

// Get all suppliers
function getSuppliers($pdo) {
  $stmt = $pdo->prepare("SELECT supplier_id, supplier_name FROM suppliers ORDER BY supplier_name");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get all supply types
function getSupplyTypes($pdo) {
  $stmt = $pdo->prepare("SELECT supply_type_id, name FROM supply_types ORDER BY name");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? null;

  // Sanitize all inputs
  $item_name = trim($_POST['item_name'] ?? '');
  $supplier_id = (int) ($_POST['supplier_id'] ?? 0);
  $supply_type_id = (int) ($_POST['supply_type_id'] ?? 0);
  $quantity = (int) ($_POST['quantity'] ?? 0);
  $reorder_level = (int) ($_POST['reorder_level'] ?? 10);

  try {
    if ($action === 'add') {
      // Optional: Prevent duplicate items for the same branch
      $check = $pdo->prepare("SELECT COUNT(*) FROM inventory WHERE item_name = :item_name AND branch_id = 2");
      $check->execute(['item_name' => $item_name]);
      if ($check->fetchColumn() > 0) {
        header('Location: ../dashboards/admin/inventory.php?error=duplicate');
        exit();
      }

      $stmt = $pdo->prepare("
        INSERT INTO inventory (branch_id, item_name, supplier_id, supply_type_id, quantity, reorder_level, last_updated)
        VALUES (2, :item_name, :supplier_id, :supply_type_id, :quantity, :reorder_level, NOW())
      ");
      $stmt->execute([
        'item_name' => $item_name,
        'supplier_id' => $supplier_id,
        'supply_type_id' => $supply_type_id,
        'quantity' => $quantity,
        'reorder_level' => $reorder_level
      ]);
    }

    if ($action === 'edit') {
      $id = (int) ($_POST['inventory_id'] ?? 0);
      $stmt = $pdo->prepare("
        UPDATE inventory
        SET item_name = :item_name,
            supplier_id = :supplier_id,
            supply_type_id = :supply_type_id,
            quantity = :quantity,
            reorder_level = :reorder_level,
            last_updated = NOW()
        WHERE inventory_id = :id
      ");
      $stmt->execute([
        'item_name' => $item_name,
        'supplier_id' => $supplier_id,
        'supply_type_id' => $supply_type_id,
        'quantity' => $quantity,
        'reorder_level' => $reorder_level,
        'id' => $id
      ]);
    }

    if ($action === 'delete') {
      $id = (int) ($_POST['inventory_id'] ?? 0);
      $stmt = $pdo->prepare("DELETE FROM inventory WHERE inventory_id = :id");
      $stmt->execute(['id' => $id]);
    }

    // Redirect after all actions
    header('Location: ../dashboards/admin/inventory.php?success=1');
    exit();
  } catch (PDOException $e) {
    error_log("Inventory DB Error: " . $e->getMessage());
    header('Location: ../dashboards/admin/inventory.php?error=db');
    exit();
  }
}
