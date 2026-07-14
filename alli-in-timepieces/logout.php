<?php
require 'config/db.php';
require 'includes/functions.php';

if (isset($_SESSION['customer_id'])) {
    log_activity($conn, 'customer', $_SESSION['customer_id'], $_SESSION['customer_name'], 'LOGOUT', 'Customer logged out');
}
session_unset();
session_destroy();
header("Location: login.php");
exit;
