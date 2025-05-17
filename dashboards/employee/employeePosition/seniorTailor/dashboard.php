
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
    <title>QC Dashboard - Senior Tailor</title>
    <link rel="stylesheet" href="/public/assets/css/enhanced-sidebar.css">
    <script src="/public/assets/js/enhanced-sidebar.js"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #f5f7fa;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        h1 {
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
        
        .status-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .card {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
        }
        
        .card-title {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .card-subtitle {
            color: #666;
            font-size: 14px;
            margin: 0 0 15px 0;
        }
        
        .metric {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .metric-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .icon-passed {
            background-color: #dcfce7;
            color: #16a34a;
        }
        
        .icon-failed {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .icon-pending {
            background-color: #dbeafe;
            color: #2563eb;
        }
        
        .metric-value {
            font-size: 24px;
            font-weight: 600;
        }
        
        .metric-label {
            font-size: 14px;
            color: #666;
        }
        
        .next-item {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 20px 0;
        }
        
        .item-details {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .item-image {
            width: 100px;
            height: 100px;
            background-color: #f0f0f0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }
        
        .item-info {
            flex: 1;
        }
        
        .item-id {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 5px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .order-number {
            font-size: 12px;
            color: #2563eb;
            font-weight: normal;
        }
        
        .item-name {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 10px 0;
        }
        
        .item-meta {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .priority-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background-color: #fff7ed;
            color: #c2410c;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            margin-top: 5px;
        }
        
        .action-button {
            background-color: #111827;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .action-button:hover {
            background-color: #1f2937;
        }
        
        .bottom-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .performance-card, .activity-card {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
        }
        
        .performance-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .performance-subtitle {
            color: #666;
            font-size: 14px;
            margin: 0 0 20px 0;
        }
        
        .progress-item {
            margin-bottom: 15px;
        }
        
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .progress-bar {
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-value {
            height: 100%;
            border-radius: 4px;
        }
        
        .progress-inspection {
            background-color: #3b82f6;
        }
        
        .progress-pass {
            background-color: #10b981;
        }
        
        .progress-accuracy {
            background-color: #111827;
        }
        
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }
        
        .activity-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .activity-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .activity-details {
            display: flex;
            flex-direction: column;
        }
        
        .activity-id {
            font-weight: 500;
            font-size: 14px;
        }
        
        .activity-name {
            color: #666;
            font-size: 13px;
        }
        
        .activity-time {
            font-size: 13px;
            color: #666;
        }
        
        @media (max-width: 768px) {
            .item-details {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .item-image {
                width: 100%;
                height: 150px;
            }
        }    </style>
</head>
<body>
    <div class="main-content">
        <div class="container">
        <div class="header">
            <div>
                <h1>Welcome, Jennifer Chen</h1>
                <div class="date">Friday, May 16, 2025</div>
            </div>
            <div class="user-avatar">
                <!-- User avatar could go here -->
            </div>
        </div>
        
        <div class="status-cards">
            <div class="card">
                <div class="card-title">Items Passed Today</div>
                <div class="card-subtitle">Quality standards met</div>
                <div class="metric">
                    <div class="metric-icon icon-passed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div>
                        <div class="metric-value">28 Items</div>
                        <div class="metric-label">Approved</div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-title">Items Failed</div>
                <div class="card-subtitle">Requiring attention</div>
                <div class="metric">
                    <div class="metric-icon icon-failed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </div>
                    <div>
                        <div class="metric-value">7 Items</div>
                        <div class="metric-label">Not approved</div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-title">Pending Inspections</div>
                <div class="card-subtitle">Items in queue</div>
                <div class="metric">
                    <div class="metric-icon icon-pending">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div>
                        <div class="metric-value">15 Items</div>
                        <div class="metric-label">Waiting for review</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="next-item">
            <div class="section-title">Next Item to Inspect</div>
            <div class="item-details">
                <div class="item-image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                </div>
                <div class="item-info">
                    <div class="item-id">
                        QC-5237
                        <span class="order-number">Order #ORD-7982</span>
                    </div>
                    <div class="item-name">Wool Suit Jacket</div>
                    <div class="item-meta">Crafted by: Marcus Wilson</div>
                    <div class="priority-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                        High priority item
                    </div>
                </div>
                <button class="action-button">
                    Start Inspection
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="bottom-section">
            <div class="performance-card">
                <div class="performance-title">Today's Performance</div>
                <div class="performance-subtitle">Quality check efficiency</div>
                
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Inspection Rate</span>
                        <span>75%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-value progress-inspection" style="width: 75%"></div>
                    </div>
                </div>
                
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Pass Rate</span>
                        <span>80%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-value progress-pass" style="width: 80%"></div>
                    </div>
                </div>
                
                <div class="progress-item">
                    <div class="progress-label">
                        <span>Accuracy</span>
                        <span>95%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-value progress-accuracy" style="width: 95%"></div>
                    </div>
                </div>
            </div>
            
            <div class="activity-card">
                <div class="performance-title">Recent Activity</div>
                <div class="performance-subtitle">Latest inspection results</div>
                
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-icon icon-passed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div class="activity-details">
                                <div class="activity-id">QC-5236</div>
                                <div class="activity-name">Dress Shirt</div>
                            </div>
                        </div>
                        <div class="activity-time">10:02 AM</div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-icon icon-failed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                            </div>
                            <div class="activity-details">
                                <div class="activity-id">QC-5235</div>
                                <div class="activity-name">Silk Blouse</div>
                            </div>
                        </div>
                        <div class="activity-time">10:15 AM</div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-icon icon-passed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div class="activity-details">
                                <div class="activity-id">QC-5234</div>
                                <div class="activity-name">Formal Trousers</div>
                            </div>
                        </div>
                        <div class="activity-time">9:58 AM</div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-icon icon-pending">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div class="activity-details">
                                <div class="activity-id">QC-5233</div>
                                <div class="activity-name">Cashmere Sweater</div>
                            </div>
                        </div>
                        <div class="activity-time">9:30 AM</div>
                    </div>
                </div>            </div>
        </div>
    </div>
    </div>
</body>
</html>