<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php'; // Any logged-in user
require_once '../../includes/header.php';
require_once '../../includes/sidebar_employee.php';

// Protect: If customer somehow reaches employee dashboard
if (get_user_role() === ROLE_CUSTOMER) {
    header('Location: /dashboards/customer/dashboard.php');
    exit();
}
?>

<main class="main-content">
    <h1>Employee Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['full_name']; ?>!</p>
    <p>Here you can see your assigned orders and check inventory.</p>
</main>

<?php require_once '../../includes/footer.php'; ?>
