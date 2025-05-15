<?php
require_once __DIR__ . '/../../../../config/session_handler.php';
require_once __DIR__ . '/../../../../config/constants.php';
require_once '../../../../middleware/auth_required.php';
require_once '../../../../config/db_connect.php';
// Get user position
$user_id = $_SESSION['user_id'];
try {
    $userSql = "
        SELECT e.position_id 
        FROM employees e
        WHERE e.user_id = ?
    ";
    $userStmt = $pdo->prepare($userSql);
    $userStmt->execute([$user_id]);
    $user = $userStmt->fetch();

    $positionSql = 'SELECT position_name FROM positions WHERE position_id = ?';
    $positionStmt = $pdo->prepare($positionSql);
    $positionStmt->execute([$user['position_id'] ?? 0]);
    $position = $positionStmt->fetch();
    $positionName = $position ? $position['position_name'] : '';

    // Restrict access to Senior Tailors only
    if ($positionName !== 'Senior Tailor') {
        header('Location: /dashboards/employee/dashboard.php');
        exit();
    }
} catch (PDOException $e) {
    // Handle error
    error_log('Error: ' . $e->getMessage());
    header('Location: /dashboards/employee/dashboard.php');
    exit();
}

require_once '../../../../includes/header.php';
require_once '../../../../includes/sidebar_senior_tailor.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items to Inspect - Senior Tailor</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .page-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        
        .filter-btn {
            border-radius: 0.25rem;
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            margin-right: 0.5rem;
        }
        
        .filter-btn.active {
            background-color: #0d1b2a;
            color: white;
            border-color: #0d1b2a;
        }
        
        .more-filters-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .table th {
            font-weight: 600;
            color: #495057;
            border-top: none;
            background-color: #f8f9fa;
            padding: 0.75rem 1rem;
        }
        
        .table td {
            vertical-align: middle;
            padding: 1rem;
        }
        
        .garment-type {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .garment-icon {
            width: 20px;
            height: 20px;
            background-color: #e9ecef;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        
        .submitted-time {
            display: flex;
            flex-direction: column;
        }
        
        .time-ago {
            color: #6c757d;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.25rem;
        }
        
        .priority-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            text-align: center;
            min-width: 70px;
        }
        
        .priority-high {
            background-color: #f8d7da;
            color: #dc3545;
        }
        
        .priority-medium {
            background-color: #fff3cd;
            color: #ffc107;
        }
        
        .priority-low {
            background-color: #d1e7dd;
            color: #198754;
        }
        
        .inspect-btn {
            background-color: #0d1b2a;
            color: white;
            border: none;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .inspect-btn:hover {
            background-color: #1b263b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title">Items to Inspect</h1>
        <p class="page-subtitle">Review and quality check items submitted for inspection</p>
        
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="btn-group" role="group" aria-label="Filter buttons">
                    <button type="button" class="btn btn-outline-secondary filter-btn active">All Items</button>
                    <button type="button" class="btn btn-outline-secondary filter-btn">High Priority</button>
                    <button type="button" class="btn btn-outline-secondary filter-btn">Medium Priority</button>
                    <button type="button" class="btn btn-outline-secondary filter-btn">Low Priority</button>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-outline-secondary more-filters-btn">
                    <i class="bi bi-funnel"></i>
                    More Filters
                </button>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">All Pending Inspections</h5>
                <small class="text-muted">5 items waiting for quality control</small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Garment Type</th>
                                <th>Tailor</th>
                                <th>Submitted</th>
                                <th>Priority</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>QC-5237</td>
                                <td>
                                    <div class="garment-type">
                                        <div class="garment-icon">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        Wool Suit Jacket
                                    </div>
                                </td>
                                <td>Marcus Wilson</td>
                                <td>
                                    <div class="submitted-time">
                                        May 16, 10:30 AM
                                        <div class="time-ago">
                                            <i class="bi bi-clock"></i>
                                            ~432 minutes ago
                                        </div>
                                    </div>
                                </td>
                                <td><span class="priority-badge priority-high">High</span></td>
                                <td>
                                    <button class="inspect-btn">
                                        Inspect
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>QC-5238</td>
                                <td>
                                    <div class="garment-type">
                                        <div class="garment-icon">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        Silk Blouse
                                    </div>
                                </td>
                                <td>Sarah Johnson</td>
                                <td>
                                    <div class="submitted-time">
                                        May 16, 9:45 AM
                                        <div class="time-ago">
                                            <i class="bi bi-clock"></i>
                                            ~467 minutes ago
                                        </div>
                                    </div>
                                </td>
                                <td><span class="priority-badge priority-medium">Medium</span></td>
                                <td>
                                    <button class="inspect-btn">
                                        Inspect
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>QC-5239</td>
                                <td>
                                    <div class="garment-type">
                                        <div class="garment-icon">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        Wedding Dress
                                    </div>
                                </td>
                                <td>Elena Rodriguez</td>
                                <td>
                                    <div class="submitted-time">
                                        May 16, 9:15 AM
                                        <div class="time-ago">
                                            <i class="bi bi-clock"></i>
                                            ~497 minutes ago
                                        </div>
                                    </div>
                                </td>
                                <td><span class="priority-badge priority-high">High</span></td>
                                <td>
                                    <button class="inspect-btn">
                                        Inspect
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>QC-5240</td>
                                <td>
                                    <div class="garment-type">
                                        <div class="garment-icon">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        Formal Trousers
                                    </div>
                                </td>
                                <td>David Lee</td>
                                <td>
                                    <div class="submitted-time">
                                        May 16, 8:50 AM
                                        <div class="time-ago">
                                            <i class="bi bi-clock"></i>
                                            ~512 minutes ago
                                        </div>
                                    </div>
                                </td>
                                <td><span class="priority-badge priority-low">Low</span></td>
                                <td>
                                    <button class="inspect-btn">
                                        Inspect
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>QC-5241</td>
                                <td>
                                    <div class="garment-type">
                                        <div class="garment-icon">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        Evening Gown
                                    </div>
                                </td>
                                <td>Maria Chen</td>
                                <td>
                                    <div class="submitted-time">
                                        May 15, 4:20 PM
                                        <div class="time-ago">
                                            <i class="bi bi-clock"></i>
                                            ~17 hours ago
                                        </div>
                                    </div>
                                </td>
                                <td><span class="priority-badge priority-medium">Medium</span></td>
                                <td>
                                    <button class="inspect-btn">
                                        Inspect
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>