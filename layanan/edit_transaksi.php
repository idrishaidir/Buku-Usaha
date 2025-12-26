<?php 
include '../config/database.php';

// Proteksi Halaman
if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil ID dari URL dan pastikan datanya ada
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Validasi kepemilikan: Pastikan data yang diedit milik user yang sedang login
    $query = mysqli_query($conn, "SELECT * FROM transaksi WHERE id = '$id' AND user_id = '$user_id'");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Data tidak ditemukan atau akses ditolak!'); window.location='riwayat_transaksi.php';</script>";
        exit();
    }
} else {
    header("Location: riwayat_transaksi.php");
    exit();
}

// Proses Update Data
if (isset($_POST['update'])) {
    $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $nominal   = mysqli_real_escape_string($conn, $_POST['nominal']);
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $metode    = mysqli_real_escape_string($conn, $_POST['metode']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $jenis     = mysqli_real_escape_string($conn, $_POST['jenis_transaksi']);

    $sql_update = "UPDATE transaksi SET 
                    tanggal = '$tanggal', 
                    nominal = '$nominal', 
                    kategori = '$kategori', 
                    metode = '$metode', 
                    deskripsi = '$deskripsi',
                    jenis_transaksi = '$jenis'
                   WHERE id = '$id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Transaksi berhasil diperbarui!'); window.location='transaksi.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Edit Transaksi - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen pb-20">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <div class="mt-10 mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">Edit Transaksi</h1>
                    <p class="text-slate-500 mt-1 text-sm">Perbarui informasi transaksi Anda.</p>
                </div>
                <a href="transaksi.php" class="text-blue-600 font-bold text-sm hover:underline italic">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                </a>
            </div>

            <div class="bg-white rounded-[32px] shadow-xl shadow-blue-100/40 border border-slate-100 overflow-hidden">
                <div class="flex p-2 bg-slate-100 m-6 rounded-2xl">
                    <button id="btn-pengeluaran" type="button" onclick="switchType('pengeluaran')" 
                        class="w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 <?= $data['jenis_transaksi'] == 'pengeluaran' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-500' ?>">
                        <i class="fa-solid fa-arrow-up-from-bracket mr-2"></i> Pengeluaran
                    </button>
                    <button id="btn-pemasukan" type="button" onclick="switchType('pemasukan')" 
                        class="w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 <?= $data['jenis_transaksi'] == 'pemasukan' ? 'bg-white text-green-600 shadow-sm' : 'text-slate-500' ?>">
                        <i class="fa-solid fa-arrow-down-to-bracket mr-2"></i> Pemasukan
                    </button>
                </div>

                <form method="POST" class="p-8 pt-0 space-y-6">
                    <input type="hidden" name="jenis_transaksi" id="jenis_transaksi" value="<?= $data['jenis_transaksi'] ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Tanggal</label>
                            <input type="date" name="tanggal" required value="<?= $data['tanggal'] ?>" 
                                   class="w-full px-4 py-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Nominal (Rp)</label>
                            <input type="number" name="nominal" required value="<?= (int)$data['nominal'] ?>" 
                                   class="w-full px-4 py-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 font-bold text-lg">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Kategori</label>
                        <select name="kategori" required class="w-full px-4 py-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 bg-white">
                            <?php 
                            $kategoris = ['Bahan Baku', 'Operasional', 'Gaji Karyawan', 'Penjualan Produk', 'Lainnya'];
                            foreach ($kategoris as $cat) {
                                $selected = ($data['kategori'] == $cat) ? 'selected' : '';
                                echo "<option value='$cat' $selected>$cat</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Metode</label>
                        <select name="metode" required class="w-full px-4 py-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 bg-white">
                            <option value="Tunai" <?= $data['metode'] == 'Tunai' ? 'selected' : '' ?>>Tunai</option>
                            <option value="Transfer" <?= $data['metode'] == 'Transfer' ? 'selected' : '' ?>>Transfer</option>
                            <option value="E-Wallet" <?= $data['metode'] == 'E-Wallet' ? 'selected' : '' ?>>E-Wallet</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full p-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 text-sm"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                    </div>

                    <button type="submit" name="update" id="submit-btn" 
                        class="w-full <?= $data['jenis_transaksi'] == 'pemasukan' ? 'bg-green-600' : 'bg-red-600' ?> text-white py-5 rounded-2xl font-extrabold text-lg shadow-xl hover:scale-[1.01] transition-all">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function switchType(type) {
            const btnPemasukan = document.getElementById('btn-pemasukan');
            const btnPengeluaran = document.getElementById('btn-pengeluaran');
            const submitBtn = document.getElementById('submit-btn');
            const inputJenis = document.getElementById('jenis_transaksi');

            if (type === 'pemasukan') {
                btnPemasukan.className = "w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-white text-green-600 shadow-sm";
                btnPengeluaran.className = "w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-500 hover:text-red-600";
                submitBtn.classList.replace('bg-red-600', 'bg-green-600');
                inputJenis.value = 'pemasukan';
            } else {
                btnPengeluaran.className = "w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-white text-red-600 shadow-sm";
                btnPemasukan.className = "w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-500 hover:text-green-600";
                submitBtn.classList.replace('bg-green-600', 'bg-red-600');
                inputJenis.value = 'pengeluaran';
            }
        }
    </script>
</body>
</html>