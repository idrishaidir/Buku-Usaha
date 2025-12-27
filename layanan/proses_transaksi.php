<?php 
include '../config/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $user_id         = $_SESSION['user_id'];
    $jenis_transaksi = mysqli_real_escape_string($conn, $_POST['jenis_transaksi']);
    $tanggal         = mysqli_real_escape_string($conn, $_POST['tanggal']);
    
    $nominal_mentah  = $_POST['nominal']; 
    $nominal         = str_replace('.', '', $nominal_mentah); 
    $nominal         = mysqli_real_escape_string($conn, $nominal);

    $kategori        = mysqli_real_escape_string($conn, $_POST['kategori']);
    $metode          = mysqli_real_escape_string($conn, $_POST['metode']);
    $deskripsi       = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $bukti_final = "";

    if (isset($_FILES['bukti_transaksi']) && $_FILES['bukti_transaksi']['error'] === 0) {
        $nama_file   = $_FILES['bukti_transaksi']['name'];
        $tmp_name    = $_FILES['bukti_transaksi']['tmp_name'];
        $ukuran_file = $_FILES['bukti_transaksi']['size'];
        
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'pdf'];
        $ekstensi       = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        $finfo      = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type  = finfo_file($finfo, $tmp_name);
        $mime_valid = ['image/jpeg', 'image/png', 'application/pdf'];

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

    $sql = "INSERT INTO transaksi (user_id, jenis_transaksi, tanggal, nominal, kategori, metode, deskripsi, bukti_transaksi) 
            VALUES ('$user_id', '$jenis_transaksi', '$tanggal', '$nominal', '$kategori', '$metode', '$deskripsi', '$bukti_final')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Transaksi Berhasil Dicatat!'); window.location='tambah_transaksi.php';</script>";
    } else {
        die("Kesalahan Database: " . mysqli_error($conn));
    }
} else {
    header("Location: tambah_transaksi.php");
    exit();
}
?>