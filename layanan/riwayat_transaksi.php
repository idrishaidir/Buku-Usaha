<?php 
include '../config/database.php';

// Proteksi Halaman
if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data filter & search
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter_jenis = isset($_GET['jenis']) ? mysqli_real_escape_string($conn, $_GET['jenis']) : '';

// Build Query Dinamis berdasarkan user_id
$query_sql = "SELECT * FROM transaksi WHERE user_id = '$user_id'";
if ($search) $query_sql .= " AND (kategori LIKE '%$search%' OR deskripsi LIKE '%$search%')";
if ($filter_jenis) $query_sql .= " AND jenis_transaksi = '$filter_jenis'";
$query_sql .= " ORDER BY tanggal DESC";

$result = mysqli_query($conn, $query_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Manajemen Transaksi - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900">

    <div class="flex min-h-screen">
        <?php include 'side_navbar.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Transaksi</h1>
                    <p class="text-slate-500 text-sm mt-1">Kelola, edit, atau hapus data transaksi usaha Anda.</p>
                </div>
                <a href="tambah_transaksi.php" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                    <i class="fa-solid fa-plus text-sm"></i> Transaksi Baru
                </a>
            </div>

            <div class="bg-white p-4 rounded-[24px] border border-slate-100 shadow-sm mb-8">
                <form method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari kategori atau deskripsi..." 
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition text-sm">
                    </div>
                    <select name="jenis" class="px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none text-sm font-semibold text-slate-600">
                        <option value="">Semua Jenis</option>
                        <option value="pemasukan" <?= $filter_jenis == 'pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
                        <option value="pengeluaran" <?= $filter_jenis == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                    </select>
                    <button type="submit" class="bg-slate-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-800 transition text-sm">
                        Terapkan Filter
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-50">
                                <th class="px-6 py-5 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Tanggal</th>
                                <th class="px-6 py-5 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Kategori & Info</th>
                                <th class="px-6 py-5 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Jenis</th>
                                <th class="px-6 py-5 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest text-right">Nominal</th>
                                <th class="px-6 py-5 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php if(mysqli_num_rows($result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-5">
                                        <span class="text-sm font-semibold text-slate-600"><?= date('d M Y', strtotime($row['tanggal'])) ?></span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="font-bold text-slate-800"><?= htmlspecialchars($row['kategori']) ?></div>
                                        <div class="text-xs text-slate-400 truncate max-w-[200px]"><?= htmlspecialchars($row['deskripsi']) ?></div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <?php if($row['jenis_transaksi'] == 'pemasukan'): ?>
                                            <span class="px-3 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-bold uppercase">Masuk</span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-bold uppercase">Keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-5 text-right font-extrabold <?= $row['jenis_transaksi'] == 'pemasukan' ? 'text-green-600' : 'text-red-600' ?>">
                                        <?= $row['jenis_transaksi'] == 'pemasukan' ? '+' : '-' ?> Rp <?= number_format($row['nominal'], 0, ',', '.') ?>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="edit_transaksi.php?id=<?= $row['id'] ?>" class="w-9 h-9 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm">
                                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                                            </a>
                                            <button onclick="confirmDelete(<?= $row['id'] ?>)" class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition shadow-sm">
                                                <i class="fa-solid fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="py-20 text-center">
                                        <div class="flex flex-col items-center opacity-30">
                                            <i class="fa-solid fa-folder-open text-5xl mb-4"></i>
                                            <p class="font-bold">Belum ada transaksi ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        function confirmDelete(id) {
            if (confirm("Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini akan memengaruhi laporan keuangan Anda secara permanen.")) {
                window.location.href = "hapus_transaksi.php?id=" + id;
            }
        }
    </script>
</body>
</html>