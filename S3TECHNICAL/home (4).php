<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: home.php');
    exit();
}

$errorMsg = "";
$showResult = false;
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['first_name']  = $_POST['first_name'] ?? '';
    $data['middle_name'] = $_POST['middle_name'] ?? '';
    $data['last_name']   = $_POST['last_name'] ?? '';
    $data['username']    = $_POST['username'] ?? '';
    $data['password']    = $_POST['password'] ?? '';
    $confirmPassword     = $_POST['confirm_password'] ?? '';
    $data['birthday']    = $_POST['birthday'] ?? '';
    $data['email']       = $_POST['email'] ?? '';
    $data['contact']     = $_POST['contact'] ?? '';

    if ($data['password'] !== $confirmPassword) {
        $errorMsg = "password and confirm password are not the same";
    } else {
        $showResult = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; }
        .form-container {
            max-width: 420px; margin: 40px auto; background:#fff;
            padding: 25px 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        h2 { text-align:center; }
        label { display:block; margin-top: 12px; font-weight:bold; color:#333; }
        input[type=text], input[type=password], input[type=email] {
            width: 100%; padding: 8px; margin-top: 4px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;
        }
        button {
            width:100%; margin-top:20px; padding:10px; background:#4CAF50; color:#fff;
            border:none; border-radius:4px; cursor:pointer; font-size:16px;
        }
        button:hover { background:#45a049; }
        .footer { text-align:center; margin-top:10px; color:#777; }
        .error { color:#c0392b; text-align:center; font-weight:bold; }
        .result { margin-top:20px; padding:15px; background:#eafaf1; border-radius:6px; }
        .result p { margin:4px 0; }
        a { display:block; text-align:center; margin-top:10px; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>My Personal Information</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label>First Name</label>
        <input type="text" name="first_name" required>

        <label>Middle Name</label>
        <input type="text" name="middle_name">

        <label>Last Name</label>
        <input type="text" name="last_name" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <label>Birthday</label>
        <input type="text" name="birthday" placeholder="e.g. January 30 1993" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Contact Number</label>
        <input type="text" name="contact" required>

        <button type="submit">Submit</button>
    </form>
    <p class="footer">&copy; Crix Brix</p>

    <?php if ($errorMsg): ?>
        <p class="error"><?php echo htmlspecialchars($errorMsg); ?></p>
    <?php endif; ?>

    <?php if ($showResult): ?>
        <div class="result">
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($data['username']); ?></p>
            <p><strong>Password:</strong> <?php echo htmlspecialchars($data['password']); ?></p>
            <p><strong>Birthday:</strong> <?php echo htmlspecialchars($data['birthday']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($data['contact']); ?></p>
        </div>
    <?php endif; ?>

    <a href="login.php">Already registered? Login here</a>
</div>
</body>
</html>
