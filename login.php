<?php 
include 'config.php'; 

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        // Verifikasi password hash
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nama_usaha'] = $row['nama_usaha'];
            header("Location: layanan.php");
            exit();
        }
    }
    $error = "Email atau Password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login - BukuUsaha.id</title>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Login BukuUsaha.id</h2>
        <?php if(isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm text-center"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded-lg focus:ring-blue-500" required>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded-lg focus:ring-blue-500" required>
            </div>
            <button name="login" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Masuk</button>
        </form>
    </div>
</body>
</html>