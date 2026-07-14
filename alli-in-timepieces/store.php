<?php
require 'config/db.php';
require 'includes/functions.php';
$__base = '';
$page_title = 'Store';

// Handle add-to-cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    require_customer_login();
    $product_id = (int)$_POST['product_id'];
    $qty = max(1, (int)($_POST['quantity'] ?? 1));
    $customer_id = $_SESSION['customer_id'];

    $existing = mysqli_query($conn, "SELECT cart_id, quantity FROM cart_items WHERE customer_id=$customer_id AND product_id=$product_id");
    if ($row = mysqli_fetch_assoc($existing)) {
        $newQty = $row['quantity'] + $qty;
        mysqli_query($conn, "UPDATE cart_items SET quantity=$newQty WHERE cart_id=" . $row['cart_id']);
    } else {
        mysqli_query($conn, "INSERT INTO cart_items (customer_id, product_id, quantity) VALUES ($customer_id, $product_id, $qty)");
    }
    $prodName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name FROM products WHERE product_id=$product_id"))['name'] ?? '';
    log_activity($conn, 'customer', $customer_id, $_SESSION['customer_name'], 'ADD_TO_CART', "Added \"$prodName\" x$qty to cart");

    header("Location: store.php?added=1" . (isset($_GET['category']) ? '&category=' . (int)$_GET['category'] : ''));
    exit;
}

$catFilter = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");

$where = "WHERE p.status='active'" . ($catFilter ? " AND p.category_id=$catFilter" : "");
$products = mysqli_query($conn, "SELECT p.*, c.name AS category_name FROM products p
                                  JOIN categories c ON c.category_id = p.category_id
                                  $where ORDER BY c.name, p.name");

require 'includes/header.php';
?>

<section class="band">
  <div class="container">
    <div class="eyebrow mb-2">The Collection</div>
    <h1 class="mb-4">Store</h1>

    <?php if (isset($_GET['added'])): ?>
      <div class="alert alert-brass">Item added to your cart. <a href="cart.php">View cart &rarr;</a></div>
    <?php endif; ?>
    <?php if (!isset($_SESSION['customer_id'])): ?>
      <div class="alert alert-brass">You're browsing as a guest. <a href="login.php">Log in</a> or <a href="register.php">register</a> to add items to your cart.</div>
    <?php endif; ?>

    <div class="mb-4">
      <a href="store.php" class="btn btn-sm <?php echo !$catFilter?'btn-brass':'btn-outline-brass'; ?> me-2 mb-2">All</a>
      <?php while ($c = mysqli_fetch_assoc($categories)): ?>
        <a href="store.php?category=<?php echo $c['category_id']; ?>"
           class="btn btn-sm <?php echo $catFilter==$c['category_id']?'btn-brass':'btn-outline-brass'; ?> me-2 mb-2">
           <?php echo htmlspecialchars($c['name']); ?>
        </a>
      <?php endwhile; ?>
    </div>

    <div class="row g-4">
      <?php if (mysqli_num_rows($products) === 0): ?>
        <p style="color:var(--ivory-dim);">No products found in this category.</p>
      <?php endif; ?>
      <?php while ($p = mysqli_fetch_assoc($products)): ?>
        <div class="col-lg-4 col-md-6">
          <div class="card card-alli">
            <img src="<?php echo htmlspecialchars($p['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="card-body">
              <span class="category-pill"><?php echo htmlspecialchars($p['category_name']); ?></span>
              <h5 class="card-title mb-1"><?php echo htmlspecialchars($p['name']); ?></h5>
              <p class="mb-1" style="color:var(--ivory-dim); font-size:.85rem;"><?php echo htmlspecialchars($p['brand']); ?></p>
              <p class="mb-2" style="color:var(--ivory-dim); font-size:.82rem;"><?php echo htmlspecialchars($p['description']); ?></p>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="price"><?php echo format_price($p['price']); ?></div>
                <small class="specs" style="color:var(--ivory-dim);">
                  <?php echo $p['stock_qty'] > 0 ? $p['stock_qty'] . ' in stock' : 'Out of stock'; ?>
                </small>
              </div>
              <?php if ($p['stock_qty'] > 0): ?>
                <form method="POST">
                  <input type="hidden" name="product_id" value="<?php echo $p['product_id']; ?>">
                  <div class="input-group input-group-sm mb-2">
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $p['stock_qty']; ?>" class="form-control">
                    <button type="submit" name="add_to_cart" value="1" class="btn btn-brass">Add to Cart</button>
                  </div>
                </form>
              <?php else: ?>
                <button class="btn btn-outline-brass btn-sm w-100" disabled>Out of Stock</button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
