<?php
require 'config/db.php';
require 'includes/functions.php';
$__base = '';
$page_title = 'Home';
require 'includes/header.php';

$featured = mysqli_query($conn, "SELECT * FROM products WHERE status='active' ORDER BY product_id LIMIT 3");
?>

<section class="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="eyebrow mb-3">The Alli In Timepieces Collection</div>
        <h1>Time, worn<br>quietly well.</h1>
        <p class="lead-text mt-3">Every Alli watch is built around a single idea: a timepiece should
          disappear into your day and only ever announce itself in the details — the sweep of a
          second hand, the weight of a clasp, the light on a sapphire crystal.</p>
        <div class="mt-4">
          <a href="store.php" class="btn btn-brass me-2">Browse The Store</a>
          <a href="about.php" class="btn btn-outline-brass">Our Story</a>
        </div>
      </div>
      <div class="col-lg-6 text-center mt-5 mt-lg-0">
        <svg class="watch-face" width="300" height="300" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
          <circle cx="150" cy="150" r="140" fill="#101215" stroke="#b08d57" stroke-width="2"/>
          <circle cx="150" cy="150" r="115" fill="none" stroke="#2b2d32" stroke-width="1"/>
          <?php for ($i=0; $i<12; $i++): $angle = $i * 30; ?>
            <line x1="150" y1="40" x2="150" y2="55" stroke="#b08d57" stroke-width="2"
              transform="rotate(<?php echo $angle; ?> 150 150)"/>
          <?php endfor; ?>
          <text x="150" y="150" text-anchor="middle" font-family="Cormorant Garamond, serif" font-size="20" fill="#f3eee4" dy="-40" letter-spacing="3">ALLI</text>
        </svg>
        <g>
        <svg width="0" height="0"><line class="watch-hand-hour"/></svg>
        </g>
      </div>
    </div>
  </div>
</section>

<section class="band">
  <div class="container">
    <div class="d-flex justify-content-between align-items-end mb-4">
      <h2>Featured Pieces</h2>
      <a href="store.php" class="text-uppercase" style="font-size:.8rem; letter-spacing:.1em;">View full store &rarr;</a>
    </div>
    <div class="row g-4">
      <?php while ($p = mysqli_fetch_assoc($featured)): ?>
        <div class="col-md-4">
          <div class="card card-alli">
            <img src="<?php echo htmlspecialchars($p['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="card-body">
              <h5 class="card-title mb-1"><?php echo htmlspecialchars($p['name']); ?></h5>
              <p class="mb-2" style="color:var(--ivory-dim); font-size:.85rem;"><?php echo htmlspecialchars($p['brand']); ?></p>
              <div class="price"><?php echo format_price($p['price']); ?></div>
              <a href="store.php" class="btn btn-outline-brass btn-sm mt-3">View In Store</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
