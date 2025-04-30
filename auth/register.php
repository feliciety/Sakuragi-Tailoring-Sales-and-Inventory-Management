<?php
require_once '../config/db_connect.php';
require_once '../config/session_handler.php';
require_once '../config/constants.php';
require_once '../includes/functions.php';

redirect_if_logged_in();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize_input($_POST['full_name']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone_number = sanitize_input($_POST['phone_number']);
    $role = ROLE_CUSTOMER;

    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        set_flash('error', 'All fields are required.');
        header('Location: register.php');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        set_flash('error', 'Invalid email format.');
        header('Location: register.php');
        exit();
    }

    if ($password !== $confirm_password) {
        set_flash('error', 'Passwords do not match.');
        header('Location: register.php');
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        set_flash('error', 'Email is already registered.');
        header('Location: register.php');
        exit();
    }

    $hashed_password = hash_password($password);
    $insert_stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, phone_number, role, status) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_stmt->execute([$full_name, $email, $hashed_password, $phone_number, $role, STATUS_ACTIVE]);

    set_flash('success', 'Registration successful! Please log in.');
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sakuragi Tailoring Shop - Register</title>
    <link rel="stylesheet" href="../public/assets/css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="par ">
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
        </div>

<div class="login-container">


    <!-- Left side - Illustration -->
    <div class="illustration"><a href="../index.php" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a></div>
  
<div class>


</div>

    <div class="register-form">

  
 

    <h2>Create Account</h2>
    <p>Join Sakuragi Tailoring Shop. It’s quick and easy!</p>

    <?php if ($msg = get_flash('error')): ?>
        <div class="error-msg"><?= $msg ?></div>
    <?php endif; ?>
    <?php if ($msg = get_flash('success')): ?>
        <div class="success-msg"><?= $msg ?></div>
    <?php endif; ?>

    <!-- START of scrollable area -->
    <div class="form-scrollable">
        <form method="POST" action="">
            <label for="full_name">Full Name</label>
            <input type="text" name="full_name" id="full_name" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit">Register</button>
        </form>
    </div>
    <!-- END of scrollable area -->

    <a href="login.php">Already have an account? Sign In here.</a>
</div>

</div>

</body>
</html>
