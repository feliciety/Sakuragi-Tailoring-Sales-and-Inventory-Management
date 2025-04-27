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
  <title>Orders Table</title>
  <link href="../../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 fw-bold">Orders</h1>
            <p class="text-muted mb-0">Manage customer orders and track their progress</p>
        </div>
        <div>
            <select class="form-select form-select-sm w-auto">
                <option>All Orders</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-uppercase small text-muted">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row Example -->
                    <tr>
                        <td>#001 Example(01)</td>
                        <td>John Smith</td>
                        <td>Embroidery</td>
                        <td>Mar 19, 2025</td>
                        <td>$45.00</td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary">In Progress</span></td>
                        <td>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class="d-flex gap-2">
                            <button class="btn btn-sm btn-light border"><i class="bi bi-eye"></i></button>
                            <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <!-- Add more rows here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="../../public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include '../../includes/admin_footer.php'; ?>
