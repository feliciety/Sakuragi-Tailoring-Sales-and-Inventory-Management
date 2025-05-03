<?php
// No session_start() here — it's already handled in session_handler.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sakuragi Tailoring Shop</title>
  <link rel="stylesheet" href="/public/assets/css/includes.css" />
  <link rel="stylesheet" href="/public/assets/css/tables.css" />
  
  <script src="/public/assets/js/sidebar.js"></script>
  <script src="/public/assets/js/tables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <script src="https://unpkg.com/scrollreveal"></script>



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 
</head>
<body>

<header class="main-header">
    <!-- Particles animation -->
    <div class="particles-header">
  <?php for ($i = 1; $i <= 20; $i++): ?>
    <span></span>
  <?php endfor; ?>
</div>


    <!-- Content -->
    <div class="header-container">
        <div class="logo-area">
            <i class="fas fa-scissors logo-icon"></i>
            <span class="header-title">Sakuragi Tailoring Shop</span>
        </div>

        <div class="user-area">
        <?php if (is_logged_in()): ?>
    <div class="user-profile">
        <div class="avatar">
        <a href="/account.php" class="avatar-btn" title="My Account">
            <i class="fas fa-user-circle"></i>
            <span class="user-name"><?= $_SESSION['full_name']; ?></span>
        </a>
        </div>
       
        <a href="/auth/logout.php" class="logout-btn" onclick="return confirm('Logout?')">Logout</a>
    </div>
      <?php else: ?>
          <a href="/auth/login.php" class="header-btn">Login</a>
      <?php endif; ?>

        </div>
    </div>
</header>
