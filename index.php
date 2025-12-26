<?php
// Memulai session untuk mengecek status login
session_start();
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>BukuUsaha.id - Solusi Akuntansi Modern UMKM</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .bg-gradient-custom { background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%); }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 overflow-x-hidden">

    <nav class="fixed w-full z-50 top-0 px-6 py-4">
        <div class="max-w-7xl mx-auto glass rounded-2xl border border-white/40 shadow-lg px-6 py-3 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                BukuUsaha.id
            </a>
            
            <div class="hidden md:flex space-x-8 text-sm font-semibold text-slate-600">
                <a href="index.php" class="text-blue-600">Beranda</a>
                <a href="layanan.php" class="hover:text-blue-600 transition">Layanan</a>
                <a href="tentang.php" class="hover:text-blue-600 transition">Tentang Kami</a>
                <a href="kontak.php" class="hover:text-blue-600 transition">Kontak</a>
            </div>

            <div class="flex items-center gap-4">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="layanan.php" class="bg-gradient-custom text-white px-6 py-2.5 rounded-xl font-bold hover:opacity-90 transition shadow-lg shadow-blue-200">Dashboard</a>
                <?php else: ?>
                    <a href="login.php" class="hidden md:block font-bold text-slate-600 hover:text-blue-600 transition">Masuk</a>
                    <a href="register.php" class="bg-gradient-custom text-white px-6 py-2.5 rounded-xl font-bold hover:scale-105 transition shadow-lg shadow-blue-200">Daftar</a>
                <?php endif; ?>
                
                <button class="md:hidden text-slate-600" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
            </div>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden absolute top-20 left-6 right-6 bg-white rounded-2xl shadow-2xl p-6 border border-slate-100">
            <div class="flex flex-col space-y-4 font-semibold">
                <a href="index.php" class="text-blue-600">Beranda</a>
                <a href="layanan.php">Layanan</a>
                <a href="tentang.php">Tentang Kami</a>
                <a href="kontak.php">Kontak</a>
                <hr>
                <a href="login.php" class="text-center py-2">Masuk</a>
            </div>
        </div>
    </nav>

    <section class="relative pt-40 pb-20 overflow-hidden">
        <div class="absolute top-0 right-0 -z-10 w-[500px] h-[500px] bg-blue-100 rounded-full blur-3xl opacity-50 -mr-40 -mt-20"></div>
        <div class="absolute bottom-0 left-0 -z-10 w-[400px] h-[400px] bg-purple-100 rounded-full blur-3xl opacity-50 -ml-20"></div>

        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 text-center md:text-left space-y-6">
                <div class="inline-block px-4 py-1.5 bg-blue-50 border border-blue-100 rounded-full text-blue-600 text-sm font-bold animate-bounce">
                    ✨ Solusi Akuntansi Terpercaya
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold leading-tight tracking-tight text-slate-900">
                    Akuntansi UMKM, <br>
                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Lebih Rapi.</span> <br>
                    Lebih Cerdas.
                </h1>
                <p class="text-lg text-slate-600 max-w-lg leading-relaxed">
                    Ubah kerumitan pembukuan manual menjadi sistem digital yang otomatis dan akurat. Kendalikan profit bisnis Anda hanya dengan satu platform.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="register.php" class="bg-gradient-custom text-white px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-2xl hover:-translate-y-1 transition-all">
                        Mulai Kelola Keuangan <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#solusi" class="px-8 py-4 rounded-2xl font-bold text-lg text-slate-600 border border-slate-200 hover:bg-slate-50 transition">
                        Lihat Demo
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 mt-16 md:mt-0 relative animate-float">
                <div class="absolute inset-0 bg-gradient-custom opacity-10 blur-2xl rounded-full"></div>
                <img src="https://img.freepik.com/free-vector/modern-flat-design-concept-accountant-working-with-calculator-laptop-documents-tax-ledgers-reporting-financial-statements-audit-taxation-business-analysis-accounting_126608-207.jpg" 
                     alt="Accounting Illustration" class="relative z-10 w-full drop-shadow-2xl rounded-3xl">
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4 text-slate-900">UMKM Hebat, Tapi Keuangan Masih Ribet?</h2>
                <p class="text-slate-500">Banyak bisnis gagal bukan karena tidak laku, tapi karena arus kas yang tidak terpantau.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group p-10 bg-slate-50 rounded-3xl border border-transparent hover:border-blue-200 hover:bg-white hover:shadow-2xl transition-all duration-300">
                    <div class="text-4xl mb-6 group-hover:scale-110 transition-transform">📉</div>
                    <h3 class="text-xl font-bold mb-3">Pencatatan Berantakan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Nota fisik sering hilang dan transaksi lupa dicatat sehingga data tidak valid.</p>
                </div>
                <div class="group p-10 bg-slate-50 rounded-3xl border border-transparent hover:border-purple-200 hover:bg-white hover:shadow-2xl transition-all duration-300">
                    <div class="text-4xl mb-6 group-hover:scale-110 transition-transform">💸</div>
                    <h3 class="text-xl font-bold mb-3">Uang Pribadi Tercampur</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Sulit membedakan mana modal usaha dan mana uang belanja harian.</p>
                </div>
                <div class="group p-10 bg-slate-50 rounded-3xl border border-transparent hover:border-blue-200 hover:bg-white hover:shadow-2xl transition-all duration-300">
                    <div class="text-4xl mb-6 group-hover:scale-110 transition-transform">📋</div>
                    <h3 class="text-xl font-bold mb-3">Laporan Pajak Pusing</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Menjelang akhir tahun panik menyusun laporan untuk pelaporan pajak tahunan.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="solusi" class="py-24">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center gap-16 mb-24">
                <div class="md:w-1/2">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-blue-600/10 rounded-3xl blur-xl"></div>
                        <img src="https://img.freepik.com/free-vector/business-budget-management_603843-1529.jpg?uid=R227561317&ga=GA1.1.285523955.1766743514&w=740&q=80" class="rounded-3xl shadow-xl relative">
                    </div>
                </div>
                <div class="md:w-1/2 space-y-6 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-extrabold">Catat Transaksi Dalam Detik</h2>
                    <p class="text-slate-600 leading-relaxed">Input data penjualan dan pengeluaran dengan formulir yang sangat simpel. Biarkan sistem kami yang melakukan penjurnalan otomatis untuk Anda.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-slate-700 font-medium">
                            <i class="fa-solid fa-check-circle text-green-500"></i> Auto-Journaling System
                        </li>
                        <li class="flex items-center gap-3 text-slate-700 font-medium">
                            <i class="fa-solid fa-check-circle text-green-500"></i> Filter Kategori Transaksi
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row-reverse items-center gap-16">
                <div class="md:w-1/2">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-purple-600/10 rounded-3xl blur-xl"></div>
                        <img src="https://img.freepik.com/free-vector/growth-analysis-concept-illustration_114360-2345.jpg" class="rounded-3xl shadow-xl relative">
                    </div>
                </div>
                <div class="md:w-1/2 space-y-6 text-center md:text-left">
                    <h2 class="text-3xl md:text-4xl font-extrabold">Visualisasi Kesehatan Bisnis</h2>
                    <p class="text-slate-600 leading-relaxed">Lihat perkembangan bisnis Anda melalui grafik yang mudah dipahami. Pantau laba rugi secara real-time tanpa harus jago akuntansi.</p>
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                            <p class="text-2xl font-bold text-blue-600">Real-time</p>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Laporan Laba Rugi</p>
                        </div>
                        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-100">
                            <p class="text-2xl font-bold text-purple-600">Export</p>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">PDF & Excel Ready</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-900 text-white rounded-[50px] mx-4">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div class="max-w-xl">
                    <h2 class="text-4xl font-extrabold mb-4">Mengapa BukuUsaha.id Unggul?</h2>
                    <p class="text-slate-400">Dirancang khusus dengan riset mendalam terhadap kebutuhan harian pengusaha mikro di Indonesia.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="space-y-4">
                    <div class="text-blue-400 text-3xl font-bold">01.</div>
                    <h3 class="text-xl font-bold italic">User-Based & Aman</h3>
                    <p class="text-slate-400 text-sm">Setiap akun diproteksi dengan enkripsi password</p>
                </div>
                <div class="space-y-4">
                    <div class="text-purple-400 text-3xl font-bold">02.</div>
                    <h3 class="text-xl font-bold italic">Transparan & Terstruktur</h3>
                    <p class="text-slate-400 text-sm">Semua riwayat layanan dan catatan keuangan tercatat kronologis, memudahkan audit internal kapan saja.</p>
                </div>
                <div class="space-y-4">
                    <div class="text-green-400 text-3xl font-bold">03.</div>
                    <h3 class="text-xl font-bold italic">Mudah Digunakan</h3>
                    <p class="text-slate-400 text-sm">Tanpa istilah teknis yang rumit. Jika Anda bisa menggunakan WhatsApp, Anda pasti bisa menggunakan BukuUsaha.id.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-extrabold mb-16">Mulai Hanya Dalam 4 Langkah</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="relative p-6">
                    <div class="text-6xl font-black text-slate-100 absolute -top-4 left-1/2 -translate-x-1/2 z-0">01</div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white shadow-xl rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">👤</div>
                        <h4 class="font-bold mb-2 text-slate-800">Daftar Akun</h4>
                        <p class="text-slate-400 text-sm">Buat akun usaha gratis</p>
                    </div>
                </div>
                <div class="relative p-6">
                    <div class="text-6xl font-black text-slate-100 absolute -top-4 left-1/2 -translate-x-1/2 z-0">02</div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white shadow-xl rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">🏢</div>
                        <h4 class="font-bold mb-2 text-slate-800">Lengkapi Profil</h4>
                        <p class="text-slate-400 text-sm">Isi data identitas UMKM Anda</p>
                    </div>
                </div>
                <div class="relative p-6">
                    <div class="text-6xl font-black text-slate-100 absolute -top-4 left-1/2 -translate-x-1/2 z-0">03</div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white shadow-xl rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">📝</div>
                        <h4 class="font-bold mb-2 text-slate-800">Input Transaksi</h4>
                        <p class="text-slate-400 text-sm">Mulai catat pengeluaran harian</p>
                    </div>
                </div>
                <div class="relative p-6">
                    <div class="text-6xl font-black text-slate-100 absolute -top-4 left-1/2 -translate-x-1/2 z-0">04</div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white shadow-xl rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl">📊</div>
                        <h4 class="font-bold mb-2 text-slate-800">Lihat Laporan</h4>
                        <p class="text-slate-400 text-sm">Laporan siap dikonsultasikan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 mb-24">
        <div class="max-w-6xl mx-auto bg-gradient-custom rounded-[40px] p-12 md:p-20 text-center text-white relative overflow-hidden shadow-2xl shadow-blue-300">
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <svg viewBox="0 0 100 100" class="w-full h-full"><circle cx="50" cy="50" r="40" fill="none" stroke="white" stroke-width="1" stroke-dasharray="5 5"/></svg>
            </div>
            <div class="relative z-10 space-y-8">
                <h2 class="text-4xl md:text-6xl font-extrabold leading-tight">Siap Bikin UMKM <br> Naik Kelas?</h2>
                <p class="text-blue-100 text-lg max-w-2xl mx-auto opacity-80">Ribuan UMKM telah bergabung. Jangan biarkan keuangan Anda jadi penghambat pertumbuhan bisnis.</p>
                <a href="register.php" class="inline-block bg-white text-blue-600 px-12 py-5 rounded-2xl font-extrabold text-xl shadow-xl hover:scale-105 transition-transform active:scale-95">
                    Daftar Sekarang <i class="fa-solid fa-paper-plane ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-slate-100 pt-20 pb-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-1">
                    <a href="#" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">BukuUsaha.id</a>
                    <p class="mt-4 text-slate-500 text-sm leading-relaxed italic">
                        "Bertumbuh Bersama UMKM Indonesia melalui transparansi keuangan digital."
                    </p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </div>
                <div>
                    <h5 class="font-bold mb-6 text-slate-900 uppercase text-xs tracking-widest">Navigasi Cepat</h5>
                    <ul class="space-y-4 text-sm font-medium text-slate-500">
                        <li><a href="index.php" class="hover:text-blue-600 transition">Beranda</a></li>
                        <li><a href="layanan.php" class="hover:text-blue-600 transition">Layanan</a></li>
                        <li><a href="tentang.php" class="hover:text-blue-600 transition">Tentang Kami</a></li>
                        <li><a href="kontak.php" class="hover:text-blue-600 transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold mb-6 text-slate-900 uppercase text-xs tracking-widest">Dukungan</h5>
                    <ul class="space-y-4 text-sm font-medium text-slate-500">
                        <li><a href="#" class="hover:text-blue-600 transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold mb-6 text-slate-900 uppercase text-xs tracking-widest">Hubungi Kami</h5>
                    <ul class="space-y-4 text-sm text-slate-500">
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-blue-600"></i> support@bukuusaha.id
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-blue-600"></i> +62 812 3456 7890
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-10 text-center">
                <p class="text-slate-400 text-xs font-medium uppercase tracking-widest">
                    &copy; 2025 BukuUsaha.id. Tugas Proyek Web Layanan Akuntansi UMKM.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Animasi Scroll Reveal Sederhana
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav div');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-xl');
            } else {
                navbar.classList.remove('shadow-xl');
            }
        });
    </script>
</body>
</html>