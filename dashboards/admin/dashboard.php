<?php   
    include '../../includes/session_check.php'; 
    include '../../includes/admin_header.php'; 
    include '../../includes/admin_sidebar.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="../../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">
<main class="container py-4">

  <!-- Heading -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 fw-bold">Dashboard</h1>
      <p class="text-muted">Overview of your tailoring shop inventory and orders</p>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row g-4 mb-5">
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Total Materials</h5>
          <h2 class="card-text fw-bold mt-3">1,284 <small class="text-muted">(Example)</small></h2>
          <p class="text-success small mt-2">+12 added this week (Example)</p>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Low Stock Items</h5>
          <h2 class="card-text fw-bold mt-3">24 <small class="text-muted">(Example)</small></h2>
          <p class="text-warning small mt-2">+2 since yesterday (Example)</p>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Active Orders</h5>
          <h2 class="card-text fw-bold mt-3">36 <small class="text-muted">(Example)</small></h2>
          <p class="text-success small mt-2">+8 new today (Example)</p>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Services Booked</h5>
          <h2 class="card-text fw-bold mt-3">42 <small class="text-muted">(Example)</small></h2>
          <p class="text-danger small mt-2">-6 from last week (Example)</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts and Recent Orders -->
  <div class="row g-4">
    <!-- Overview Chart Placeholder -->
    <div class="col-12 col-lg-8">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title mb-4">Overview</h5>
          <div class="d-flex justify-content-center align-items-center" style="height: 250px; color: #ccc;">
            [Bar Chart Placeholder]
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-12 col-lg-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title mb-4">Recent Orders</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <p class="mb-1 fw-medium">John Smith</p>
                <small class="text-muted">Embroidery - Mar 19, 2025</small>
              </div>
              <span class="badge bg-warning text-dark rounded-pill">In Progress</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

</main>

<!-- Bootstrap JS -->
<script src="../../public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php include '../../includes/admin_footer.php'; ?>
