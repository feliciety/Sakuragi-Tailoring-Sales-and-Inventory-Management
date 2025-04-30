<?php
// /middleware/role_admin_only.php

require_once __DIR__ . '/../config/session_handler.php';
// Check if user is logged in first
if (!is_logged_in()) {
    header('Location: /auth/login.php');
    exit();
}

// Check if user is an Admin
if (get_user_role() !== ROLE_ADMIN) {
    // Redirect non-admin users to their correct dashboard
    switch (get_user_role()) {
        case ROLE_MANAGER:
        case ROLE_EMPLOYEE:
            header('Location: /dashboards/employee/dashboard.php');
            break;
        case ROLE_CUSTOMER:
            header('Location: /dashboards/customer/dashboard.php');
            break;
        default:
            header('Location: /auth/login.php');
    }
    exit();
}
?>
