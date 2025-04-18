<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'Active'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;

        if ($user['role'] === 'admin') {
            header("Location: ../dashboards/admin_dashboard.php");
        } else {
            header("Location: ../dashboards/customer_dashboard.php");
        }
        exit();
    } else {
        header("Location: ../public/index.php?error=invalid");
        exit();
    }
}
?>
