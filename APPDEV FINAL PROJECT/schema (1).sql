<?php
require 'config/db.php';
require 'includes/functions.php';
$__base = '';
$page_title = 'About';
require 'includes/header.php';
?>

<section class="band">
  <div class="container">
    <div class="eyebrow mb-2">About Us</div>
    <h1 class="mb-4">Alli In Timepieces</h1>
    <div class="row">
      <div class="col-lg-7">
        <p style="color:var(--ivory-dim);">
          Alli In Timepieces is a student-built e-commerce concept centered on luxury and
          fashion-accessory watches. The brand imagines a small, design-led watch house
          that sources movements from established manufacturers and finishes every case,
          dial, and strap in-house, favouring quiet, long-lasting design over seasonal trends.
        </p>
        <p style="color:var(--ivory-dim);">
          This website was developed entirely with core PHP (no PHP framework), MySQL,
          and Bootstrap for layout/styling, as the final project requirement for our
          Web Development / Systems Integration course. It demonstrates a two-sided
          e-commerce system: a <strong>seller/admin side</strong> for inventory, staff accounts
          and reporting, and a <strong>buyer side</strong> for registration, browsing, cart,
          checkout and payment.
        </p>
      </div>
      <div class="col-lg-5">
        <div class="form-card">
          <h5 class="mb-3">Project Facts</h5>
          <ul class="list-unstyled mb-0" style="color:var(--ivory-dim); font-size:.92rem;">
            <li class="mb-2"><strong style="color:var(--brass-light);">Category:</strong> Luxury / Fashion Timepieces</li>
            <li class="mb-2"><strong style="color:var(--brass-light);">Backend:</strong> Core PHP + MySQLi</li>
            <li class="mb-2"><strong style="color:var(--brass-light);">Frontend:</strong> Bootstrap 5, custom CSS</li>
            <li class="mb-0"><strong style="color:var(--brass-light);">Purpose:</strong> Educational final project only</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<hr class="divider">

<section class="band">
  <div class="container">
    <h2 class="mb-4">Meet Group 5</h2>
    <div class="row g-4">
      <?php
      $members = [
        ['name'=>'Juan Dela Cruz', 'role'=>'Project Lead / Backend Development', 'blurb'=>'Handled PHP page logic, session/auth, and the checkout & payment flow.'],
        ['name'=>'Maria Santos',   'role'=>'Database Design', 'blurb'=>'Designed the schema, relationships, and audit-log structure.'],
        ['name'=>'Pedro Reyes',    'role'=>'Frontend / UI Design', 'blurb'=>'Built the visual identity, Bootstrap layout, and responsive styling.'],
        ['name'=>'Ana Lim',        'role'=>'QA & Documentation', 'blurb'=>'Tested all forms and flows, wrote the submission documentation.'],
      ];
      foreach ($members as $m): ?>
        <div class="col-md-3 col-sm-6">
          <div class="card card-alli text-center p-3">
            <div class="mx-auto mb-3" style="width:64px;height:64px;border-radius:50%;background:var(--onyx);border:1px solid var(--brass); display:flex;align-items:center;justify-content:center;">
              <span class="display-font" style="font-size:1.4rem;color:var(--brass-light);"><?php echo strtoupper(substr($m['name'],0,1)); ?></span>
            </div>
            <h5 class="mb-1"><?php echo htmlspecialchars($m['name']); ?></h5>
            <div style="color:var(--brass); font-size:.75rem; text-transform:uppercase; letter-spacing:.08em;" class="mb-2"><?php echo htmlspecialchars($m['role']); ?></div>
            <p style="color:var(--ivory-dim); font-size:.85rem;" class="mb-0"><?php echo htmlspecialchars($m['blurb']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
