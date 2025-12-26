<?php
// Mendapatkan nama file yang sedang dibuka
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
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
<body>
    <nav class="fixed w-full z-50 top-0 px-6 py-4">
        <div class="max-w-7xl mx-auto glass rounded-2xl border border-white/40 shadow-lg px-6 py-3 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                BukuUsaha.id
            </a>
            
            <div class="hidden md:flex space-x-8 text-sm font-semibold text-slate-600">
                <a href="index.php" class="text-sm font-bold transition <?= $current_page == 'index.php' ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' ?>">Beranda</a>
                <a href="layanan/dashboard.php" class="text-sm font-bold transition <?= $current_page == 'layanan/dashboard.php' ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' ?>">Layanan</a>
                <a href="tentang.php" class="text-sm font-bold transition <?= $current_page == 'tentang.php' ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' ?>">Tentang Kami</a>
                <a href="kontak.php" class="text-sm font-bold transition <?= $current_page == 'kontak.php' ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' ?>">Kontak</a>
            </div>
    
            <div class="flex items-center gap-4">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="layanan/dashboard.php" class="bg-gradient-custom text-white px-6 py-2.5 rounded-xl font-bold hover:opacity-90 transition shadow-lg shadow-blue-200">Dashboard</a>
                    <a href="logout.php" class="hidden md:block font-bold text-red-500 hover:text-red-700 transition">Logout</a>
                <?php else: ?>
                    <a href="akun/login.php" class="hidden md:block font-bold text-slate-600 hover:text-blue-600 transition">Masuk</a>
                    <a href="akun/register.php" class="bg-gradient-custom text-white px-6 py-2.5 rounded-xl font-bold hover:scale-105 transition shadow-lg shadow-blue-200">Daftar</a>
                <?php endif; ?>
                
                <button class="md:hidden text-slate-600" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
            </div>
        </div>
        
        <div id="mobile-menu" class="hidden md:hidden absolute top-20 left-6 right-6 bg-white rounded-2xl shadow-2xl p-6 border border-slate-100">
            <div class="flex flex-col space-y-4 font-semibold">
                <a href="index.php">Beranda</a>
                <a href="layanan/dashboard.php">Layanan</a>
                <a href="tentang.php">Tentang Kami</a>
                <a href="kontak.php">Kontak</a>
                <hr>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="akun/logout.php" class="text-center py-2 text-red-500">Logout</a>
                <?php else: ?>
                    <a href="akun/login.php" class="text-center py-2">Masuk</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</body>
</html>