-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2025 at 07:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u836263092_dbloewix`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `periode` date NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `periode`, `link`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '', NULL, '2025-08-01', 'banner1.png', '2025-06-21 17:35:24', '2025-06-21 17:35:24', NULL),
(2, 'Ini banner 2', 'Hello', '2025-08-01', 'banner2.png', '2025-06-21 17:35:24', '2025-06-21 17:35:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-budi@example.com|127.0.0.1', 'i:1;', 1753061505),
('laravel-cache-budi@example.com|127.0.0.1:timer', 'i:1753061505;', 1753061505);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `produk_id`, `quantity`, `created_at`, `updated_at`) VALUES
(23, 4, 19, 1, '2025-07-20 18:31:12', '2025-07-20 18:31:12'),
(24, 2, 19, 2, '2025-07-20 18:53:44', '2025-07-20 18:53:47'),
(25, 2, 23, 1, '2025-07-20 18:53:58', '2025-07-20 18:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `receiver_phone` varchar(25) NOT NULL,
  `address` text NOT NULL,
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `user_id`, `receiver_name`, `receiver_phone`, `address`, `province`, `city`, `postal_code`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 4, 'Budi Santoso (Rumah)', '085755556666', 'Jl. Majapahit No. 200, Pedurungan', 'Jawa Tengah', 'Semarang', '50249', 1, NULL, NULL),
(2, 4, 'Andi (Kantor Ayah)', '081234567890', 'Gedung Menara Suara, Lantai 10, Jl. Pemuda No. 150', 'Jawa Tengah', 'Semarang', '50132', 0, NULL, NULL),
(3, 5, 'Citra Lestari', '081977778888', 'Apartemen Sudirman Park, Tower B, Lt. 25 Unit C', 'DKI Jakarta', 'Jakarta Selatan', '12190', 1, NULL, NULL),
(4, 4, 'Saudara Budi', '08782468723', 'Jalan sesama, RT 01 RW 02, No. 12', 'DKI Jakarta', 'Jakarta Timur', '13830', 0, '2025-07-15 23:49:48', '2025-07-15 23:49:48'),
(5, 2, 'Mr Mr', '0863254477823', 'Jalan sesama', 'DKI Jakarta', 'Jakarta Timur', '13830', 0, '2025-07-20 19:15:45', '2025-07-20 19:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `dealer_banners`
--

CREATE TABLE `dealer_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dealer_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Foreign key to users table with role dealer',
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dealer_banners`
--

INSERT INTO `dealer_banners` (`id`, `dealer_id`, `title`, `subtitle`, `image`, `link`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Promo Gajian!', 'Diskon hingga 20% untuk semua IP Camera', 'banners/dealers/jaya-abadi-promo1.jpg', '/products/ip-camera', 1, '2025-07-14 01:35:00', '2025-07-14 01:35:00'),
(2, 3, 'Paket CCTV Murah', 'Sudah termasuk instalasi area Semarang', 'banners/dealers/bintang-terang-paket.jpg', '/packages/semarang-install', 1, '2025-07-14 01:35:00', '2025-07-14 01:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `dealer_carts`
--

CREATE TABLE `dealer_carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dealer_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dealer_carts`
--

INSERT INTO `dealer_carts` (`id`, `dealer_id`, `produk_id`, `quantity`, `created_at`, `updated_at`) VALUES
(6, 2, 16, 3, '2025-07-23 09:13:17', '2025-07-23 09:13:17'),
(7, 2, 39, 3, '2025-07-23 09:13:22', '2025-07-23 09:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `dealer_profiles`
--

CREATE TABLE `dealer_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Foreign key to users table with role dealer',
  `store_name` varchar(255) NOT NULL,
  `store_slug` varchar(255) NOT NULL,
  `store_logo` varchar(255) DEFAULT NULL,
  `store_description` text DEFAULT NULL,
  `store_image` varchar(255) DEFAULT NULL,
  `store_maps` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dealer_profiles`
--

INSERT INTO `dealer_profiles` (`id`, `user_id`, `store_name`, `store_slug`, `store_logo`, `store_description`, `store_image`, `store_maps`, `created_at`, `updated_at`) VALUES
(1, 2, 'Toko Dealer Jaya Abadi', 'jaya-abadi', 'logos/jaya-abadi.png', 'Menyediakan produk Loewix terlengkap di Jakarta.', NULL, NULL, '2025-07-14 01:30:00', '2025-07-14 01:30:00'),
(2, 3, 'Rumah CCTV', 'rumah-cctv-boyolali', 'logos/rumah-cctv-boyolali.png', 'Pusat CCTV Loewix terpercaya di Jawa Tengah.', 'rumah-cctv.jpg', 'https://maps.app.goo.gl/r7JxagEnZ5KxB432A', '2025-07-14 01:30:00', '2025-07-14 01:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `dealer_tiers`
--

CREATE TABLE `dealer_tiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `min_monthly_purchase` decimal(15,2) NOT NULL,
  `product_discount_percentage` decimal(5,2) NOT NULL,
  `shipping_discount_amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dealer_tiers`
--

