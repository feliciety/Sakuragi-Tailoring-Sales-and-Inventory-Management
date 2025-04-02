<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

<div style="justify-content:center; display:flex;">
    <h1>Register</h1> 
    <form action="../controllers/AuthController.php" method="post">
        <label for="Email">Email</label><br>
        <input type="email" name="email" required><br>
        <label for="Password">Password</label><br>
        <input type="password" name="password" required><br>
        <label for="Password">Re-type Password</label> <br>
        <input type="password" name="confirm_password" required><br>
        <button type="submit" name="action" value="register">Submit</button>
    </form>
</div>
</body>
</html>
