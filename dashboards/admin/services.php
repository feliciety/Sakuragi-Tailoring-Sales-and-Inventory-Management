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
  <title>Services with Bootstrap</title>
  <link href="../../public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="h4 fw-bold">Services</h1>
        <p class="text-muted">Manage your tailoring services including sublimation, embroidery, and alterations</p>
    </div>

    <!-- Services Grid -->
    <div class="row g-4">
        
        <!-- Service Card -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Sublimation Printing</h5>
                        <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                    </div>
                    <p class="text-muted small">Full-color dye sublimation printing on polyester fabrics and items</p>
                    <ul class="list-unstyled small mb-4">
                        <li><strong>Base Price:</strong> $25.00</li>
                        <li><strong>Materials:</strong> Sublimation Paper, Sublimation Ink, Heat Press</li>
                        <li><strong>Avg. Completion:</strong> 1-2 days</li>
                    </ul>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="service1" checked>
                            <label class="form-check-label small" for="service1">Active</label>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service 2: Custom Embroidery -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Custom Embroidery</h5>
                        <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                    </div>
                    <p class="text-muted small">Personalized embroidery for garments, hats, bags, and more</p>
                    <ul class="list-unstyled small mb-4">
                        <li><strong>Base Price:</strong> $15.00</li>
                        <li><strong>Materials:</strong> Embroidery Thread, Stabilizers, Hoops</li>
                        <li><strong>Avg. Completion:</strong> 2-3 days</li>
                    </ul>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="service2" checked>
                            <label class="form-check-label small" for="service2">Active</label>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service 3: Alterations -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Alterations</h5>
                        <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                    </div>
                    <p class="text-muted small">Garment alterations including hemming, taking in/out, and repairs</p>
                    <ul class="list-unstyled small mb-4">
                        <li><strong>Base Price:</strong> $20.00</li>
                        <li><strong>Materials:</strong> Thread, Fabric (if needed)</li>
                        <li><strong>Avg. Completion:</strong> 3-5 days</li>
                    </ul>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="service3" checked>
                            <label class="form-check-label small" for="service3">Active</label>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service 4: Custom Tailoring -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Custom Tailoring</h5>
                        <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                    </div>
                    <p class="text-muted small">Made-to-measure clothing creation from scratch</p>
                    <ul class="list-unstyled small mb-4">
                        <li><strong>Base Price:</strong> $150.00</li>
                        <li><strong>Materials:</strong> Fabric, Thread, Buttons, Zippers</li>
                        <li><strong>Avg. Completion:</strong> 7-14 days</li>
                    </ul>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="service4" checked>
                            <label class="form-check-label small" for="service4">Active</label>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service 5: Patch Creation -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Patch Creation</h5>
                        <span class="badge bg-danger bg-opacity-10 text-danger">Inactive</span>
                    </div>
                    <p class="text-muted small">Custom embroidered patches for uniforms and apparel</p>
                    <ul class="list-unstyled small mb-4">
                        <li><strong>Base Price:</strong> $12.00</li>
                        <li><strong>Materials:</strong> Backing Material, Embroidery Thread, Adhesive</li>
                        <li><strong>Avg. Completion:</strong> 2-3 days</li>
                    </ul>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="service5">
                            <label class="form-check-label small" for="service5">Active</label>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service 6: Screen Printing -->
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Screen Printing</h5>
                        <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                    </div>
                    <p class="text-muted small">Multi-color screen printing for t-shirts and apparel</p>
                    <ul class="list-unstyled small mb-4">
                        <li><strong>Base Price:</strong> $18.00</li>
                        <li><strong>Materials:</strong> Screens, Ink, Squeegees</li>
                        <li><strong>Avg. Completion:</strong> 3-5 days</li>
                    </ul>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="service6" checked>
                            <label class="form-check-label small" for="service6">Active</label>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- /row -->
</div> <!-- /container -->

<!-- Bootstrap JS -->
<script src="../../public/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include '../../includes/admin_footer.php'; ?>