INSERT INTO `dealer_tiers` (`id`, `name`, `min_monthly_purchase`, `product_discount_percentage`, `shipping_discount_amount`, `created_at`, `updated_at`) VALUES
(1, 'Bronze', 0.00, 0.00, 0.00, NULL, NULL),
(2, 'Silver', 20000000.00, 5.00, 50000.00, NULL, NULL),
(3, 'Gold', 50000000.00, 10.00, 100000.00, NULL, NULL),
(4, 'Platinum', 100000000.00, 15.00, 150000.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Owner of stock (Dealer or Loewix)',
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `user_id`, `produk_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 1000, '2025-07-14 00:58:10', '2025-07-14 00:58:10'),
(2, 1, 16, 500, '2025-07-14 00:58:10', '2025-07-14 00:58:10'),
(3, 1, 3, 200, '2025-07-14 00:58:10', '2025-07-14 00:58:10'),
(4, 2, 15, 50, '2025-07-14 00:58:10', '2025-07-14 00:58:10'),
(5, 2, 16, 20, '2025-07-14 00:58:10', '2025-07-14 00:58:10'),
(6, 3, 15, 100, '2025-07-14 00:58:10', '2025-07-14 00:58:10'),
(7, 3, 16, 30, '2025-07-14 00:58:10', '2025-07-14 00:58:10'),
(8, 3, 3, 10, '2025-07-14 00:58:10', '2025-07-14 00:58:10'),
(9, 1, 17, 500, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(10, 2, 17, 50, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(11, 3, 17, 30, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(12, 1, 18, 500, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(13, 2, 18, 40, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(14, 3, 18, 60, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(15, 1, 19, 200, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(16, 2, 19, 10, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(17, 3, 19, 15, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(18, 1, 20, 1000, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(19, 2, 20, 99, '2025-07-15 03:44:16', '2025-07-18 22:17:57'),
(20, 3, 20, 150, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(21, 1, 21, 300, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(22, 2, 21, 20, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(23, 3, 21, 25, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(24, 1, 22, 400, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(25, 2, 22, 30, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(26, 3, 22, 0, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(27, 1, 23, 100, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(28, 2, 23, 5, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(29, 3, 23, 10, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(30, 1, 24, 200, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(31, 2, 24, 20, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(32, 3, 24, 10, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(33, 1, 25, 2000, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(34, 2, 25, 200, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(35, 3, 25, 300, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(36, 1, 26, 300, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(37, 2, 26, 25, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(38, 3, 26, 35, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(39, 1, 27, 50, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(40, 2, 27, 5, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(41, 3, 27, 2, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(42, 1, 28, 400, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(43, 2, 28, 40, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(44, 3, 28, 50, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(45, 1, 29, 80, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(46, 2, 29, 4, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(47, 3, 29, 5, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(48, 1, 30, 300, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(49, 2, 30, 30, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(50, 3, 30, 20, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(51, 1, 31, 100, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(52, 2, 31, 8, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(53, 3, 31, 12, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(54, 1, 32, 5000, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(55, 2, 32, 500, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(56, 3, 32, 600, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(57, 1, 33, 600, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(58, 2, 33, 50, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(59, 3, 33, 40, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(60, 1, 34, 100, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(61, 2, 34, 10, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(62, 3, 34, 8, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(63, 1, 35, 1000, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(64, 2, 35, 100, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(65, 3, 35, 120, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(66, 1, 36, 500, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(67, 2, 36, 50, '2025-07-15 03:44:16', '2025-07-15 03:44:16'),
(68, 3, 36, 45, '2025-07-15 03:44:16', '2025-07-15 03:44:16');

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `image_kategori` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama_kategori`, `parent_id`, `image_kategori`, `created_at`, `updated_at`) VALUES
(1, 'CAMERA', 0, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(2, 'Recorder', 0, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(3, 'Network', 0, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(6, 'NVR', 2, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(7, 'DVR', 2, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(8, 'KABEL', 3, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(9, 'POE SWITCH', 3, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(14, 'Indoor', 1, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(15, 'Outdoor', 1, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(16, 'IP', 14, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(17, 'AHD', 14, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(18, 'IP', 15, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(19, 'AHD', 15, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(23, '2MP', 17, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(24, '2MP', 19, NULL, '2025-06-24 03:52:31', '2025-06-24 03:52:31'),
(30, '5MP', 19, NULL, NULL, NULL),
(31, 'Accesories', 0, NULL, NULL, NULL),
(32, 'Connector', 31, NULL, NULL, NULL),
(37, '5MP', 17, NULL, NULL, NULL),
(39, '3MP', 16, NULL, NULL, NULL),
(40, '4MP', 16, NULL, NULL, NULL),
(41, '5MP', 16, NULL, NULL, NULL),
(42, '6MP', 16, NULL, NULL, NULL),
(43, '8MP', 16, NULL, NULL, NULL),
(44, '3MP', 18, NULL, NULL, NULL),
(45, '4MP', 18, NULL, NULL, NULL),
(46, '5MP', 18, NULL, NULL, NULL),
(47, '6MP', 18, NULL, NULL, NULL),
(48, '8MP', 18, NULL, NULL, NULL),
(49, 'POE SWITCH 4 PORT', 9, NULL, NULL, NULL),
(50, 'POE SWITCH 8 PORT', 9, NULL, NULL, NULL),
(51, 'POE SWITCH 16 PORT', 9, NULL, NULL, NULL),
(52, 'POE SWITCH 24 PORT', 9, NULL, NULL, NULL),
(53, 'DVR 2MP', 7, NULL, NULL, NULL),
(54, 'DVR 5MP', 7, NULL, NULL, NULL),
(55, 'DVR 2MP 4CH', 53, NULL, NULL, NULL),
(56, 'DVR 2MP 8CH', 53, NULL, NULL, NULL),
(57, 'DVR 5MP 4CH', 54, NULL, NULL, NULL),
(58, 'DVR 5MP 8CH', 54, NULL, NULL, NULL),
(59, 'DVR 5MP 16CH', 54, NULL, NULL, NULL),
(60, 'DVR 5MP 32CH', 54, NULL, NULL, NULL),
(61, 'NVR 5MP 10CH', 6, NULL, NULL, NULL),
(62, 'NVR 5MP 16CH', 6, NULL, NULL, NULL),
(63, 'NVR 5MP 32CH', 6, NULL, NULL, NULL),
(64, 'NVR 5MP 64CH', 6, NULL, NULL, NULL),
(65, 'POE EXTENDER', 3, NULL, NULL, NULL),
(66, 'GIGABIT SWITCH', 3, NULL, NULL, NULL),
(67, 'POE INJECTOR', 3, NULL, NULL, NULL),
(68, 'GIGABIT SWITCH 5 PORT', 66, NULL, NULL, NULL),
(69, 'GIGABIT SWITCH 8 PORT', 66, NULL, NULL, NULL),
(70, 'POE EXTENDER 2 PORT', 65, NULL, NULL, NULL),
(71, 'POE INJECTOR 1 PORT', 67, NULL, NULL, NULL),
(72, 'LAN / UTP', 8, NULL, NULL, NULL),
(73, 'COAXIAL', 8, NULL, NULL, NULL),
(76, 'RG59', 73, NULL, NULL, NULL),
(77, 'RG6', 73, NULL, NULL, NULL),
(78, 'RG59 + POWER ( WHITE ) 50M', 76, NULL, NULL, NULL),
(79, 'RG59 + POWER ( WHITE ) 100M', 76, NULL, NULL, NULL),
(80, 'RG59 + POWER ( WHITE ) 300M', 76, NULL, NULL, NULL),
(81, 'RG6+ POWER ( BLACK ) 300M', 77, NULL, NULL, NULL),
(82, 'CAT5E', 72, NULL, NULL, NULL),
(83, 'CAT6', 72, NULL, NULL, NULL),
(84, 'LAN CAT5E ( WHITE ) 305M', 82, NULL, NULL, NULL),
(85, 'LAN CAT6 ( WHITE ) 305M', 83, NULL, NULL, NULL),
(86, 'BNC', 32, NULL, NULL, NULL),
(87, 'RJ-45', 32, NULL, NULL, NULL),
(88, 'MALE', 32, NULL, NULL, NULL),
(89, 'FEMALE', 32, NULL, NULL, NULL),
(90, 'Adaptore', 31, NULL, NULL, NULL),
(91, '12 VOLT - 1 AMPERE', 90, NULL, NULL, NULL),
(92, '12 VOLT - 2 AMPERE', 90, NULL, NULL, NULL),
(93, '12 VOLT - 5 AMPERE', 90, NULL, NULL, NULL),
(94, 'Power Supply Analog', 31, NULL, NULL, NULL),
(95, 'PSU ANALOG 4CH', 94, NULL, NULL, NULL),
(96, 'PSU ANALOG 8CH', 94, NULL, NULL, NULL),
(97, 'PSU ANALOG 16CH', 94, NULL, NULL, NULL),
(98, 'Power Supply Box', 31, NULL, NULL, NULL),
(99, 'PSU 12V-10A BOX', 98, NULL, NULL, NULL),
(100, 'PSU 12V-20A BOX', 98, NULL, NULL, NULL),
(101, 'PSU 12V-30A BOX', 98, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_06_21_225635_create_banners_table', 1),
(6, '2025_06_21_225635_create_produkimages_table', 1),
(7, '2025_06_21_225635_create_produks_table', 1),
(8, '2025_06_21_225635_create_whislists_table', 1),
(9, '2025_06_23_103020_create_kategoris_table', 2),
(10, '2025_06_23_103020_create_produkkategoris_table', 2),
(11, '2025_06_24_051805_create_kategoris_table', 3),
(12, '0001_01_01_000001_create_cache_table', 4),
(13, '2014_10_12_100000_create_password_resets_table', 4),
(14, '2025_07_14_155452_create_sessions_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('8060a7a5-62dc-11f0-93a0-02004c4f4f50', 'App\\Notifications\\OrderStatusUpdated', 'App\\Models\\User', 4, '{\"order_id\":9,\"message\":\"Status pesanan #ORD-68771DCB2CE21 Anda telah diperbarui menjadi: Processing\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/akun\\/pesanan\\/9\"}', NULL, '2025-07-17 05:06:04', '2025-07-17 05:06:04'),
('8061161a-62dc-11f0-93a0-02004c4f4f50', 'App\\Notifications\\OrderStatusUpdated', 'App\\Models\\User', 4, '{\"order_id\":8,\"message\":\"Status pesanan #ORD-68771B63CBCD7 Anda telah diperbarui menjadi: Shipped\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/akun\\/pesanan\\/8\"}', NULL, '2025-07-16 07:06:04', '2025-07-16 07:06:04'),
('80611ae3-62dc-11f0-93a0-02004c4f4f50', 'App\\Notifications\\NewVoucher', 'App\\Models\\User', 4, '{\"title\":\"Spesial Untuk Anda!\",\"message\":\"Gunakan kode MERDEKA17 untuk diskon 17% spesial hari kemerdekaan!\",\"link\":\"http:\\/\\/127.0.0.1:8000\\/produk\"}', '2025-07-14 07:06:04', '2025-07-14 07:06:04', '2025-07-14 07:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `customer_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `voucher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `voucher_code` varchar(50) DEFAULT NULL,
  `discount_amount` decimal(15,2) DEFAULT 0.00,
  `shipping_cost` decimal(15,2) DEFAULT 0.00,
  `dealer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_province` varchar(100) NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `status` enum('pending_payment','pending_dealer_acceptance','processing','shipped','completed','cancelled','searching_new_dealer') NOT NULL,
  `acceptance_deadline` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `customer_id`, `customer_address_id`, `voucher_id`, `voucher_code`, `discount_amount`, `shipping_cost`, `dealer_id`, `total_amount`, `shipping_address`, `shipping_province`, `shipping_city`, `status`, `acceptance_deadline`, `created_at`, `updated_at`) VALUES
(10, 'ORD-6877318A01AD9', 4, 2, 1, 'DISKON10PERSEN', 20000.00, 18000.00, 3, 2728000.00, 'Gedung Menara Suara, Lantai 10, Jl. Pemuda No. 150', 'Jawa Tengah', 'Semarang', 'pending_dealer_acceptance', '2025-07-16 00:58:50', '2025-07-15 21:58:50', '2025-07-15 21:58:50'),
(11, 'ORD-68774C6075A2E', 4, 4, 2, 'GRATISONGKIR15RB', 15000.00, 25000.00, 3, 12160000.00, 'Jalan sesama, RT 01 RW 02, No. 12', 'DKI Jakarta', 'Jakarta Timur', 'pending_dealer_acceptance', '2025-07-16 02:53:20', '2025-07-15 23:53:20', '2025-07-15 23:53:20'),
(12, 'ORD-68774D339C04F', 4, 4, NULL, NULL, 0.00, 25000.00, 2, 375000.00, 'Jalan sesama, RT 01 RW 02, No. 12', 'DKI Jakarta', 'Jakarta Timur', 'processing', '2025-07-16 02:56:51', '2025-07-15 23:56:51', '2025-07-18 22:17:57'),
(13, 'ORD-68774D529BACA', 4, 1, 2, 'GRATISONGKIR15RB', 15000.00, 18000.00, 3, 8553000.00, 'Jl. Majapahit No. 200, Pedurungan', 'Jawa Tengah', 'Semarang', 'pending_dealer_acceptance', '2025-07-16 02:57:22', '2025-07-15 23:57:22', '2025-07-15 23:57:22'),
(14, 'ORD-68789F93D774C', 5, 3, 1, 'DISKON10PERSEN', 20000.00, 38000.00, 2, 7023000.00, 'Apartemen Sudirman Park, Tower B, Lt. 25 Unit C', 'DKI Jakarta', 'Jakarta Selatan', 'pending_dealer_acceptance', '2025-07-17 03:00:35', '2025-07-17 00:00:35', '2025-07-17 00:00:35'),
(15, 'ORD-6880FF7CAECE2', 5, 3, 1, 'DISKON10PERSEN', 20000.00, 38000.00, 2, 14708000.00, 'Apartemen Sudirman Park, Tower B, Lt. 25 Unit C', 'DKI Jakarta', 'Jakarta Selatan', 'pending_dealer_acceptance', '2025-07-23 11:27:56', '2025-07-23 08:27:56', '2025-07-23 08:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `order_dealer_assignments`
--

CREATE TABLE `order_dealer_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `dealer_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('offered','accepted','rejected','timed_out') NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `handled_at` timestamp NULL DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL COMMENT 'Alasan reject/timeout dari sistem',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_dealer_assignments`
--

INSERT INTO `order_dealer_assignments` (`id`, `order_id`, `dealer_id`, `status`, `assigned_at`, `handled_at`, `notes`, `created_at`, `updated_at`) VALUES
(8, 10, 3, 'offered', '2025-07-15 21:58:50', NULL, NULL, '2025-07-15 21:58:50', '2025-07-15 21:58:50'),
(9, 11, 3, 'offered', '2025-07-15 23:53:20', NULL, NULL, '2025-07-15 23:53:20', '2025-07-15 23:53:20'),
(10, 12, 2, 'accepted', '2025-07-19 05:17:57', NULL, NULL, '2025-07-15 23:56:51', '2025-07-18 22:17:57'),
(11, 13, 3, 'offered', '2025-07-15 23:57:22', NULL, NULL, '2025-07-15 23:57:22', '2025-07-15 23:57:22'),
(12, 14, 2, 'offered', '2025-07-17 00:00:35', NULL, NULL, '2025-07-17 00:00:36', '2025-07-17 00:00:36'),
(13, 15, 2, 'offered', '2025-07-23 08:27:56', NULL, NULL, '2025-07-23 08:27:56', '2025-07-23 08:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `produk_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(20, 10, 17, 2, 765000, '2025-07-15 21:58:50', '2025-07-15 21:58:50'),
(21, 10, 21, 1, 1200000, '2025-07-15 21:58:50', '2025-07-15 21:58:50'),
(22, 11, 21, 3, 1200000, '2025-07-15 23:53:20', '2025-07-15 23:53:20'),
(23, 11, 27, 2, 4275000, '2025-07-15 23:53:20', '2025-07-15 23:53:20'),
(24, 12, 20, 1, 350000, '2025-07-15 23:56:51', '2025-07-15 23:56:51'),
(25, 13, 27, 2, 4275000, '2025-07-15 23:57:22', '2025-07-15 23:57:22'),
(26, 14, 17, 2, 765000, '2025-07-17 00:00:35', '2025-07-17 00:00:35'),
(27, 14, 21, 1, 1200000, '2025-07-17 00:00:35', '2025-07-17 00:00:35'),
(28, 14, 27, 1, 4275000, '2025-07-17 00:00:35', '2025-07-17 00:00:35'),
(29, 15, 17, 1, 765000, '2025-07-23 08:27:56', '2025-07-23 08:27:56'),
(30, 15, 27, 3, 4275000, '2025-07-23 08:27:56', '2025-07-23 08:27:56'),
(31, 15, 23, 1, 1100000, '2025-07-23 08:27:56', '2025-07-23 08:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `otp_verifications`
--

CREATE TABLE `otp_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(25) NOT NULL,
  `code` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp_verifications`
--

INSERT INTO `otp_verifications` (`id`, `phone`, `code`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, '085755556666', '123456', '2025-07-14 02:00:00', '2025-07-14 01:45:00', '2025-07-14 01:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produks`
--

CREATE TABLE `produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `merk` varchar(255) NOT NULL,
  `berat` int(11) NOT NULL,
  `garansi` varchar(255) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `is_archive` tinyint(1) DEFAULT NULL,
  `is_popular` tinyint(1) NOT NULL,
  `rating` double DEFAULT NULL,
  `sold` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produks`
--

INSERT INTO `produks` (`id`, `name`, `harga`, `kategori_id`, `merk`, `berat`, `garansi`, `diskon`, `keterangan`, `is_archive`, `is_popular`, `rating`, `sold`, `created_at`, `updated_at`, `deleted_at`) VALUES
(15, 'LWX-12345678', 890000, 39, 'Loewix', 0, NULL, NULL, '', NULL, 1, 4.5, 975637486, '2025-07-12 04:06:37', '2025-07-12 04:06:37', NULL),
(16, 'LWX-9876543', 960000, 30, 'Loewix', 0, NULL, NULL, '', NULL, 0, 5, 52672, '2025-07-12 04:07:03', '2025-07-12 04:07:03', NULL),
(17, 'LWX-IPC-DOME-5MP-PRO', 850000, 41, 'Loewix', 500, '1 Tahun', 10, 'Kamera Dome IP 5MP dengan night vision dan audio dua arah.', NULL, 1, 4.8, 120, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(18, 'LWX-IPC-BULLET-4MP', 780000, 45, 'Loewix', 600, '1 Tahun', 5, 'Kamera Bullet outdoor 4MP, tahan cuaca IP67.', NULL, 1, 4.7, 250, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(19, 'LWX-NVR-16CH-POE', 2500000, 62, 'Loewix', 2000, '2 Tahun', NULL, 'NVR 16 Channel dengan 16 port PoE, support hingga 8MP.', NULL, 1, 5, 50, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(20, 'LWX-AHD-TURRET-2MP', 350000, 23, 'Loewix', 450, '1 Tahun', NULL, 'Kamera AHD Turret 2MP full color.', NULL, 0, 4.5, 400, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(21, 'LWX-DVR-8CH-5MP', 1200000, 58, 'Loewix', 1500, '2 Tahun', NULL, 'DVR 8 Channel support hingga 5MP.', NULL, 1, 4.9, 80, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(22, 'LWX-POE-SWITCH-8P', 650000, 50, 'Loewix', 800, '1 Tahun', 15, 'POE Switch 8 Port Gigabit.', NULL, 0, 4.6, 150, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(23, 'LWX-CBL-CAT6-305M', 1100000, 85, 'Loewix', 10000, 'N/A', NULL, 'Kabel LAN UTP CAT6 305 Meter high quality.', NULL, 1, 5, 300, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(24, 'LWX-CBL-RG59-100M', 450000, 79, 'Loewix', 5000, 'N/A', NULL, 'Kabel Coaxial RG59 + Power 100 Meter.', NULL, 0, 4.8, 200, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(25, 'LWX-CONN-RJ45-100', 80000, 87, 'Loewix', 200, 'N/A', NULL, 'Konektor RJ-45 isi 100 pcs.', NULL, 0, 4.9, 1000, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(26, 'LWX-PSU-12V-10A', 250000, 99, 'Loewix', 1000, '6 Bulan', NULL, 'Power Supply Box 12V 10A 9 Channel.', NULL, 1, 4.7, 180, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(27, 'LWX-IPC-PTZ-5MP-25X', 4500000, 46, 'Loewix', 2500, '2 Tahun', 5, 'Kamera PTZ 5MP dengan 25x Optical Zoom.', NULL, 1, 4.9, 30, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(28, 'LWX-AHD-DOME-5MP', 550000, 37, 'Loewix', 500, '1 Tahun', NULL, 'Kamera AHD Dome 5MP high resolution.', NULL, 0, 4.6, 90, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(29, 'LWX-DVR-32CH-5MP', 4800000, 60, 'Loewix', 2500, '2 Tahun', NULL, 'DVR 32 Channel 5MP support H.265+.', NULL, 0, 5, 15, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(30, 'LWX-POE-EXT-2P', 300000, 70, 'Loewix', 300, '1 Tahun', NULL, 'POE Extender 2 Port, memperpanjang jangkauan PoE.', NULL, 0, 4.5, 75, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(31, 'LWX-IPC-FISHEYE-6MP', 3200000, 47, 'Loewix', 600, '2 Tahun', 10, 'Kamera Fisheye 360 derajat 6MP.', NULL, 0, 4.8, 25, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(32, 'LWX-ADAPTOR-12V-2A', 50000, 92, 'Loewix', 150, '1 Bulan', NULL, 'Adaptor 12V 2A kualitas terbaik.', NULL, 1, 5, 2000, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(33, 'LWX-AHD-BULLET-5MP', 620000, 30, 'Loewix', 600, '1 Tahun', NULL, 'Kamera AHD Bullet Outdoor 5MP.', NULL, 1, 4.7, 110, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(34, 'LWX-NVR-32CH-4K', 5500000, 63, 'Loewix', 2500, '2 Tahun', NULL, 'NVR 32 Channel support resolusi 4K.', NULL, 1, 5, 20, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(35, 'LWX-GIGA-SWITCH-5P', 250000, 68, 'Loewix', 500, '1 Tahun', NULL, 'Gigabit Switch 5 Port unmanaged.', NULL, 0, 4.9, 500, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(36, 'LWX-IPC-CUBE-3MP', 680000, 39, 'Loewix', 400, '1 Tahun', NULL, 'Kamera IP Cube 3MP dengan WiFi.', NULL, 0, 4.6, 130, '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(37, 'Test', 670000, 59, 'Loewix', 900, NULL, 0, 'sfawef fgdg', NULL, 0, NULL, NULL, '2025-07-22 09:27:46', '2025-07-22 09:27:46', NULL),
(38, 'kewgbwkeb`', 885000, 46, 'Loewix', 1500, NULL, 0, 'skdjgbsjkrkj elghwlehg elgnwl', NULL, 0, NULL, NULL, '2025-07-22 09:44:58', '2025-07-22 09:44:58', NULL),
(39, 'kewgbwkeb`', 885000, 46, 'Loewix', 1500, NULL, 0, 'skdjgbsjkrkj elghwlehg elgnwl', NULL, 0, NULL, NULL, '2025-07-22 09:45:28', '2025-07-22 09:45:28', NULL),
(40, 'sbsdlkn', 1300000, 62, 'Loewix', 2300, NULL, 0, 'lhengklwehkl elkghwelgnklwe', NULL, 1, NULL, NULL, '2025-07-22 09:50:13', '2025-07-22 09:50:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk_images`
--

CREATE TABLE `produk_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk_images`
--

INSERT INTO `produk_images` (`id`, `produk_id`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(31, 15, '6871df4d241e1_Desaintanpajudul26.jpg', '2025-07-12 04:06:37', '2025-07-12 04:06:37', NULL),
(32, 16, '6871df6715418_Desaintanpajudul20.jpg', '2025-07-12 04:07:03', '2025-07-12 04:07:03', NULL),
(33, 17, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(34, 18, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(35, 19, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(36, 20, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(37, 21, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(38, 22, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(39, 23, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(40, 24, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(41, 25, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(42, 26, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(43, 27, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(44, 28, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(45, 29, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(46, 30, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(47, 31, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(48, 32, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(49, 33, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(50, 34, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(51, 35, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(52, 36, 'images/dummy.jpg', '2025-07-15 03:44:16', '2025-07-15 03:44:16', NULL),
(53, 39, 'products/5VQY2weZkTgxGzWJz9y4UtdAYAbPkuedZrtSR493.png', '2025-07-22 09:45:28', '2025-07-22 09:45:28', NULL),
(54, 39, 'products/3Jto5dFcInTv5Qq325s4w98zgBjsbwJbhrkQv27U.png', '2025-07-22 09:45:28', '2025-07-22 09:45:28', NULL),
(55, 40, 'products/P2srvEQOecd586Zb6Fk0zQiMokFX6Rg64dzKOt72.png', '2025-07-22 09:50:13', '2025-07-22 09:50:13', NULL),
(56, 40, 'products/Z1QlySU9iXAzljV70UpT6io8ZICIE8q8K3xGcZXI.png', '2025-07-22 09:50:13', '2025-07-22 09:50:13', NULL),
(57, 40, 'products/B1GBNVj0PPjjJk1u8RVLwwVZgjQwns4XHcnjk0zM.png', '2025-07-22 09:50:13', '2025-07-22 10:02:31', '2025-07-22 10:02:31'),
(58, 40, 'products/PfWsWyD7U2WejGnmXxyLSjSmdtWGCW7qhymdKg1v.png', '2025-07-22 09:50:42', '2025-07-22 09:50:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('InluzdrfjTA9eh2olem5QxC6HGcWeWDErVqNuFRX', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoib1ZRcmZORWNkeUt5Mm5HT1E1MWdmSDlFZTFlcmZHVzJYakRkMEtLTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kZWFsZXIvcGVzYW5hbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzUzMjgwNzE2O319', 1753290259),
('J85ABvfKSJcXVJP9iScRVPfEwgbYiEgUJakymuqN', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNHlzb1V1QXF2am5qNDVKa3VzbmJOZjk2ZVpNQWM5VkRUV040ZjlJZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ha3VuL3Blc2FuYW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1MzI4MDc3Njt9fQ==', 1753286385),
('jydKjAKnkxwSDsxCQ5S6IXzezCbcvSPpn0wBvqTO', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTENXWmhWa1dZclcwaVVnaGJVQTdLT09zaGgwWWY0bTN5MWE0VTlORyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wZXNhbmFuLXN0b2svMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzUzMjgyMTM0O319', 1753290271);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_costs`
--

CREATE TABLE `shipping_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `destination_city` varchar(255) NOT NULL,
  `cost_per_kg` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_costs`
--

INSERT INTO `shipping_costs` (`id`, `destination_city`, `cost_per_kg`, `created_at`, `updated_at`) VALUES
(1, 'Semarang', 9000, NULL, NULL),
(2, 'Jakarta Pusat', 18000, NULL, NULL),
(3, 'Jakarta Selatan', 19000, NULL, NULL),
(4, 'Bandung', 15000, NULL, NULL),
(5, 'Surabaya', 12000, NULL, NULL),
(6, 'Jakarta Timur', 9000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_histories`
--

CREATE TABLE `stock_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('penambahan','pengurangan','koreksi') NOT NULL,
  `quantity_change` int(11) NOT NULL,
  `quantity_before` int(11) NOT NULL,
  `quantity_after` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_orders`
--

CREATE TABLE `stock_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dealer_id` bigint(20) UNSIGNED NOT NULL,
  `customer_address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `voucher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_code` varchar(20) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `discount_amount` decimal(15,2) DEFAULT 0.00,
  `shipping_cost` decimal(15,2) DEFAULT 0.00,
  `shipping_discount_amount` decimal(15,2) DEFAULT 0.00,
  `status` enum('pending_payment','processing','shipped','completed','cancelled') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_orders`
--

INSERT INTO `stock_orders` (`id`, `dealer_id`, `customer_address_id`, `voucher_id`, `order_code`, `total_amount`, `discount_amount`, `shipping_cost`, `shipping_discount_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, 'STK-20250714-001', 44500000.00, 0.00, 0.00, 0.00, 'completed', '2025-07-13 10:00:00', '2025-07-13 12:00:00'),
(2, 2, 5, 3, 'STK-688109E7BEC57', 8089000.00, 665000.00, 504000.00, 50000.00, 'pending_payment', '2025-07-23 09:12:23', '2025-07-23 09:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `stock_order_items`
--

CREATE TABLE `stock_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_order_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL COMMENT 'Harga beli dealer dari loewix',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_order_items`
--

INSERT INTO `stock_order_items` (`id`, `stock_order_id`, `produk_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 50, 890000, '2025-07-13 10:00:00', '2025-07-13 10:00:00'),
(2, 2, 32, 4, 50000, '2025-07-23 09:12:23', '2025-07-23 09:12:23'),
(3, 2, 23, 5, 1100000, '2025-07-23 09:12:23', '2025-07-23 09:12:23'),
(4, 2, 40, 2, 1300000, '2025-07-23 09:12:23', '2025-07-23 09:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE `tutorials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `category` enum('Instalasi Hardware','Konfigurasi Software','Troubleshooting') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tutorials`
--

INSERT INTO `tutorials` (`id`, `title`, `description`, `file_path`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Mengunduh & Memasang Aplikasi XMEye Pro (Android & IOS)', 'Panduan lengkap untuk aplikasi mobile XMEye Pro.', 'tutorials/1.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(2, 'Menambah dan Menautkan NVR KE Aplikasi XMEye Pro', 'Hubungkan NVR Anda ke aplikasi mobile untuk pemantauan jarak jauh.', 'tutorials/2.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(3, 'Mengakses NVR, Perangkat Lain & Menu Live & Playback Video', 'Navigasi dasar menu NVR dan fitur live view serta playback.', 'tutorials/3.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(4, 'Mengunduh dan Memasang XMEye PC Client (VMS)', 'Instalasi software VMS di komputer Windows atau Mac.', 'tutorials/4.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(5, 'Menambahkan dan Menyambungkan DVR KE VMS', 'Integrasikan perangkat DVR Anda dengan software VMS di PC.', 'tutorials/5.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(6, 'Live Video XMEye PC Client (VMS)', 'Cara melakukan pemantauan langsung melalui VMS.', 'tutorials/6.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(7, 'Video Recording & Playback XMEye PC Client (VMS)', 'Mengelola rekaman dan memutar ulang video via VMS.', 'tutorials/7.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(8, '(AHD) Pengenalan Komponen Produk DVR, Analog CCTV, Kabel', 'Mengenal setiap komponen dalam sistem CCTV Analog.', 'tutorials/8.pdf', 'Instalasi Hardware', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(9, '(AHD) Tata Cara Memasang Hardisk & Menghubungkan DVR dengan CCTV ke Monitor', 'Panduan instalasi fisik hardisk dan koneksi dasar DVR.', 'tutorials/9.pdf', 'Instalasi Hardware', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(10, '(AHD) XMEye Instalasi DVR & Panduan Awal', 'Langkah-langkah awal setup dan konfigurasi DVR AHD.', 'tutorials/10.pdf', 'Instalasi Hardware', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(11, '(AHD) XMEye LIVE Video', 'Melakukan pemantauan langsung dari sistem DVR AHD.', 'tutorials/11.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(12, '(AHD) XMEye FORMAT ULANG HARD DISK', 'Cara melakukan format pada hardisk melalui menu DVR.', 'tutorials/12.pdf', 'Troubleshooting', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(13, '(AHD) XMEye PANDUAN MENGGUNAKAN VIDEO RECORDING', 'Pengaturan jadwal dan mode perekaman pada DVR.', 'tutorials/13.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(14, '(AHD) XMEye PANDUAN MENGGUNAKAN VIDEO PLAYBACK', 'Cara mencari dan memutar ulang rekaman video dari DVR.', 'tutorials/14.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(15, '(AHD) XMEye Panduan BackUp Video', 'Menyimpan klip video penting dari DVR ke media eksternal.', 'tutorials/15.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(16, '(AHD) XMEye PANDUAN SETTING XVI', 'Pengaturan lanjutan menggunakan protokol Coax-Vision Control.', 'tutorials/16.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(17, '(IP) PENGENALAN KOMPONEN PRODUK NVR, IP CCTV, KABEL', 'Mengenal setiap komponen dalam sistem CCTV berbasis IP.', 'tutorials/17.pdf', 'Instalasi Hardware', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(18, '(IP) TATA CARA MEMASANG HARDISK & MENGHUBUNGKAN NVR', 'Panduan instalasi fisik hardisk pada perangkat NVR.', 'tutorials/18.pdf', 'Instalasi Hardware', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(19, '(IP) XMEye PANDUAN MENGGUNAKAN VIDEO RECORDING & PENGATURAN PENYIMPANAN', 'Manajemen rekaman dan penyimpanan pada sistem NVR.', 'tutorials/19.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(20, '(IP) XMEye PANDUAN BACKUP VIDEO', 'Menyimpan klip video penting dari NVR ke media eksternal.', 'tutorials/20.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(21, '(IP) XMEye PANDUAN MENGGUNAKAN VIDEO PLAYBACK', 'Cara mencari dan memutar ulang rekaman video dari NVR.', 'tutorials/21.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(22, '(IP) XMEye PANDUAN MENGGUNAKAN FITUR INTELLIGENT ALERT', 'Mengatur fitur pintar seperti deteksi gerakan dan deteksi manusia.', 'tutorials/22.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(23, '(IP) XMEye PANDUAN MENGHUBUNGKAN Recorder (NVR) KE ROUTER', 'Koneksi NVR ke jaringan internet melalui router.', 'tutorials/23.pdf', 'Instalasi Hardware', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(24, '(IP) XMEye PANDUAN MEMERIKSA VERSI FIRMWARE RECORDER (NVR)', 'Cara mengecek versi firmware pada perangkat NVR Anda.', 'tutorials/24.pdf', 'Troubleshooting', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(25, '(IP) XMEye PANDUAN MENAUTKAN EMAIL KE RECORDER (NVR)', 'Mengatur notifikasi peringatan keamanan melalui email.', 'tutorials/25.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(26, '(IP) XMEye PANDUAN MENGATUR USER PADA RECORDER (NVR)', 'Manajemen pengguna dan hak akses pada NVR.', 'tutorials/26.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(27, '(IP) XMEye PANDUAN MENGATUR KUALITAS REKAMAN', 'Menyesuaikan resolusi, bitrate, dan frame rate rekaman.', 'tutorials/27.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(28, '(IP) XMEye WEB BROWSER MENGAKSES REMOTE NVR MELALUI WEB BROWSER', 'Cara mengakses NVR dari jarak jauh menggunakan browser.', 'tutorials/28.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(29, '(IP) XMEye PC Client CMS MENAMBAHKAN RECORDER (NVR) MELALUI SOFTWARE PC CLIENT', 'Menambahkan perangkat NVR ke software CMS di komputer.', 'tutorials/29.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(30, '(IP) XMEye TUTORIAL MENGATUR CHANNEL DIGITAL PADA NVR', 'Manajemen dan pengaturan setiap channel kamera pada NVR.', 'tutorials/30.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(31, '(IP) XMEye TUTORIAL MENAMBAHKAN KAMERA IP KE NVR', 'Proses pairing dan menambahkan kamera IP baru ke NVR.', 'tutorials/31.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(32, '(IP) CARA MEMASANG SISTEM NVR POE XMEYE', 'Panduan lengkap instalasi sistem NVR dengan teknologi PoE.', 'tutorials/32.pdf', 'Instalasi Hardware', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(33, '(IP) XMEye TUTORIAL MENGATUR WAKTU DAN TANGGAL PADA NVR', 'Sinkronisasi waktu dan pengaturan zona waktu pada NVR.', 'tutorials/33.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(34, '(IP) XMEye TUTORIAL MENGATUR PENGATURAN JARINGAN', 'Konfigurasi alamat IP statis, DHCP, dan port pada NVR.', 'tutorials/34.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(35, '(IP) XMEye CARA MEMASANG DAN MENGGUNAKAN APLIKASI', 'Panduan singkat penggunaan aplikasi mobile XMEye.', 'tutorials/35.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(36, '(IP) XMEye TUTORIAL MENGATUR DISPLAY MONITOR NVR', 'Pengaturan output tampilan ke monitor, termasuk layout kamera.', 'tutorials/36.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(37, 'TUTORIAL MENGATUR PENGATURAN UMUM (GENERAL) NVR', 'Konfigurasi umum seperti bahasa, standar video, dan lainnya.', 'tutorials/37.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(38, 'TUTORIAL MENGATUR KONFIGURASI REKAMAN NVR', 'Pengaturan detail untuk mode dan jadwal perekaman.', 'tutorials/38.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(39, 'TUTORIAL MENGATUR INTELLIGENT ALERT PADA NVR', 'Setup lanjutan untuk fitur-fitur analisis video pintar.', 'tutorials/39.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28'),
(40, '(IP) XMEye PANDUAN AWAL & FORMAT HARD DISK', 'Menghapus data secara permanen merupakan risiko yang harus dipertimbangkan.', 'tutorials/40.pdf', 'Konfigurasi Software', '2025-07-16 07:52:28', '2025-07-16 07:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `role` enum('loewix','dealer','customer') NOT NULL DEFAULT 'customer',
  `address` text DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `phone`, `phone_verified_at`, `role`, `address`, `province`, `city`, `postal_code`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Loewix Admin', 'admin@loewix.com', '2025-07-14 01:27:28', '081200000001', '2025-07-14 01:27:28', 'loewix', 'Jl. Industri No. 1, Kawasan Industri Candi', 'Jawa Tengah', 'Semarang', '50181', '$2y$12$d1tM72/OP/p69OYEetLM5OlBjg5JOEDCq6zsAhglvnlR3NafPacvq', NULL, '2025-07-14 01:27:28', '2025-07-21 19:27:35'),
(2, 'Dealer Jaya Abadi', 'jaya.abadi@dealer.com', '2025-07-14 01:27:28', '081211112222', '2025-07-14 01:27:28', 'dealer', 'Jl. Gajah Mada No. 10', 'DKI Jakarta', 'Jakarta Pusat', '10130', '$2y$12$PzNJPk6ziEv3pBTDQQ6RveCb13tKAGEQlCIx3xJQdR9kSbswz4NlG', NULL, '2025-07-14 01:27:28', '2025-07-18 19:45:11'),
(3, 'Dealer Rumah CCTV', 'rumah.cctv@gmail.com', '2025-07-14 01:27:28', '081333334444', '2025-07-14 01:27:28', 'dealer', 'Jetis, Sawahan, Kec. Ngemplak, Kabupaten Boyolali, Jawa Tengah 57375', 'Jawa Tengah', 'Boyolali', '57375', '$2y$12$16pLVCKyWMpBHz2RiLkkC.DGpbFH5XGJ7OOjeUBnx9lLKCbi2Tc3a', NULL, '2025-07-14 01:27:28', '2025-07-14 08:56:37'),
(4, 'Budi Santoso', 'budi.s@example.com', NULL, '085755556666', '2025-07-14 01:27:28', 'customer', 'Jl. Majapahit No. 200', 'Jawa Tengah', 'Semarang', '50249', '$2y$12$GP28m0wC9XLTKF6aCF5MiOEAv/T4mQDtOuEKQl2DjdGxzAFR86FH2', NULL, '2025-07-14 01:27:28', '2025-07-14 09:01:17'),
(5, 'Citra Lestari', 'citra.l@example.com', NULL, '081977778888', '2025-07-14 01:27:28', 'customer', 'Jl. Jenderal Sudirman No. 5', 'DKI Jakarta', 'Jakarta Selatan', '12190', '$2y$12$JkIkZgPuezK9QAok/dVNCePOo8X8fZx86lm5Tw9osw4/4g3fD3lGi', NULL, '2025-07-14 01:27:28', '2025-07-16 17:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('percentage','fixed') NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `max_discount` decimal(15,2) DEFAULT NULL,
  `min_purchase` decimal(15,2) DEFAULT 0.00,
  `valid_from` timestamp NULL DEFAULT NULL,
  `valid_to` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `for_dealer` tinyint(1) NOT NULL DEFAULT 0,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `description`, `type`, `value`, `max_discount`, `min_purchase`, `valid_from`, `valid_to`, `is_active`, `for_dealer`, `usage_limit`, `usage_count`, `created_at`, `updated_at`) VALUES
(1, 'DISKON10PERSEN', 'Diskon 10% untuk semua produk, maks. potongan Rp 20.000', 'percentage', 10.00, 20000.00, 50000.00, NULL, '2025-12-31 16:59:59', 1, 0, 5, 0, NULL, NULL),
(2, 'GRATISONGKIR15RB', 'Potongan ongkos kirim Rp 15.000', 'fixed', 15000.00, NULL, 100000.00, NULL, '2025-12-31 16:59:59', 1, 0, 5, 0, NULL, NULL),
(3, 'DEALERHEBAT', 'Potongan tambahan Rp 250.000 untuk dealer setia', 'fixed', 250000.00, NULL, 0.00, NULL, NULL, 1, 1, 5, 1, NULL, '2025-07-23 09:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `whislists`
--

CREATE TABLE `whislists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `produk_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `whislists`
--

INSERT INTO `whislists` (`id`, `user_id`, `produk_id`, `created_at`, `updated_at`) VALUES
(2, 5, '32', '2025-07-16 21:32:15', '2025-07-16 21:32:15'),
(3, 5, '24', '2025-07-16 21:55:24', '2025-07-16 21:55:24'),
(4, 5, '17', '2025-07-16 23:16:21', '2025-07-16 23:16:21'),
(5, 5, '27', '2025-07-23 07:57:40', '2025-07-23 07:57:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `dealer_banners`
--
ALTER TABLE `dealer_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dealer_carts`
--
ALTER TABLE `dealer_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dealer_carts_dealer_id_foreign` (`dealer_id`);

--
-- Indexes for table `dealer_profiles`
--
ALTER TABLE `dealer_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_dealer_assignments`
--
ALTER TABLE `order_dealer_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_images`
--
ALTER TABLE `produk_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_histories`
--
ALTER TABLE `stock_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_orders`
--
ALTER TABLE `stock_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_order_items`
--
ALTER TABLE `stock_order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whislists`
--
ALTER TABLE `whislists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dealer_banners`
--
ALTER TABLE `dealer_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dealer_carts`
--
ALTER TABLE `dealer_carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dealer_profiles`
--
ALTER TABLE `dealer_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_dealer_assignments`
--
ALTER TABLE `order_dealer_assignments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `otp_verifications`
--
ALTER TABLE `otp_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `produk_images`
--
ALTER TABLE `produk_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `stock_histories`
--
ALTER TABLE `stock_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_orders`
--
ALTER TABLE `stock_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_order_items`
--
ALTER TABLE `stock_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `whislists`
--
ALTER TABLE `whislists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
