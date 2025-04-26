<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="col-md-2 bg-white border-end p-3 shadow-sm vh-100">
    <h6 class="text-uppercase text-muted small mb-3">Customer Menu</h6>
    <ul class="nav flex-column gap-2">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $current === 'dashboard.php' ? 'bg-info text-white fw-bold' : 'text-dark' ?>">
                <i class="bi bi-house-door me-1"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="about_us.php" class="nav-link <?= $current === 'about_us.php' ? 'bg-info text-white fw-bold' : 'text-dark' ?>">
                <i class="bi bi-info-circle"></i> About Us
            </a>
        </li>
        <li class="nav-item">
            <a href="place_order.php" class="nav-link <?= $current === 'place_order.php' ? 'bg-info text-white fw-bold' : 'text-dark' ?>">
                <i class="bi bi-plus-square me-1"></i> Place Order
            </a>
        </li>
        <li class="nav-item">
            <a href="my_orders.php" class="nav-link <?= $current === 'my_orders.php' ? 'bg-info text-white fw-bold' : 'text-dark' ?>">
                <i class="bi bi-card-checklist me-1"></i> My Orders
            </a>
        </li>
        <li class="nav-item">
            <a href="services.php" class="nav-link <?= $current === 'services.php' ? 'bg-info text-white fw-bold' : 'text-dark' ?>">
                <i class="bi bi-gear me-1"></i> Services
            </a>
        </li>
    </ul>
</div>
<div class="col-md-10 bg-light">
