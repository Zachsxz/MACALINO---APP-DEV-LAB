<?php
require 'config/db.php';
require 'includes/functions.php';
$__base = '';
$page_title = 'Register';

$errors = [];
$old = ['full_name'=>'','email'=>'','address'=>'','contact_number'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name       = trim($_POST['full_name'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $password        = $_POST['password'] ?? '';
    $confirm_password= $_POST['confirm_password'] ?? '';
    $address         = trim($_POST['address'] ?? '');
    $contact_number  = trim($_POST['contact_number'] ?? '');

    $old = compact('full_name','email','address','contact_number');

    // ---- Server-side validation (plain PHP, no library) ----
    if ($full_name === '') $errors[] = "Complete name is required.";
    if ($email === '') {
        $errors[] = "Email address is required.";
    } elseif (!is_valid_email($email)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
    if ($password !== $confirm_password) $errors[] = "Password and Confirm Password do not match.";
    if ($address === '') $errors[] = "Complete address is required.";
    if ($contact_number === '') {
        $errors[] = "Contact number is required.";
    } elseif (!preg_match('/^[0-9+\-\s()]{7,20}$/', $contact_number)) {
        $errors[] = "Please enter a valid contact number.";
    }

    // Check duplicate email
    if (!$errors) {
        $emailSafe = clean($conn, $email);
        $check = mysqli_query($conn, "SELECT customer_id FROM customers WHERE email = '$emailSafe'");
        if (mysqli_num_rows($check) > 0) {
            $errors[] = "An account with that email already exists. Please log in instead.";
        }
    }

    if (!$errors) {
        $full_name_safe = clean($conn, $full_name);
        $email_safe      = clean($conn, $email);
        $address_safe    = clean($conn, $address);
        $contact_safe    = clean($conn, $contact_number);
        $password_hash   = password_hash($password, PASSWORD_DEFAULT);
        $token           = bin2hex(random_bytes(24));

        $sql = "INSERT INTO customers (full_name, email, password_hash, address, contact_number, is_confirmed, confirm_token)
                VALUES ('$full_name_safe', '$email_safe', '$password_hash', '$address_safe', '$contact_safe', 0, '$token')";

        if (mysqli_query($conn, $sql)) {
            $customer_id = mysqli_insert_id($conn);
            log_activity($conn, 'customer', $customer_id, $email, 'REGISTER', 'New account registered, awaiting email confirmation');

            // ---- Send confirmation email (core PHP mail()) ----
            $confirm_link = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']
                . dirname($_SERVER['PHP_SELF']) . '/confirm.php?token=' . $token;

            $subject = "Confirm your Alli In Timepieces account";
            $message = "Hi $full_name,\n\nThank you for registering at Alli In Timepieces.\n"
                     . "Please confirm your email by clicking the link below:\n\n$confirm_link\n\n"
                     . "If you did not create this account, you may ignore this email.\n\n"
                     . "— Alli In Timepieces (educational project)";
            $headers = "From: no-reply@alli-timepieces.local";
            @mail($email, $subject, $message, $headers); // best-effort; see note on-screen below

            $_SESSION['just_registered_link'] = $confirm_link; // shown on-screen as a fallback for testing
            header("Location: register.php?sent=1");
            exit;
        } else {
            $errors[] = "Registration failed: " . mysqli_error($conn);
        }
    }
}

require 'includes/header.php';
?>

<section class="band">
  <div class="container" style="max-width:640px;">
    <div class="eyebrow mb-2">Join Alli In Timepieces</div>
    <h1 class="mb-4">Create your account</h1>

    <?php if (isset($_GET['sent'])): ?>
      <div class="alert alert-brass">
        <strong>Almost done!</strong> We've sent a confirmation link to your email address.
        Please check your inbox (and spam folder) and click the link to activate your account.
        <?php if (!empty($_SESSION['just_registered_link'])): ?>
          <hr>
          <small>Testing on localhost / free hosting without SMTP? Use this link directly:<br>
          <a href="<?php echo htmlspecialchars($_SESSION['just_registered_link']); ?>"><?php echo htmlspecialchars($_SESSION['just_registered_link']); ?></a></small>
          <?php unset($_SESSION['just_registered_link']); ?>
        <?php endif; ?>
      </div>
      <div class="text-center"><a href="login.php" class="btn btn-brass">Go to Login</a></div>
    <?php else: ?>

      <?php if ($errors): ?>
        <div class="alert alert-burgundy">
          <ul class="mb-0">
            <?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST" class="form-card" novalidate>
        <div class="mb-3">
          <label class="form-label">Complete Name</label>
          <input type="text" name="full_name" class="form-control" required value="<?php echo htmlspecialchars($old['full_name']); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($old['email']); ?>">
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" required minlength="6">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Complete Address</label>
          <textarea name="address" class="form-control" rows="2" required><?php echo htmlspecialchars($old['address']); ?></textarea>
        </div>
        <div class="mb-4">
          <label class="form-label">Contact Number</label>
          <input type="text" name="contact_number" class="form-control" required placeholder="e.g. 09171234567" value="<?php echo htmlspecialchars($old['contact_number']); ?>">
        </div>
        <button type="submit" class="btn btn-brass w-100">Create Account</button>
        <p class="text-center mt-3 mb-0" style="font-size:.85rem;color:var(--ivory-dim);">
          Already have an account? <a href="login.php">Log in</a>
        </p>
      </form>

    <?php endif; ?>
  </div>
</section>

<?php require 'includes/footer.php'; ?>