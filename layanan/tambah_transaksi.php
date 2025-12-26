<?php 
include '../config/database.php';

// Proteksi Halaman
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
        .input-focus:focus-within { border-color: #2563eb; ring: 2px; ring-color: #dbeafe; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen pb-20">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <?php include 'side_navbar.php'; ?>
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900">Catat Transaksi</h1>
                    <p class="text-slate-500 mt-1 text-sm">Input data harian dengan teliti untuk laporan yang akurat.</p>
                </div>
                <a href="layanan.php" class="text-blue-600 font-bold text-sm hover:underline italic">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

            <div class="bg-white rounded-[32px] shadow-xl shadow-blue-100/40 border border-slate-100 overflow-hidden">
                
                <div class="flex p-2 bg-slate-100 m-6 rounded-2xl">
                    <button id="btn-pengeluaran" onclick="switchType('pengeluaran')" class="w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-white text-red-600 shadow-sm">
                        <i class="fa-solid fa-arrow-up-from-bracket mr-2"></i> Pengeluaran
                    </button>
                    <button id="btn-pemasukan" onclick="switchType('pemasukan')" class="w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-500 hover:text-green-600">
                        <i class="fa-solid fa-arrow-down-to-bracket mr-2"></i> Pemasukan
                    </button>
                </div>

                <form action="proses_transaksi.php" method="POST" class="p-8 pt-0 space-y-6">
                    <input type="hidden" name="jenis_transaksi" id="jenis_transaksi" value="pengeluaran">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Tanggal Transaksi</label>
                            <div class="relative group input-focus border border-slate-200 rounded-2xl overflow-hidden transition-all">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400"><i class="fa-solid fa-calendar-day"></i></span>
                                <input type="date" name="tanggal" required class="w-full pl-11 pr-4 py-4 outline-none text-slate-700 bg-white">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Nominal (Rp)</label>
                            <div class="relative group input-focus border border-slate-200 rounded-2xl overflow-hidden transition-all">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 font-bold italic">Rp</span>
                                <input type="number" name="nominal" placeholder="0" required class="w-full pl-11 pr-4 py-4 outline-none text-slate-700 font-bold text-lg">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-400">Kategori</label>
                            <button type="button" class="text-[10px] font-bold text-blue-600 hover:underline">+ KATEGORI BARU</button>
                        </div>
                        <div class="relative group input-focus border border-slate-200 rounded-2xl overflow-hidden transition-all">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400"><i class="fa-solid fa-tags"></i></span>
                            <select name="kategori" required class="w-full pl-11 pr-4 py-4 outline-none text-slate-700 bg-white appearance-none">
                                <option value="">Pilih Kategori--</option>
                                <option value="Bahan Baku">Bahan Baku</option>
                                <option value="Operasional">Operasional</option>
                                <option value="Gaji Karyawan">Gaji Karyawan</option>
                                <option value="Penjualan Produk">Penjualan Produk</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="metode" value="Tunai" class="hidden peer" checked>
                                <div class="p-3 text-center border border-slate-200 rounded-xl peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                    <i class="fa-solid fa-money-bill-wave block mb-1"></i>
                                    <span class="text-[10px] font-bold uppercase">Tunai</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="metode" value="Transfer" class="hidden peer">
                                <div class="p-3 text-center border border-slate-200 rounded-xl peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all text-slate-500">
                                    <i class="fa-solid fa-university block mb-1"></i>
                                    <span class="text-[10px] font-bold uppercase">Transfer</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="metode" value="E-Wallet" class="hidden peer">
                                <div class="p-3 text-center border border-slate-200 rounded-xl peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all text-slate-500">
                                    <i class="fa-solid fa-mobile-screen block mb-1"></i>
                                    <span class="text-[10px] font-bold uppercase">E-Wallet</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400 ml-1">Deskripsi / Catatan (Opsional)</label>
                        <textarea name="deskripsi" rows="3" placeholder="Contoh: Beli tepung terigu 50kg" class="w-full p-4 border border-slate-200 rounded-2xl outline-none focus:border-blue-500 transition-all text-sm"></textarea>
                    </div>

                    <button type="submit" name="simpan" id="submit-btn" class="w-full bg-red-600 text-white py-5 rounded-2xl font-extrabold text-lg shadow-xl shadow-red-100 hover:scale-[1.01] active:scale-95 transition-all duration-300">
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
                submitBtn.className = submitBtn.className.replace('bg-red-600', 'bg-green-600').replace('shadow-red-100', 'shadow-green-100');
                inputJenis.value = 'pemasukan';
            } else {
                btnPengeluaran.className = "w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 bg-white text-red-600 shadow-sm";
                btnPemasukan.className = "w-1/2 py-3 rounded-xl font-bold text-sm transition-all duration-300 text-slate-500 hover:text-green-600";
                submitBtn.className = submitBtn.className.replace('bg-green-600', 'bg-red-600').replace('shadow-green-100', 'shadow-red-100');
                inputJenis.value = 'pengeluaran';
            }
        }
    </script>
</body>
</html>