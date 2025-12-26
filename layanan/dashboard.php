<?php 
include '../config/database.php';

// Proteksi Halaman
if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nama_usaha = $_SESSION['nama_usaha'];
$bulan_ini = date('Y-m');

// 1. LOGIKA REKAP & GRAFIK (Bulan Ini)
$total_masuk = 0;
$total_keluar = 0;
$data_harian = [];

$query_rekap = mysqli_query($conn, "SELECT DATE(tanggal) as tgl, jenis_transaksi, SUM(nominal) as total 
                                    FROM transaksi 
                                    WHERE user_id = '$user_id' AND tanggal LIKE '$bulan_ini%' 
                                    GROUP BY tgl, jenis_transaksi");

while($rekap = mysqli_fetch_assoc($query_rekap)) {
    $tgl = $rekap['tgl'];
    $jenis = $rekap['jenis_transaksi'];
    $nominal = (float)$rekap['total'];

    if($jenis == 'pemasukan') {
        $total_masuk += $nominal;
        $data_harian[$tgl]['masuk'] = $nominal;
    } else {
        $total_keluar += $nominal;
        $data_harian[$tgl]['keluar'] = $nominal;
    }
}

// Persiapan data Chart.js
$labels_grafik = [];
$data_masuk_grafik = [];
$data_keluar_grafik = [];
$jumlah_hari = date('t');

for ($i = 1; $i <= $jumlah_hari; $i++) {
    $tgl_cek = date('Y-m-') . str_pad($i, 2, '0', STR_PAD_LEFT);
    $labels_grafik[] = $i; 
    $data_masuk_grafik[] = $data_harian[$tgl_cek]['masuk'] ?? 0;
    $data_keluar_grafik[] = $data_harian[$tgl_cek]['keluar'] ?? 0;
}

// 2. Ambil 5 Transaksi Terbaru
$query_terbaru = mysqli_query($conn, "SELECT * FROM transaksi WHERE user_id = '$user_id' ORDER BY tanggal DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Dashboard - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC]">

    <div class="flex min-h-screen">
        <?php include 'side_navbar.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Halo, <?= htmlspecialchars($nama_usaha) ?>! 👋</h1>
                <p class="text-slate-500 mt-1 text-sm">Ini adalah ringkasan performa bisnismu bulan ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pemasukan</p>
                        <h3 class="text-xl font-black text-slate-800">Rp <?= number_format($total_masuk, 0, ',', '.') ?></h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm flex items-center gap-5">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pengeluaran</p>
                        <h3 class="text-xl font-black text-slate-800">Rp <?= number_format($total_keluar, 0, ',', '.') ?></h3>
                    </div>
                </div>

                <div class="bg-blue-600 p-6 rounded-[24px] shadow-lg shadow-blue-100 flex items-center gap-5 text-white">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-xl">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest">Saldo Akhir</p>
                        <h3 class="text-xl font-black">Rp <?= number_format($total_masuk - $total_keluar, 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
                        <h3 class="font-bold text-slate-800 text-lg mb-6">Tren Arus Kas (Bulan Ini)</h3>
                        <div class="h-[300px]">
                            <canvas id="dashboardChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-slate-50">
                            <h3 class="font-bold text-slate-800">Transaksi Terbaru</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <tbody class="divide-y divide-slate-50">
                                    <?php if(mysqli_num_rows($query_terbaru) > 0): ?>
                                        <?php while($row = mysqli_fetch_assoc($query_terbaru)): ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4 text-xs text-slate-500"><?= date('d M', strtotime($row['tanggal'])) ?></td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-bold text-slate-800"><?= htmlspecialchars($row['kategori']) ?></div>
                                                <div class="text-[10px] text-slate-400"><?= htmlspecialchars($row['deskripsi']) ?></div>
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-black <?= $row['jenis_transaksi'] == 'pemasukan' ? 'text-green-600' : 'text-red-600' ?>">
                                                <?= $row['jenis_transaksi'] == 'pemasukan' ? '+' : '-' ?> Rp <?= number_format($row['nominal'], 0, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td class="p-10 text-center text-slate-400 text-sm">Belum ada data.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-slate-900 p-8 rounded-[32px] text-white">
                        <h3 class="font-bold mb-4">Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="tambah_transaksi.php" class="block w-full text-center bg-blue-600 py-3 rounded-xl font-bold text-sm transition hover:bg-blue-500">
                                <i class="fa-solid fa-plus mr-2"></i> Tambah Transaksi
                            </a>
                            <a href="riwayat_transaksi.php" class="block w-full text-center bg-white/10 py-3 rounded-xl font-bold text-sm transition hover:bg-white/20">
                                <i class="fa-solid fa-receipt mr-2"></i> Riwayat Transaksi
                            </a>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm">
                        <h4 class="font-bold text-slate-800 mb-4 text-sm">Persentase Arus</h4>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex-1 bg-slate-100 h-2 rounded-full overflow-hidden">
                                <?php 
                                    $total_semua = $total_masuk + $total_keluar;
                                    $persen_masuk = $total_semua > 0 ? ($total_masuk / $total_semua) * 100 : 0;
                                ?>
                                <div class="bg-green-500 h-full" style="width: <?= $persen_masuk ?>%"></div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400"><?= round($persen_masuk) ?>%</span>
                        </div>
                        <p class="text-[10px] text-slate-400 italic">*Pemasukan dibandingkan total volume transaksi</p>
                    </div>
                </div>

                
            </div>
        </main>
    </div>

    <script>
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels_grafik) ?>,
            datasets: [
                {
                    label: 'Masuk',
                    data: <?= json_encode($data_masuk_grafik) ?>,
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Keluar',
                    data: <?= json_encode($data_keluar_grafik) ?>,
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220, 38, 38, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false } }
            }
        }
    });
    </script>
</body>
</html>