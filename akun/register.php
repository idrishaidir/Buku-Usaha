<?php 
// 1. Integrasi Database
include '../config/database.php';

if (isset($_POST['register'])) {
    // Tangkap data dan bersihkan
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $whatsapp     = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $nama_usaha   = mysqli_real_escape_string($conn, $_POST['nama_usaha']);
    $jenis_usaha  = mysqli_real_escape_string($conn, $_POST['jenis_usaha']);
    $skala_usaha  = mysqli_real_escape_string($conn, $_POST['skala_usaha']);
    
    // Validasi Password Match
    if ($_POST['password'] !== $_POST['konfirmasi_password']) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Hashing password untuk keamanan
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (nama_lengkap, email, whatsapp, nama_usaha, jenis_usaha, skala_usaha, password) 
                VALUES ('$nama_lengkap', '$email', '$whatsapp', '$nama_usaha', '$jenis_usaha', '$skala_usaha', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Registrasi Berhasil! Silakan Login'); window.location='login.php';</script>";
        } else {
            $error = "Pendaftaran gagal: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Daftar Akun - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center py-12 px-4 relative overflow-x-hidden">

    <div class="absolute top-0 right-0 w-full h-full -z-0">
        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-blue-100 rounded-full blur-[120px] opacity-60"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-80 h-80 bg-purple-100 rounded-full blur-[100px] opacity-60"></div>
    </div>

    <div class="w-full max-w-4xl relative z-10">
        <div class="text-center mb-10">
            <a href="index.php" class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                BukuUsaha.id
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 mt-4">Mulai Kelola Keuangan UMKM Anda</h1>
            <p class="text-slate-500 mt-2">Daftar sekarang dan nikmati pencatatan yang lebih rapi & profesional.</p>
        </div>

        <div class="glass p-8 md:p-12 rounded-[40px] shadow-2xl shadow-blue-100/50 border border-white">
            
            <?php if(isset($error)): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-8 text-sm flex items-center gap-3 border border-red-100">
                    <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="space-y-6">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-blue-600 border-b border-blue-100 pb-2">Informasi Akun</h3>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" name="nama_lengkap" required placeholder="Nama Anda" 
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Email Aktif</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" name="email" required placeholder="nama@email.com" 
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">No. WhatsApp</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                                <i class="fa-brands fa-whatsapp"></i>
                            </span>
                            <input type="tel" name="whatsapp" required placeholder="0812xxxx" 
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-purple-600 border-b border-purple-100 pb-2">Informasi UMKM</h3>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Nama Usaha</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-purple-600 transition-colors">
                                <i class="fa-solid fa-store"></i>
                            </span>
                            <input type="text" name="nama_usaha" required placeholder="Nama Toko/Usaha" 
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700 ml-1">Jenis Usaha</label>
                            <select name="jenis_usaha" required class="w-full p-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-purple-500/20 outline-none text-sm">
                                <option value="">Pilih--</option>
                                <option value="Kuliner">Kuliner</option>
                                <option value="Jasa">Jasa</option>
                                <option value="Retail">Retail</option>
                                <option value="Produksi">Produksi</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700 ml-1">Skala</label>
                            <select name="skala_usaha" required class="w-full p-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-purple-500/20 outline-none text-sm">
                                <option value="Mikro">Mikro</option>
                                <option value="Kecil">Kecil</option>
                                <option value="Menengah">Menengah</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Password</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-purple-600 transition-colors">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" id="pass" name="password" required placeholder="••••••••" 
                                class="w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 outline-none transition-all">
                            <button type="button" onclick="toggleView('pass', 'eye1')" class="absolute inset-y-0 right-0 pr-4 text-slate-400">
                                <i class="fa-solid fa-eye" id="eye1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 pt-6 space-y-6">
                    <div class="space-y-4">
                        <div class="relative group">
                            <label class="text-sm font-semibold text-slate-700 ml-1">Konfirmasi Password</label>
                            <input type="password" id="confirm" name="konfirmasi_password" required placeholder="Ulangi password" 
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 outline-none transition-all mt-2">
                        </div>
                        
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" required class="w-5 h-5 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 transition-all">
                            <span class="text-sm text-slate-500 group-hover:text-slate-700">Saya menyetujui <a href="#" class="text-blue-600 font-bold hover:underline">Syarat & Kebijakan Privasi</a> BukuUsaha.id</span>
                        </label>
                    </div>

                    <button type="submit" name="register" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-[20px] font-bold text-lg shadow-xl shadow-blue-200 hover:scale-[1.01] active:scale-95 transition-all duration-300">
                        Daftar Akun Sekarang
                    </button>
                    
                    <p class="text-center text-slate-500 text-sm">
                        Sudah memiliki akun? <a href="login.php" class="text-blue-600 font-bold hover:underline">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleView(id, eyeId) {
            const input = document.getElementById(id);
            const eye = document.getElementById(eyeId);
            if (input.type === "password") {
                input.type = "text";
                eye.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                eye.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</body>
</html>