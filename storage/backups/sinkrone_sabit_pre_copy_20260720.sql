-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 103.112.245.8    Database: sinkrone_sabit
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.27-MariaDB-cll-lve-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `sinkrone_sabit`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `sinkrone_sabit` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `sinkrone_sabit`;

--
-- Table structure for table `akun_level1`
--

DROP TABLE IF EXISTS `akun_level1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akun_level1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lev1` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev2` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev3` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev4` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `kode_akun` varchar(10) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `jenis_mutasi` varchar(6) NOT NULL DEFAULT 'Debet',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `akun_level1_kode_akun_unique` (`kode_akun`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akun_level1`
--

LOCK TABLES `akun_level1` WRITE;
/*!40000 ALTER TABLE `akun_level1` DISABLE KEYS */;
/*!40000 ALTER TABLE `akun_level1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `akun_level2`
--

DROP TABLE IF EXISTS `akun_level2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akun_level2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `lev1` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev2` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev3` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev4` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `kode_akun` varchar(10) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `jenis_mutasi` varchar(6) NOT NULL DEFAULT 'Debet',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `akun_level2_kode_akun_unique` (`kode_akun`),
  KEY `akun_level2_parent_id_index` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akun_level2`
--

LOCK TABLES `akun_level2` WRITE;
/*!40000 ALTER TABLE `akun_level2` DISABLE KEYS */;
/*!40000 ALTER TABLE `akun_level2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `akun_level3`
--

DROP TABLE IF EXISTS `akun_level3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akun_level3` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `lev1` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev2` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev3` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev4` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `kode_akun` varchar(10) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `posisi` tinyint(4) NOT NULL DEFAULT 1,
  `jenis_mutasi` varchar(6) NOT NULL DEFAULT 'Debet',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `akun_level3_kode_akun_unique` (`kode_akun`),
  KEY `akun_level3_parent_id_index` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `akun_level3`
--

LOCK TABLES `akun_level3` WRITE;
/*!40000 ALTER TABLE `akun_level3` DISABLE KEYS */;
/*!40000 ALTER TABLE `akun_level3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anggota_kelas`
--

DROP TABLE IF EXISTS `anggota_kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anggota_kelas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_siswa` int(11) NOT NULL,
  `tahun_akademik` varchar(255) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `kode_kelas` varchar(255) NOT NULL,
  `tgl_masuk` varchar(255) NOT NULL,
  `tgl_keluar` varchar(255) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggota_kelas`
--

LOCK TABLES `anggota_kelas` WRITE;
/*!40000 ALTER TABLE `anggota_kelas` DISABLE KEYS */;
/*!40000 ALTER TABLE `anggota_kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calk`
--

DROP TABLE IF EXISTS `calk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calk` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `catatan` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calk_tanggal_unique` (`tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calk`
--

LOCK TABLES `calk` WRITE;
/*!40000 ALTER TABLE `calk` DISABLE KEYS */;
/*!40000 ALTER TABLE `calk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_biaya`
--

DROP TABLE IF EXISTS `jenis_biaya`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_biaya` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_jp` bigint(20) unsigned NOT NULL,
  `angkatan` varchar(255) NOT NULL,
  `total_beban` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_biaya_id_jp_foreign` (`id_jp`),
  CONSTRAINT `jenis_biaya_id_jp_foreign` FOREIGN KEY (`id_jp`) REFERENCES `jenis_pembayaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_biaya`
--

LOCK TABLES `jenis_biaya` WRITE;
/*!40000 ALTER TABLE `jenis_biaya` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_biaya` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_laporan`
--

DROP TABLE IF EXISTS `jenis_laporan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_laporan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `urut` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_laporan`
--

LOCK TABLES `jenis_laporan` WRITE;
/*!40000 ALTER TABLE `jenis_laporan` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_laporan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_pembayaran`
--

DROP TABLE IF EXISTS `jenis_pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_pembayaran` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kode_akun` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_pembayaran`
--

LOCK TABLES `jenis_pembayaran` WRITE;
/*!40000 ALTER TABLE `jenis_pembayaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_pembayaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_transaksi`
--

DROP TABLE IF EXISTS `jenis_transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_transaksi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_transaksi`
--

LOCK TABLES `jenis_transaksi` WRITE;
/*!40000 ALTER TABLE `jenis_transaksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `jenis_transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jurusan`
--

DROP TABLE IF EXISTS `jurusan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jurusan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kode_jurusan` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurusan`
--

LOCK TABLES `jurusan` WRITE;
/*!40000 ALTER TABLE `jurusan` DISABLE KEYS */;
/*!40000 ALTER TABLE `jurusan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(255) NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `tingkat` varchar(255) NOT NULL,
  `kode_kurikulum` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kurikulum`
--

DROP TABLE IF EXISTS `kurikulum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kurikulum` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kurikulum` varchar(50) DEFAULT NULL,
  `nama_kurikulum` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kurikulum_kode_kurikulum_unique` (`kode_kurikulum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kurikulum`
--

LOCK TABLES `kurikulum` WRITE;
/*!40000 ALTER TABLE `kurikulum` DISABLE KEYS */;
/*!40000 ALTER TABLE `kurikulum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2019_12_14_000001_create_personal_access_tokens_table',1),(3,'2025_12_02_014526_create_siswa_table',1),(4,'2025_12_02_021819_create_kelas_table',1),(5,'2025_12_02_022525_create_kurikulum_table',1),(6,'2025_12_02_064630_create_transaksi_table',1),(7,'2025_12_02_070158_create_tahun_akademik_table',1),(8,'2025_12_02_070528_create_anggota_kelas_table',1),(9,'2025_12_08_074853_create_jurusan_table',1),(10,'2025_12_10_062031_create_jenis_biaya_table',1),(11,'2025_12_11_031144_create_spp_table',1),(12,'2025_12_11_041937_create_ruangan_table',1),(13,'2025_12_13_025226_create_tanda_tangan_table',1),(14,'2025_12_15_012836_create_jenis_transaksi_table',1),(15,'2026_07_15_033320_create_jenis_pembayaran_table',1),(16,'2026_07_15_042502_add_soft_deletes_to_transaksi_table',1),(17,'2026_07_15_042747_add_status_to_spp_table',1),(18,'2026_07_15_105900_create_profil_table',1),(19,'2026_07_15_110000_create_akun_level1_table',1),(20,'2026_07_15_110100_create_akun_level2_table',1),(21,'2026_07_15_110200_create_akun_level3_table',1),(22,'2026_07_15_110300_create_rekening_table',1),(23,'2026_07_15_112814_create_saldo_table',1),(24,'2026_07_15_113949_drop_isspp_and_change_kode_akun_to_idjp',1),(25,'2026_07_15_120000_add_kode_kurikulum_to_kurikulum_table',1),(26,'2026_07_15_120100_create_jenis_laporan_table',1),(27,'2026_07_15_121000_rename_name_to_nama_in_users_table',1),(28,'2026_07_15_121100_add_profile_columns_to_users_table',1),(29,'2026_07_15_130000_drop_profil_columns',1),(30,'2026_07_15_140000_create_sub_laporans_table',1),(31,'2026_07_15_150000_create_calk_table',1),(32,'2026_07_16_080000_add_status_siswa_to_siswa_table',1),(33,'2026_07_16_100000_add_tgl_lunas_to_spp_table',1),(34,'2026_07_20_000000_add_kode_to_spp_table',2),(35,'2026_07_21_000000_replace_spp_id_with_kode_spp_in_transaksi_table',3),(36,'2026_07_21_010000_add_invoice_to_transaksi_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil`
--

DROP TABLE IF EXISTS `profil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profil` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telpon` varchar(30) DEFAULT NULL,
  `penanggung_jawab` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `jatuh_tempo` tinyint(3) unsigned NOT NULL DEFAULT 10,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil`
--

LOCK TABLES `profil` WRITE;
/*!40000 ALTER TABLE `profil` DISABLE KEYS */;
/*!40000 ALTER TABLE `profil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rekening`
--

DROP TABLE IF EXISTS `rekening`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekening` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `lev1` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev2` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev3` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `lev4` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `kode_akun` varchar(10) NOT NULL,
  `nama_akun` varchar(100) NOT NULL,
  `jenis_mutasi` varchar(6) NOT NULL DEFAULT 'Debet',
  `tgl_nonaktif` date DEFAULT NULL,
  `saldo` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rekening_kode_akun_unique` (`kode_akun`),
  KEY `rekening_parent_id_index` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rekening`
--

LOCK TABLES `rekening` WRITE;
/*!40000 ALTER TABLE `rekening` DISABLE KEYS */;
/*!40000 ALTER TABLE `rekening` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ruangan`
--

DROP TABLE IF EXISTS `ruangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ruangan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_gedung` varchar(255) NOT NULL,
  `kode_ruangan` varchar(255) NOT NULL,
  `nama_ruangan` varchar(255) NOT NULL,
  `kapasitas_belajar` varchar(255) NOT NULL,
  `kapasitas_ujian` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` enum('aktif','non_aktif') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ruangan`
--

LOCK TABLES `ruangan` WRITE;
/*!40000 ALTER TABLE `ruangan` DISABLE KEYS */;
/*!40000 ALTER TABLE `ruangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saldo`
--

DROP TABLE IF EXISTS `saldo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saldo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_akun` varchar(10) NOT NULL,
  `bulan` tinyint(3) unsigned NOT NULL,
  `tahun` smallint(5) unsigned NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kredit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `saldo_kode_akun_bulan_tahun_unique` (`kode_akun`,`bulan`,`tahun`),
  KEY `saldo_tahun_bulan_index` (`tahun`,`bulan`),
  CONSTRAINT `saldo_kode_akun_foreign` FOREIGN KEY (`kode_akun`) REFERENCES `rekening` (`kode_akun`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saldo`
--

LOCK TABLES `saldo` WRITE;
/*!40000 ALTER TABLE `saldo` DISABLE KEYS */;
/*!40000 ALTER TABLE `saldo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siswa`
--

DROP TABLE IF EXISTS `siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `siswa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `nipd` varchar(255) NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `no_kk` varchar(16) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `rt` varchar(255) NOT NULL,
  `rw` varchar(255) NOT NULL,
  `dusun` varchar(255) NOT NULL,
  `kelurahan` varchar(255) NOT NULL,
  `kecamatan` varchar(255) NOT NULL,
  `kode_pos` varchar(255) NOT NULL,
  `kebutuhan_khusus` varchar(255) NOT NULL,
  `jenis_tinggal` enum('orang_tua','asrama','kost','wali') NOT NULL DEFAULT 'orang_tua',
  `alat_transportasi` varchar(255) NOT NULL,
  `hp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `skhun` varchar(255) NOT NULL,
  `penerima_kps` varchar(255) NOT NULL,
  `no_kps` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tahun_akademik` varchar(255) NOT NULL,
  `status_awal` enum('baru','pindahan') NOT NULL DEFAULT 'baru',
  `status_siswa` enum('aktif','nonaktif','blokir') NOT NULL DEFAULT 'aktif',
  `kode_kelas` varchar(255) NOT NULL,
  `kode_jurusan` varchar(255) DEFAULT NULL,
  `ruang` varchar(255) NOT NULL,
  `spp_nominal` varchar(255) DEFAULT NULL,
  `tingkat` varchar(255) DEFAULT NULL,
  `nama_ayah` varchar(255) NOT NULL,
  `tahun_lahir_ayah` varchar(255) NOT NULL,
  `pendidikan_ayah` varchar(255) NOT NULL,
  `pekerjaan_ayah` varchar(255) NOT NULL,
  `penghasilan_ayah` varchar(255) NOT NULL,
  `kebutuhan_khusus_ayah` varchar(255) NOT NULL,
  `no_telepon_ayah` varchar(255) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `tahun_lahir_ibu` varchar(255) NOT NULL,
  `pendidikan_ibu` varchar(255) NOT NULL,
  `pekerjaan_ibu` varchar(255) NOT NULL,
  `penghasilan_ibu` varchar(255) NOT NULL,
  `kebutuhan_khusus_ibu` varchar(255) NOT NULL,
  `no_telepon_ibu` varchar(255) NOT NULL,
  `nama_wali` varchar(255) NOT NULL,
  `tahun_lahir_wali` varchar(255) NOT NULL,
  `pendidikan_wali` varchar(255) NOT NULL,
  `pekerjaan_wali` varchar(255) NOT NULL,
  `penghasilan_wali` varchar(255) NOT NULL,
  `kebutuhan_khusus_wali` varchar(255) NOT NULL,
  `no_telepon_wali` varchar(255) NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siswa`
--

LOCK TABLES `siswa` WRITE;
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spp`
--

DROP TABLE IF EXISTS `spp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `spp` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `anggota_kelas` varchar(255) NOT NULL,
  `nominal` varchar(255) NOT NULL,
  `status` enum('L','B') NOT NULL DEFAULT 'B',
  `tgl_lunas` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spp`
--

LOCK TABLES `spp` WRITE;
/*!40000 ALTER TABLE `spp` DISABLE KEYS */;
/*!40000 ALTER TABLE `spp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_laporans`
--

DROP TABLE IF EXISTS `sub_laporans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_laporans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_laporan` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `urut` int(10) unsigned NOT NULL DEFAULT 0,
  `id_lap` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_laporans_id_lap_index` (`id_lap`),
  KEY `sub_laporans_file_id_lap_index` (`file`,`id_lap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_laporans`
--

LOCK TABLES `sub_laporans` WRITE;
/*!40000 ALTER TABLE `sub_laporans` DISABLE KEYS */;
/*!40000 ALTER TABLE `sub_laporans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tahun_akademik`
--

DROP TABLE IF EXISTS `tahun_akademik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tahun_akademik` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_tahun` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tahun_akademik`
--

LOCK TABLES `tahun_akademik` WRITE;
/*!40000 ALTER TABLE `tahun_akademik` DISABLE KEYS */;
/*!40000 ALTER TABLE `tahun_akademik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tanda_tangan`
--

DROP TABLE IF EXISTS `tanda_tangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tanda_tangan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanda_tangan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tanda_tangan`
--

LOCK TABLES `tanda_tangan` WRITE;
/*!40000 ALTER TABLE `tanda_tangan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tanda_tangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaksi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invoice` bigint(20) DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL,
  `rekening_debit` varchar(255) NOT NULL,
  `rekening_kredit` varchar(255) NOT NULL,
  `kode_spp` varchar(255) DEFAULT NULL,
  `siswa_id` int(11) NOT NULL,
  `idtp` int(11) DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `urutan` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaksi`
--

LOCK TABLES `transaksi` WRITE;
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(32) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `telepon` varchar(30) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','1','Administrator','L','08123456789','Sragen','1784337372_images.jpg','admin@local','admin','$2y$12$o7AB2.OF0UWFGnCFP/Xdqu.NECJTLb.VP9uA0qY12fGyyMaCkNpum',NULL,'2026-07-14 22:29:55','2026-07-17 18:16:12');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'sinkrone_sabit'
--

--
-- Dumping routines for database 'sinkrone_sabit'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-20 10:17:01
