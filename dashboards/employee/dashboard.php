<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php'; // Any logged-in user
require_once '../../config/db_connect.php'; // Add database connection

// Protect: If customer somehow reaches employee dashboard
if (get_user_role() === ROLE_CUSTOMER) {
    header('Location: /dashboards/customer/dashboard.php');
    exit();
}

// Check user position for potential redirection to specialized dashboard
$user_id = $_SESSION['user_id'];
try {
    $positionSql = "
        SELECT p.position_name 
        FROM employees e
        JOIN positions p ON e.position_id = p.position_id
        WHERE e.user_id = ?
    ";
    $positionStmt = $pdo->prepare($positionSql);
    $positionStmt->execute([$user_id]);
    $positionData = $positionStmt->fetch();
    $positionName = $positionData ? $positionData['position_name'] : '';

    // Redirect to specific dashboard based on position
    if ($positionName === 'Senior Tailor') {
        header('Location: /dashboards/employee/employeePosition/seniorTailor/dashboard.php');
        exit();
    }
} catch (PDOException $e) {
    // Continue with regular employee dashboard if there's an error
    error_log('Error fetching position: ' . $e->getMessage());
}

require_once '../../includes/header.php';
require_once '../../includes/sidebar_employee.php';

// Get currently logged in user's ID
$user_id = $_SESSION['user_id'];
$full_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Employee';
$name_parts = explode(' ', $full_name);
$first_name = isset($name_parts[0]) ? $name_parts[0] : 'Employee';

// Get date information
$today = new DateTime();
$greeting = '';
$hour = (int) $today->format('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = 'Good morning';
} elseif ($hour >= 12 && $hour < 18) {
    $greeting = 'Good afternoon';
} else {
    $greeting = 'Good evening';
}
$formatted_date = $today->format('l, F j, Y');

// Get assigned orders
try {
    // Count orders by status
    $statusSql = "
        SELECT o.status, COUNT(*) as count
        FROM order_workflow ow
        JOIN orders o ON ow.order_id = o.order_id
        WHERE ow.assigned_employee = ?
        GROUP BY o.status
    ";
    $statusStmt = $pdo->prepare($statusSql);
    $statusStmt->execute([$user_id]);
    $orderStatusCounts = $statusStmt->fetchAll();

    // Count tasks completed this week
    $weekStartDate = date('Y-m-d', strtotime('monday this week'));
    $completedTasksSql = "
        SELECT COUNT(*) AS completed_count
        FROM order_workflow ow
        JOIN orders o ON ow.order_id = o.order_id
        WHERE ow.assigned_employee = ? AND o.status = 'Completed' 
        AND o.completion_date >= ?
    ";
    $completedTasksStmt = $pdo->prepare($completedTasksSql);
    $completedTasksStmt->execute([$user_id, $weekStartDate]);
    $completedThisWeek = $completedTasksStmt->fetch()['completed_count'] ?? 0;
} catch (PDOException $e) {
    // Just log the error, don't stop page from loading
    error_log('Dashboard error: ' . $e->getMessage());
    $orderStatusCounts = [];
    $completedThisWeek = 0;
}

// Calculate pending tasks
$pendingTasks = 0;
foreach ($orderStatusCounts as $statusData) {
    if ($statusData['status'] === 'Pending') {
        $pendingTasks = $statusData['count'];
        break;
    }
}
?>

<main class="main-content">
    <div class="container">
        <div class="header">
            <h1><?= $greeting ?>, <?= htmlspecialchars($first_name) ?></h1>
            <div class="date"><?= htmlspecialchars($formatted_date) ?></div>
        </div>
        
        <div class="cards-container">
            <div class="card">
                <div class="card-title">Tasks for Today</div>
                <div class="card-subtitle">Your pending work</div>
                <div class="card-content">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <div class="metric"><?= $pendingTasks ?> Tasks</div>
                        <div class="metric-label">Pending</div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-title">Completed this Week</div>
                <div class="card-subtitle">Your productivity</div>
                <div class="card-content">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div>
                        <div class="metric"><?= $completedThisWeek ?> Garments</div>
                        <div class="metric-label">Done</div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-title">Assigned Area</div>
                <div class="card-subtitle">Your specialization</div>
                <div class="card-content">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="metric">Section: Tailoring</div>
                        <div class="metric-label">Specialist</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="buttons">
            <a href="my_tasks.php" class="btn-primary">
                Start First Task
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
            <a href="my_tasks.php" class="btn-secondary">View My Tasks</a>
        </div>
    </div>
</main>

<style>
/* Exactly matching the provided design */
.main-content {
    background-color: #fff;
    min-height: calc(100vh - 60px);
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.header {
    margin-bottom: 30px;
}

.header h1 {
    font-size: 28px;
    font-weight: 600;
    margin: 0;
    color: #333;
}

.date {
    color: #666;
    font-size: 16px;
    margin-top: 5px;
}

.cards-container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.card {
    flex: 1;
    min-width: 300px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    background-color: #fff;
    box-shadow: none;
    transition: box-shadow 0.2s ease;
}

.card:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
}

.card-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 5px 0;
    color: #333;
}

.card-subtitle {
    font-size: 14px;
    color: #666;
    margin: 0 0 20px 0;
}

.card-content {
    display: flex;
    align-items: center;
    gap: 15px;
}

.icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.metric {
    font-size: 24px;
    font-weight: 600;
    color: #333;
}

.metric-label {
    font-size: 14px;
    color: #666;
}

.buttons {
    margin-top: 30px;
    display: flex;
    gap: 15px;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #111827;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
}

.btn-secondary {
    background-color: white;
    color: #333;
    border: 1px solid #e0e0e0;
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
}

.btn-primary:hover {
    background-color: #1f2937;
}

.btn-secondary:hover {
    background-color: #f5f5f5;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .cards-container {
        flex-direction: column;
    }
    
    .card {
        width: 100%;
        min-width: auto;
    }
}
</style>

<?php require_once '../../includes/footer.php'; ?>
