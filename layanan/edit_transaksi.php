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
// Proses Update Data di layanan/edit_transaksi.php
if (isset($_POST['update'])) {
    $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $nominal   = mysqli_real_escape_string($conn, $_POST['nominal']);
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $metode    = mysqli_real_escape_string($conn, $_POST['metode']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $jenis     = mysqli_real_escape_string($conn, $_POST['jenis_transaksi']);
    
    // Default gunakan bukti lama
    $bukti_final = $data['bukti_transaksi'];

    // Cek apakah user mengunggah file baru
    if (isset($_FILES['bukti_transaksi']) && $_FILES['bukti_transaksi']['error'] === 0) {
        $target_dir = "uploads/";
        
        // Buat folder jika belum ada (antisipasi)
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $nama_file = $_FILES['bukti_transaksi']['name'];
        $tmp_name  = $_FILES['bukti_transaksi']['tmp_name'];
        $ekstensi  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $ekstensi_valid = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($ekstensi, $ekstensi_valid)) {
            $nama_file_baru = uniqid() . "." . $ekstensi;
            $target_file = $target_dir . $nama_file_baru;

            if (move_uploaded_file($tmp_name, $target_file)) {
                // Hapus file bukti lama dari folder jika ada file baru yang masuk
                if (!empty($data['bukti_transaksi']) && file_exists($target_dir . $data['bukti_transaksi'])) {
                    unlink($target_dir . $data['bukti_transaksi']);
                }
                $bukti_final = $nama_file_baru; // Update variabel untuk database
            }
        }
    }

    $sql_update = "UPDATE transaksi SET 
                    tanggal = '$tanggal', 
                    nominal = '$nominal', 
                    kategori = '$kategori', 
                    metode = '$metode', 
                    deskripsi = '$deskripsi',
                    jenis_transaksi = '$jenis',
                    bukti_transaksi = '$bukti_final'
                   WHERE id = '$id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Transaksi berhasil diperbarui!'); window.location='riwayat_transaksi.php';</script>";
    } else {
        echo "Error database: " . mysqli_error($conn);
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
<body class="bg-[#F8FAFC] text-slate-900">

    <div class="flex min-h-screen">
        <?php include 'side_navbar.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <div class="mb-10 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Transaksi</h1>
                    <p class="text-slate-500 text-sm mt-1">Perbarui detail informasi umum dan lampiran bukti transaksi Anda.</p>
                </div>
                <a href="riwayat_transaksi.php" class="text-blue-600 font-bold text-sm hover:underline">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Riwayat
                </a>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="jenis_transaksi" id="jenis_transaksi" value="<?= $data['jenis_transaksi'] ?>">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-2 mb-8 text-blue-600">
                                <i class="fa-solid fa-file-lines"></i>
                                <h3 class="font-bold uppercase tracking-widest text-xs">Informasi Umum</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Tanggal Transaksi</label>
                                    <input type="date" name="tanggal" required value="<?= $data['tanggal'] ?>" 
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Jenis Transaksi</label>
                                    <div class="flex p-1 bg-slate-100 rounded-xl">
                                        <button type="button" onclick="switchType('pengeluaran')" id="btn-out" 
                                                class="flex-1 py-2 px-4 rounded-lg text-sm font-bold transition <?= $data['jenis_transaksi'] == 'pengeluaran' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-500' ?>">
                                            Pengeluaran
                                        </button>
                                        <button type="button" onclick="switchType('pemasukan')" id="btn-in" 
                                                class="flex-1 py-2 px-4 rounded-lg text-sm font-bold transition <?= $data['jenis_transaksi'] == 'pemasukan' ? 'bg-white text-green-600 shadow-sm' : 'text-slate-500' ?>">
                                            Pemasukan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Kategori</label>
                                    <select name="kategori" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
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
                                    <label class="text-sm font-semibold text-slate-700">Metode Pembayaran</label>
                                    <select name="metode" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                                        <option value="Tunai" <?= $data['metode'] == 'Tunai' ? 'selected' : '' ?>>Tunai</option>
                                        <option value="Transfer" <?= $data['metode'] == 'Transfer' ? 'selected' : '' ?>>Transfer</option>
                                        <option value="E-Wallet" <?= $data['metode'] == 'E-Wallet' ? 'selected' : '' ?>>E-Wallet</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2 mb-6">
                                <label class="text-sm font-semibold text-slate-700">Nominal (Rp)</label>
                                <input type="number" name="nominal" required value="<?= (int)$data['nominal'] ?>" 
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition font-bold text-lg text-slate-800">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Deskripsi / Memo</label>
                                <textarea name="deskripsi" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-sm"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" name="update" id="submit-btn" 
                                    class="w-full md:w-auto px-10 py-4 rounded-2xl font-extrabold shadow-xl transition duration-300 <?= $data['jenis_transaksi'] == 'pemasukan' ? 'bg-green-600 shadow-green-200' : 'bg-red-600 shadow-red-200' ?> text-white hover:scale-[1.02] active:scale-95">
                                Simpan Perubahan <i class="fa-solid fa-paper-plane ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-2 mb-8 text-slate-500">
                                <i class="fa-solid fa-paperclip"></i>
                                <h3 class="font-bold uppercase tracking-widest text-xs">Bukti Transaksi</h3>
                            </div>

                            <?php if(!empty($data['bukti_transaksi'])): ?>
                            <div class="mb-4 text-center">
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-2">Bukti Saat Ini:</p>
                                <div class="inline-block p-2 border border-slate-100 rounded-xl">
                                    <?php 
                                    $ext = strtolower(pathinfo($data['bukti_transaksi'], PATHINFO_EXTENSION));
                                    if($ext == 'pdf'): ?>
                                        <a href="uploads/<?= $data['bukti_transaksi'] ?>" target="_blank" class="text-red-500 text-3xl">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </a>
                                    <?php else: ?>
                                        <img src="uploads/<?= $data['bukti_transaksi'] ?>" class="h-20 rounded-lg shadow-sm">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="relative group cursor-pointer border-2 border-dashed border-slate-200 rounded-[24px] p-8 text-center hover:border-blue-500 hover:bg-blue-50/50 transition duration-300">
                                <input type="file" name="bukti_transaksi" accept="image/*,.pdf" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewFile(event)">
                                <div id="preview-container" class="space-y-4">
                                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto group-hover:bg-blue-100 group-hover:text-blue-600 transition">
                                        <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Ganti Bukti Transaksi</p>
                                        <p class="text-[11px] text-slate-400 mt-1 uppercase font-bold tracking-tighter">PDF / JPG / PNG (Maks 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            <div id="file-name" class="mt-4 text-xs font-semibold text-blue-600 hidden text-center"></div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-[24px] border border-blue-100">
                            <h4 class="text-xs font-extrabold text-blue-600 uppercase mb-2">Tips Edit</h4>
                            <p class="text-[11px] text-blue-500 leading-relaxed italic">
                                Anda dapat memperbarui bukti transaksi dengan mengunggah file baru. File lama akan otomatis tergantikan.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
        function switchType(type) {
            const btnIn = document.getElementById('btn-in');
            const btnOut = document.getElementById('btn-out');
            const submitBtn = document.getElementById('submit-btn');
            const inputJenis = document.getElementById('jenis_transaksi');

            if (type === 'pemasukan') {
                btnIn.className = "flex-1 py-2 px-4 rounded-lg text-sm font-bold transition bg-white text-green-600 shadow-sm";
                btnOut.className = "flex-1 py-2 px-4 rounded-lg text-sm font-bold transition text-slate-500 hover:text-red-600";
                submitBtn.classList.remove('bg-red-600', 'shadow-red-200');
                submitBtn.classList.add('bg-green-600', 'shadow-green-200');
                inputJenis.value = 'pemasukan';
            } else {
                btnOut.className = "flex-1 py-2 px-4 rounded-lg text-sm font-bold transition bg-white text-red-600 shadow-sm";
                btnIn.className = "flex-1 py-2 px-4 rounded-lg text-sm font-bold transition text-slate-500 hover:text-green-600";
                submitBtn.classList.remove('bg-green-600', 'shadow-green-200');
                submitBtn.classList.add('bg-red-600', 'shadow-red-200');
                inputJenis.value = 'pengeluaran';
            }
        }

        function previewFile(event) {
            const fileNameDisplay = document.getElementById('file-name');
            const file = event.target.files[0];
            if (file) {
                fileNameDisplay.innerText = "File baru dipilih: " + file.name;
                fileNameDisplay.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>