<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tentang Kami - BukuUsaha.id</title>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="fixed w-full z-30 top-0 bg-white shadow-md">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-4 px-6">
            <a class="text-blue-600 font-bold text-2xl" href="index.php">BukuUsaha.id</a>
            <div class="hidden md:flex items-center space-x-8 text-sm font-semibold">
                <a class="text-gray-600 hover:text-blue-600" href="index.php">Beranda</a>
                <a class="text-gray-600 hover:text-blue-600" href="layanan.php">Layanan</a>
                <a class="text-blue-600" href="tentang.php">Tentang Kami</a>
                <a class="text-gray-600 hover:text-blue-600" href="kontak.php">Kontak</a>
            </div>
            <a href="login.php" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 transition">Login</a>
        </div>
    </nav>

    <section class="pt-32 pb-12 bg-blue-600 text-white text-center">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl font-bold mb-4">Tentang Kami</h1>
            <p class="text-xl opacity-90">Mengenal lebih dekat solusi akuntansi untuk masa depan UMKM Indonesia.</p>
        </div>
    </section>

    <section class="py-16 container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2">
                <img src="https://img.freepik.com/free-vector/team-goals-concept-illustration_114360-5151.jpg" alt="Tentang BukuUsaha" class="rounded-xl">
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Misi Kami untuk UMKM</h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    <strong>BukuUsaha.id</strong> hadir sebagai respons atas tantangan yang dihadapi oleh jutaan pelaku UMKM di Indonesia dalam mengelola administrasi keuangan. Kami percaya bahwa data keuangan yang rapi adalah fondasi bagi bisnis untuk berkembang dan naik kelas.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Kami menyediakan platform yang tidak hanya berfungsi sebagai alat pencatatan, tetapi juga sebagai mitra digital dalam menyusun laporan keuangan yang akuntabel dan profesional.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-white py-20 border-t">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                <div class="bg-blue-50 p-8 rounded-2xl">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">Visi</h3>
                    <p class="text-gray-700 italic">"Menjadi platform akuntansi digital nomor satu bagi UMKM Indonesia dalam mewujudkan tata kelola keuangan yang transparan dan profesional."</p>
                </div>
                <div class="bg-blue-50 p-8 rounded-2xl">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4">Misi</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Menyediakan alat pencatatan keuangan yang mudah dan terjangkau.</li>
                        <li>Membantu UMKM memahami kesehatan finansial bisnis mereka.</li>
                        <li>Mempermudah proses administrasi perpajakan bagi pelaku usaha.</li>
                    </ul>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-center mb-12">Nilai Utama Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl mb-4">🛡️</div>
                    <h4 class="font-bold text-xl mb-2">Integritas</h4>
                    <p class="text-gray-600">Menjaga keamanan dan privasi data keuangan Anda dengan standar terbaik.</p>
                </div>
                <div>
                    <div class="text-4xl mb-4">⚡</div>
                    <h4 class="font-bold text-xl mb-2">Kemudahan</h4>
                    <p class="text-gray-600">Menyederhanakan proses akuntansi yang rumit menjadi lebih ramah pengguna.</p>
                </div>
                <div>
                    <div class="text-4xl mb-4">🤝</div>
                    <h4 class="font-bold text-xl mb-2">Kolaborasi</h4>
                    <p class="text-gray-600">Terus mendengarkan kebutuhan pelaku usaha untuk inovasi berkelanjutan.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-100 py-10 text-center text-gray-500 text-sm">
        &copy; 2025 BukuUsaha.id. Semua Hak Dilindungi.
    </footer>
</body>
</html>