<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php'; // Any logged-in user
require_once '../../includes/header.php';
require_once '../../includes/sidebar_customer.php';

// Protect: If employee/admin accidentally opens customer dashboard
if (get_user_role() === ROLE_ADMIN || get_user_role() === ROLE_MANAGER || get_user_role() === ROLE_EMPLOYEE) {
    header('Location: /dashboards/employee/dashboard.php');
    exit();
}
?>

<main class="main-content">
    <div class="dashboard-header">
        <h1>Welcome, <?php echo $_SESSION['full_name']; ?>!</h1>
        <p class="sub-text">This is your customer dashboard. Place new orders, view order history, and track order status here.</p>
    </div>

    <div class="dashboard-cards">
        <div class="card">
            <i class="fas fa-tshirt icon"></i>
            <h3>New Order</h3>
            <p>Start a new tailoring request</p>
            <a href="/dashboards/customer/place_order.php" class="card-btn">Order Now</a>
        </div>
        <div class="card">
            <i class="fas fa-history icon"></i>
            <h3>My Orders</h3>
            <p>View past and ongoing orders</p>
            <a href="/dashboards/customer/my_orders.php" class="card-btn">View Orders</a>
        </div>
        <div class="card">
            <i class="fas fa-info-circle icon"></i>
            <h3>Services</h3>
            <p>Check available tailoring services</p>
            <a href="/dashboards/customer/services.php" class="card-btn">View Services</a>
        </div>
    </div>
</main>


<?php require_once '../../includes/footer.php'; ?>

<style>.dashboard-header {
    margin-bottom: 2rem;
    text-align: center;
}

.dashboard-header h1 {
    font-size: 2rem;
    color: #2c3e50;
}

.dashboard-header .sub-text {
    font-size: 1rem;
    color: #7f8c8d;
    margin-top: 8px;
}

.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

.card {
    background: #ffffff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
}

.card .icon {
    font-size: 2.5rem;
    color: #3498db;
    margin-bottom: 12px;
}

.card h3 {
    font-size: 1.25rem;
    margin-bottom: 10px;
    color: #2c3e50;
}

.card p {
    color: #7f8c8d;
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.card-btn {
    display: inline-block;
    background-color: #3498db;
    color: #fff;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
}

.card-btn:hover {
    background-color: #2980b9;
}
</style>