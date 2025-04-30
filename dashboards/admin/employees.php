<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
?>

<main class="main-content">
    <h1>Manage Employees</h1>
    <p>View, add, update, or remove employees here.</p>
</main>

<?php require_once '../../includes/footer.php'; ?>
