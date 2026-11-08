-- =====================================================================
-- Sinkronisasi data DPM UII periode 2026/2027 ke MySQL produksi
-- Jalankan sekali di phpMyAdmin (database dpmuii_new).
-- Aman dijalankan berulang: data lama periode 2026/2027 dihapus dulu.
-- =====================================================================

-- ---------------------------------------------------------------------
-- 1. Periode kepengurusan 2026/2027
-- ---------------------------------------------------------------------
INSERT INTO `periods` (`name`, `starts_on`, `ends_on`, `is_active`, `created_at`, `updated_at`)
SELECT '2026/2027', '2026-09-01', '2027-08-31', 1, NOW(), NOW()
FROM (SELECT 1) AS dummy
WHERE NOT EXISTS (SELECT 1 FROM `periods` WHERE `name` = '2026/2027');

UPDATE `periods` SET `is_active` = 0, `updated_at` = NOW() WHERE `name` <> '2026/2027';

SET @periode := (SELECT `id` FROM `periods` WHERE `name` = '2026/2027' LIMIT 1);
UPDATE `periods` SET `is_active` = 1, `updated_at` = NOW() WHERE `id` = @periode;

SET @pimpinan := (SELECT `id` FROM `organizational_units` WHERE `slug` = 'pimpinan-dewan' LIMIT 1);
SET @mentari := (SELECT `id` FROM `organizational_units` WHERE `slug` = 'mentari' LIMIT 1);

-- ---------------------------------------------------------------------
-- 2. Pimpinan Dewan (halaman /profil-dewan dan /unit/pimpinan-dewan)
-- ---------------------------------------------------------------------
DELETE FROM `officials` WHERE `organizational_unit_id` = @pimpinan AND (`period_id` = @periode OR `nim` = '23215075');

INSERT INTO `officials`
  (`organizational_unit_id`, `period_id`, `name`, `position`, `photo_path`, `email`, `instagram`, `linkedin`, `sort_order`, `is_active`, `created_at`, `updated_at`, `description`, `fakultas`, `prodi`, `angkatan`, `nim`)
