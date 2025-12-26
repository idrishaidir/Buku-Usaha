<?php
// Memulai session jika diperlukan (konsisten dengan halaman lain)
session_start();
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Tentang Kami - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .bg-gradient-soft { background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); }
        .card-hover:hover { transform: translateY(-10px); transition: all 0.3s ease; }

        
    </style>
</head>
<body class="bg-slate-50 text-slate-900 overflow-x-hidden">

    <?php include 'navbar.php'; ?>

    <section class="relative pt-48 pb-32 overflow-hidden bg-slate-900">
        <div class="absolute top-0 left-0 w-full h-full opacity-20">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600 rounded-full blur-[120px] -mr-40 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-purple-600 rounded-full blur-[120px] -ml-20 -mb-20"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                Membantu UMKM Mengelola <br>
                <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Keuangan Lebih Baik</span>
            </h1>
            <p class="text-slate-400 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">
                BukuUsaha.id hadir sebagai mitra strategis bagi pelaku usaha mikro, kecil, dan menengah untuk bertransformasi dari pembukuan manual ke ekosistem digital yang akurat.
            </p>
        </div>
    </section>

    <section class="py-24 container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="bg-white p-8 md:p-12 rounded-[40px] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-5">
                    <i class="fa-solid fa-briefcase text-9xl"></i>
                </div>
                <h2 class="text-3xl font-bold mb-6 text-slate-900 uppercase tracking-tight">Siapa Kami?</h2>
                <p class="text-slate-600 leading-relaxed mb-6">
                    <strong>BukuUsaha.id</strong> adalah platform layanan akuntansi berbasis sistem yang dirancang khusus untuk memenuhi standar pencatatan keuangan profesional tanpa kerumitan teknis. 
                </p>
                <p class="text-slate-600 leading-relaxed">
                    Kami percaya bahwa data keuangan yang transparan adalah kunci utama bagi UMKM untuk mendapatkan akses permodalan, mengoptimalkan profit, dan naik kelas ke skala yang lebih besar.
                </p>
            </div>

            <div class="space-y-8">
                <div class="inline-block px-4 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold uppercase tracking-widest">The Problem</div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Kenapa Kami Ada?</h2>
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-2">Masalah Klasik UMKM</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">Banyak UMKM yang usahanya sangat potensial, namun terhambat karena manajemen kas yang berantakan, nota yang hilang, dan tidak adanya laporan keuangan bulanan yang jelas.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="flex-shrink-0 w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-2">Solusi Digital Kami</h4>
                        <p class="text-slate-500 text-sm leading-relaxed">Kami hadir untuk memutus rantai kerumitan tersebut dengan menyediakan sistem pencatatan yang semudah mengirim pesan teks namun seakurat software akuntansi perusahaan besar.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-slate-50 border-y border-slate-200">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="p-10 bg-gradient-soft rounded-[30px] text-white shadow-xl shadow-blue-200">
                    <h3 class="text-sm font-bold uppercase tracking-[0.2em] mb-4 opacity-80">Visi Kami</h3>
                    <p class="text-2xl md:text-3xl font-extrabold leading-tight">
                        "Menjadi ekosistem akuntansi digital nomor satu yang memberdayakan jutaan UMKM Indonesia untuk mandiri secara finansial."
                    </p>
                </div>
                <div class="p-10 bg-white rounded-[30px] border border-slate-100 shadow-sm">
                    <h3 class="text-sm font-bold text-blue-600 uppercase tracking-[0.2em] mb-6">Misi Kami</h3>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <span class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm">01</span>
                            <p class="text-slate-600 text-sm font-medium">Menyediakan platform akuntansi yang aman, handal, dan mudah diakses dari perangkat apapun.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm">02</span>
                            <p class="text-slate-600 text-sm font-medium">Menyederhanakan proses pelaporan keuangan agar UMKM siap menghadapi standar perbankan dan perpajakan.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm">03</span>
                            <p class="text-slate-600 text-sm font-medium">Memberikan edukasi literasi keuangan berkelanjutan bagi seluruh pengguna platform kami.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Nilai-Nilai Utama Kami</h2>
            <div class="w-20 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card-hover p-10 bg-white rounded-3xl border border-slate-100 shadow-sm text-center">
                <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <h4 class="text-xl font-bold mb-3">Transparansi</h4>
                <p class="text-slate-500 text-sm">Setiap rupiah yang tercatat dapat dilacak dengan jelas dan real-time tanpa ada data yang tersembunyi.</p>
            </div>
            <div class="card-hover p-10 bg-white rounded-3xl border border-slate-100 shadow-sm text-center">
                <div class="w-20 h-20 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
                    <i class="fa-solid fa-shield"></i>
                </div>
                <h4 class="text-xl font-bold mb-3">Keamanan Data</h4>
                <p class="text-slate-500 text-sm">Privasi bisnis Anda adalah prioritas kami. Kami menggunakan enkripsi standar industri untuk melindungi data Anda.</p>
            </div>
            <div class="card-hover p-10 bg-white rounded-3xl border border-slate-100 shadow-sm text-center">
                <div class="w-20 h-20 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h4 class="text-xl font-bold mb-3">Edukasi UMKM</h4>
                <p class="text-slate-500 text-sm">Kami tidak hanya memberikan aplikasi, tapi juga membimbing Anda memahami makna di balik angka keuangan.</p>
            </div>
        </div>
    </section>

    <section class="py-24 bg-blue-600 text-white mx-4 rounded-[50px] overflow-hidden relative">
        <div class="absolute right-0 top-0 w-1/3 h-full bg-white opacity-5 skew-x-12 translate-x-20"></div>
        <div class="container mx-auto px-10 flex flex-col md:flex-row items-center gap-12 relative z-10">
            <div class="md:w-1/2">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-6 italic">Lebih dari Sekedar Aplikasi, Kami Adalah Pendamping.</h2>
                <p class="text-blue-100 leading-relaxed">
                    Kami menyadari bahwa sistem saja tidak cukup. Pendekatan kami menggabungkan kecanggihan teknologi dengan pendampingan berbasis komunitas, sehingga Anda tidak pernah merasa sendirian dalam mengelola bisnis.
                </p>
            </div>
            <div class="md:w-1/2 grid grid-cols-1 gap-4">
                <div class="p-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                    <h5 class="font-bold mb-1">🤝 Community Support</h5>
                    <p class="text-xs text-blue-100">Bergabunglah dengan grup diskusi sesama pengusaha.</p>
                </div>
                <div class="p-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                    <h5 class="font-bold mb-1">📈 Business Coaching</h5>
                    <p class="text-xs text-blue-100">Sesi konsultasi rutin untuk menganalisis pertumbuhan laba Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-32 container mx-auto px-6 text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-3xl font-extrabold text-slate-900 mb-6">Melangkah ke Masa Depan</h2>
            <p class="text-slate-500 leading-relaxed italic">
                "Kami terus berinovasi untuk menghadirkan fitur Artificial Intelligence yang mampu memprediksi arus kas Anda di masa depan dan integrasi otomatis dengan layanan perbankan syariah maupun konvensional. Perjalanan BukuUsaha.id baru saja dimulai."
            </p>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>