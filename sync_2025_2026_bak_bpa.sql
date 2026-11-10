-- =====================================================================
-- Sinkronisasi periode 2025/2026 + BAK & BPA ke MySQL produksi
-- Jalankan sekali di phpMyAdmin (database dpmuii_new).
-- Aman dijalankan berulang: data lama dihapus dulu sebelum insert.
-- =====================================================================

-- ---------------------------------------------------------------------
-- 1. Nama periode dibenahi
--    Periode mulai 2026-09-01 -> 2026/2027
--    Periode mulai 2025-09-01 -> 2025/2026
-- ---------------------------------------------------------------------
UPDATE `periods` SET `name` = '2026/2027', `updated_at` = NOW() WHERE `starts_on` = '2026-09-01';
UPDATE `periods` SET `name` = '2025/2026', `updated_at` = NOW() WHERE `starts_on` = '2025-09-01';

-- ---------------------------------------------------------------------
-- 2. Periode aktif = 2025/2026
-- ---------------------------------------------------------------------
UPDATE `periods` SET `is_active` = 0, `updated_at` = NOW();
UPDATE `periods` SET `is_active` = 1, `updated_at` = NOW() WHERE `name` = '2025/2026';

SET @periode := (SELECT `id` FROM `periods` WHERE `name` = '2025/2026' LIMIT 1);
SET @lama := (SELECT `id` FROM `periods` WHERE `name` = '2026/2027' LIMIT 1);

SET @bak := (SELECT `id` FROM `organizational_units` WHERE `slug` = 'badan-audit-kemahasiswaan' LIMIT 1);
SET @bpa := (SELECT `id` FROM `organizational_units` WHERE `slug` = 'badan-pengelola-aset' LIMIT 1);

-- ---------------------------------------------------------------------
-- 3. Pimpinan, MENTARI, dan profil dewan masuk periode 2025/2026
-- ---------------------------------------------------------------------
UPDATE `officials` SET `period_id` = @periode, `updated_at` = NOW() WHERE `period_id` = @lama;
UPDATE `pimpinan_dewan` SET `periode_id` = @periode, `updated_at` = NOW() WHERE `periode_id` = @lama;
UPDATE `profil_dewans` SET `periode` = '2025/2026', `updated_at` = NOW() WHERE `periode` = '2026/2027';

-- ---------------------------------------------------------------------
-- 4. BAK - Badan Audit Kemahasiswaan
-- ---------------------------------------------------------------------
DELETE FROM `officials` WHERE `organizational_unit_id` = @bak
  AND `name` IN ('Hasan Basri', 'Nabila Putri', 'Adi Nugroho', 'Rika Wulandari', 'Tommy Gunawan', 'Lina Marlina', 'Yoga Pratama');

INSERT INTO `officials`
  (`organizational_unit_id`, `period_id`, `name`, `position`, `photo_path`, `email`, `instagram`, `linkedin`, `sort_order`, `is_active`, `created_at`, `updated_at`, `description`, `fakultas`, `prodi`, `angkatan`, `nim`)
VALUES
  (@bak, @periode, 'Hasan Basri', 'Ketua', NULL, 'hasan-basri@students.uii.ac.id', NULL, NULL, 1, 1, NOW(), NOW(), 'Memimpin audit keuangan seluruh lembaga KM UII', NULL, NULL, NULL, NULL),
  (@bak, @periode, 'Nabila Putri', 'Wakil Ketua', NULL, 'nabila-putri@students.uii.ac.id', NULL, NULL, 2, 1, NOW(), NOW(), 'Membantu ketua dalam perencanaan dan eksekusi audit', NULL, NULL, NULL, NULL),
  (@bak, @periode, 'Adi Nugroho', 'Sekretaris', NULL, 'adi-nugroho@students.uii.ac.id', NULL, NULL, 3, 1, NOW(), NOW(), 'Mengelola administrasi audit dan penyusunan LHA', NULL, NULL, NULL, NULL),
  (@bak, @periode, 'Rika Wulandari', 'Bendahara', NULL, 'rika-wulandari@students.uii.ac.id', NULL, NULL, 4, 1, NOW(), NOW(), 'Mengelola dana operasional Badan Audit', NULL, NULL, NULL, NULL),
  (@bak, @periode, 'Tommy Gunawan', 'Auditor Senior', NULL, 'tommy-gunawan@students.uii.ac.id', NULL, NULL, 5, 1, NOW(), NOW(), 'Melakukan audit lapangan ke lembaga-lembaga KM', NULL, NULL, NULL, NULL),
  (@bak, @periode, 'Lina Marlina', 'Auditor Junior', NULL, 'lina-marlina@students.uii.ac.id', NULL, NULL, 6, 1, NOW(), NOW(), 'Membantu pelaksanaan audit dan verifikasi dokumen', NULL, NULL, NULL, NULL),
  (@bak, @periode, 'Yoga Pratama', 'Analis Laporan', NULL, 'yoga-pratama@students.uii.ac.id', NULL, NULL, 7, 1, NOW(), NOW(), 'Menganalisis laporan keuangan dan menyusun temuan audit', NULL, NULL, NULL, NULL);

