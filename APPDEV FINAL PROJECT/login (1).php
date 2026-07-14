<?php
require '../config/db.php';
require '../includes/functions.php';
require_superadmin();
$page_title = 'Admin Users';

$errors = [];
$success = '';
$edit_admin = null;

// ---- Add or Update admin ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_admin'])) {
    $admin_id  = (int)($_POST['admin_id'] ?? 0);
    $username  = trim($_POST['username'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $role      = ($_POST['role'] ?? 'admin') === 'superadmin' ? 'superadmin' : 'admin';
    $status    = ($_POST['status'] ?? 'active') === 'disabled' ? 'disabled' : 'active';
    $password  = $_POST['password'] ?? '';

    if ($username === '') $errors[] = "Username is required.";
    if ($full_name === '') $errors[] = "Full name is required.";
    if (!$admin_id && strlen($password) < 6) $errors[] = "Password must be at least 6 characters for a new admin.";

    if (!$errors) {
        $usernameSafe = clean($conn, $username);
        $fullNameSafe = clean($conn, $full_name);

        // check unique username (excluding current record)
        $dup = mysqli_query($conn, "SELECT admin_id FROM admins WHERE username='$usernameSafe' AND admin_id != $admin_id");
        if (mysqli_num_rows($dup) > 0) {
            $errors[] = "That username is already taken.";
        } else {
            if ($admin_id) {
                // UPDATE
                $sql = "UPDATE admins SET username='$usernameSafe', full_name='$fullNameSafe', role='$role', status='$status'";
                if (strlen($password) >= 6) {
                    $sql .= ", password_hash='" . password_hash($password, PASSWORD_DEFAULT) . "'";
                }
                $sql .= " WHERE admin_id=$admin_id";
                mysqli_query($conn, $sql);
                log_activity($conn, 'admin', $_SESSION['admin_id'], $_SESSION['admin_name'], 'UPDATE_ADMIN', "Updated admin account \"$username\" (ID $admin_id)");
                $success = "Admin account updated.";
            } else {
                // INSERT
                $hash = password_hash($password, PASSWORD_DEFAULT);
                mysqli_query($conn, "INSERT INTO admins (username, password_hash, full_name, role, status)
                                      VALUES ('$usernameSafe', '$hash', '$fullNameSafe', '$role', '$status')");
                log_activity($conn, 'admin', $_SESSION['admin_id'], $_SESSION['admin_name'], 'CREATE_ADMIN', "Created new admin account \"$username\"");
                $success = "New admin account created.";
            }
        }
    }
}

// ---- Load one admin for editing ----
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admins WHERE admin_id=$edit_id"));
}

$admins = mysqli_query($conn, "SELECT * FROM admins ORDER BY created_at DESC");

require 'includes/header.php';
?>
<h1 class="mb-4">Admin Users</h1>

<?php if ($errors): ?>
  <div class="alert alert-burgundy"><ul class="mb-0"><?php foreach ($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul></div>
<?php endif; ?>
<?php if ($success): ?><div class="alert alert-brass"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

<div class="row g-4">
  <div class="col-lg-4">
    <div class="form-card">
      <h5 class="mb-3"><?php echo $edit_admin ? 'Edit Admin' : 'Add New Admin'; ?></h5>
      <form method="POST">
        <input type="hidden" name="admin_id" value="<?php echo $edit_admin['admin_id'] ?? ''; ?>">
        <div class="mb-2">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required value="<?php echo htmlspecialchars($edit_admin['username'] ?? ''); ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Full Name</label>
          <input type="text" name="full_name" class="form-control" required value="<?php echo htmlspecialchars($edit_admin['full_name'] ?? ''); ?>">
        </div>
        <div class="mb-2">
          <label class="form-label">Password <?php echo $edit_admin ? '(leave blank to keep current)' : ''; ?></label>
          <input type="password" name="password" class="form-control" <?php echo $edit_admin ? '' : 'required'; ?>>
        </div>
        <div class="mb-2">
          <label class="form-label">Role</label>
          <select name="role" class="form-select">
            <option value="admin" <?php echo (($edit_admin['role'] ?? '')=='admin')?'selected':''; ?>>Admin</option>
            <option value="superadmin" <?php echo (($edit_admin['role'] ?? '')=='superadmin')?'selected':''; ?>>Super Admin</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="active" <?php echo (($edit_admin['status'] ?? 'active')=='active')?'selected':''; ?>>Active</option>
            <option value="disabled" <?php echo (($edit_admin['status'] ?? '')=='disabled')?'selected':''; ?>>Disabled</option>
          </select>
        </div>
        <button type="submit" name="save_admin" value="1" class="btn btn-brass w-100"><?php echo $edit_admin ? 'Save Changes' : 'Create Admin'; ?></button>
        <?php if ($edit_admin): ?><a href="users.php" class="btn btn-outline-brass w-100 mt-2">Cancel Edit</a><?php endif; ?>
      </form>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="table-responsive">
      <table class="table table-alli align-middle">
        <thead><tr><th>Username</th><th>Full Name</th><th>Role</th><th>Status</th><th>Created</th><th></th></tr></thead>
        <tbody>
          <?php while ($a = mysqli_fetch_assoc($admins)): ?>
            <tr>
              <td><?php echo htmlspecialchars($a['username']); ?></td>
              <td><?php echo htmlspecialchars($a['full_name']); ?></td>
              <td><span class="category-pill"><?php echo htmlspecialchars($a['role']); ?></span></td>
              <td><?php echo $a['status']==='active' ? '<span style="color:#9fd6a3;">Active</span>' : '<span style="color:#e5738a;">Disabled</span>'; ?></td>
              <td><small><?php echo date('M j, Y', strtotime($a['created_at'])); ?></small></td>
              <td><a href="users.php?edit=<?php echo $a['admin_id']; ?>" class="btn btn-sm btn-outline-brass">Edit</a></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require 'includes/footer.php'; ?>
