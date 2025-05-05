<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/auth_required.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_customer.php';

if (get_user_role() === ROLE_ADMIN || get_user_role() === ROLE_MANAGER || get_user_role() === ROLE_EMPLOYEE) {
    header('Location: /dashboards/employee/dashboard.php');
    exit();
}
?>
<main class="main-content">
  <div class="dashboard-content">
    <div class="container-wrapper">
      <div class="text-center mb-5 fade-in">
        <h2 class="fw-bold">About Sakuragi Tailoring Shop</h2>
        <p class="text-muted">Crafting your vision, one stitch at a time.</p>
      </div>

      <!-- Who We Are -->
      <section class="card-section fade-in-up">
        <h2 class="section-heading">Who We Are</h2>
        <p>Sakuragi Tailoring Shop is a family-grown business dedicated to delivering high-quality, customized apparel. From uniforms and event shirts to personalized embroidery and sublimation, we bring every design to life with precision and passion.</p>
        <p>We proudly serve schools, organizations, and individuals across the region with trusted tailoring solutions.</p>
      </section>

      <!-- Achievements -->
      <section class="card-section fade-in-up">
        <h2 class="section-heading">Our Achievements</h2>
        <p class="section-subtitle">Delivering excellence through experience and dedication.</p>
        <div class="grid stats-grid">
          <div class="stats-card">
            <div class="stats-icon">📦</div>
            <div class="stats-number">500+</div>
            <div class="stats-label">Orders Fulfilled</div>
          </div>
          <div class="stats-card">
            <div class="stats-icon">🏆</div>
            <div class="stats-number">5+ Years</div>
            <div class="stats-label">In Business</div>
          </div>
          <div class="stats-card">
            <div class="stats-icon">😊</div>
            <div class="stats-number">100%</div>
            <div class="stats-label">Customer Satisfaction</div>
          </div>
          <div class="stats-card">
            <div class="stats-icon">⏰</div>
            <div class="stats-number">24/7</div>
            <div class="stats-label">Order Tracking</div>
          </div>
          <div class="stats-card">
            <div class="stats-icon">👥</div>
            <div class="stats-number">200+</div>
            <div class="stats-label">Trusted Clients</div>
          </div>
        </div>
      </section>

      <!-- Mission & Services -->
      <section class="card-section fade-in-up">
        <h2 class="section-heading">Mission & Services</h2>
        <h4 class="fw-semibold">Our Mission</h4>
        <p>To empower individuals and groups with custom-made apparel that reflects their identity and purpose — crafted with heart, tailored with excellence.</p>
        <h4 class="fw-semibold mt-4">Our Services</h4>
        <ul class="values-list">
          <li>Embroidery & Custom Name Stitches</li>
          <li>Sublimation & Full-Color Prints</li>
          <li>Screen Printing for Bulk Orders</li>
          <li>Alterations and Repairs</li>
          <li>Patch Production</li>
        </ul>
      </section>

      <!-- Developer Team -->
      <section class="card-section fade-in-up">
        <h2 class="section-heading">Developer Team</h2>
        <p class="section-subtitle">Crafting the digital experience that powers Sakuragi Tailoring Shop.</p>
        <div class="grid team-grid">
          <?php
          $team = [
            ['name' => 'Albert Peculados', 'role' => 'Developer', 'img' => 'albert.png'],
            ['name' => 'Cjay Lao', 'role' => 'Backend Developer', 'img' => 'cjay.png'],
            ['name' => 'Fe Malasarte', 'role' => 'Frontend Developer', 'img' => 'fe.png'],
            ['name' => 'Joevan Capote', 'role' => 'Developer', 'img' => 'joevan.png'],
          ];
          foreach ($team as $member): ?>
          <div class="developer-card fade-in-up">
            <img src="/public/assets/images/<?= $member['img'] ?>" class="developer-image" alt="<?= $member['name'] ?>">
            <h5 class="fw-bold mt-3 mb-1"><?= $member['name'] ?></h5>
            <p class="text-muted-small"><?= $member['role'] ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      </section>
    </div>
  </div>
</main>
<?php require_once '../../includes/footer.php'; ?>

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #f4f6f9;
  margin: 0;
  padding: 0;
  color: #333;
}

.container-wrapper {
  max-width: 1080px;
  margin: 0 auto;
  padding: 32px 20px;
}

.text-center {
  text-align: center;
}

.section-heading {
  font-size: 1.6rem;
  color: #0B5CF9;
  margin-bottom: 8px;
}

.section-subtitle {
  color: #6c757d;
  font-size: 0.95rem;
  margin-bottom: 20px;
}

.card-section {
  background: #fff;
  padding: 28px;
  border-radius: 16px;
  box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);
  margin-bottom: 40px;
  transition: all 0.4s ease;
}

.card-section:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 28px rgba(0, 0, 0, 0.06);
}

.stats-card {
  background: #fff;
  border-radius: 14px;
  padding: 24px 18px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  transition: 0.3s ease;
}

.stats-card:hover {
  transform: translateY(-6px);
}

.stats-icon {
  font-size: 1.9rem;
  margin-bottom: 10px;
  color: #0B5CF9;
}

.stats-number {
  font-size: 1.4rem;
  font-weight: 700;
  color: #0B5CF9;
}

.stats-label {
  font-size: 0.85rem;
  color: #6c757d;
}

.values-list li {
  list-style: none;
  padding-left: 20px;
  position: relative;
  margin-bottom: 10px;
}

.values-list li::before {
  content: '\2713';
  position: absolute;
  left: 0;
  color: #27ae60;
  font-weight: bold;
}

.grid {
  display: grid;
  gap: 20px;
  margin-top: 25px;
}

.stats-grid {
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
}

.team-grid {
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  justify-content: center;
}

.developer-card {
  background: #fff;
  padding: 20px;
  border-radius: 14px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.developer-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
}

.developer-image {
  width: 100%;
  height: auto;
  border-radius: 50%;
  max-width: 120px;
  margin: 0 auto 15px;
  display: block;
}

.text-muted-small {
  color: #6c757d;
  font-size: 0.85rem;
}

.fade-in-up {
  animation: fadeInUp 0.8s ease both;
}

.fade-in {
  animation: fadeIn 1s ease both;
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>
