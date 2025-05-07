<?php
// Handle form submission for updating inventory
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inventory_id'], $_POST['quantity'])) {
    $inventoryId = $_POST['inventory_id'];
    $quantity = $_POST['quantity'];

    if (!is_numeric($quantity) || $quantity < 0) {
        die('Invalid quantity value.');
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE inventory
            SET quantity = :quantity,
                last_updated = NOW()
            WHERE inventory_id = :inventory_id
        ");
        $stmt->execute([
            ':quantity' => $quantity,
            ':inventory_id' => $inventoryId,
        ]);

        header('Location: inventory.php');
        exit();
    } catch (PDOException $e) {
        die('Error updating inventory: ' . $e->getMessage());
    }
}

// Fetch inventory data
$stmt = $pdo->query(
    "SELECT i.inventory_id, i.item_name, i.category, s.supplier_name, i.quantity, i.last_updated,
            CASE
                WHEN i.quantity <= i.reorder_level THEN 'Low'
                ELSE 'Sufficient'
            END AS status
     FROM inventory i
     JOIN suppliers s ON i.supplier_id = s.supplier_id"
);

$inventoryItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Load centralized table script -->
<script src="/assets/js/tables.js"></script>
<script>
function openEditModal(inventoryId, itemName, quantity) {
    document.getElementById('inventory_id').value = inventoryId;
    document.getElementById('item_name').value = itemName;
    document.getElementById('quantity').value = quantity;
    document.getElementById('editModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Close the modal when clicking outside of it
window.onclick = function(event) {
    var modal = document.getElementById('editModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>
