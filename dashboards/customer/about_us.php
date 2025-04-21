<?php
include '../../includes/session_check.php';
include '../../includes/customer_header.php';
include '../../includes/customer_sidebar.php';
?>

<link rel="stylesheet" href="../../public/assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="dashboard-content py-4 px-3">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">About Sakuragi Tailoring Shop</h2>
            <p class="text-muted">Crafting your vision, one stitch at a time.</p>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <img src="../../assets/images/tailoring-shop.jpg" alt="Sakuragi Tailoring" class="img-fluid rounded-4 shadow-sm">
            </div>
            <div class="col-md-6">
                <h4 class="fw-semibold">Who We Are</h4>
                <p>
                    Sakuragi Tailoring Shop is a family-grown business dedicated to delivering high-quality, customized apparel.
                    From uniforms and event shirts to personalized embroidery and sublimation, we bring every design to life with precision and passion.
                </p>
                <p>
                    Established to meet the growing demand for professional tailoring and printing solutions, we’ve served schools, organizations,
                    businesses, and individuals with excellence and creativity.
                </p>
            </div>
        </div>

        <div class="row text-center mb-5">
            <div class="col-md-3">
                <h1 class="fw-bold text-primary">500+</h1>
                <p class="text-muted">Orders Fulfilled</p>
            </div>
            <div class="col-md-3">
                <h1 class="fw-bold text-primary">5+</h1>
                <p class="text-muted">Years in Business</p>
            </div>
            <div class="col-md-3">
                <h1 class="fw-bold text-primary">100%</h1>
                <p class="text-muted">Customer Satisfaction</p>
            </div>
            <div class="col-md-3">
                <h1 class="fw-bold text-primary">24/7</h1>
                <p class="text-muted">Order Tracking</p>
            </div>
        </div>

        <div class="bg-light p-5 rounded-4 shadow-sm">
            <h4 class="fw-semibold mb-3">Our Mission</h4>
            <p>
                To empower individuals and groups with custom-made apparel that reflects their identity and purpose—created with heart, tailored with excellence.
            </p>

            <h4 class="fw-semibold mt-4 mb-3">Our Services</h4>
            <ul class="list-unstyled">
                <li>✔️ Embroidery & Custom Name Stitches</li>
                <li>✔️ Sublimation & Full-Color Prints</li>
                <li>✔️ Screen Printing for Bulk Orders</li>
                <li>✔️ Alterations and Repairs</li>
                <li>✔️ Patch Production</li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>

<?php include '../../includes/customer_footer.php'; ?>