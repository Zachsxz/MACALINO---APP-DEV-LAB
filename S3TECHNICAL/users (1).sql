<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

// Fetch current user's info
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

$errorMsg = "";
$successMsg = "";

// Handle Reset Password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $currentPassword  = $_POST['current_password'] ?? '';
    $newPassword      = $_POST['new_password'] ?? '';
    $reenterPassword  = $_POST['reenter_password'] ?? '';

    if (!password_verify($currentPassword, $user['password'])) {
        $errorMsg = "Current password is not the same with the old password";
    } elseif ($newPassword !== $reenterPassword) {
        $errorMsg = "New password and Re-Enter new password should be the same";
    } else {
        $hashedNew = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE id = ?");
        mysqli_stmt_bind_param($updateStmt, "si", $hashedNew, $_SESSION['user_id']);
        mysqli_stmt_execute($updateStmt);

        $successMsg = "Password reset successfully!";
        // refresh $user with new hash so subsequent checks in same request are consistent
        $user['password'] = $hashedNew;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Information Form</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; }
        .box {
            max-width: 420px; margin: 40px auto; background:#fff;
            padding: 25px 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            position: relative;
        }
        h2 { margin-top:0; }
        .logout { position:absolute; top:25px; right:30px; color:#2980b9; text-decoration:none; font-weight:bold; }
        hr { margin: 20px 0; border:none; border-top:1px solid #ddd; }
        label { display:block; margin-top: 12px; font-weight:bold; color:#333; }
        input[type=password] {
            width: 100%; padding: 8px; margin-top: 4px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;
        }
        button {
            width:100%; margin-top:20px; padding:10px; background:#e67e22; color:#fff;
            border:none; border-radius:4px; cursor:pointer; font-size:16px;
        }
        button:hover { background:#ca6f1e; }
        .footer { text-align:center; margin-top:15px; color:#777; }
        .error { color:#c0392b; text-align:center; font-weight:bold; }
        .success { color:#27ae60; text-align:center; font-weight:bold; }
    </style>
</head>
<body>
<div class="box">
    <a href="logout.php" class="logout">Log-out</a>
    <h2>User Information Form</h2>
    <p><strong>Welcome</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name']); ?></p>
    <p><strong>Birthday:</strong> <?php echo htmlspecialchars($user['birthday']); ?></p>
    <p><strong>Contact Details</strong><br>
       &nbsp;&nbsp;<strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?><br>
       &nbsp;&nbsp;<strong>Contact:</strong> <?php echo htmlspecialchars($user['contact_number']); ?></p>

    <hr>
    <h3 style="margin-bottom:0;">RESET PASSWORD</h3>

    <?php if ($errorMsg): ?>
        <p class="error"><?php echo htmlspecialchars($errorMsg); ?></p>
    <?php endif; ?>
    <?php if ($successMsg): ?>
        <p class="success"><?php echo htmlspecialchars($successMsg); ?></p>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label>Enter Current Password:</label>
        <input type="password" name="current_password" required>

        <label>Enter New Password:</label>
        <input type="password" name="new_password" required>

        <label>Re-Enter New Password:</label>
        <input type="password" name="reenter_password" required>

        <button type="submit" name="reset_password">Reset Password</button>
    </form>
    <p class="footer">&copy; Crix Brix</p>
</div>
</body>
</html>
