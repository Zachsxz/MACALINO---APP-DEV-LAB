<?php
/**
 * Database connection.
 * EDIT THESE 4 VALUES to match your hosting (e.g. InfinityFree) credentials.
 */
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "alli_timepieces";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

// Start session for every page that includes this file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
