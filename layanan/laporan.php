<?php 
include '../config/database.php';

// Proteksi Halaman
if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nama_usaha = $_SESSION['nama_usaha'];

// Logika Filter (Default bulan berjalan)
$bulan_ini = date('m');
$tahun_ini = date('Y');

// Simulasi Query Agregat (Ganti dengan tabel asli Anda)
// $query_pemasukan = mysqli_query($conn, "SELECT SUM(nominal) as total FROM transaksi WHERE user_id = '$user_id' AND jenis_transaksi = 'pemasukan'");
// $total_pemasukan = mysqli_fetch_assoc($query_pemasukan)['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Laporan Keuangan - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900">

    <div class="flex min-h-screen">
        <?php include 'side_navbar.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <header class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Analisis Laporan Keuangan</h1>
                    <p class="text-slate-500 mt-1">Data real-time berdasarkan aktivitas transaksi Anda.</p>
                </div>
                
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex bg-white p-1 rounded-2xl border border-slate-200 shadow-sm">
                        <input type="month" value="<?= date('Y-m') ?>" class="px-4 py-2 text-sm font-bold bg-transparent outline-none text-slate-700">
                    </div>
                    <button onclick="window.print()" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-2xl font-bold text-sm text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <i class="fa-solid fa-print"></i> Cetak
                    </button>
                    <button class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-blue-200 hover:scale-[1.02] transition">
                        <i class="fa-solid fa-file-export"></i> Export Excel
                    </button>
                </div>
            </header>

            <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="glass-card p-8 rounded-[32px] border border-white shadow-xl shadow-blue-100/20 relative overflow-hidden group">
                    <div class="relative z-10">
                        <span class="text-xs font-bold text-green-600 uppercase tracking-widest bg-green-50 px-3 py-1 rounded-full">Total Pemasukan</span>
                        <h3 class="text-3xl font-extrabold text-slate-900 mt-4">Rp 24.500.000</h3>
                        <p class="text-slate-400 text-xs mt-2"><i class="fa-solid fa-arrow-up mr-1 text-green-500"></i> +12% dari bulan lalu</p>
                    </div>
                    <i class="fa-solid fa-chart-line absolute -right-4 -bottom-4 text-7xl text-slate-50 opacity-50 group-hover:scale-110 transition-transform"></i>
                </div>

                <div class="glass-card p-8 rounded-[32px] border border-white shadow-xl shadow-blue-100/20 relative overflow-hidden group">
                    <div class="relative z-10">
                        <span class="text-xs font-bold text-red-600 uppercase tracking-widest bg-red-50 px-3 py-1 rounded-full">Total Pengeluaran</span>
                        <h3 class="text-3xl font-extrabold text-slate-900 mt-4">Rp 10.200.000</h3>
                        <p class="text-slate-400 text-xs mt-2"><i class="fa-solid fa-arrow-down mr-1 text-red-500"></i> -5% dari bulan lalu</p>
                    </div>
                    <i class="fa-solid fa-money-bill-transfer absolute -right-4 -bottom-4 text-7xl text-slate-50 opacity-50"></i>
                </div>

                <div class="bg-slate-900 p-8 rounded-[32px] shadow-2xl shadow-blue-200 relative overflow-hidden group">
                    <div class="relative z-10">
                        <span class="text-xs font-bold text-blue-400 uppercase tracking-widest bg-white/10 px-3 py-1 rounded-full">Laba Bersih</span>
                        <h3 class="text-3xl font-extrabold text-white mt-4">Rp 14.300.000</h3>
                        <div class="w-full bg-white/10 h-1.5 rounded-full mt-4">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: 58%"></div>
                        </div>
                    </div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/20 rounded-full blur-3xl"></div>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-list text-blue-600"></i> Rincian Transaksi Periode Ini
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50">
                                <tr class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em]">
                                    <th class="px-8 py-4">Tanggal</th>
                                    <th class="px-4 py-4">Kategori</th>
                                    <th class="px-4 py-4 text-right">Nominal</th>
                                    <th class="px-8 py-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-8 py-5 text-sm font-medium text-slate-600">24 Des 2025</td>
                                    <td class="px-4 py-5 font-bold text-slate-800">Bahan Baku</td>
                                    <td class="px-4 py-5 text-right font-extrabold text-red-600">- Rp 1.500.000</td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-3 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-bold uppercase">Berhasil</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-8 py-5 text-sm font-medium text-slate-600">23 Des 2025</td>
                                    <td class="px-4 py-5 font-bold text-slate-800">Penjualan Retail</td>
                                    <td class="px-4 py-5 text-right font-extrabold text-green-600">+ Rp 4.250.000</td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="px-3 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-bold uppercase">Berhasil</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
                        <h4 class="font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-pie-chart text-purple-600"></i> Alokasi Pengeluaran
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1">
                                    <span class="text-slate-500">OPERASIONAL</span>
                                    <span>45%</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-blue-600 h-full" style="width: 45%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1">
                                    <span class="text-slate-500">GAJI KARYAWAN</span>
                                    <span>35%</span>
                                </div>
                                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-600 h-full" style="width: 35%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-600 to-purple-700 p-8 rounded-[32px] text-white shadow-xl shadow-blue-200">
                        <h4 class="font-bold text-lg mb-2">Butuh Bantuan Analisis?</h4>
                        <p class="text-blue-100 text-sm mb-6 leading-relaxed">Tim ahli kami siap membantu Anda membaca laporan keuangan lebih mendalam via WhatsApp.</p>
                        <a href="kontak.php" class="inline-block w-full text-center py-3 bg-white text-blue-600 rounded-2xl font-bold hover:bg-blue-50 transition">Chat Konsultan</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>