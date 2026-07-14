<?php
/**
 * Shared helper functions used across the buyer + seller pages.
 */

// ---------------------------------------------------------------
// Basic input cleaning (plain PHP, no framework)
// ---------------------------------------------------------------
function clean($conn, $value) {
    $value = trim($value);
    $value = stripslashes($value);
    return mysqli_real_escape_string($conn, $value);
}

function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// ---------------------------------------------------------------
// AUDIT LOG - records every action of whoever is currently logged in
// ---------------------------------------------------------------
function log_activity($conn, $user_type, $user_id, $username, $action, $details = '') {
    $user_type = mysqli_real_escape_string($conn, $user_type);
    $user_id   = (int)$user_id;
    $username  = mysqli_real_escape_string($conn, $username);
    $action    = mysqli_real_escape_string($conn, $action);
    $details   = mysqli_real_escape_string($conn, $details);
    $ip        = mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR'] ?? 'unknown');

    $sql = "INSERT INTO audit_log (user_type, user_id, username, action, details, ip_address)
            VALUES ('$user_type', $user_id, '$username', '$action', '$details', '$ip')";
    mysqli_query($conn, $sql);
}

// ---------------------------------------------------------------
// AUTH GUARDS
// ---------------------------------------------------------------
function require_customer_login() {
    if (!isset($_SESSION['customer_id'])) {
        header("Location: login.php");
        exit;
    }
}

function require_admin_login() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit;
    }
}

function require_superadmin() {
    require_admin_login();
    if (($_SESSION['admin_role'] ?? '') !== 'superadmin') {
        die("Access denied. Only a Super Admin can manage admin accounts.");
    }
}

// ---------------------------------------------------------------
// Cart helpers
// ---------------------------------------------------------------
function cart_count($conn, $customer_id) {
    $result = mysqli_query($conn, "SELECT SUM(quantity) AS total FROM cart_items WHERE customer_id = " . (int)$customer_id);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ? (int)$row['total'] : 0;
}

function format_price($amount) {
    return '₱' . number_format($amount, 2);
}
