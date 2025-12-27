<?php 
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../akun/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($query);

if (isset($_POST['update_profil'])) {
    $nama_usaha  = mysqli_real_escape_string($conn, $_POST['nama_usaha']);
    $jenis_usaha = mysqli_real_escape_string($conn, $_POST['jenis_usaha']);
    $skala_usaha = mysqli_real_escape_string($conn, $_POST['skala_usaha']);
    $nama_lengkap= mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $whatsapp    = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $alamat      = mysqli_real_escape_string($conn, $_POST['alamat_usaha']);
    
    $foto_profil = $user['foto_profil']; 

    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === 0) {
        $target_dir = "uploads/profiles/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $ext = strtolower(pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION));
        $nama_file_baru = "user_" . $user_id . "_" . time() . "." . $ext;
        $target_file = $target_dir . $nama_file_baru;

        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($ext, $allowed)) {
            if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)) {
                if (!empty($user['foto_profil']) && file_exists($target_dir . $user['foto_profil'])) {
                    unlink($target_dir . $user['foto_profil']);
                }
                $foto_profil = $nama_file_baru;
            }
        }
    }

    $sql = "UPDATE users SET 
            nama_usaha = '$nama_usaha', 
            jenis_usaha = '$jenis_usaha', 
            skala_usaha = '$skala_usaha',
            nama_lengkap = '$nama_lengkap',
            whatsapp = '$whatsapp',
            alamat_usaha = '$alamat',
            foto_profil = '$foto_profil'
            WHERE id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['nama_usaha'] = $nama_usaha;
        echo "<script>alert('Profil UMKM berhasil diperbarui!'); window.location='profil.php';</script>";
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
    <title>Profil UMKM - BukuUsaha.id</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC]">

    <div class="flex min-h-screen">
        <?php include 'side_navbar.php'; ?>

        <main class="flex-1 p-6 lg:p-10">
            <div class="max-w-4xl mx-auto">
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Profil UMKM</h1>
                        <p class="text-slate-500 mt-1">Identitas bisnis Anda yang muncul di laporan dan dashboard.</p>
                    </div>
                    <button onclick="toggleModal()" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Profil
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm text-center">
                        <div class="w-28 h-28 bg-blue-50 rounded-[32px] flex items-center justify-center mx-auto mb-6 overflow-hidden border-4 border-white shadow-xl shadow-blue-100/50">
                            <?php if(!empty($user['foto_profil'])): ?>
                                <img src="uploads/profiles/<?= $user['foto_profil'] ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-4xl font-black text-blue-500"><?= substr($user['nama_usaha'], 0, 1) ?></span>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800"><?= htmlspecialchars($user['nama_usaha']) ?></h3>
                        <p class="text-blue-600 font-bold text-xs uppercase tracking-widest mt-2"><?= htmlspecialchars($user['jenis_usaha']) ?></p>
                        <div class="mt-6 pt-6 border-t border-slate-50 flex justify-center">
                             <span class="px-4 py-2 bg-slate-100 rounded-full text-[10px] font-bold text-slate-500 uppercase tracking-tighter">
                                Skala <?= htmlspecialchars($user['skala_usaha']) ?>
                            </span>
                        </div>
                    </div>

                    <div class="md:col-span-2 bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm">
                        <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8 pb-4 border-b border-slate-50">Informasi Dasar</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Nama Pemilik</label>
                                <p class="font-bold text-slate-800"><?= htmlspecialchars($user['nama_lengkap']) ?></p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Email</label>
                                <p class="font-bold text-slate-800"><?= htmlspecialchars($user['email']) ?></p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">WhatsApp</label>
                                <p class="font-bold text-slate-800"><?= htmlspecialchars($user['whatsapp']) ?></p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Alamat</label>
                                <p class="text-sm text-slate-600 font-medium"><?= nl2br(htmlspecialchars($user['alamat_usaha'] ?? 'Alamat belum diatur')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="modalEdit" class="hidden fixed inset-0 z-[60] overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal()"></div>
            <div class="relative bg-white w-full max-w-2xl rounded-[40px] shadow-2xl p-8 md:p-12">
                <h2 class="text-2xl font-black text-slate-800 mb-8">Edit Profil UMKM</h2>
                
                <form method="POST" enctype="multipart/form-data" onsubmit="return confirm('Simpan perubahan?')">
                    <div class="mb-8 p-6 bg-blue-50/50 rounded-3xl border border-blue-100 flex items-center gap-6">
                        <div class="w-16 h-16 bg-white rounded-2xl overflow-hidden border">
                             <?php if(!empty($user['foto_profil'])): ?>
                                <img src="uploads/profiles/<?= $user['foto_profil'] ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-blue-200"><i class="fa-solid fa-camera text-2xl"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-blue-600 uppercase mb-2">Unggah Foto Profil Baru</label>
                            <input type="file" name="foto_profil" accept="image/*" class="text-xs text-slate-500 cursor-pointer">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Nama UMKM</label>
                            <input type="text" name="nama_usaha" value="<?= $user['nama_usaha'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Nama Pemilik</label>
                            <input type="text" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Jenis Usaha</label>
                            <select name="jenis_usaha" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl">
                                <option <?= $user['jenis_usaha'] == 'Kuliner' ? 'selected' : '' ?>>Kuliner</option>
                                <option <?= $user['jenis_usaha'] == 'Jasa' ? 'selected' : '' ?>>Jasa</option>
                                <option <?= $user['jenis_usaha'] == 'Retail' ? 'selected' : '' ?>>Retail</option>
                                <option <?= $user['jenis_usaha'] == 'Produksi' ? 'selected' : '' ?>>Produksi</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-slate-700">Skala Usaha</label>
                            <select name="skala_usaha" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl">
                                <option <?= $user['skala_usaha'] == 'Mikro' ? 'selected' : '' ?>>Mikro</option>
                                <option <?= $user['skala_usaha'] == 'Kecil' ? 'selected' : '' ?>>Kecil</option>
                                <option <?= $user['skala_usaha'] == 'Menengah' ? 'selected' : '' ?>>Menengah</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2 mb-6">
                        <label class="text-sm font-semibold text-slate-700">WhatsApp</label>
                        <input type="tel" name="whatsapp" value="<?= $user['whatsapp'] ?>" required class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl">
                    </div>

                    <div class="space-y-2 mb-10">
                        <label class="text-sm font-semibold text-slate-700">Alamat Lengkap Usaha</label>
                        <textarea name="alamat_usaha" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl"><?= htmlspecialchars($user['alamat_usaha'] ?? '') ?></textarea>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" onclick="toggleModal()" class="flex-1 px-6 py-4 border border-slate-200 rounded-2xl font-bold text-slate-500">Batal</button>
                        <button type="submit" name="update_profil" class="flex-[2] bg-blue-600 text-white px-6 py-4 rounded-2xl font-bold shadow-xl shadow-blue-100 hover:bg-blue-700 transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal() {
            document.getElementById('modalEdit').classList.toggle('hidden');
        }
    </script>

</body>
</html>