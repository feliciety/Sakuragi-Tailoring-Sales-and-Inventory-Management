<?php
// /includes/functions.php

// Sanitize input (prevent XSS)
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Hash password
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Flash message (Optional: use for success/error messages)
function set_flash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function get_flash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}
?>
