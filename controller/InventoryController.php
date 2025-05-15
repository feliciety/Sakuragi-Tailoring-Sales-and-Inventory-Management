<?php
require_once __DIR__ . '/../config/db_connect.php';

// 🔁 Fetch all inventory records
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

// 📦 Get all suppliers
function getSuppliers($pdo) {
  $stmt = $pdo->prepare("SELECT supplier_id, supplier_name FROM suppliers ORDER BY supplier_name");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 📂 Get all supply types
function getSupplyTypes($pdo) {
  $stmt = $pdo->prepare("SELECT supply_type_id, name FROM supply_types ORDER BY name");
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ✏️ Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? null;

  if ($action === 'add') {
    $item_name = $_POST['item_name'];
    $supplier_id = $_POST['supplier_id'];
    $supply_type_id = $_POST['supply_type_id'];
    $quantity = $_POST['quantity'];
    $reorder_level = $_POST['reorder_level'];

    $stmt = $pdo->prepare("
      INSERT INTO inventory (branch_id, item_name, supplier_id, supply_type_id, quantity, reorder_level)
      VALUES (2, :item_name, :supplier_id, :supply_type_id, :quantity, :reorder_level)
    ");
    $stmt->execute([
      'item_name' => $item_name,
      'supplier_id' => $supplier_id,
      'supply_type_id' => $supply_type_id,
      'quantity' => $quantity,
      'reorder_level' => $reorder_level
    ]);

    header('Location: ../dashboards/admin/inventory.php');
    exit();
  }

  if ($action === 'edit') {
    $id = $_POST['inventory_id'];
    $item_name = $_POST['item_name'];
    $supplier_id = $_POST['supplier_id'];
    $supply_type_id = $_POST['supply_type_id'];
    $quantity = $_POST['quantity'];
    $reorder_level = $_POST['reorder_level'];

    $stmt = $pdo->prepare("
      UPDATE inventory
      SET item_name = :item_name,
          supplier_id = :supplier_id,
          supply_type_id = :supply_type_id,
          quantity = :quantity,
          reorder_level = :reorder_level
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

    header('Location: ../dashboards/admin/inventory.php');
    exit();
  }

  if ($action === 'delete') {
    $id = $_POST['inventory_id'];

    $stmt = $pdo->prepare("DELETE FROM inventory WHERE inventory_id = :id");
    $stmt->execute(['id' => $id]);

    header('Location: ../dashboards/admin/inventory.php');
    exit();
  }
}
