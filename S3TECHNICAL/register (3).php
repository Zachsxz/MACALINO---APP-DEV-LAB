<?php
$host   = "localhost";
$dbUser = "root";   // default XAMPP MySQL user
$dbPass = "";       // default XAMPP MySQL password is empty
$dbName = "sa3_db";

$conn = mysqli_connect($host, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
