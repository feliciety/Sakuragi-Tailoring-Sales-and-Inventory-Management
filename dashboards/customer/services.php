<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php'; // Any logged-in user
require_once '../../includes/header.php';
require_once '../../includes/sidebar_customer.php';


if (get_user_role() !== ROLE_CUSTOMER) {
    header('Location: /dashboards/employee/dashboard.php');
    exit();
}
?>

<main class="main-content">
    <h1>Our Services</h1>
    <p>View available tailoring services offered by Sakuragi Tailoring Shop.</p>
</main>

<?php require_once '../../includes/footer.php'; ?>
