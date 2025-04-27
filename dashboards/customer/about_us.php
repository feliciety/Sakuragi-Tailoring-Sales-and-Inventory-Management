<?php
include '../../includes/session_check.php';
include '../../includes/customer_header.php';
include '../../includes/customer_sidebar.php';
?>

<link rel="stylesheet" href="../../public/assets/css/style.css">
<link rel="stylesheet" href="../../public/assets/css/about_us.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- === About Page Content === -->
<div class="dashboard-content py-5 d-flex justify-content-center">
    <div class="content-wrapper">
        <!-- 🧵 Hero Section -->
        <div class="about-hero text-center mb-5 fade-in-up">
            <h1 class="section-title text-primary"><i class="bi bi-scissors"></i> Sakuragi Tailoring Shop</h1>
            <p class="section-subtitle fs-6">Crafting your vision, one stitch at a time.</p>
        </div>

        <!-- 🪡 Who We Are -->
        <div class="about-section mb-5 fade-in-up">
            <div class="row align-items-center">
                <div class="col-md-6 text-center mb-4 mb-md-0">
                    <img src="/public/assets/images/tailoring-shop.png" alt="Sakuragi Tailoring"
                        class="img-fluid about-image rounded-4 shadow-sm zoom-in">
                </div>
                <div class="col-md-6">
                    <h2 class="section-heading text-primary fs-4">Who We Are</h2>
                    <p class="fs-6">
                        Sakuragi Tailoring Shop is a family-grown business dedicated to delivering high-quality, customized apparel.
                        From uniforms and event shirts to personalized embroidery and sublimation, we bring every design to life with precision and passion.
                    </p>
                    <p class="fs-6">
                        We proudly serve schools, organizations, businesses, and individuals with a commitment to quality, affordability, and timely delivery.
                    </p>
                </div>
            </div>
        </div>

        <!-- 📈 Achievements / Stats -->
        <div class="about-stats fade-in-up mb-5">
            <div class="text-center mb-4">
                <h2 class="section-heading text-primary fs-4"><i class="bi bi-graph-up-arrow"></i> Our Achievements</h2>
                <p class="section-subtitle fs-6">Delivering excellence through experience, passion, and commitment.</p>
            </div>
            <div class="row text-center justify-content-center g-2">
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="stats-card modern-stats-card zoom-in">
                        <div class="stats-icon mb-2"><i class="bi bi-box-seam"></i></div>
                        <div class="stats-number">500+</div>
                        <div class="stats-label">Orders Fulfilled</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="stats-card modern-stats-card zoom-in delay-1">
                        <div class="stats-icon mb-2"><i class="bi bi-award"></i></div>
                        <div class="stats-number">5+ Years</div>
                        <div class="stats-label">In Business</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="stats-card modern-stats-card zoom-in delay-2">
                        <div class="stats-icon mb-2"><i class="bi bi-emoji-smile"></i></div>
                        <div class="stats-number">100%</div>
                        <div class="stats-label">Customer Satisfaction</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="stats-card modern-stats-card zoom-in delay-3">
                        <div class="stats-icon mb-2"><i class="bi bi-clock-history"></i></div>
                        <div class="stats-number">24/7</div>
                        <div class="stats-label">Order Tracking</div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="stats-card modern-stats-card zoom-in delay-4">
                        <div class="stats-icon mb-2"><i class="bi bi-people-fill"></i></div>
                        <div class="stats-number">200+</div>
                        <div class="stats-label">Trusted Clients</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🎯 Mission & Vision -->
        <div class="about-values mb-5 p-4 rounded-4 shadow-sm bg-white fade-in-up">
            <div class="text-center mb-4">
                <h2 class="section-heading text-primary fs-4"><i class="bi bi-bullseye"></i> Mission & Vision</h2>
                <p class="section-subtitle fs-6">Driven by passion, defined by quality.</p>
            </div>
            <div class="mb-4">
                <h4 class="fw-semibold text-primary fs-5">
                    <i class="bi bi-rocket-takeoff-fill me-2"></i> Our Mission
                </h4>
                <p class="lead text-muted fs-6">
                    To <strong>empower individuals and groups</strong> with custom-made apparel that reflects their
                    <strong>identity and purpose</strong> — crafted with heart, tailored with excellence.
                </p>
            </div>
            <div>
                <h4 class="fw-semibold text-primary fs-5">
                    <i class="bi bi-eye-fill me-2"></i> Our Vision
                </h4>
                <p class="lead text-muted fs-6">
                    To be the <strong>most trusted</strong> and preferred tailoring partner for schools, organizations, and
                    businesses — known for <strong>creativity, reliability,</strong> and <strong>outstanding customer care</strong>.
                </p>
            </div>
        </div>

        <!-- 💎 Core Values -->
        <div class="about-values mb-5 p-4 rounded-4 shadow-sm bg-white fade-in-up">
            <div class="text-center mb-4">
                <h2 class="section-heading text-primary fs-4"><i class="bi bi-stars"></i> Our Core Values</h2>
                <p class="section-subtitle fs-6">What drives and defines us.</p>
            </div>
            <div class="row mt-4 core-values-grid">
                <?php
                $coreValues = [
                    ['🤝', 'Commitment to Quality', 'We deliver consistent, high-standard workmanship.'],
                    ['✨', 'Creativity and Innovation', 'We embrace new ideas and creative solutions.'],
                    ['💼', 'Professionalism and Integrity', 'We act with honesty, fairness, and respect.'],
                    ['🎯', 'Customer-Centric Service', 'Your satisfaction is always our priority.'],
                    ['🌱', 'Continuous Improvement', 'We learn and grow to serve you better.'],
                    ['🤝', 'Teamwork and Collaboration', 'We work together for shared success.'],
                ];
                foreach ($coreValues as $value) {
                    echo '
                    <div class="col-6 col-md-4 mb-3">
                        <div class="value-card text-center p-4 rounded-4 shadow-sm h-100">
                            <div class="icon mb-3">' .
                        $value[0] .
                        '</div>
                            <h5 class="fw-semibold mb-2">' .
                        $value[1] .
                        '</h5>
                            <p class="value-description">' .
                        $value[2] .
                        '</p>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>

        <!-- 🧵 Our Services -->
        <div class="about-services mb-5 p-4 rounded-4 shadow-sm bg-white fade-in-up">
            <h2 class="section-heading text-primary fs-4"><i class="bi bi-tools"></i> Our Services</h2>
            <ul class="list-unstyled mt-3 fs-6">
                <li>✔️ Embroidery & Custom Name Stitches</li>
                <li>✔️ Sublimation & Full-Color Prints</li>
                <li>✔️ Screen Printing for Bulk Orders</li>
                <li>✔️ Alterations and Repairs</li>
                <li>✔️ Patch Production</li>
                <li>✔️ Officer Uniforms & Organization Shirts</li>
            </ul>
        </div>

        <!-- 👥 Meet the Team -->
        <div class="about-team p-4 rounded-4 shadow-sm bg-white fade-in-up">
            <h2 class="section-heading text-primary fs-4"><i class="bi bi-people-fill"></i> Meet Our Team</h2>
            <p class="mt-3 fs-6">
                Behind every stitch and print is a passionate team ensuring each project is handled with care and expertise.
                From our skilled tailors and designers to our friendly customer service representatives, we work together to deliver the best results for you.
            </p>
        </div>
    </div>
</div>

<?php include '../../includes/customer_footer.php'; ?>
