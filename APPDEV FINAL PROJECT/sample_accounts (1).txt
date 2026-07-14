<?php
/**
 * RUN THIS FILE ONCE in your browser, right after importing sql/schema.sql,
 * to create the initial Super Admin account with a properly generated
 * password hash. After it works, DELETE this file (or rename it) for security.
 *
 * Seed login created:
 *   username: superadmin
 *   password: Admin@123
 */
require 'config/db.php';

$username  = 'superadmin';
$password  = 'Admin@123';
$full_name = 'System Administrator';
$hash = password_hash($password, PASSWORD_DEFAULT);

$existing = mysqli_query($conn, "SELECT admin_id FROM admins WHERE username='$username'");

if (mysqli_num_rows($existing) > 0) {
    mysqli_query($conn, "UPDATE admins SET password_hash='$hash', status='active', role='superadmin' WHERE username='$username'");
    echo "Superadmin account already existed — password has been reset to Admin@123.";
} else {
    mysqli_query($conn, "INSERT INTO admins (username, password_hash, full_name, role, status)
                          VALUES ('$username', '$hash', '$full_name', 'superadmin', 'active')");
    echo "Superadmin account created successfully.";
}

echo "<br><br><strong>Username:</strong> superadmin<br><strong>Password:</strong> Admin@123";
echo "<br><br>Please delete or rename setup_admin.php now that setup is complete.";
