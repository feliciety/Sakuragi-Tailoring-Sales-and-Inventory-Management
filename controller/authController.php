<?php
session_start();
require_once '../config/db.php';

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'Active'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;

        if ($user['role'] === 'admin') {
            header("Location: ../dashboards/admin/admin_dashboard.php");
        } else {
            header("Location: ../dashboards/customer/customer_dashboard.php");
        }
        exit();
    } else {
        header("Location: ../public/loginPage.php?error=invalid");
        exit();
    }
}

// Handle Registration
if (isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $checkStmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $checkStmt->execute([$email]);

    if ($checkStmt->rowCount() > 0) {
        header("Location: ../public/register.php?error=exists");
        exit();
    }

    // Register new customer
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, phone_number, role) VALUES (?, ?, ?, ?, 'customer')");
    $stmt->execute([$full_name, $email, $password, $phone]);

    header("Location: ../public/loginPage.php?success=registered");
    exit();
}
?>
