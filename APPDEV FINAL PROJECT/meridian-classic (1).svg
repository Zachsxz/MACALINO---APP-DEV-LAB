<?php
require 'config/db.php';
require 'includes/functions.php';
require_customer_login();
$__base = '';
$page_title = 'Cart';
$customer_id = $_SESSION['customer_id'];

// Update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $cart_id => $qty) {
        $cart_id = (int)$cart_id;
        $qty = max(1, (int)$qty);
        mysqli_query($conn, "UPDATE cart_items SET quantity=$qty WHERE cart_id=$cart_id AND customer_id=$customer_id");
    }
    log_activity($conn, 'customer', $customer_id, $_SESSION['customer_name'], 'UPDATE_CART', 'Updated cart quantities');
    header("Location: cart.php?updated=1");
    exit;
}

// Remove item
if (isset($_GET['remove'])) {
    $cart_id = (int)$_GET['remove'];
    mysqli_query($conn, "DELETE FROM cart_items WHERE cart_id=$cart_id AND customer_id=$customer_id");
    log_activity($conn, 'customer', $customer_id, $_SESSION['customer_name'], 'REMOVE_FROM_CART', "Removed cart item #$cart_id");
    header("Location: cart.php?removed=1");
    exit;
}

$items = mysqli_query($conn, "SELECT ci.cart_id, ci.quantity, p.product_id, p.name, p.price, p.image_url, p.stock_qty
                               FROM cart_items ci JOIN products p ON p.product_id = ci.product_id
                               WHERE ci.customer_id = $customer_id");
$rows = [];
$grand_total = 0;
while ($r = mysqli_fetch_assoc($items)) {
    $r['subtotal'] = $r['price'] * $r['quantity'];
    $grand_total += $r['subtotal'];
    $rows[] = $r;
}

require 'includes/header.php';
?>
<section class="band">
  <div class="container">
    <div class="eyebrow mb-2">Your Selection</div>
    <h1 class="mb-4">Shopping Cart</h1>

    <?php if (isset($_GET['updated'])): ?><div class="alert alert-brass">Cart updated.</div><?php endif; ?>
    <?php if (isset($_GET['removed'])): ?><div class="alert alert-brass">Item removed from cart.</div><?php endif; ?>

    <?php if (!$rows): ?>
      <p style="color:var(--ivory-dim);">Your cart is empty. <a href="store.php">Browse the store &rarr;</a></p>
    <?php else: ?>
      <form method="POST">
        <div class="table-responsive">
          <table class="table table-alli align-middle">
            <thead>
              <tr><th>Product</th><th>Price</th><th style="width:120px;">Quantity</th><th>Subtotal</th><th></th></tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $r): ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <img src="<?php echo htmlspecialchars($r['image_url']); ?>" width="48" height="48" alt="">
                      <span><?php echo htmlspecialchars($r['name']); ?></span>
                    </div>
                  </td>
                  <td class="price"><?php echo format_price($r['price']); ?></td>
                  <td>
                    <input type="number" name="qty[<?php echo $r['cart_id']; ?>]" value="<?php echo $r['quantity']; ?>"
                           min="1" max="<?php echo $r['stock_qty']; ?>" class="form-control form-control-sm">
                  </td>
                  <td class="price"><?php echo format_price($r['subtotal']); ?></td>
                  <td><a href="cart.php?remove=<?php echo $r['cart_id']; ?>" class="text-danger" style="color:#e5738a !important;" onclick="return confirm('Remove this item?');">Remove</a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3">
          <button type="submit" name="update_cart" value="1" class="btn btn-outline-brass">Update Cart</button>
          <div class="text-end">
            <div style="color:var(--ivory-dim);" class="mb-1">Grand Total</div>
            <div class="price" style="font-size:1.4rem;"><?php echo format_price($grand_total); ?></div>
          </div>
        </div>
      </form>
      <div class="text-end mt-3">
        <a href="checkout.php" class="btn btn-brass">Proceed to Checkout</a>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
