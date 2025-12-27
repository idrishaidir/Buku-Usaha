<?php 
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Pusat Bantuan - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .accordion-content { transition: max-height 0.3s ease-out; overflow: hidden; max-height: 0; }
        .accordion-open .accordion-content { max-height: 500px; }
        .accordion-open .icon-chevron { transform: rotate(180deg); }
    </style>
</head>
<body class="bg-[#F8FAFC]">

    <div class="flex min-h-screen">
        <?php include 'side_navbar.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <div class="max-w-5xl mx-auto">
                
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Ada yang bisa kami bantu?</h1>
                    <p class="text-slate-500 max-w-2xl mx-auto italic">Temukan panduan lengkap penggunaan fitur BukuUsaha.id dan tips akuntansi praktis untuk memajukan bisnis UMKM Anda.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        
                        <section>
                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i class="fa-solid fa-book-open text-blue-600"></i> Panduan Penggunaan Fitur
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-plus-circle"></i>
                                    </div>
                                    <h4 class="font-bold text-slate-800 mb-2">Tambah Transaksi</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed">Klik menu "Tambah Transaksi", pilih jenis (Masuk/Keluar), isi nominal, dan jangan lupa unggah bukti transaksi.</p>
                                </div>
                                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                    <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-chart-pie"></i>
                                    </div>
                                    <h4 class="font-bold text-slate-800 mb-2">Laporan Keuangan</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed">Pantau arus kas di Dashboard. Gunakan menu Riwayat untuk mengekspor laporan bulanan ke format PDF.</p>
                                </div>
                            </div>
                        </section>

                        <section>
                            <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i class="fa-solid fa-circle-question text-blue-600"></i> Pertanyaan Sering Diajukan
                            </h3>
                            <div class="space-y-3">
                                <div class="accordion-item bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                                    <button onclick="toggleAccordion(this)" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-slate-50 transition">
                                        <span class="text-sm font-bold text-slate-700">Apa itu Laporan Laba Rugi?</span>
                                        <i class="fa-solid fa-chevron-down text-slate-400 icon-chevron transition"></i>
                                    </button>
                                    <div class="accordion-content bg-slate-50/50">
                                        <div class="p-6 text-sm text-slate-600 leading-relaxed">
                                            Laporan Laba Rugi adalah ringkasan pendapatan dan biaya usaha Anda dalam periode tertentu. Jika pendapatan lebih besar dari biaya, Anda mengalami keuntungan (Laba), begitu juga sebaliknya.
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                                    <button onclick="toggleAccordion(this)" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-slate-50 transition">
                                        <span class="text-sm font-bold text-slate-700">Apakah data saya aman?</span>
                                        <i class="fa-solid fa-chevron-down text-slate-400 icon-chevron transition"></i>
                                    </button>
                                    <div class="accordion-content bg-slate-50/50">
                                        <div class="p-6 text-sm text-slate-600 leading-relaxed">
                                            Ya, data Anda disimpan di database terenkripsi dan hanya dapat diakses melalui akun Anda. Kami melakukan backup berkala untuk memastikan data transaksi Anda tidak hilang.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="space-y-8">
                        
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-8 rounded-[32px] text-white shadow-xl shadow-blue-100">
                            <h3 class="font-bold text-lg mb-4">Tips Akuntansi UMKM</h3>
                            <ul class="space-y-4">
                                <li class="flex gap-3">
                                    <i class="fa-solid fa-check-double text-blue-200 mt-1"></i>
                                    <p class="text-xs leading-relaxed text-blue-50">Pisahkan rekening pribadi dengan rekening usaha agar arus kas jelas.</p>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fa-solid fa-check-double text-blue-200 mt-1"></i>
                                    <p class="text-xs leading-relaxed text-blue-50">Catat setiap pengeluaran sekecil apapun, termasuk biaya admin bank.</p>
                                </li>
                                <li class="flex gap-3">
                                    <i class="fa-solid fa-check-double text-blue-200 mt-1"></i>
                                    <p class="text-xs leading-relaxed text-blue-50">Lakukan evaluasi mingguan untuk melihat pengeluaran yang bisa dihemat.</p>
                                </li>
                            </ul>
                        </div>

                        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm text-center">
                            <div class="w-16 h-16 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <i class="fa-solid fa-headset text-2xl"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-2">Butuh Bantuan Lebih?</h4>
                            <p class="text-xs text-slate-400 mb-6 leading-relaxed">Tim dukungan kami siap membantu Anda setiap Senin - Jumat.</p>
                            <div class="space-y-3">
                                <a href="https://wa.me/62812345678" target="_blank" class="block w-full py-3 bg-green-500 text-white rounded-xl font-bold text-sm hover:bg-green-600 transition shadow-lg shadow-green-100">
                                    <i class="fa-brands fa-whatsapp mr-2"></i> WhatsApp Kami
                                </a>
                                <a href="mailto:support@bukuusaha.id" class="block w-full py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition">
                                    <i class="fa-solid fa-envelope mr-2"></i> Email Support
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleAccordion(button) {
            const item = button.parentElement;
            const isOpen = item.classList.contains('accordion-open');
            

            document.querySelectorAll('.accordion-item').forEach(el => {
                el.classList.remove('accordion-open');
            });


            if (!isOpen) {
                item.classList.add('accordion-open');
            }
        }
    </script>
</body>
</html>