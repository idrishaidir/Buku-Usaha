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
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_transaksi = mysqli_real_escape_string($conn, $_GET['id']);

    // 3. Keamanan Berlapis: Pastikan transaksi yang dihapus adalah milik user yang login
    // Ini mencegah User A menghapus transaksi User B hanya dengan menebak ID di URL
    $check_owner = mysqli_query($conn, "SELECT id FROM transaksi WHERE id = '$id_transaksi' AND user_id = '$user_id'");

    if (mysqli_num_rows($check_owner) === 1) {
        // 4. Jalankan perintah hapus jika validasi kepemilikan sukses
        $sql_delete = "DELETE FROM transaksi WHERE id = '$id_transaksi' AND user_id = '$user_id'";
        
        if (mysqli_query($conn, $sql_delete)) {
            echo "<script>
                    alert('Transaksi berhasil dihapus.');
                    window.location.href = 'transaksi.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menghapus transaksi: " . mysqli_error($conn) . "');
                    window.location.href = 'transaksi.php';
                  </script>";
        }
    } else {
        // Jika ID ditemukan tapi bukan milik user tersebut, atau ID tidak ada
        echo "<script>
                alert('Akses ditolak atau data tidak ditemukan!');
                window.location.href = 'transaksi.php';
              </script>";
    }
} else {
    // Jika tidak ada ID yang dikirim
    header("Location: transaksi.php");
    exit();
}
?>