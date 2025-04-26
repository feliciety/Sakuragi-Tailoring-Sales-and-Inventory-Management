<!DOCTYPE html>
<html>
<head>
    <title>Register | Sakuragi Tailoring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h3 class="text-center mb-4">Create Account</h3>
                <form action="../controller/authController.php" method="POST">
                    <input type="hidden" name="register" value="1">
                    <div class="mb-3">
                        <label>Full Name:</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Phone Number:</label>
                        <input type="text" name="phone_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Register</button>
                </form>
                <div class="text-center mt-3">
                <a >Already have an account? </a>    <a href="loginPage.php">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
