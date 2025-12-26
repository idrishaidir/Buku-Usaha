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
    if (isset($_FILES['bukti_transaksi']) && $_FILES['bukti_transaksi']['error'] === 0) {
        $nama_file   = $_FILES['bukti_transaksi']['name'];
        $tmp_name    = $_FILES['bukti_transaksi']['tmp_name'];
        $ukuran_file = $_FILES['bukti_transaksi']['size'];
        
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'pdf'];
        $ekstensi       = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if (in_array($ekstensi, $ekstensi_valid) && $ukuran_file <= 2000000) {
            // Buat folder otomatis jika belum ada
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            $bukti_final = uniqid() . "." . $ekstensi;
            move_uploaded_file($tmp_name, 'uploads/' . $bukti_final);
        }
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