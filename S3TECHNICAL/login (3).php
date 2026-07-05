<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; }
        .box {
            max-width: 400px; margin: 60px auto; background:#fff;
            padding: 25px 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            text-align:center;
        }
        a { color:#c0392b; text-decoration:none; font-weight:bold; }
    </style>
</head>
<body>
<div class="box">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>You are logged in. This page cannot be reached without an active session.</p>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
