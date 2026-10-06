-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2026 at 12:24 PM
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
-- Database: `rtq_kawali`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_years`
--

CREATE TABLE `academic_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `academic_years`
--

INSERT INTO `academic_years` (`id`, `nama`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2026/2027', 1, '2026-04-24 02:08:27', '2026-04-24 02:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `target` enum('semua','ustadz','santri') NOT NULL DEFAULT 'semua',
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `user_id`, `judul`, `konten`, `target`, `is_pinned`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Selamat Datang di SIAKAD RTQ Kawali', 'Alhamdulillah, Sistem Informasi Akademik Pondok Pesantren RTQ Kawali kini telah resmi digunakan. Semoga bermanfaat untuk seluruh civitas akademika.', 'semua', 1, '2026-05-16 00:52:12', '2026-04-24 02:08:28', '2026-05-16 00:52:12');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `halaqah_id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','sakit','izin','alpha') NOT NULL DEFAULT 'hadir',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `discipline_notes`
--

CREATE TABLE `discipline_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `halaqah_id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `tipe` enum('pelanggaran','prestasi') NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `poin` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dormitories`
--

CREATE TABLE `dormitories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dormitories`
--

INSERT INTO `dormitories` (`id`, `nama`, `kapasitas`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'Asrama Al-Fatih', 20, 'Asrama putra lantai 1', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(2, 'Asrama Al-Amin', 15, 'Asrama putra lantai 2', '2026-04-24 02:08:27', '2026-04-24 02:08:27');

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
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `halaqah_id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `tipe` enum('tugas','uts','uas','harian') NOT NULL DEFAULT 'harian',
  `nilai` decimal(5,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hafalan_exams`
--

CREATE TABLE `hafalan_exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `halaqah_id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `kategori` enum('per_juz','semester','bulanan') NOT NULL,
  `juz` int(11) DEFAULT NULL,
  `surat_mulai` varchar(255) DEFAULT NULL,
  `ayat_mulai` int(11) DEFAULT NULL,
  `surat_selesai` varchar(255) DEFAULT NULL,
  `ayat_selesai` int(11) DEFAULT NULL,
  `nilai_bacaan` int(11) NOT NULL DEFAULT 0,
  `nilai_hafalan` int(11) NOT NULL DEFAULT 0,
  `catatan` text DEFAULT NULL,
  `evaluasi` text DEFAULT NULL,
  `tanggal_ujian` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hafalan_exams`
--

INSERT INTO `hafalan_exams` (`id`, `halaqah_id`, `santri_id`, `kategori`, `juz`, `surat_mulai`, `ayat_mulai`, `surat_selesai`, `ayat_selesai`, `nilai_bacaan`, `nilai_hafalan`, `catatan`, `evaluasi`, `tanggal_ujian`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'per_juz', 20, 'Al ankbaut', 1, 'rum', 20, 99, 50, 'jangan tolol', 'bagus', '2026-04-24', '2026-04-24 02:33:28', '2026-04-24 02:33:28');

-- --------------------------------------------------------

--
-- Table structure for table `hafalan_journals`
--

CREATE TABLE `hafalan_journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `halaqah_id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` enum('ziyadah','murojaah') NOT NULL,
  `surat` varchar(255) DEFAULT NULL,
  `ayat_mulai` int(11) DEFAULT NULL,
  `ayat_selesai` int(11) DEFAULT NULL,
  `juz` int(11) DEFAULT NULL,
  `kualitas` enum('mumtaz','jayyid_jiddan','jayyid','maqbul','perlu_perbaikan') NOT NULL DEFAULT 'jayyid',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hafalan_journals`
--

INSERT INTO `hafalan_journals` (`id`, `halaqah_id`, `santri_id`, `tanggal`, `jenis`, `surat`, `ayat_mulai`, `ayat_selesai`, `juz`, `kualitas`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-04-24', 'ziyadah', 'Al Baqarah Sampai Ali Imran', NULL, NULL, 1, 'jayyid', NULL, '2026-04-24 02:32:13', '2026-04-24 02:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `halaqahs`
--

CREATE TABLE `halaqahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED NOT NULL,
  `ustadz_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `halaqahs`
--

INSERT INTO `halaqahs` (`id`, `semester_id`, `ustadz_id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Halaqah Al-Fatih', '2026-04-24 02:08:28', '2026-04-24 02:08:28'),
(2, 1, 2, 'Halaqah Al-Amin', '2026-04-24 02:08:28', '2026-04-24 02:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `halaqah_santri`
--

CREATE TABLE `halaqah_santri` (
  `halaqah_id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `halaqah_santri`
--

INSERT INTO `halaqah_santri` (`halaqah_id`, `santri_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-04-24 02:08:28', '2026-04-24 02:08:28'),
(1, 2, '2026-04-24 02:08:28', '2026-04-24 02:08:28'),
(2, 3, '2026-04-24 02:08:28', '2026-04-24 02:08:28'),
(2, 5, '2026-04-30 02:47:19', '2026-04-30 02:47:19');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_01_000001_create_ppdb_registrations_table', 1),
(5, '2026_04_01_155605_create_app_settings_table', 1),
(6, '2026_04_01_155606_add_seleksi_columns_to_ppdb_registrations_table', 1),
(7, '2026_04_02_000001_add_hasil_seleksi_to_ppdb_registrations', 1),
(8, '2026_04_06_000001_add_siakad_roles_to_users', 1),
(9, '2026_04_06_000002_create_academic_years_table', 1),
(10, '2026_04_06_000003_create_semesters_table', 1),
(11, '2026_04_06_000004_create_subject_categories_table', 1),
(12, '2026_04_06_000005_create_subjects_table', 1),
(13, '2026_04_06_000006_create_dormitories_table', 1),
(14, '2026_04_06_000007_create_ustadzs_table', 1),
(15, '2026_04_06_000008_create_santris_table', 1),
(16, '2026_04_06_000009_create_halaqahs_table', 1),
(17, '2026_04_06_000010_create_halaqah_santri_table', 1),
(18, '2026_04_06_000011_create_attendances_table', 1),
(19, '2026_04_06_000012_create_grades_table', 1),
(20, '2026_04_06_000013_create_hafalan_journals_table', 1),
(21, '2026_04_06_000014_create_discipline_notes_table', 1),
(22, '2026_04_06_000015_create_announcements_table', 1),
(23, '2026_04_12_000001_add_foto_to_santris_table', 1),
(24, '2026_04_13_000001_add_rfid_uid_to_santris_table', 1),
(25, '2026_04_13_000002_create_prayer_attendances_table', 1),
(26, '2026_04_13_000003_create_santri_permissions_table', 1),
(27, '2026_04_24_000001_create_hafalan_exams_table', 2),
(28, '2026_05_04_100000_add_jam_to_santri_permissions_table', 3),
(29, '2026_05_16_000001_add_hafalan_stage_to_santris_table', 4);

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
-- Table structure for table `ppdb_registrations`
--

CREATE TABLE `ppdb_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL DEFAULT '2026/2027',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_pembayaran` enum('belum_upload','menunggu_verifikasi','diterima','ditolak') NOT NULL DEFAULT 'belum_upload',
  `alasan_tolak_pembayaran` text DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `asal_sekolah` varchar(255) DEFAULT NULL,
  `nisn` varchar(255) DEFAULT NULL,
  `pernah_hafal_quran` tinyint(1) NOT NULL DEFAULT 0,
  `jumlah_hafalan` varchar(255) DEFAULT NULL,
  `anak_ke` int(11) DEFAULT NULL,
  `jumlah_saudara` int(11) DEFAULT NULL,
  `nama_ayah` varchar(255) DEFAULT NULL,
  `pekerjaan_ayah` varchar(255) DEFAULT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `pekerjaan_ibu` varchar(255) DEFAULT NULL,
  `alamat_rumah` text DEFAULT NULL,
  `status_data_diri` enum('belum_isi','draft','selesai') NOT NULL DEFAULT 'belum_isi',
  `no_hp_ayah` varchar(255) DEFAULT NULL,
  `no_hp_ibu` varchar(255) DEFAULT NULL,
  `status_kontak` enum('belum_isi','selesai') NOT NULL DEFAULT 'belum_isi',
  `kartu_keluarga` varchar(255) DEFAULT NULL,
  `foto_3x4` varchar(255) DEFAULT NULL,
  `ijazah_raport` varchar(255) DEFAULT NULL,
  `status_berkas` enum('belum_upload','draft','selesai') NOT NULL DEFAULT 'belum_upload',
  `finalisasi_at` timestamp NULL DEFAULT NULL,
  `status_verifikasi` enum('belum_diajukan','menunggu_verifikasi_berkas','perlu_perbaikan','terverifikasi') NOT NULL DEFAULT 'belum_diajukan',
  `catatan_perbaikan` text DEFAULT NULL,
  `nomor_peserta` varchar(255) DEFAULT NULL,
  `hasil_seleksi_pdf` varchar(255) DEFAULT NULL,
  `hasil_seleksi_status` enum('belum_tersedia','tersedia') NOT NULL DEFAULT 'belum_tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ppdb_registrations`
--

INSERT INTO `ppdb_registrations` (`id`, `user_id`, `tahun_ajaran`, `bukti_pembayaran`, `status_pembayaran`, `alasan_tolak_pembayaran`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `asal_sekolah`, `nisn`, `pernah_hafal_quran`, `jumlah_hafalan`, `anak_ke`, `jumlah_saudara`, `nama_ayah`, `pekerjaan_ayah`, `nama_ibu`, `pekerjaan_ibu`, `alamat_rumah`, `status_data_diri`, `no_hp_ayah`, `no_hp_ibu`, `status_kontak`, `kartu_keluarga`, `foto_3x4`, `ijazah_raport`, `status_berkas`, `finalisasi_at`, `status_verifikasi`, `catatan_perbaikan`, `nomor_peserta`, `hasil_seleksi_pdf`, `hasil_seleksi_status`, `created_at`, `updated_at`) VALUES
(1, 4, '2026/2027', 'dummy/bukti.pdf', 'diterima', NULL, 'Ahmad Fadhil', 'Ciamis', '2012-03-15', 'SD Negeri 1 Kawali', '0012345678', 0, NULL, NULL, NULL, 'Budi Santoso', 'Wiraswasta', 'Siti Aminah', 'Ibu Rumah Tangga', 'Jl. Raya Kawali No. 123', 'selesai', '6281200001111', '6281200002222', 'selesai', 'dummy/kk.pdf', 'dummy/foto.jpg', 'dummy/ijazah.pdf', 'selesai', '2026-05-11 00:52:10', 'menunggu_verifikasi_berkas', NULL, NULL, NULL, 'belum_tersedia', '2026-04-24 02:08:26', '2026-05-16 00:52:10'),
(2, 5, '2026/2027', 'dummy/bukti.pdf', 'diterima', NULL, 'Muhammad Rizki', 'Tasikmalaya', '2012-07-22', 'SD IT Al-Falah', '0012345679', 1, '5 Juz', NULL, NULL, 'Irfan', 'PNS', 'Rina', 'Guru', 'Jl. Siliwangi No. 45', 'selesai', '6281300001111', '6281300002222', 'selesai', 'dummy/kk.pdf', 'dummy/foto.jpg', 'dummy/ijazah.pdf', 'selesai', '2026-05-13 00:52:10', 'terverifikasi', NULL, 'PPDB-2026-0001', NULL, 'belum_tersedia', '2026-04-24 02:08:27', '2026-05-16 00:52:10'),
(3, 6, '2026/2027', 'dummy/bukti.pdf', 'diterima', NULL, 'Hafizh Albani', 'Bandung', '2013-01-10', 'SD Al-Irsyad', '0012345680', 0, NULL, NULL, NULL, 'Rahman', 'Pedagang', 'Nisa', 'Ibu Rumah Tangga', 'Jl. Merdeka No. 10', 'selesai', '6281400001111', '6281400002222', 'selesai', 'dummy/kk.pdf', 'dummy/foto.jpg', 'dummy/ijazah.pdf', 'selesai', '2026-05-14 00:52:10', 'perlu_perbaikan', 'Foto 3x4 terlalu buram, mohon upload ulang dengan kualitas lebih baik.', NULL, NULL, 'belum_tersedia', '2026-04-24 02:08:27', '2026-05-16 00:52:10'),
(4, 7, '2026/2027', 'dummy/bukti.pdf', 'diterima', NULL, 'Zahra Aisyah', 'Ciamis', '2012-11-05', 'SD Negeri 2 Kawali', '0012345681', 0, NULL, NULL, NULL, 'Dani', 'Petani', 'Dewi', 'Pedagang', 'Kp. Cikaret RT 01/02', 'selesai', NULL, NULL, 'belum_isi', NULL, NULL, NULL, 'belum_upload', NULL, 'belum_diajukan', NULL, NULL, NULL, 'belum_tersedia', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(5, 8, '2026/2027', 'dummy/bukti.pdf', 'diterima', NULL, 'Yusuf Ramadhan', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'draft', NULL, NULL, 'belum_isi', NULL, NULL, NULL, 'belum_upload', NULL, 'belum_diajukan', NULL, NULL, NULL, 'belum_tersedia', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(6, 18, '2026/2027', NULL, 'belum_upload', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'belum_isi', NULL, NULL, 'belum_isi', NULL, NULL, NULL, 'belum_upload', NULL, 'belum_diajukan', NULL, NULL, NULL, 'belum_tersedia', '2026-04-30 03:03:23', '2026-04-30 03:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `prayer_attendances`
--

CREATE TABLE `prayer_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `waktu_shalat` enum('subuh','dzuhur','ashar','maghrib','isya') NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','terlambat') NOT NULL DEFAULT 'hadir',
  `metode` enum('rfid','manual') NOT NULL DEFAULT 'rfid',
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `santris`
--

CREATE TABLE `santris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `asal_sekolah` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nama_ayah` varchar(255) DEFAULT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `telepon_wali` varchar(255) DEFAULT NULL,
  `dormitory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rfid_uid` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif','lulus','pindah') NOT NULL DEFAULT 'aktif',
  `hafalan_stage` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `santris`
--

INSERT INTO `santris` (`id`, `user_id`, `nis`, `nama_lengkap`, `foto`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `asal_sekolah`, `alamat`, `nama_ayah`, `nama_ibu`, `telepon_wali`, `dormitory_id`, `rfid_uid`, `status`, `hafalan_stage`, `created_at`, `updated_at`) VALUES
(1, 11, '20260101', 'Ibrahim Malik', NULL, 'Ciamis', '2013-05-12', 'laki-laki', NULL, NULL, 'Malik', 'Fatimah', NULL, 1, NULL, 'aktif', 4, '2026-04-24 02:08:28', '2026-05-16 00:53:33'),
(2, 12, '20260102', 'Zaid Abdurrahman', NULL, 'Tasikmalaya', '2013-08-20', 'laki-laki', NULL, NULL, 'Abdurrahman', 'Khadijah', NULL, 1, NULL, 'aktif', 1, '2026-04-24 02:08:28', '2026-05-16 00:52:11'),
(3, 13, '20260103', 'Usamah Hamzah', NULL, 'Bandung', '2012-11-03', 'laki-laki', NULL, NULL, 'Hamzah', 'Aisyah', NULL, 2, NULL, 'aktif', 5, '2026-04-24 02:08:28', '2026-05-16 00:52:12'),
(4, 14, '20262026', 'Pa Haji', 'foto-santri/yp4u00tfrUJzprrdDtBJ4XW4NhiDNVYj6FxsqK38.jpg', 'Ciamis', '2006-03-09', 'laki-laki', 'Mias', 'Tasikmalaya', 'Ayahku', 'Ibuku', NULL, 2, NULL, 'aktif', NULL, '2026-04-24 02:11:03', '2026-04-24 02:11:03'),
(5, 15, '010101', 'Ahsan', 'foto-santri/kzzKIhUsXSSKKfVbYvJvV7MGLgLgl5FOxmeCHiRc.jpg', 'ciamis', '2026-04-16', 'laki-laki', 'mias', 'kawali', 'null', 'null', NULL, 2, '0976618121', 'aktif', NULL, '2026-04-30 02:45:38', '2026-04-30 02:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `santri_permissions`
--

CREATE TABLE `santri_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `santri_id` bigint(20) UNSIGNED NOT NULL,
  `jenis` enum('pulang','sakit','kegiatan','lainnya') NOT NULL,
  `alasan` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jam_keluar` time DEFAULT NULL,
  `jam_kembali` time DEFAULT NULL,
  `status` enum('diajukan','disetujui','ditolak','selesai') NOT NULL DEFAULT 'diajukan',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `catatan_ustadz` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `santri_permissions`
--

INSERT INTO `santri_permissions` (`id`, `santri_id`, `jenis`, `alasan`, `tanggal_mulai`, `tanggal_selesai`, `jam_keluar`, `jam_kembali`, `status`, `approved_by`, `catatan_ustadz`, `created_at`, `updated_at`) VALUES
(1, 5, 'pulang', 'khatam', '2026-04-30', '2026-05-06', NULL, NULL, 'selesai', 9, 'jangan telat', '2026-04-30 02:52:03', '2026-04-30 02:52:53'),
(2, 5, 'kegiatan', 'Jajan', '2026-04-30', '2026-04-30', NULL, NULL, 'selesai', 9, 'Jajan Ahad', '2026-04-30 02:54:17', '2026-05-16 00:45:39'),
(3, 4, 'lainnya', 'Ahad', '2026-05-04', '2026-05-04', '12:09:00', '12:12:00', 'selesai', 9, 'Jangan terlambat', '2026-05-04 03:00:29', '2026-05-16 00:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `academic_year_id` bigint(20) UNSIGNED NOT NULL,
  `tipe` enum('ganjil','genap') NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `academic_year_id`, `tipe`, `tanggal_mulai`, `tanggal_selesai`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'ganjil', '2026-07-14', '2026-12-20', 1, '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(2, 1, 'genap', '2027-01-04', '2027-06-15', 0, '2026-04-24 02:08:27', '2026-04-24 02:08:27');

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
('7pXq6f5hLIjU1UnUohSlDmTREWgVl0SZuxxdXeTl', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicVFxbkk1a0FUbklzcUdYbXF2OGlmWGNOSkZBOFN6cGJDTXRiMG5IdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaWFrYWQvc2FudHJpL2hhZmFsYW4/YnVsYW49NSZrYXRlZ29yaV91amlhbj1wZXJfanV6JnRhaHVuPTIwMjYiO3M6NToicm91dGUiO3M6MjE6InNpYWthZC5zYW50cmkuaGFmYWxhbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEyO30=', 1778919266),
('eeaa7TTDkvY3nxEyOJhKCUVbrV2Pmbeo3yLoFuPS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWRlVnpkY1FIRFZEV1Q4eDhXeUdZTGhYTW1GRG93M09ySDhtVTBOQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmZvcm1hc2ktcHBkYiI7czo1OiJyb3V0ZSI7czo5OiJwcGRiLmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjQwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcHBkYi9oYXNpbC1zZWxla3NpIjt9fQ==', 1790071680),
('G265ZvqRDESQGXKFSY5gXRt4hkEf5qYwo2A1EBIl', 9, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWhTSEsxVWRtQWZVN1dodUhSb1hmZ3dPUWgzVURtTU44RjdaZmtVNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaWFrYWQvdXN0YWR6L3Blcml6aW5hbiI7czo1OiJyb3V0ZSI7czoyOToic2lha2FkLnVzdGFkei5wZXJpemluYW4uaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5O30=', 1777888889),
('RzUs7yFZEKAWZeFNo7nhOkm02ddaD28h91MTYyd8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQW41WGR1em9HSkdhU0RBeXJRQlJqMDJnZkRUR0U3V09HWkozakVYYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmZvcm1hc2ktcHBkYiI7czo1OiJyb3V0ZSI7czo5OiJwcGRiLmluZm8iO319', 1777543604);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `category_id`, `kode`, `nama`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 1, 'DIN-01', 'Nahwu Shorof', 'Ilmu tata bahasa Arab', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(2, 1, 'DIN-02', 'Fiqih', 'Hukum Islam praktis', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(3, 1, 'DIN-03', 'Aqidah Akhlaq', 'Keyakinan dan budi pekerti', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(4, 2, 'TAH-01', 'Tahfidz Al-Quran', 'Hafalan Al-Quran', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(5, 2, 'TAH-02', 'Tajwid', 'Ilmu baca Al-Quran', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(6, 3, 'UMM-01', 'Matematika', NULL, '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(7, 3, 'UMM-02', 'Bahasa Indonesia', NULL, '2026-04-24 02:08:27', '2026-04-24 02:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `subject_categories`
--

CREATE TABLE `subject_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_categories`
--

INSERT INTO `subject_categories` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Diniyyah', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(2, 'Tahfidz', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(3, 'Umum', '2026-04-24 02:08:27', '2026-04-24 02:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `role` enum('admin','ustadz_ppdb','calon_santri','ustadz_halaqah','santri') DEFAULT 'calon_santri',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, '081111111111', 'admin', NULL, '$2y$12$tORG/YkX0YiNnnZqsv6zyOF4jlaSX6aNRseRMlg4e.jLyhTtLsIn6', NULL, '2026-04-24 02:08:26', '2026-05-16 00:52:09'),
(2, 'Ustadz Ahmad', NULL, '08222222222', 'ustadz_ppdb', NULL, '$2y$12$n15X7LGWmNHqNW75qAfctOuN3ib9e.DrT.lcZGb/8g.YyLqP/lnui', NULL, '2026-04-24 02:08:26', '2026-05-16 00:52:10'),
(3, 'Ustadz Bilal', NULL, '08222222233', 'ustadz_ppdb', NULL, '$2y$12$s/1CnLLKHw3hVza.58vOfunjGcGbuaV6zuhOnG7crQMvs6Yaw.Ue.', NULL, '2026-04-24 02:08:26', '2026-05-16 00:52:10'),
(4, 'Ahmad Fadhil', NULL, '08310000001', 'calon_santri', NULL, '$2y$12$zoL32WX0q2wKYLiC7at6Y.19yMMc0vFFDk8Q/8i/ttlV6rBJz.Soq', NULL, '2026-04-24 02:08:26', '2026-05-16 00:52:10'),
(5, 'Muhammad Rizki', NULL, '08310000002', 'calon_santri', NULL, '$2y$12$/qY5DoHkOnDf8tDh/eRxI.J2SpZdh87SkDFhr/dx5t9emPzVkFV/a', NULL, '2026-04-24 02:08:27', '2026-05-16 00:52:10'),
(6, 'Hafizh Albani', NULL, '08310000003', 'calon_santri', NULL, '$2y$12$e6o.vCevfjCPDHpWFUzjnOOxSLh.7La2Ew1phL0KXvaH6gmy1mz/y', NULL, '2026-04-24 02:08:27', '2026-05-16 00:52:10'),
(7, 'Zahra Aisyah', NULL, '08310000004', 'calon_santri', NULL, '$2y$12$qoHy6UfuxOoc7rcYavjfk.EDNXEYnXzWuFfHz2C0LnTqfnKqdgAce', NULL, '2026-04-24 02:08:27', '2026-05-16 00:52:11'),
(8, 'Yusuf Ramadhan', NULL, '08310000005', 'calon_santri', NULL, '$2y$12$.N0wlvZHPBX.yZfHhxhB1emcxgsVePfU/umi/UZH20FhA.l8bXRWy', NULL, '2026-04-24 02:08:27', '2026-05-16 00:52:11'),
(9, 'Ustadz Hasan', NULL, '08500000001', 'ustadz_halaqah', NULL, '$2y$12$Bp3aAIgnpJMtWqsKK6fwkOq7eJAIs98V90pqXcwcySvJWVs9n87j2', NULL, '2026-04-24 02:08:27', '2026-05-16 00:52:11'),
(10, 'Ustadz Umar', NULL, '08500000002', 'ustadz_halaqah', NULL, '$2y$12$DUpGR9Bbp2fhXQXAKUNUD.DT/vCSIh.QTWtykOcvt0CanoHVHbBi.', NULL, '2026-04-24 02:08:28', '2026-05-16 00:52:11'),
(11, 'Ibrahim Malik', NULL, 'NIS-20260101', 'santri', NULL, '$2y$12$5DpvdMVK1O2bAcbSIIYw8u/5slpjcd6dn9OX9wpW4x9owDVASmk2W', NULL, '2026-04-24 02:08:28', '2026-05-16 00:52:11'),
(12, 'Zaid Abdurrahman', NULL, 'NIS-20260102', 'santri', NULL, '$2y$12$L.BRPScSK6k706qoMM7tdeCfZhnYGv9tLiq7K3LtHQQT0IvkCWbBq', NULL, '2026-04-24 02:08:28', '2026-05-16 00:52:11'),
(13, 'Usamah Hamzah', NULL, 'NIS-20260103', 'santri', NULL, '$2y$12$mvzrFjTXHgs0dfxVqVGf4uI5qsEUnOSLIrAUTrFhXFDHzHeDX8/U6', NULL, '2026-04-24 02:08:28', '2026-05-16 00:52:12'),
(14, 'Pa Haji', NULL, 'NIS-20262026', 'santri', NULL, '$2y$12$I966E37Gyt04oW1mQoMKAOUEDjNkjvdTyUNh9pursv9FZxPoHMyCC', NULL, '2026-04-24 02:11:03', '2026-04-24 02:11:03'),
(15, 'Ahsan', NULL, 'NIS-010101', 'santri', NULL, '$2y$12$Rs3MfxpeSr2q9y5qPS2AseWTvwswPxS7NjfP.CoNI2ANiEGeA9CmO', NULL, '2026-04-30 02:45:38', '2026-04-30 02:45:38'),
(18, 'Umar Ahsan', NULL, '080000000000', 'calon_santri', NULL, '$2y$12$QHHIMJAjs23gjqGs8VMNz.kPfYKs5qnXxF.uX5lbsYJqFSaUjvPqW', NULL, '2026-04-30 03:03:22', '2026-04-30 03:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `ustadzs`
--

CREATE TABLE `ustadzs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `spesialisasi` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ustadzs`
--

INSERT INTO `ustadzs` (`id`, `user_id`, `nip`, `nama_lengkap`, `spesialisasi`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, NULL, 'Ustadz Hasan', 'Tahfidz', 'aktif', '2026-04-24 02:08:27', '2026-04-24 02:08:27'),
(2, 10, NULL, 'Ustadz Umar', 'Fiqih & Nahwu', 'aktif', '2026-04-24 02:08:28', '2026-04-24 02:08:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_years`
--
ALTER TABLE `academic_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_user_id_foreign` (`user_id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_halaqah_id_santri_id_tanggal_unique` (`halaqah_id`,`santri_id`,`tanggal`),
  ADD KEY `attendances_santri_id_foreign` (`santri_id`);

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
-- Indexes for table `discipline_notes`
--
ALTER TABLE `discipline_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discipline_notes_halaqah_id_foreign` (`halaqah_id`),
  ADD KEY `discipline_notes_santri_id_foreign` (`santri_id`);

--
-- Indexes for table `dormitories`
--
ALTER TABLE `dormitories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_halaqah_id_foreign` (`halaqah_id`),
  ADD KEY `grades_santri_id_foreign` (`santri_id`),
  ADD KEY `grades_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `hafalan_exams`
--
ALTER TABLE `hafalan_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hafalan_exams_halaqah_id_foreign` (`halaqah_id`),
  ADD KEY `hafalan_exams_santri_id_foreign` (`santri_id`);

--
-- Indexes for table `hafalan_journals`
--
ALTER TABLE `hafalan_journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hafalan_journals_halaqah_id_foreign` (`halaqah_id`),
  ADD KEY `hafalan_journals_santri_id_foreign` (`santri_id`);

--
-- Indexes for table `halaqahs`
--
ALTER TABLE `halaqahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `halaqahs_semester_id_foreign` (`semester_id`),
  ADD KEY `halaqahs_ustadz_id_foreign` (`ustadz_id`);

--
-- Indexes for table `halaqah_santri`
--
ALTER TABLE `halaqah_santri`
  ADD PRIMARY KEY (`halaqah_id`,`santri_id`),
  ADD KEY `halaqah_santri_santri_id_foreign` (`santri_id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `ppdb_registrations`
--
ALTER TABLE `ppdb_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ppdb_registrations_nomor_peserta_unique` (`nomor_peserta`),
  ADD KEY `ppdb_registrations_user_id_foreign` (`user_id`);

--
-- Indexes for table `prayer_attendances`
--
ALTER TABLE `prayer_attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prayer_attendances_santri_id_waktu_shalat_tanggal_unique` (`santri_id`,`waktu_shalat`,`tanggal`),
  ADD KEY `prayer_attendances_recorded_by_foreign` (`recorded_by`);

--
-- Indexes for table `santris`
--
ALTER TABLE `santris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `santris_nis_unique` (`nis`),
  ADD UNIQUE KEY `santris_rfid_uid_unique` (`rfid_uid`),
  ADD KEY `santris_user_id_foreign` (`user_id`),
  ADD KEY `santris_dormitory_id_foreign` (`dormitory_id`);

--
-- Indexes for table `santri_permissions`
--
ALTER TABLE `santri_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `santri_permissions_santri_id_foreign` (`santri_id`),
  ADD KEY `santri_permissions_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `semesters_academic_year_id_tipe_unique` (`academic_year_id`,`tipe`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subjects_kode_unique` (`kode`),
  ADD KEY `subjects_category_id_foreign` (`category_id`);

--
-- Indexes for table `subject_categories`
--
ALTER TABLE `subject_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `ustadzs`
--
ALTER TABLE `ustadzs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ustadzs_nip_unique` (`nip`),
  ADD KEY `ustadzs_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_years`
--
ALTER TABLE `academic_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discipline_notes`
--
ALTER TABLE `discipline_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dormitories`
--
ALTER TABLE `dormitories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hafalan_exams`
--
ALTER TABLE `hafalan_exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hafalan_journals`
--
ALTER TABLE `hafalan_journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `halaqahs`
--
ALTER TABLE `halaqahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ppdb_registrations`
--
ALTER TABLE `ppdb_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prayer_attendances`
--
ALTER TABLE `prayer_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `santris`
--
ALTER TABLE `santris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `santri_permissions`
--
ALTER TABLE `santri_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subject_categories`
--
ALTER TABLE `subject_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ustadzs`
--
ALTER TABLE `ustadzs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_halaqah_id_foreign` FOREIGN KEY (`halaqah_id`) REFERENCES `halaqahs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discipline_notes`
--
ALTER TABLE `discipline_notes`
  ADD CONSTRAINT `discipline_notes_halaqah_id_foreign` FOREIGN KEY (`halaqah_id`) REFERENCES `halaqahs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discipline_notes_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_halaqah_id_foreign` FOREIGN KEY (`halaqah_id`) REFERENCES `halaqahs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hafalan_exams`
--
ALTER TABLE `hafalan_exams`
  ADD CONSTRAINT `hafalan_exams_halaqah_id_foreign` FOREIGN KEY (`halaqah_id`) REFERENCES `halaqahs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hafalan_exams_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hafalan_journals`
--
ALTER TABLE `hafalan_journals`
  ADD CONSTRAINT `hafalan_journals_halaqah_id_foreign` FOREIGN KEY (`halaqah_id`) REFERENCES `halaqahs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hafalan_journals_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `halaqahs`
--
ALTER TABLE `halaqahs`
  ADD CONSTRAINT `halaqahs_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `halaqahs_ustadz_id_foreign` FOREIGN KEY (`ustadz_id`) REFERENCES `ustadzs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `halaqah_santri`
--
ALTER TABLE `halaqah_santri`
  ADD CONSTRAINT `halaqah_santri_halaqah_id_foreign` FOREIGN KEY (`halaqah_id`) REFERENCES `halaqahs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `halaqah_santri_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ppdb_registrations`
--
ALTER TABLE `ppdb_registrations`
  ADD CONSTRAINT `ppdb_registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prayer_attendances`
--
ALTER TABLE `prayer_attendances`
  ADD CONSTRAINT `prayer_attendances_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prayer_attendances_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `santris`
--
ALTER TABLE `santris`
  ADD CONSTRAINT `santris_dormitory_id_foreign` FOREIGN KEY (`dormitory_id`) REFERENCES `dormitories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `santris_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `santri_permissions`
--
ALTER TABLE `santri_permissions`
  ADD CONSTRAINT `santri_permissions_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `santri_permissions_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `semesters`
--
ALTER TABLE `semesters`
  ADD CONSTRAINT `semesters_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `subject_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ustadzs`
--
ALTER TABLE `ustadzs`
  ADD CONSTRAINT `ustadzs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
