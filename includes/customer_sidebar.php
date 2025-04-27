<?php
$current = basename($_SERVER['PHP_SELF']); ?>
<div class="sidebar bg-white border-end p-3 shadow-sm" id="sidebar">
    <h6 class="text-uppercase text-muted small mb-3">Customer Menu</h6>
    <ul class="nav flex-column gap-2">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?= $current === 'dashboard.php' ? 'active' : '' ?>">
                <i class="bi bi-house-door me-1"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="about_us.php" class="nav-link <?= $current === 'about_us.php' ? 'active' : '' ?>">
                <i class="bi bi-info-circle me-1"></i> About Us
            </a>
        </li>
        <li class="nav-item">
            <a href="place_order.php" class="nav-link <?= $current === 'place_order.php' ? 'active' : '' ?>">
                <i class="bi bi-plus-square me-1"></i> Place Order
            </a>
        </li>
        <li class="nav-item">
            <a href="my_orders.php" class="nav-link <?= $current === 'my_orders.php' ? 'active' : '' ?>">
                <i class="bi bi-card-checklist me-1"></i> My Orders
            </a>
        </li>
        <li class="nav-item">
            <a href="services.php" class="nav-link <?= $current === 'services.php' ? 'active' : '' ?>">
                <i class="bi bi-gear me-1"></i> Services
            </a>
        </li>
    </ul>
</div>
