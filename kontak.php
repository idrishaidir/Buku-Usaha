<?php 
include 'config.php'; 

if (isset($_POST['kirim'])) {
    // Simulasi pengiriman pesan (tidak simpan database)
    $nama = htmlspecialchars($_POST['nama']);
    echo "<script>alert('Terima kasih $nama, pesan Anda telah terkirim!'); window.location='kontak.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kontak Kami - BukuUsaha.id</title>
</head>
<body class="bg-gray-50 min-h-screen">

    <nav class="fixed w-full z-30 top-0 bg-white shadow-md py-4 px-6">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-blue-600 font-bold text-2xl" href="index.php">BukuUsaha.id</a>
            <div class="hidden md:flex space-x-8 text-sm font-semibold">
                <a href="index.php" class="text-gray-600 hover:text-blue-600">Beranda</a>
                <a href="layanan.php" class="text-gray-600 hover:text-blue-600">Layanan</a>
                <a href="tentang.php" class="text-gray-600 hover:text-blue-600">Tentang Kami</a>
                <a href="kontak.php" class="text-blue-600">Kontak</a>
            </div>
            <a href="login.php" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold">Login</a>
        </div>
    </nav>

    <div class="container mx-auto pt-32 pb-20 px-6">
        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
            
            <div class="bg-blue-600 md:w-1/3 p-10 text-white">
                <h2 class="text-3xl font-bold mb-6">Hubungi Kami</h2>
                <p class="mb-8 opacity-80">Ada pertanyaan? Kami siap membantu mengelola keuangan UMKM Anda.</p>
                
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <span class="text-2xl">📍</span>
                        <p class="text-sm">Jakarta Selatan, Indonesia</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-2xl">📧</span>
                        <p class="text-sm">support@bukuusaha.id</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-2xl">📞</span>
                        <p class="text-sm">+62 812-3456-7890</p>
                    </div>
                </div>
            </div>

            <div class="md:w-2/3 p-10">
                <form method="POST" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan nama" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Bisnis</label>
                            <input type="email" name="email" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" placeholder="email@usaha.com" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                        <textarea name="pesan" rows="5" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required></textarea>
                    </div>
                    <button type="submit" name="kirim" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition-all shadow-lg">
                        Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <footer class="text-center py-10 text-gray-400 text-sm italic">
        "BukuUsaha.id - Bertumbuh Bersama UMKM"
    </footer>
</body>
</html>