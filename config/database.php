<?php
$host = "localhost";
$user = "root";
$pass = "admin123";
$db   = "bukuusaha_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>