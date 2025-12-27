<?php 
include '../config/database.php'; 

if (!isset($_GET['token'])) {
    header("Location: lupa_password.php");
    exit();
}
$token = $_GET['token'];

$stmt = $conn->prepare("SELECT pr.user_id, pr.expires_at, u.email FROM password_resets pr JOIN users u ON pr.user_id = u.id WHERE pr.token = ? LIMIT 1");
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();
$reset = $res->fetch_assoc();

if (!$reset) {
    $error = "Token tidak valid atau sudah digunakan.";
} else {

    if (new DateTime() > new DateTime($reset['expires_at'])) {
        $error = "Link reset sudah kadaluarsa.";

        $del = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $del->bind_param("s", $token);
        $del->execute();
    } elseif (isset($_POST['reset'])) {

        $pw_baru = $_POST['password'];
        $konfirmasi = $_POST['konfirmasi_password'];

        if ($pw_baru !== $konfirmasi) {
            $error = "Konfirmasi password tidak cocok!";
        } else {

            $hashed_pw = password_hash($pw_baru, PASSWORD_DEFAULT);
            $up = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $up->bind_param("si", $hashed_pw, $reset['user_id']);
            if ($up->execute()) {

                $del = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                $del->bind_param("s", $token);
                $del->execute();

                echo "<script>alert('Kata sandi berhasil diperbarui! Silakan login kembali.'); window.location='login.php';</script>";
                exit();
            } else {
                $error = "Gagal memperbarui kata sandi.";
            }
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
    <title>Reset Password - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <div class="glass p-8 md:p-10 rounded-[32px] border border-white shadow-2xl shadow-blue-100/50">
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Buat Password Baru</h2>
            <p class="text-sm text-slate-500 mb-8">Gunakan kombinasi yang kuat agar akun Anda tetap aman.</p>

            <?php if(isset($error)): ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl mb-6 text-sm border border-red-100">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Password Baru</label>
                    <input type="password" name="password" required placeholder="••••••••" 
                        class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700">Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" required placeholder="••••••••" 
                        class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 outline-none">
                </div>

                <button type="submit" name="reset" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-2xl font-bold text-lg shadow-lg hover:scale-[1.02] transition-all">
                    Perbarui Password
                </button>
            </form>
        </div>
    </div>
</body>
</html>