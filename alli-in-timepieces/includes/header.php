<?php
// Expects $conn and session already available (require config/db.php before this)
$__cart_count = isset($_SESSION['customer_id']) ? cart_count($conn, $_SESSION['customer_id']) : 0;
$__current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($page_title) ? $page_title . ' — Alli In Timepieces' : 'Alli In Timepieces'; ?></title>
<link rel="icon" href="<?php echo $__base ?? ''; ?>assets/img/logo.svg" type="image/svg+xml">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Jost:wght@300;400;500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $__base ?? ''; ?>assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-alli">
  <div class="container">
    <a class="navbar-brand brand-mark" href="<?php echo $__base ?? ''; ?>index.php">
      <img src="<?php echo $__base ?? ''; ?>assets/img/logo.svg" width="34" height="34" alt="Alli In Timepieces logo">
      <span>Alli In Timepieces<small>Group 5 &middot; Est. Final Project</small></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" style="filter:invert(1);">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item"><a class="nav-link <?php echo $__current=='index.php'?'active':''; ?>" href="<?php echo $__base ?? ''; ?>index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $__current=='store.php'?'active':''; ?>" href="<?php echo $__base ?? ''; ?>store.php">Store</a></li>
        <li class="nav-item"><a class="nav-link <?php echo $__current=='about.php'?'active':''; ?>" href="<?php echo $__base ?? ''; ?>about.php">About</a></li>
        <?php if (isset($_SESSION['customer_id'])): ?>
          <li class="nav-item"><a class="nav-link <?php echo $__current=='cart.php'?'active':''; ?>" href="<?php echo $__base ?? ''; ?>cart.php">Cart <span class="cart-badge"><?php echo $__cart_count; ?></span></a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo $__base ?? ''; ?>logout.php">Logout (<?php echo htmlspecialchars($_SESSION['customer_name']); ?>)</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link <?php echo $__current=='login.php'?'active':''; ?>" href="<?php echo $__base ?? ''; ?>login.php">Login</a></li>
          <li class="nav-item"><a class="btn btn-brass ms-lg-2" href="<?php echo $__base ?? ''; ?>register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
