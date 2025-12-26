<?php 
include '../config/database.php';

// Proteksi Halaman: Hanya user login yang bisa masuk
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SElayananSSION['user_id'];
$nama_usaha = $_SESSION['nama_usaha'];

// Contoh pengambilan summary data dari database (Logika SQL)
// $query = mysqli_query($conn, "SELECT SUM(nominal) as total FROM transaksi WHERE user_id = '$user_id' AND tipe = 'pemasukan'");
// $pemasukan = mysqli_fetch_assoc($query)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Dashboard UMKM - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900">

    <div class="flex min-h-screen">
        <?php include 'side_navbar.php'; ?>

        <main class="flex-1 p-6 lg:p-10 overflow-y-auto">
            <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900">Selamat datang, <?= htmlspecialchars($nama_usaha) ?>! 👋</h1>
                    <p class="text-slate-500 text-sm mt-1">Ini ringkasan kondisi bisnis Anda bulan ini.</p>
                </div>
                <div class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="px-4 py-1.5 text-xs font-bold bg-slate-100 rounded-xl text-slate-600 uppercase tracking-wider">Desember 2025</span>
                </div>
            </header>

            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-arrow-down"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Total Pemasukan</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">Rp 12.500.000</h3>
                </div>
                <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-arrow-up"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Total Pengeluaran</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">Rp 4.200.000</h3>
                </div>
                <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm bg-gradient-to-br from-blue-600 to-purple-700 text-white">
                    <div class="w-12 h-12 bg-white/20 text-white rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <p class="text-sm font-medium opacity-80">Saldo Akhir</p>
                    <h3 class="text-2xl font-extrabold mt-1">Rp 8.300.000</h3>
                </div>
                <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-500">Jumlah Transaksi</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">42 Kali</h3>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="font-bold text-slate-800">Transaksi Terbaru</h3>
                        <a href="layanan.php" class="text-xs font-bold text-blue-600 hover:underline tracking-widest uppercase">Lihat Semua</a>
                    </div>
                    <div class="p-6">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-slate-400 text-xs font-bold uppercase tracking-wider">
                                    <th class="pb-4">Tanggal</th>
                                    <th class="pb-4">Kategori</th>
                                    <th class="pb-4 text-right">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <tr class="group hover:bg-slate-50 transition-colors">
                                    <td class="py-4 text-sm text-slate-600">26 Des 2025</td>
                                    <td class="py-4 font-bold text-slate-800">Penjualan Produk</td>
                                    <td class="py-4 text-right font-extrabold text-green-600">+ Rp 450.000</td>
                                </tr>
                                <tr class="group hover:bg-slate-50 transition-colors">
                                    <td class="py-4 text-sm text-slate-600">25 Des 2025</td>
                                    <td class="py-4 font-bold text-slate-800">Biaya Listrik</td>
                                    <td class="py-4 text-right font-extrabold text-red-600">- Rp 150.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm">
                        <h3 class="font-bold text-slate-800 mb-6">Aksi Cepat</h3>
                        <div class="grid grid-cols-1 gap-3">
                            <a href="tambah_transaksi.php" class="flex items-center justify-center gap-2 w-full py-4 bg-blue-600 text-white rounded-2xl font-bold hover:scale-[1.02] transition shadow-lg shadow-blue-200">
                                <i class="fa-solid fa-plus"></i> Tambah Transaksi
                            </a>
                            <a href="#" class="flex items-center justify-center gap-2 w-full py-4 bg-slate-50 text-slate-700 rounded-2xl font-bold hover:bg-slate-100 transition">
                                <i class="fa-solid fa-file-invoice-dollar"></i> Cetak Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>