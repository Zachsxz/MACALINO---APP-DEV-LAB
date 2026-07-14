<?php
require '../config/db.php';
require '../includes/functions.php';
require_admin_login();
$page_title = 'Audit Log';

// By default show ONLY the currently logged in admin's activity (as required).
// A toggle lets a superadmin view everyone's activity too.
$scope = $_GET['scope'] ?? 'mine';
$isSuperadmin = ($_SESSION['admin_role'] === 'superadmin');
if ($scope === 'all' && !$isSuperadmin) $scope = 'mine';

if ($scope === 'all') {
    $logs = mysqli_query($conn, "SELECT * FROM audit_log ORDER BY created_at DESC LIMIT 300");
} else {
    $uid = (int)$_SESSION['admin_id'];
    $logs = mysqli_query($conn, "SELECT * FROM audit_log WHERE user_type='admin' AND user_id=$uid ORDER BY created_at DESC LIMIT 300");
}

require 'includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <h1 class="mb-0">Audit Log</h1>
  <div>
    <a href="reports_audit.php?scope=mine" class="btn btn-sm <?php echo $scope=='mine'?'btn-brass':'btn-outline-brass'; ?>">My Activity</a>
    <?php if ($isSuperadmin): ?>
      <a href="reports_audit.php?scope=all" class="btn btn-sm <?php echo $scope=='all'?'btn-brass':'btn-outline-brass'; ?>">All Admins (Super Admin)</a>
    <?php endif; ?>
  </div>
</div>
<p style="color:var(--ivory-dim);">
  This report shows all recorded actions for
  <?php echo $scope=='all' ? 'every admin account' : 'the account currently logged in (' . htmlspecialchars($_SESSION['admin_name']) . ')'; ?>.
</p>

<div class="table-responsive">
  <table class="table table-alli align-middle">
    <thead><tr><th>Date / Time</th><th>User</th><th>Type</th><th>Action</th><th>Details</th><th>IP</th></tr></thead>
    <tbody>
      <?php $count = 0; while ($l = mysqli_fetch_assoc($logs)): $count++; ?>
        <tr>
          <td><small><?php echo date('M j, Y g:i:s A', strtotime($l['created_at'])); ?></small></td>
          <td><?php echo htmlspecialchars($l['username']); ?></td>
          <td><span class="category-pill"><?php echo htmlspecialchars($l['user_type']); ?></span></td>
          <td><?php echo htmlspecialchars($l['action']); ?></td>
          <td><small><?php echo htmlspecialchars($l['details']); ?></small></td>
          <td><small><?php echo htmlspecialchars($l['ip_address']); ?></small></td>
        </tr>
      <?php endwhile; ?>
      <?php if ($count === 0): ?>
        <tr><td colspan="6" class="text-center" style="color:var(--ivory-dim);">No activity recorded yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php require 'includes/footer.php'; ?>
