<?php
// Memulai session untuk mengecek apakah user sudah login atau belum
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>BukuUsaha.id - Solusi Akuntansi UMKM</title>
</head>
<body class="bg-white text-gray-800 font-sans leading-normal tracking-normal">

    <nav class="fixed w-full z-30 top-0 bg-white shadow-md">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-4 px-6">
            <div class="flex items-center">
                <a class="text-blue-600 no-underline hover:no-underline font-bold text-2xl" href="index.php">
                    BukuUsaha.id
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-sm font-semibold" id="nav-content">
                <a class="inline-block text-gray-600 hover:text-blue-600 transition" href="index.php">Beranda</a>
                <a class="inline-block text-gray-600 hover:text-blue-600 transition" href="layanan.php">Layanan</a>
                <a class="inline-block text-gray-600 hover:text-blue-600 transition" href="tentang.php">Tentang Kami</a>
                <a class="inline-block text-gray-600 hover:text-blue-600 transition" href="kontak.php">Kontak</a>
            </div>

            <div class="flex items-center">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="layanan.php" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 transition shadow-md">Dashboard</a>
                <?php else: ?>
                    <a href="login.php" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 transition shadow-md">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 bg-gradient-to-b from-blue-50 to-white">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
            <div class="flex flex-col w-full md:w-1/2 justify-center items-start text-center md:text-left">
                <h1 class="my-4 text-4xl md:text-5xl font-bold leading-tight text-gray-900">
                    Solusi Akuntansi Digital <br>
                    <span class="text-blue-600">Khusus Untuk UMKM</span>
                </h1>
                <p class="leading-normal text-xl mb-8 text-gray-600">
                    Kelola pencatatan keuangan, laporan pajak, dan konsultasi bisnis dalam satu platform aman dan terstruktur. Saatnya UMKM naik kelas dengan data yang rapi.
                </p>
                <div class="flex w-full justify-center md:justify-start">
                    <a href="register.php" class="bg-blue-600 text-white font-bold rounded-lg my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
            <div class="w-full md:w-1/2 py-6 text-center">
                <img class="w-full md:w-4/5 z-50 inline-block" src="https://img.freepik.com/free-vector/financial-report-concept-illustration_114360-3162.jpg" alt="Ilustrasi Akuntansi">
            </div>
        </div>
    </section>

    <section class="bg-white border-b py-20">
        <div class="container mx-auto px-6">
            <h2 class="w-full my-2 text-3xl font-bold leading-tight text-center text-gray-800">
                Kenapa Memilih BukuUsaha.id?
            </h2>
            <div class="w-full mb-12">
                <div class="h-1 mx-auto bg-blue-600 w-24 opacity-25 my-0 py-0 rounded-t"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-8 bg-white rounded-xl shadow-xl border border-gray-100 hover:shadow-2xl transition duration-300">
                    <div class="text-blue-600 mb-4 flex justify-center">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04kM12 21.355r2.263-6.415m-4.526 0L12 21.355z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Data Aman & Terpisah</h3>
                    <p class="text-gray-600 text-sm">Sistem multi-user menjamin data keuangan UMKM Anda tidak akan tercampur dengan pengguna lain.</p>
                </div>

                <div class="p-8 bg-white rounded-xl shadow-xl border border-gray-100 hover:shadow-2xl transition duration-300">
                    <div class="text-blue-600 mb-4 flex justify-center">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Akses Cepat</h3>
                    <p class="text-gray-600 text-sm">Kelola data kapan saja dan di mana saja melalui perangkat mobile maupun desktop secara responsif.</p>
                </div>

                <div class="p-8 bg-white rounded-xl shadow-xl border border-gray-100 hover:shadow-2xl transition duration-300">
                    <div class="text-blue-600 mb-4 flex justify-center">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Terstruktur</h3>
                    <p class="text-gray-600 text-sm">Pencatatan yang rapi membantu Anda dalam proses pelaporan pajak dan evaluasi bisnis tahunan.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-100 py-10">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-600">&copy; 2025 BukuUsaha.id. Tugas Proyek Web Layanan Akuntansi UMKM.</p>
        </div>
    </footer>

</body>
</html>