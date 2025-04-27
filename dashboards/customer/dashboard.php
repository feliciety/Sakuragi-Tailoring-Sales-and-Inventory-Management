<?php
include '../../includes/session_check.php';
include '../../includes/customer_header.php';
include '../../includes/customer_sidebar.php';
?>
<link rel="stylesheet" href="../../public/assets/css/style.css">
<link rel="stylesheet" href="../../public/assets/css/customer_dashboard.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- 🟢 Fixed Dashboard Content Layout -->
<div class="dashboard-content py-5 d-flex justify-content-center">
    <div class="content-wrapper">
        <!-- 👋 Welcome Section -->
        <div class="text-center mb-5">
            <h2 class="fw-bold">Welcome, <?= isset($_SESSION['user']['full_name'])
                ? htmlspecialchars($_SESSION['user']['full_name'])
                : 'Customer' ?> 👋</h2>
            <p class="text-muted">Manage your orders, explore our services, and stay updated.</p>
        </div>

        <!-- 📦 Quick Actions -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card dashboard-card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-plus-square dashboard-icon"></i>
                        <h5 class="fw-semibold mt-3">Place New Order</h5>
                        <p class="text-muted small">Create a custom tailoring request.</p>
                        <a href="place_order.php" class="btn btn-primary btn-sm rounded-pill mt-2">Start Order</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-card-checklist dashboard-icon"></i>
                        <h5 class="fw-semibold mt-3">My Orders</h5>
                        <p class="text-muted small">View and track your orders.</p>
                        <a href="my_orders.php" class="btn btn-primary btn-sm rounded-pill mt-2">View Orders</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-gear dashboard-icon"></i>
                        <h5 class="fw-semibold mt-3">Services</h5>
                        <p class="text-muted small">Check out what we offer.</p>
                        <a href="services.php" class="btn btn-primary btn-sm rounded-pill mt-2">View Services</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-info-circle dashboard-icon"></i>
                        <h5 class="fw-semibold mt-3">About Us</h5>
                        <p class="text-muted small">Learn more about our shop.</p>
                        <a href="about_us.php" class="btn btn-primary btn-sm rounded-pill mt-2">Read More</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 📈 Order Status Summary -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="summary-card">
                    <h6 class="text-muted">Pending Orders</h6>
                    <h2 class="text-primary">3</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <h6 class="text-muted">In Progress</h6>
                    <h2 class="text-warning">2</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <h6 class="text-muted">Completed Orders</h6>
                    <h2 class="text-success">8</h2>
                </div>
            </div>
        </div>

        <!-- 🕒 Recent Activity -->
        <div class="recent-activity-card p-4 rounded-4 shadow-sm bg-white">
            <h5 class="fw-semibold mb-3"><i class="bi bi-clock-history me-2"></i>Recent Activity</h5>
            <ul class="list-unstyled">
                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Order #1023 completed successfully.</li>
                <li class="mb-2"><i class="bi bi-hourglass-split text-warning me-2"></i> Order #1045 is in progress.</li>
                <li class="mb-2"><i class="bi bi-file-earmark-plus text-primary me-2"></i> New order placed on April 24, 2025.</li>
            </ul>
        </div>
    </div>
</div>

<?php include '../../includes/customer_footer.php'; ?>
