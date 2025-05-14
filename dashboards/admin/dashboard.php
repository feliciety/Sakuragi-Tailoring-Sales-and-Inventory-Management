<?php
require_once __DIR__ . '/../../config/db_connect.php';
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../../middleware/role_admin_only.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar_admin.php';

$stmt = $pdo->query('SELECT COUNT(*) FROM orders');
$totalOrders = (int) $stmt->fetchColumn();

// Orders per day (last 7 days)
$chartLabels = [];
$chartData = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $chartLabels[] = date('M d', strtotime($date));
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM orders WHERE DATE(order_date) = ?');
    $stmt->execute([$date]);
    $chartData[] = (int) $stmt->fetchColumn();
}
// Fetch inventory items
$inventoryItems = [];
$stmt = $pdo->query("
    SELECT item_name, category, quantity, reorder_level
    FROM inventory
    ORDER BY quantity ASC
    LIMIT 5
");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $inventoryItems[] = $row;
}
// Order statuses
$orderStatuses = ['Pending', 'In Progress', 'Completed', 'Cancelled', 'Refunded'];
$statusCounts = [];
foreach ($orderStatuses as $status) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM orders WHERE status = ?');
    $stmt->execute([$status]);
    $statusCounts[] = (int) $stmt->fetchColumn();
}

// Top 5 Services
$serviceNames = [];
$serviceCounts = [];
$stmt = $pdo->query("
    SELECT s.service_name, COUNT(o.service_id) AS order_count
    FROM services s
    LEFT JOIN orders o ON s.service_id = o.service_id
    GROUP BY s.service_id
    ORDER BY order_count DESC
    LIMIT 5
");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $serviceNames[] = $row['service_name'];
    $serviceCounts[] = (int) $row['order_count'];
}

$branchLabels = [];
$branchCounts = [];

$stmt = $pdo->query("
    SELECT b.branch_name, COUNT(o.order_id) as order_count
    FROM branches b
    LEFT JOIN orders o ON b.branch_id = o.branch_id
    GROUP BY b.branch_id
    ORDER BY b.branch_id ASC
");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $branchLabels[] = $row['branch_name'];
    $branchCounts[] = (int) $row['order_count'];
}

// If no data was found, provide empty arrays or default values
if (empty($branchLabels)) {
    $branchLabels = ['No branches found'];
    $branchCounts = [0];
}

// Order Timelines
$orderTimelineLabels = [];
$orderTimelineStarts = [];
$orderTimelineEnds = [];
$stmt = $pdo->query("
    SELECT o.order_id, u.full_name, o.order_date, o.expected_completion
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    ORDER BY o.order_date DESC
    LIMIT 5
");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $orderTimelineLabels[] = 'Order #' . $row['order_id'] . ' - ' . $row['full_name'];
    $orderTimelineStarts[] = $row['order_date'];
    $orderTimelineEnds[] = $row['expected_completion'];
}

// Fetch active employees
$stmt = $pdo->query('SELECT COUNT(*) FROM employees WHERE status = "active"');
$activeEmployeesCount = (int) $stmt->fetchColumn();

// Fetch total inventory items
$stmt = $pdo->query('SELECT COUNT(*) AS total_items FROM inventory');
$totalInventoryItems = (int) $stmt->fetchColumn();

// Calculate total sales from completed orders
$stmt = $pdo->query('SELECT SUM(total_price) FROM orders WHERE status = "Completed" AND payment_status = "Paid"');
$totalSales = (float) $stmt->fetchColumn();
// If no completed orders yet, set to 0
$totalSales = $totalSales ?: 0;

