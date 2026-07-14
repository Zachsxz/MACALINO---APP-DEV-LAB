<?php
require '../config/db.php';
require '../includes/functions.php';
require_admin_login();
$page_title = 'Dashboard';

$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM products"))['c'];
$lowStock      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM products WHERE stock_qty <= 5"))['c'];
$totalOrders   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM orders"))['c'];
$totalCustomers= mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM customers WHERE is_confirmed=1"))['c'];
$totalSales    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_amount),0) s FROM orders WHERE status != 'cancelled'"))['s'];

require 'includes/header.php';
?>
<h1 class="mb-1">Dashboard</h1>
<p style="color:var(--ivory-dim);">Signed in as <?php echo htmlspecialchars($_SESSION['admin_name']); ?> (<?php echo htmlspecialchars($_SESSION['admin_role']); ?>)</p>

<div class="row g-3 mt-2">
  <div class="col-md-3 col-sm-6">
    <div class="stat-card"><div class="stat-num"><?php echo $totalProducts; ?></div><div style="color:var(--ivory-dim);">Products</div></div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="stat-card"><div class="stat-num"><?php echo $lowStock; ?></div><div style="color:var(--ivory-dim);">Low Stock (&le;5)</div></div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="stat-card"><div class="stat-num"><?php echo $totalOrders; ?></div><div style="color:var(--ivory-dim);">Orders Placed</div></div>
  </div>
  <div class="col-md-3 col-sm-6">
    <div class="stat-card"><div class="stat-num"><?php echo $totalCustomers; ?></div><div style="color:var(--ivory-dim);">Confirmed Customers</div></div>
  </div>
</div>

<div class="row mt-3">
  <div class="col-md-6">
    <div class="stat-card">
      <div style="color:var(--ivory-dim);">Total Sales (non-cancelled orders)</div>
      <div class="stat-num"><?php echo format_price($totalSales); ?></div>
    </div>
  </div>
</div>

<div class="mt-4">
  <a href="products.php" class="btn btn-brass me-2">Manage Stocks &amp; Prices</a>
  <a href="users.php" class="btn btn-outline-brass me-2">Manage Admin Users</a>
  <a href="reports_audit.php" class="btn btn-outline-brass">View Audit Log</a>
</div>

<?php require 'includes/footer.php'; ?>
