<?php
require '../config/db.php';
require '../includes/functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $usernameSafe = clean($conn, $username);

    $result = mysqli_query($conn, "SELECT * FROM admins WHERE username='$usernameSafe'");
    $admin = mysqli_fetch_assoc($result);

    if (!$admin || !password_verify($password, $admin['password_hash'])) {
        $error = "Invalid username or password.";
    } elseif ($admin['status'] !== 'active') {
        $error = "This admin account has been disabled.";
    } else {
        $_SESSION['admin_id']   = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $_SESSION['admin_role'] = $admin['role'];
        log_activity($conn, 'admin', $admin['admin_id'], $admin['username'], 'LOGIN', 'Admin logged in');
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — Alli In Timepieces</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<section class="band" style="min-height:100vh; display:flex; align-items:center;">
  <div class="container" style="max-width:420px;">
    <div class="text-center mb-4">
      <img src="../assets/img/logo.svg" width="46" height="46" alt="logo">
      <h1 class="mt-2 mb-0">Seller Admin</h1>
      <p style="color:var(--ivory-dim);">Alli In Timepieces</p>
    </div>
    <?php if ($error): ?><div class="alert alert-burgundy"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="POST" class="form-card">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required autofocus>
      </div>
      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-brass w-100">Log In</button>
    </form>
    <p class="text-center mt-3"><a href="../index.php">&larr; Back to website</a></p>
  </div>
</section>
</body>
</html>
