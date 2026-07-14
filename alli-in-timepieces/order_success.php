<?php
require 'config/db.php';
require 'includes/functions.php';
require_customer_login();
$__base = '';
$page_title = 'Order Confirmed';
$customer_id = $_SESSION['customer_id'];
$order_id = (int)($_GET['order_id'] ?? 0);

$order = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE order_id=$order_id AND customer_id=$customer_id"));
if (!$order) { header("Location: store.php"); exit; }

$items = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id=$order_id");

require 'includes/header.php';
?>
<section class="band">
  <div class="container text-center" style="max-width:640px;">
    <div class="eyebrow mb-2">Thank You</div>
    <h1 class="mb-3">Order #<?php echo $order_id; ?> Confirmed</h1>
    <p style="color:var(--ivory-dim);">Payment method: <strong style="color:var(--brass-light);"><?php echo strtoupper(str_replace('_',' ', $order['payment_method'])); ?></strong>
    &middot; Status: <strong style="color:var(--brass-light);"><?php echo ucfirst($order['status']); ?></strong></p>

    <div class="form-card text-start mt-4">
      <?php while ($it = mysqli_fetch_assoc($items)): ?>
        <div class="d-flex justify-content-between mb-2" style="font-size:.9rem;">
          <span><?php echo htmlspecialchars($it['product_name']); ?> &times; <?php echo $it['quantity']; ?></span>
          <span class="price"><?php echo format_price($it['unit_price'] * $it['quantity']); ?></span>
        </div>
      <?php endwhile; ?>
      <hr class="divider my-2">
      <div class="d-flex justify-content-between">
        <strong>Total Paid</strong>
        <strong class="price"><?php echo format_price($order['total_amount']); ?></strong>
      </div>
    </div>

    <a href="store.php" class="btn btn-brass mt-4">Continue Shopping</a>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
