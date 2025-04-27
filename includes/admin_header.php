<?php
$current = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sakuragi Admin Dashboard</title>
  <link href="../../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body class="bg-white">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3">
  <div class="container-fluid d-flex justify-content-between align-items-center w-100">
    
    <div class="d-flex align-items-center gap-3">
      <a class="navbar-brand mb-0 h1" href="#">Sakuragi Admin</a>
      
      <ul class="nav">
        <li class="nav-item">
          <a href="../admin/dashboard.php" class="nav-link <?= $current === 'dashboard.php'
              ? 'active fw-bold text-white'
              : 'text-light' ?>">Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="../admin/inventory.php" class="nav-link <?= $current === 'inventory.php'
              ? 'active fw-bold text-white'
              : 'text-light' ?>">Inventory</a>
        </li>
        <li class="nav-item">
          <a href="../admin/order.php" class="nav-link <?= $current === 'order.php'
              ? 'active fw-bold text-white'
              : 'text-light' ?>">Orders</a>
        </li>
        <li class="nav-item">
          <a href="../admin/services.php" class="nav-link <?= $current === 'services.php'
              ? 'active fw-bold text-white'
              : 'text-light' ?>">Services</a>
        </li>
        <li class="nav-item">
          <a href="../admin/reports.php" class="nav-link <?= $current === 'reports.php'
              ? 'active fw-bold text-white'
              : 'text-light' ?>">Reports</a>
        </li>
      </ul>
    </div>
    
    <div class="d-flex align-items-center gap-3">
      
      <div class="position-relative" style="width: 200px;">
        <input 
          type="text" 
          placeholder="Search inventory..." 
          class="form-control form-control-sm ps-5">
        <div class="position-absolute top-50 translate-middle-y start-0 ps-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1116.65 2a7.5 7.5 0 010 15z" />
          </svg>
        </div>
      </div>

      <span class="navbar-text text-white small me-2">Welcome, <?= $_SESSION['user']['full_name'] ?></span>
      <a href="../../auth/logout.php" class="btn btn-sm btn-outline-light">Logout</a>
    </div>

  </div>
</nav>

<div class="container-fluid mt-4">
  <div class="row">
    <!-- Your content here -->
  </div>
</div>

</body>
</html>
