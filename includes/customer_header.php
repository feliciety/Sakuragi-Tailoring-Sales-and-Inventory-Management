<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer | Sakuragi Tailoring</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href= "../../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../public/assets/css/customer.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm px-4">
    <a class="navbar-brand fw-bold text-primary" href="../customer/dashboard.php">
        <i class="bi bi-scissors"></i> Sakuragi Tailoring
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle fw-semibold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i>
                    <?= $_SESSION['user']['full_name'] ?? 'Customer' ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="../../auth/logout.php"><i class="bi bi-box-arrow-right me-1"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<script src="../../public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid">
    <div class="row">
