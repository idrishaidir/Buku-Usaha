<?php 
// Pastikan koneksi database benar
include '../config/database.php'; 

// Periksa apakah session sudah dimulai di database.php, jika belum:
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi akses
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

    // Inisialisasi variabel bukti
    $bukti_final = "";

    // Logika Upload File
    // Bagian Logika Upload File di layanan/proses_transaksi.php
    if (isset($_FILES['bukti_transaksi']) && $_FILES['bukti_transaksi']['error'] === 0) {
        $nama_file   = $_FILES['bukti_transaksi']['name'];
        $tmp_name    = $_FILES['bukti_transaksi']['tmp_name'];
        $ukuran_file = $_FILES['bukti_transaksi']['size'];
        
        // 1. Validasi Ekstensi
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'pdf'];
        $ekstensi       = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        // 2. Validasi MIME Type (Lebih Aman)
        $finfo      = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type  = finfo_file($finfo, $tmp_name);
        $mime_valid = ['image/jpeg', 'image/png', 'application/pdf'];

        // 3. Cek apakah ekstensi, MIME, dan ukuran (maks 2MB) sesuai
        if (in_array($ekstensi, $ekstensi_valid) && in_array($mime_type, $mime_valid) && $ukuran_file <= 2000000) {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            $bukti_final = uniqid() . "." . $ekstensi;
            move_uploaded_file($tmp_name, 'uploads/' . $bukti_final);
        } else {
            echo "<script>alert('Format file tidak didukung atau ukuran terlalu besar!'); window.history.back();</script>";
            exit();
        }
        finfo_close($finfo);
    }

    // Gunakan query yang sesuai dengan struktur tabel Anda
    $sql = "INSERT INTO transaksi (user_id, jenis_transaksi, tanggal, nominal, kategori, metode, deskripsi, bukti_transaksi) 
            VALUES ('$user_id', '$jenis_transaksi', '$tanggal', '$nominal', '$kategori', '$metode', '$deskripsi', '$bukti_final')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Transaksi Berhasil Dicatat!'); window.location='dashboard.php';</script>";
    } else {
        // Jika error database, ini akan memunculkan pesan alih-alih Error 500
        die("Kesalahan Database: " . mysqli_error($conn));
    }
} else {
    header("Location: tambah_transaksi.php");
    exit();
}
?>