-- ---------------------------------------------------------------------
-- 5. BPA - Badan Pengelola Aset (Data Fungsionaris BPA 2026)
-- ---------------------------------------------------------------------
DELETE FROM `officials` WHERE `organizational_unit_id` = @bpa
  AND `nim` IN ('24216008', '24311030', '25320485', '25320418', '23410811', '24410667', '25410714', '24311415', '24411100', '24410767', '24311020', '25523065', '24523172', '24311422', '24411051', '25320177', '24216013', '25522223', '24311529', '24523219', '24215056');

INSERT INTO `officials`
  (`organizational_unit_id`, `period_id`, `name`, `position`, `photo_path`, `email`, `instagram`, `linkedin`, `sort_order`, `is_active`, `created_at`, `updated_at`, `description`, `fakultas`, `prodi`, `angkatan`, `nim`)
VALUES
  (@bpa, @periode, 'M. Dhavin Ghulam Fahmi', 'Presiden Direktur', NULL, '24216008@students.uii.ac.id', NULL, NULL, 1, 1, NOW(), NOW(), 'PRESDIR', 'Bisnis dan Ekonomika', 'Analisis Keuangan', '2024', '24216008'),
  (@bpa, @periode, 'Hillnandesh Bunga Nurlailla', 'Manajer PSDM', NULL, '24311030@students.uii.ac.id', NULL, NULL, 2, 1, NOW(), NOW(), 'PSDM', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311030'),
  (@bpa, @periode, 'Reyra Vania Rohmanto', 'Staf Ahli Rekrutmen', NULL, '25320485@students.uii.ac.id', NULL, NULL, 3, 1, NOW(), NOW(), 'PSDM', 'Psikologi & Ilmu Sosial Budaya', 'Psikologi', '2025', '25320485'),
  (@bpa, @periode, 'Kirana Putri Haryadi', 'Staf Ahli Penilaian', NULL, '25320418@students.uii.ac.id', NULL, NULL, 4, 1, NOW(), NOW(), 'PSDM', 'Psikologi & Ilmu Sosial Budaya', 'Psikologi', '2025', '25320418'),
  (@bpa, @periode, 'M. Islam Reshani Fekran Nabi', 'Staf Ahli Pengembangan', NULL, '23410811@students.uii.ac.id', NULL, NULL, 5, 1, NOW(), NOW(), 'PSDM', 'Hukum', 'Hukum', '2023', '23410811'),
  (@bpa, @periode, 'Mercury Aisyaharani', 'Staf Ahli Fungsionaris', NULL, '24410667@students.uii.ac.id', NULL, NULL, 6, 1, NOW(), NOW(), 'PSDM', 'Hukum', 'Hukum', '2024', '24410667'),
  (@bpa, @periode, 'Rosalina Chaca Primadani', 'Manajer GAS', NULL, '25410714@students.uii.ac.id', NULL, NULL, 7, 1, NOW(), NOW(), 'GAS', 'Hukum', 'Hukum', '2025', '25410714'),
  (@bpa, @periode, 'Zidan Prasetyo Surahman', 'Staf Ahli Warehousing Almamater dan Catering', NULL, '24311415@students.uii.ac.id', NULL, NULL, 8, 1, NOW(), NOW(), 'GAS', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311415'),
  (@bpa, @periode, 'Muhammad Rafael Harjadinata', 'Staf Ahli Pengelolaan Aset', NULL, '24411100@students.uii.ac.id', NULL, NULL, 9, 1, NOW(), NOW(), 'GAS', 'Hukum', 'Hukum Bisnis', '2024', '24411100'),
  (@bpa, @periode, 'Natasha Putri A Riyanto', 'Manajer PDP', NULL, '24410767@students.uii.ac.id', NULL, NULL, 10, 1, NOW(), NOW(), 'PDP', 'Hukum', 'Hukum', '2024', '24410767'),
  (@bpa, @periode, 'Adila Alifia', 'Staff Ahli Marketing Online & SAC', NULL, '24311020@students.uii.ac.id', NULL, NULL, 11, 1, NOW(), NOW(), 'PDP', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311020'),
  (@bpa, @periode, 'Muhammad Ziaul Haq', 'Staff Ahli Marketing Offline & Photoboot', NULL, '25523065@students.uii.ac.id', NULL, NULL, 12, 1, NOW(), NOW(), 'PDP', 'Teknologi Industri', 'Informatika', '2025', '25523065'),
  (@bpa, @periode, 'M Zaky Fathurrahman', 'Staf Ahli Publikasi (Pengembangan Website)', NULL, '24523172@students.uii.ac.id', NULL, NULL, 13, 1, NOW(), NOW(), 'PDP', 'Teknologi Industri', 'Informatika', '2024', '24523172'),
  (@bpa, @periode, 'M. Ibnu Budianto', 'Manajer SAM', NULL, '24311422@students.uii.ac.id', NULL, NULL, 14, 1, NOW(), NOW(), 'SAM', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311422'),
  (@bpa, @periode, 'Radanta Pradipa Putra Sutrisno', 'Staff CS Photobooth', NULL, '24411051@students.uii.ac.id', NULL, NULL, 15, 1, NOW(), NOW(), 'SAM', 'Hukum', 'Hukum Bisnis', '2024', '24411051'),
  (@bpa, @periode, 'Baiq Alyssa Nur Oktavia', 'Staff Inventaris Photobooth', NULL, '25320177@students.uii.ac.id', NULL, NULL, 16, 1, NOW(), NOW(), 'SAM', 'Psikologi & Ilmu Sosial Budaya', 'Psikologi', '2025', '25320177'),
  (@bpa, @periode, 'Sela Areza Utami', 'Manajer ADKEU', NULL, '24216013@students.uii.ac.id', NULL, NULL, 17, 1, NOW(), NOW(), 'ADKEU', 'Bisnis dan Ekonomika', 'Analisis Keuangan', '2024', '24216013'),
  (@bpa, @periode, 'Nurmadina A. Baba', 'Staf Ahli Outflow', NULL, '25522223@students.uii.ac.id', NULL, NULL, 18, 1, NOW(), NOW(), 'ADKEU', 'Teknologi Industri', 'Teknik Industri', '2025', '25522223'),
  (@bpa, @periode, 'M. Ridho Pasya', 'Staf Ahli Inflow', NULL, '24311529@students.uii.ac.id', NULL, NULL, 19, 1, NOW(), NOW(), 'ADKEU', 'Bisnis dan Ekonomika', 'Manajemen', '2024', '24311529'),
  (@bpa, @periode, 'Muhammad Farid', 'Staf Ahli Administrasi', NULL, '24523219@students.uii.ac.id', NULL, NULL, 20, 1, NOW(), NOW(), 'ADKEU', 'Teknologi Industri', 'Informatika', '2024', '24523219'),
  (@bpa, @periode, 'Akbar Muntaqo', 'Staf Ahli Keuangan', NULL, '24215056@students.uii.ac.id', NULL, NULL, 21, 1, NOW(), NOW(), 'ADKEU', 'Bisnis dan Ekonomika', 'Akuntansi Perpajakan', '2024', '24215056');

-- ---------------------------------------------------------------------
-- 6. Cek hasil
-- ---------------------------------------------------------------------
SELECT `id`, `name`, `starts_on`, `ends_on`, `is_active` FROM `periods` ORDER BY `id`;
SELECT `organizational_unit_id`, `period_id`, COUNT(*) AS jumlah FROM `officials` GROUP BY `organizational_unit_id`, `period_id` ORDER BY `organizational_unit_id`;
SELECT `nama_lengkap`, `jabatan`, `nim`, `periode` FROM `profil_dewans` WHERE `status` = 'Aktif' ORDER BY `id`;
