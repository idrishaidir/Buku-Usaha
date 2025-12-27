<?php 
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nama_usaha = $_SESSION['nama_usaha'];
$nama_lengkap = $_SESSION['nama_lengkap'];

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$tgl_mulai = isset($_GET['tgl_mulai']) ? mysqli_real_escape_string($conn, $_GET['tgl_mulai']) : '';
$tgl_selesai = isset($_GET['tgl_selesai']) ? mysqli_real_escape_string($conn, $_GET['tgl_selesai']) : '';

$jumlahDataPerHalaman = 10;
$halamanAktif = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$base_filter = "WHERE user_id = '$user_id'";

if (!empty($tgl_mulai) && !empty($tgl_selesai)) {
    $base_filter .= " AND tanggal BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    $label_periode = date('d/m/Y', strtotime($tgl_mulai)) . " s/d " . date('d/m/Y', strtotime($tgl_selesai));
} else {
    $label_periode = "Semua Waktu";
}

if ($search) {
    $base_filter .= " AND (kategori LIKE '%$search%' OR deskripsi LIKE '%$search%')";
}

$query_hitung = "SELECT COUNT(*) as total FROM transaksi $base_filter";
$result_hitung = mysqli_query($conn, $query_hitung);
$data_hitung = mysqli_fetch_assoc($result_hitung);
$totalData = $data_hitung['total'];
$jumlahHalaman = ceil($totalData / $jumlahDataPerHalaman);

$query_pdf = "SELECT * FROM transaksi $base_filter ORDER BY tanggal ASC";
$result_pdf = mysqli_query($conn, $query_pdf);

$query_sql = "SELECT * FROM transaksi $base_filter ORDER BY id DESC LIMIT $awalData, $jumlahDataPerHalaman";
$result = mysqli_query($conn, $query_sql);

