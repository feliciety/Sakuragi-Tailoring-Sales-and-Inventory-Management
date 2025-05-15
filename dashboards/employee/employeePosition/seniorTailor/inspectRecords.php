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
    <title>Inspection History - Senior Tailor</title>
    <!-- Enhanced sidebar functionality -->
    <link rel="stylesheet" href="/public/assets/css/enhanced-sidebar.css">
    <script src="/public/assets/js/enhanced-sidebar.js"></script>
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
        
        .search-bar {
            position: relative;
        }
        
        .search-bar i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .search-input {
            padding-left: 35px;
        }
        
        .filter-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .filter-btn {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }
        
        .filter-btn.active {
            background-color: #0d1b2a;
            color: white;
            border-color: #0d1b2a;
        }
        
        .date-picker-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .view-toggle-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0d1b2a;
            color: white;
            border: none;
            border-radius: 0.25rem;
        }
        
        .export-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-header {
            margin: 1.5rem 0 1rem;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }
        
        .section-subtitle {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .inspection-card {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            height: 100%;
            position: relative;
        }
        
        .card-image {
            height: 200px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card-image-icon {
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
        }
        
        .status-badge {
            position: absolute;
            bottom: 10px;
            left: 10px;
            padding: 0.35rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .status-passed {
            background-color: #d1e7dd;
            color: #198754;
        }
        
        .status-failed {
            background-color: #f8d7da;
            color: #dc3545;
        }
        
        .status-rework {
            background-color: #fff3cd;
            color: #ffc107;
        }
        
        .card-content {
            padding: 1rem;
            background-color: white;
        }
        
        .card-id {
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-garment {
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .card-date {
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        .view-icon {
            color: #6c757d;
            cursor: pointer;
        }
        
        .view-icon:hover {
            color: #0d1b2a;
        }    </style>
</head>
<body>
    <div class="main-content">
        <div class="container">
        <h1 class="page-title">Inspection History</h1>
        <p class="page-subtitle">View your complete quality inspection history</p>
        
        <div class="row mb-4">
            <div class="col-md-5">
                <div class="search-bar">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control search-input" placeholder="Search by ID, order number, or garment type...">
                </div>
            </div>
            <div class="col-md-7">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <div class="filter-section me-2">
                        <button type="button" class="btn btn-outline-secondary filter-btn active">All Time</button>
                        <button type="button" class="btn btn-outline-secondary filter-btn">Today</button>
                        <button type="button" class="btn btn-outline-secondary filter-btn">This Week</button>
                        <button type="button" class="btn btn-outline-secondary date-picker-btn">
                            <i class="bi bi-calendar"></i>
                            Pick a date
                        </button>
                    </div>
                    
                    <div class="btn-group me-2" role="group" aria-label="View toggle">
                        <button type="button" class="view-toggle-btn">
                            <i class="bi bi-grid-fill"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>
                    
                    <button class="btn btn-outline-secondary export-btn">
                        <i class="bi bi-download"></i>
                        Export History
                    </button>
                </div>
            </div>
        </div>
        
        <div class="section-header">
            <h2 class="section-title">Inspection Records</h2>
            <p class="section-subtitle">8 inspection records found</p>
        </div>
        
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="inspection-card">
                    <div class="card-image">
                        <div class="card-image-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                    <div class="status-badge status-passed">
                        <i class="bi bi-check-circle-fill"></i>
                        Passed
                    </div>
                    <div class="card-content">
                        <div class="card-id">
                            <span>QC-5236</span>
                            <i class="bi bi-eye view-icon"></i>
                        </div>
                        <div class="card-garment">Dress Shirt</div>
                        <div class="card-date">May 16, 2025, 10:42 AM</div>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="inspection-card">
                    <div class="card-image">
                        <div class="card-image-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                    <div class="status-badge status-failed">
                        <i class="bi bi-x-circle-fill"></i>
                        Failed
                    </div>
                    <div class="card-content">
                        <div class="card-id">
                            <span>QC-5235</span>
                            <i class="bi bi-eye view-icon"></i>
                        </div>
                        <div class="card-garment">Silk Blouse</div>
                        <div class="card-date">May 16, 2025, 10:15 AM</div>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="inspection-card">
                    <div class="card-image">
                        <div class="card-image-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                    <div class="status-badge status-passed">
                        <i class="bi bi-check-circle-fill"></i>
                        Passed
                    </div>
                    <div class="card-content">
                        <div class="card-id">
                            <span>QC-5234</span>
                            <i class="bi bi-eye view-icon"></i>
                        </div>
                        <div class="card-garment">Formal Trousers</div>
                        <div class="card-date">May 16, 2025, 9:58 AM</div>
                    </div>
                </div>
            </div>
            
            <!-- Card 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="inspection-card">
                    <div class="card-image">
                        <div class="card-image-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                    <div class="status-badge status-rework">
                        <i class="bi bi-arrow-repeat"></i>
                        Rework
                    </div>
                    <div class="card-content">
                        <div class="card-id">
                            <span>QC-5233</span>
                            <i class="bi bi-eye view-icon"></i>
                        </div>
                        <div class="card-garment">Evening Gown</div>
                        <div class="card-date">May 16, 2025, 9:30 AM</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>