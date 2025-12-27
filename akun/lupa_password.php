<?php 
include '../config/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Alamat email tidak valid.";
    } else {

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows === 1) {
            $row = $res->fetch_assoc();
            $user_id = $row['id'];


            $create_sql = "CREATE TABLE IF NOT EXISTS password_resets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                token VARCHAR(128) NOT NULL UNIQUE,
                expires_at DATETIME NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX (token),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $conn->query($create_sql);

            try {
                $token = bin2hex(random_bytes(32));
            } catch (Exception $e) {
                $token = bin2hex(openssl_random_pseudo_bytes(32));
            }
            $expires_at = date('Y-m-d H:i:s', time() + 3600);


            $del = $conn->prepare("DELETE FROM password_resets WHERE user_id = ?");
            $del->bind_param('i', $user_id);
            $del->execute();


            $ins = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
            $ins->bind_param('iss', $user_id, $token, $expires_at);
            $ins->execute();

           
            header('Location: reset_password.php?token=' . $token);
            exit();
        } else {
           
            $error = "Jika alamat email Anda terdaftar, instruksi reset telah dikirim ke email tersebut.";
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
    <title>Lupa Password - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

    <div class="fixed top-6 left-6 z-50">
        <a href="login.php" class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold text-sm shadow-sm hover:text-blue-600 transition-all group">
            <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i> Kembali ke Login
        </a>
    </div>

    <div class="w-full max-w-md relative">
        <div class="glass p-8 md:p-10 rounded-[32px] border border-white shadow-2xl shadow-blue-100/50">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-6">
                <i class="fa-solid fa-key"></i>
            </div>
            
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Lupa Kata Sandi?</h2>
            <p class="text-sm text-slate-500 mb-8">Masukkan email yang terdaftar untuk memulihkan akses akun dashboard Anda.</p>

            <?php if(isset($error)): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-sm flex items-center gap-3 border border-red-100">
                    <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" onsubmit="return disableSubmit(this)" class="space-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 ml-1">Email Bisnis</label>
                    <input type="email" name="email" required placeholder="nama@bisnis.com" 
                        class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                </div>

                <button type="submit" id="cek_email_btn" name="cek_email" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-blue-100">
                    Lanjutkan Verifikasi
                </button>
            </form>
        </div>
    </div>

    <script>
        function disableSubmit(form) {
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerText = 'Mengirim...';
            }
            return true; 
        }
    </script>
</body>
</html>