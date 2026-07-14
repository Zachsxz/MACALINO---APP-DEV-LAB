<?php
require '../config/db.php';
require '../includes/functions.php';

if (isset($_SESSION['admin_id'])) {
    log_activity($conn, 'admin', $_SESSION['admin_id'], $_SESSION['admin_name'], 'LOGOUT', 'Admin logged out');
}
session_unset();
session_destroy();
header("Location: login.php");
exit;