$rekap_sql = "SELECT jenis_transaksi, SUM(nominal) as total FROM transaksi $base_filter GROUP BY jenis_transaksi";
$total_masuk = 0; $total_keluar = 0;
$rekap_query = mysqli_query($conn, $rekap_sql);
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
    <title>Laporan Transaksi - <?= htmlspecialchars($nama_usaha) ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0; margin: 0; color: black; }
            .pdf-only { display: block !important; }
            
            .pdf-header { text-align: center; border-bottom: 3px double #000; padding-bottom: 15px; margin-bottom: 30px; }
            .pdf-header h1 { font-size: 22pt; font-weight: 800; margin: 0; letter-spacing: -1px; }
            .pdf-header p { font-size: 11pt; margin: 3px 0; color: #333; }

            .pdf-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            .pdf-table th { border-top: 2px solid black; border-bottom: 2px solid black; padding: 12px 8px; text-align: left; font-size: 10pt; background: #f8fafc !important; -webkit-print-color-adjust: exact; }
            .pdf-table td { border-bottom: 1px solid #ddd; padding: 10px 8px; font-size: 10pt; vertical-align: top; }
            
            .row-section { font-weight: bold; background: #f1f5f9 !important; -webkit-print-color-adjust: exact; }
            .row-total { border-top: 2px solid black; border-bottom: 2px solid black; font-weight: 800; font-size: 11pt; }
            .text-right { text-align: right; }
            
            .pdf-footer { margin-top: 50px; display: flex; justify-content: flex-end; }
            .signature-box { text-align: center; width: 250px; font-size: 10pt; }
        }

        .pdf-only { display: none; }
    </style>
</head>
<body class="bg-[#F8FAFC]">

    <div class="flex min-h-screen">
        <div class="no-print">
            <?php include 'side_navbar.php'; ?>
        </div>

        <main class="flex-1 p-6 lg:p-10">
            <div class="no-print">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Transaksi</h1>
                        <p class="text-slate-500 text-sm mt-1">Kelola dan ekspor laporan keuangan UMKM Anda.</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="window.print()" class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl font-bold hover:bg-slate-50 transition shadow-sm">
                            <i class="fa-solid fa-file-pdf mr-2 text-red-500"></i> Export Laporan
                        </button>
                        <a href="tambah_transaksi.php" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            <i class="fa-solid fa-plus text-sm mr-2"></i> Transaksi Baru
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm mb-8">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-slate-400 uppercase ml-1">Dari Tanggal</label>
                            <input type="date" name="tgl_mulai" value="<?= $tgl_mulai ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-slate-400 uppercase ml-1">Sampai Tanggal</label>
                            <input type="date" name="tgl_selesai" value="<?= $tgl_selesai ?>" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-slate-400 uppercase ml-1">Pencarian</label>
                            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari kategori..." class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none text-sm">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-slate-900 text-white py-3.5 rounded-xl font-bold text-sm hover:bg-blue-600 transition">Filter</button>
                            <a href="riwayat_transaksi.php" class="px-4 py-3.5 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition"><i class="fa-solid fa-rotate-left"></i></a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="pdf-only">
                <div class="pdf-header">
                    <h1>LAPORAN ARUS KAS</h1>
                    <p class="font-bold text-lg"><?= strtoupper(htmlspecialchars($nama_usaha)) ?></p>
                    <p>Periode: <?= $label_periode ?></p>
                </div>

                <table class="pdf-table">
                    <thead>
                        <tr>
                            <th>Keterangan Transaksi</th>
                            <th>Tanggal</th>
                            <th class="text-right">Pemasukan (IDR)</th>
                            <th class="text-right">Pengeluaran (IDR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row-section"><td colspan="4">SUMBER PENERIMAAN KAS</td></tr>
                        <?php 
                        mysqli_data_seek($result_pdf, 0);
                        while($p = mysqli_fetch_assoc($result_pdf)): 
                            if($p['jenis_transaksi'] == 'pemasukan'): ?>
                            <tr>
                                <td style="padding-left: 20px;"><?= htmlspecialchars($p['kategori']) ?> <br><span style="font-size: 8pt; color: #666;"><?= htmlspecialchars($p['deskripsi']) ?></span></td>
                                <td><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                                <td class="text-right"><?= number_format($p['nominal'], 0, ',', '.') ?></td>
                                <td class="text-right">-</td>
                            </tr>
                        <?php endif; endwhile; ?>
                        <tr class="font-bold">
                            <td colspan="2" class="text-right">Sub-Total Penerimaan:</td>
                            <td class="text-right"><?= number_format($total_masuk, 0, ',', '.') ?></td>
                            <td class="text-right">-</td>
                        </tr>

                        <tr class="row-section"><td colspan="4" style="padding-top: 20px;">PENGGUNAAN KAS</td></tr>
                        <?php 
                        mysqli_data_seek($result_pdf, 0);
                        while($k = mysqli_fetch_assoc($result_pdf)): 
                            if($k['jenis_transaksi'] == 'pengeluaran'): ?>
                            <tr>
                                <td style="padding-left: 20px;"><?= htmlspecialchars($k['kategori']) ?> <br><span style="font-size: 8pt; color: #666;"><?= htmlspecialchars($k['deskripsi']) ?></span></td>
                                <td><?= date('d/m/Y', strtotime($k['tanggal'])) ?></td>
                                <td class="text-right">-</td>
                                <td class="text-right">(<?= number_format($k['nominal'], 0, ',', '.') ?>)</td>
                            </tr>
                        <?php endif; endwhile; ?>
                        <tr class="font-bold">
                            <td colspan="3" class="text-right">Sub-Total Penggunaan:</td>
                            <td class="text-right">(<?= number_format($total_keluar, 0, ',', '.') ?>)</td>
                        </tr>

                        <tr class="row-total">
                            <td colspan="3" style="padding: 15px;">KENAIKAN / PENURUNAN KAS BERSIH</td>
                            <td class="text-right" style="padding: 15px;">Rp <?= number_format($total_masuk - $total_keluar, 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="pdf-footer">
                    <div class="signature-box">
                        <p>Dicetak pada: <?= date('d/m/Y H:i') ?></p>
                        <p style="margin-top: 10px;">Pemilik Usaha,</p>
                        <div style="height: 70px;"></div>
                        <p class="font-bold border-t border-black pt-2"><?= strtoupper(htmlspecialchars($nama_lengkap)) ?></p>
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
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase text-center">Bukti</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-500"><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800"><?= htmlspecialchars($row['kategori']) ?></div>
                                <div class="text-[10px] text-slate-400 uppercase"><?= htmlspecialchars($row['deskripsi']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-right font-bold <?= $row['jenis_transaksi'] == 'pemasukan' ? 'text-green-600' : 'text-red-600' ?>">
                                <?= $row['jenis_transaksi'] == 'pemasukan' ? '+' : '-' ?> Rp <?= number_format($row['nominal'], 0, ',', '.') ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if(!empty($row['bukti_transaksi'])): ?>
                                    <img src="uploads/<?= $row['bukti_transaksi'] ?>" onclick="window.open(this.src)" class="w-9 h-9 object-cover rounded-lg cursor-pointer border border-slate-200 mx-auto hover:scale-110 transition">
                                <?php else: ?>
                                    <span class="text-slate-200 text-xs">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="edit_transaksi.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:text-blue-700 px-2"><i class="fa-solid fa-pen"></i></a>
                                <button onclick="confirmDelete(<?= $row['id'] ?>)" class="text-red-400 hover:text-red-600 px-2"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($jumlahHalaman > 1): ?>
            <div class="mt-8 flex justify-center items-center gap-2 no-print">
                <?php 
                $q = $_GET; unset($q['halaman']);
                $link = "?" . http_build_query($q) . "&halaman=";
                ?>
                <?php if($halamanAktif > 1): ?>
                    <a href="<?= $link . ($halamanAktif - 1) ?>" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-blue-50 transition">Prev</a>
                <?php endif; ?>
                <?php for($i = 1; $i <= $jumlahHalaman; $i++): ?>
                    <a href="<?= $link . $i ?>" class="w-10 h-10 flex items-center justify-center rounded-xl border <?= $i == $halamanAktif ? 'bg-blue-600 border-blue-600 text-white font-bold' : 'bg-white border-slate-200 text-slate-600'; ?>"><?= $i ?></a>
                <?php endfor; ?>
                <?php if($halamanAktif < $jumlahHalaman): ?>
                    <a href="<?= $link . ($halamanAktif + 1) ?>" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-blue-50 transition">Next</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Hapus data transaksi ini secara permanen?")) window.location.href = "hapus_transaksi.php?id=" + id;
        }
    </script>
</body>
</html>