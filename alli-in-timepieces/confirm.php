<?php
require 'config/db.php';
require 'includes/functions.php';
$__base = '';
$page_title = 'Confirm Account';

$status = 'invalid';
$token = clean($conn, $_GET['token'] ?? '');

if ($token !== '') {
    $result = mysqli_query($conn, "SELECT customer_id, full_name, is_confirmed FROM customers WHERE confirm_token = '$token'");
    if ($row = mysqli_fetch_assoc($result)) {
        if ($row['is_confirmed']) {
            $status = 'already';
        } else {
            mysqli_query($conn, "UPDATE customers SET is_confirmed = 1, confirm_token = NULL WHERE customer_id = " . (int)$row['customer_id']);
            log_activity($conn, 'customer', $row['customer_id'], $row['full_name'], 'EMAIL_CONFIRMED', 'Customer confirmed email address');
            $status = 'confirmed';
        }
    }
}

require 'includes/header.php';
?>
<section class="band">
  <div class="container text-center" style="max-width:560px;">
    <?php if ($status === 'confirmed'): ?>
      <div class="alert alert-brass">
        <h4 class="mb-2">Email confirmed!</h4>
        <p class="mb-0">Your account is now active. You may log in and start shopping.</p>
      </div>
      <a href="login.php" class="btn btn-brass mt-3">Log In</a>
    <?php elseif ($status === 'already'): ?>
      <div class="alert alert-brass">Your account was already confirmed. You may log in.</div>
      <a href="login.php" class="btn btn-brass mt-3">Log In</a>
    <?php else: ?>
      <div class="alert alert-burgundy">This confirmation link is invalid or has expired.</div>
      <a href="register.php" class="btn btn-outline-brass mt-3">Back to Registration</a>
    <?php endif; ?>
  </div>
</section>
<?php require 'includes/footer.php'; ?>
