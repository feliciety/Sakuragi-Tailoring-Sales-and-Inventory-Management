<?php
session_start();
include '../../database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // LOGIN
    if (isset($_POST['login'])) {
        $email = $_POST['email']; 
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND status = 'Active'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role_id'] = $user['role_id'];
                $_SESSION['branch_id'] = $user['branch_id'];

                header("Location: ../views/dashboard/costumerDashboard.php");
                exit;
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "User not found or inactive.";
        }

    // REGISTER
    } elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];

        if ($password !== $confirm) {
            echo "Passwords do not match.";
            exit;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $full_name = "New User"; 
        $phone_number = "0000000000"; 
        $role_id = 2; 
        $branch_id = null; 

        $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {
            echo "Email already registered.";
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO users (branch_id, role_id, full_name, email, password, phone_number, status) 
                                VALUES (?, ?, ?, ?, ?, ?, 'Active')");
        $stmt->bind_param("iissss", $branch_id, $role_id, $full_name, $email, $hashed, $phone_number);

        if ($stmt->execute()) {
            header("Location: ../views/login.php");
            exit;
        } else {
            echo "Registration failed.";
        }
    }
}
?>
