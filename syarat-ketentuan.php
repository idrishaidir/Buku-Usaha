<?php 
include 'config/database.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Syarat & Ketentuan - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .clause-card:hover .clause-icon { transform: scale(1.1) rotate(-5deg); }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800">

    <?php include 'navbar.php'; ?>

    <section class="pt-32 pb-16 bg-white border-b border-slate-100">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div class="inline-block px-4 py-1.5 mb-6 text-[10px] font-bold tracking-widest text-slate-400 uppercase bg-slate-50 rounded-full">
                Legalitas & Aturan Layanan
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-6">Syarat & Ketentuan</h1>
            <p class="text-slate-500 text-lg leading-relaxed max-w-2xl mx-auto">
                Terima kasih telah mempercayakan akuntansi digital Anda kepada kami. Harap baca aturan penggunaan layanan kami agar Anda mendapatkan pengalaman terbaik.
            </p>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-5xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <div class="hidden lg:block lg:col-span-1">
                    <div class="sticky top-32 space-y-4" id="pasal-nav">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Navigasi Pasal</h4>
                        <a href="#pendahuluan" class="nav-link block text-sm font-semibold text-slate-500 hover:text-blue-600 transition-all duration-300">1. Pendahuluan</a>
                        <a href="#akun" class="nav-link block text-sm font-semibold text-slate-500 hover:text-blue-600 transition-all duration-300">2. Akun Pengguna</a>
                        <a href="#layanan" class="nav-link block text-sm font-semibold text-slate-500 hover:text-blue-600 transition-all duration-300">3. Penggunaan Layanan</a>
                        <a href="#tanggungjawab" class="nav-link block text-sm font-semibold text-slate-500 hover:text-blue-600 transition-all duration-300">4. Batasan Tanggung Jawab</a>
                        <a href="#kontak" class="nav-link block text-sm font-semibold text-slate-500 hover:text-blue-600 transition-all duration-300">5. Kontak Legal</a>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-12">
                    
                    <div id="pendahuluan" class="clause-card group">
                        <div class="flex gap-6">
                            <div class="clause-icon w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shrink-0 transition duration-300">
                                <i class="fa-solid fa-handshake text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-4">1. Pendahuluan</h3>
                                <p class="text-slate-600 leading-relaxed text-sm">
                                    Dengan mendaftar dan menggunakan layanan <strong>BukuUsaha.id</strong>, Anda secara otomatis menyetujui seluruh syarat dan ketentuan yang berlaku. Layanan ini dirancang untuk membantu UMKM dalam pencatatan keuangan secara digital dan mandiri.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="akun" class="clause-card group">
                        <div class="flex gap-6">
                            <div class="clause-icon w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center shrink-0 transition duration-300">
                                <i class="fa-solid fa-user-shield text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-4">2. Akun Pengguna</h3>
                                <p class="text-slate-600 leading-relaxed text-sm mb-4">
                                    Pengguna wajib memberikan informasi yang akurat saat pendaftaran. Anda bertanggung jawab penuh atas keamanan kata sandi dan seluruh aktivitas yang terjadi di bawah akun Anda.
                                </p>
                                <ul class="bg-slate-50 p-6 rounded-2xl space-y-3">
                                    <li class="flex items-center gap-3 text-xs font-medium text-slate-500">
                                        <i class="fa-solid fa-circle-check text-green-500"></i> Dilarang berbagi akun dengan pihak yang tidak berwenang.
                                    </li>
                                    <li class="flex items-center gap-3 text-xs font-medium text-slate-500">
                                        <i class="fa-solid fa-circle-check text-green-500"></i> Segera lapor jika terjadi indikasi peretasan akun.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div id="layanan" class="clause-card group">
                        <div class="flex gap-6">
                            <div class="clause-icon w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center shrink-0 transition duration-300">
                                <i class="fa-solid fa-laptop-code text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-4">3. Penggunaan Layanan</h3>
                                <p class="text-slate-600 leading-relaxed text-sm">
                                    Layanan hanya boleh digunakan untuk tujuan legal pencatatan keuangan bisnis. Kami berhak menonaktifkan akun yang terindikasi melakukan penyalahgunaan sistem, manipulasi data yang merugikan orang lain, atau percobaan peretasan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="tanggungjawab" class="clause-card group">
                        <div class="flex gap-6">
                            <div class="clause-icon w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center shrink-0 transition duration-300">
                                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 mb-4">4. Batasan Tanggung Jawab</h3>
                                <p class="text-slate-600 leading-relaxed text-sm">
                                    Laporan keuangan yang dihasilkan oleh sistem bersifat informatif berdasarkan input data yang Anda berikan. <strong>BukuUsaha.id</strong> tidak bertanggung jawab atas keputusan bisnis, kerugian finansial, atau kesalahan audit yang diakibatkan oleh kesalahan input pengguna.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="perubahan" class="p-8 bg-blue-600 rounded-[32px] text-white shadow-xl shadow-blue-100">
                        <h3 class="text-xl font-bold mb-4">Pembaruan Ketentuan</h3>
                        <p class="text-blue-100 text-sm leading-relaxed">
                            Kami dapat memperbarui Syarat & Ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya. Penggunaan layanan secara berkelanjutan setelah perubahan dianggap sebagai persetujuan terhadap ketentuan baru.
                        </p>
                    </div>

                    <div id="kontak" class="text-center py-10 bg-white rounded-[32px] border border-dashed border-slate-200">
                        <i class="fa-solid fa-comments text-3xl text-slate-300 mb-4"></i>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Punya Pertanyaan Legal?</h3>
                        <p class="text-slate-400 text-sm mb-6 px-10">Hubungi tim kepatuhan kami jika Anda membutuhkan penjelasan lebih lanjut.</p>
                        <a href="mailto:legal@bukuusaha.id" class="inline-block px-8 py-3 bg-slate-900 text-white rounded-xl font-bold text-sm hover:scale-105 transition">
                            Email Tim Legal
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                window.scrollTo({
                    top: target.offsetTop - 120, 
                    behavior: 'smooth'
                });
            });
        });

        const navLinks = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('.clause-card, #perubahan, #kontak');

        const options = {
            root: null,
            threshold: 0.5, 
            rootMargin: "-100px 0px -40% 0px" 
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    
                    navLinks.forEach(link => {
                        link.classList.remove('text-blue-600', 'font-bold', 'scale-105', 'pl-2');
                        link.classList.add('text-slate-500', 'font-semibold');
                        
                        if (link.getAttribute('href') === '#' + id) {
                            link.classList.add('text-blue-600', 'font-bold', 'scale-105', 'pl-2');
                            link.classList.remove('text-slate-500', 'font-semibold');
                        }
                    });
                }
            });
        }, options);

        sections.forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html>