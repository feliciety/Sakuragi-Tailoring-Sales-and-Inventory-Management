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
    <h1>Customer Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['full_name']; ?>!</p>
    <p>Place new orders, view your order history, and track order progress here!</p>
</main>

<?php require_once '../../includes/footer.php'; ?>
