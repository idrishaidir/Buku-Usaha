<?php 
include '../config/database.php';

// 1. Pastikan session aktif dan user sudah login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Validasi parameter ID transaksi
// Perbaikan pada layanan/hapus_transaksi.php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_transaksi = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // 1. Ambil nama file bukti sebelum data dihapus
    $query_file = mysqli_query($conn, "SELECT bukti_transaksi FROM transaksi WHERE id = '$id_transaksi' AND user_id = '$user_id'");
    $data_file  = mysqli_fetch_assoc($query_file);

    if ($data_file) {
        // 2. Jika ada file bukti, hapus dari folder uploads
        if (!empty($data_file['bukti_transaksi'])) {
            $path_file = "uploads/" . $data_file['bukti_transaksi'];
            if (file_exists($path_file)) {
                unlink($path_file); // Menghapus file fisik
            }
        }

        // 3. Jalankan perintah hapus data di database
        $sql_delete = "DELETE FROM transaksi WHERE id = '$id_transaksi' AND user_id = '$user_id'";
        
        if (mysqli_query($conn, $sql_delete)) {
            echo "<script>alert('Transaksi dan file bukti berhasil dihapus.'); window.location.href = 'riwayat_transaksi.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data.'); window.location.href = 'riwayat_transaksi.php';</script>";
        }
    } else {
        echo "<script>alert('Akses ditolak!'); window.location.href = 'riwayat_transaksi.php';</script>";
    }
} else {
    // Jika tidak ada ID yang dikirim
    header("Location: transaksi.php");
    exit();
}
?>