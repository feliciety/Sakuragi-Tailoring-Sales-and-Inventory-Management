<?php
  $current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sakuragi Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body class="bg-white">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3">
  <div class="container-fluid d-flex justify-content-between align-items-center w-100">
    
    
    <div class="d-flex align-items-center gap-3">
      <a class="navbar-brand mb-0 h1" href="#">Sakuragi Admin</a>
      
      
      <div class="flex space-x-4 text-sm font-medium text-gray-400">
  <a href="../admin/dashboard.php" class="<?= $current === 'dashboard.php' ? 'text-white fw-bold' : 'hover:text-white' ?>">Dashboard</a>
  <a href="../admin/inventory.php" class="<?= $current === 'inventory.php' ? 'text-white fw-bold' : 'hover:text-white' ?>">Inventory</a>
  <a href="../admin/order.php" class="<?= $current === 'order.php' ? 'text-white fw-bold' : 'hover:text-white' ?>">Orders</a>
  <a href="../admin/services.php" class="<?= $current === 'services.php' ? 'text-white fw-bold' : 'hover:text-white' ?>">Services</a>
  <a href="../admin/reports.php" class="<?= $current === 'reports.php' ? 'text-white fw-bold' : 'hover:text-white' ?>">Reports</a>
</div>
    </div>

    
    <div class="d-flex align-items-center gap-3">
      
      <div class="relative" style="width: 200px;">
        <input 
          type="text" 
          placeholder="Search inventory..." 
          class="w-full pl-9 pr-3 py-1 text-sm border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <div class="absolute left-2.5 top-2.5 text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1116.65 2a7.5 7.5 0 010 15z" />
          </svg>
        </div>
      </div>

      <!-- Logout Area -->
      <span class="navbar-text text-white small me-2">Welcome, <?= $_SESSION['user']['full_name']; ?></span>
      <a href="../../auth/logout.php" class="btn btn-sm btn-outline-light">Logout</a>
    </div>

  </div>
</nav>

<!-- Content Container -->
<div class="container-fluid mt-4">
  <div class="row">
    <!-- Dashboard content here -->
  </div>
</div>

</body>
</html>
