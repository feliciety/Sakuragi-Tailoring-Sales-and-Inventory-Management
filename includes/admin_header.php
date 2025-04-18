<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sakuragi Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sakuragi Admin</a>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">Welcome, <?= $_SESSION['user']['full_name']; ?></span>
            <a href="../auth/logout.php" class="btn btn-sm btn-outline-light">Logout</a>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
