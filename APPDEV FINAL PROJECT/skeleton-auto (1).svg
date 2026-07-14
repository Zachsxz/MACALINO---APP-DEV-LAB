<?php
require 'config/db.php';
require 'includes/functions.php';
require_customer_login();
$__base = '';
$page_title = 'Payment';
$customer_id = $_SESSION['customer_id'];

if (empty($_SESSION['checkout_address']) || empty($_SESSION['checkout_contact'])) {
    header("Location: checkout.php");
    exit;
}

$items = mysqli_query($conn, "SELECT ci.cart_id, ci.quantity, p.product_id, p.name, p.price, p.stock_qty
                               FROM cart_items ci JOIN products p ON p.product_id = ci.product_id
                               WHERE ci.customer_id = $customer_id");
$rows = [];
$grand_total = 0;
while ($r = mysqli_fetch_assoc($items)) {
    $r['subtotal'] = $r['price'] * $r['quantity'];
    $grand_total += $r['subtotal'];
    $rows[] = $r;
}

if (!$rows) {
    header("Location: store.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['payment_method'] ?? '';
    $allowed = ['cod', 'bank_transfer', 'credit_card'];

    if (!in_array($method, $allowed)) {
        $error = "Please select a payment method.";
    } elseif ($method === 'credit_card') {
        $cardNum = preg_replace('/\D/', '', $_POST['card_number'] ?? '');
        $expiry  = trim($_POST['card_expiry'] ?? '');
        $cvv     = trim($_POST['card_cvv'] ?? '');
        if (strlen($cardNum) < 12 || $expiry === '' || strlen($cvv) < 3) {
            $error = "Please fill in valid (dummy) card details. No real card is charged — this is a class project.";
        }
    }

    // Re-check stock right before committing
    if (!$error) {
        foreach ($rows as $r) {
            $stockRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stock_qty FROM products WHERE product_id=" . $r['product_id']));
            if ($r['quantity'] > $stockRow['stock_qty']) {
                $error = "\"" . $r['name'] . "\" no longer has enough stock. Please review your cart.";
                break;
            }
        }
    }

    if (!$error) {
        $address = clean($conn, $_SESSION['checkout_address']);
        $contact = clean($conn, $_SESSION['checkout_contact']);

        mysqli_begin_transaction($conn);
        try {
            $status = ($method === 'cod') ? 'pending' : 'paid';
            mysqli_query($conn, "INSERT INTO orders (customer_id, shipping_address, contact_number, payment_method, total_amount, status)
                                  VALUES ($customer_id, '$address', '$contact', '$method', $grand_total, '$status')");
            $order_id = mysqli_insert_id($conn);

            foreach ($rows as $r) {
                $name = clean($conn, $r['name']);
                mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, product_name, quantity, unit_price)
                                      VALUES ($order_id, {$r['product_id']}, '$name', {$r['quantity']}, {$r['price']})");
                mysqli_query($conn, "UPDATE products SET stock_qty = stock_qty - {$r['quantity']} WHERE product_id = {$r['product_id']}");
            }

            mysqli_query($conn, "DELETE FROM cart_items WHERE customer_id = $customer_id");
            mysqli_commit($conn);

            log_activity($conn, 'customer', $customer_id, $_SESSION['customer_name'], 'CHECKOUT_PAYMENT',
                "Placed order #$order_id via $method, total " . number_format($grand_total,2));

            unset($_SESSION['checkout_address'], $_SESSION['checkout_contact']);
            header("Location: order_success.php?order_id=$order_id");
            exit;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $error = "Something went wrong while placing your order. Please try again.";
        }
    }
}

require 'includes/header.php';
?>
<section class="band">
  <div class="container">
    <div class="eyebrow mb-2">Step 2 of 2</div>
    <h1 class="mb-4">Payment</h1>
    <div class="alert alert-brass" style="font-size:.85rem;">
      This is a class project — no real payment gateway is connected. Any card details entered are not processed or stored for real transactions.
    </div>

    <?php if ($error): ?><div class="alert alert-burgundy"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>

    <div class="row g-4">
      <div class="col-lg-7">
        <form method="POST" class="form-card" id="paymentForm">
          <h5 class="mb-3">Select Payment Method</h5>

          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="payment_method" value="cod" id="pm_cod" checked>
            <label class="form-check-label" for="pm_cod">Cash on Delivery</label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer" id="pm_bank">
            <label class="form-check-label" for="pm_bank">Bank Transfer</label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="payment_method" value="credit_card" id="pm_card">
            <label class="form-check-label" for="pm_card">Credit / Debit Card</label>
          </div>

          <div id="cardFields" class="d-none border-top pt-3 mt-2" style="border-color:var(--line) !important;">
            <div class="mb-3">
              <label class="form-label">Card Number</label>
              <input type="text" name="card_number" class="form-control" placeholder="4111 1111 1111 1111" maxlength="19">
            </div>
            <div class="row">
              <div class="col-6 mb-3">
                <label class="form-label">Expiry (MM/YY)</label>
                <input type="text" name="card_expiry" class="form-control" placeholder="12/29">
              </div>
              <div class="col-6 mb-3">
                <label class="form-label">CVV</label>
                <input type="text" name="card_cvv" class="form-control" placeholder="123" maxlength="4">
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-brass w-100 mt-2">Place Order</button>
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
          <div class="d-flex justify-content-between mb-3">
            <strong>Total</strong>
            <strong class="price"><?php echo format_price($grand_total); ?></strong>
          </div>
          <div style="font-size:.82rem;color:var(--ivory-dim);">
            Shipping to:<br><?php echo nl2br(htmlspecialchars($_SESSION['checkout_address'])); ?><br>
            Contact: <?php echo htmlspecialchars($_SESSION['checkout_contact']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
document.querySelectorAll('input[name="payment_method"]').forEach(function(r){
  r.addEventListener('change', function(){
    document.getElementById('cardFields').classList.toggle('d-none', this.value !== 'credit_card');
  });
});
</script>
<?php require 'includes/footer.php'; ?>
