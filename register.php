<?php 
include 'config.php'; 

if (isset($_POST['register'])) {
    $nama_usaha = mysqli_real_escape_string($conn, $_POST['nama_usaha']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (nama_usaha, email, password) VALUES ('$nama_usaha', '$email', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registrasi Berhasil! Silakan Login'); window.location='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Daftar - BukuUsaha.id</title>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Daftar BukuUsaha.id</h2>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Usaha</label>
                <input type="text" name="nama_usaha" class="w-full p-2 border rounded-lg focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded-lg focus:ring-blue-500" required>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded-lg focus:ring-blue-500" required>
            </div>
            <button name="register" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Daftar Sekarang</button>
        </form>
        <p class="text-center mt-4 text-sm text-gray-600">Sudah punya akun? <a href="login.php" class="text-blue-600 font-bold">Login</a></p>
    </div>
</body>
</html>