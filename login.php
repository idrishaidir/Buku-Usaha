<?php 
// Memulai session untuk pengecekan login (Konsisten dengan config/database.php)
include 'config/database.php'; 

if (isset($_POST['login'])) {
    // Logika backend sederhana (Konsisten dengan file login.php lama)
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nama_usaha'] = $row['nama_usaha'];
            header("Location: layanan.php");
            exit();
        }
    }
    $error = "Email atau Password tidak sesuai!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Login - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); }
        .bg-gradient-fintech { background: radial-gradient(circle at top left, #eff6ff 0%, #ffffff 50%, #f5f3ff 100%); }
    </style>
</head>
<body class="bg-gradient-fintech min-h-screen flex items-center justify-center p-6">

    <div class="fixed top-0 left-0 w-96 h-96 bg-blue-200 rounded-full blur-[120px] opacity-30 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="fixed bottom-0 right-0 w-80 h-80 bg-purple-200 rounded-full blur-[100px] opacity-30 translate-x-1/3 translate-y-1/3"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-8">
            <a href="index.php" class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                BukuUsaha.id
            </a>
            <p class="text-slate-500 mt-2 font-medium">Lanjutkan kelola keuangan UMKM Anda</p>
        </div>

        <div class="glass p-8 md:p-10 rounded-[32px] border border-white shadow-2xl shadow-blue-100/50">
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Selamat Datang Kembali</h2>
            <p class="text-sm text-slate-500 mb-8">Akses dashboard akuntansi Anda sekarang.</p>

            <?php if(isset($error)): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-sm flex items-center gap-3 border border-red-100">
                    <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 ml-1">Email Bisnis</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" required placeholder="nama@bisnis.com" 
                            class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-sm font-semibold text-slate-700">Password</label>
                        <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">Lupa Password?</a>
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-blue-600 transition-colors">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" required placeholder="••••••••" 
                            class="w-full pl-11 pr-12 py-3.5 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 transition">
                            <i class="fa-solid fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2 ml-1">
                    <input type="checkbox" id="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label for="remember" class="text-sm text-slate-600 cursor-pointer">Ingat perangkat ini</label>
                </div>

                <button type="submit" name="login" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all duration-300">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-600">
                    Belum punya akun usaha? 
                    <a href="register.php" class="text-blue-600 font-bold hover:underline ml-1">Daftar Sekarang</a>
                </p>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center gap-2 text-slate-400">
            <i class="fa-solid fa-shield-halved text-xs"></i>
            <span class="text-[10px] font-bold uppercase tracking-[0.2em]">Data akun Anda aman & terenkripsi</span>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>