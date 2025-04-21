<?php
include '../../includes/session_check.php';
include '../../includes/customer_header.php';
include '../../includes/customer_sidebar.php';
include '../../config/db.php'; 
$userId = $_SESSION['user']['user_id'];
?>

<link rel="stylesheet" href="../../public/assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="dashboard-content py-4 px-3">
    <h3 class="fw-semibold">My Orders</h3>
    <p class="text-muted">Track all your past and current tailoring orders here.</p>

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <?php
        $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Service</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Total (₱)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['order_id']) ?></td>
                                <td><?= date("M d, Y", strtotime($row['order_date'])) ?></td>
                                <td><?= htmlspecialchars($row['service_type'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['quantity'] ?? '1') ?></td>
                                <td>
                                    <?php
                                    $status = $row['status'];
                                    $badgeClass = match ($status) {
                                        'Completed' => 'success',
                                        'In Progress' => 'warning',
                                        'Cancelled' => 'danger',
                                        default => 'secondary',
                                    };
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                                </td>
                                <td><?= number_format($row['total_price'], 2) ?></td>
                                <td>
                                    <a href="order_details.php?id=<?= $row['order_id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">
                    You haven’t placed any orders yet. Start by placing a
                    <a href="place_order.php" class="alert-link">new order</a>.
                </div>
            <?php endif;

            $stmt->close();
        } else {
            echo '<div class="alert alert-danger">Error fetching orders. Please try again later.</div>';
        }

        $conn->close();
        ?>
    </div>
</div>

<?php include '../../includes/customer_footer.php'; ?>
