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
  <title>Inventory Table</title>
  <link href="../../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 fw-bold">Inventory</h1>
            <p class="text-muted mb-0">Manage your materials, fabrics, threads, and supplies</p>
        </div>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm">
                <option>All Categories</option>
                <option>Fabrics</option>
                <option>Threads</option>
                <option>Sublimation Supplies</option>
                <option>Embroidery Supplies</option>
                <option>Other Supplies</option>
            </select>
            <select class="form-select form-select-sm">
                <option>All Status</option>
                <option>In Stock</option>
                <option>Low Stock</option>
                <option>Out of Stock</option>
                <option>On Order</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-uppercase small text-muted">
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Supplier</th>
                        <th>Unit Price</th>
                        <th>Reorder Level</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row Example -->
                    <tr>
                        <td>Cotton Fabric - Black (Example)</td>
                        <td>Fabrics</td>
                        <td>FAB-COT-BLK</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-outline-secondary btn-sm px-2 py-0">-</button>
                                <span>45</span>
                                <button class="btn btn-outline-secondary btn-sm px-2 py-0">+</button>
                            </div>
                        </td>
                        <td><span class="badge bg-success bg-opacity-10 text-success">In Stock</span></td>
                        <td>Textile World Inc.</td>
                        <td>$8.50</td>
                        <td>20</td>
                        <td>Mar 18, 2025</td>
                        <td>
                            <button class="btn btn-sm btn-link text-decoration-none text-muted">Edit</button>
                            <button class="btn btn-sm btn-link text-decoration-none text-danger">Delete</button>
                        </td>
                    </tr>
                    <!-- You can duplicate more rows as needed -->
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
