-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2026 at 01:15 AM
-- Server version: 10.6.23-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dpmuii_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `alokasi_distribusi`
--

DROP TABLE IF EXISTS `alokasi_distribusi`;
CREATE TABLE `alokasi_distribusi` (
  `id` bigint(20) NOT NULL,
  `dana_triwulan_id` bigint(20) NOT NULL,
  `lembaga_id` bigint(20) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alokasi_distribusi`
--

INSERT INTO `alokasi_distribusi` (`id`, `dana_triwulan_id`, `lembaga_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 37125798, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(2, 1, 5, 37125798, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(3, 1, 6, 31822112, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(4, 1, 7, 0, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(5, 1, 3, 60108434, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(6, 1, 2, 10607371, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(7, 1, 14, 38184088, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(8, 1, 15, 19707916, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(9, 1, 16, 3695234, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(10, 1, 8, 37922920, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(11, 1, 9, 19573120, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(12, 1, 10, 3669960, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(13, 1, 11, 33434120, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(14, 1, 12, 17256320, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(15, 1, 13, 3235560, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(16, 1, 17, 28427000, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(17, 1, 18, 14672000, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(18, 1, 19, 2751000, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(19, 1, 20, 27174600, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(20, 1, 21, 14025600, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(21, 1, 22, 2629800, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(22, 1, 23, 22475000, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(23, 1, 24, 11600000, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(24, 1, 25, 2175000, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(25, 1, 26, 21445800, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(26, 1, 27, 11068800, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(27, 1, 28, 2075400, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(28, 1, 29, 17663800, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(29, 1, 30, 9116800, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(30, 1, 31, 1709400, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(31, 1, 32, 17242200, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(32, 1, 33, 8899200, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(33, 1, 34, 1668600, '2026-11-17 08:45:00', '2026-11-17 08:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `alokasi_taktis`
--

DROP TABLE IF EXISTS `alokasi_taktis`;
CREATE TABLE `alokasi_taktis` (
  `id` bigint(20) NOT NULL,
  `dana_triwulan_id` bigint(20) NOT NULL,
  `fakultas_id` bigint(20) DEFAULT NULL,
  `jumlah` bigint(20) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alokasi_taktis`
--

INSERT INTO `alokasi_taktis` (`id`, `dana_triwulan_id`, `fakultas_id`, `jumlah`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 41200000, 'Universitas', '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(2, 1, 1, 700000, NULL, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(3, 1, 3, 5000000, NULL, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(4, 1, 12, 9000000, NULL, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(5, 1, 6, 4400000, NULL, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(6, 1, 8, 5200000, NULL, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(7, 1, 13, 0, NULL, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(8, 1, 5, 3000000, NULL, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(9, 1, 7, 6600000, NULL, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(10, 1, 11, 5500000, NULL, '2026-11-17 08:45:00', '2026-11-17 08:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE `complaints` (
  `id` bigint(20) NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'baru',
  `response` longtext DEFAULT NULL,
  `responded_at` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `faculty` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `ticket_number`, `name`, `email`, `phone`, `category`, `subject`, `message`, `attachment_path`, `is_anonymous`, `status`, `response`, `responded_at`, `ip_address`, `created_at`, `updated_at`, `student_id`, `faculty`) VALUES
(1, 'DPM-261029-7A8B', 'Fathurrahman Al-Ghifari', '21522045@students.uii.ac.id', '081234567890', 'Fasilitas & Sarana Prasarana', 'Permohonan Penambahan Stopkontak dan Penguatan Wifi Gedung FTI', 'Mohon kepada DPM UII untuk mengadvokasikan penambahan fasilitas stopkontak di selasar lantai 2 dan 3 Gedung Mas Mansyur FTI serta optimalisasi jaringan wifi edukasi yang sering mengalami lonjakan trafik pada jam kuliah sibuk.', NULL, 0, 'baru', NULL, NULL, NULL, '2026-11-02 02:30:49', '2026-11-02 04:30:50', '21522045', 'Fakultas Teknologi Industri'),
(2, 'DPM-261029-3K9L', NULL, 'mahasiswa.fbe@students.uii.ac.id', NULL, 'Finansial & UKT', 'Transparansi Mekanisme Pengajuan Keringanan UKT Semester Genap', 'Kami mengharapkan adanya kejelasan batas waktu verifikasi berkas dan indikator penilaian bagi rekan-rekan mahasiswa yang mengajukan permohonan banding/keringanan pembayaran UKT.', NULL, 1, 'baru', NULL, NULL, NULL, '2026-11-01 23:30:49', '2026-11-02 04:30:52', '22311099', 'Fakultas Bisnis dan Ekonomika'),
(3, 'DPM-261028-9F2M', 'Nabila Zahra Syahrani', 'nabila.zahra@students.uii.ac.id', '085712349988', 'Advokasi & Kebijakan Kampus', 'Advokasi Perpanjangan Jam Operasional Perpustakaan Pusat UII', 'Sehubungan dengan meningkatnya kebutuhan ruang belajar yang representatif dan kondusif bagi mahasiswa menjelang periode ujian, kami mengusulkan advokasi perpanjangan jam operasional Perpustakaan Pusat hingga pukul 21.00 WIB.', NULL, 0, 'diproses', NULL, NULL, NULL, '2026-11-01 04:30:49', '2026-11-02 04:30:53', '23411012', 'Fakultas Hukum'),
(4, 'DPM-261025-1C4E', 'Muhammad Ilham Pratama', 'ilham.pratama@students.uii.ac.id', '087811223344', 'Konstitusi KM UII', 'Klarifikasi Tahapan Sosialisasi Perubahan PKM Pemilwa KM UII', 'Bagaimanakah alur keterlibatan lembaga legislatif fakultas dalam pembahasan draf akhir revisi PKM tentang Pemilwa sebelum disahkan dalam Sidang Paripurna DPM UII?', NULL, 0, 'selesai', 'Terima kasih atas perhatian dan aspirasi Saudara. Komisi I (Legislasi) DPM UII telah menyelenggarakan agenda Uji Publik Draf PKM Pemilwa bersama delegasi DPM Fakultas se-UII. Risalah pembahasan dan matriks persandingan pasal dapat diakses terbuka pada portal ini.', '2026-10-31 04:30:49', NULL, '2026-10-29 04:30:49', '2026-11-02 04:30:55', '20320078', 'Fakultas Ilmu Agama Islam'),
(5, 'DPM-261020-8H5Z', 'Rendi Kurniawan', 'rendi.k@students.uii.ac.id', '089988776655', 'Lainnya', 'Pengajuan Proposal Sponsor Produk Minuman Luar Kampus', 'Pengajuan proposal kerjasama sponsorship komersial untuk kegiatan perlombaan eksternal.', NULL, 0, 'ditolak', 'Kanal Layanan Aspirasi DPM UII dikhususkan untuk penyerapan aspirasi, advokasi kebijakan kemahasiswaan, dan pengawalan hak-hak mahasiswa KM UII. Untuk pengajuan sponsorship dan kerjasama komersial, silakan berkoordinasi langsung dengan Direktorat Kemitraan Kampus.', '2026-10-26 04:30:49', NULL, '2026-10-24 04:30:49', '2026-11-02 04:30:56', '22511033', 'Fakultas Teknik Sipil dan Perencanaan');

-- --------------------------------------------------------

--
-- Table structure for table `dana_info`
--

DROP TABLE IF EXISTS `dana_info`;
CREATE TABLE `dana_info` (
  `id` bigint(20) NOT NULL,
  `dana_triwulan_id` bigint(20) NOT NULL,
  `seksi` varchar(255) NOT NULL,
  `teks` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dana_info`
--

INSERT INTO `dana_info` (`id`, `dana_triwulan_id`, `seksi`, `teks`, `created_at`, `updated_at`) VALUES
(1, 1, 'overview', 'Total dana distribusi periode 2025/2026 Triwulan I sebesar Rp688.575.000,00.', '2026-11-07 19:46:48', '2026-11-07 19:46:48'),
(2, 1, 'pembagian', 'Dana dibagi menjadi komponen transisi, taktis, aset, dan distribusi.', '2026-11-07 19:46:49', '2026-11-07 19:46:49'),
(3, 1, 'universitas', 'Dana tingkat universitas dialokasikan kepada DPM Universitas dan LEM Universitas.', '2026-11-07 19:46:51', '2026-11-07 19:46:51'),
(4, 1, 'fakultas', 'Dana tingkat fakultas dialokasikan kepada LEM, LPM, dan DPM tiap fakultas.', '2026-11-07 19:46:52', '2026-11-07 19:46:52'),
(5, 1, 'per_fakultas', 'Setiap fakultas menerima alokasi sesuai dengan jumlah mahasiswa dan kebutuhan program kerja.', '2026-11-07 19:46:54', '2026-11-07 19:46:54'),
(6, 1, 'rasio', 'Rasio alokasi per fakultas dihitung berdasarkan proporsi jumlah mahasiswa per fakultas terhadap total mahasiswa.', '2026-11-07 19:46:56', '2026-11-07 19:46:56'),
(7, 1, 'taktis', 'Dana taktis dialokasikan untuk kebutuhan operasional dan program kerja tingkat universitas dan fakultas.', '2026-11-07 19:46:57', '2026-11-07 19:46:57');

-- --------------------------------------------------------

--
-- Table structure for table `dana_komponen`
--

DROP TABLE IF EXISTS `dana_komponen`;
CREATE TABLE `dana_komponen` (
  `id` bigint(20) NOT NULL,
  `dana_triwulan_id` bigint(20) NOT NULL,
  `komponen_id` bigint(20) NOT NULL,
  `jumlah` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dana_komponen`
--

INSERT INTO `dana_komponen` (`id`, `dana_triwulan_id`, `komponen_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 12000000, '2026-11-07 19:45:00', '2026-11-07 19:45:00'),
(2, 1, 2, 103286250, '2026-11-07 19:45:02', '2026-11-07 19:45:02'),
(3, 1, 3, 3000000, '2026-11-07 19:45:03', '2026-11-07 19:45:03'),
(4, 1, 4, 570288750, '2026-11-07 19:45:05', '2026-11-07 19:45:05');

-- --------------------------------------------------------

--
-- Table structure for table `dana_revisi`
--

DROP TABLE IF EXISTS `dana_revisi`;
CREATE TABLE `dana_revisi` (
  `id` bigint(20) NOT NULL,
  `dana_triwulan_id` bigint(20) NOT NULL,
  `diubah_oleh` bigint(20) DEFAULT NULL,
  `alasan` longtext NOT NULL,
  `snapshot` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`snapshot`)),
  `dibuat_pada` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dana_revisi`
--

INSERT INTO `dana_revisi` (`id`, `dana_triwulan_id`, `diubah_oleh`, `alasan`, `snapshot`, `dibuat_pada`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Pembentukan data awal distribusi dana Triwulan I.', '{\"total_dana\":688575000,\"status\":\"terbit\"}', '2026-11-07 19:47:20', '2026-11-07 19:47:20', '2026-11-07 19:47:20'),
(2, 1, 1, 'Pembentukan data awal distribusi dana Triwulan I.', '{\"total_dana\":688575000,\"status\":\"terbit\"}', '2026-11-07 21:14:44', '2026-11-07 21:14:44', '2026-11-07 21:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `dana_seksi`
--

DROP TABLE IF EXISTS `dana_seksi`;
CREATE TABLE `dana_seksi` (
  `id` bigint(20) NOT NULL,
  `dana_triwulan_id` bigint(20) NOT NULL,
  `seksi` varchar(255) NOT NULL,
  `urutan` smallint(6) NOT NULL DEFAULT 0,
  `is_tampil` tinyint(1) NOT NULL DEFAULT 1,
  `judul` varchar(120) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dana_seksi`
--

INSERT INTO `dana_seksi` (`id`, `dana_triwulan_id`, `seksi`, `urutan`, `is_tampil`, `judul`, `created_at`, `updated_at`) VALUES
(1, 1, 'overview', 1, 1, 'Ringkasan', '2026-11-07 19:46:59', '2026-11-07 19:46:59'),
(2, 1, 'pembagian', 2, 1, 'Pembagian Komponen', '2026-11-07 19:47:01', '2026-11-07 19:47:01'),
(3, 1, 'universitas', 3, 1, 'Tingkat Universitas', '2026-11-07 19:47:03', '2026-11-07 19:47:03'),
(4, 1, 'fakultas', 4, 1, 'Tingkat Fakultas', '2026-11-07 19:47:04', '2026-11-07 19:47:04'),
(5, 1, 'per_fakultas', 5, 1, 'Per Fakultas', '2026-11-07 19:47:06', '2026-11-07 19:47:06'),
(6, 1, 'rasio', 6, 1, 'Rasio Mahasiswa', '2026-11-07 19:47:08', '2026-11-07 19:47:08'),
(7, 1, 'taktis', 7, 1, 'Dana Taktis', '2026-11-07 19:47:09', '2026-11-07 19:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `dana_triwulan`
--

DROP TABLE IF EXISTS `dana_triwulan`;
CREATE TABLE `dana_triwulan` (
  `id` bigint(20) NOT NULL,
  `periode_id` bigint(20) NOT NULL,
  `triwulan` smallint(6) NOT NULL,
  `total_dana` bigint(20) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `diterbitkan_pada` datetime DEFAULT NULL,
  `diterbitkan_oleh` bigint(20) DEFAULT NULL,
  `sumber_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dana_triwulan`
--

INSERT INTO `dana_triwulan` (`id`, `periode_id`, `triwulan`, `total_dana`, `status`, `diterbitkan_pada`, `diterbitkan_oleh`, `sumber_url`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 688575000, 'terbit', '2026-11-07 21:13:41', 1, NULL, '2026-11-07 19:44:59', '2026-11-07 21:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` bigint(20) NOT NULL,
  `document_category_id` bigint(20) NOT NULL,
  `period_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `external_url` varchar(2048) DEFAULT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `size` bigint(20) NOT NULL DEFAULT 0,
  `year` smallint(6) DEFAULT NULL,
  `quarter` smallint(6) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `downloads` bigint(20) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `document_category_id`, `period_id`, `title`, `slug`, `description`, `file_path`, `external_url`, `mime_type`, `size`, `year`, `quarter`, `published_at`, `downloads`, `is_featured`, `sort_order`, `created_at`, `updated_at`) VALUES
(75, 10, NULL, 'Surat Keputusan Direktorat Sekretaris Jenderal', 'surat-keputusan-direktorat-sekretaris-jenderal', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK DIREKTORAT SEKRETARIS JENDERAL.pdf', NULL, 'application/pdf', 502559, 2024, NULL, '2024-01-01 00:00:00', 7, 0, 1, '2026-11-02 05:27:36', '2026-11-16 14:28:46'),
(76, 10, NULL, 'Surat Keputusan Panwas', 'surat-keputusan-panwas', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK PANWAS PERIODE 2022-2023.pdf', NULL, 'application/pdf', 466886, 2022, NULL, '2022-01-01 00:00:00', 7, 0, 2, '2026-11-02 05:27:39', '2026-11-16 14:06:55'),
(77, 10, NULL, 'Surat Keputusan Struktur Panitia Pengawas Pemilihan Umum Wakil Mahasiswa', 'surat-keputusan-struktur-panitia-pengawas-pemilihan-umum-wakil-mahasiswa', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK STRUKTUR PANITIA PENGAWAS PEMILIHAN UMUM WAKIL MAHASISWA.pdf', NULL, 'application/pdf', 466886, 2024, NULL, '2024-01-01 00:00:00', 6, 0, 3, '2026-11-02 05:27:42', '2026-11-15 05:43:38'),
(78, 10, NULL, 'Surat Keputusan Baleg Komisi I', 'surat-keputusan-baleg-komisi-i', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK-BALEG KOMISI I _REVISI=final.pdf', NULL, 'application/pdf', 173503, 2024, NULL, '2024-01-01 00:00:00', 8, 0, 4, '2026-11-02 05:27:45', '2026-11-15 05:39:42'),
(79, 10, NULL, 'Surat Keputusan Struktur KPSU UII', 'surat-keputusan-struktur-kpsu-uii', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK-STRUKTUR KPSU-UII 2021-Fix.pdf', NULL, 'application/pdf', 404372, 2021, NULL, '2021-01-01 00:00:00', 5, 0, 5, '2026-11-02 05:27:48', '2026-11-16 11:25:07'),
(80, 10, NULL, 'Surat Keputusan Tim MO & AD Pesta', 'surat-keputusan-tim-mo-ad-pesta', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK-TIM MO & AD pesta_final.pdf', NULL, 'application/pdf', 152238, 2024, NULL, '2024-01-01 00:00:00', 7, 0, 6, '2026-11-02 05:27:51', '2026-11-15 05:38:46'),
(81, 10, NULL, 'Surat Keputusan BAK KM UII', 'surat-keputusan-bak-km-uii', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN BAK KM UII 2021 FINAL.pdf', NULL, 'application/pdf', 179972, 2021, NULL, '2021-01-01 00:00:00', 3, 0, 7, '2026-11-02 05:27:54', '2026-11-15 16:21:01'),
(83, 10, NULL, 'Surat Keputusan BPA KM UII', 'surat-keputusan-bpa-km-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN BPA KM UII 2020-2021.pdf', NULL, 'application/pdf', 236612, 2020, NULL, '2020-01-01 00:00:00', 5, 0, 8, '2026-11-02 05:28:00', '2026-11-16 13:12:55'),
(85, 11, NULL, 'Surat Keputusan DPM FBE UII', 'surat-keputusan-dpm-fbe-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FBE UII 2020-2021.pdf', NULL, 'application/pdf', 164193, 2020, NULL, '2020-01-01 00:00:00', 4, 0, 9, '2026-11-02 05:28:06', '2026-11-16 08:35:49'),
(87, 11, NULL, 'Surat Keputusan DPM FH UII', 'surat-keputusan-dpm-fh-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FH UII 2020-2021.pdf', NULL, 'application/pdf', 164369, 2020, NULL, '2020-01-01 00:00:00', 4, 0, 10, '2026-11-02 05:28:12', '2026-11-15 16:43:52'),
(89, 11, NULL, 'Surat Keputusan DPM FIAI UII', 'surat-keputusan-dpm-fiai-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FIAI UII 2020-2021.pdf', NULL, 'application/pdf', 208616, 2020, NULL, '2020-01-01 00:00:00', 5, 0, 11, '2026-11-02 05:28:18', '2026-11-16 09:24:01'),
(91, 11, NULL, 'Surat Keputusan DPM FK UII', 'surat-keputusan-dpm-fk-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FK UII 2020-2021.pdf', NULL, 'application/pdf', 164657, 2020, NULL, '2020-01-01 00:00:00', 4, 0, 12, '2026-11-02 05:28:24', '2026-11-16 17:28:56'),
(92, 11, NULL, 'Surat Keputusan DPM FMIPA UII', 'surat-keputusan-dpm-fmipa-uii', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FMIPA UII 2020-2021_revisi.pdf', NULL, 'application/pdf', 168941, 2020, NULL, '2020-01-01 00:00:00', 4, 0, 13, '2026-11-02 05:28:27', '2026-11-16 12:21:03'),
(93, 11, NULL, 'Surat Keputusan DPM FTI UII', 'surat-keputusan-dpm-fti-uii', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FTI UII 2020-2021 final.pdf', NULL, 'application/pdf', 207614, 2020, NULL, '2020-01-01 00:00:00', 5, 0, 14, '2026-11-02 05:28:30', '2026-11-16 17:28:54'),
(96, 11, NULL, 'Surat Keputusan DPM FTSP UII', 'surat-keputusan-dpm-ftsp-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FTSP UII 2020-2021.pdf', NULL, 'application/pdf', 292841, 2020, NULL, '2020-01-01 00:00:00', 4, 0, 15, '2026-11-02 05:28:39', '2026-11-16 18:09:52'),
(97, 10, NULL, 'Surat Keputusan KPU', 'surat-keputusan-kpu-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN KPU 2022.pdf', NULL, 'application/pdf', 193386, 2022, NULL, '2022-01-01 00:00:00', 4, 0, 16, '2026-11-02 05:28:42', '2026-11-16 12:00:40'),
(99, 10, NULL, 'Surat Keputusan Pembentukan DPM FPSB UII', 'surat-keputusan-pembentukan-dpm-fpsb-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN PEMBENTUKAN DPM FPSB UII 2020-2021.pdf', NULL, 'application/pdf', 204185, 2020, NULL, '2020-01-01 00:00:00', 3, 0, 17, '2026-11-02 05:28:48', '2026-11-16 10:07:27'),
(100, 12, NULL, 'Surat Keputusan Pengesahan Struktur Pengurus Lembaga Khusus Pers Himmah', 'surat-keputusan-pengesahan-struktur-pengurus-lembaga-khusus-pers-himmah', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN PENGESAHAN STRUKTUR PENGURUS LEMBAGA KHUSUS PERS HIMMAH.pdf', NULL, 'application/pdf', 603542, 2024, NULL, '2024-01-01 00:00:00', 6, 0, 18, '2026-11-02 05:28:51', '2026-11-16 17:59:53'),
(101, 10, NULL, 'Surat Keputusan Tim Produksi', 'surat-keputusan-tim-produksi', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN-TIM PRODUKSI-1.pdf', NULL, 'application/pdf', 224345, 2024, NULL, '2024-01-01 00:00:00', 4, 0, 19, '2026-11-02 05:28:54', '2026-11-16 09:09:03'),
(102, 8, NULL, 'Ketetapan DPM UII Nomor XLI', 'ketetapan-dpm-uii-nomor-xli', 'Surat Ketetapan DPM UII', 'uploads/produk-hukum/SURAT KETETAPAN/S-TAP-SU-XLI_DPM UII-final.pdf', NULL, 'application/pdf', 162922, 2024, NULL, '2024-01-01 00:00:00', 8, 0, 1, '2026-11-02 05:28:57', '2026-11-16 17:28:59'),
(103, 9, NULL, 'RPKM Kode Etik Lembaga Legislatif', 'rpkm-kode-etik-lembaga-legislatif', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM KODE ETIK LEMBAGA LEGISLATIF.pdf', NULL, 'application/pdf', 131774, 2024, NULL, '2024-01-01 00:00:00', 5, 0, 1, '2026-11-02 05:29:00', '2026-11-16 17:28:58'),
(104, 9, NULL, 'RPKM Lembaga Legislatif', 'rpkm-lembaga-legislatif', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM LEMBAGA LEGISLATIF.pdf', NULL, 'application/pdf', 174564, 2024, NULL, '2024-01-01 00:00:00', 6, 0, 2, '2026-11-02 05:29:02', '2026-11-16 05:09:42'),
(105, 9, NULL, 'RPKM LMBG Khusus', 'rpkm-lmbg-khusus', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM LMBG KHUSUS.pdf', NULL, 'application/pdf', 155011, 2024, NULL, '2024-01-01 00:00:00', 7, 0, 3, '2026-11-02 05:29:04', '2026-11-16 17:28:57'),
(106, 9, NULL, 'RPKM Pedoman Kegiatan', 'rpkm-pedoman-kegiatan', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM PEDOMAN KEGIATAN.pdf', NULL, 'application/pdf', 174858, 2024, NULL, '2024-01-01 00:00:00', 5, 0, 4, '2026-11-02 05:29:07', '2026-11-16 17:28:57'),
(107, 9, NULL, 'RPKM Pedoman Struktur LMBG Eksekutif', 'rpkm-pedoman-struktur-lmbg-eksekutif', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM PEDOMAN STRUKTUR LMBG EKSEKUTIF.pdf', NULL, 'application/pdf', 174634, 2024, NULL, '2024-01-01 00:00:00', 6, 0, 5, '2026-11-02 05:29:09', '2026-11-16 12:09:56'),
(108, 9, NULL, 'RPKM Pembentukan, Pembekuan dan Pembubaran Lembaga', 'rpkm-pembentukan-pembekuan-dan-pembubaran-lembaga', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM PEMBENTUKAN, PEMBEKUAN DAN PEMBUBARAN LEMBAGA.pdf', NULL, 'application/pdf', 150680, 2024, NULL, '2024-01-01 00:00:00', 5, 0, 6, '2026-11-02 05:29:11', '2026-11-16 17:28:56'),
(109, 9, NULL, 'RPKM UKMK', 'rpkm-ukmk', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM UKMK.pdf', NULL, 'application/pdf', 154675, 2024, NULL, '2024-01-01 00:00:00', 6, 0, 7, '2026-11-02 05:29:13', '2026-11-16 14:38:16'),
(110, 9, NULL, 'PKM Aset KM UII', 'pkm-aset-km-uii', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KETERANGAN AKADEMIK PKM ASET KM UII.pdf', NULL, 'application/pdf', 158892, 2024, NULL, '2024-01-01 00:00:00', 2, 0, 8, '2026-11-02 05:29:16', '2026-11-16 17:28:58'),
(111, 9, NULL, 'RPKM Foraslak', 'rpkm-foraslak', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KETERANGAN AKADEMIK RPKM FORASLAK.pdf', NULL, 'application/pdf', 126971, 2024, NULL, '2024-01-01 00:00:00', 5, 0, 9, '2026-11-02 05:29:18', '2026-11-16 12:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `document_categories`
--

DROP TABLE IF EXISTS `document_categories`;
CREATE TABLE `document_categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'main'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `document_categories`
--

INSERT INTO `document_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `created_at`, `updated_at`, `group`, `parent_id`, `type`) VALUES
(1, 'Produk Hukum', 'produk-hukum', 'PDKM, GBHKM, PKM, dan PDPM sebagai dasar penyelenggaraan KM UII.', 1, '2026-11-02 04:29:22', '2026-11-02 04:29:22', 'Produk Hukum', NULL, 'main'),
(2, 'Surat Keputusan', 'surat-keputusan', 'Surat keputusan yang dikeluarkan DPM UII: badan, tim kelengkapan dewan, lembaga, dan penyelenggara pemilu.', 2, '2026-11-02 04:29:24', '2026-11-02 04:29:24', 'Keputusan', NULL, 'main'),
(3, 'Laporan Kinerja', 'laporan-kinerja', 'Laporan kinerja DPM UII: Foraslak, Laporan Akhir, Evaluasi Kinerja, dan dokumen penilaian kinerja per periode.', 9, '2026-11-02 04:29:26', '2026-11-02 04:32:21', 'Kinerja', NULL, 'main'),
(4, 'Distribusi Dana', 'distribusi-dana', 'Rincian distribusi dan alokasi dana KM UII per lembaga.', 4, '2026-11-02 04:29:29', '2026-11-02 04:29:29', 'Dana', NULL, 'main'),
(5, 'LPJ', 'lpj', 'Laporan pertanggungjawaban penggunaan dana kegiatan KM UII.', 5, '2026-11-02 04:29:31', '2026-11-02 04:29:31', 'Dana', NULL, 'main'),
(6, 'LHA', 'lha', 'Laporan hasil audit pengelolaan keuangan dan aset kemahasiswaan.', 6, '2026-11-02 04:29:33', '2026-11-02 04:29:33', 'Dana', NULL, 'main'),
(7, 'Laporan Keuangan', 'laporan-keuangan', 'Laporan keuangan triwulan dan laporan penggunaan dana kegiatan.', 7, '2026-11-02 04:29:35', '2026-11-02 04:29:35', 'Dana', NULL, 'main'),
(8, 'Surat Ketetapan', 'surat-ketetapan', 'Ketetapan dan penetapan yang dikeluarkan DPM UII dalam sidang paripurna.', 3, '2026-11-02 04:32:16', '2026-11-02 04:32:16', 'Keputusan', NULL, 'main'),
(9, 'Keterangan Akademik', 'keterangan-akademik', 'Surat keterangan akademik yang diterbitkan DPM UII.', 8, '2026-11-02 04:32:19', '2026-11-02 04:32:19', 'Akademik', NULL, 'main'),
(10, 'Badan Kelengkapan Dewan', 'badan-kelengkapan-dewan', 'Surat keputusan dari badan-badan kelengkapan Dewan: Baleg, Bawas, BAK, BPA, Bksaj, Mentari, Pimpinan, KPU, Panwas, Sekretariat.', 1, '2026-11-02 04:32:23', '2026-11-02 04:32:23', 'Keputusan', 2, 'sub'),
(11, 'DPM Fakultas', 'dpm-fakultas', 'Surat keputusan dari DPM Fakultas se-UII: FBE, FH, FIA, FK, FMIPA, FTI, FTSP, FPSB, FPSI, FIA, FEB, dll.', 2, '2026-11-02 04:32:26', '2026-11-02 04:32:26', 'Keputusan', 2, 'sub'),
(12, 'Lembaga & LK', 'lembaga-lk', 'Surat keputusan dari Lembaga Khusus, LK, dan unit kerja lain: Pers Himmah, Tim Produksi, dll.', 3, '2026-11-02 04:32:29', '2026-11-02 04:32:29', 'Keputusan', 2, 'sub');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_keuangan`
--

DROP TABLE IF EXISTS `dokumen_keuangan`;
CREATE TABLE `dokumen_keuangan` (
  `id` bigint(20) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `periode_id` bigint(20) NOT NULL,
  `lembaga_id` bigint(20) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumen_keuangan`
--

INSERT INTO `dokumen_keuangan` (`id`, `jenis`, `periode_id`, `lembaga_id`, `semester`, `judul`, `tanggal`, `file_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 'lpj', 3, 2, 'ganjil', 'LPJ DPM Universitas Semester Ganjil 2025/2026', '2026-01-15', NULL, 'terbit', '2026-11-07 19:47:12', '2026-11-07 19:47:12'),
(2, 'lha', 3, 2, 'ganjil', 'LHA DPM Universitas Semester Ganjil 2025/2026', '2026-02-01', NULL, 'draft', '2026-11-07 19:47:13', '2026-11-07 19:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

DROP TABLE IF EXISTS `fakultas`;
CREATE TABLE `fakultas` (
  `id` bigint(20) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `urutan` smallint(6) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id`, `kode`, `nama`, `urutan`, `created_at`, `updated_at`) VALUES
(11, 'FBE', 'Fakultas Bisnis & Ekonomika', 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(1, 'FH', 'Fakultas Hukum', 2, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(3, 'FTI', 'Fakultas Teknik Industri', 3, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(12, 'FISB', 'Fakultas Ilmu Sosial Budaya', 4, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(6, 'FTSP', 'Fakultas Teknik Sipil & Perencanaan', 5, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(8, 'FMIPA', 'Fakultas MIPA', 6, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(13, 'FPSI', 'Fakultas Psikologi', 7, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(5, 'FIAI', 'Fakultas Ilmu Agama Islam', 8, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(7, 'FK', 'Fakultas Kedokteran', 9, '2026-11-17 08:45:00', '2026-11-17 08:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(6) NOT NULL,
  `reserved_at` int(11) DEFAULT NULL,
  `available_at` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` longtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `komponen_dana`
--

DROP TABLE IF EXISTS `komponen_dana`;
CREATE TABLE `komponen_dana` (
  `id` bigint(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `urutan` smallint(6) NOT NULL DEFAULT 0,
  `is_tampil` tinyint(1) NOT NULL DEFAULT 1,
  `peran` varchar(255) NOT NULL DEFAULT 'lainnya',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komponen_dana`
--

INSERT INTO `komponen_dana` (`id`, `kode`, `nama`, `urutan`, `is_tampil`, `peran`, `created_at`, `updated_at`) VALUES
(1, 'transisi', 'Dana Transisi', 1, 1, 'lainnya', '2026-11-07 19:44:52', '2026-11-07 19:44:52'),
(2, 'taktis', 'Dana Taktis', 2, 1, 'taktis', '2026-11-07 19:44:54', '2026-11-07 19:44:54'),
(3, 'aset', 'Pengembangan dan Pengelolaan Aset', 3, 1, 'lainnya', '2026-11-07 19:44:55', '2026-11-07 19:44:55'),
(4, 'distribusi', 'Dana Distribusi', 4, 1, 'distribusi', '2026-11-07 19:44:57', '2026-11-07 19:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `legal_products`
--

DROP TABLE IF EXISTS `legal_products`;
CREATE TABLE `legal_products` (
  `id` bigint(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `number` smallint(6) DEFAULT NULL,
  `year` smallint(6) DEFAULT NULL,
  `period_id` bigint(20) DEFAULT NULL,
  `amends_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `size` bigint(20) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` datetime DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `downloads` bigint(20) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `edition` varchar(50) DEFAULT NULL,
  `enacted_on` date DEFAULT NULL,
  `forum` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `legal_products`
--

INSERT INTO `legal_products` (`id`, `type`, `number`, `year`, `period_id`, `amends_id`, `title`, `slug`, `description`, `file_path`, `mime_type`, `size`, `is_published`, `published_at`, `sort_order`, `downloads`, `created_at`, `updated_at`, `status`, `edition`, `enacted_on`, `forum`) VALUES
(86, 'pdkm', NULL, 2024, NULL, NULL, 'Peraturan Dasar KM UII Ke-38 (1)', 'peraturan-dasar-km-uii-ke-38-1-pdkm-single-2024', 'Peraturan Dasar Keluarga Mahasiswa (PDKM) merupakan konstitusi tertinggi KM UII yang mengatur asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa.', 'uploads/produk-hukum/PDKM UII/PERATURAN DASAR KM UII KE-38 (1).pdf', 'application/pdf', 763035, 1, '2026-11-07 22:50:52', 1, 9, '2026-11-07 22:50:54', '2026-11-16 17:27:24', 'aktif', NULL, NULL, NULL),
(87, 'gbhkm', NULL, 2024, NULL, NULL, 'SU Xlv (45)', 'su-xlv-45-gbhkm-single-2024', 'GBHKM merupakan manifestasi dari arah gerak dan cita-cita mahasiswa UII yang disusun dan disahkan oleh DPM UII melalui Sidang Umum atau Sidang Istimewa. Dokumen ini berfungsi sebagai pedoman resmi dan landasan penyusunan rencana kerja yang berkesinambungan bagi seluruh lembaga kemahasiswaan di lingkungan KM UII.', 'uploads/produk-hukum/GBHKM/GBHKM SU XLV (45).pdf', 'application/pdf', 384092, 1, '2026-11-07 22:50:54', 1, 6, '2026-11-07 22:50:56', '2026-11-16 17:28:43', 'aktif', NULL, NULL, NULL),
(88, 'pkm', 2, 2022, NULL, NULL, 'Pemilihan Umum Wakil Mahasiswa Perubahan Atas PKM Nomor 2 Tahun 2018 Tentang Pemilihan Umum Wakil Mahasiswa-final.docx', 'pemilihan-umum-wakil-mahasiswa-perubahan-atas-pkm-nomor-2-tahun-2018-tentang-pemilihan-umum-wakil-mahasiswa-finaldocx-pkm-2-2022', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM NOMOR 2 TAHUN 2022 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA PERUBAHAN ATAS PKM NOMOR 2 TAHUN 2018 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA-final.docx.pdf', 'application/pdf', 347327, 1, '2026-11-07 22:50:57', 1, 3, '2026-11-07 22:50:59', '2026-11-15 00:14:15', 'aktif', NULL, NULL, NULL),
(89, 'pkm', 2, 2022, NULL, NULL, 'Pemilihan Umum Wakil Mahasiswa Perubahan Kedua Atas PKM Nomor 2 Tahun 2018 Tentang Pemilihan Umum Wakil Mahasiswa-final.docx', 'pemilihan-umum-wakil-mahasiswa-perubahan-kedua-atas-pkm-nomor-2-tahun-2018-tentang-pemilihan-umum-wakil-mahasiswa-finaldocx-pkm-2-2022', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM NOMOR 2 TAHUN 2022 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA PERUBAHAN KEDUA ATAS PKM NOMOR 2 TAHUN 2018 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA-final.docx.pdf', 'application/pdf', 425716, 1, '2026-11-07 22:50:59', 2, 4, '2026-11-07 22:51:01', '2026-11-16 17:28:43', 'aktif', NULL, NULL, NULL),
(90, 'pkm', 1, 2024, NULL, NULL, 'Perubahan Atas PKM Pedoman Administrasi', 'perubahan-atas-pkm-pedoman-administrasi-pkm-1-2024', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM No. 1 Th 2024 tentang Perubahan Atas PKM Pedoman Administrasi.pdf', 'application/pdf', 430114, 1, '2026-11-07 22:51:02', 3, 2, '2026-11-07 22:51:04', '2026-11-15 18:15:39', 'aktif', NULL, NULL, NULL),
(91, 'pkm', 2, 2024, NULL, NULL, 'Pedoman Kegiatan KM UII', 'pedoman-kegiatan-km-uii-pkm-2-2024', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM No. 2 Th 2024 tentang Pedoman Kegiatan KM UII.pdf', 'application/pdf', 398917, 1, '2026-11-07 22:51:04', 4, 3, '2026-11-07 22:51:06', '2026-11-16 17:52:57', 'aktif', NULL, NULL, NULL),
(92, 'pkm', 3, 2024, NULL, NULL, 'Perubahan Atas PKM Alokasi Dana', 'perubahan-atas-pkm-alokasi-dana-pkm-3-2024', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM No. 3 Th 2024 tentang Perubahan Atas PKM Alokasi Dana.pdf', 'application/pdf', 294576, 1, '2026-11-07 22:51:07', 5, 1, '2026-11-07 22:51:09', '2026-11-16 17:28:43', 'aktif', NULL, NULL, NULL),
(93, 'pkm', NULL, 2023, NULL, NULL, 'Pemilwa Dan Penjelasan', 'pemilwa-dan-penjelasan-pkm-single-2023', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM PEMILWA DAN PENJELASAN 2023.pdf', 'application/pdf', 511350, 1, '2026-11-07 22:51:10', 6, 3, '2026-11-07 22:51:11', '2026-11-16 13:40:21', 'aktif', NULL, NULL, NULL),
(94, 'pkm', 1, 2019, NULL, NULL, 'Kode Etik Lembaga Legislatif UII', 'kode-etik-lembaga-legislatif-uii-pkm-1-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 1 TAHUN 2019 TENTANG KODE ETIK LEMBAGA LEGISLATIF UII.pdf', 'application/pdf', 258028, 1, '2026-11-07 22:51:12', 7, 0, '2026-11-07 22:51:14', '2026-11-07 22:51:14', 'aktif', NULL, NULL, NULL),
(95, 'pkm', 10, 2019, NULL, NULL, 'Pengelolaan Aset KM UII', 'pengelolaan-aset-km-uii-pkm-10-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 10 TAHUN 2019 TENTANG PENGELOLAAN ASET KM UII.pdf', 'application/pdf', 231802, 1, '2026-11-07 22:51:15', 8, 4, '2026-11-07 22:51:16', '2026-11-15 05:40:49', 'aktif', NULL, NULL, NULL),
(96, 'pkm', 2, 2018, NULL, NULL, 'Pemilihan Umum Wakil Mahasiswa UII', 'pemilihan-umum-wakil-mahasiswa-uii-pkm-2-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 2 TAHUN 2018 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA UII.pdf', 'application/pdf', 548805, 1, '2026-11-07 22:51:17', 9, 3, '2026-11-07 22:51:19', '2026-11-16 17:28:43', 'aktif', NULL, NULL, NULL),
(97, 'pkm', 3, 2018, NULL, NULL, 'Pengelolaan Aspirasi Mahasiswa UII', 'pengelolaan-aspirasi-mahasiswa-uii-pkm-3-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 3 TAHUN 2018 TENTANG PENGELOLAAN ASPIRASI MAHASISWA UII.pdf', 'application/pdf', 318291, 1, '2026-11-07 22:51:20', 10, 0, '2026-11-07 22:51:21', '2026-11-07 22:51:21', 'aktif', NULL, NULL, NULL),
(98, 'pkm', 3, 2019, NULL, NULL, 'DPM U & DPM F', 'dpm-u-dpm-f-pkm-3-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 3 TAHUN 2019 TENTANG DPM U & DPM F.pdf', 'application/pdf', 351520, 1, '2026-11-07 22:51:22', 11, 3, '2026-11-07 22:51:24', '2026-11-16 17:28:44', 'aktif', NULL, NULL, NULL),
(99, 'pkm', 4, 2018, NULL, NULL, 'Produksi Jas Almamater UII', 'produksi-jas-almamater-uii-pkm-4-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 4 TAHUN 2018 TENTANG PRODUKSI JAS ALMAMATER UII.pdf', 'application/pdf', 248879, 1, '2026-11-07 22:51:25', 12, 1, '2026-11-07 22:51:26', '2026-11-16 17:28:43', 'aktif', NULL, NULL, NULL),
(100, 'pkm', 4, 2019, NULL, NULL, 'Pedoman Pelaksanaan Foraslak Lembaga Legislatif KM UII', 'pedoman-pelaksanaan-foraslak-lembaga-legislatif-km-uii-pkm-4-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 4 TAHUN 2019 TENTANG PEDOMAN PELAKSANAAN FORASLAK LEMBAGA LEGISLATIF KM UII.pdf', 'application/pdf', 322317, 1, '2026-11-07 22:51:27', 13, 1, '2026-11-07 22:51:29', '2026-11-15 02:36:46', 'aktif', NULL, NULL, NULL),
(101, 'pkm', 5, 2018, NULL, NULL, 'Pedoman Keanggotaan KM UII', 'pedoman-keanggotaan-km-uii-pkm-5-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 5 TAHUN 2018 TENTANG PEDOMAN KEANGGOTAAN KM UII.pdf', 'application/pdf', 276852, 1, '2026-11-07 22:51:30', 14, 2, '2026-11-07 22:51:31', '2026-11-14 10:18:34', 'aktif', NULL, NULL, NULL),
(102, 'pkm', 5, 2019, NULL, NULL, 'UKM KM UII', 'ukm-km-uii-pkm-5-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 5 TAHUN 2019 TENTANG UKM KM UII.pdf', 'application/pdf', 341161, 1, '2026-11-07 22:51:32', 15, 4, '2026-11-07 22:51:34', '2026-11-14 22:49:59', 'aktif', NULL, NULL, NULL),
(103, 'pkm', 6, 2018, NULL, NULL, 'Pedoman Administrasi KM UII (1)', 'pedoman-administrasi-km-uii-1-pkm-6-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 6 TAHUN 2018 TENTANG PEDOMAN ADMINISTRASI KM UII (1).pdf', 'application/pdf', 371577, 1, '2026-11-07 22:51:35', 16, 3, '2026-11-07 22:51:36', '2026-11-16 04:07:59', 'aktif', NULL, NULL, NULL),
(104, 'pkm', 6, 2019, NULL, NULL, 'UKMK KM UII', 'ukmk-km-uii-pkm-6-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 6 TAHUN 2019 TENTANG UKMK KM UII.pdf', 'application/pdf', 342801, 1, '2026-11-07 22:51:37', 17, 4, '2026-11-07 22:51:39', '2026-11-14 13:32:26', 'aktif', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lembaga`
--

DROP TABLE IF EXISTS `lembaga`;
CREATE TABLE `lembaga` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `fakultas_id` bigint(20) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lembaga`
--

INSERT INTO `lembaga` (`id`, `nama`, `tingkat`, `jenis`, `fakultas_id`, `parent_id`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Lembaga Khusus Universitas', 'universitas', 'lembaga_khusus', NULL, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(2, 'DPM Universitas', 'universitas', 'dpm', NULL, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(3, 'LEM Universitas', 'universitas', 'lem', NULL, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(4, 'Mapala UII', 'universitas', 'lembaga_khusus', NULL, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(5, 'Himmah UII', 'universitas', 'lembaga_khusus', NULL, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(6, 'Marching Band UII', 'universitas', 'lembaga_khusus', NULL, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(7, 'KOPMA UII', 'universitas', 'kopma', NULL, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(14, 'LEM FBE', 'fakultas', 'lem', 11, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(15, 'LPM FBE', 'fakultas', 'lpm', 11, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(16, 'DPM FBE', 'fakultas', 'dpm', 11, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(8, 'LEM FH', 'fakultas', 'lem', 1, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(9, 'LPM FH', 'fakultas', 'lpm', 1, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(10, 'DPM FH', 'fakultas', 'dpm', 1, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(11, 'LEM FTI', 'fakultas', 'lem', 3, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(12, 'LPM FTI', 'fakultas', 'lpm', 3, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(13, 'DPM FTI', 'fakultas', 'dpm', 3, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(17, 'LEM FISB', 'fakultas', 'lem', 12, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(18, 'LPM FISB', 'fakultas', 'lpm', 12, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(19, 'DPM FISB', 'fakultas', 'dpm', 12, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(20, 'LEM FTSP', 'fakultas', 'lem', 6, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(21, 'LPM FTSP', 'fakultas', 'lpm', 6, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(22, 'DPM FTSP', 'fakultas', 'dpm', 6, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(23, 'LEM FMIPA', 'fakultas', 'lem', 8, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(24, 'LPM FMIPA', 'fakultas', 'lpm', 8, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(25, 'DPM FMIPA', 'fakultas', 'dpm', 8, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(26, 'LEM FPSI', 'fakultas', 'lem', 13, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(27, 'LPM FPSI', 'fakultas', 'lpm', 13, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(28, 'DPM FPSI', 'fakultas', 'dpm', 13, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(29, 'LEM FIAI', 'fakultas', 'lem', 5, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(30, 'LPM FIAI', 'fakultas', 'lpm', 5, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(31, 'DPM FIAI', 'fakultas', 'dpm', 5, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(32, 'LEM FK', 'fakultas', 'lem', 7, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(33, 'LPM FK', 'fakultas', 'lpm', 7, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(34, 'DPM FK', 'fakultas', 'dpm', 7, NULL, 1, '2026-11-17 08:45:00', '2026-11-17 08:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa_fakultas`
--

DROP TABLE IF EXISTS `mahasiswa_fakultas`;
CREATE TABLE `mahasiswa_fakultas` (
  `id` bigint(20) NOT NULL,
  `periode_id` bigint(20) NOT NULL,
  `fakultas_id` bigint(20) NOT NULL,
  `jumlah_mahasiswa` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa_fakultas`
--

INSERT INTO `mahasiswa_fakultas` (`id`, `periode_id`, `fakultas_id`, `jumlah_mahasiswa`, `created_at`, `updated_at`) VALUES
(1, 3, 11, 3441, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(2, 3, 1, 3408, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(3, 3, 3, 2843, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(4, 3, 12, 2213, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(5, 3, 6, 2055, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(6, 3, 8, 1464, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(7, 3, 13, 1334, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(8, 3, 5, 858, '2026-11-17 08:45:00', '2026-11-17 08:45:00'),
(9, 3, 7, 805, '2026-11-17 08:45:00', '2026-11-17 08:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `size` bigint(20) NOT NULL DEFAULT 0,
  `alt_text` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `name`, `file_path`, `mime_type`, `size`, `alt_text`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'BEBAS Bunny Snack Mascot Logo.png', 'uploads/2026/11/613d8af4-f0d2-4569-8127-e8a21a6c53d7.png', 'image/png', 1599277, NULL, 1, '2026-11-07 16:53:12', '2026-11-07 16:53:12'),
(2, 'IMG_1783.JPG', 'uploads/2026/11/57dac147-8160-4faf-94ed-60aca4b977ad.jpg', 'image/jpeg', 7306559, NULL, 1, '2026-11-10 22:18:50', '2026-11-10 22:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_10_29_100001_create_settings_table', 1),
(5, '2026_10_29_100002_create_pages_table', 1),
(6, '2026_10_29_100003_create_posts_table', 1),
(7, '2026_10_29_100004_create_media_table', 1),
(8, '2026_10_29_100005_create_periods_table', 1),
(9, '2026_10_29_100006_create_document_categories_table', 1),
(10, '2026_10_29_100007_create_documents_table', 1),
(11, '2026_10_29_100008_create_organizational_units_table', 1),
(12, '2026_10_29_100009_create_officials_table', 1),
(13, '2026_10_29_100010_create_complaints_table', 1),
(14, '2026_10_29_100011_create_menus_table', 1),
(15, '2026_10_29_100012_create_post_categories_table', 1),
(16, '2026_10_29_100013_create_legal_products_table', 1),
(17, '2026_10_29_110000_add_navigation_columns_to_content_tables', 1),
(18, '2026_10_29_120000_replace_wordpress_pages_with_fixed_sections', 1),
(19, '2026_10_29_130000_add_description_to_officials_table', 1),
(20, '2026_10_29_130418_add_student_id_and_faculty_to_complaints_table', 1),
(21, '2026_10_30_082435_add_mega_menu_fields_to_menu_items_table', 1),
(22, '2026_10_30_083033_add_mega_docs_to_menu_items_table', 1),
(23, '2026_10_30_105358_add_fields_to_organizational_units_table', 1),
(24, '2026_10_30_152001_add_parent_to_document_categories', 1),
(25, '2026_10_31_225453_add_period_id_to_site_contents_table', 1),
(26, '2026_10_31_230050_fix_site_contents_unique_constraint', 1),
(27, '2026_11_01_143401_add_fakultas_prodi_angkatan_to_officials_table', 1),
(28, '2026_11_02_031830_add_type_to_posts_table', 1),
(29, '2026_11_07_004401_add_status_to_legal_products_table', 2),
(30, '2026_11_07_010215_add_edition_to_legal_products_table', 3),
(31, '2026_11_07_152432_add_gbhkm_period_fields_to_legal_products_table', 4),
(32, '2026_11_07_165141_create_profil_dewans_table', 5),
(33, '2026_11_08_000001_create_fakultas_table', 6),
(34, '2026_11_08_000002_create_lembaga_table', 6),
(35, '2026_11_08_000003_create_komponen_dana_table', 6),
(36, '2026_11_08_000004_create_dana_triwulan_table', 6),
(37, '2026_11_08_000005_create_dana_komponen_table', 7),
(38, '2026_11_08_000006_create_alokasi_distribusi_table', 7),
(39, '2026_11_08_000007_create_alokasi_taktis_table', 7),
(40, '2026_11_08_000008_create_mahasiswa_fakultas_table', 7),
(41, '2026_11_08_000009_create_dana_info_table', 7),
(42, '2026_11_08_000010_create_dana_revisi_table', 7),
(43, '2026_11_08_000011_create_dokumen_keuangan_table', 7),
(44, '2026_11_08_000012_create_pengaturan_halaman_table', 7),
(45, '2026_11_08_000013_create_dana_seksi_table', 7),
(46, '2026_11_08_100000_create_pimpinan_dewan_table', 8),
(47, '2026_11_08_100001_create_pimpinan_tugas_table', 8),
(48, '2026_11_08_100002_drop_unused_tables', 9),
(49, '2026_11_07_224826_create_page_contents_table', 10),
(50, '2026_11_08_100003_add_signature_to_page_contents_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `officials`
--

DROP TABLE IF EXISTS `officials`;
CREATE TABLE `officials` (
  `id` bigint(20) NOT NULL,
  `organizational_unit_id` bigint(20) NOT NULL,
  `period_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `fakultas` varchar(255) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `angkatan` varchar(255) DEFAULT NULL,
  `nim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `officials`
--

INSERT INTO `officials` (`id`, `organizational_unit_id`, `period_id`, `name`, `position`, `photo_path`, `email`, `instagram`, `linkedin`, `sort_order`, `is_active`, `created_at`, `updated_at`, `description`, `fakultas`, `prodi`, `angkatan`, `nim`) VALUES
(1, 1, 3, 'Troy Amirul Akhmad', 'Ketua Umum', 'uploads/fungsionaris/pimpinan-dewan/32a65320-20aa-4fc8-aebe-3de4edf4f063.jpg', '23215075@students.uii.ac.id', 'https://www.instagram.com/dpmub/', 'https://www.instagram.com/dpp/', 1, 1, '2026-11-06 15:06:50', '2026-11-08 07:19:53', NULL, 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215075'),
(2, 2, 3, 'Dimas Andika Putra', 'Kepala MENTARI', NULL, NULL, NULL, NULL, 1, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2024', '24215039'),
(3, 2, 3, 'Siti Maghfira Lahinta', 'Koordinator Biro Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 2, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Psikologi', NULL, '2023', '23320242'),
(4, 2, 3, 'Ilham Juluborita', 'Staf Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 3, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2024', '24311094'),
(5, 2, 3, 'Fathya Adya Farahdiba', 'Staf Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 4, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Ilmu Sosial Budaya', NULL, '2025', '25323135'),
(6, 2, 3, 'Imawan Caesar Wahyudi', 'Staf Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 5, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Ilmu Sosial Budaya', NULL, '2024', '24321304'),
(7, 2, 3, 'Yanuar Farrel Yudistira', 'Kabiro Media dan Inventaris', NULL, NULL, NULL, NULL, 6, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2024', '24215016'),
(8, 2, 3, 'Nurul Ayu Afiah', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 7, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2025', '25215042'),
(9, 2, 3, 'Laras Fadhilatul Amaro', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 8, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2025', '25214152'),
(10, 2, 3, 'Najwa Fauziah Ismail', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 9, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Hukum', NULL, '2025', '25410044'),
(11, 2, 3, 'Muhammad Dzaky Abdurrahman', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 10, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2025', '25311205'),
(12, 1, 3, 'Asep Subagya', 'Sekretaris Jenderal', NULL, '23215044@students.uii.ac.id', NULL, NULL, 2, 1, '2026-11-08 07:05:17', '2026-11-08 07:05:17', NULL, 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215044'),
(13, 1, 3, 'Annisa Fidanta Shafir', 'Ketua Komisi', NULL, '23215020@students.uii.ac.id', NULL, NULL, 3, 1, '2026-11-08 07:05:29', '2026-11-08 07:05:29', NULL, 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215020'),
(14, 7, 3, 'M. Dhavin Ghulam Fahmi', 'Presiden Direktur', NULL, '24216008@students.uii.ac.id', NULL, NULL, 1, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PRESDIR', 'Bisnis dan Ekonomika', 'Analisis Keuangan', '2024', '24216008'),
(15, 7, 3, 'Hillnandesh Bunga Nurlailla', 'Manajer PSDM', NULL, '24311030@students.uii.ac.id', NULL, NULL, 2, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PSDM', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311030'),
(16, 7, 3, 'Reyra Vania Rohmanto', 'Staf Ahli Rekrutmen', NULL, '25320485@students.uii.ac.id', NULL, NULL, 3, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PSDM', 'Psikologi & Ilmu Sosial Budaya', 'Psikologi', '2025', '25320485'),
(17, 7, 3, 'Kirana Putri Haryadi', 'Staf Ahli Penilaian', NULL, '25320418@students.uii.ac.id', NULL, NULL, 4, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PSDM', 'Psikologi & Ilmu Sosial Budaya', 'Psikologi', '2025', '25320418'),
(18, 7, 3, 'M. Islam Reshani Fekran Nabi', 'Staf Ahli Pengembangan', NULL, '23410811@students.uii.ac.id', NULL, NULL, 5, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PSDM', 'Hukum', 'Hukum', '2023', '23410811'),
(19, 7, 3, 'Mercury Aisyaharani', 'Staf Ahli Fungsionaris', NULL, '24410667@students.uii.ac.id', NULL, NULL, 6, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PSDM', 'Hukum', 'Hukum', '2024', '24410667'),
(20, 7, 3, 'Rosalina Chaca Primadani', 'Manajer GAS', NULL, '25410714@students.uii.ac.id', NULL, NULL, 7, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'GAS', 'Hukum', 'Hukum', '2025', '25410714'),
(21, 7, 3, 'Zidan Prasetyo Surahman', 'Staf Ahli Warehousing Almamater dan Catering', NULL, '24311415@students.uii.ac.id', NULL, NULL, 8, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'GAS', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311415'),
(22, 7, 3, 'Muhammad Rafael Harjadinata', 'Staf Ahli Pengelolaan Aset', NULL, '24411100@students.uii.ac.id', NULL, NULL, 9, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'GAS', 'Hukum', 'Hukum Bisnis', '2024', '24411100'),
(23, 7, 3, 'Natasha Putri A Riyanto', 'Manajer PDP', NULL, '24410767@students.uii.ac.id', NULL, NULL, 10, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PDP', 'Hukum', 'Hukum', '2024', '24410767'),
(24, 7, 3, 'Adila Alifia', 'Staff Ahli Marketing Online & SAC', NULL, '24311020@students.uii.ac.id', NULL, NULL, 11, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PDP', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311020'),
(25, 7, 3, 'Muhammad Ziaul Haq', 'Staff Ahli Marketing Offline & Photoboot', NULL, '25523065@students.uii.ac.id', NULL, NULL, 12, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PDP', 'Teknologi Industri', 'Informatika', '2025', '25523065'),
(26, 7, 3, 'M Zaky Fathurrahman', 'Staf Ahli Publikasi (Pengembangan Website)', NULL, '24523172@students.uii.ac.id', NULL, NULL, 13, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'PDP', 'Teknologi Industri', 'Informatika', '2024', '24523172'),
(27, 7, 3, 'M. Ibnu Budianto', 'Manajer SAM', NULL, '24311422@students.uii.ac.id', NULL, NULL, 14, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'SAM', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311422'),
(28, 7, 3, 'Radanta Pradipa Putra Sutrisno', 'Staff CS Photobooth', NULL, '24411051@students.uii.ac.id', NULL, NULL, 15, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'SAM', 'Hukum', 'Hukum Bisnis', '2024', '24411051'),
(29, 7, 3, 'Baiq Alyssa Nur Oktavia', 'Staff Inventaris Photobooth', NULL, '25320177@students.uii.ac.id', NULL, NULL, 16, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'SAM', 'Psikologi & Ilmu Sosial Budaya', 'Psikologi', '2025', '25320177'),
(30, 7, 3, 'Sela Areza Utami', 'Manajer ADKEU', NULL, '24216013@students.uii.ac.id', NULL, NULL, 17, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'ADKEU', 'Bisnis dan Ekonomika', 'Analisis Keuangan', '2024', '24216013'),
(31, 7, 3, 'Nurmadina A. Baba', 'Staf Ahli Outflow', NULL, '25522223@students.uii.ac.id', NULL, NULL, 18, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'ADKEU', 'Teknologi Industri', 'Teknik Industri', '2025', '25522223'),
(32, 7, 3, 'M. Ridho Pasya', 'Staf Ahli Inflow', NULL, '24311529@students.uii.ac.id', NULL, NULL, 19, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'ADKEU', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311529'),
(33, 7, 3, 'Muhammad Farid', 'Staf Ahli Administrasi', NULL, '24523219@students.uii.ac.id', NULL, NULL, 20, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'ADKEU', 'Teknologi Industri', 'Informatika', '2024', '24523219'),
(34, 7, 3, 'Akbar Muntaqo', 'Staf Ahli Keuangan', NULL, '24215056@students.uii.ac.id', NULL, NULL, 21, 1, '2026-11-10 21:39:45', '2026-11-10 21:39:45', 'ADKEU', 'Bisnis dan Ekonomika', 'Akuntansi Perpajakan', '2024', '24215056');

-- --------------------------------------------------------

--
-- Table structure for table `organizational_units`
--

DROP TABLE IF EXISTS `organizational_units`;
CREATE TABLE `organizational_units` (
  `id` bigint(20) NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'badan',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `abbreviation` varchar(32) DEFAULT NULL,
  `tasks` longtext DEFAULT NULL,
  `work_programs` longtext DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizational_units`
--

INSERT INTO `organizational_units` (`id`, `parent_id`, `type`, `name`, `slug`, `description`, `logo_path`, `sort_order`, `is_active`, `created_at`, `updated_at`, `abbreviation`, `tasks`, `work_programs`, `email`) VALUES
(1, NULL, 'pimpinan', 'Pimpinan Dewan', 'pimpinan-dewan', NULL, NULL, 1, 1, '2026-11-02 04:29:53', '2026-11-02 04:29:53', NULL, NULL, NULL, NULL),
(2, NULL, 'lembaga', 'Mentari', 'mentari', NULL, NULL, 2, 1, '2026-11-02 04:29:55', '2026-11-02 04:29:55', 'Mentari', NULL, NULL, NULL),
(3, NULL, 'badan', 'Badan Legislasi', 'badan-legislasi', NULL, NULL, 3, 1, '2026-11-02 04:29:57', '2026-11-02 04:29:57', 'Baleg', NULL, NULL, NULL),
(4, NULL, 'badan', 'Badan Pengawasan', 'badan-pengawasan', NULL, NULL, 4, 1, '2026-11-02 04:29:59', '2026-11-02 04:29:59', 'Bawas', NULL, NULL, NULL),
(5, NULL, 'badan', 'Badan Kerjasama, Advokasi, dan Jaringan', 'badan-kerjasama-advokasi-dan-jaringan', NULL, NULL, 5, 1, '2026-11-02 04:30:02', '2026-11-02 04:30:02', 'Bksaj', NULL, NULL, NULL),
(6, NULL, 'badan', 'Badan Audit Kemahasiswaan', 'badan-audit-kemahasiswaan', NULL, NULL, 6, 1, '2026-11-02 04:30:04', '2026-11-02 04:30:04', 'BAK', NULL, NULL, NULL),
(7, NULL, 'badan', 'Badan Pengelola Aset', 'badan-pengelola-aset', NULL, NULL, 7, 1, '2026-11-02 04:30:06', '2026-11-02 04:30:06', 'BPA', NULL, NULL, NULL),
(12, NULL, 'komisi', 'Komisi I', 'komisi-i', 'Bidang Hukum, Peraturan, dan Ketertiban Dewan', NULL, 10, 1, '2026-11-07 20:56:56', '2026-11-07 20:56:56', 'I', NULL, NULL, NULL),
(13, NULL, 'komisi', 'Komisi II', 'komisi-ii', 'Bidang Anggaran, Keuangan, dan Aset Dewan', NULL, 11, 1, '2026-11-07 20:56:58', '2026-11-07 20:56:58', 'II', NULL, NULL, NULL),
(14, NULL, 'komisi', 'Komisi III', 'komisi-iii', 'Bidang Aspirasi, Kemitraan, dan Jaringan Dewan', NULL, 12, 1, '2026-11-07 20:57:01', '2026-11-07 20:57:01', 'III', NULL, NULL, NULL),
(15, NULL, 'komisi', 'Komisi IV', 'komisi-iv', 'Bidang SDM, Organisasi, dan Protokol Dewan', NULL, 13, 1, '2026-11-07 20:57:03', '2026-11-07 20:57:03', 'IV', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page_contents`
--

DROP TABLE IF EXISTS `page_contents`;
CREATE TABLE `page_contents` (
  `id` bigint(20) NOT NULL,
  `key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `signature_role` varchar(255) DEFAULT NULL,
  `signature_name` varchar(255) DEFAULT NULL,
  `signature_fakultas` varchar(255) DEFAULT NULL,
  `signature_nim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_contents`
--

INSERT INTO `page_contents` (`id`, `key`, `title`, `subtitle`, `body`, `created_at`, `updated_at`, `signature_role`, `signature_name`, `signature_fakultas`, `signature_nim`) VALUES
(1, 'sambutan', 'Sambutan', 'Sambutan Ketua DPM UII', '<p>Assalamu’alaikum warahmatullahi wabarakatuh.</p><p>Selamat datang di portal resmi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia.</p><p>Dewan Permusyawaratan Mahasiswa UII hadir sebagai lembaga legislatif tertinggi dalam sistem pemerintahan mahasiswa. Melalui fungsi legislasi, anggaran, dan pengawasan, kami berkomitmen memastikan setiap kebijakan Keluarga Mahasiswa UII berpijak pada aspirasi mahasiswa serta prinsip tata kelola yang terbuka dan akuntabel.</p><p>Portal ini kami sediakan sebagai ruang transparansi: produk hukum, laporan keuangan, dokumen resmi, hingga kanal aspirasi dapat diakses dengan mudah oleh seluruh mahasiswa. Kami mengajak seluruh civitas akademika untuk turut mengawal kerja-kerja dewan dan menyampaikan gagasan terbaiknya.</p><p>Terima kasih atas dukungan dan kepercayaan yang diberikan. Mari bersama membangun Keluarga Mahasiswa UII yang lebih baik.</p>', '2026-11-07 22:50:29', '2026-11-08 05:34:11', 'Ketua DPM UII', 'Troy', 'Fbe', '25311205'),
(2, 'sejarah', 'Sejarah KM UII', 'Tentang DPM UII', NULL, '2026-11-07 22:50:31', '2026-11-07 22:50:31', NULL, NULL, NULL, NULL),
(3, 'visi-misi', 'Visi Misi', 'Tentang DPM UII', NULL, '2026-11-07 22:50:32', '2026-11-07 22:50:32', NULL, NULL, NULL, NULL),
(4, 'struktur', 'Struktur', 'Tentang DPM UII', NULL, '2026-11-07 22:50:34', '2026-11-07 22:50:34', NULL, NULL, NULL, NULL),
(5, 'kedudukan-tugas-wewenang', 'Kedudukan, Tugas dan Wewenang', 'Tentang DPM UII', NULL, '2026-11-07 22:50:36', '2026-11-07 22:50:36', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_halaman`
--

DROP TABLE IF EXISTS `pengaturan_halaman`;
CREATE TABLE `pengaturan_halaman` (
  `id` bigint(20) NOT NULL,
  `halaman` varchar(40) NOT NULL,
  `kunci` varchar(60) NOT NULL,
  `nilai` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaturan_halaman`
--

INSERT INTO `pengaturan_halaman` (`id`, `halaman`, `kunci`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 'distribusi_dana', 'hero_deskripsi', 'Transparansi distribusi dana DPM UII periode 2025/2026.', '2026-11-07 19:47:15', '2026-11-07 19:47:15'),
(2, 'distribusi_dana', 'judul_overview', 'Ringkasan Dana', '2026-11-07 19:47:16', '2026-11-07 19:47:16'),
(3, 'distribusi_dana', 'catatan_sumber', 'Sumber: Sekretariat Jenderal DPM UII', '2026-11-07 19:47:18', '2026-11-07 19:47:18'),
(4, 'distribusi_dana', 'dasar_hukum', 'PDKM UII dan PDPM UII', '2026-11-07 19:47:20', '2026-11-07 19:47:20');

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

DROP TABLE IF EXISTS `periods`;
CREATE TABLE `periods` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `starts_on` date DEFAULT NULL,
  `ends_on` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `periods`
--

INSERT INTO `periods` (`id`, `name`, `starts_on`, `ends_on`, `is_active`, `created_at`, `updated_at`) VALUES
(3, '2025/2026', '2025-09-01', '2026-08-31', 1, '2026-11-02 04:29:20', '2026-11-10 21:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `pimpinan_dewan`
--

DROP TABLE IF EXISTS `pimpinan_dewan`;
CREATE TABLE `pimpinan_dewan` (
  `id` bigint(20) NOT NULL,
  `periode_id` bigint(20) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `fakultas` varchar(255) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `angkatan` varchar(255) DEFAULT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `foto_path` varchar(255) DEFAULT NULL,
  `sort_order` smallint(6) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pimpinan_dewan`
--

INSERT INTO `pimpinan_dewan` (`id`, `periode_id`, `jabatan`, `nama`, `fakultas`, `prodi`, `angkatan`, `nim`, `email`, `instagram`, `linkedin`, `foto_path`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 3, 'Ketua', 'Ketua DPM UII', 'Fakultas Hukum', NULL, NULL, '21000001', NULL, NULL, NULL, NULL, 1, 1, '2026-11-07 20:58:20', '2026-11-07 20:58:20'),
(2, 3, 'Sekretaris Jenderal', 'Sekretaris Jenderal DPM UII', 'Fakultas Ilmu Komunikasi', NULL, NULL, '21000002', NULL, NULL, NULL, NULL, 2, 1, '2026-11-07 20:58:21', '2026-11-07 20:58:21'),
(3, 3, 'Komisi 1', 'Ketua Komisi I', 'Fakultas Hukum', NULL, NULL, '21000003', NULL, NULL, NULL, NULL, 3, 1, '2026-11-07 20:58:23', '2026-11-07 20:58:23'),
(4, 3, 'Komisi 2', 'Ketua Komisi II', 'Fakultas Ekonomi', NULL, NULL, '21000004', NULL, NULL, NULL, NULL, 4, 1, '2026-11-07 20:58:24', '2026-11-07 20:58:24'),
(5, 3, 'Komisi 3', 'Ketua Komisi III', 'Fakultas Ilmu Sosial dan Politik', NULL, NULL, '21000005', NULL, NULL, NULL, NULL, 5, 1, '2026-11-07 20:58:26', '2026-11-07 20:58:26'),
(6, 3, 'Komisi 4', 'Ketua Komisi IV', 'Fakultas Teknik', NULL, NULL, '21000006', NULL, NULL, NULL, NULL, 6, 1, '2026-11-07 20:58:27', '2026-11-07 20:58:27'),
(7, 3, 'Anggota Komisi 1', 'Anggota Komisi I', 'Fakultas Hukum', NULL, NULL, '21000007', NULL, NULL, NULL, NULL, 7, 1, '2026-11-07 20:58:29', '2026-11-07 20:58:29'),
(8, 3, 'Anggota Komisi 2', 'Anggota Komisi II', 'Fakultas Ekonomi', NULL, NULL, '21000008', NULL, NULL, NULL, NULL, 8, 1, '2026-11-07 20:58:30', '2026-11-07 20:58:30'),
(9, 3, 'Anggota Komisi 3', 'Anggota Komisi III', 'Fakultas Ilmu Sosial dan Politik', NULL, NULL, '21000009', NULL, NULL, NULL, NULL, 9, 1, '2026-11-07 20:58:32', '2026-11-07 20:58:32'),
(10, 3, 'Anggota Komisi 4', 'Anggota Komisi IV', 'Fakultas Teknik', NULL, NULL, '21000010', NULL, NULL, NULL, NULL, 10, 1, '2026-11-07 20:58:33', '2026-11-07 20:58:33'),
(11, 3, 'Ketua Umum', 'Troy Amirul Akhmad', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215075', '23215075@students.uii.ac.id', NULL, NULL, NULL, 1, 1, '2026-11-08 07:05:07', '2026-11-10 21:39:45'),
(12, 3, 'Sekretaris Jenderal', 'Asep Subagya', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215044', '23215044@students.uii.ac.id', NULL, NULL, NULL, 2, 1, '2026-11-08 07:05:19', '2026-11-10 21:39:45'),
(13, 3, 'Ketua Komisi', 'Annisa Fidanta Shafir', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215020', '23215020@students.uii.ac.id', NULL, NULL, NULL, 3, 1, '2026-11-08 07:05:31', '2026-11-10 21:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `pimpinan_tugas`
--

DROP TABLE IF EXISTS `pimpinan_tugas`;
CREATE TABLE `pimpinan_tugas` (
  `id` bigint(20) NOT NULL,
  `pimpinan_dewan_id` bigint(20) NOT NULL,
  `tugas` longtext NOT NULL,
  `sort_order` smallint(6) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pimpinan_tugas`
--

INSERT INTO `pimpinan_tugas` (`id`, `pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 11, 'Memimpin dan mengoordinasikan seluruh pelaksanaan tugas serta fungsi DPM UII.', 1, '2026-11-08 07:05:09', '2026-11-08 07:05:09'),
(2, 11, 'Mengarahkan penyelenggaraan fungsi legislasi, anggaran, dan pengawasan DPM UII.', 2, '2026-11-08 07:05:10', '2026-11-08 07:05:10'),
(3, 11, 'Mewakili DPM UII dalam hubungan kelembagaan dengan LEM UII dan pihak terkait.', 3, '2026-11-08 07:05:11', '2026-11-08 07:05:11'),
(4, 11, 'Mengawasi pelaksanaan program kerja dan kinerja seluruh alat kelengkapan dewan.', 4, '2026-11-08 07:05:12', '2026-11-08 07:05:12'),
(5, 12, 'Mengelola administrasi kesekretariatan, agenda rapat, pencatatan, dan pengarsipan dokumen resmi DPM UII.', 1, '2026-11-08 07:05:21', '2026-11-08 07:05:21'),
(6, 12, 'Mengoordinasikan administrasi dan pelaporan hasil kerja seluruh alat kelengkapan dewan.', 2, '2026-11-08 07:05:22', '2026-11-08 07:05:22'),
(7, 12, 'Memastikan kelancaran komunikasi, koordinasi, dan dokumentasi antara pimpinan, komisi, serta unit kerja DPM UII.', 3, '2026-11-08 07:05:23', '2026-11-08 07:05:23'),
(8, 12, 'Menyampaikan hasil pelaksanaan administrasi dan kesekretariatan dalam forum resmi DPM UII.', 4, '2026-11-08 07:05:24', '2026-11-08 07:05:24'),
(9, 13, 'Memimpin dan mengoordinasikan pelaksanaan tugas serta program kerja komisi.', 1, '2026-11-08 07:05:33', '2026-11-08 07:05:33'),
(10, 13, 'Mengarahkan pembahasan kebijakan sesuai bidang komisi.', 2, '2026-11-08 07:05:34', '2026-11-08 07:05:34'),
(11, 13, 'Mengawasi pelaksanaan tugas anggota komisi serta memastikan tercapainya target kerja.', 3, '2026-11-08 07:05:35', '2026-11-08 07:05:35'),
(12, 13, 'Menyampaikan hasil kerja dan rekomendasi komisi dalam Sidang Pleno DPM UII.', 4, '2026-11-08 07:05:36', '2026-11-08 07:05:36');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` longtext DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'Type for Sosialisasi: peraturan, kebijakan, program, lain-lain',
  `category` varchar(255) NOT NULL DEFAULT 'berita' COMMENT 'berita | berita-kegiatan | pengumuman | sosialisasi',
  KEY `posts_category_index` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `body`, `status`, `published_at`, `featured_image`, `meta_title`, `meta_description`, `created_at`, `updated_at`, `type`) VALUES
(16, 'KM UII Melawan: Gelar Aksi Demonstrasi Damai \"Menggugat 2 Tahun Rezim Prabowo - Gibran\", Layangkan 7 Poin Tuntutan', 'km-uii-melawan-gelar-aksi-demonstrasi-damai-menggugat-2-tahun-rezim-prabowo-gibran-layangkan-7-poin-tuntutan', 'YOGYAKARTA, dpm.uii.ac.id - Keluarga Mahasiswa Universitas Islam Indonesia (KM UII) menggelar aksi demonstrasi damai pada Selasa (20/10). Aksi yang bertema \"Menggugat 2 Tahun Rezim Prabowo - Gibran\" ini merupakan bentuk pengawalan isu nasional serta wujud kepedulian mahasiswa UII dalam merawat demokrasi, keadilan sosial, dan hak asasi manusia di Indonesia.', '<p>YOGYAKARTA, dpm.uii.ac.id - Keluarga Mahasiswa Universitas Islam Indonesia (KM UII) menggelar aksi demonstrasi damai pada Selasa (20/10). Aksi yang bertema \"Menggugat 2 Tahun Rezim Prabowo - Gibran\" ini merupakan bentuk pengawalan isu nasional serta wujud kepedulian mahasiswa UII dalam merawat demokrasi, keadilan sosial, dan hak asasi manusia di Indonesia.</p><p>Sebelum aksi turun ke jalan ini dilaksanakan, KM UII telah menggelar konsolidasi matang pada hari-hari sebelumnya untuk merumuskan lembar pengkajian isu serta memetakan teknis di lapangan. Memasuki hari H pada Selasa (20/10), pergerakan massa aksi dimulai pada pukul 10.00 WIB dengan berangkat langsung dari Kampus Terpadu UII menuju titik kumpul berikutnya. Setelah seluruh rombongan berkumpul secara utuh di titik kumpul tersebut, massa aksi kemudian bergerak bersama menuju Kantor DPRD DIY untuk menyampaikan orasi aspirasi, hingga akhirnya mengakhiri pergerakannya secara terpusat di Titik Nol Kilometer Yogyakarta.</p><p>Seluruh rangkaian aksi berlangsung secara tertib dan damai dengan tetap mengedepankan asas perdamaian. Massa aksi yang terdiri dari perwakilan mahasiswa berbagai fakultas di lingkungan KM UII berkumpul menyuarakan aspirasi masyarakat secara kritis, tegas, namun tetap beretika.</p><p>Dalam aksi tersebut, KM UII secara resmi melayangkan 7 (tujuh) poin tuntutan utama kepada pemerintah:</p><p>1. Evaluasi Total Penanggulangan Karhutla dan Percepat Pemulihan Masyarakat Terdampak;</p><p>2. Moratorium, Evaluasi, dan Transparansi Program Strategis nasional terutama MBG dan KDMP;</p><p>3. Menuntut regulasi pengadaan, tata kelola dan transparansi BBM subsidi di setiap daerah di indonesia;</p><p>4. Menuntut perbaikan pola komunikasi pemerintah terutama komunikasi Presiden yang kerap merendahkan rakyat;</p><p>5. Restrukturisasi dan Perampingan Kabinet Gemuk demi Efisiensi Birokrasi dan Anggaran Negara;</p><p>6. Hentikan Militerisme dalam berbagai bentuk terutama pelibatan militer di ranah sipil;</p><p>7. Tegakkan proses peradilan HAM bagi 13 peristiwa pelanggaran HAM Berat masa lalu.</p><p>Melalui penyampaian aspirasi ini, DPM UII menegaskan komitmennya untuk terus mengawal isu-isu kerakyatan serta mendukung setiap ikhtiar penyampaian aspirasi mahasiswa yang dilakukan secara santun, beretika, dan berkeadilan.</p><p>(DPM UII)</p><p>Sabtu, 31 Oktober 2026</p>', 'published', '2026-10-31 00:00:00', 'https://dpm.uii.ac.id/uploads/2026/11/57dac147-8160-4faf-94ed-60aca4b977ad.jpg', 'demokrasi', NULL, '2026-11-10 22:19:31', '2026-11-10 22:20:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profil_dewans`
--

DROP TABLE IF EXISTS `profil_dewans`;
CREATE TABLE `profil_dewans` (
  `id` bigint(20) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `fakultas` varchar(255) DEFAULT NULL,
  `program_studi` varchar(255) DEFAULT NULL,
  `angkatan` varchar(255) DEFAULT NULL,
  `email_kampus` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL,
  `unit_kerja` varchar(255) DEFAULT NULL,
  `periode` varchar(255) NOT NULL,
  `masa_jabatan` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `bio` longtext DEFAULT NULL,
  `tugas_tanggung_jawab` longtext DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profil_dewans`
--

INSERT INTO `profil_dewans` (`id`, `nama_lengkap`, `nim`, `fakultas`, `program_studi`, `angkatan`, `email_kampus`, `jabatan`, `unit_kerja`, `periode`, `masa_jabatan`, `status`, `bio`, `tugas_tanggung_jawab`, `instagram`, `email`, `created_at`, `updated_at`) VALUES
(4, 'Fikri Maulana', '202023001', '', '', '', 'fikri@uii.ac.id', 'Ketua Umum', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 Juni 2024 - 31 Mei 2026', 'Selesai', 'Mengelola seluruh kegiatan DPM UII periode 2024/2025.', 'Mendorong berjalannya program-program DPM UII, melakukan koordinasi dengan seluruh unit kerja dan alat kelengkapan.', 'https://instagram.com/fikri.maulana', 'fikri@uii.ac.id', '2026-11-07 16:55:10', '2026-11-07 16:55:10'),
(5, 'Intan Permata', '202023002', '', '', '', 'intan@uii.ac.id', 'Sekretaris Jendral', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 Juni 2024 - 31 Mei 2026', 'Selesai', 'Mengatur administrasi dan sekretariat DPM UII periode 2024/2025.', 'Menyusun berita acara, mengurus surat menyurat DPM UII, serta menyelenggarakan rapat plenipoten.', 'https://instagram.com/intan.permata', 'intan@uii.ac.id', '2026-11-07 16:55:11', '2026-11-07 16:55:11'),
(6, 'Raka Wirawan', '202023003', 'Fakultas Teknologi Industri', 'Teknik Industri', '2023', 'raka@uii.ac.id', 'Ketua Komisi II', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 Juni 2024 - 31 Mei 2026', 'Selesai', 'MimpinKomisi II untuk memperbaiki tata tertib dan kerangka kerja komisi.', 'Mengarahkan anggota Komisi II, melakukan evaluasi kerja rutin, serta melaporkan hasil komisi pada sidang plenog.', 'https://instagram.com/raka.wirawan', 'raka@uii.ac.id', '2026-11-07 16:55:11', '2026-11-07 16:55:11'),
(7, 'Troy Amirul Akhmad', '23215075', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215075@students.uii.ac.id', 'Ketua Umum', 'Dewan Permusyawaratan Mahasiswa', '2025/2026', 'Belum terverifikasi', 'Aktif', NULL, 'Memimpin dan mengoordinasikan seluruh pelaksanaan tugas serta fungsi DPM UII.\nMengarahkan penyelenggaraan fungsi legislasi, anggaran, dan pengawasan DPM UII.\nMewakili DPM UII dalam hubungan kelembagaan dengan LEM UII dan pihak terkait.\nMengawasi pelaksanaan program kerja dan kinerja seluruh alat kelengkapan dewan.', NULL, '23215075@students.uii.ac.id', '2026-11-08 07:05:02', '2026-11-10 21:39:45'),
(8, 'Asep Subagya', '23215044', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215044@students.uii.ac.id', 'Sekretaris Jenderal', 'Dewan Permusyawaratan Mahasiswa', '2025/2026', 'Belum terverifikasi', 'Aktif', NULL, 'Mengelola administrasi kesekretariatan, agenda rapat, pencatatan, dan pengarsipan dokumen resmi DPM UII.\nMengoordinasikan administrasi dan pelaporan hasil kerja seluruh alat kelengkapan dewan.\nMemastikan kelancaran komunikasi, koordinasi, dan dokumentasi antara pimpinan, komisi, serta unit kerja DPM UII.\nMenyampaikan hasil pelaksanaan administrasi dan kesekretariatan dalam forum resmi DPM UII.', NULL, '23215044@students.uii.ac.id', '2026-11-08 07:05:14', '2026-11-10 21:39:45'),
(9, 'Annisa Fidanta Shafir', '23215020', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215020@students.uii.ac.id', 'Ketua Komisi', 'Dewan Permusyawaratan Mahasiswa', '2025/2026', 'Belum terverifikasi', 'Aktif', NULL, 'Memimpin dan mengoordinasikan pelaksanaan tugas serta program kerja komisi.\nMengarahkan pembahasan kebijakan sesuai bidang komisi.\nMengawasi pelaksanaan tugas anggota komisi serta memastikan tercapainya target kerja.\nMenyampaikan hasil kerja dan rekomendasi komisi dalam Sidang Pleno DPM UII.', NULL, '23215020@students.uii.ac.id', '2026-11-08 07:05:26', '2026-11-10 21:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` longtext DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'DPM UII', '2026-11-02 04:28:51', '2026-11-02 04:28:51'),
(2, 'site_tagline', 'Dewan Permusyawaratan Mahasiswa UII', '2026-11-02 04:28:53', '2026-11-02 04:28:53'),
(3, 'site_logo', NULL, '2026-11-02 04:28:55', '2026-11-02 04:28:55'),
(4, 'hero_title', 'Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia', '2026-11-02 04:28:56', '2026-11-02 04:28:56'),
(5, 'hero_subtitle', 'Lembaga legislatif tertinggi dalam sistem student government KM UII: menyusun produk hukum, mengawasi jalannya pemerintahan mahasiswa, dan menyalurkan aspirasi mahasiswa.', '2026-11-02 04:28:58', '2026-11-02 04:28:58'),
(6, 'hero_image', NULL, '2026-11-02 04:28:59', '2026-11-02 04:28:59'),
(7, 'about_text', 'Keluarga Mahasiswa Universitas Islam Indonesia (KM UII) berdiri pada 21 September 1950 dengan ciri khas “student government”: pemerintahan dari, oleh, dan untuk mahasiswa. DPM UII menjalankan fungsi legislasi, pengawasan, dan penganggaran dalam sistem tersebut.', '2026-11-02 04:29:01', '2026-11-02 04:29:01'),
(8, 'contact_email', 'dpm@uii.ac.id', '2026-11-02 04:29:02', '2026-11-02 04:29:02'),
(9, 'contact_phone', '0815 1109 2004', '2026-11-02 04:29:04', '2026-11-02 04:29:04'),
(10, 'contact_address', 'Kampus Terpadu UII, Jl. Kaliurang KM 14.5, Sleman, Yogyakarta', '2026-11-02 04:29:05', '2026-11-02 04:29:05'),
(11, 'footer_text', 'Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia.', '2026-11-02 04:29:07', '2026-11-02 04:29:07'),
(12, 'social_instagram', 'https://www.instagram.com/dpmuii/', '2026-11-02 04:29:08', '2026-11-02 04:29:08'),
(13, 'social_linkedin', 'https://www.linkedin.com/company/dewan-permusyawaratan-mahasiswa/', '2026-11-02 04:29:10', '2026-11-02 04:29:10'),
(14, 'social_twitter', 'https://twitter.com/DPM_UII', '2026-11-02 04:29:11', '2026-11-02 04:29:11'),
(15, 'social_facebook', NULL, '2026-11-02 04:29:13', '2026-11-02 04:29:13'),
(16, 'social_youtube', NULL, '2026-11-02 04:29:14', '2026-11-02 04:29:14'),
(17, 'meta_description', 'Portal resmi DPM UII — produk hukum, surat keputusan, laporan keuangan triwulan, laporan kinerja, dan berita terbaru.', '2026-11-02 04:29:15', '2026-11-02 04:29:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@dpm.uii.ac.id', '2026-11-02 04:28:49', '$2y$12$rT.97tm1v1i5Gd8jBtqFQ.Qxu59FFtiT88c6E5pc3NJnJPyo.yjTK', '0bZQRLuUHBvkbiJJQghqoUvTGOTJ7FosmAfp32QKJ5KgDwWF12nLfJy55BkQ', '2026-11-02 04:28:50', '2026-11-02 07:42:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alokasi_distribusi`
--
ALTER TABLE `alokasi_distribusi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alokasi_distribusi_dana_triwulan_id_lembaga_id_unique` (`dana_triwulan_id`,`lembaga_id`),
  ADD KEY `alokasi_distribusi_lembaga_id_foreign` (`lembaga_id`);

--
-- Indexes for table `alokasi_taktis`
--
ALTER TABLE `alokasi_taktis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alokasi_taktis_dana_triwulan_id_fakultas_id_unique` (`dana_triwulan_id`,`fakultas_id`),
  ADD KEY `alokasi_taktis_fakultas_id_foreign` (`fakultas_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `complaints_ticket_number_unique` (`ticket_number`),
  ADD KEY `complaints_status_created_at_index` (`status`,`created_at`);

--
-- Indexes for table `dana_info`
--
ALTER TABLE `dana_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dana_info_dana_triwulan_id_seksi_unique` (`dana_triwulan_id`,`seksi`);

--
-- Indexes for table `dana_komponen`
--
ALTER TABLE `dana_komponen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dana_komponen_dana_triwulan_id_komponen_id_unique` (`dana_triwulan_id`,`komponen_id`),
  ADD KEY `dana_komponen_komponen_id_foreign` (`komponen_id`);

--
-- Indexes for table `dana_revisi`
--
ALTER TABLE `dana_revisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dana_revisi_dana_triwulan_id_foreign` (`dana_triwulan_id`),
  ADD KEY `dana_revisi_diubah_oleh_foreign` (`diubah_oleh`);

--
-- Indexes for table `dana_seksi`
--
ALTER TABLE `dana_seksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dana_seksi_dana_triwulan_id_seksi_unique` (`dana_triwulan_id`,`seksi`);

--
-- Indexes for table `dana_triwulan`
--
ALTER TABLE `dana_triwulan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dana_triwulan_periode_id_triwulan_unique` (`periode_id`,`triwulan`),
  ADD KEY `dana_triwulan_diterbitkan_oleh_foreign` (`diterbitkan_oleh`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documents_slug_unique` (`slug`),
  ADD KEY `documents_document_category_id_year_quarter_index` (`document_category_id`,`year`,`quarter`),
  ADD KEY `documents_period_id_foreign` (`period_id`);

--
-- Indexes for table `document_categories`
--
ALTER TABLE `document_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document_categories_slug_unique` (`slug`),
  ADD KEY `document_categories_group_index` (`group`),
  ADD KEY `document_categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `dokumen_keuangan`
--
ALTER TABLE `dokumen_keuangan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dokumen_keuangan_jenis_periode_id_lembaga_id_semester_unique` (`jenis`,`periode_id`,`lembaga_id`,`semester`),
  ADD KEY `dokumen_keuangan_lembaga_id_foreign` (`lembaga_id`),
  ADD KEY `dokumen_keuangan_periode_id_foreign` (`periode_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fakultas_kode_unique` (`kode`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komponen_dana`
--
ALTER TABLE `komponen_dana`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `komponen_dana_kode_unique` (`kode`);

--
-- Indexes for table `legal_products`
--
ALTER TABLE `legal_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `legal_products_slug_unique` (`slug`),
  ADD KEY `legal_products_type_index` (`type`),
  ADD KEY `legal_products_type_year_number_index` (`type`,`year`,`number`),
  ADD KEY `legal_products_amends_id_foreign` (`amends_id`),
  ADD KEY `legal_products_period_id_foreign` (`period_id`);

--
-- Indexes for table `lembaga`
--
ALTER TABLE `lembaga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lembaga_fakultas_id_foreign` (`fakultas_id`),
  ADD KEY `lembaga_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `mahasiswa_fakultas`
--
ALTER TABLE `mahasiswa_fakultas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mahasiswa_fakultas_periode_id_fakultas_id_unique` (`periode_id`,`fakultas_id`),
  ADD KEY `mahasiswa_fakultas_fakultas_id_foreign` (`fakultas_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_file_path_unique` (`file_path`),
  ADD KEY `media_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officials`
--
ALTER TABLE `officials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `officials_organizational_unit_id_foreign` (`organizational_unit_id`),
  ADD KEY `officials_period_id_foreign` (`period_id`);

--
-- Indexes for table `organizational_units`
--
ALTER TABLE `organizational_units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `organizational_units_slug_unique` (`slug`),
  ADD KEY `organizational_units_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `page_contents`
--
ALTER TABLE `page_contents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_contents_key_unique` (`key`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengaturan_halaman`
--
ALTER TABLE `pengaturan_halaman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengaturan_halaman_halaman_kunci_unique` (`halaman`,`kunci`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pimpinan_dewan`
--
ALTER TABLE `pimpinan_dewan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pimpinan_dewan_jabatan_index` (`jabatan`),
  ADD KEY `pimpinan_dewan_periode_id_is_active_index` (`periode_id`,`is_active`);

--
-- Indexes for table `pimpinan_tugas`
--
ALTER TABLE `pimpinan_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pimpinan_tugas_pimpinan_dewan_id_index` (`pimpinan_dewan_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `profil_dewans`
--
ALTER TABLE `profil_dewans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`),
  ADD KEY `sessions_user_id_index` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alokasi_distribusi`
--
ALTER TABLE `alokasi_distribusi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `alokasi_taktis`
--
ALTER TABLE `alokasi_taktis`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dana_info`
--
ALTER TABLE `dana_info`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dana_komponen`
--
ALTER TABLE `dana_komponen`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dana_revisi`
--
ALTER TABLE `dana_revisi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dana_seksi`
--
ALTER TABLE `dana_seksi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `dana_triwulan`
--
ALTER TABLE `dana_triwulan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `document_categories`
--
ALTER TABLE `document_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dokumen_keuangan`
--
ALTER TABLE `dokumen_keuangan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komponen_dana`
--
ALTER TABLE `komponen_dana`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `legal_products`
--
ALTER TABLE `legal_products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `lembaga`
--
ALTER TABLE `lembaga`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mahasiswa_fakultas`
--
ALTER TABLE `mahasiswa_fakultas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `organizational_units`
--
ALTER TABLE `organizational_units`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `page_contents`
--
ALTER TABLE `page_contents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengaturan_halaman`
--
ALTER TABLE `pengaturan_halaman`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pimpinan_dewan`
--
ALTER TABLE `pimpinan_dewan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pimpinan_tugas`
--
ALTER TABLE `pimpinan_tugas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `profil_dewans`
--
ALTER TABLE `profil_dewans`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alokasi_distribusi`
--
ALTER TABLE `alokasi_distribusi`
  ADD CONSTRAINT `alokasi_distribusi_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alokasi_distribusi_lembaga_id_foreign` FOREIGN KEY (`lembaga_id`) REFERENCES `lembaga` (`id`);

--
-- Constraints for table `alokasi_taktis`
--
ALTER TABLE `alokasi_taktis`
  ADD CONSTRAINT `alokasi_taktis_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alokasi_taktis_fakultas_id_foreign` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dana_info`
--
ALTER TABLE `dana_info`
  ADD CONSTRAINT `dana_info_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dana_komponen`
--
ALTER TABLE `dana_komponen`
  ADD CONSTRAINT `dana_komponen_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dana_komponen_komponen_id_foreign` FOREIGN KEY (`komponen_id`) REFERENCES `komponen_dana` (`id`);

--
-- Constraints for table `dana_revisi`
--
ALTER TABLE `dana_revisi`
  ADD CONSTRAINT `dana_revisi_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dana_revisi_diubah_oleh_foreign` FOREIGN KEY (`diubah_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dana_seksi`
--
ALTER TABLE `dana_seksi`
  ADD CONSTRAINT `dana_seksi_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dana_triwulan`
--
ALTER TABLE `dana_triwulan`
  ADD CONSTRAINT `dana_triwulan_diterbitkan_oleh_foreign` FOREIGN KEY (`diterbitkan_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `dana_triwulan_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periods` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_document_category_id_foreign` FOREIGN KEY (`document_category_id`) REFERENCES `document_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `document_categories`
--
ALTER TABLE `document_categories`
  ADD CONSTRAINT `document_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `document_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `dokumen_keuangan`
--
ALTER TABLE `dokumen_keuangan`
  ADD CONSTRAINT `dokumen_keuangan_lembaga_id_foreign` FOREIGN KEY (`lembaga_id`) REFERENCES `lembaga` (`id`),
  ADD CONSTRAINT `dokumen_keuangan_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periods` (`id`);

--
-- Constraints for table `legal_products`
--
ALTER TABLE `legal_products`
  ADD CONSTRAINT `legal_products_amends_id_foreign` FOREIGN KEY (`amends_id`) REFERENCES `legal_products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `legal_products_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `lembaga`
--
ALTER TABLE `lembaga`
  ADD CONSTRAINT `lembaga_fakultas_id_foreign` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lembaga_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `lembaga` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `mahasiswa_fakultas`
--
ALTER TABLE `mahasiswa_fakultas`
  ADD CONSTRAINT `mahasiswa_fakultas_fakultas_id_foreign` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`),
  ADD CONSTRAINT `mahasiswa_fakultas_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periods` (`id`);

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `officials`
--
ALTER TABLE `officials`
  ADD CONSTRAINT `officials_organizational_unit_id_foreign` FOREIGN KEY (`organizational_unit_id`) REFERENCES `organizational_units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `officials_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `organizational_units`
--
ALTER TABLE `organizational_units`
  ADD CONSTRAINT `organizational_units_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `organizational_units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pimpinan_dewan`
--
ALTER TABLE `pimpinan_dewan`
  ADD CONSTRAINT `pimpinan_dewan_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pimpinan_tugas`
--
ALTER TABLE `pimpinan_tugas`
  ADD CONSTRAINT `pimpinan_tugas_pimpinan_dewan_id_foreign` FOREIGN KEY (`pimpinan_dewan_id`) REFERENCES `pimpinan_dewan` (`id`) ON DELETE CASCADE;

-- ============================================================
-- TAMBAHAN DATA (periode lampau + BAK 2025/2026)
-- Data asli di atas dipertahankan; blok ini hanya menambah/melengkapi.
-- 3 baris profil_dewans contoh (Fikri Maulana, Intan Permata, Raka
-- Wirawan) dihapus karena bukan data resmi.
-- ============================================================

-- Kategori konten untuk post yang sudah ada.
UPDATE `posts` SET `category` = 'berita-kegiatan' WHERE `category` = 'berita';

-- Deskripsi singkat alat kelengkapan (kartu Beranda & hero halaman unit).
UPDATE `organizational_units` SET `description` = 'Media dan Kesekretariatan' WHERE `slug` = 'mentari' AND (`description` IS NULL OR `description` = '');
UPDATE `organizational_units` SET `description` = 'Badan Legislasi' WHERE `slug` = 'badan-legislasi' AND (`description` IS NULL OR `description` = '');
UPDATE `organizational_units` SET `description` = 'Badan Pengawasan' WHERE `slug` = 'badan-pengawasan' AND (`description` IS NULL OR `description` = '');
UPDATE `organizational_units` SET `description` = 'Badan Kerjasama, Advokasi, dan Jaringan' WHERE `slug` = 'badan-kerjasama-advokasi-dan-jaringan' AND (`description` IS NULL OR `description` = '');
UPDATE `organizational_units` SET `description` = 'Badan Audit Kemahasiswaan' WHERE `slug` = 'badan-audit-kemahasiswaan' AND (`description` IS NULL OR `description` = '');
UPDATE `organizational_units` SET `description` = 'Badan Pengelola Aset' WHERE `slug` = 'badan-pengelola-aset' AND (`description` IS NULL OR `description` = '');
UPDATE `organizational_units` SET `description` = 'Pimpinan Dewan' WHERE `slug` = 'pimpinan-dewan' AND (`description` IS NULL OR `description` = '');

-- Periode kepengurusan yang belum ada.
INSERT INTO `periods` (`id`, `name`, `starts_on`, `ends_on`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2023/2024', '2023-09-01', '2024-08-31', 0, NOW(), NOW()),
(2, '2024/2025', '2024-09-01', '2025-08-31', 0, NOW(), NOW());

-- Anggota alat kelengkapan periode lampau + BAK 2025/2026.
INSERT INTO `officials` (`id`, `organizational_unit_id`, `period_id`, `name`, `position`, `photo_path`, `email`, `instagram`, `linkedin`, `sort_order`, `is_active`, `created_at`, `updated_at`, `description`, `fakultas`, `prodi`, `angkatan`, `nim`) VALUES
(35, 6, 3, 'M Rosyid Perdana', 'Ketua', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24312167'),
(36, 6, 3, 'Winda Tsani Meisarohmah', 'Sekretaris', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24216002'),
(37, 6, 3, 'Shafina Alya', 'Sekretaris', NULL, NULL, NULL, NULL, 3, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24215058'),
(38, 6, 3, 'Mohammad Azzam Athallah', 'Kabiro Audit', NULL, NULL, NULL, NULL, 4, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24311276'),
(39, 6, 3, 'Nimala Amy Safira', 'Wakabiro Audit', NULL, NULL, NULL, NULL, 5, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24312135'),
(40, 6, 3, 'Rafif Irhab Rajendra', 'Staff Audit', NULL, NULL, NULL, NULL, 6, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24311350'),
(41, 6, 3, 'Leti Ellyani', 'Kabiro Konsultan Keuangan', NULL, NULL, NULL, NULL, 7, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24311373'),
(42, 6, 3, 'Axa Yusaima', 'Wakabiro Konsultan Keuangan', NULL, NULL, NULL, NULL, 8, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24311418'),
(43, 6, 3, 'Sigit Danna Kurniawan', 'Staff Konsultan Keuangan', NULL, NULL, NULL, NULL, 9, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24215009'),
(44, 6, 3, 'Excella Putri', 'Staff Konsultan Keuangan', NULL, NULL, NULL, NULL, 10, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, '24311419'),
(45, 1, 1, 'M Rafsan Jzani', 'Ketua Umum', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(46, 1, 1, 'Nanda Revi Saputri', 'Sekretaris Jenderal', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(47, 12, 1, 'Potrika Janno Vitanka', 'Ketua Komisi I', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(48, 12, 1, 'Muhammad Rafly Aryasatya', 'Anggota Komisi I', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(49, 12, 1, 'Rafli Jaisy Muhammad', 'Anggota Komisi I', NULL, NULL, NULL, NULL, 3, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(50, 13, 1, 'M. Raihan Alfarizy', 'Ketua Komisi II', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(51, 13, 1, 'Ghiyats Fahim Abdulkarim', 'Anggota Komisi II', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(52, 13, 1, 'Anis Banowati', 'Anggota Komisi II', NULL, NULL, NULL, NULL, 3, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(53, 14, 1, 'Syifa Aldora Cahyaimani', 'Ketua Komisi III', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(54, 14, 1, 'Nur Biyantara Efendi', 'Anggota Komisi III', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(55, 14, 1, 'Muhammad Nawawi', 'Anggota Komisi III', NULL, NULL, NULL, NULL, 3, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(56, 1, 2, 'Cipta Aditya Pratama Kolopita', 'Ketua Umum', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(57, 1, 2, 'Nawad Jamunnasyath Karobbi', 'Sekretaris Jenderal', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(58, 12, 2, 'Shendy Pratama', 'Ketua Komisi I', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(59, 12, 2, 'Raka Aditya Faslah', 'Anggota Komisi I', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(60, 12, 2, 'Ayutias Aulia Rahman', 'Anggota Komisi I', NULL, NULL, NULL, NULL, 3, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(61, 13, 2, 'Andi Arya Tri Buana Agung', 'Ketua Komisi II', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(62, 13, 2, 'Amy Dwi Kurnia', 'Anggota Komisi II', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(63, 13, 2, 'Pasha Aulia Amanah', 'Anggota Komisi II', NULL, NULL, NULL, NULL, 3, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(64, 14, 2, 'Fatharani Raihan Firdaus', 'Ketua Komisi III', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(65, 14, 2, 'Audyo Turi Mesa', 'Anggota Komisi III', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL),
(66, 14, 2, 'Maryam Faizah Rosyadi', 'Anggota Komisi III', NULL, NULL, NULL, NULL, 3, 1, NOW(), NOW(), NULL, NULL, NULL, NULL, NULL);

-- Hapus 3 profil dewan contoh periode 2024/2025, ganti data resmi.
DELETE FROM `profil_dewans` WHERE `id` IN (4, 5, 6);

-- Profil dewan 2023/2024 dan 2024/2025 (halaman /profil-dewan).
INSERT INTO `profil_dewans` (`id`, `nama_lengkap`, `nim`, `fakultas`, `program_studi`, `angkatan`, `email_kampus`, `jabatan`, `unit_kerja`, `periode`, `masa_jabatan`, `status`, `bio`, `tugas_tanggung_jawab`, `instagram`, `email`, `created_at`, `updated_at`) VALUES
(10, 'M Rafsan Jzani', NULL, NULL, NULL, NULL, NULL, 'Ketua Umum', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(11, 'Nanda Revi Saputri', NULL, NULL, NULL, NULL, NULL, 'Sekretaris Jenderal', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(12, 'Potrika Janno Vitanka', NULL, NULL, NULL, NULL, NULL, 'Ketua Komisi I', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(13, 'Muhammad Rafly Aryasatya', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi I', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(14, 'Rafli Jaisy Muhammad', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi I', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(15, 'M. Raihan Alfarizy', NULL, NULL, NULL, NULL, NULL, 'Ketua Komisi II', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(16, 'Ghiyats Fahim Abdulkarim', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi II', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(17, 'Anis Banowati', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi II', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(18, 'Syifa Aldora Cahyaimani', NULL, NULL, NULL, NULL, NULL, 'Ketua Komisi III', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(19, 'Nur Biyantara Efendi', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi III', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(20, 'Muhammad Nawawi', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi III', 'Dewan Permusyawaratan Mahasiswa', '2023/2024', '1 September 2023 - 31 Agustus 2024', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(21, 'Cipta Aditya Pratama Kolopita', NULL, NULL, NULL, NULL, NULL, 'Ketua Umum', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(22, 'Nawad Jamunnasyath Karobbi', NULL, NULL, NULL, NULL, NULL, 'Sekretaris Jenderal', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(23, 'Shendy Pratama', NULL, NULL, NULL, NULL, NULL, 'Ketua Komisi I', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(24, 'Raka Aditya Faslah', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi I', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(25, 'Ayutias Aulia Rahman', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi I', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(26, 'Andi Arya Tri Buana Agung', NULL, NULL, NULL, NULL, NULL, 'Ketua Komisi II', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(27, 'Amy Dwi Kurnia', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi II', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(28, 'Pasha Aulia Amanah', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi II', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(29, 'Fatharani Raihan Firdaus', NULL, NULL, NULL, NULL, NULL, 'Ketua Komisi III', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(30, 'Audyo Turi Mesa', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi III', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW()),
(31, 'Maryam Faizah Rosyadi', NULL, NULL, NULL, NULL, NULL, 'Anggota Komisi III', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 September 2024 - 31 Agustus 2025', 'Selesai', NULL, NULL, NULL, NULL, NOW(), NOW());

-- Catat migrasi baru agar `php artisan migrate` tidak mengulang.
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(51, '2026_11_10_000001_add_category_to_posts_table', 12),
(52, '2026_11_10_000002_fill_organizational_unit_descriptions', 12);

ALTER TABLE `officials` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
ALTER TABLE `profil_dewans` MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
ALTER TABLE `migrations` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(53, '2026_11_17_013216_make_complaints_email_nullable', 13);
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
