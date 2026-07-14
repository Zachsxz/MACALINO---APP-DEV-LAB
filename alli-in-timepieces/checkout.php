<?php
require 'config/db.php';
require 'includes/functions.php';
require_customer_login();
$__base = '';
$page_title = 'Checkout';
$customer_id = $_SESSION['customer_id'];

$customer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM customers WHERE customer_id=$customer_id"));

$items = mysqli_query($conn, "SELECT ci.quantity, p.name, p.price, p.stock_qty
                               FROM cart_items ci JOIN products p ON p.product_id = ci.product_id
                               WHERE ci.customer_id = $customer_id");
$rows = [];
$grand_total = 0;
$stock_error = false;
while ($r = mysqli_fetch_assoc($items)) {
    $r['subtotal'] = $r['price'] * $r['quantity'];
    $grand_total += $r['subtotal'];
    if ($r['quantity'] > $r['stock_qty']) $stock_error = true;
    $rows[] = $r;
}

if (!$rows) {
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address'] ?? '');
    $contact = trim($_POST['contact_number'] ?? '');
    if ($address === '' || $contact === '') {
        $error = "Please fill in both shipping address and contact number.";
    } else {
        $_SESSION['checkout_address'] = $address;
        $_SESSION['checkout_contact'] = $contact;
        header("Location: payment.php");
        exit;
    }
}

require 'includes/header.php';
?>
<section class="band">
  <div class="container">
    <div class="eyebrow mb-2">Step 1 of 2</div>
    <h1 class="mb-4">Checkout</h1>

    <?php if ($stock_error): ?>
      <div class="alert alert-burgundy">One or more items in your cart exceed available stock. Please <a href="cart.php">update your cart</a> before continuing.</div>
    <?php else: ?>

    <?php if (!empty($error)): ?><div class="alert alert-burgundy"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

    <div class="row g-4">
      <div class="col-lg-7">
        <form method="POST" class="form-card">
          <h5 class="mb-3">Shipping Details</h5>
          <div class="mb-3">
            <label class="form-label">Complete Address</label>
            <textarea name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($customer['address']); ?></textarea>
          </div>
          <div class="mb-4">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact_number" class="form-control" required value="<?php echo htmlspecialchars($customer['contact_number']); ?>">
          </div>
          <button type="submit" class="btn btn-brass w-100">Continue to Payment</button>
        </form>
      </div>
      <div class="col-lg-5">
        <div class="form-card">
          <h5 class="mb-3">Order Summary</h5>
          <?php foreach ($rows as $r): ?>
            <div class="d-flex justify-content-between mb-2" style="font-size:.9rem;">
              <span><?php echo htmlspecialchars($r['name']); ?> &times; <?php echo $r['quantity']; ?></span>
              <span class="price"><?php echo format_price($r['subtotal']); ?></span>
            </div>
          <?php endforeach; ?>
          <hr class="divider my-2">
          <div class="d-flex justify-content-between">
            <strong>Total</strong>
            <strong class="price"><?php echo format_price($grand_total); ?></strong>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
