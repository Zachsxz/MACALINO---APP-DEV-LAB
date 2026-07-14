<?php
$__current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($page_title) ? $page_title . ' — Admin — Alli In Timepieces' : 'Admin — Alli In Timepieces'; ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Jost:wght@300;400;500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="d-flex">
  <div class="admin-sidebar" style="width:230px;">
    <div class="brand-mark mb-4">
      <img src="../assets/img/logo.svg" width="30" height="30" alt="logo">
      <span style="font-size:1.15rem;">Alli Admin</span>
    </div>
    <a href="index.php" class="<?php echo $__current=='index.php'?'active':''; ?>">Dashboard</a>
    <a href="users.php" class="<?php echo $__current=='users.php'?'active':''; ?>">Admin Users</a>
    <a href="products.php" class="<?php echo $__current=='products.php'?'active':''; ?>">Stocks &amp; Prices</a>
    <a href="reports_inventory.php" class="<?php echo $__current=='reports_inventory.php'?'active':''; ?>">Inventory Report</a>
    <a href="reports_audit.php" class="<?php echo $__current=='reports_audit.php'?'active':''; ?>">Audit Log</a>
    <hr class="divider my-3">
    <a href="../index.php">View Website</a>
    <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['admin_name'] ?? ''); ?>)</a>
  </div>
  <div class="flex-grow-1">
    <div class="container-fluid py-4 px-4">
