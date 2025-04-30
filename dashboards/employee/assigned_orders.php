<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php'; // Any logged-in user
require_once '../../includes/header.php';
require_once '../../includes/sidebar_employee.php';
// Block customers
if (get_user_role() === ROLE_CUSTOMER) {
    header('Location: /dashboards/customer/dashboard.php');
    exit();
}
?>

<main class="main-content">
    <h1>Assigned Orders</h1>
    <p>Here you can view orders assigned to you by the admin.</p>
</main>

<?php require_once '../../includes/footer.php'; ?>
