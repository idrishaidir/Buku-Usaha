-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 27, 2025 at 04:12 PM
-- Server version: 8.0.44-0ubuntu0.24.04.2
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bukuusaha_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `token` varchar(128) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesan_kontak`
--

CREATE TABLE `pesan_kontak` (
  `id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `subjek` varchar(50) DEFAULT NULL,
  `pesan` text,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesan_kontak`
--

INSERT INTO `pesan_kontak` (`id`, `nama`, `email`, `whatsapp`, `subjek`, `pesan`, `tanggal`) VALUES
(1, 'meow', 'kucingmeow@gmail.com', '210312411142', 'Layanan Akuntansi', 'binung', '2025-12-26 10:49:41'),
(2, 'sad', 'sad@gmail.com', '2311', 'Layanan Akuntansi', 'dsadaadsmkam', '2025-12-26 10:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `jenis_transaksi` enum('pemasukan','pengeluaran') NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `metode` varchar(30) NOT NULL,
  `deskripsi` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `bukti_transaksi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `jenis_transaksi`, `tanggal`, `nominal`, `kategori`, `metode`, `deskripsi`, `created_at`, `bukti_transaksi`) VALUES
(7, 1, 'pengeluaran', '2025-12-26', 20000.00, 'Operasional', 'Tunai', 'hbkjbkj', '2025-12-26 15:12:51', '694ea5f35af16.png'),
(8, 2, 'pemasukan', '2025-12-26', 2000000.00, 'Penjualan Produk', 'Transfer', 'jual chiki', '2025-12-26 17:00:00', ''),
(9, 1, 'pengeluaran', '2025-12-27', 1000000.00, 'Bahan Baku', 'Tunai', 'Memberi Shampo Kucing', '2025-12-27 04:50:53', '694f65ad93aaa.png'),
(11, 1, 'pemasukan', '2025-12-27', 5000000.00, 'Penjualan Produk', 'Tunai', 'Jual Cakar', '2025-12-27 13:38:18', ''),
(13, 1, 'pengeluaran', '2025-12-27', 200000.00, 'Operasional', 'Tunai', 'LEM', '2025-12-27 13:41:52', ''),
(14, 1, 'pemasukan', '2025-12-27', 2000000.00, 'Lainnya', 'Tunai', 'CASHBACK', '2025-12-27 13:42:18', ''),
(15, 1, 'pemasukan', '2025-12-27', 2000000.00, 'Bahan Baku', 'Tunai', 'Cashback', '2025-12-27 13:42:41', ''),
(16, 1, 'pengeluaran', '2025-12-27', 20000.00, 'Gaji Karyawan', 'Transfer', 'GAJI ', '2025-12-27 13:42:56', ''),
(19, 1, 'pengeluaran', '2025-12-27', 100000.00, 'Bahan Baku', 'Tunai', 'Bahan Baru 1', '2025-12-27 13:50:39', ''),
(20, 1, 'pemasukan', '2025-12-27', 100000.00, 'Penjualan Produk', 'Tunai', 'Jualan Bulu', '2025-12-27 13:59:46', ''),
(21, 1, 'pengeluaran', '2025-12-27', 100000.00, 'Operasional', 'E-Wallet', '', '2025-12-27 14:21:36', ''),
(22, 1, 'pengeluaran', '2025-12-27', 10000.00, 'Bahan Baku', 'Transfer', 'Beli Bahan Baku', '2025-12-27 14:45:42', '694ff116c99a9.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama_usaha` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `whatsapp` varchar(20) DEFAULT NULL,
  `jenis_usaha` varchar(50) DEFAULT NULL,
  `skala_usaha` varchar(20) DEFAULT NULL,
  `alamat_usaha` text,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_usaha`, `nama_lengkap`, `email`, `password`, `created_at`, `whatsapp`, `jenis_usaha`, `skala_usaha`, `alamat_usaha`, `foto_profil`) VALUES
(1, 'MEOWW', 'Bakrie', 'meow@gmail.com', '$2y$10$uyRbZbw8rvIUi3wg0ac5IOU4fGosRpumFZav6T3MLRoOqGoWigChK', '2025-12-26 11:22:30', '089320231', 'Jasa', 'Mikro', 'madiun raya', 'user_1_1766765804.png'),
(2, 'chitato lite', 'ahmad syahroni', 'chitato@gmail.com', '$2y$10$X6/9zaPt5ahBvCIhJEdxZeWmk6pZL.1NLJFHRFBQoRt6T4bk/1vCu', '2025-12-26 16:57:22', '089531252', 'Kuliner', 'Kecil', NULL, NULL),
(3, 'Vit Mineral', 'Samsul Bakrie', 'vit_mineral@gmail.com', '$2y$10$xQDWI8Oiv3110VVGRytLzOkNngSZU96C3gxw4tHL6MqeFllppZdaC', '2025-12-27 12:58:49', '0812939123', 'Produksi', 'Menengah', NULL, NULL),
(4, 'Daging Cincang TItan', 'Eren', 'Eren@user.com', '$2y$10$HVNJSHqAMvCzfEIquHlJauvboNxqbl71gui66JtEhjiEH.5foBYUS', '2025-12-27 13:55:09', '3214124123', 'Kuliner', 'Menengah', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `token_2` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
