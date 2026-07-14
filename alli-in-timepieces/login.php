<?php
require 'config/db.php';
require 'includes/functions.php';
$__base = '';
$page_title = 'Login';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Please enter both email and password.";
    } else {
        $emailSafe = clean($conn, $email);
        $result = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$emailSafe'");
        $user = mysqli_fetch_assoc($result);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $error = "Invalid email or password.";
        } elseif (!$user['is_confirmed']) {
            $error = "Please confirm your email address before logging in. Check your inbox for the confirmation link.";
        } else {
            $_SESSION['customer_id']   = $user['customer_id'];
            $_SESSION['customer_name'] = $user['full_name'];
            log_activity($conn, 'customer', $user['customer_id'], $user['email'], 'LOGIN', 'Customer logged in');
            header("Location: store.php");
            exit;
        }
    }
}

require 'includes/header.php';
?>
<section class="band">
  <div class="container" style="max-width:460px;">
    <div class="eyebrow mb-2">Welcome Back</div>
    <h1 class="mb-4">Log In</h1>

    <?php if ($error): ?>
      <div class="alert alert-burgundy"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" class="form-card">
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-brass w-100">Log In</button>
      <p class="text-center mt-3 mb-0" style="font-size:.85rem;color:var(--ivory-dim);">
        No account yet? <a href="register.php">Register here</a>
      </p>
    </form>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
