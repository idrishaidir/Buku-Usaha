<?php 
include '../config/database.php';

// Proteksi Halaman
if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Catat Transaksi - BukuUsaha.id</title>
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
                    <h1 class="text-3xl font-extrabold text-slate-900">Catat Transaksi</h1>
                    <p class="text-slate-500 mt-1 text-sm">Input data harian dengan teliti untuk laporan yang akurat.</p>
                </div>
                <a href="dashboard.php" class="text-blue-600 font-bold text-sm hover:underline italic">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white rounded-[32px] shadow-xl shadow-blue-100/40 border border-slate-100 overflow-hidden">
                <div class="flex p-2 bg-slate-100 m-6 rounded-2xl">
                    <button id="btn-pengeluaran" type="button" onclick="switchType('pengeluaran')" class="w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-white text-red-600 shadow-sm">
                        <i class="fa-solid fa-arrow-up-from-bracket mr-2"></i> Pengeluaran
                    </button>
                    <button id="btn-pemasukan" type="button" onclick="switchType('pemasukan')" class="w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-500 hover:text-green-600">
                        <i class="fa-solid fa-arrow-down-to-bracket mr-2"></i> Pemasukan
                    </button>
                </div>

                <form action="proses_transaksi.php" method="POST" class="p-8 pt-0 space-y-6">
                    <input type="hidden" name="jenis_transaksi" id="jenis_transaksi" value="pengeluaran">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Tanggal Transaksi</label>
                            <input type="date" name="tanggal" required value="<?= date('Y-m-d') ?>" class="w-full px-4 py-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Nominal (Rp)</label>
                            <input type="number" name="nominal" placeholder="0" required class="w-full px-4 py-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 font-bold text-lg">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Kategori</label>
                        <select name="kategori" required class="w-full px-4 py-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 bg-white">
                            <option value="">Pilih Kategori--</option>
                            <option value="Bahan Baku">Bahan Baku</option>
                            <option value="Operasional">Operasional</option>
                            <option value="Gaji Karyawan">Gaji Karyawan</option>
                            <option value="Penjualan Produk">Penjualan Produk</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Metode Pembayaran</label>
                        <select name="metode" required class="w-full px-4 py-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 bg-white">
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" rows="3" placeholder="Contoh: Beli bahan baku mingguan" class="w-full p-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 text-sm"></textarea>
                    </div>

                    <button type="submit" name="simpan" id="submit-btn" class="w-full bg-red-600 text-white py-5 rounded-2xl font-extrabold text-lg shadow-xl hover:scale-[1.01] active:scale-95 transition-all">
                        Simpan Transaksi
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
                submitBtn.classList.remove('bg-red-600');
                submitBtn.classList.add('bg-green-600');
                inputJenis.value = 'pemasukan';
            } else {
                btnPengeluaran.className = "w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-white text-red-600 shadow-sm";
                btnPemasukan.className = "w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-500 hover:text-green-600";
                submitBtn.classList.remove('bg-green-600');
                submitBtn.classList.add('bg-red-600');
                inputJenis.value = 'pengeluaran';
            }
        }
    </script>
</body>
</html>