<?php
require '../config/db.php';
require '../includes/functions.php';
require_admin_login();
$page_title = 'Stocks & Prices';

$errors = [];
$success = '';
$edit_product = null;

// ---- Add or Update product ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
    $product_id  = (int)($_POST['product_id'] ?? 0);
    $category_id = (int)($_POST['category_id'] ?? 0);
    $name        = trim($_POST['name'] ?? '');
    $brand       = trim($_POST['brand'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = (float)($_POST['price'] ?? 0);
    $stock_qty   = (int)($_POST['stock_qty'] ?? 0);
    $image_url   = trim($_POST['image_url'] ?? '') ?: 'assets/img/products/meridian-classic.svg';
    $status      = ($_POST['status'] ?? 'active') === 'archived' ? 'archived' : 'active';

    if ($name === '') $errors[] = "Product name is required.";
    if ($brand === '') $errors[] = "Brand is required.";
    if ($price <= 0) $errors[] = "Price must be greater than 0.";
    if ($stock_qty < 0) $errors[] = "Stock quantity cannot be negative.";
    if ($category_id <= 0) $errors[] = "Please choose a category.";

    if (!$errors) {
        $nameSafe = clean($conn, $name);
        $brandSafe = clean($conn, $brand);
        $descSafe = clean($conn, $description);
        $imgSafe = clean($conn, $image_url);

        if ($product_id) {
            $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price, stock_qty FROM products WHERE product_id=$product_id"));
            mysqli_query($conn, "UPDATE products SET category_id=$category_id, name='$nameSafe', brand='$brandSafe',
                                  description='$descSafe', price=$price, stock_qty=$stock_qty, image_url='$imgSafe', status='$status'
                                  WHERE product_id=$product_id");
            $detail = "Updated \"$name\": price {$old['price']} -> $price, stock {$old['stock_qty']} -> $stock_qty";
            log_activity($conn, 'admin', $_SESSION['admin_id'], $_SESSION['admin_name'], 'UPDATE_PRODUCT', $detail);
            $success = "Product updated.";
        } else {
            mysqli_query($conn, "INSERT INTO products (category_id, name, brand, description, price, stock_qty, image_url, status)
                                  VALUES ($category_id, '$nameSafe', '$brandSafe', '$descSafe', $price, $stock_qty, '$imgSafe', '$status')");
            log_activity($conn, 'admin', $_SESSION['admin_id'], $_SESSION['admin_name'], 'CREATE_PRODUCT', "Added new product \"$name\" (stock $stock_qty, price $price)");
            $success = "New product added.";
        }
    }
}

if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE product_id=$edit_id"));
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");
$categoryList = [];
while ($c = mysqli_fetch_assoc($categories)) $categoryList[] = $c;

$products = mysqli_query($conn, "SELECT p.*, c.name AS category_name FROM products p
                                  JOIN categories c ON c.category_id=p.category_id ORDER BY p.updated_at DESC");

require 'includes/header.php';
?>
<h1 class="mb-4">Stocks &amp; Prices</h1>

<?php if ($errors): ?>
  <div class="alert alert-burgundy"><ul class="mb-0"><?php foreach ($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul></div>
<?php endif; ?>
<?php if ($success): ?><div class="alert alert-brass"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

<div class="row g-4">
  <div class="col-lg-4">
    <div class="form-card">
      <h5 class="mb-3"><?php echo $edit_product ? 'Edit Product' : 'Add New Product'; ?></h5>
      <form method="POST">
        <input type="hidden" name="product_id" value="<?php echo $edit_product['product_id'] ?? ''; ?>">
        <div class="mb-2">
          <label class="form-label">Category</label>
          <select name="category_id" class="form-select" required>
            <option value="">-- choose --</option>
            <?php foreach ($categoryList as $c): ?>
              <option value="<?php echo $c['category_id']; ?>" <?php echo (($edit_product['category_id'] ?? '')==$c['category_id'])?'selected':''; ?>>
                <?php echo htmlspecialchars($c['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Product Name</label>
          <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($edit_product['name'] ?? ''); ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Brand</label>
          <input type="text" name="brand" class="form-control" required value="<?php echo htmlspecialchars($edit_product['brand'] ?? 'Alli In House'); ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="2"><?php echo htmlspecialchars($edit_product['description'] ?? ''); ?></textarea>
        </div>
        <div class="row">
          <div class="col-6 mb-2">
            <label class="form-label">Price (₱)</label>
            <input type="number" step="0.01" min="0" name="price" class="form-control" required value="<?php echo htmlspecialchars($edit_product['price'] ?? ''); ?>">
          </div>
          <div class="col-6 mb-2">
            <label class="form-label">Stock Qty</label>
            <input type="number" min="0" name="stock_qty" class="form-control" required value="<?php echo htmlspecialchars($edit_product['stock_qty'] ?? '0'); ?>">
          </div>
        </div>
        <div class="mb-2">
          <label class="form-label">Image path</label>
          <input type="text" name="image_url" class="form-control" placeholder="assets/img/products/xxx.svg" value="<?php echo htmlspecialchars($edit_product['image_url'] ?? ''); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="active" <?php echo (($edit_product['status'] ?? 'active')=='active')?'selected':''; ?>>Active (visible in store)</option>
            <option value="archived" <?php echo (($edit_product['status'] ?? '')=='archived')?'selected':''; ?>>Archived (hidden)</option>
          </select>
        </div>
        <button type="submit" name="save_product" value="1" class="btn btn-brass w-100"><?php echo $edit_product ? 'Save Changes' : 'Add Product'; ?></button>
        <?php if ($edit_product): ?><a href="products.php" class="btn btn-outline-brass w-100 mt-2">Cancel Edit</a><?php endif; ?>
      </form>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="table-responsive">
      <table class="table table-alli align-middle">
        <thead><tr><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th></th></tr></thead>
        <tbody>
          <?php while ($p = mysqli_fetch_assoc($products)): ?>
            <tr>
              <td><?php echo htmlspecialchars($p['name']); ?><br><small style="color:var(--ivory-dim);"><?php echo htmlspecialchars($p['brand']); ?></small></td>
              <td><?php echo htmlspecialchars($p['category_name']); ?></td>
              <td class="price"><?php echo format_price($p['price']); ?></td>
              <td><?php echo $p['stock_qty']; ?><?php if ($p['stock_qty'] <= 5) echo ' <span style="color:#e5738a;">low</span>'; ?></td>
              <td><?php echo $p['status']==='active' ? '<span style="color:#9fd6a3;">Active</span>' : '<span style="color:var(--ivory-dim);">Archived</span>'; ?></td>
              <td><a href="products.php?edit=<?php echo $p['product_id']; ?>" class="btn btn-sm btn-outline-brass">Edit</a></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
