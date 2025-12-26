<?php 
include '../config/database.php';

// Proteksi Halaman
if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nama_usaha = $_SESSION['nama_usaha'];

// Ambil data filter
$bulan_filter = isset($_GET['bulan']) ? mysqli_real_escape_string($conn, $_GET['bulan']) : date('Y-m');
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query Data untuk Tabel
$query_sql = "SELECT * FROM transaksi WHERE user_id = '$user_id' AND tanggal LIKE '$bulan_filter%'";
if ($search) $query_sql .= " AND (kategori LIKE '%$search%' OR deskripsi LIKE '%$search%')";
$query_sql .= " ORDER BY tanggal ASC";
$result = mysqli_query($conn, $query_sql);

// Hitung Total untuk Laporan PDF
$total_masuk = 0;
$total_keluar = 0;
$rekap_query = mysqli_query($conn, "SELECT jenis_transaksi, SUM(nominal) as total FROM transaksi WHERE user_id = '$user_id' AND tanggal LIKE '$bulan_filter%' GROUP BY jenis_transaksi");
while($rekap = mysqli_fetch_assoc($rekap_query)) {
    if($rekap['jenis_transaksi'] == 'pemasukan') $total_masuk = $rekap['total'];
    else $total_keluar = $rekap['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Riwayat Transaksi - <?= htmlspecialchars($nama_usaha) ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Tampilan Khusus PDF (Hanya aktif saat Print/Export) */
        @media print {
            /* Sembunyikan semua elemen website asli */
            .no-print, aside, nav, button, .filter-box, .action-col { display: none !important; }
            
            /* Reset Layout untuk PDF */
            body { background: white !important; padding: 0; margin: 0; color: black; }
            .print-container { width: 100% !important; margin: 0 !important; padding: 0 !important; display: block !important; }
            
            /* Header Formal ala Akuntansi */
            .pdf-only { display: block !important; }
            .pdf-header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 30px; }
            .pdf-header h1 { font-size: 24pt; font-weight: 800; margin: 0; }
            .pdf-header p { font-size: 10pt; margin: 5px 0; color: #444; }

            /* Tabel Formal */
            .pdf-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            .pdf-table th { border-top: 2px solid black; border-bottom: 2px solid black; padding: 10px; text-align: left; text-transform: uppercase; font-size: 10pt; }
            .pdf-table td { border-bottom: 1px solid #eee; padding: 10px; font-size: 10pt; }
            .pdf-table .row-bold { font-weight: bold; background: #f9f9f9 !important; -webkit-print-color-adjust: exact; }
            .pdf-table .row-total { border-top: 2px solid black; border-bottom: 2px solid black; font-weight: 800; }
            
            .text-right { text-align: right; }
            .pdf-footer { display: flex !important; justify-content: flex-end; margin-top: 50px; }
        }

        /* Sembunyikan elemen PDF di tampilan Browser */
        .pdf-only { display: none; }
    </style>
</head>
<body class="bg-[#F8FAFC]">

    <div class="flex min-h-screen print-container">
        <div class="no-print">
            <?php include 'side_navbar.php'; ?>
        </div>

        <main class="flex-1 p-6 lg:p-10">
            <div class="no-print">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Transaksi</h1>
                        <p class="text-slate-500 text-sm mt-1">Kelola data keuangan usaha Anda.</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="window.print()" class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl font-bold hover:bg-slate-50 transition shadow-sm">
                            <i class="fa-solid fa-file-pdf mr-2 text-red-500"></i> Export PDF
                        </button>
                        <a href="tambah_transaksi.php" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            <i class="fa-solid fa-plus text-sm"></i> Transaksi Baru
                        </a>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-[24px] border border-slate-100 shadow-sm mb-8 filter-box">
                    <form method="GET" class="flex flex-col md:flex-row gap-4">
                        <input type="month" name="bulan" value="<?= $bulan_filter ?>" class="px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none text-sm font-semibold text-slate-600">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari transaksi..." class="flex-1 px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none text-sm">
                        <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-xl font-bold text-sm">Filter</button>
                    </form>
                </div>
            </div>

            <div class="pdf-only">
                <div class="pdf-header">
                    <h1>LAPORAN ARUS KAS</h1>
                    <p class="font-bold"><?= strtoupper(htmlspecialchars($nama_usaha)) ?></p>
                    <p>Periode: <?= date('F Y', strtotime($bulan_filter)) ?></p>
                </div>

                <table class="pdf-table">
                    <thead>
                        <tr>
                            <th>Keterangan Akun</th>
                            <th class="text-right">Nilai (IDR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row-bold"><td colspan="2">Pemasukan Operasional</td></tr>
                        <?php 
                        mysqli_data_seek($result, 0);
                        while($row = mysqli_fetch_assoc($result)): 
                            if($row['jenis_transaksi'] == 'pemasukan'): ?>
                            <tr>
                                <td style="padding-left: 30px;"><?= htmlspecialchars($row['kategori']) ?> (<?= htmlspecialchars($row['deskripsi']) ?>)</td>
                                <td class="text-right"><?= number_format($row['nominal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endif; endwhile; ?>
                        <tr class="row-bold">
                            <td>Total Pemasukan</td>
                            <td class="text-right"><?= number_format($total_masuk, 0, ',', '.') ?></td>
                        </tr>

                        <tr class="row-bold"><td colspan="2" style="padding-top: 20px;">Pengeluaran Operasional</td></tr>
                        <?php 
                        mysqli_data_seek($result, 0);
                        while($row = mysqli_fetch_assoc($result)): 
                            if($row['jenis_transaksi'] == 'pengeluaran'): ?>
                            <tr>
                                <td style="padding-left: 30px;"><?= htmlspecialchars($row['kategori']) ?> (<?= htmlspecialchars($row['deskripsi']) ?>)</td>
                                <td class="text-right">(<?= number_format($row['nominal'], 0, ',', '.') ?>)</td>
                            </tr>
                        <?php endif; endwhile; ?>
                        <tr class="row-bold">
                            <td>Total Pengeluaran</td>
                            <td class="text-right">(<?= number_format($total_keluar, 0, ',', '.') ?>)</td>
                        </tr>

                        <tr class="row-total">
                            <td style="padding: 15px 10px;">SALDO AKHIR KAS</td>
                            <td class="text-right" style="padding: 15px 10px;">Rp <?= number_format($total_masuk - $total_keluar, 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="pdf-footer">
                    <div style="text-align: center; width: 200px;">
                        <p>Pemilik Usaha,</p>
                        <div style="height: 60px;"></div>
                        <p class="font-bold border-t border-black pt-1"><?= htmlspecialchars($nama_usaha) ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden no-print">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 border-b border-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase">Tanggal</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase">Info</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase text-right">Nominal</th>
                            <th class="px-6 py-5 text-[11px] font-bold text-slate-400 uppercase text-center">Bukti</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php 
                        mysqli_data_seek($result, 0);
                        while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-500"><?= date('d/m/y', strtotime($row['tanggal'])) ?></td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800"><?= htmlspecialchars($row['kategori']) ?></div>
                                <div class="text-[10px] text-slate-400"><?= htmlspecialchars($row['deskripsi']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-right font-bold <?= $row['jenis_transaksi'] == 'pemasukan' ? 'text-green-600' : 'text-red-600' ?>">
                                <?= $row['jenis_transaksi'] == 'pemasukan' ? '+' : '-' ?> Rp <?= number_format($row['nominal'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-5 text-center">
                                    <?php if(!empty($row['bukti_transaksi'])): ?>
                                        <?php 
                                        $ext = strtolower(pathinfo($row['bukti_transaksi'], PATHINFO_EXTENSION));
                                        if($ext == 'pdf'): ?>
                                            <a href="uploads/<?= $row['bukti_transaksi'] ?>" target="_blank" class="text-red-500 text-lg hover:scale-110 transition inline-block">
                                                <i class="fa-solid fa-file-pdf"></i>
                                            </a>
                                        <?php else: ?>
                                            <img src="uploads/<?= $row['bukti_transaksi'] ?>" 
                                                 onclick="openModal(this.src)"
                                                 class="w-10 h-10 object-cover rounded-lg cursor-pointer border border-slate-200 hover:scale-110 transition shadow-sm mx-auto">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <i class="fa-solid fa-image-slash text-slate-200"></i>
                                    <?php endif; ?>
                                </td>
                            <td class="px-6 py-4 text-center">
                                <a href="edit_transaksi.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:text-blue-700 px-2"><i class="fa-solid fa-pen"></i></a>
                                <button onclick="confirmDelete(<?= $row['id'] ?>)" class="text-red-500 hover:text-red-700 px-2"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Hapus data ini?")) window.location.href = "hapus_transaksi.php?id=" + id;
        }
    </script>
</body>
</html>