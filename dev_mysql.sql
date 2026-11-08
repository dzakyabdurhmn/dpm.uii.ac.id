-- DPM UII — dump MySQL (hasil konversi dari PostgreSQL)
-- Dibuat: 2026-11-08 07:46:28

SET NAMES utf8mb4;
SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET FOREIGN_KEY_CHECKS=0;

-- ------------------------------------------------------------
-- Struktur tabel
-- ------------------------------------------------------------

DROP TABLE IF EXISTS `alokasi_distribusi`;
CREATE TABLE `alokasi_distribusi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `dana_triwulan_id` bigint NOT NULL,
  `lembaga_id` bigint NOT NULL,
  `jumlah` bigint NOT NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `alokasi_distribusi_dana_triwulan_id_lembaga_id_unique` (`dana_triwulan_id`, `lembaga_id`),
  PRIMARY KEY (`id`),
  CONSTRAINT `alokasi_distribusi_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `alokasi_distribusi_lembaga_id_foreign` FOREIGN KEY (`lembaga_id`) REFERENCES `lembaga` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `alokasi_taktis`;
CREATE TABLE `alokasi_taktis` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `dana_triwulan_id` bigint NOT NULL,
  `fakultas_id` bigint NULL,
  `jumlah` bigint NOT NULL,
  `keterangan` varchar(255) NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `alokasi_taktis_dana_triwulan_id_fakultas_id_unique` (`dana_triwulan_id`, `fakultas_id`),
  PRIMARY KEY (`id`),
  CONSTRAINT `alokasi_taktis_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `alokasi_taktis_fakultas_id_foreign` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` longtext NOT NULL,
  `expiration` bigint NOT NULL,
  KEY `cache_expiration_index` (`expiration`),
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint NOT NULL,
  KEY `cache_locks_expiration_index` (`expiration`),
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE `complaints` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(255) NOT NULL,
  `name` varchar(255) NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(30) NULL,
  `category` varchar(255) NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `attachment_path` varchar(255) NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'baru',
  `response` longtext NULL,
  `responded_at` datetime NULL,
  `ip_address` varchar(45) NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  `student_id` varchar(20) NULL,
  `faculty` varchar(100) NULL,
  PRIMARY KEY (`id`),
  KEY `complaints_status_created_at_index` (`status`, `created_at`),
  UNIQUE KEY `complaints_ticket_number_unique` (`ticket_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dana_info`;
CREATE TABLE `dana_info` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `dana_triwulan_id` bigint NOT NULL,
  `seksi` varchar(255) NOT NULL,
  `teks` longtext NOT NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `dana_info_dana_triwulan_id_seksi_unique` (`dana_triwulan_id`, `seksi`),
  PRIMARY KEY (`id`),
  CONSTRAINT `dana_info_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dana_komponen`;
CREATE TABLE `dana_komponen` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `dana_triwulan_id` bigint NOT NULL,
  `komponen_id` bigint NOT NULL,
  `jumlah` bigint NOT NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `dana_komponen_dana_triwulan_id_komponen_id_unique` (`dana_triwulan_id`, `komponen_id`),
  PRIMARY KEY (`id`),
  CONSTRAINT `dana_komponen_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dana_komponen_komponen_id_foreign` FOREIGN KEY (`komponen_id`) REFERENCES `komponen_dana` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dana_revisi`;
CREATE TABLE `dana_revisi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `dana_triwulan_id` bigint NOT NULL,
  `diubah_oleh` bigint NULL,
  `alasan` longtext NOT NULL,
  `snapshot` json NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `dana_revisi_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dana_revisi_diubah_oleh_foreign` FOREIGN KEY (`diubah_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dana_seksi`;
CREATE TABLE `dana_seksi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `dana_triwulan_id` bigint NOT NULL,
  `seksi` varchar(255) NOT NULL,
  `urutan` smallint NOT NULL DEFAULT '0',
  `is_tampil` tinyint(1) NOT NULL DEFAULT 1,
  `judul` varchar(120) NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `dana_seksi_dana_triwulan_id_seksi_unique` (`dana_triwulan_id`, `seksi`),
  PRIMARY KEY (`id`),
  CONSTRAINT `dana_seksi_dana_triwulan_id_foreign` FOREIGN KEY (`dana_triwulan_id`) REFERENCES `dana_triwulan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dana_triwulan`;
CREATE TABLE `dana_triwulan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `periode_id` bigint NOT NULL,
  `triwulan` smallint NOT NULL,
  `total_dana` bigint NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `diterbitkan_pada` datetime NULL,
  `diterbitkan_oleh` bigint NULL,
  `sumber_url` varchar(255) NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `dana_triwulan_periode_id_triwulan_unique` (`periode_id`, `triwulan`),
  PRIMARY KEY (`id`),
  CONSTRAINT `dana_triwulan_diterbitkan_oleh_foreign` FOREIGN KEY (`diterbitkan_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `dana_triwulan_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `document_categories`;
CREATE TABLE `document_categories` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  `group` varchar(255) NULL,
  `parent_id` bigint NULL,
  `type` varchar(255) NOT NULL DEFAULT 'main',
  KEY `document_categories_group_index` (`group`),
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_categories_slug_unique` (`slug`),
  CONSTRAINT `document_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `document_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `document_category_id` bigint NOT NULL,
  `period_id` bigint NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NULL,
  `file_path` varchar(255) NULL,
  `external_url` varchar(2048) NULL,
  `mime_type` varchar(255) NULL,
  `size` bigint NOT NULL DEFAULT '0',
  `year` smallint NULL,
  `quarter` smallint NULL,
  `published_at` datetime NULL,
  `downloads` bigint NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int NOT NULL DEFAULT 0,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  KEY `documents_document_category_id_year_quarter_index` (`document_category_id`, `year`, `quarter`),
  PRIMARY KEY (`id`),
  UNIQUE KEY `documents_slug_unique` (`slug`),
  CONSTRAINT `documents_document_category_id_foreign` FOREIGN KEY (`document_category_id`) REFERENCES `document_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `documents_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `dokumen_keuangan`;
CREATE TABLE `dokumen_keuangan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `jenis` varchar(255) NOT NULL,
  `periode_id` bigint NOT NULL,
  `lembaga_id` bigint NOT NULL,
  `semester` varchar(255) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `tanggal` date NOT NULL,
  `file_path` varchar(255) NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `dokumen_keuangan_jenis_periode_id_lembaga_id_semester_unique` (`jenis`, `periode_id`, `lembaga_id`, `semester`),
  PRIMARY KEY (`id`),
  CONSTRAINT `dokumen_keuangan_lembaga_id_foreign` FOREIGN KEY (`lembaga_id`) REFERENCES `lembaga` (`id`),
  CONSTRAINT `dokumen_keuangan_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`, `queue`, `failed_at`),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `fakultas`;
CREATE TABLE `fakultas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(120) NOT NULL,
  `urutan` smallint NOT NULL DEFAULT '0',
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `fakultas_kode_unique` (`kode`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` longtext NULL,
  `cancelled_at` int NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint NOT NULL,
  `reserved_at` int NULL,
  `available_at` int NOT NULL,
  `created_at` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `komponen_dana`;
CREATE TABLE `komponen_dana` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `urutan` smallint NOT NULL DEFAULT '0',
  `is_tampil` tinyint(1) NOT NULL DEFAULT 1,
  `peran` varchar(255) NOT NULL DEFAULT 'lainnya',
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `komponen_dana_kode_unique` (`kode`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `legal_products`;
CREATE TABLE `legal_products` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `number` smallint NULL,
  `year` smallint NULL,
  `period_id` bigint NULL,
  `amends_id` bigint NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NULL,
  `file_path` varchar(255) NULL,
  `mime_type` varchar(255) NULL,
  `size` bigint NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` datetime NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `downloads` bigint NOT NULL DEFAULT '0',
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `edition` varchar(50) NULL,
  `enacted_on` date NULL,
  `forum` varchar(150) NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `legal_products_slug_unique` (`slug`),
  KEY `legal_products_type_index` (`type`),
  KEY `legal_products_type_year_number_index` (`type`, `year`, `number`),
  CONSTRAINT `legal_products_amends_id_foreign` FOREIGN KEY (`amends_id`) REFERENCES `legal_products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `legal_products_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- Index parsial `legal_products_gbhkm_period_unique` dilewati (tidak didukung MySQL).

DROP TABLE IF EXISTS `lembaga`;
CREATE TABLE `lembaga` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama` varchar(120) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `fakultas_id` bigint NULL,
  `parent_id` bigint NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `lembaga_fakultas_id_foreign` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `lembaga_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `lembaga` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `mahasiswa_fakultas`;
CREATE TABLE `mahasiswa_fakultas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `periode_id` bigint NOT NULL,
  `fakultas_id` bigint NOT NULL,
  `jumlah_mahasiswa` int NOT NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `mahasiswa_fakultas_periode_id_fakultas_id_unique` (`periode_id`, `fakultas_id`),
  PRIMARY KEY (`id`),
  CONSTRAINT `mahasiswa_fakultas_fakultas_id_foreign` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultas` (`id`),
  CONSTRAINT `mahasiswa_fakultas_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `mime_type` varchar(255) NULL,
  `size` bigint NOT NULL DEFAULT '0',
  `alt_text` varchar(255) NULL,
  `user_id` bigint NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `media_file_path_unique` (`file_path`),
  PRIMARY KEY (`id`),
  CONSTRAINT `media_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `officials`;
CREATE TABLE `officials` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `organizational_unit_id` bigint NOT NULL,
  `period_id` bigint NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NULL,
  `photo_path` varchar(255) NULL,
  `email` varchar(255) NULL,
  `instagram` varchar(255) NULL,
  `linkedin` varchar(255) NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  `description` varchar(255) NULL,
  `fakultas` varchar(255) NULL,
  `prodi` varchar(255) NULL,
  `angkatan` varchar(255) NULL,
  `nim` varchar(255) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `officials_organizational_unit_id_foreign` FOREIGN KEY (`organizational_unit_id`) REFERENCES `organizational_units` (`id`) ON DELETE CASCADE,
  CONSTRAINT `officials_period_id_foreign` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `organizational_units`;
CREATE TABLE `organizational_units` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `parent_id` bigint NULL,
  `type` varchar(255) NOT NULL DEFAULT 'badan',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NULL,
  `logo_path` varchar(255) NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  `abbreviation` varchar(32) NULL,
  `tasks` longtext NULL,
  `work_programs` longtext NULL,
  `email` varchar(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organizational_units_slug_unique` (`slug`),
  CONSTRAINT `organizational_units_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `organizational_units` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `page_contents`;
CREATE TABLE `page_contents` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NULL,
  `body` longtext NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  `signature_role` varchar(255) NULL,
  `signature_name` varchar(255) NULL,
  `signature_fakultas` varchar(255) NULL,
  `signature_nim` varchar(255) NULL,
  UNIQUE KEY `page_contents_key_unique` (`key`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pengaturan_halaman`;
CREATE TABLE `pengaturan_halaman` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `halaman` varchar(40) NOT NULL,
  `kunci` varchar(60) NOT NULL,
  `nilai` longtext NOT NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `pengaturan_halaman_halaman_kunci_unique` (`halaman`, `kunci`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `periods`;
CREATE TABLE `periods` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `starts_on` date NULL,
  `ends_on` date NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pimpinan_dewan`;
CREATE TABLE `pimpinan_dewan` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `periode_id` bigint NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `fakultas` varchar(255) NULL,
  `prodi` varchar(255) NULL,
  `angkatan` varchar(255) NULL,
  `nim` varchar(255) NULL,
  `email` varchar(255) NULL,
  `instagram` varchar(255) NULL,
  `linkedin` varchar(255) NULL,
  `foto_path` varchar(255) NULL,
  `sort_order` smallint NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  KEY `pimpinan_dewan_jabatan_index` (`jabatan`),
  KEY `pimpinan_dewan_periode_id_is_active_index` (`periode_id`, `is_active`),
  PRIMARY KEY (`id`),
  CONSTRAINT `pimpinan_dewan_periode_id_foreign` FOREIGN KEY (`periode_id`) REFERENCES `periods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pimpinan_tugas`;
CREATE TABLE `pimpinan_tugas` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `pimpinan_dewan_id` bigint NOT NULL,
  `tugas` longtext NOT NULL,
  `sort_order` smallint NOT NULL DEFAULT '0',
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  KEY `pimpinan_tugas_pimpinan_dewan_id_index` (`pimpinan_dewan_id`),
  PRIMARY KEY (`id`),
  CONSTRAINT `pimpinan_tugas_pimpinan_dewan_id_foreign` FOREIGN KEY (`pimpinan_dewan_id`) REFERENCES `pimpinan_dewan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` longtext NULL,
  `body` longtext NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `published_at` datetime NULL,
  `featured_image` varchar(255) NULL,
  `meta_title` varchar(255) NULL,
  `meta_description` longtext NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  `type` varchar(255) NULL COMMENT 'Type for Sosialisasi: peraturan, kebijakan, program, lain-lain',
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `profil_dewans`;
CREATE TABLE `profil_dewans` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `nim` varchar(255) NULL,
  `fakultas` varchar(255) NULL,
  `program_studi` varchar(255) NULL,
  `angkatan` varchar(255) NULL,
  `email_kampus` varchar(255) NULL,
  `jabatan` varchar(255) NOT NULL,
  `unit_kerja` varchar(255) NULL,
  `periode` varchar(255) NOT NULL,
  `masa_jabatan` varchar(255) NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `bio` longtext NULL,
  `tugas_tanggung_jawab` longtext NULL,
  `instagram` varchar(255) NULL,
  `email` varchar(255) NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint NULL,
  `ip_address` varchar(45) NULL,
  `user_agent` longtext NULL,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  KEY `sessions_last_activity_index` (`last_activity`),
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `settings_key_unique` (`key`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` datetime NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) NULL,
  `created_at` datetime NULL,
  `updated_at` datetime NULL,
  UNIQUE KEY `users_email_unique` (`email`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Data
-- ------------------------------------------------------------

INSERT INTO `alokasi_distribusi` (`id`, `dana_triwulan_id`, `lembaga_id`, `jumlah`, `created_at`, `updated_at`) VALUES
  (1, 1, 4, 37125798, '2026-11-07 19:45:07', '2026-11-07 19:45:07'),
  (2, 1, 5, 37125798, '2026-11-07 19:45:09', '2026-11-07 19:45:09'),
  (3, 1, 6, 31822112, '2026-11-07 19:45:12', '2026-11-07 19:45:12'),
  (4, 1, 7, 0, '2026-11-07 19:45:14', '2026-11-07 19:45:14'),
  (5, 1, 3, 60108434, '2026-11-07 19:45:16', '2026-11-07 19:45:16'),
  (6, 1, 2, 10607371, '2026-11-07 19:45:19', '2026-11-07 19:45:19'),
  (7, 1, 8, 24396952, '2026-11-07 19:46:05', '2026-11-07 19:46:05'),
  (8, 1, 9, 12591975, '2026-11-07 19:46:09', '2026-11-07 19:46:09'),
  (9, 1, 10, 2360995, '2026-11-07 19:46:11', '2026-11-07 19:46:11'),
  (10, 1, 11, 24396952, '2026-11-07 19:46:14', '2026-11-07 19:46:14'),
  (11, 1, 12, 12591975, '2026-11-07 19:46:17', '2026-11-07 19:46:17'),
  (12, 1, 13, 2360995, '2026-11-07 19:46:19', '2026-11-07 19:46:19');

INSERT INTO `alokasi_taktis` (`id`, `dana_triwulan_id`, `fakultas_id`, `jumlah`, `keterangan`, `created_at`, `updated_at`) VALUES
  (1, 1, NULL, 41200000, 'Universitas', '2026-11-07 19:46:21', '2026-11-07 19:46:21'),
  (2, 1, 1, 700000, NULL, '2026-11-07 19:46:24', '2026-11-07 19:46:24'),
  (3, 1, 3, 5000000, NULL, '2026-11-07 19:46:26', '2026-11-07 19:46:26');

-- cache: tidak ada data

-- cache_locks: tidak ada data

INSERT INTO `complaints` (`id`, `ticket_number`, `name`, `email`, `phone`, `category`, `subject`, `message`, `attachment_path`, `is_anonymous`, `status`, `response`, `responded_at`, `ip_address`, `created_at`, `updated_at`, `student_id`, `faculty`) VALUES
  (1, 'DPM-261029-7A8B', 'Fathurrahman Al-Ghifari', '21522045@students.uii.ac.id', '081234567890', 'Fasilitas & Sarana Prasarana', 'Permohonan Penambahan Stopkontak dan Penguatan Wifi Gedung FTI', 'Mohon kepada DPM UII untuk mengadvokasikan penambahan fasilitas stopkontak di selasar lantai 2 dan 3 Gedung Mas Mansyur FTI serta optimalisasi jaringan wifi edukasi yang sering mengalami lonjakan trafik pada jam kuliah sibuk.', NULL, 0, 'baru', NULL, NULL, NULL, '2026-11-02 02:30:49', '2026-11-02 04:30:50', '21522045', 'Fakultas Teknologi Industri'),
  (2, 'DPM-261029-3K9L', NULL, 'mahasiswa.fbe@students.uii.ac.id', NULL, 'Finansial & UKT', 'Transparansi Mekanisme Pengajuan Keringanan UKT Semester Genap', 'Kami mengharapkan adanya kejelasan batas waktu verifikasi berkas dan indikator penilaian bagi rekan-rekan mahasiswa yang mengajukan permohonan banding/keringanan pembayaran UKT.', NULL, 1, 'baru', NULL, NULL, NULL, '2026-11-01 23:30:49', '2026-11-02 04:30:52', '22311099', 'Fakultas Bisnis dan Ekonomika'),
  (3, 'DPM-261028-9F2M', 'Nabila Zahra Syahrani', 'nabila.zahra@students.uii.ac.id', '085712349988', 'Advokasi & Kebijakan Kampus', 'Advokasi Perpanjangan Jam Operasional Perpustakaan Pusat UII', 'Sehubungan dengan meningkatnya kebutuhan ruang belajar yang representatif dan kondusif bagi mahasiswa menjelang periode ujian, kami mengusulkan advokasi perpanjangan jam operasional Perpustakaan Pusat hingga pukul 21.00 WIB.', NULL, 0, 'diproses', NULL, NULL, NULL, '2026-11-01 04:30:49', '2026-11-02 04:30:53', '23411012', 'Fakultas Hukum'),
  (4, 'DPM-261025-1C4E', 'Muhammad Ilham Pratama', 'ilham.pratama@students.uii.ac.id', '087811223344', 'Konstitusi KM UII', 'Klarifikasi Tahapan Sosialisasi Perubahan PKM Pemilwa KM UII', 'Bagaimanakah alur keterlibatan lembaga legislatif fakultas dalam pembahasan draf akhir revisi PKM tentang Pemilwa sebelum disahkan dalam Sidang Paripurna DPM UII?', NULL, 0, 'selesai', 'Terima kasih atas perhatian dan aspirasi Saudara. Komisi I (Legislasi) DPM UII telah menyelenggarakan agenda Uji Publik Draf PKM Pemilwa bersama delegasi DPM Fakultas se-UII. Risalah pembahasan dan matriks persandingan pasal dapat diakses terbuka pada portal ini.', '2026-10-31 04:30:49', NULL, '2026-10-29 04:30:49', '2026-11-02 04:30:55', '20320078', 'Fakultas Ilmu Agama Islam'),
  (5, 'DPM-261020-8H5Z', 'Rendi Kurniawan', 'rendi.k@students.uii.ac.id', '089988776655', 'Lainnya', 'Pengajuan Proposal Sponsor Produk Minuman Luar Kampus', 'Pengajuan proposal kerjasama sponsorship komersial untuk kegiatan perlombaan eksternal.', NULL, 0, 'ditolak', 'Kanal Layanan Aspirasi DPM UII dikhususkan untuk penyerapan aspirasi, advokasi kebijakan kemahasiswaan, dan pengawalan hak-hak mahasiswa KM UII. Untuk pengajuan sponsorship dan kerjasama komersial, silakan berkoordinasi langsung dengan Direktorat Kemitraan Kampus.', '2026-10-26 04:30:49', NULL, '2026-10-24 04:30:49', '2026-11-02 04:30:56', '22511033', 'Fakultas Teknik Sipil dan Perencanaan');

INSERT INTO `dana_info` (`id`, `dana_triwulan_id`, `seksi`, `teks`, `created_at`, `updated_at`) VALUES
  (1, 1, 'overview', 'Total dana distribusi periode 2025/2026 Triwulan I sebesar Rp688.575.000,00.', '2026-11-07 19:46:48', '2026-11-07 19:46:48'),
  (2, 1, 'pembagian', 'Dana dibagi menjadi komponen transisi, taktis, aset, dan distribusi.', '2026-11-07 19:46:49', '2026-11-07 19:46:49'),
  (3, 1, 'universitas', 'Dana tingkat universitas dialokasikan kepada DPM Universitas dan LEM Universitas.', '2026-11-07 19:46:51', '2026-11-07 19:46:51'),
  (4, 1, 'fakultas', 'Dana tingkat fakultas dialokasikan kepada LEM, LPM, dan DPM tiap fakultas.', '2026-11-07 19:46:52', '2026-11-07 19:46:52'),
  (5, 1, 'per_fakultas', 'Setiap fakultas menerima alokasi sesuai dengan jumlah mahasiswa dan kebutuhan program kerja.', '2026-11-07 19:46:54', '2026-11-07 19:46:54'),
  (6, 1, 'rasio', 'Rasio alokasi per fakultas dihitung berdasarkan proporsi jumlah mahasiswa per fakultas terhadap total mahasiswa.', '2026-11-07 19:46:56', '2026-11-07 19:46:56'),
  (7, 1, 'taktis', 'Dana taktis dialokasikan untuk kebutuhan operasional dan program kerja tingkat universitas dan fakultas.', '2026-11-07 19:46:57', '2026-11-07 19:46:57');

INSERT INTO `dana_komponen` (`id`, `dana_triwulan_id`, `komponen_id`, `jumlah`, `created_at`, `updated_at`) VALUES
  (1, 1, 1, 12000000, '2026-11-07 19:45:00', '2026-11-07 19:45:00'),
  (2, 1, 2, 103286250, '2026-11-07 19:45:02', '2026-11-07 19:45:02'),
  (3, 1, 3, 3000000, '2026-11-07 19:45:03', '2026-11-07 19:45:03'),
  (4, 1, 4, 570288750, '2026-11-07 19:45:05', '2026-11-07 19:45:05');

INSERT INTO `dana_revisi` (`id`, `dana_triwulan_id`, `diubah_oleh`, `alasan`, `snapshot`, `dibuat_pada`, `created_at`, `updated_at`) VALUES
  (1, 1, 1, 'Pembentukan data awal distribusi dana Triwulan I.', '{\"total_dana\":688575000,\"status\":\"terbit\"}', '2026-11-07 19:47:20', '2026-11-07 19:47:20', '2026-11-07 19:47:20'),
  (2, 1, 1, 'Pembentukan data awal distribusi dana Triwulan I.', '{\"total_dana\":688575000,\"status\":\"terbit\"}', '2026-11-07 21:14:44', '2026-11-07 21:14:44', '2026-11-07 21:14:44');

INSERT INTO `dana_seksi` (`id`, `dana_triwulan_id`, `seksi`, `urutan`, `is_tampil`, `judul`, `created_at`, `updated_at`) VALUES
  (1, 1, 'overview', 1, 1, 'Ringkasan', '2026-11-07 19:46:59', '2026-11-07 19:46:59'),
  (2, 1, 'pembagian', 2, 1, 'Pembagian Komponen', '2026-11-07 19:47:01', '2026-11-07 19:47:01'),
  (3, 1, 'universitas', 3, 1, 'Tingkat Universitas', '2026-11-07 19:47:03', '2026-11-07 19:47:03'),
  (4, 1, 'fakultas', 4, 1, 'Tingkat Fakultas', '2026-11-07 19:47:04', '2026-11-07 19:47:04'),
  (5, 1, 'per_fakultas', 5, 1, 'Per Fakultas', '2026-11-07 19:47:06', '2026-11-07 19:47:06'),
  (6, 1, 'rasio', 6, 1, 'Rasio Mahasiswa', '2026-11-07 19:47:08', '2026-11-07 19:47:08'),
  (7, 1, 'taktis', 7, 1, 'Dana Taktis', '2026-11-07 19:47:09', '2026-11-07 19:47:09');

INSERT INTO `dana_triwulan` (`id`, `periode_id`, `triwulan`, `total_dana`, `status`, `diterbitkan_pada`, `diterbitkan_oleh`, `sumber_url`, `created_at`, `updated_at`) VALUES
  (1, 3, 1, 688575000, 'terbit', '2026-11-07 21:13:41', 1, NULL, '2026-11-07 19:44:59', '2026-11-07 21:13:42');

INSERT INTO `document_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `created_at`, `updated_at`, `group`, `parent_id`, `type`) VALUES
  (1, 'Produk Hukum', 'produk-hukum', 'PDKM, GBHKM, PKM, dan PDPM sebagai dasar penyelenggaraan KM UII.', 1, '2026-11-02 04:29:22', '2026-11-02 04:29:22', 'Produk Hukum', NULL, 'main'),
  (2, 'Surat Keputusan', 'surat-keputusan', 'Surat keputusan yang dikeluarkan DPM UII: badan, tim kelengkapan dewan, lembaga, dan penyelenggara pemilu.', 2, '2026-11-02 04:29:24', '2026-11-02 04:29:24', 'Keputusan', NULL, 'main'),
  (4, 'Distribusi Dana', 'distribusi-dana', 'Rincian distribusi dan alokasi dana KM UII per lembaga.', 4, '2026-11-02 04:29:29', '2026-11-02 04:29:29', 'Dana', NULL, 'main'),
  (5, 'LPJ', 'lpj', 'Laporan pertanggungjawaban penggunaan dana kegiatan KM UII.', 5, '2026-11-02 04:29:31', '2026-11-02 04:29:31', 'Dana', NULL, 'main'),
  (6, 'LHA', 'lha', 'Laporan hasil audit pengelolaan keuangan dan aset kemahasiswaan.', 6, '2026-11-02 04:29:33', '2026-11-02 04:29:33', 'Dana', NULL, 'main'),
  (7, 'Laporan Keuangan', 'laporan-keuangan', 'Laporan keuangan triwulan dan laporan penggunaan dana kegiatan.', 7, '2026-11-02 04:29:35', '2026-11-02 04:29:35', 'Dana', NULL, 'main'),
  (8, 'Surat Ketetapan', 'surat-ketetapan', 'Ketetapan dan penetapan yang dikeluarkan DPM UII dalam sidang paripurna.', 3, '2026-11-02 04:32:16', '2026-11-02 04:32:16', 'Keputusan', NULL, 'main'),
  (9, 'Keterangan Akademik', 'keterangan-akademik', 'Surat keterangan akademik yang diterbitkan DPM UII.', 8, '2026-11-02 04:32:19', '2026-11-02 04:32:19', 'Akademik', NULL, 'main'),
  (3, 'Laporan Kinerja', 'laporan-kinerja', 'Laporan kinerja DPM UII: Foraslak, Laporan Akhir, Evaluasi Kinerja, dan dokumen penilaian kinerja per periode.', 9, '2026-11-02 04:29:26', '2026-11-02 04:32:21', 'Kinerja', NULL, 'main'),
  (11, 'DPM Fakultas', 'dpm-fakultas', 'Surat keputusan dari DPM Fakultas se-UII: FBE, FH, FIA, FK, FMIPA, FTI, FTSP, FPSB, FPSI, FIA, FEB, dll.', 2, '2026-11-02 04:32:26', '2026-11-02 04:32:26', 'Keputusan', 2, 'sub'),
  (12, 'Lembaga & LK', 'lembaga-lk', 'Surat keputusan dari Lembaga Khusus, LK, dan unit kerja lain: Pers Himmah, Tim Produksi, dll.', 3, '2026-11-02 04:32:29', '2026-11-02 04:32:29', 'Keputusan', 2, 'sub'),
  (10, 'Badan Kelengkapan Dewan', 'badan-kelengkapan-dewan', 'Surat keputusan dari badan-badan kelengkapan Dewan: Baleg, Bawas, BAK, BPA, Bksaj, Mentari, Pimpinan, KPU, Panwas, Sekretariat.', 1, '2026-11-02 04:32:23', '2026-11-02 04:32:23', 'Keputusan', 2, 'sub');

INSERT INTO `documents` (`id`, `document_category_id`, `period_id`, `title`, `slug`, `description`, `file_path`, `external_url`, `mime_type`, `size`, `year`, `quarter`, `published_at`, `downloads`, `is_featured`, `sort_order`, `created_at`, `updated_at`) VALUES
  (79, 10, 1, 'Surat Keputusan Struktur KPSU UII', 'surat-keputusan-struktur-kpsu-uii', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK-STRUKTUR KPSU-UII 2021-Fix.pdf', NULL, 'application/pdf', 404372, 2021, NULL, '2021-01-01 00:00:00', 0, 0, 5, '2026-11-02 05:27:48', '2026-11-07 00:25:04'),
  (80, 10, 2, 'Surat Keputusan Tim MO & AD Pesta', 'surat-keputusan-tim-mo-ad-pesta', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK-TIM MO & AD pesta_final.pdf', NULL, 'application/pdf', 152238, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 6, '2026-11-02 05:27:51', '2026-11-07 00:25:08'),
  (81, 10, 1, 'Surat Keputusan BAK KM UII', 'surat-keputusan-bak-km-uii', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN BAK KM UII 2021 FINAL.pdf', NULL, 'application/pdf', 179972, 2021, NULL, '2021-01-01 00:00:00', 0, 0, 7, '2026-11-02 05:27:54', '2026-11-07 00:25:12'),
  (102, 8, 2, 'Ketetapan DPM UII Nomor XLI', 'ketetapan-dpm-uii-nomor-xli', 'Surat Ketetapan DPM UII', 'uploads/produk-hukum/SURAT KETETAPAN/S-TAP-SU-XLI_DPM UII-final.pdf', NULL, 'application/pdf', 162922, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 1, '2026-11-02 05:28:57', '2026-11-07 00:26:50'),
  (103, 9, 2, 'RPKM Kode Etik Lembaga Legislatif', 'rpkm-kode-etik-lembaga-legislatif', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM KODE ETIK LEMBAGA LEGISLATIF.pdf', NULL, 'application/pdf', 131774, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 1, '2026-11-02 05:29:00', '2026-11-07 00:26:54'),
  (104, 9, 2, 'RPKM Lembaga Legislatif', 'rpkm-lembaga-legislatif', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM LEMBAGA LEGISLATIF.pdf', NULL, 'application/pdf', 174564, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 2, '2026-11-02 05:29:02', '2026-11-07 00:26:58'),
  (83, 10, 1, 'Surat Keputusan BPA KM UII', 'surat-keputusan-bpa-km-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN BPA KM UII 2020-2021.pdf', NULL, 'application/pdf', 236612, 2020, NULL, '2020-01-01 00:00:00', 0, 0, 8, '2026-11-02 05:28:00', '2026-11-07 00:32:38'),
  (85, 11, 1, 'Surat Keputusan DPM FBE UII', 'surat-keputusan-dpm-fbe-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FBE UII 2020-2021.pdf', NULL, 'application/pdf', 164193, 2020, NULL, '2020-01-01 00:00:00', 0, 0, 9, '2026-11-02 05:28:06', '2026-11-07 00:32:42'),
  (87, 11, 1, 'Surat Keputusan DPM FH UII', 'surat-keputusan-dpm-fh-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FH UII 2020-2021.pdf', NULL, 'application/pdf', 164369, 2020, NULL, '2020-01-01 00:00:00', 0, 0, 10, '2026-11-02 05:28:12', '2026-11-07 00:32:45'),
  (89, 11, 1, 'Surat Keputusan DPM FIAI UII', 'surat-keputusan-dpm-fiai-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FIAI UII 2020-2021.pdf', NULL, 'application/pdf', 208616, 2020, NULL, '2020-01-01 00:00:00', 0, 0, 11, '2026-11-02 05:28:18', '2026-11-07 00:32:49'),
  (91, 11, 1, 'Surat Keputusan DPM FK UII', 'surat-keputusan-dpm-fk-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FK UII 2020-2021.pdf', NULL, 'application/pdf', 164657, 2020, NULL, '2020-01-01 00:00:00', 0, 0, 12, '2026-11-02 05:28:24', '2026-11-07 00:32:53'),
  (92, 11, 1, 'Surat Keputusan DPM FMIPA UII', 'surat-keputusan-dpm-fmipa-uii', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FMIPA UII 2020-2021_revisi.pdf', NULL, 'application/pdf', 168941, 2020, NULL, '2020-01-01 00:00:00', 0, 0, 13, '2026-11-02 05:28:27', '2026-11-07 00:32:57'),
  (93, 11, 1, 'Surat Keputusan DPM FTI UII', 'surat-keputusan-dpm-fti-uii', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FTI UII 2020-2021 final.pdf', NULL, 'application/pdf', 207614, 2020, NULL, '2020-01-01 00:00:00', 0, 0, 14, '2026-11-02 05:28:30', '2026-11-07 00:33:00'),
  (96, 11, 1, 'Surat Keputusan DPM FTSP UII', 'surat-keputusan-dpm-ftsp-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN DPM FTSP UII 2020-2021.pdf', NULL, 'application/pdf', 292841, 2020, NULL, '2020-01-01 00:00:00', 0, 0, 15, '2026-11-02 05:28:39', '2026-11-07 00:33:04'),
  (97, 10, 1, 'Surat Keputusan KPU', 'surat-keputusan-kpu-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN KPU 2022.pdf', NULL, 'application/pdf', 193386, 2022, NULL, '2022-01-01 00:00:00', 0, 0, 16, '2026-11-02 05:28:42', '2026-11-07 00:33:08'),
  (99, 10, 1, 'Surat Keputusan Pembentukan DPM FPSB UII', 'surat-keputusan-pembentukan-dpm-fpsb-uii-1', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN PEMBENTUKAN DPM FPSB UII 2020-2021.pdf', NULL, 'application/pdf', 204185, 2020, NULL, '2020-01-01 00:00:00', 0, 0, 17, '2026-11-02 05:28:48', '2026-11-07 00:33:11'),
  (101, 10, 2, 'Surat Keputusan Tim Produksi', 'surat-keputusan-tim-produksi', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN-TIM PRODUKSI-1.pdf', NULL, 'application/pdf', 224345, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 19, '2026-11-02 05:28:54', '2026-11-07 00:33:19'),
  (105, 9, 2, 'RPKM LMBG Khusus', 'rpkm-lmbg-khusus', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM LMBG KHUSUS.pdf', NULL, 'application/pdf', 155011, 2024, NULL, '2024-01-01 00:00:00', 1, 0, 3, '2026-11-02 05:29:04', '2026-11-07 00:27:01'),
  (106, 9, 2, 'RPKM Pedoman Kegiatan', 'rpkm-pedoman-kegiatan', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM PEDOMAN KEGIATAN.pdf', NULL, 'application/pdf', 174858, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 4, '2026-11-02 05:29:07', '2026-11-07 00:27:05'),
  (107, 9, 2, 'RPKM Pedoman Struktur LMBG Eksekutif', 'rpkm-pedoman-struktur-lmbg-eksekutif', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM PEDOMAN STRUKTUR LMBG EKSEKUTIF.pdf', NULL, 'application/pdf', 174634, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 5, '2026-11-02 05:29:09', '2026-11-07 00:27:08'),
  (108, 9, 2, 'RPKM Pembentukan, Pembekuan dan Pembubaran Lembaga', 'rpkm-pembentukan-pembekuan-dan-pembubaran-lembaga', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM PEMBENTUKAN, PEMBEKUAN DAN PEMBUBARAN LEMBAGA.pdf', NULL, 'application/pdf', 150680, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 6, '2026-11-02 05:29:11', '2026-11-07 00:27:12'),
  (109, 9, 2, 'RPKM UKMK', 'rpkm-ukmk', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KA RPKM UKMK.pdf', NULL, 'application/pdf', 154675, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 7, '2026-11-02 05:29:13', '2026-11-07 00:27:15'),
  (110, 9, 2, 'PKM Aset KM UII', 'pkm-aset-km-uii', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KETERANGAN AKADEMIK PKM ASET KM UII.pdf', NULL, 'application/pdf', 158892, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 8, '2026-11-02 05:29:16', '2026-11-07 00:27:18'),
  (111, 9, 2, 'RPKM Foraslak', 'rpkm-foraslak', 'Keterangan Akademik DPM UII', 'uploads/produk-hukum/KETERANGAN AKADEMIK/KETERANGAN AKADEMIK RPKM FORASLAK.pdf', NULL, 'application/pdf', 126971, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 9, '2026-11-02 05:29:18', '2026-11-07 00:27:21'),
  (100, 12, 2, 'Surat Keputusan Pengesahan Struktur Pengurus Lembaga Khusus Pers Himmah', 'surat-keputusan-pengesahan-struktur-pengurus-lembaga-khusus-pers-himmah', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SURAT KEPUTUSAN PENGESAHAN STRUKTUR PENGURUS LEMBAGA KHUSUS PERS HIMMAH.pdf', NULL, 'application/pdf', 603542, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 18, '2026-11-02 05:28:51', '2026-11-07 00:33:15'),
  (75, 10, 2, 'Surat Keputusan Direktorat Sekretaris Jenderal', 'surat-keputusan-direktorat-sekretaris-jenderal', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK DIREKTORAT SEKRETARIS JENDERAL.pdf', NULL, 'application/pdf', 502559, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 1, '2026-11-02 05:27:36', '2026-11-07 00:24:46'),
  (77, 10, 2, 'Surat Keputusan Struktur Panitia Pengawas Pemilihan Umum Wakil Mahasiswa', 'surat-keputusan-struktur-panitia-pengawas-pemilihan-umum-wakil-mahasiswa', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK STRUKTUR PANITIA PENGAWAS PEMILIHAN UMUM WAKIL MAHASISWA.pdf', NULL, 'application/pdf', 466886, 2024, NULL, '2024-01-01 00:00:00', 0, 0, 3, '2026-11-02 05:27:42', '2026-11-07 00:24:55'),
  (78, 10, 2, 'Surat Keputusan Baleg Komisi I', 'surat-keputusan-baleg-komisi-i', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK-BALEG KOMISI I _REVISI=final.pdf', NULL, 'application/pdf', 173503, 2024, NULL, '2024-01-01 00:00:00', 1, 0, 4, '2026-11-02 05:27:45', '2026-11-07 00:24:59'),
  (76, 10, 1, 'Surat Keputusan Panwas', 'surat-keputusan-panwas', 'Surat Keputusan DPM UII', 'uploads/produk-hukum/SURAT KEPUTUSAN/SK PANWAS PERIODE 2022-2023.pdf', NULL, 'application/pdf', 466886, 2022, NULL, '2022-01-01 00:00:00', 1, 0, 2, '2026-11-02 05:27:39', '2026-11-07 15:40:51');

INSERT INTO `dokumen_keuangan` (`id`, `jenis`, `periode_id`, `lembaga_id`, `semester`, `judul`, `tanggal`, `file_path`, `status`, `created_at`, `updated_at`) VALUES
  (1, 'lpj', 3, 2, 'ganjil', 'LPJ DPM Universitas Semester Ganjil 2025/2026', '2026-01-15', NULL, 'terbit', '2026-11-07 19:47:12', '2026-11-07 19:47:12'),
  (2, 'lha', 3, 2, 'ganjil', 'LHA DPM Universitas Semester Ganjil 2025/2026', '2026-02-01', NULL, 'draft', '2026-11-07 19:47:13', '2026-11-07 19:47:13');

-- failed_jobs: tidak ada data

INSERT INTO `fakultas` (`id`, `kode`, `nama`, `urutan`, `created_at`, `updated_at`) VALUES
  (2, 'FPSIB', 'Fakultas Psikologi & Ilmu Sosial Budaya', 2, '2026-11-07 19:43:14', '2026-11-07 19:43:14'),
  (4, 'FE', 'Fakultas Ekonomi', 4, '2026-11-07 19:43:15', '2026-11-07 19:43:15'),
  (6, 'FTSP', 'Fakultas Teknik Sipil & Perencanaan', 6, '2026-11-07 19:43:17', '2026-11-07 19:43:17'),
  (9, 'FB', 'Fakultas Biologi', 9, '2026-11-07 19:43:19', '2026-11-07 19:43:19'),
  (11, 'FBE', 'Fakultas Bisnis dan Ekonomika', 1, '2026-11-07 21:13:14', '2026-11-07 21:13:14'),
  (1, 'FH', 'Fakultas Hukum', 2, '2026-11-07 19:43:13', '2026-11-07 21:13:16'),
  (5, 'FIAI', 'Fakultas Ilmu Agama Islam', 3, '2026-11-07 19:43:16', '2026-11-07 21:13:18'),
  (12, 'FISB', 'Fakultas Ilmu Sosial Budaya', 4, '2026-11-07 21:13:19', '2026-11-07 21:13:19'),
  (7, 'FK', 'Fakultas Kedokteran', 5, '2026-11-07 19:43:18', '2026-11-07 21:13:21'),
  (8, 'FMIPA', 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 6, '2026-11-07 19:43:18', '2026-11-07 21:13:22'),
  (13, 'FPSB', 'Fakultas Psikologi', 7, '2026-11-07 21:13:24', '2026-11-07 21:13:24'),
  (14, 'FTDI', 'Fakultas Teknik Desain Inovasi', 8, '2026-11-07 21:13:25', '2026-11-07 21:13:25'),
  (3, 'FTI', 'Fakultas Teknologi Industri', 9, '2026-11-07 19:43:14', '2026-11-07 21:13:27');

-- job_batches: tidak ada data

-- jobs: tidak ada data

INSERT INTO `komponen_dana` (`id`, `kode`, `nama`, `urutan`, `is_tampil`, `peran`, `created_at`, `updated_at`) VALUES
  (1, 'transisi', 'Dana Transisi', 1, 1, 'lainnya', '2026-11-07 19:44:52', '2026-11-07 19:44:52'),
  (2, 'taktis', 'Dana Taktis', 2, 1, 'taktis', '2026-11-07 19:44:54', '2026-11-07 19:44:54'),
  (3, 'aset', 'Pengembangan dan Pengelolaan Aset', 3, 1, 'lainnya', '2026-11-07 19:44:55', '2026-11-07 19:44:55'),
  (4, 'distribusi', 'Dana Distribusi', 4, 1, 'distribusi', '2026-11-07 19:44:57', '2026-11-07 19:44:57');

INSERT INTO `legal_products` (`id`, `type`, `number`, `year`, `period_id`, `amends_id`, `title`, `slug`, `description`, `file_path`, `mime_type`, `size`, `is_published`, `published_at`, `sort_order`, `downloads`, `created_at`, `updated_at`, `status`, `edition`, `enacted_on`, `forum`) VALUES
  (86, 'pdkm', NULL, 2024, 2, NULL, 'Peraturan Dasar KM UII Ke-38 (1)', 'peraturan-dasar-km-uii-ke-38-1-pdkm-single-2024', 'Peraturan Dasar Keluarga Mahasiswa (PDKM) merupakan konstitusi tertinggi KM UII yang mengatur asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa.', 'uploads/produk-hukum/PDKM UII/PERATURAN DASAR KM UII KE-38 (1).pdf', 'application/pdf', 763035, 1, '2026-11-07 22:50:52', 1, 0, '2026-11-07 22:50:54', '2026-11-07 22:50:54', 'aktif', NULL, NULL, NULL),
  (87, 'gbhkm', NULL, 2024, 2, NULL, 'SU Xlv (45)', 'su-xlv-45-gbhkm-single-2024', 'GBHKM merupakan manifestasi dari arah gerak dan cita-cita mahasiswa UII yang disusun dan disahkan oleh DPM UII melalui Sidang Umum atau Sidang Istimewa. Dokumen ini berfungsi sebagai pedoman resmi dan landasan penyusunan rencana kerja yang berkesinambungan bagi seluruh lembaga kemahasiswaan di lingkungan KM UII.', 'uploads/produk-hukum/GBHKM/GBHKM SU XLV (45).pdf', 'application/pdf', 384092, 1, '2026-11-07 22:50:54', 1, 0, '2026-11-07 22:50:56', '2026-11-07 22:50:56', 'aktif', NULL, NULL, NULL),
  (88, 'pkm', 2, 2022, NULL, NULL, 'Pemilihan Umum Wakil Mahasiswa Perubahan Atas PKM Nomor 2 Tahun 2018 Tentang Pemilihan Umum Wakil Mahasiswa-final.docx', 'pemilihan-umum-wakil-mahasiswa-perubahan-atas-pkm-nomor-2-tahun-2018-tentang-pemilihan-umum-wakil-mahasiswa-finaldocx-pkm-2-2022', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM NOMOR 2 TAHUN 2022 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA PERUBAHAN ATAS PKM NOMOR 2 TAHUN 2018 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA-final.docx.pdf', 'application/pdf', 347327, 1, '2026-11-07 22:50:57', 1, 0, '2026-11-07 22:50:59', '2026-11-07 22:50:59', 'aktif', NULL, NULL, NULL),
  (89, 'pkm', 2, 2022, NULL, NULL, 'Pemilihan Umum Wakil Mahasiswa Perubahan Kedua Atas PKM Nomor 2 Tahun 2018 Tentang Pemilihan Umum Wakil Mahasiswa-final.docx', 'pemilihan-umum-wakil-mahasiswa-perubahan-kedua-atas-pkm-nomor-2-tahun-2018-tentang-pemilihan-umum-wakil-mahasiswa-finaldocx-pkm-2-2022', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM NOMOR 2 TAHUN 2022 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA PERUBAHAN KEDUA ATAS PKM NOMOR 2 TAHUN 2018 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA-final.docx.pdf', 'application/pdf', 425716, 1, '2026-11-07 22:50:59', 2, 0, '2026-11-07 22:51:01', '2026-11-07 22:51:01', 'aktif', NULL, NULL, NULL),
  (90, 'pkm', 1, 2024, 2, NULL, 'Perubahan Atas PKM Pedoman Administrasi', 'perubahan-atas-pkm-pedoman-administrasi-pkm-1-2024', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM No. 1 Th 2024 tentang Perubahan Atas PKM Pedoman Administrasi.pdf', 'application/pdf', 430114, 1, '2026-11-07 22:51:02', 3, 0, '2026-11-07 22:51:04', '2026-11-07 22:51:04', 'aktif', NULL, NULL, NULL),
  (91, 'pkm', 2, 2024, 2, NULL, 'Pedoman Kegiatan KM UII', 'pedoman-kegiatan-km-uii-pkm-2-2024', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM No. 2 Th 2024 tentang Pedoman Kegiatan KM UII.pdf', 'application/pdf', 398917, 1, '2026-11-07 22:51:04', 4, 0, '2026-11-07 22:51:06', '2026-11-07 22:51:06', 'aktif', NULL, NULL, NULL),
  (92, 'pkm', 3, 2024, 2, NULL, 'Perubahan Atas PKM Alokasi Dana', 'perubahan-atas-pkm-alokasi-dana-pkm-3-2024', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM No. 3 Th 2024 tentang Perubahan Atas PKM Alokasi Dana.pdf', 'application/pdf', 294576, 1, '2026-11-07 22:51:07', 5, 0, '2026-11-07 22:51:09', '2026-11-07 22:51:09', 'aktif', NULL, NULL, NULL),
  (93, 'pkm', NULL, 2023, 1, NULL, 'Pemilwa Dan Penjelasan', 'pemilwa-dan-penjelasan-pkm-single-2023', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM PEMILWA DAN PENJELASAN 2023.pdf', 'application/pdf', 511350, 1, '2026-11-07 22:51:10', 6, 0, '2026-11-07 22:51:11', '2026-11-07 22:51:11', 'aktif', NULL, NULL, NULL),
  (94, 'pkm', 1, 2019, NULL, NULL, 'Kode Etik Lembaga Legislatif UII', 'kode-etik-lembaga-legislatif-uii-pkm-1-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 1 TAHUN 2019 TENTANG KODE ETIK LEMBAGA LEGISLATIF UII.pdf', 'application/pdf', 258028, 1, '2026-11-07 22:51:12', 7, 0, '2026-11-07 22:51:14', '2026-11-07 22:51:14', 'aktif', NULL, NULL, NULL),
  (95, 'pkm', 10, 2019, NULL, NULL, 'Pengelolaan Aset KM UII', 'pengelolaan-aset-km-uii-pkm-10-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 10 TAHUN 2019 TENTANG PENGELOLAAN ASET KM UII.pdf', 'application/pdf', 231802, 1, '2026-11-07 22:51:15', 8, 0, '2026-11-07 22:51:16', '2026-11-07 22:51:16', 'aktif', NULL, NULL, NULL),
  (96, 'pkm', 2, 2018, NULL, NULL, 'Pemilihan Umum Wakil Mahasiswa UII', 'pemilihan-umum-wakil-mahasiswa-uii-pkm-2-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 2 TAHUN 2018 TENTANG PEMILIHAN UMUM WAKIL MAHASISWA UII.pdf', 'application/pdf', 548805, 1, '2026-11-07 22:51:17', 9, 0, '2026-11-07 22:51:19', '2026-11-07 22:51:19', 'aktif', NULL, NULL, NULL),
  (97, 'pkm', 3, 2018, NULL, NULL, 'Pengelolaan Aspirasi Mahasiswa UII', 'pengelolaan-aspirasi-mahasiswa-uii-pkm-3-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 3 TAHUN 2018 TENTANG PENGELOLAAN ASPIRASI MAHASISWA UII.pdf', 'application/pdf', 318291, 1, '2026-11-07 22:51:20', 10, 0, '2026-11-07 22:51:21', '2026-11-07 22:51:21', 'aktif', NULL, NULL, NULL),
  (98, 'pkm', 3, 2019, NULL, NULL, 'DPM U & DPM F', 'dpm-u-dpm-f-pkm-3-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 3 TAHUN 2019 TENTANG DPM U & DPM F.pdf', 'application/pdf', 351520, 1, '2026-11-07 22:51:22', 11, 0, '2026-11-07 22:51:24', '2026-11-07 22:51:24', 'aktif', NULL, NULL, NULL),
  (99, 'pkm', 4, 2018, NULL, NULL, 'Produksi Jas Almamater UII', 'produksi-jas-almamater-uii-pkm-4-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 4 TAHUN 2018 TENTANG PRODUKSI JAS ALMAMATER UII.pdf', 'application/pdf', 248879, 1, '2026-11-07 22:51:25', 12, 0, '2026-11-07 22:51:26', '2026-11-07 22:51:26', 'aktif', NULL, NULL, NULL),
  (100, 'pkm', 4, 2019, NULL, NULL, 'Pedoman Pelaksanaan Foraslak Lembaga Legislatif KM UII', 'pedoman-pelaksanaan-foraslak-lembaga-legislatif-km-uii-pkm-4-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 4 TAHUN 2019 TENTANG PEDOMAN PELAKSANAAN FORASLAK LEMBAGA LEGISLATIF KM UII.pdf', 'application/pdf', 322317, 1, '2026-11-07 22:51:27', 13, 0, '2026-11-07 22:51:29', '2026-11-07 22:51:29', 'aktif', NULL, NULL, NULL),
  (101, 'pkm', 5, 2018, NULL, NULL, 'Pedoman Keanggotaan KM UII', 'pedoman-keanggotaan-km-uii-pkm-5-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 5 TAHUN 2018 TENTANG PEDOMAN KEANGGOTAAN KM UII.pdf', 'application/pdf', 276852, 1, '2026-11-07 22:51:30', 14, 0, '2026-11-07 22:51:31', '2026-11-07 22:51:31', 'aktif', NULL, NULL, NULL),
  (102, 'pkm', 5, 2019, NULL, NULL, 'UKM KM UII', 'ukm-km-uii-pkm-5-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 5 TAHUN 2019 TENTANG UKM KM UII.pdf', 'application/pdf', 341161, 1, '2026-11-07 22:51:32', 15, 0, '2026-11-07 22:51:34', '2026-11-07 22:51:34', 'aktif', NULL, NULL, NULL),
  (103, 'pkm', 6, 2018, NULL, NULL, 'Pedoman Administrasi KM UII (1)', 'pedoman-administrasi-km-uii-1-pkm-6-2018', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 6 TAHUN 2018 TENTANG PEDOMAN ADMINISTRASI KM UII (1).pdf', 'application/pdf', 371577, 1, '2026-11-07 22:51:35', 16, 0, '2026-11-07 22:51:36', '2026-11-07 22:51:36', 'aktif', NULL, NULL, NULL),
  (104, 'pkm', 6, 2019, NULL, NULL, 'UKMK KM UII', 'ukmk-km-uii-pkm-6-2019', 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.', 'uploads/produk-hukum/PKM UII/PKM UII NOMOR 6 TAHUN 2019 TENTANG UKMK KM UII.pdf', 'application/pdf', 342801, 1, '2026-11-07 22:51:37', 17, 0, '2026-11-07 22:51:39', '2026-11-07 22:51:39', 'aktif', NULL, NULL, NULL);

INSERT INTO `lembaga` (`id`, `nama`, `tingkat`, `jenis`, `fakultas_id`, `parent_id`, `is_aktif`, `created_at`, `updated_at`) VALUES
  (1, 'Lembaga Khusus Universitas', 'universitas', 'lembaga_khusus', NULL, NULL, 1, '2026-11-07 19:44:33', '2026-11-07 19:44:33'),
  (2, 'DPM Universitas', 'universitas', 'dpm', NULL, NULL, 1, '2026-11-07 19:44:34', '2026-11-07 19:44:34'),
  (3, 'LEM Universitas', 'universitas', 'lem', NULL, NULL, 1, '2026-11-07 19:44:36', '2026-11-07 19:44:36'),
  (4, 'Mapala UII', 'universitas', 'lembaga_khusus', NULL, NULL, 1, '2026-11-07 19:44:37', '2026-11-07 19:44:37'),
  (5, 'Himmah UII', 'universitas', 'lembaga_khusus', NULL, NULL, 1, '2026-11-07 19:44:39', '2026-11-07 19:44:39'),
  (6, 'Marching Band UII', 'universitas', 'lembaga_khusus', NULL, NULL, 1, '2026-11-07 19:44:40', '2026-11-07 19:44:40'),
  (7, 'KOPMA UII', 'universitas', 'kopma', NULL, NULL, 1, '2026-11-07 19:44:42', '2026-11-07 19:44:42'),
  (8, 'LEM FH', 'fakultas', 'lem', 1, NULL, 1, '2026-11-07 19:44:43', '2026-11-07 19:44:43'),
  (9, 'LPM FH', 'fakultas', 'lpm', 1, NULL, 1, '2026-11-07 19:44:45', '2026-11-07 19:44:45'),
  (10, 'DPM FH', 'fakultas', 'dpm', 1, NULL, 1, '2026-11-07 19:44:46', '2026-11-07 19:44:46'),
  (11, 'LEM FTI', 'fakultas', 'lem', 3, NULL, 1, '2026-11-07 19:44:48', '2026-11-07 19:44:48'),
  (12, 'LPM FTI', 'fakultas', 'lpm', 3, NULL, 1, '2026-11-07 19:44:49', '2026-11-07 19:44:49'),
  (13, 'DPM FTI', 'fakultas', 'dpm', 3, NULL, 1, '2026-11-07 19:44:51', '2026-11-07 19:44:51');

INSERT INTO `mahasiswa_fakultas` (`id`, `periode_id`, `fakultas_id`, `jumlah_mahasiswa`, `created_at`, `updated_at`) VALUES
  (1, 3, 1, 3408, '2026-11-07 19:46:29', '2026-11-07 19:46:29'),
  (2, 3, 3, 2843, '2026-11-07 19:46:31', '2026-11-07 19:46:31'),
  (3, 3, 4, 2100, '2026-11-07 19:46:34', '2026-11-07 19:46:34'),
  (4, 3, 5, 1800, '2026-11-07 19:46:36', '2026-11-07 19:46:36'),
  (5, 3, 6, 1600, '2026-11-07 19:46:39', '2026-11-07 19:46:39'),
  (8, 3, 9, 629, '2026-11-07 19:46:46', '2026-11-07 19:46:46'),
  (9, 3, 11, 3441, '2026-11-07 21:14:10', '2026-11-07 21:14:10'),
  (10, 3, 12, 2213, '2026-11-07 21:14:17', '2026-11-07 21:14:17'),
  (6, 3, 7, 805, '2026-11-07 19:46:41', '2026-11-07 21:14:20'),
  (7, 3, 8, 1464, '2026-11-07 19:46:44', '2026-11-07 21:14:22'),
  (11, 3, 13, 1334, '2026-11-07 21:14:24', '2026-11-07 21:14:24'),
  (12, 3, 14, 2055, '2026-11-07 21:14:27', '2026-11-07 21:14:27');

INSERT INTO `media` (`id`, `name`, `file_path`, `mime_type`, `size`, `alt_text`, `user_id`, `created_at`, `updated_at`) VALUES
  (1, 'BEBAS Bunny Snack Mascot Logo.png', 'uploads/2026/11/613d8af4-f0d2-4569-8127-e8a21a6c53d7.png', 'image/png', 1599277, NULL, 1, '2026-11-07 16:53:12', '2026-11-07 16:53:12');

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

INSERT INTO `officials` (`id`, `organizational_unit_id`, `period_id`, `name`, `position`, `photo_path`, `email`, `instagram`, `linkedin`, `sort_order`, `is_active`, `created_at`, `updated_at`, `description`, `fakultas`, `prodi`, `angkatan`, `nim`) VALUES
  (1, 1, 4, 'Troy Amirul Akhmad', 'Ketua Umum', 'uploads/fungsionaris/pimpinan-dewan/32a65320-20aa-4fc8-aebe-3de4edf4f063.jpg', '23215075@students.uii.ac.id', 'https://www.instagram.com/dpmub/', 'https://www.instagram.com/dpp/', 1, 1, '2026-11-06 15:06:50', '2026-11-08 07:19:53', NULL, 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215075'),
  (2, 2, 4, 'Dimas Andika Putra', 'Kepala MENTARI', NULL, NULL, NULL, NULL, 1, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2024', '24215039'),
  (3, 2, 4, 'Siti Maghfira Lahinta', 'Koordinator Biro Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 2, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Psikologi', NULL, '2023', '23320242'),
  (4, 2, 4, 'Ilham Juluborita', 'Staf Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 3, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2024', '24311094'),
  (5, 2, 4, 'Fathya Adya Farahdiba', 'Staf Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 4, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Ilmu Sosial Budaya', NULL, '2025', '25323135'),
  (6, 2, 4, 'Imawan Caesar Wahyudi', 'Staf Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 5, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Ilmu Sosial Budaya', NULL, '2024', '24321304'),
  (7, 2, 4, 'Yanuar Farrel Yudistira', 'Kabiro Media dan Inventaris', NULL, NULL, NULL, NULL, 6, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2024', '24215016'),
  (8, 2, 4, 'Nurul Ayu Afiah', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 7, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2025', '25215042'),
  (9, 2, 4, 'Laras Fadhilatul Amaro', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 8, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2025', '25214152'),
  (10, 2, 4, 'Najwa Fauziah Ismail', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 9, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Hukum', NULL, '2025', '25410044'),
  (11, 2, 4, 'Muhammad Dzaky Abdurrahman', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 10, 1, '2026-11-08 06:36:07', '2026-11-08 07:16:00', NULL, 'Bisnis dan Ekonomika', NULL, '2025', '25311205'),
  (12, 1, 4, 'Asep Subagya', 'Sekretaris Jenderal', NULL, '23215044@students.uii.ac.id', NULL, NULL, 2, 1, '2026-11-08 07:05:17', '2026-11-08 07:05:17', NULL, 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215044'),
  (13, 1, 4, 'Annisa Fidanta Shafir', 'Ketua Komisi', NULL, '23215020@students.uii.ac.id', NULL, NULL, 3, 1, '2026-11-08 07:05:29', '2026-11-08 07:05:29', NULL, 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215020');

INSERT INTO `organizational_units` (`id`, `parent_id`, `type`, `name`, `slug`, `description`, `logo_path`, `sort_order`, `is_active`, `created_at`, `updated_at`, `abbreviation`, `tasks`, `work_programs`, `email`) VALUES
  (1, NULL, 'pimpinan', 'Pimpinan Dewan', 'pimpinan-dewan', NULL, NULL, 1, 1, '2026-11-02 04:29:53', '2026-11-02 04:29:53', NULL, NULL, NULL, NULL),
  (2, NULL, 'lembaga', 'Mentari', 'mentari', NULL, NULL, 2, 1, '2026-11-02 04:29:55', '2026-11-02 04:29:55', 'Mentari', NULL, NULL, NULL),
  (3, NULL, 'badan', 'Badan Legislasi', 'badan-legislasi', NULL, NULL, 3, 1, '2026-11-02 04:29:57', '2026-11-02 04:29:57', 'Baleg', NULL, NULL, NULL),
  (4, NULL, 'badan', 'Badan Pengawasan', 'badan-pengawasan', NULL, NULL, 4, 1, '2026-11-02 04:29:59', '2026-11-02 04:29:59', 'Bawas', NULL, NULL, NULL),
  (6, NULL, 'badan', 'Badan Audit Kemahasiswaan', 'badan-audit-kemahasiswaan', NULL, NULL, 6, 1, '2026-11-02 04:30:04', '2026-11-02 04:30:04', 'BAK', NULL, NULL, NULL),
  (7, NULL, 'badan', 'Badan Pengelola Aset', 'badan-pengelola-aset', NULL, NULL, 7, 1, '2026-11-02 04:30:06', '2026-11-02 04:30:06', 'BPA', NULL, NULL, NULL),
  (5, NULL, 'badan', 'Badan Kerjasama, Advokasi, dan Jaringan', 'badan-kerjasama-advokasi-dan-jaringan', NULL, NULL, 5, 1, '2026-11-02 04:30:02', '2026-11-02 04:30:02', 'Bksaj', NULL, NULL, NULL),
  (12, NULL, 'komisi', 'Komisi I', 'komisi-i', 'Bidang Hukum, Peraturan, dan Ketertiban Dewan', NULL, 10, 1, '2026-11-07 20:56:56', '2026-11-07 20:56:56', 'I', NULL, NULL, NULL),
  (13, NULL, 'komisi', 'Komisi II', 'komisi-ii', 'Bidang Anggaran, Keuangan, dan Aset Dewan', NULL, 11, 1, '2026-11-07 20:56:58', '2026-11-07 20:56:58', 'II', NULL, NULL, NULL),
  (14, NULL, 'komisi', 'Komisi III', 'komisi-iii', 'Bidang Aspirasi, Kemitraan, dan Jaringan Dewan', NULL, 12, 1, '2026-11-07 20:57:01', '2026-11-07 20:57:01', 'III', NULL, NULL, NULL),
  (15, NULL, 'komisi', 'Komisi IV', 'komisi-iv', 'Bidang SDM, Organisasi, dan Protokol Dewan', NULL, 13, 1, '2026-11-07 20:57:03', '2026-11-07 20:57:03', 'IV', NULL, NULL, NULL);

INSERT INTO `page_contents` (`id`, `key`, `title`, `subtitle`, `body`, `created_at`, `updated_at`, `signature_role`, `signature_name`, `signature_fakultas`, `signature_nim`) VALUES
  (2, 'sejarah', 'Sejarah KM UII', 'Tentang DPM UII', NULL, '2026-11-07 22:50:31', '2026-11-07 22:50:31', NULL, NULL, NULL, NULL),
  (3, 'visi-misi', 'Visi Misi', 'Tentang DPM UII', NULL, '2026-11-07 22:50:32', '2026-11-07 22:50:32', NULL, NULL, NULL, NULL),
  (4, 'struktur', 'Struktur', 'Tentang DPM UII', NULL, '2026-11-07 22:50:34', '2026-11-07 22:50:34', NULL, NULL, NULL, NULL),
  (5, 'kedudukan-tugas-wewenang', 'Kedudukan, Tugas dan Wewenang', 'Tentang DPM UII', NULL, '2026-11-07 22:50:36', '2026-11-07 22:50:36', NULL, NULL, NULL, NULL),
  (1, 'sambutan', 'Sambutan', 'Sambutan Ketua DPM UII', '<p>Assalamu’alaikum warahmatullahi wabarakatuh.</p><p>Selamat datang di portal resmi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia.</p><p>Dewan Permusyawaratan Mahasiswa UII hadir sebagai lembaga legislatif tertinggi dalam sistem pemerintahan mahasiswa. Melalui fungsi legislasi, anggaran, dan pengawasan, kami berkomitmen memastikan setiap kebijakan Keluarga Mahasiswa UII berpijak pada aspirasi mahasiswa serta prinsip tata kelola yang terbuka dan akuntabel.</p><p>Portal ini kami sediakan sebagai ruang transparansi: produk hukum, laporan keuangan, dokumen resmi, hingga kanal aspirasi dapat diakses dengan mudah oleh seluruh mahasiswa. Kami mengajak seluruh civitas akademika untuk turut mengawal kerja-kerja dewan dan menyampaikan gagasan terbaiknya.</p><p>Terima kasih atas dukungan dan kepercayaan yang diberikan. Mari bersama membangun Keluarga Mahasiswa UII yang lebih baik.</p>', '2026-11-07 22:50:29', '2026-11-08 05:34:11', 'Ketua DPM UII', 'Troy', 'Fbe', '25311205');

-- password_reset_tokens: tidak ada data

INSERT INTO `pengaturan_halaman` (`id`, `halaman`, `kunci`, `nilai`, `created_at`, `updated_at`) VALUES
  (1, 'distribusi_dana', 'hero_deskripsi', 'Transparansi distribusi dana DPM UII periode 2025/2026.', '2026-11-07 19:47:15', '2026-11-07 19:47:15'),
  (2, 'distribusi_dana', 'judul_overview', 'Ringkasan Dana', '2026-11-07 19:47:16', '2026-11-07 19:47:16'),
  (3, 'distribusi_dana', 'catatan_sumber', 'Sumber: Sekretariat Jenderal DPM UII', '2026-11-07 19:47:18', '2026-11-07 19:47:18'),
  (4, 'distribusi_dana', 'dasar_hukum', 'PDKM UII dan PDPM UII', '2026-11-07 19:47:20', '2026-11-07 19:47:20');

INSERT INTO `periods` (`id`, `name`, `starts_on`, `ends_on`, `is_active`, `created_at`, `updated_at`) VALUES
  (1, '2023/2024', '2023-09-01', '2024-08-31', 0, '2026-11-02 04:29:17', '2026-11-08 07:04:59'),
  (2, '2024/2025', '2024-09-01', '2025-08-31', 0, '2026-11-02 04:29:18', '2026-11-08 07:04:59'),
  (3, '2025/2026', '2025-09-01', '2026-08-31', 0, '2026-11-02 04:29:20', '2026-11-08 07:04:59'),
  (4, '2026/2027', '2026-09-01', '2027-08-31', 1, '2026-11-08 07:03:02', '2026-11-08 07:03:05');

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
  (11, 4, 'Ketua Umum', 'Troy Amirul Akhmad', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215075', '23215075@students.uii.ac.id', NULL, NULL, NULL, 1, 1, '2026-11-08 07:05:07', '2026-11-08 07:05:07'),
  (12, 4, 'Sekretaris Jenderal', 'Asep Subagya', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215044', '23215044@students.uii.ac.id', NULL, NULL, NULL, 2, 1, '2026-11-08 07:05:19', '2026-11-08 07:05:19'),
  (13, 4, 'Ketua Komisi', 'Annisa Fidanta Shafir', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215020', '23215020@students.uii.ac.id', NULL, NULL, NULL, 3, 1, '2026-11-08 07:05:31', '2026-11-08 07:05:31');

-- pioneering_tugas: lihat blok INSERT di bagian bawah dump

INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `body`, `status`, `published_at`, `featured_image`, `meta_title`, `meta_description`, `created_at`, `updated_at`, `type`) VALUES
  (5, 'Pelatihan Legislasi untuk Anggota DPM UII Baru', 'pelatihan-legislasi-untuk-anggota-dpm-uis-baru', 'Badan Legislasi (Baleg) mengadakan pelatihan dasar legislasi bagi anggota DPM UII periode 2025/2026.', '<p>Pelatihan berlangsung selama 2 hari dan mencakup materi: tata cara sidang, teknis drafting peraturan, dan kajian hukum dasar.</p><p>\"Kami ingin memastikan seluruh anggota memahami proses legislasi dengan baik,\" kata Ketua Baleg.</p>', 'published', '2026-10-13 05:19:32', NULL, NULL, NULL, '2026-11-02 04:34:43', '2026-11-02 05:19:47', NULL),
  (7, 'Pembukaan Lomba Karya Tulis Ilmiah (LKTI) KM UII 2025', 'pembukaan-lomba-karya-tulis-ilmiah-lkti-km-uis-2025', 'Mentari DPM UII membuka pendaftaran Lomba Karya Tulis Ilmiah tingkat KM UII tahun 2025.', '<p>Lomba ini terbuka untuk seluruh mahasiswa UII dengan tema \"Inovasi Mahasiswa untuk Kampus Berkelanjutan\". Hadiah total mencapai 20 juta rupiah.</p><p>Pendaftaran dibuka hingga 31 Oktober 2025 melalui website resmi DPM UII.</p>', 'published', '2026-09-23 05:19:32', NULL, NULL, NULL, '2026-11-02 04:34:47', '2026-11-02 05:19:49', NULL),
  (8, 'Kunjungan Kerja DPM UII ke DPM Se-Jawa Tengah', 'kunjungan-kerja-dpm-uis-ke-dpm-se-jawa-tengah', 'Delegasi DPM UII melakukan kunjungan kerja ke DPM Universitas lain di Jawa Tengah untuk silaturahmi dan sharing pengalaman.', '<p>Kunjungan dilakukan ke 4 universitas: UNDIP, UNNES, UNS, dan UGM. Bahasan meliputi penguatan legislasi mahasiswa, advokasi kebijakan, dan kerjasama antar DPM.</p>', 'published', '2026-09-13 05:19:32', NULL, NULL, NULL, '2026-11-02 04:34:50', '2026-11-02 05:19:51', NULL),
  (6, 'Audit Keuangan Lembaga KM UII Triwulan II 2024', 'audit-keuangan-lembaga-km-uis-triwulan-ii-2024', 'Badan Audit Kemahasiswaan (BAK) menyelesaikan audit keuangan lembaga-lembaga KM UII untuk triwulan II tahun 2024.', '<p>Hasil audit menunjukkan bahwa mayoritas lembaga telah mengelola dana sesuai peraturan. Beberapa temuan perbaikan telah disampaikan ke masing-masing lembaga.</p>', 'published', '2026-10-03 05:19:32', NULL, NULL, NULL, '2026-11-02 04:34:45', '2026-11-02 05:19:38', NULL),
  (4, 'Forum Aspirasi Mahasiswa Tingkat Fakultas - Gelombang I', 'forum-aspirasi-mahasiswa-tingkat-fakultas-gelombang-i', 'DPM UII melalui BKSAJ menggelar Forum Aspirasi Mahasiswa tingkat fakultas untuk menampung keluhan dan usulan mahasiswa.', '<p>Forum Aspirasi diadakan secara hybrid (online dan offline) di 8 fakultas di UII. Mahasiswa dapat menyampaikan aspirasi langsung ke wakil DPM Fakultas masing-masing.</p><p>Hasil forum akan dijadikan bahan pertimbangan dalam penyusunan program advokasi DPM UII.</p>', 'published', '2026-10-18 05:19:32', NULL, NULL, NULL, '2026-11-02 04:34:41', '2026-11-02 05:19:44', NULL),
  (3, 'Rapat Koordinasi Alat Kelengkapan Dewan Periode 2025/2026', 'rapat-koordinasi-alat-kelengkapan-dewan-periode-2025-2026', 'Ketua DPM UII memimpin rapat koordinasi seluruh alat kelengkapan dewan untuk menyelaraskan program kerja periode 2025/2026.', '<p>Rapat koordinasi dihadiri oleh ketua-ketua Baleg, Bawas, BAK, BPA, Bksaj, dan Mentari. Setiap alat kelengkapan menyampaikan rencana program kerja masing-masing.</p>', 'published', '2026-10-23 05:19:32', NULL, NULL, NULL, '2026-11-02 04:34:39', '2026-11-02 05:19:42', NULL),
  (2, 'PKM UII No. 3 Tahun 2024 Resmi Berlaku: Tentang Distribusi Dana KM UII', 'pkm-uis-no-3-tahun-2024-resmi-berlaku-tentang-distribusi-dana-km-uis', 'Peraturan Keluarga Mahasiswa Nomor 3 Tahun 2024 mengenai pengelolaan dan distribusi dana KM UII telah disahkan dan berlaku efektif.', '<p>PKM UII Nomor 3 Tahun 2024 tentang Distribusi dan Alokasi Dana KM UII telah disahkan oleh Pimpinan DPM UII pada tanggal 10 Agustus 2024.</p><p>Peraturan ini mengatur mekanisme transparan dalam pengelolaan dana Kemahasiswaan, termasuk alokasi untuk Lembaga Eksekutif, Alat Kelengkapan Dewan, dan Lembaga Khusus.</p>', 'published', '2026-10-28 05:19:32', NULL, NULL, NULL, '2026-11-02 04:34:36', '2026-11-02 05:19:35', NULL),
  (9, 'Pengumuman Penerima Beasiswa Prestasi KM UII 2024', 'pengumuman-penerima-beasiswa-prestasi-km-uis-2024', 'DPM UII melalui BPA mengumumkan daftar penerima beasiswa prestasi bagi mahasiswa berprestasi akademik dan non-akademik.', '<p>Sebanyak 25 mahasiswa menerima beasiswa prestasi tahun 2024. Seleksi dilakukan berdasarkan IPK, prestasi lomba, dan aktifitas organisasi.</p>', 'published', '2026-09-03 05:19:32', NULL, NULL, NULL, '2026-11-02 04:34:52', '2026-11-02 05:19:40', NULL),
  (1, 'DPM UII Gelar Sidang Paripurna Ke-1 Periode 2025/2026', 'dpm-uii-gelar-sidang-paripurna-ke-1-periode-2025-2026', 'Dewan Permusyawaratan Mahasiswa UII menyelenggarakan Sidang Paripurna pertama periode 2025/2026 untuk membahas program kerja dan anggaran tahunan.', '<p>Pada hari Senin, 15 September 2025, DPM UII menggelar Sidang Paripurna pertama periode 2025/2026 di Ruang Sidang DPM UII. Sidang dibuka oleh Ketua DPM UII dan dihadiri seluruh anggota dewan.</p><p>Agenda utama sidang meliputi pembahasan program kerja tahunan, anggaran pendapatan dan belanja (APB), serta penetapan struktur pengurus alat kelengkapan dewan.</p><p>\"Sidang ini menjadi momen penting untuk menyepakati arah kebijakan dewan selama satu periode ke depan,\" ujar Ketua DPM UII.</p>', 'published', '2026-10-31 05:19:32', NULL, NULL, NULL, '2026-11-02 04:34:34', '2026-11-02 05:19:33', NULL),
  (10, 'Sosialisasi PKM UII No. 3 Tahun 2024: Distribusi Dana KM UII', 'sosialisasi-pkm-uis-no-3-tahun-2024-distribusi-dana-km-uis', 'Badan Legislasi menggelar sosialisasi PKM Nomor 3 Tahun 2024 mengenai pengelolaan dan distribusi dana KM UII kepada seluruh lembaga.', '<p>Sosialisasi diadakan secara hybrid di Ruang Sidang DPM UII dan via Zoom. Peserta meliputi bendahara dan ketua keuangan seluruh lembaga KM UII.</p><p>Materi meliputi: alur pengajuan dana, mekanisme pencairan, pertanggungjawaban (LPJ), dan sanksi pelanggaran.</p>', 'published', '2026-10-30 05:19:32', NULL, NULL, NULL, '2026-11-02 04:49:03', '2026-11-02 05:19:53', 'peraturan'),
  (11, 'Sosialisasi Perubahan PKM Pedoman Administrasi KM UII', 'sosialisasi-perubahan-pkm-pedoman-administrasi-km-uis', 'Baleg mengadakan sosialisasi perubahan PKM tentang pedoman administrasi bagi seluruh pengurus alat kelengkapan dewan.', '<p>Sosialisasi difokuskan pada pasal-pasal yang berubah terkait tata kelola administrasi dewan dan alat kelengkapan.</p>', 'published', '2026-10-21 05:19:32', NULL, NULL, NULL, '2026-11-02 04:49:05', '2026-11-02 05:19:56', 'peraturan'),
  (13, 'Sosialisasi Program Magang Mahasiswa DPM UII Batch 2', 'sosialisasi-program-magang-mahasiswa-dpm-uis-batch-2', 'Mentari membuka pendaftaran program magang di sekretariat DPM UII untuk mahasiswa tingkat 1-3.', '<p>Program magang bertujuan memberikan pengalaman kerja nyata di lingkungan parlemen mahasiswa. Durasi 3 bulan dengan sertifikat resmi.</p>', 'published', '2026-10-15 05:19:32', NULL, NULL, NULL, '2026-11-02 04:49:10', '2026-11-02 05:20:00', 'program'),
  (14, 'Sosialisasi Program Beasiswa Prestasi KM UII 2025', 'sosialisasi-program-beasiswa-prestasi-km-uis-2025', 'BPA menggelar sosialisasi program beasiswa prestasi tahun 2025 bagi mahasiswa berprestasi.', '<p>Sosialisasi menjelaskan kriteria seleksi, jenis beasiswa, nilai hadiah, dan tata cara pendaftaran melalui sistem online.</p>', 'published', '2026-10-08 05:19:32', NULL, NULL, NULL, '2026-11-02 04:49:12', '2026-11-02 05:20:02', 'program'),
  (15, 'Sosialisasi Kegiatan Konsolidasi Aksi Mahasiswa UII', 'sosialisasi-kegiatan-konsolidasi-aksi-mahasiswa-uis', 'DPM UII menggelar sosialisasi terkait konsolidasi aksi mahasiswa menyambut HARDIKNAS.', '<p>Sosialisasi dibuka untuk seluruh ormawa dan mahasiswa UII. Membahas rundown acara, aturan partisipasi, dan koordinasi keamanan.</p>', 'published', '2026-10-27 05:19:32', NULL, NULL, NULL, '2026-11-02 04:49:15', '2026-11-02 05:20:04', 'lainnya'),
  (12, 'Sosialisasi Kebijakan Baru: Advokasi Keringanan UKT Mahasiswa', 'sosialisasi-kebijakan-baru-adovkasi-keringanan-ukt-mahasiswa', 'BKSAJ menggelar sosialisasi kebijakan advokasi keringanan UKT bagi mahasiswa terdampak ekonomi.', '<p>Kebijakan ini merupakan hasil advokasi DPM UII kepada Rektorat UII. Sosialisasi menjelaskan syarat, prosedur pengajuan, dan jadwal verifikasi.</p>', 'published', '2026-10-25 05:19:32', NULL, NULL, NULL, '2026-11-02 04:49:07', '2026-11-02 05:19:58', 'kebijakan');

INSERT INTO `profil_dewans` (`id`, `nama_lengkap`, `nim`, `fakultas`, `program_studi`, `angkatan`, `email_kampus`, `jabatan`, `unit_kerja`, `periode`, `masa_jabatan`, `status`, `bio`, `tugas_tanggung_jawab`, `instagram`, `email`, `created_at`, `updated_at`) VALUES
  (1, 'Rizky Ananda', '202024001', 'Fakultas Hukum', 'Ilmu Hukum', '2020', 'rizy@uii.ac.id', 'Ketua Komisi I', 'Dewan Permusyawaratan Mahasiswa', '2025/2026', '1 Juni 2025 - 31 Mei 2027', 'Selesai', 'Mahasiswa aktif Fakultas Hukum UII, terpilih sebagai Ketua Komisi I DPM UII periode 2025/2026.', 'Memimpin dan mengoordinasikan kerja Komisi I, melakukan Laporan Kinerja pada Sidang Pleno DPM UII, berkoordinasi dengan alat kelengkapan dewan dan pimpinan.', 'https://instagram.com/rizy.ananda', 'rizy@uii.ac.id', '2026-11-07 16:55:02', '2026-11-08 07:28:00'),
  (2, 'Aulia Rahmawati', '202024002', 'Fakultas Hukum', 'Ilmu Hukum', '2023', 'aulia@uii.ac.id', 'Sekretaris Jendral', 'Dewan Permusyawaratan Mahasiswa', '2025/2026', '1 Juni 2025 - 31 Mei 2027', 'Selesai', 'Mahasiswa aktif Fakultas Hukum UII, menjabat sebagai Sekretaris Jendral DPM UII periode 2025/2026.', 'Menyusun rapat dan meeting, mencatat keputusan plenog, melakukan pengarsipan dokumen resmi DPM UII.', 'https://instagram.com/aulia.rahmawati', 'aulia@uii.ac.id', '2026-11-07 16:55:08', '2026-11-08 07:28:00'),
  (3, 'Farhan Hidayat', '202024003', 'Fakultas Ilmu Agama Islam', 'Hukum Ekonomi Syariah', '2024', 'farhan@uii.ac.id', 'Anggota Komisi I', 'Dewan Permusyawaratan Mahasiswa', '2025/2026', '1 Juni 2025 - 31 Mei 2027', 'Selesai', 'Mahasiswa aktif Fakultas Ilmu Agama Islam UII, menjadi anggota Komisi I DPM UII periode 2025/2026.', 'Membantu koordinasi kerja Komisi I, melakukan penelitian dan studi kasus sesuai bidang tugas.', 'https://instagram.com/farhan.hidayat', 'farhan@uii.ac.id', '2026-11-07 16:55:09', '2026-11-08 07:28:00'),
  (4, 'Fikri Maulana', '202023001', '', '', '', 'fikri@uii.ac.id', 'Ketua Umum', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 Juni 2024 - 31 Mei 2026', 'Selesai', 'Mengelola seluruh kegiatan DPM UII periode 2024/2025.', 'Mendorong berjalannya program-program DPM UII, melakukan koordinasi dengan seluruh unit kerja dan alat kelengkapan.', 'https://instagram.com/fikri.maulana', 'fikri@uii.ac.id', '2026-11-07 16:55:10', '2026-11-07 16:55:10'),
  (5, 'Intan Permata', '202023002', '', '', '', 'intan@uii.ac.id', 'Sekretaris Jendral', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 Juni 2024 - 31 Mei 2026', 'Selesai', 'Mengatur administrasi dan sekretariat DPM UII periode 2024/2025.', 'Menyusun berita acara, mengurus surat menyurat DPM UII, serta menyelenggarakan rapat plenipoten.', 'https://instagram.com/intan.permata', 'intan@uii.ac.id', '2026-11-07 16:55:11', '2026-11-07 16:55:11'),
  (6, 'Raka Wirawan', '202023003', 'Fakultas Teknologi Industri', 'Teknik Industri', '2023', 'raka@uii.ac.id', 'Ketua Komisi II', 'Dewan Permusyawaratan Mahasiswa', '2024/2025', '1 Juni 2024 - 31 Mei 2026', 'Selesai', 'MimpinKomisi II untuk memperbaiki tata tertib dan kerangka kerja komisi.', 'Mengarahkan anggota Komisi II, melakukan evaluasi kerja rutin, serta melaporkan hasil komisi pada sidang plenog.', 'https://instagram.com/raka.wirawan', 'raka@uii.ac.id', '2026-11-07 16:55:11', '2026-11-07 16:55:11'),
  (7, 'Troy Amirul Akhmad', '23215075', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215075@students.uii.ac.id', 'Ketua Umum', 'Dewan Permusyawaratan Mahasiswa', '2026/2027', 'Belum terverifikasi', 'Aktif', NULL, 'Memimpin dan mengoordinasikan seluruh pelaksanaan tugas serta fungsi DPM UII.\nMengarahkan penyelenggaraan fungsi legislasi, anggaran, dan pengawasan DPM UII.\nMewakili DPM UII dalam hubungan kelembagaan dengan LEM UII dan pihak terkait.\nMengawasi pelaksanaan program kerja dan kinerja seluruh alat kelengkapan dewan.', NULL, '23215075@students.uii.ac.id', '2026-11-08 07:05:02', '2026-11-08 07:05:02'),
  (8, 'Asep Subagya', '23215044', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215044@students.uii.ac.id', 'Sekretaris Jenderal', 'Dewan Permusyawaratan Mahasiswa', '2026/2027', 'Belum terverifikasi', 'Aktif', NULL, 'Mengelola administrasi kesekretariatan, agenda rapat, pencatatan, dan pengarsipan dokumen resmi DPM UII.\nMengoordinasikan administrasi dan pelaporan hasil kerja seluruh alat kelengkapan dewan.\nMemastikan kelancaran komunikasi, koordinasi, dan dokumentasi antara pimpinan, komisi, serta unit kerja DPM UII.\nMenyampaikan hasil pelaksanaan administrasi dan kesekretariatan dalam forum resmi DPM UII.', NULL, '23215044@students.uii.ac.id', '2026-11-08 07:05:14', '2026-11-08 07:05:14'),
  (9, 'Annisa Fidanta Shafir', '23215020', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215020@students.uii.ac.id', 'Ketua Komisi', 'Dewan Permusyawaratan Mahasiswa', '2026/2027', 'Belum terverifikasi', 'Aktif', NULL, 'Memimpin dan mengoordinasikan pelaksanaan tugas serta program kerja komisi.\nMengarahkan pembahasan kebijakan sesuai bidang komisi.\nMengawasi pelaksanaan tugas anggota komisi serta memastikan tercapainya target kerja.\nMenyampaikan hasil kerja dan rekomendasi komisi dalam Sidang Pleno DPM UII.', NULL, '23215020@students.uii.ac.id', '2026-11-08 07:05:26', '2026-11-08 07:05:26');

-- sessions: tidak ada data

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

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
  (1, 'Administrator', 'admin@dpm.uii.ac.id', '2026-11-02 04:28:49', '$2y$12$rT.97tm1v1i5Gd8jBtqFQ.Qxu59FFtiT88c6E5pc3NJnJPyo.yjTK', '0bZQRLuUHBvkbiJJQghqoUvTGOTJ7FosmAfp32QKJ5KgDwWF12nLfJy55BkQ', '2026-11-02 04:28:50', '2026-11-02 07:42:13');

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

SET FOREIGN_KEY_CHECKS=1;


