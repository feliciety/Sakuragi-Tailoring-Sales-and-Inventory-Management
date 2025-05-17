<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php'; // Any logged-in user
require_once '../../config/db_connect.php'; // Add database connection
require_once '../../includes/header.php';
require_once '../../includes/sidebar_employee.php';

// Check if $pdo is defined after including db_connect.php
if (!isset($pdo)) {
    die('Database connection failed. Please check the db_connect.php file.');
}

// Block customers
if (get_user_role() === ROLE_CUSTOMER) {
    header('Location: /dashboards/customer/dashboard.php');
    exit();
}

// Get currently logged in user's ID
$user_id = $_SESSION['user_id'];

// First, let's check the structure of the users table
try {
    $checkTableStmt = $pdo->prepare('DESCRIBE users');
    $checkTableStmt->execute();
    $columns = $checkTableStmt->fetchAll(PDO::FETCH_COLUMN);

    // Determine which customer name fields exist
    $hasFirstName = in_array('first_name', $columns);
    $hasLastName = in_array('last_name', $columns);
    $hasName = in_array('name', $columns);
    $hasFullName = in_array('full_name', $columns);

    // Build the SQL query based on available columns
    $nameFields = '';
    if ($hasFirstName && $hasLastName) {
        $nameFields = 'u.first_name, u.last_name';
    } elseif ($hasFullName) {
        $nameFields = 'u.full_name';
    } elseif ($hasName) {
        $nameFields = 'u.name';
    } else {
        // Fallback to user_id if no name columns exist
        $nameFields = 'u.user_id as customer_name';
    }

    $sql = "
        SELECT o.order_id, o.order_date, o.status, o.total_price, ow.stage, ow.expected_completion,
               $nameFields
        FROM order_workflow ow
        JOIN orders o ON ow.order_id = o.order_id
        JOIN users u ON o.user_id = u.user_id
        WHERE ow.assigned_employee = ?
        ORDER BY o.order_date DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $result = $stmt->fetchAll();
} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}
?>

<main class="main-content">
    <h1>Assigned Orders</h1>
    <p>Here you can view orders assigned to you by the admin.</p>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Stage</th>
                    <th>Status</th>
                    <th>Expected Completion</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($result)): ?>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['order_id']) ?></td>
                            <td><?php if (isset($row['first_name']) && isset($row['last_name'])) {
                                echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                            } elseif (isset($row['full_name'])) {
                                echo htmlspecialchars($row['full_name']);
                            } elseif (isset($row['name'])) {
                                echo htmlspecialchars($row['name']);
                            } else {
                                echo 'Customer #' . htmlspecialchars($row['customer_name'] ?? 'Unknown');
                            } ?></td>
                            <td><?= htmlspecialchars(date('M d, Y', strtotime($row['order_date']))) ?></td>
                            <td><?= htmlspecialchars($row['stage']) ?></td>
                            <td>
                                <span class="badge <?= get_status_badge_class($row['status']) ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td><?= $row['expected_completion']
                                ? htmlspecialchars(date('M d, Y', strtotime($row['expected_completion'])))
                                : 'Not set' ?></td>
                            <td>₱<?= htmlspecialchars(number_format($row['total_price'], 2)) ?></td>
                            <td>
                                <a href="view_order.php?id=<?= $row['order_id'] ?>" class="btn btn-sm btn-primary">
                                    View Details
                                </a>
                                <a href="update_order_status.php?id=<?= $row[
                                    'order_id'
                                ] ?>" class="btn btn-sm btn-secondary">
                                    Update Status
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No orders assigned to you yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
// Helper function to get appropriate badge class based on status
function get_status_badge_class($status)
{
    switch ($status) {
        case 'Completed':
            return 'bg-success';
        case 'Cancelled':
            return 'bg-danger';
        case 'In Progress':
            return 'bg-primary';
        case 'Pending':
            return 'bg-warning';
        default:
            return 'bg-secondary';
    }
}
require_once '../../includes/footer.php';
?>

