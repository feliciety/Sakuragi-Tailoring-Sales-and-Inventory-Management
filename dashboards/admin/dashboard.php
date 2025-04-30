<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php'; // Any logged-in user
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
?>

<main class="main-content">
    <h2>Welcome, <?php echo $_SESSION['full_name']; ?> (Admin)!</h2>
    <p>This is your Admin Dashboard.</p>
</main>

<?php require_once '../../includes/footer.php'; ?>
