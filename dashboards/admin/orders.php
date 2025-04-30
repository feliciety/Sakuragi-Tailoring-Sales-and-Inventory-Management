<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
?>

<main class="main-content">
    <h1>Manage Orders</h1>
    <p>Here you can view, update, and manage all customer orders.</p>
</main>

<?php require_once '../../includes/footer.php'; ?>