VALUES
  (@pimpinan, @periode, 'Troy Amirul Akhmad', 'Ketua Umum', 'uploads/fungsionaris/pimpinan-dewan/32a65320-20aa-4fc8-aebe-3de4edf4f063.jpg', '23215075@students.uii.ac.id', NULL, NULL, 1, 1, NOW(), NOW(), NULL, 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215075'),
  (@pimpinan, @periode, 'Asep Subagya', 'Sekretaris Jenderal', NULL, '23215044@students.uii.ac.id', NULL, NULL, 2, 1, NOW(), NOW(), NULL, 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215044'),
  (@pimpinan, @periode, 'Annisa Fidanta Shafir', 'Ketua Komisi', NULL, '23215020@students.uii.ac.id', NULL, NULL, 3, 1, NOW(), NOW(), NULL, 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215020');

-- ---------------------------------------------------------------------
-- 3. Profil Dewan (tabel profil_dewans, sumber halaman publik)
-- ---------------------------------------------------------------------
DELETE FROM `profil_dewans` WHERE `periode` = '2026/2027';

INSERT INTO `profil_dewans`
  (`nama_lengkap`, `nim`, `fakultas`, `program_studi`, `angkatan`, `email_kampus`, `jabatan`, `unit_kerja`, `periode`, `masa_jabatan`, `status`, `bio`, `tugas_tanggung_jawab`, `instagram`, `email`, `created_at`, `updated_at`)
VALUES
  ('Troy Amirul Akhmad', '23215075', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215075@students.uii.ac.id', 'Ketua Umum', 'Dewan Permusyawaratan Mahasiswa', '2026/2027', 'Belum terverifikasi', 'Aktif', NULL,
   'Memimpin dan mengoordinasikan seluruh pelaksanaan tugas serta fungsi DPM UII.\nMengarahkan penyelenggaraan fungsi legislasi, anggaran, dan pengawasan DPM UII.\nMewakili DPM UII dalam hubungan kelembagaan dengan LEM UII dan pihak terkait.\nMengawasi pelaksanaan program kerja dan kinerja seluruh alat kelengkapan dewan.',
   NULL, '23215075@students.uii.ac.id', NOW(), NOW()),
  ('Asep Subagya', '23215044', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215044@students.uii.ac.id', 'Sekretaris Jenderal', 'Dewan Permusyawaratan Mahasiswa', '2026/2027', 'Belum terverifikasi', 'Aktif', NULL,
   'Mengelola administrasi kesekretariatan, agenda rapat, pencatatan, dan pengarsipan dokumen resmi DPM UII.\nMengoordinasikan administrasi dan pelaporan hasil kerja seluruh alat kelengkapan dewan.\nMemastikan kelancaran komunikasi, koordinasi, dan dokumentasi antara pimpinan, komisi, serta unit kerja DPM UII.\nMenyampaikan hasil pelaksanaan administrasi dan kesekretariatan dalam forum resmi DPM UII.',
   NULL, '23215044@students.uii.ac.id', NOW(), NOW()),
  ('Annisa Fidanta Shafir', '23215020', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215020@students.uii.ac.id', 'Ketua Komisi', 'Dewan Permusyawaratan Mahasiswa', '2026/2027', 'Belum terverifikasi', 'Aktif', NULL,
   'Memimpin dan mengoordinasikan pelaksanaan tugas serta program kerja komisi.\nMengarahkan pembahasan kebijakan sesuai bidang komisi.\nMengawasi pelaksanaan tugas anggota komisi serta memastikan tercapainya target kerja.\nMenyampaikan hasil kerja dan rekomendasi komisi dalam Sidang Pleno DPM UII.',
   NULL, '23215020@students.uii.ac.id', NOW(), NOW());

-- Data profil periode sebelumnya ditandai selesai supaya tidak muncul lagi.
UPDATE `profil_dewans` SET `status` = 'Selesai', `updated_at` = NOW() WHERE `periode` <> '2026/2027' AND `status` = 'Aktif';

-- ---------------------------------------------------------------------
-- 4. MENTARI (10 orang, periode 2026/2027)
-- ---------------------------------------------------------------------DELETE FROM `officials` WHERE `organizational_unit_id` = @mentari;

INSERT INTO `officials`
  (`organizational_unit_id`, `period_id`, `name`, `position`, `photo_path`, `email`, `instagram`, `linkedin`, `sort_order`, `is_active`, `created_at`, `updated_at`, `description`, `fakultas`, `prodi`, `angkatan`, `nim`)
VALUES
  (@mentari, @periode, 'Dimas Andika Putra', 'Kepala MENTARI', NULL, NULL, NULL, NULL, 1, 1, NOW(), NOW(), NULL, 'Bisnis dan Ekonomika', NULL, '2024', '24215039'),
  (@mentari, @periode, 'Siti Maghfira Lahinta', 'Koordinator Biro Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 2, 1, NOW(), NOW(), NULL, 'Psikologi', NULL, '2023', '23320242'),
  (@mentari, @periode, 'Ilham Juluborita', 'Staf Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 3, 1, NOW(), NOW(), NULL, 'Bisnis dan Ekonomika', NULL, '2024', '24311094'),
  (@mentari, @periode, 'Fathya Adya Farahdiba', 'Staf Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 4, 1, NOW(), NOW(), NULL, 'Ilmu Sosial Budaya', NULL, '2025', '25323135'),
  (@mentari, @periode, 'Imawan Caesar Wahyudi', 'Staf Administrasi dan Kearsipan', NULL, NULL, NULL, NULL, 5, 1, NOW(), NOW(), NULL, 'Ilmu Sosial Budaya', NULL, '2024', '24321304'),
  (@mentari, @periode, 'Yanuar Farrel Yudistira', 'Kabiro Media dan Inventaris', NULL, NULL, NULL, NULL, 6, 1, NOW(), NOW(), NULL, 'Bisnis dan Ekonomika', NULL, '2024', '24215016'),
  (@mentari, @periode, 'Nurul Ayu Afiah', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 7, 1, NOW(), NOW(), NULL, 'Bisnis dan Ekonomika', NULL, '2025', '25215042'),
  (@mentari, @periode, 'Laras Fadhilatul Amaro', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 8, 1, NOW(), NOW(), NULL, 'Bisnis dan Ekonomika', NULL, '2025', '25214152'),
  (@mentari, @periode, 'Najwa Fauziah Ismail', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 9, 1, NOW(), NOW(), NULL, 'Hukum', NULL, '2025', '25410044'),
  (@mentari, @periode, 'Muhammad Dzaky Abdurrahman', 'Staf Media dan Inventaris', NULL, NULL, NULL, NULL, 10, 1, NOW(), NOW(), NULL, 'Bisnis dan Ekonomika', NULL, '2025', '25311205');

-- ---------------------------------------------------------------------
-- 5. Tabel admin "Pimpinan Dewan" (pimpinan_dewan + pioneered_tugas)
-- ---------------------------------------------------------------------
DELETE FROM `pimpinan_tugas` WHERE `pimpinan_dewan_id` IN (SELECT `id` FROM `pimpinan_dewan` WHERE `periode_id` = @periode);
DELETE FROM `pimpinan_dewan` WHERE `periode_id` = @periode;

INSERT INTO `pimpinan_dewan`
  (`periode_id`, `jabatan`, `nama`, `fakultas`, `prodi`, `angkatan`, `nim`, `email`, `instagram`, `linkedin`, `foto_path`, `sort_order`, `is_active`, `created_at`, `updated_at`)
VALUES
  (@periode, 'Ketua Umum', 'Troy Amirul Akhmad', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215075', '23215075@students.uii.ac.id', NULL, NULL, NULL, 1, 1, NOW(), NOW()),
  (@periode, 'Sekretaris Jenderal', 'Asep Subagya', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215044', '23215044@students.uii.ac.id', NULL, NULL, NULL, 2, 1, NOW(), NOW()),
  (@periode, 'Ketua Komisi', 'Annisa Fidanta Shafir', 'Bisnis dan Ekonomika', 'Sarjana Terapan Akuntansi Perpajakan', '2023', '23215020', '23215020@students.uii.ac.id', NULL, NULL, NULL, 3, 1, NOW(), NOW());

INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Memimpin dan mengoordinasikan seluruh pelaksanaan tugas serta fungsi DPM UII.', 1, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215075';
INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Mengarahkan penyelenggaraan fungsi legislasi, anggaran, dan pengawasan DPM UII.', 2, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215075';
INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Mewakili DPM UII dalam hubungan kelembagaan dengan LEM UII dan pihak terkait.', 3, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215075';
INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Mengawasi pelaksanaan program kerja dan kinerja seluruh alat kelengkapan dewan.', 4, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215075';

INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Mengelola administrasi kesekretariatan, agenda rapat, pencatatan, dan pengarsipan dokumen resmi DPM UII.', 1, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215044';
INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Mengoordinasikan administrasi dan pelaporan hasil kerja seluruh alat kelengkapan dewan.', 2, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215044';
INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Memastikan kelancaran komunikasi, koordinasi, dan dokumentasi antara pimpinan, komisi, serta unit kerja DPM UII.', 3, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215044';
INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Menyampaikan hasil pelaksanaan administrasi dan kesekretariatan dalam forum resmi DPM UII.', 4, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215044';

INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Memimpin dan mengoordinasikan pelaksanaan tugas serta program kerja komisi.', 1, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215020';
INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Mengarahkan pembahasan kebijakan sesuai bidang komisi.', 2, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215020';
INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Mengawasi pelaksanaan tugas anggota komisi serta memastikan tercapainya target kerja.', 3, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215020';
INSERT INTO `pimpinan_tugas` (`pimpinan_dewan_id`, `tugas`, `sort_order`, `created_at`, `updated_at`)
SELECT `id`, 'Menyampaikan hasil kerja dan rekomendasi komisi dalam Sidang Pleno DPM UII.', 4, NOW(), NOW() FROM `pimpinan_dewan` WHERE `periode_id` = @periode AND `nim` = '23215020';

-- ---------------------------------------------------------------------
-- 6. Cek hasil
-- ---------------------------------------------------------------------
SELECT `id`, `name`, `is_active` FROM `periods` ORDER BY `id`;
SELECT `name`, `position`, `nim`, `fakultas` FROM `officials` WHERE `period_id` = @periode ORDER BY `organizational_unit_id`, `sort_order`;
SELECT `nama_lengkap`, `jabatan`, `nim`, `periode` FROM `profil_dewans` WHERE `periode` = '2026/2027' ORDER BY `id`;
