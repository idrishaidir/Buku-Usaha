<?php
// Memulai session untuk integrasi sistem login yang sudah ada
session_start();
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Hubungi Kami - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .bg-gradient-soft { background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="fixed w-full z-50 top-0 px-6 py-4">
        <div class="max-w-7xl mx-auto glass rounded-2xl border border-white/40 shadow-lg px-6 py-3 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                BukuUsaha.id
            </a>
            <div class="hidden md:flex space-x-8 text-sm font-semibold text-slate-600">
                <a href="index.php" class="hover:text-blue-600 transition">Beranda</a>
                <a href="layanan.php" class="hover:text-blue-600 transition">Layanan</a>
                <a href="tentang.php" class="hover:text-blue-600 transition">Tentang Kami</a>
                <a href="kontak.php" class="text-blue-600">Kontak</a>
            </div>
            <div>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="layanan.php" class="bg-gradient-soft text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-200 hover:opacity-90 transition">Dashboard</a>
                <?php else: ?>
                    <a href="login.php" class="bg-gradient-soft text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-200 hover:scale-105 transition">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <section class="pt-40 pb-20 bg-slate-50 relative overflow-hidden">
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight">
                Ada Pertanyaan? <br>
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent italic">Kami Siap Mendengar.</span>
            </h1>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto leading-relaxed">
                Konsultasikan kebutuhan akuntansi UMKM Anda secara gratis. Tim ahli kami akan memberikan solusi terbaik untuk pertumbuhan bisnis Anda.
            </p>
        </div>
        <div class="absolute top-0 right-0 -z-0 w-96 h-96 bg-blue-100 rounded-full blur-[100px] opacity-50"></div>
    </section>

    <section class="pb-24 container mx-auto px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-4 space-y-6">
                <div class="p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl mb-6">
                        <i class="fa-brands fa-whatsapp font-bold"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2">WhatsApp Support</h4>
                    <p class="text-slate-500 text-sm mb-4">Respon cepat via chat untuk kendala teknis atau pertanyaan instan.</p>
                    <a href="https://wa.me/6281234567890" class="text-blue-600 font-bold text-sm hover:underline">+62 812-3456-7890</a>
                </div>

                <div class="p-8 bg-white rounded-[32px] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl mb-6">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Email Bisnis</h4>
                    <p class="text-slate-500 text-sm mb-4">Kirimkan proposal kerjasama atau keluhan mendalam ke email kami.</p>
                    <a href="mailto:support@bukuusaha.id" class="text-purple-600 font-bold text-sm hover:underline">support@bukuusaha.id</a>
                </div>

                <div class="p-8 bg-blue-600 rounded-[32px] text-white shadow-lg shadow-blue-200 relative overflow-hidden group">
                    <div class="relative z-10">
                        <h4 class="font-bold text-lg mb-2">Jam Operasional</h4>
                        <div class="space-y-2 opacity-90 text-sm font-medium">
                            <p class="flex justify-between"><span>Senin - Jumat</span> <span>09:00 - 17:00</span></p>
                            <p class="flex justify-between"><span>Sabtu</span> <span>09:00 - 14:00</span></p>
                        </div>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clock text-9xl"></i>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 bg-white p-8 md:p-12 rounded-[40px] border border-slate-100 shadow-sm relative">
                <h3 class="text-2xl font-bold mb-8 text-slate-800">Kirimkan Pesan Anda</h3>
                
                <form action="proses_kontak.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" required placeholder="Masukkan nama Anda"
                            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Email Bisnis</label>
                        <input type="email" name="email" required placeholder="email@usaha.id"
                            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">No. WhatsApp</label>
                        <input type="tel" name="whatsapp" required placeholder="0812xxxx"
                            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Subjek</label>
                        <select name="subjek" required class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition appearance-none">
                            <option value="">Pilih Subjek</option>
                            <option value="Layanan Akuntansi">Layanan Akuntansi</option>
                            <option value="Masalah Akun">Masalah Akun</option>
                            <option value="Kerjasama">Kerjasama</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Pesan Lengkap</label>
                        <textarea name="pesan" rows="5" required placeholder="Ceritakan tantangan keuangan bisnis Anda..."
                            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500 outline-none transition"></textarea>
                    </div>
                    <div class="md:col-span-2 pt-4">
                        <button type="submit" name="kirim" class="w-full md:w-auto bg-gradient-soft text-white px-12 py-5 rounded-2xl font-extrabold shadow-xl shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all duration-300">
                            Kirim Pesan Sekarang <i class="fa-solid fa-paper-plane ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-slate-100 pt-20 pb-10">
        <div class="container mx-auto px-6 text-center">
            <p class="text-slate-400 text-xs font-medium uppercase tracking-widest">
                &copy; 2025 BukuUsaha.id. Tugas Proyek Web Layanan Akuntansi UMKM.
            </p>
        </div>
    </footer>

    <a href="https://wa.me/6281234567890" target="_blank" class="fixed bottom-8 right-8 w-16 h-16 bg-green-500 text-white rounded-full flex items-center justify-center text-2xl shadow-2xl hover:scale-110 active:scale-90 transition z-[60]">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

</body>
</html>