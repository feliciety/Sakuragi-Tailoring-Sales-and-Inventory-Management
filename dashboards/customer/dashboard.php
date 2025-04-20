<?php
include '../../includes/session_check.php';
include '../../includes/customer_header.php';
include '../../includes/customer_sidebar.php';
?>
<link rel="stylesheet" href="../../public/assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="dashboard-content py-4 px-3">
    <h2 class="fw-semibold mb-2">
        Welcome, <?= isset($_SESSION['user']['full_name']) ? htmlspecialchars($_SESSION['user']['full_name']) : 'Customer'; ?>
    </h2>
    <p class="text-muted">This is your customer dashboard.</p>

    <div class="row g-4 mt-3">
        <!-- Place Order -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-semibold mb-2">Place New Order</h5>
                <p>Create a custom tailoring request.</p>
                <a href="place_order.php" class="btn btn-outline-primary">Start Order</a>
            </div>
        </div>

        <!-- My Orders -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-semibold mb-2">My Orders</h5>
                <p>View all your orders.</p>
                <a href="my_orders.php" class="btn btn-outline-primary">View Orders</a>
            </div>
        </div>

        <!-- Services -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-semibold mb-2">Services</h5>
                <p>See the services we offer.</p>
                <a href="services.php" class="btn btn-outline-primary">View Services</a>
            </div>
        </div>

        <!-- About Us -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h5 class="fw-semibold mb-2">About Us</h5>
                <p>Learn more about our shop.</p>
                <a href="about_us.php" class="btn btn-outline-primary">Read More</a>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/customer_footer.php'; ?>
