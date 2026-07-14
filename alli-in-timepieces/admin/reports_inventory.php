<?php
require '../config/db.php';
require '../includes/functions.php';
require_admin_login();
$page_title = 'Inventory Report';

$products = mysqli_query($conn, "SELECT p.*, c.name AS category_name FROM products p
                                  JOIN categories c ON c.category_id = p.category_id
                                  ORDER BY p.stock_qty ASC");

$totalUnits = 0;
$totalValue = 0;
$rows = [];
while ($p = mysqli_fetch_assoc($products)) {
    $totalUnits += $p['stock_qty'];
    $totalValue += $p['stock_qty'] * $p['price'];
    $rows[] = $p;
}

log_activity($conn, 'admin', $_SESSION['admin_id'], $_SESSION['admin_name'], 'VIEW_REPORT', 'Viewed Inventory Report');

require 'includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="mb-0">Inventory Report</h1>
  <span style="color:var(--ivory-dim);">Generated <?php echo date('M j, Y g:i A'); ?></span>
</div>

<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="stat-card"><div class="stat-num"><?php echo count($rows); ?></div><div style="color:var(--ivory-dim);">SKUs</div></div>
  </div>
  <div class="col-md-4">
    <div class="stat-card"><div class="stat-num"><?php echo $totalUnits; ?></div><div style="color:var(--ivory-dim);">Total Units Remaining</div></div>
  </div>
  <div class="col-md-4">
    <div class="stat-card"><div class="stat-num"><?php echo format_price($totalValue); ?></div><div style="color:var(--ivory-dim);">Total Inventory Value</div></div>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-alli align-middle">
    <thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Remaining Stock</th><th>Stock Value</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $p): ?>
        <tr>
          <td><?php echo htmlspecialchars($p['name']); ?><br><small style="color:var(--ivory-dim);"><?php echo htmlspecialchars($p['brand']); ?></small></td>
          <td><?php echo htmlspecialchars($p['category_name']); ?></td>
          <td class="price"><?php echo format_price($p['price']); ?></td>
          <td>
            <?php echo $p['stock_qty']; ?>
            <?php if ($p['stock_qty'] == 0): ?><span style="color:#e5738a;"> — Out of stock</span>
            <?php elseif ($p['stock_qty'] <= 5): ?><span style="color:#e0b04a;"> — Low</span>
            <?php endif; ?>
          </td>
          <td class="price"><?php echo format_price($p['stock_qty'] * $p['price']); ?></td>
          <td><?php echo $p['status']==='active' ? 'Active' : 'Archived'; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require 'includes/footer.php'; ?>
