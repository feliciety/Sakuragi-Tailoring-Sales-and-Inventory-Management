<?php
require_once '../../config/session_handler.php';
require_once '../../config/constants.php';
require_once '../../middleware/auth_required.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_customer.php';

if (get_user_role() !== ROLE_CUSTOMER) {
    header('Location: /dashboards/employee/dashboard.php');
    exit();
}
?>

<main class="main-content">
    <div class="account-page-container">
        <!-- Profile Box -->
        <div class="profile-box">
            <img src="/assets/images/user1.jpg" alt="Avatar" class="avatar">
            <div class="user-details">
                <h2><?php echo $_SESSION['full_name']; ?></h2>
                <p class="user-role"><?php echo ucfirst($_SESSION['role']); ?></p>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="order-stats">
            <div class="stat-card">
                <span class="label">Total Orders</span>
                <h3>12</h3>
            </div>
            <div class="stat-card">
                <span class="label">Pending</span>
                <h3>3</h3>
            </div>
            <div class="stat-card">
                <span class="label">Completed</span>
                <h3>8</h3>
            </div>
            <div class="stat-card">
                <span class="label">Cancelled</span>
                <h3>1</h3>
            </div>
        </div>

        <!-- Manage Options --> 
        <div class="account-actions">
            <h4>Manage Account</h4>
            <div class="action-links">
                <a href="#">📦 My Orders</a>
                <a href="#">🏠 Address Book</a>
                <a href="#">🔒 Change Password</a>
                <a href="#">⚙️ Settings</a>
                <a href="/auth/logout.php">🚪 Logout</a>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>



<style>
.account-page-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.profile-box {
    display: flex;
    align-items: center;
    gap: 20px;
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
}

.profile-box .avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #0B5CF9;
}

.user-details h2 {
    margin: 0;
    color: #0B5CF9;
    font-size: 1.5rem;
    font-weight: 700;
}

.user-details .user-role {
    margin-top: 4px;
    color: #888;
    font-size: 0.95rem;
}

.order-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 20px;
}

.stat-card {
    background-color: #f2f6fd;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
}

.stat-card .label {
    font-size: 0.9rem;
    color: #333;
}

.stat-card h3 {
    margin-top: 10px;
    font-size: 1.6rem;
    color: #0B5CF9;
    font-weight: 700;
}

.account-actions {
    background-color: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
}

.account-actions h4 {
    font-size: 1.2rem;
    margin-bottom: 20px;
    color: #0B5CF9;
}

.action-links {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.action-links a {
    display: inline-block;
    background-color: #eaf1ff;
    color: #0B5CF9;
    padding: 12px 18px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.action-links a:hover {
    background-color: #d6e6ff;
}
.account-page-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.profile-box {
    display: flex;
    align-items: center;
    gap: 20px;
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
}

.profile-box .avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #0B5CF9;
}

.user-details h2 {
    margin: 0;
    color: #0B5CF9;
    font-size: 1.5rem;
    font-weight: 700;
}

.user-details .user-role {
    margin-top: 4px;
    color: #888;
    font-size: 0.95rem;
}

.order-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 20px;
}

.stat-card {
    background-color: #f2f6fd;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
}

.stat-card .label {
    font-size: 0.9rem;
    color: #333;
}

.stat-card h3 {
    margin-top: 10px;
    font-size: 1.6rem;
    color: #0B5CF9;
    font-weight: 700;
}

.account-actions {
    background-color: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
}

.account-actions h4 {
    font-size: 1.2rem;
    margin-bottom: 20px;
    color: #0B5CF9;
}

.action-links {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.action-links a {
    display: inline-block;
    background-color: #eaf1ff;
    color: #0B5CF9;
    padding: 12px 18px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.action-links a:hover {
    background-color: #d6e6ff;
}

</style>