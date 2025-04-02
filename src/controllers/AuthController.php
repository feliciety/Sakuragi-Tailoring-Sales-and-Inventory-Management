<?php
// Assuming you have a basic database connection setup
require_once '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'login':
            login();
            break;
        case 'register':
            register();
            break;
        default:
            echo 'Invalid action';
    }
}

function login() {
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate credentials (you can add password hashing later)
        $query = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $GLOBALS['db']->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, login successful
            echo "Login successful!";
            // Redirect to dashboard or homepage
        } else {
            echo "Invalid username or password.";
        }
    }
}

function register() {
    if (isset($_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password === $confirm_password) {
            // Hash password before storing (consider using password_hash for security)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Check if the user already exists
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $GLOBALS['db']->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "User with this email already exists.";
            } else {
                // Insert new user
                $query = "INSERT INTO users (email, password) VALUES (?, ?)";
                $stmt = $GLOBALS['db']->prepare($query);
                $stmt->bind_param("ss", $email, $hashed_password);
                $stmt->execute();
                echo "Registration successful!";
            }
        } else {
            echo "Passwords do not match.";
        }
    }
}
?>