// Recent orders for dashboard
$recentOrders = [];
$stmt = $pdo->query("
    SELECT 
        o.order_id,
        u.full_name,
        o.status,
        o.total_price,
        o.order_date
    FROM 
        orders o
    JOIN 
        users u ON o.user_id = u.user_id
    ORDER BY 
        o.order_date DESC
    LIMIT 5
");

$recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="main-content admin-dashboard">
    <div class="dashboard-container">
        <h1>Welcome, <?= $_SESSION['full_name'] ?> (Admin)</h1>

        <section class="dashboard-cards">
  <div class="card card-blue">    <div class="card-content">
      <div class="card-text">
        <h3>Total Orders</h3>
        <p><?= $totalOrders ?></p>
      </div>
      <div class="card-icon"><i class="fa-solid fa-cart-shopping"></i></div>
    </div>
  </div>

  <div class="card card-red">
    <div class="card-content">
      <div class="card-text">
        <h3>Inventory Items</h3>
        <p><?= $totalInventoryItems ?></p>
      </div>
      <div class="card-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
    </div>
  </div>
  <div class="card card-yellow">
    <div class="card-content">
      <div class="card-text">
        <h3>Total Sales</h3>
        <p>₱ <?= number_format($totalSales, 2) ?></p>
      </div>
      <div class="card-icon"><i class="fa-solid fa-peso-sign"></i></div>
    </div>
  </div>

  <div class="card card-green">
    <div class="card-content">
        <div class="card-text">
            <h3>Active Employees</h3>
            <p><?= $activeEmployeesCount ?></p>
        </div>
        <div class="card-icon"><i class="fa-solid fa-users"></i></div>
    </div>
  </div>
</section>


        <section class="chart-grid-2x2">
            <div class="chart-card"><h2>📈 Orders - Last 7 Days</h2><canvas id="ordersChart"></canvas></div>
            <div class="chart-card"><h2>📊 Orders by Status</h2><canvas id="orderStatusChart"></canvas></div>
            <div class="chart-card"><h2>🏆 Top 5 Services</h2><canvas id="topServicesChart"></canvas></div>
            <div class="chart-card"><h2>📍 Orders Per Branch</h2><canvas id="branchChart"></canvas></div>
        </section>

        <section class="recent-orders">
            <h2>📝 Recent Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentOrders)): ?>
                        <tr>
                            <td colspan="5" class="text-center">No recent orders found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td>#<?= $order['order_id'] ?></td>
                                <td><?= htmlspecialchars($order['full_name']) ?></td>
                                <td>
                                    <span class="badge status-<?= strtolower($order['status']) ?>">
                                        <?= $order['status'] ?>
                                </td>
                                <td>₱<?= number_format($order['total_price'], 2) ?></td>
                                <td><?= date('Y-m-d', strtotime($order['order_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section class="dashboard-bottom-section">
            <div class="low-stock">
                <h2>⚠️ Low Stock Alerts</h2>
                <ul>
                    <?php foreach ($inventoryItems as $item): ?>
                        <?php if ($item['quantity'] <= $item['reorder_level']): ?>
                            <li style="background: #ffeaea; padding: 14px; border-left: 6px solid #ff4c4c; margin-bottom: 10px; border-radius: 6px; font-weight: 500; color: #cc0000;">
                                <?= htmlspecialchars($item['item_name']) ?> - 
                                <?= htmlspecialchars($item['quantity']) ?> left 
                                <span style="color: red;">🔴 Low</span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="timeline-chart">
                <h2>🗓️ Order Timelines</h2>
                <ul class="timeline-list">
                    <?php foreach ($orderTimelineLabels as $i => $label): ?>
                        <li>
                            <div class="timeline-header">
                                <strong><?= htmlspecialchars($label) ?></strong>
                                <span class="date-range"><?= date(
                                    'M d',
                                    strtotime($orderTimelineStarts[$i])
                                ) ?> → <?= date('M d', strtotime($orderTimelineEnds[$i])) ?></span>
                            </div>
                            <div class="timeline-bar">
                                <?php
                                $start = strtotime($orderTimelineStarts[$i]);
                                $end = strtotime($orderTimelineEnds[$i]);
                                $days = max(1, round(($end - $start) / 86400));
                                $widthPercent = min(100, $days * 10);
                                ?>
                                <div class="timeline-fill" style="width: <?= $widthPercent ?>%;"></div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    </div>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>



        <!-- External Libraries -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/scrollreveal"></script>

<script>
    // Reveal animations
    ScrollReveal().reveal('.card, .chart-card, .recent-orders, .low-stock, .timeline-chart', {
        distance: '40px',
        duration: 900,
        easing: 'ease-in-out',
        origin: 'bottom',
        interval: 100
    });

    // Orders - Last 7 Days (Line Chart)
    new Chart(document.getElementById('ordersChart'), {
        type: 'line',
        data: {
            labels: <?= json_encode($chartLabels) ?>,
            datasets: [{
                label: 'Orders per Day',
                data: <?= json_encode($chartData) ?>,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Order Status (Doughnut Chart)
    new Chart(document.getElementById('orderStatusChart'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($orderStatuses) ?>,
            datasets: [{
                data: <?= json_encode($statusCounts) ?>,
                backgroundColor: ['#f39c12', '#3498db', '#2ecc71', '#e74c3c', '#9b59b6'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            maintainAspectRatio: false
        }
    });

    // Top 5 Services (Bar Chart)
    new Chart(document.getElementById('topServicesChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($serviceNames) ?>,
            datasets: [{
                label: 'Orders',
                data: <?= json_encode($serviceCounts) ?>,
                backgroundColor: '#007bff',
                borderColor: '#0056b3',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Orders Per Branch (Pie Chart)
    new Chart(document.getElementById('branchChart'), {
        type: 'pie',
        data: {
            labels: <?= json_encode($branchLabels) ?>,
            datasets: [{
                data: <?= json_encode($branchCounts) ?>,
                backgroundColor: ['#2980b9', '#5dade2', '#85c1e9', '#aed6f1']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            maintainAspectRatio: false
        }
    });
</script>



<style>
/* Hide all scrollbars in modern browsers */
body {
  overflow-y: auto;
  scrollbar-width: none; /* Firefox */
}

body::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Edge */
}
    
.admin-dashboard {
    padding: 30px 20px;
    font-family: 'Segoe UI', sans-serif;
}

.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 30px;
    animation: fadeIn 0.8s ease-in-out;
}



@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(15px); }
    100% { opacity: 1; transform: translateY(0); }
}

.admin-dashboard h1 {
    font-size: 2rem;
    text-align: center;
    background: linear-gradient(90deg, #0077cc, #00c6ff);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 700;
    animation: slideIn 0.6s ease;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Container */
.dashboard-cards {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: space-between;
  padding: 10px 0 30px;
}

/* Card */
.dashboard-cards .card {
  flex: 1 1 calc(25% - 20px);
  border-radius: 16px;
  padding: 24px 30px;
  background-color: #fff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 10px 18px rgba(0, 0, 0, 0.04);
  border-left: 6px solid transparent;
  cursor: pointer;
}

.dashboard-cards .card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
}

/* Card content */
.card-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

/* Text */
.card-text h3 {
  margin: 0;
  font-size: 0.95rem;
  color: #666;
  font-weight: 500;
}

.card-text p {
  margin: 8px 0 0;
  font-size: 1.75rem;
  font-weight: 700;
  color: #222;
}

/* Icon style */
.card-icon {
  background: #f1f5f9;
  color: inherit;
  width: 52px;
  height: 52px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.2);
}

/* Color Variants (PRIMARY colors) */
.card-blue {
  border-left-color: #007bff;
  --icon-color: #007bff;
}
.card-blue .card-icon { color: #007bff; }

.card-red {
  border-left-color: #dc3545;
  --icon-color: #dc3545;
}
.card-red .card-icon { color: #dc3545; }

.card-yellow {
  border-left-color: #ffc107;
  --icon-color: #ffc107;
}
.card-yellow .card-icon { color: #ffc107; }

.card-green {
  border-left-color: #28a745;
  --icon-color: #28a745;
}
.card-green .card-icon { color: #28a745; }

/* Responsive */
@media (max-width: 992px) {
  .dashboard-cards .card {
    flex: 1 1 calc(50% - 20px);
  }
}

@media (max-width: 576px) {
  .dashboard-cards .card {
    flex: 1 1 100%;
  }
}


/* Chart grid layout */
.chart-grid-2x2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
    width: 100%;
}

@media (max-width: 768px) {
    .chart-grid-2x2 {
        grid-template-columns: 1fr;
    }
}

.chart-card {
    background: #fff;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.05);
    text-align: center;
    height: 320px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    transition: transform 0.3s ease;
}

.chart-card:hover {
    transform: scale(1.02);
}

.chart-card h2 {
    font-size: 1.1rem;
    margin-bottom: 12px;
    color: #0077cc;
    font-weight: 600;
}

.chart-card canvas {
    flex-grow: 1;
    width: 100% !important;
    height: 250px !important;
    background-color: #f9fcff;
    border-radius: 10px;
    padding: 10px;
}

/* Recent orders section */
.recent-orders {
    background: #ffffff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.recent-orders h2 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: #004e99;
    border-left: 5px solid #0077cc;
    padding-left: 10px;
}

.recent-orders table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}

.recent-orders th, .recent-orders td {
    padding: 14px 16px;
    text-align: left;
    border-bottom: 1px solid #ddeeff;
}

.recent-orders thead {
    background-color: #e3f2ff;
    color: #0077cc;
    font-weight: bold;
}

.recent-orders tbody tr:hover {
    background-color: #f2faff;
    transition: background 0.3s ease;
}

/* Low stock & Timeline section */
.dashboard-bottom-section {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    margin-top: 30px;
}

.low-stock, .timeline-chart {
    flex: 1 1 48%;
    background: #ffffff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

@media (max-width: 768px) {
    .dashboard-bottom-section {
        flex-direction: column;
    }
    .low-stock, .timeline-chart {
        flex: 1 1 100%;
    }
}

.low-stock h2, .timeline-chart h2 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: #004e99;
    border-left: 5px solid #0077cc;
    padding-left: 10px;
}   padding-left: 0;
    margin: 0;
.low-stock ul {
    list-style: none;
    padding-left: 0;
    margin: 0;: #fff6f6;
}   padding: 14px;
    border-left: 6px solid #ff4c4c;
.low-stock li {om: 10px;
    background: #fff6f6;
    padding: 14px;;
    border-left: 6px solid #ff4c4c;
    margin-bottom: 10px;m 0.3s ease;
    font-weight: 500;
    color: #cc0000;
    border-radius: 6px;
    transition: transform 0.3s ease;
}   background: #ffeaea;
}
.low-stock li:hover {
    transform: translateX(5px);
    background: #ffeaea;
}   list-style: none;
    padding: 0;
/* Timeline styles */
.timeline-list {
    list-style: none;
    padding: 0;li {
    margin: 0;tom: 18px;
}   background: #f0f8ff;
    padding: 12px 16px;
.timeline-list li {10px;
    margin-bottom: 18px;x rgba(0,0,0,0.04);
    background: #f0f8ff;
    padding: 12px 16px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}   justify-content: space-between;
    font-size: 0.95rem;
.timeline-header { 5px;
    display: flex;;
    justify-content: space-between;
    font-size: 0.95rem;
    margin-bottom: 5px;
    color: #0077cc;
    font-weight: 600;
}   background: #e0e0e0;
    border-radius: 5px;
.timeline-bar {idden;
    height: 10px;
    background: #e0e0e0;
    border-radius: 5px;
    overflow: hidden;
}   background: linear-gradient(90deg, #0077cc, #00c6ff);
    border-radius: 5px;
.timeline-fill {width 0.6s ease-in-out;
    height: 100%;
    background: linear-gradient(90deg, #0077cc, #00c6ff);
    border-radius: 5px;
    transition: width 0.6s ease-in-out;
}
