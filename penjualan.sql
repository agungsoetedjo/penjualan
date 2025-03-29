-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 29 Mar 2025 pada 12.18
-- Versi server: 8.0.30
-- Versi PHP: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Minuman Sachet', '2025-03-23 11:30:41', '2025-03-26 23:15:32'),
(2, 'Minuman Botol', '2025-03-28 23:06:32', '2025-03-28 23:06:32'),
(3, 'Minuman Kaleng', '2025-03-28 23:06:40', '2025-03-28 23:06:40'),
(4, 'Minuman Box', '2025-03-28 23:06:50', '2025-03-28 23:07:47'),
(5, 'Minuman Gelas', '2025-03-28 23:08:31', '2025-03-28 23:08:31'),
(6, 'Sabun', '2025-03-25 20:34:10', '2025-03-25 20:34:10'),
(7, 'Deterjen Bubuk', '2025-03-25 21:54:24', '2025-03-26 23:15:39'),
(8, 'Pewangi', '2025-03-25 22:08:09', '2025-03-25 22:08:09'),
(9, 'Sampo', '2025-03-28 23:08:57', '2025-03-28 23:08:57'),
(10, 'Obat', '2025-03-28 23:09:14', '2025-03-28 23:09:14'),
(11, 'Bumbu Penyedap', '2025-03-28 23:09:26', '2025-03-28 23:09:26'),
(12, 'Jajanan', '2025-03-28 23:10:28', '2025-03-28 23:10:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_24_072736_create_kategori_table', 1),
(5, '2025_03_24_072747_create_produk_table', 1),
(6, '2025_03_24_072802_create_keranjang_table', 1),
(7, '2025_03_24_072813_create_transaksi_table', 1),
(8, '2025_03_24_072826_create_transaksi_detail_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `harga`, `stok`, `kategori_id`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'ABC Susu', 2000.00, 8, 1, 'produk_img/AGVKSdcBSrVTKDuFKoGV.jpg', '2025-03-22 21:52:44', '2025-03-26 19:49:57'),
(2, 'AMH Jahe Merah', 2000.00, 10, 1, 'produk_img/DREotzPgtQGsDtKu0Hil.png', '2025-03-28 08:34:05', '2025-03-28 08:34:05'),
(3, 'Anget Sari Susu Jahe', 2000.00, 10, 1, 'produk_img/JbKFz3Uq5QFqVwCTiyIJ.png', '2025-03-28 08:34:26', '2025-03-28 08:34:26'),
(4, 'Good Day Cappucino', 2500.00, 20, 1, 'produk_img/fP43jHkkdDYfbCDPH2Pm.jpg', '2025-03-25 10:34:35', '2025-03-26 00:02:13'),
(5, 'Good Day Moccacino 20g', 2000.00, 10, 1, 'produk_img/XruiDSGQqbEIAy97B3hL.png', '2025-03-26 00:31:06', '2025-03-26 00:31:06'),
(6, 'Good Day Chococino', 2000.00, 10, 1, 'produk_img/cIT2r7PuF45rM8sAzzJT.png', '2025-03-26 10:49:27', '2025-03-26 10:49:27'),
(7, 'Indocafe Coffemix', 2000.00, 20, 1, 'produk_img/l4eAbTuSsT1b4I6DPjSP.png', '2025-03-25 10:38:23', '2025-03-26 00:02:23'),
(8, 'Kapal Api Specialmix', 2000.00, 10, 1, 'produk_img/JEQUnZReYTXBtYM6BvcJ.png', '2025-03-25 06:20:08', '2025-03-25 23:59:14'),
(9, 'Luwak White Koffie', 2000.00, 0, 1, 'produk_img/9KLsccuerFMl7NpCdBWx.png', '2025-03-26 08:55:25', '2025-03-26 10:12:59'),
(10, 'Sariwangi', 1000.00, 10, 1, 'produk_img/qcEWVe8ynORiTyOgzVes.jpg', '2025-03-26 10:06:02', '2025-03-26 10:06:02'),
(11, 'Tora Bika Creamy Latte', 2000.00, 5, 1, 'produk_img/bC4ylQwmwopdySrkHRDI.jpg', '2025-03-24 04:10:54', '2025-03-25 23:59:07'),
(12, 'Dancow Putih', 4500.00, 10, 1, 'produk_img/QZipOaGIThSIYIbqHjhn.png', '2025-03-26 10:11:35', '2025-03-28 08:27:32'),
(13, 'Dancow Coklat', 4500.00, 0, 1, 'produk_img/DHg8Au8LnXO7djREBtZO.png', '2025-03-26 10:11:49', '2025-03-26 10:11:49'),
(14, 'Energen Vanilla', 2000.00, 10, 1, 'produk_img/0nwTV9Xkmkt9SWtv7rSs.png', '2025-03-22 21:49:51', '2025-03-26 01:23:38'),
(15, 'Energen Coklat', 2000.00, 10, 1, 'produk_img/lwcb5b3Z3Qpb2gyOeYDT.png', '2025-03-26 09:03:51', '2025-03-26 09:03:51'),
(16, 'Energen Champion', 2500.00, 0, 1, 'produk_img/dOWb10ukPoSICT5JYGDi.png', '2025-03-26 09:02:01', '2025-03-28 08:28:15'),
(17, 'Energen Kacang Hijau', 2000.00, 10, 1, 'produk_img/q12Fm2xgHHJoyLWBpZwT.png', '2025-03-26 09:11:17', '2025-03-26 09:11:17'),
(18, 'Frisian Flag Cokelat', 2000.00, 20, 1, 'produk_img/mM4pfXT72wg1uP6JZzeY.png', '2025-03-26 08:59:04', '2025-03-26 08:59:04'),
(19, 'Frisian Flag Putih', 2000.00, 20, 1, 'produk_img/sNzNcMnkcOZzw7G6Y7C3.png', '2025-03-26 08:58:51', '2025-03-26 08:58:51'),
(20, 'Milo Bubuk 25g', 2000.00, 15, 1, 'produk_img/WqAFycVeSpY2wLMTtdCY.png', '2025-03-25 23:13:35', '2025-03-26 00:02:35'),
(21, 'Aqua 600mL', 4000.00, 10, 2, 'produk_img/LmgLMYcvtNSzxG73RScS.png', '2025-03-28 23:26:35', '2025-03-28 23:26:35'),
(22, 'Le Minerale 600mL', 4000.00, 5, 2, 'produk_img/UHuZJGxcNOOEWpQi6vj1.png', '2025-03-28 23:26:58', '2025-03-28 23:26:58'),
(23, 'Floridina Coco 350mL', 3500.00, 15, 2, 'produk_img/E2HrMHZcZeolopHBXWCq.png', '2025-03-28 23:34:08', '2025-03-28 23:34:08'),
(24, 'Teh Pucuk 350mL', 4000.00, 10, 2, 'produk_img/CIn9bgUTg1F0BssfluG4.png', '2025-03-28 23:34:30', '2025-03-28 23:34:30'),
(25, 'Golda Coffee Cappucino 200mL', 3500.00, 10, 2, 'produk_img/IyB9zxAohvedQByEpIWj.png', '2025-03-28 23:35:25', '2025-03-28 23:35:25'),
(26, 'Pocari Sweat 350mL', 7000.00, 2, 2, 'produk_img/AAtOBqtDojVIwSGgFRHO.png', '2025-03-28 23:40:44', '2025-03-28 23:40:44'),
(27, 'Adem Sari 350mL', 7500.00, 5, 2, 'produk_img/StrQjT1kkucU3lRoWrHp.png', '2025-03-28 23:41:11', '2025-03-28 23:41:11'),
(28, 'Milku Stroberi 200mL', 3500.00, 0, 2, 'produk_img/QrjAchZEhBs7eawmAUQC.png', '2025-03-29 00:01:52', '2025-03-29 00:01:52'),
(29, 'Milku Coklat 200mL', 3500.00, 0, 2, 'produk_img/Gsz1KN0YqN72JEFopI1A.png', '2025-03-29 00:02:19', '2025-03-29 00:02:19'),
(30, 'Mogu Mogu 320mL', 11000.00, 0, 2, 'produk_img/mhjingUGAYVoPFxnCIJC.png', '2025-03-29 00:03:12', '2025-03-29 00:03:12'),
(31, 'Yakult', 2500.00, 5, 2, 'produk_img/ME7bXxmieBR3q7DD1P3P.png', '2025-03-29 00:03:45', '2025-03-29 00:03:45'),
(32, 'NU Milktea 330mL', 7500.00, 0, 2, 'produk_img/C9T58rHMD3BYuJtBlakN.png', '2025-03-29 00:04:52', '2025-03-29 00:04:52'),
(33, 'NU Greentea 330mL', 4500.00, 0, 2, 'produk_img/Lp2KFwOAUVOaasoQktsI.png', '2025-03-29 00:05:11', '2025-03-29 00:05:11'),
(34, 'Nestle Bear Brand 189mL', 11000.00, 2, 3, 'produk_img/ztP8VAae1nvTr6EDfN5x.png', '2025-03-29 00:13:56', '2025-03-29 00:13:56'),
(35, 'Nescafe Caramel Machiato 220mL', 7500.00, 1, 3, 'produk_img/aCLUlyCB9qn2ZLiMFX7c.png', '2025-03-29 00:17:18', '2025-03-29 00:17:18'),
(36, 'Nescafe Cappucino 220mL', 7500.00, 1, 3, 'produk_img/3L6ip3kULbtWTVyLVUxQ.png', '2025-03-29 00:18:13', '2025-03-29 00:18:13'),
(37, 'Adem Sari Chingku 320mL', 7500.00, 1, 3, 'produk_img/apTwAsIj6hgx7pAhN4Tw.png', '2025-03-29 00:19:16', '2025-03-29 00:19:16'),
(38, 'Larutan Jeruk Anak 238mL', 6000.00, 1, 3, 'produk_img/RotqD2VG7MxdRQrSAcxq.png', '2025-03-29 00:22:59', '2025-03-29 00:23:09'),
(39, 'Grass Jelly Cap Panda 310mL', 6500.00, 1, 3, 'produk_img/PtryP9HhcZr1Kcn2SzW2.png', '2025-03-29 00:24:11', '2025-03-29 00:24:11'),
(40, 'Larutan Cap Kaki Tiga 320mL', 7500.00, 5, 3, 'produk_img/OQBnTaXJ9iYLWj0jVn23.png', '2025-03-29 00:25:11', '2025-03-29 00:25:11'),
(41, 'Teh Kotak 200mL', 4000.00, 0, 4, 'produk_img/TrlRK3IFg5xavG6wtZO1.png', '2025-03-29 00:49:19', '2025-03-29 00:49:19'),
(42, 'Ultramilk Full Cream 125mL', 4000.00, 5, 4, 'produk_img/WVFTfHJg4iJnBkIbTZSR.png', '2025-03-29 00:50:06', '2025-03-29 00:50:06'),
(43, 'Ultramilk Full Cream 200mL', 6000.00, 0, 4, 'produk_img/UNhqzRlhANnLVYqMgWW1.png', '2025-03-29 01:21:59', '2025-03-29 01:21:59'),
(44, 'Ultramilk Full Cream 250mL', 7000.00, 10, 4, 'produk_img/vNj53yCa3eNV1CvEgbu1.png', '2025-03-29 01:22:27', '2025-03-29 01:22:27'),
(45, 'Ultramilk Stroberi 125mL', 4000.00, 5, 4, 'produk_img/1KMuWrAr5xc3ebOfHeV6.png', '2025-03-29 01:22:53', '2025-03-29 01:22:53'),
(46, 'Ultramilk Stroberi 200mL', 6000.00, 0, 4, 'produk_img/GzQ7J0Z4kOluFYogk3CG.png', '2025-03-29 01:23:23', '2025-03-29 01:23:23'),
(47, 'Ultramilk Stroberi 250mL', 7000.00, 10, 4, 'produk_img/JqB8Yvmo6fJtVPQH0MhK.png', '2025-03-29 01:23:43', '2025-03-29 01:23:43'),
(48, 'Ultramilk Coklat 125mL', 4000.00, 10, 4, 'produk_img/SuLja4ISvCH0Wo1i7ba3.png', '2025-03-29 01:24:19', '2025-03-29 01:24:19'),
(49, 'Ultramilk Coklat 200mL', 6000.00, 0, 4, 'produk_img/ZS7BqTZf1dsCoi1YWdEe.png', '2025-03-29 01:24:41', '2025-03-29 01:24:41'),
(50, 'Ultramilk Coklat 250mL', 7000.00, 10, 4, 'produk_img/dzApSRCwtq2D9W4PXIGN.png', '2025-03-29 01:25:01', '2025-03-29 01:25:01'),
(51, 'Nestle Milo 110mL', 4000.00, 0, 4, 'produk_img/TYr6dwkcQd6mTOecsHO0.png', '2025-03-29 01:25:44', '2025-03-29 01:25:44'),
(52, 'Ekonomi Ungu', 2000.00, 20, 6, 'produk_img/NA4ZsW3Xdu8umcawNhbn.jpg', '2025-03-26 09:50:03', '2025-03-26 09:50:03'),
(53, 'Ekonomi Putih', 1000.00, 10, 6, 'produk_img/FRmUCzUEYIdkN8lTTbHM.jpg', '2025-03-26 10:06:57', '2025-03-26 10:06:57'),
(54, 'Rinso Cair', 1000.00, 30, 6, 'produk_img/kqIeEOYz8OpEjiIhVcZy.png', '2025-03-25 06:34:29', '2025-03-25 23:59:20'),
(55, 'So Klin Liquid 20mL', 500.00, 50, 6, 'produk_img/dYQ1gSguTNQQ2CCHpzlm.jpg', '2025-03-25 06:57:00', '2025-03-26 00:00:53'),
(56, 'So Klin Lantai Lavender Bloom', 500.00, 10, 6, 'produk_img/ZXYyr0ionDxNsKJlJGne.jpg', '2025-03-25 08:03:15', '2025-03-26 00:01:37'),
(57, 'So Klin Lantai Apple & Peony', 500.00, 10, 6, 'produk_img/sxulBIz0vNlFZJdyBCeK.jpg', '2025-03-25 08:06:16', '2025-03-26 00:01:45'),
(58, 'Sunlight', 2500.00, 10, 6, 'produk_img/Vi8AMCKwL4h4olgX5TT3.jpg', '2025-03-26 10:06:34', '2025-03-26 10:06:34'),
(59, 'Lifebuoy Merah', 4500.00, 10, 6, 'produk_img/AIWsAIhwGVPUlHdu0mpj.png', '2025-03-26 09:47:39', '2025-03-26 09:47:39'),
(60, 'LUX Botanical Ungu', 5000.00, 10, 6, 'produk_img/RcTcUxFk7LnNUgMBpmev.png', '2025-03-26 09:44:24', '2025-03-26 09:44:24'),
(61, 'LUX Botanical Kuning', 5000.00, 10, 6, 'produk_img/TRkLeFtrOigtJxj7hGvQ.jpg', '2025-03-26 09:46:08', '2025-03-26 09:46:08'),
(62, 'Nuvo Family Biru', 4000.00, 10, 6, 'produk_img/FIP6tA6aviaWFcF0iD8U.png', '2025-03-26 09:45:23', '2025-03-26 09:45:23'),
(63, 'Daia Putih', 1000.00, 10, 7, 'produk_img/6RtTAIizIJrDoYFeJymw.jpg', '2025-03-25 07:55:26', '2025-03-26 00:01:29'),
(64, 'Rinso Bubuk', 1000.00, 10, 7, 'produk_img/q5t9DoEVwhiBym4o40J3.jpg', '2025-03-25 07:54:43', '2025-03-26 00:01:16'),
(65, 'Biosol Karbol', 500.00, 12, 8, 'produk_img/NU2br5HgmQRctvqT1l5k.jpg', '2025-03-26 10:07:33', '2025-03-26 10:07:33'),
(66, 'Kispray Violet', 500.00, 10, 8, 'produk_img/0ru3jE8ZwC625A8AgHao.jpg', '2025-03-25 08:08:37', '2025-03-26 00:02:03'),
(67, 'Softener Pink', 500.00, 20, 8, 'produk_img/61zTN0SQhFquZHIPpPUI.png', '2025-03-26 09:49:06', '2025-03-26 09:49:06'),
(68, 'Softener Twilight Biru', 500.00, 20, 8, 'produk_img/3dKwLMX2XT3CVrXRr5XM.png', '2025-03-26 09:48:20', '2025-03-26 09:48:20'),
(69, 'Softener Twilight Ungu', 500.00, 20, 8, 'produk_img/hS9uEnepEwRBqeqvFBxb.png', '2025-03-26 09:48:40', '2025-03-26 09:48:40'),
(70, 'Clear Anti Ketombe', 1000.00, 20, 9, 'produk_img/vD6HM9LLHyJ7R17RqTuD.png', '2025-03-29 10:35:06', '2025-03-29 10:35:06'),
(71, 'Sunsilk Black Shine', 1000.00, 20, 9, 'produk_img/osK4VwV7MXmeLxBXHD5D.png', '2025-03-29 10:35:43', '2025-03-29 10:35:43'),
(72, 'Pantene Anti Ketombe', 1000.00, 0, 9, 'produk_img/XzAp1mEtC8LMbV0GpQRT.png', '2025-03-29 10:36:04', '2025-03-29 10:36:04'),
(73, 'Pantene Perawatan Rambut Rontok', 1000.00, 20, 9, 'produk_img/TCF0nplnozdZtEfcTr63.png', '2025-03-29 10:36:23', '2025-03-29 10:36:23'),
(74, 'Pantene Kondisioner', 1000.00, 20, 9, 'produk_img/UtZRDhUv4Seh8nZxMIE4.png', '2025-03-29 10:36:42', '2025-03-29 10:36:42'),
(75, 'Segar Dingin', 1500.00, 10, 1, 'produk_img/hPUHwDNmxXg1ItZ068pf.png', '2025-03-29 10:59:37', '2025-03-29 10:59:37'),
(76, 'Nutrisari Florida Orange', 1500.00, 10, 1, 'produk_img/lFiessdCmPjxI2JF4i0A.png', '2025-03-29 10:59:56', '2025-03-29 10:59:56'),
(77, 'Komix OBH', 2000.00, 20, 10, 'produk_img/EM9cW2ubyBvN0sPXQj5g.png', '2025-03-29 11:39:11', '2025-03-29 11:39:11'),
(78, 'Komix Peppermint', 1000.00, 20, 10, 'produk_img/R0aMqNwlvjla0PKQK9h2.png', '2025-03-29 11:39:59', '2025-03-29 11:39:59'),
(79, 'Komix Jahe', 1000.00, 20, 10, 'produk_img/qyJIo72hB6a7I2qHgRkD.png', '2025-03-29 11:40:20', '2025-03-29 11:40:20'),
(80, 'Komix Jeruk Nipis', 1000.00, 20, 10, 'produk_img/pyWWwveo0nD9GNQwjgmh.png', '2025-03-29 11:40:40', '2025-03-29 11:40:40'),
(81, 'Tolak Angin', 4000.00, 20, 10, 'produk_img/0G25suV5HhF2CyIyFKeW.png', '2025-03-29 11:41:18', '2025-03-29 11:41:18'),
(82, 'Antangin JRG', 4000.00, 20, 10, 'produk_img/jqYvsdvOZXapPADdi6Xz.png', '2025-03-29 11:41:39', '2025-03-29 11:41:39'),
(83, 'Salonpas', 1000.00, 20, 10, 'produk_img/neDfWMCeqUBF8hAXmehl.png', '2025-03-29 11:42:20', '2025-03-29 11:42:20'),
(84, 'Koyo Cabe', 1000.00, 20, 10, 'produk_img/Sed9rt8c0TsBBt4HK7Kv.png', '2025-03-29 11:42:57', '2025-03-29 11:42:57'),
(85, 'Panadol Extra', 2000.00, 20, 10, 'produk_img/hTU8sD7zqbWXJRcvoCZr.png', '2025-03-29 11:43:27', '2025-03-29 11:43:27'),
(86, 'Panadol Paracetamol', 1000.00, 20, 10, 'produk_img/hWeNWoogxROJfPJhupeF.png', '2025-03-29 11:44:02', '2025-03-29 11:44:02'),
(87, 'Panadol Paracetamol Anak', 1500.00, 20, 10, 'produk_img/hc27L24R2OWB7vWc8Olh.png', '2025-03-29 11:44:42', '2025-03-29 11:44:42'),
(88, 'Paramex Nyeri Otot', 1000.00, 10, 10, 'produk_img/y8rnVeVmcmkctE99jBBq.png', '2025-03-29 11:45:44', '2025-03-29 11:45:44'),
(89, 'Paramex', 1000.00, 20, 10, 'produk_img/o1OVb9Xvd7AtugDSDvcv.png', '2025-03-29 11:46:07', '2025-03-29 11:46:07'),
(90, 'Promag', 1500.00, 10, 10, 'produk_img/20GFPVbSV8O6PsKB5yen.png', '2025-03-29 12:01:07', '2025-03-29 12:01:07'),
(91, 'Diapet', 2000.00, 20, 10, 'produk_img/KMucKWM3XK966ZFcxn1c.png', '2025-03-29 12:01:55', '2025-03-29 12:01:55'),
(92, 'Bodrex Paracetamol', 1000.00, 10, 10, 'produk_img/ywTLALb6QyzmqJ6Sc0sd.png', '2025-03-29 12:02:39', '2025-03-29 12:02:39'),
(93, 'Bodrex Extra', 1500.00, 20, 10, 'produk_img/0YGbEBvShNJ1YrTGnw31.png', '2025-03-29 12:04:00', '2025-03-29 12:05:23'),
(94, 'Bodrex Flu Batuk', 1000.00, 20, 10, 'produk_img/2b6YAVRXhC49LzcIT41o.png', '2025-03-29 12:04:32', '2025-03-29 12:04:32'),
(95, 'Bodrex Migra', 1000.00, 10, 10, 'produk_img/NvDn1toUfqqvlhBdahFG.png', '2025-03-29 12:05:45', '2025-03-29 12:05:45'),
(96, 'Oskadon', 1000.00, 20, 10, 'produk_img/Cq2bxsbV5a2aCUkg5jdP.png', '2025-03-29 12:06:09', '2025-03-29 12:06:09'),
(97, 'Oskadon SP', 1000.00, 20, 10, 'produk_img/VwL74uR4uI8DDGFE5wl5.png', '2025-03-29 12:06:47', '2025-03-29 12:06:47'),
(98, 'Neo Rheumacyl', 1000.00, 20, 10, 'produk_img/HojHwruNKBXY0seQOEk9.png', '2025-03-29 12:07:40', '2025-03-29 12:07:40'),
(99, 'Konidin', 1000.00, 10, 10, 'produk_img/Dbj3Irk3gTA1oKvDXGhT.png', '2025-03-29 12:07:57', '2025-03-29 12:07:57'),
(100, 'Adem Sari Sachet', 3000.00, 0, 10, 'produk_img/SGjyQWirQxLLeFJ9eoKy.png', '2025-03-29 12:10:06', '2025-03-29 12:10:06'),
(101, 'Vegeta Herbal', 3500.00, 20, 10, 'produk_img/VEAPTxztl3SlD0PqnUiq.png', '2025-03-29 12:10:27', '2025-03-29 12:10:27'),
(102, 'Neo Napacin', 1000.00, 20, 10, 'produk_img/vqcKPRQ6nNbjYpmmsECI.png', '2025-03-29 12:11:54', '2025-03-29 12:11:54'),
(103, 'Entrostop', 1000.00, 20, 10, 'produk_img/8P4rVdcGJG0kjbvuXA9D.png', '2025-03-29 12:12:19', '2025-03-29 12:12:19'),
(104, 'Paracetamol 500mg', 500.00, 50, 10, 'produk_img/3R47JkxjAVoUHmjdM3Z6.png', '2025-03-29 12:12:57', '2025-03-29 12:12:57'),
(105, 'Mixagrip Flu', 1000.00, 10, 10, 'produk_img/amNKSRJN9uO3Cb53T9UN.png', '2025-03-29 12:13:25', '2025-03-29 12:13:25'),
(106, 'Mixagrip Flu Batul', 1000.00, 20, 10, 'produk_img/TvbOgCOkuhXKXDMDjsim.png', '2025-03-29 12:13:52', '2025-03-29 12:13:52'),
(107, 'Neozep Forte', 1500.00, 20, 10, 'produk_img/ILNTaCiObmS4JQ8Nzn3B.png', '2025-03-29 12:14:14', '2025-03-29 12:14:14'),
(108, 'Ultraflu', 1500.00, 20, 10, 'produk_img/cuQDZzVavPzLg3KIpXto.png', '2025-03-29 12:14:54', '2025-03-29 12:14:54'),
(109, 'Sanaflu', 1500.00, 20, 10, 'produk_img/2RPIByB6ALGnJApjKZEp.png', '2025-03-29 12:15:05', '2025-03-29 12:15:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('rNy2lJgz39RUMBiZKf3DCX5yQsPVD2NOzLRhrHho', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2xkdWNNQk5HVUtUN0xrMGJ5ajdqc3NnWmhNeDVJT3JlWERpT2RqVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9wZW5qdWFsYW4udGVzdC9rYXRhbG9nP3BhZ2U9NCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1743250710);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('pending','selesai') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` bigint UNSIGNED NOT NULL,
  `transaksi_id` bigint UNSIGNED NOT NULL,
  `produk_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keranjang_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaksi_kode_transaksi_unique` (`kode_transaksi`);

--
-- Indeks untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_detail_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `transaksi_detail_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_detail_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
