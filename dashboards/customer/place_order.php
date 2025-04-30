<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php'; // Any logged-in user
require_once '../../includes/header.php';
require_once '../../includes/sidebar_customer.php';


// Block admin/employee from accessing
if (get_user_role() !== ROLE_CUSTOMER) {
    header('Location: /dashboards/employee/dashboard.php');
    exit();
}
?>

<main class="main-content">
    <h1>Place New Order</h1>
    <p>Fill in your customization details and submit your order.</p>
</main>

<?php require_once '../../includes/footer.php'; ?>
