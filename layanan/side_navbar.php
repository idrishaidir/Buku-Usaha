<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="lg:hidden fixed top-3 right-3 z-50">
    <div class="flex items-center gap-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-md">
        <a href="../index.php" class="text-sm font-extrabold truncate max-w-[120px] bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">BukuUsaha.id</a>
        <button id="mobile-menu-button" aria-label="Buka menu" class="text-slate-600 p-2 focus:outline-none hover:bg-slate-100 rounded-lg transition">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
    </div>
</div>

<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 p-6 transform -translate-x-full lg:translate-x-0 lg:static lg:flex lg:flex-col transition-transform duration-300 ease-in-out shadow-xl lg:shadow-none">
    <div class="flex items-center justify-between mb-10">
        <a href="../index.php" class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">BukuUsaha.id</a>
        <button id="close-sidebar" class="lg:hidden text-slate-400 hover:text-slate-600">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <nav class="space-y-2">
        <a href="profil.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo ($current_page == 'profil.php') ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50'; ?>">
            <i class="fa-solid fa-user w-5 text-center"></i> Profil
        </a>

        <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo ($current_page == 'dashboard.php') ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50'; ?>">
            <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
        </a>

        <a href="tambah_transaksi.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo ($current_page == 'tambah_transaksi.php') ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50'; ?>">
            <i class="fa-solid fa-plus w-5 text-center"></i> Tambah Transaksi
        </a>

        <a href="riwayat_transaksi.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo ($current_page == 'riwayat_transaksi.php') ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50'; ?>">
            <i class="fa-solid fa-receipt w-5 text-center"></i> Riwayat Transaksi
        </a>

        <a href="bantuan.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?php echo ($current_page == 'bantuan.php') ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' : 'text-slate-500 hover:bg-slate-50'; ?>">
            <i class="fa-solid fa-headset w-5 text-center"></i> Bantuan
        </a>

        <hr class="my-4 border-slate-100">

        <a href="../akun/logout.php" class="flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-2xl transition">
            <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> Logout
        </a>

        <a href="../index.php" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-2xl transition mt-auto">
            <i class="fa-solid fa-angle-left w-5 text-center"></i> Kembali ke Beranda
        </a>
    </nav>
</aside>

<div id="overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden"></div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const closeSidebar = document.getElementById('close-sidebar');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    }

    if (mobileMenuButton) mobileMenuButton.addEventListener('click', toggleSidebar);
    if (closeSidebar) closeSidebar.addEventListener('click', toggleSidebar);
    if (overlay) overlay.addEventListener('click', toggleSidebar);
</script>