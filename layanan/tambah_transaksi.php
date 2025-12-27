<?php 
include '../config/database.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

if (isset($_POST['tambah_transaksi'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $jenis_transaksi = mysqli_real_escape_string($conn, $_POST['jenis_transaksi']);
    
    $nominal_mentah = $_POST['nominal'];
    $nominal_bersih = str_replace('.', '', $nominal_mentah); 

    $bukti = "";
    if (!empty($_FILES['bukti_transaksi']['name'])) {
        $nama_file = time() . '_' . $_FILES['bukti_transaksi']['name'];
        move_uploaded_file($_FILES['bukti_transaksi']['tmp_name'], 'uploads/' . $nama_file);
        $bukti = $nama_file;
    }

    $query = "INSERT INTO transaksi (user_id, tanggal, kategori, deskripsi, nominal, jenis_transaksi, bukti_transaksi) 
              VALUES ('$user_id', '$tanggal', '$kategori', '$deskripsi', '$nominal_bersih', '$jenis_transaksi', '$bukti')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Transaksi berhasil dicatat!'); window.location='riwayat_transaksi.php';</script>";
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
    <title>Tambah Transaksi Baru - BukuUsaha.id</title>
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
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Catat Transaksi Baru</h1>
                    <p class="text-slate-500 text-sm mt-1">Lengkapi detail informasi umum dan lampiran bukti untuk pencatatan otomatis.</p>
                </div>
            </div>

            <form action="proses_transaksi.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="jenis_transaksi" id="jenis_transaksi" value="pengeluaran">

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
                                    <input type="date" name="tanggal" required value="<?= date('Y-m-d') ?>" 
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Pilih Jenis Transaksi</label>
                                    <div class="flex p-1 bg-slate-100 rounded-xl">
                                        <button type="button" onclick="switchType('pengeluaran')" id="btn-out" 
                                                class="flex-1 py-2 px-4 rounded-lg text-sm font-bold transition bg-white text-red-600 shadow-sm">
                                            Pengeluaran
                                        </button>
                                        <button type="button" onclick="switchType('pemasukan')" id="btn-in" 
                                                class="flex-1 py-2 px-4 rounded-lg text-sm font-bold transition text-slate-500 hover:text-green-600">
                                            Pemasukan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Kategori</label>
                                    <select name="kategori" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                                        <option value="">Pilih Kategori...</option>
                                        <option value="Bahan Baku">Bahan Baku</option>
                                        <option value="Operasional">Operasional</option>
                                        <option value="Gaji Karyawan">Gaji Karyawan</option>
                                        <option value="Penjualan Produk">Penjualan Produk</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-slate-700">Metode Pembayaran</label>
                                    <select name="metode" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition">
                                        <option value="Tunai">Tunai</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="E-Wallet">E-Wallet</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2 mb-6">
                                <label class="text-sm font-semibold text-slate-700">Nominal (Rp)</label>
                                <input type="text" id="inputNominal" name="nominal" required placeholder="0" 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition font-bold text-lg text-slate-800">
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-slate-700">Deskripsi / Memo</label>
                                <textarea name="deskripsi" rows="4" placeholder="Jelaskan detail transaksi (cth: Pembelian terigu 50kg)" 
                                          class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 transition text-sm"></textarea>
                            </div>
                        </div>

                        <div class="block lg:hidden bg-white p-6 rounded-[24px] border border-slate-100 shadow-sm mb-6">
                            <div class="flex items-center gap-2 mb-4 text-slate-500">
                                <i class="fa-solid fa-paperclip"></i>
                                <h3 class="font-bold uppercase tracking-widest text-xs">Bukti Transaksi</h3>
                            </div>

                            <div class="relative group bukti-card cursor-pointer border-2 border-dashed border-slate-200 rounded-[16px] p-6 text-center hover:border-blue-500 hover:bg-blue-50/50 transition duration-300">
                                <input type="file" name="bukti_transaksi" accept="image/*,.pdf" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewFile(event)">
                                <div class="space-y-4">
                                    <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto group-hover:bg-blue-100 group-hover:text-blue-600 transition">
                                        <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Klik atau Drag File</p>
                                        <p class="text-[11px] text-slate-400 mt-1 uppercase font-bold tracking-tighter">PDF / JPG / PNG (Maks 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="file-name mt-4 text-xs font-semibold text-blue-600 hidden text-center"></div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" name="simpan" id="submit-btn" 
                                    class="bg-red-600 text-white px-10 py-4 rounded-2xl font-extrabold shadow-xl shadow-red-200 hover:scale-[1.02] active:scale-95 transition duration-300">
                                Simpan Transaksi <i class="fa-solid fa-paper-plane ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm hidden lg:block">
                            <div class="flex items-center gap-2 mb-8 text-slate-500">
                                <i class="fa-solid fa-paperclip"></i>
                                <h3 class="font-bold uppercase tracking-widest text-xs">Bukti Transaksi</h3>
                            </div>

                            <div class="relative group bukti-card cursor-pointer border-2 border-dashed border-slate-200 rounded-[24px] p-8 text-center hover:border-blue-500 hover:bg-blue-50/50 transition duration-300">
                                <input type="file" name="bukti_transaksi" accept="image/*,.pdf" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewFile(event)">
                                <div class="space-y-4">
                                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto group-hover:bg-blue-100 group-hover:text-blue-600 transition">
                                        <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">Klik atau Drag File</p>
                                        <p class="text-[11px] text-slate-400 mt-1 uppercase font-bold tracking-tighter">PDF / JPG / PNG (Maks 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="file-name mt-4 text-xs font-semibold text-blue-600 hidden text-center"></div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-[24px] border border-blue-100">
                            <h4 class="text-xs font-extrabold text-blue-600 uppercase mb-2">Tips Pencatatan</h4>
                            <p class="text-[11px] text-blue-500 leading-relaxed italic">
                                Pastikan nominal dan kategori sudah benar sebelum menyimpan. Bukti fisik membantu validasi laporan pajak di masa mendatang.
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
                submitBtn.className = "bg-green-600 text-white px-10 py-4 rounded-2xl font-extrabold shadow-xl shadow-green-200 hover:scale-[1.02] active:scale-95 transition duration-300";
                inputJenis.value = 'pemasukan';
            } else {
                btnOut.className = "flex-1 py-2 px-4 rounded-lg text-sm font-bold transition bg-white text-red-600 shadow-sm";
                btnIn.className = "flex-1 py-2 px-4 rounded-lg text-sm font-bold transition text-slate-500 hover:text-green-600";
                submitBtn.className = "bg-red-600 text-white px-10 py-4 rounded-2xl font-extrabold shadow-xl shadow-red-200 hover:scale-[1.02] active:scale-95 transition duration-300";
                inputJenis.value = 'pengeluaran';
            }
        }

        function previewFile(event) {
            const input = event.target;
            const file = input.files[0];
            let container = input.closest('.bukti-card');
            if (!container) container = input.parentElement;
            const fileNameDisplay = container.querySelector('.file-name');
            if (file && fileNameDisplay) {
                fileNameDisplay.innerText = "File terpilih: " + file.name;
                fileNameDisplay.classList.remove('hidden');
            }
        }

        const inputNominal = document.getElementById('inputNominal');

        inputNominal.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            
            if (value !== "") {
                this.value = formatRupiah(value);
            } else {
                this.value = "";
            }
        });

        function formatRupiah(angka) {
            let number_string = angka.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return rupiah;
        }
    </script>
</body>
</html>