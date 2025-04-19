<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: ../dashboards/" . $_SESSION['user']['role'] . "/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Sakuragi Tailoring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h3 class="text-center mb-4">Sakuragi Login</h3>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">Invalid credentials.</div>
                <?php endif; ?>
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Registration successful. Please login.</div>
                <?php endif; ?>
                <form action="../controller/authController.php" method="POST">
                    <div class="mb-3">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                </form>
                <div class="text-center mt-3">
                    <a href="register.php">Don’t have an account? Register</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
