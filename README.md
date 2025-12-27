# BukuUsaha.id 📘

**Aplikasi pencatatan keuangan dan laporan sederhana untuk UMKM (BukuUsaha.id).**

## ✨ Deskripsi singkat
BukuUsaha.id adalah aplikasi web berbasis PHP + MySQL yang membantu pelaku UMKM mencatat transaksi (pemasukan/pengeluaran), menyimpan bukti transaksi, dan melihat riwayat serta laporan sederhana. Aplikasi ini dibuat ringan, responsif untuk mobile, dan mudah dikustomisasi.

## 🧭 Fitur utama
- Autentikasi pengguna (register/login) ✅
- Catat transaksi (tambah, edit, hapus) dengan kategori, metode, dan deskripsi ✅
- Upload bukti transaksi (image/pdf) dan pratinjau kecil ✅
- Profil UMKM yang dapat diedit (nama usaha, jenis, skala, alamat, foto) ✅
- Alur reset password yang lebih aman (token berbasis link, kadaluarsa) ✅
- Sidebar navigasi responsif & tombol menu floating untuk mobile ✅

## 📁 Struktur proyek (intinya)
- `index.php`, `navbar.php`, `footer.php` — layout umum
- `akun/` — halaman otentikasi & manajemen akun (`login.php`, `register.php`, `lupa_password.php`, `reset_password.php`) 🔐
- `layanan/` — fitur utama pengguna (dashboard, `profil.php`, `tambah_transaksi.php`, `edit_transaksi.php`, `riwayat_transaksi.php`, dll.)
- `config/database.php` — konfigurasi koneksi database
- `uploads/` dan `layanan/uploads/profiles/` — tempat penyimpanan file unggahan

## ⚙️ Persyaratan & instalasi
1. Server: PHP 7.4+ (direkomendasikan PHP 8.x), MySQL/MariaDB, dan server web (Apache/Nginx).
2. Salin project ke webroot, mis. `/var/www/html/bukuusaha_id`.
3. Buat database dan atur kredensial di `config/database.php`.
4. (Opsional) Buat tabel `password_resets` di database — contoh SQL di bawah.
5. Pastikan folder `uploads/` dan `layanan/uploads/profiles/` dapat ditulis oleh web server (permission).

Contoh SQL untuk tabel reset password:

```sql
CREATE TABLE password_resets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  token VARCHAR(128) NOT NULL UNIQUE,
  expires_at DATETIME NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (token),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

> Catatan: Untuk keamanan lebih tinggi, sebaiknya simpan hash token alih-alih token mentah.

## 🔐 Keamanan & catatan penting
- Perbaikan reset password: sekarang alur reset menggunakan token (lihat `akun/lupa_password.php` dan `akun/reset_password.php`) yang memiliki masa berlaku dan dihapus setelah dipakai.
- Seluruh perubahan sensitif menggunakan prepared statements untuk mencegah SQL injection (telah diperbarui di beberapa handler).
- Rekomendasi tambahan:
  - Gunakan HTTPS di produksi
  - Simpan hanya hash token (mis. `hash('sha256', $token)`) dan bandingkan hash saat validasi
  - Batasi frekuensi permintaan reset (rate limiting)
  - Validasi dan batasi ukuran/jenis file upload

## 📱 Perbaikan UI Mobile
- `layanan/side_navbar.php` sekarang partial include (tidak menggandakan tag `<head>`/`<body>`) dan memiliki hamburger floating yang rapi di pojok kanan atas.
- `layanan/profil.php`, `layanan/tambah_transaksi.php`, dan `layanan/edit_transaksi.php` sudah diperbaiki agar elemen `Bukti Transaksi` muncul di atas tombol Simpan pada perangkat mobile tanpa merubah tampilan desktop.

## 🧪 Cara testing singkat
- Akses aplikasi via browser. Gunakan DevTools → Device Toolbar untuk memeriksa responsivitas mobile.
- Flow reset password (dev mode): masukkan email di `akun/lupa_password.php` → Anda akan diarahkan ke `akun/reset_password.php?token=...` untuk pengujian. Di produksi, kirim token via email.
- Upload bukti transaksi pada halaman tambah/edit dan pastikan preview muncul di area yang sesuai (mobile/desktop).

## 🤝 Kontribusi
- Fork repo, buat branch fitur/fix, lalu buat pull request. Sertakan deskripsi perubahan dan cara mereplikasi.

## 📬 Kontak
- Untuk pertanyaan atau bantuan implementasi (mis. kirim email otomatis, hashing token, atau audit keamanan), hubungi pengembang/owner proyek.

---
Terima kasih telah menggunakan BukuUsaha.id — semoga membantu mengelola transaksi usaha Anda! 🚀