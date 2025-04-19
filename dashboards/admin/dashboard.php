<?php include '../session_check.php'; ?>
<?php include '../admin_header.php'; ?>
<?php include '../admin_sidebar.php'; ?>

<div class="container mt-4">
    <h2 class="mb-3">Admin Dashboard</h2>
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Orders</h5>
                <p>Manage all tailoring orders.</p>
                <a href="#" class="btn btn-sm btn-primary">View Orders</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Inventory</h5>
                <p>Track and update inventory.P</p>
                <a href="#" class="btn btn-sm btn-primary">Manage Inventory</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3">
                <h5>Reports</h5>
                <p>Generate sales and usage reports.</p>
                <a href="#" class="btn btn-sm btn-primary">View Reports</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>
