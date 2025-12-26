<?php 
include 'config.php';

// 1. MIDDLEWARE: Proteksi Halaman
// Jika session user_id tidak ada, redirect ke login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nama_usaha = $_SESSION['nama_usaha'];

// 2. LOGIC: Simpan Data ke Database
if (isset($_POST['simpan'])) {
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis_layanan']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tanggal = $_POST['tanggal'];

    $query_simpan = "INSERT INTO layanan_keuangan (user_id, jenis_layanan, deskripsi, tanggal) 
                     VALUES ('$user_id', '$jenis', '$deskripsi', '$tanggal')";
    
    if (mysqli_query($conn, $query_simpan)) {
        echo "<script>alert('Data berhasil disimpan!'); window.location='layanan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// 3. LOGIC: Ambil Data (Hanya milik user yang login)
$query_tampil = "SELECT * FROM layanan_keuangan WHERE user_id = '$user_id' ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query_tampil);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Layanan Akuntansi - BukuUsaha.id</title>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wider uppercase">BukuUsaha.id</h1>
            <div class="flex items-center gap-6">
                <span class="hidden md:block">Selamat Datang, <strong><?= htmlspecialchars($nama_usaha) ?></strong></span>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg text-sm font-semibold transition">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto py-10 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Tambah Catatan Layanan</h2>
                    <form method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                            <select name="jenis_layanan" class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                                <option value="">-- Pilih Layanan --</option>
                                <option value="Pencatatan">Pencatatan</option>
                                <option value="Laporan Keuangan">Laporan Keuangan</option>
                                <option value="Konsultasi">Konsultasi</option>
                                <option value="Pajak">Pajak</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Input jurnal transaksi bulan Desember" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="tanggal" class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                        </div>
                        <button type="submit" name="simpan" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-md">
                            Simpan Data
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Riwayat Layanan Keuangan</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">No</th>
                                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                                    <th class="px-6 py-4 font-semibold">Jenis Layanan</th>
                                    <th class="px-6 py-4 font-semibold">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php 
                                $no = 1;
                                if (mysqli_num_rows($result) > 0):
                                    while($row = mysqli_fetch_assoc($result)): 
                                ?>
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= $no++ ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            <?= $row['jenis_layanan'] == 'Pajak' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' ?>">
                                            <?= $row['jenis_layanan'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= $row['deskripsi'] ?></td>
                                </tr>
                                <?php 
                                    endwhile; 
                                else:
                                ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Belum ada data layanan.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="text-center py-10 text-gray-400 text-sm">
        &copy; 2025 BukuUsaha.id - Solusi Akuntansi UMKM
    </footer>

</body>
</html>