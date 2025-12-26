<?php 
include '../config/database.php';

// Pastikan session aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi akses langsung tanpa login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $user_id         = $_SESSION['user_id'];
    $jenis_transaksi = mysqli_real_escape_string($conn, $_POST['jenis_transaksi']);
    $tanggal         = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $nominal         = mysqli_real_escape_string($conn, $_POST['nominal']);
    $kategori        = mysqli_real_escape_string($conn, $_POST['kategori']);
    $metode          = mysqli_real_escape_string($conn, $_POST['metode']);
    $deskripsi       = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Query Insert ke database
    $sql = "INSERT INTO transaksi (user_id, jenis_transaksi, tanggal, nominal, kategori, metode, deskripsi) 
            VALUES ('$user_id', '$jenis_transaksi', '$tanggal', '$nominal', '$kategori', '$metode', '$deskripsi')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Transaksi Berhasil Dicatat!'); 
                window.location='dashboard.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: tambah_transaksi.php");
    exit();
}
?>