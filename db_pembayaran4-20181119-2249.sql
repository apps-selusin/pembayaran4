-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 19, 2018 at 04:48 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pembayaran4`
--

-- --------------------------------------------------------

--
-- Table structure for table `t01_tahunajaran`
--

CREATE TABLE `t01_tahunajaran` (
  `id` int(11) NOT NULL,
  `Awal_Bulan` tinyint(4) NOT NULL,
  `Awal_Tahun` smallint(6) NOT NULL,
  `Akhir_Bulan` tinyint(4) NOT NULL,
  `Akhir_Tahun` smallint(6) NOT NULL,
  `Tahun_Ajaran` varchar(50) NOT NULL,
  `Aktif` enum('Y','T') NOT NULL DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t01_tahunajaran`
--

INSERT INTO `t01_tahunajaran` (`id`, `Awal_Bulan`, `Awal_Tahun`, `Akhir_Bulan`, `Akhir_Tahun`, `Tahun_Ajaran`, `Aktif`) VALUES
(1, 7, 2018, 6, 2019, '2018 / 2019', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `t02_sekolah`
--

CREATE TABLE `t02_sekolah` (
  `id` int(11) NOT NULL,
  `Sekolah` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t02_sekolah`
--

INSERT INTO `t02_sekolah` (`id`, `Sekolah`) VALUES
(1, 'MINU UNGGULAN'),
(2, 'MINU KARAKTER');

-- --------------------------------------------------------

--
-- Table structure for table `t03_kelas`
--

CREATE TABLE `t03_kelas` (
  `id` int(11) NOT NULL,
  `sekolah_id` int(11) NOT NULL,
  `Kelas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t03_kelas`
--

INSERT INTO `t03_kelas` (`id`, `sekolah_id`, `Kelas`) VALUES
(1, 1, 'KELAS I NICOLAS OTTO'),
(2, 1, 'KELAS I JAMES WATT'),
(3, 1, 'KELAS II ALEXANDER GRAHAM BELL'),
(4, 1, 'KELAS II MICHAEL FARADAY'),
(5, 1, 'KELAS III ALBERT EINSTEIN'),
(6, 1, 'KELAS III ALFRED NOBEL'),
(7, 1, 'KELAS IV ISAAC NEWTON'),
(8, 1, 'KELAS IV ALESSANDRO VOLTA'),
(9, 1, 'KELAS V THOMAS ALFA EDISON'),
(10, 1, 'KELAS VI GALILEO GALILEI'),
(11, 2, 'KELAS I KH. BISRI SYANSURI'),
(12, 2, 'KELAS I KH. WACHID HASYIM');

-- --------------------------------------------------------

--
-- Table structure for table `t04_siswa`
--

CREATE TABLE `t04_siswa` (
  `id` int(11) NOT NULL,
  `sekolah_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `NIS` varchar(100) NOT NULL,
  `Nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t04_siswa`
--

INSERT INTO `t04_siswa` (`id`, `sekolah_id`, `kelas_id`, `NIS`, `Nama`) VALUES
(1, 1, 1, '1', 'Abdi');

-- --------------------------------------------------------

--
-- Table structure for table `t05_rutin`
--

CREATE TABLE `t05_rutin` (
  `id` int(11) NOT NULL,
  `Jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t05_rutin`
--

INSERT INTO `t05_rutin` (`id`, `Jenis`) VALUES
(1, 'Infaq'),
(2, 'Catering'),
(3, 'Worksheet'),
(4, 'Beasiswa Infaq');

-- --------------------------------------------------------

--
-- Table structure for table `t06_siswarutin`
--

CREATE TABLE `t06_siswarutin` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `rutin_id` int(11) NOT NULL,
  `Nilai` float(14,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t06_siswarutin`
--

INSERT INTO `t06_siswarutin` (`id`, `siswa_id`, `rutin_id`, `Nilai`) VALUES
(1, 1, 1, 100000.00);

-- --------------------------------------------------------

--
-- Table structure for table `t06_siswarutintemp`
--

CREATE TABLE `t06_siswarutintemp` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `rutin_id` int(11) NOT NULL,
  `siswarutin_id` int(11) NOT NULL,
  `Periode_Awal` varchar(6) DEFAULT NULL,
  `Periode_Akhir` varchar(6) DEFAULT NULL,
  `Nilai` float(14,2) DEFAULT '0.00',
  `Nilai_Temp` float(14,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t06_siswarutintemp`
--

INSERT INTO `t06_siswarutintemp` (`id`, `siswa_id`, `rutin_id`, `siswarutin_id`, `Periode_Awal`, `Periode_Akhir`, `Nilai`, `Nilai_Temp`) VALUES
(1, 1, 1, 1, NULL, NULL, 0.00, 100000.00);

-- --------------------------------------------------------

--
-- Table structure for table `t07_siswarutinbayar`
--

CREATE TABLE `t07_siswarutinbayar` (
  `id` int(11) NOT NULL,
  `siswarutin_id` int(11) NOT NULL,
  `Bulan` tinyint(4) NOT NULL DEFAULT '0',
  `Tahun` smallint(6) NOT NULL DEFAULT '0',
  `Nilai` float(14,2) DEFAULT '0.00',
  `Tanggal_Bayar` date DEFAULT NULL,
  `Nilai_Bayar` float(14,2) DEFAULT '0.00',
  `Periode_Tahun_Bulan` varchar(6) DEFAULT NULL,
  `Periode_Text` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t07_siswarutinbayar`
--

INSERT INTO `t07_siswarutinbayar` (`id`, `siswarutin_id`, `Bulan`, `Tahun`, `Nilai`, `Tanggal_Bayar`, `Nilai_Bayar`, `Periode_Tahun_Bulan`, `Periode_Text`) VALUES
(1, 1, 7, 2018, 100000.00, NULL, 0.00, '201807', 'Juli 2018'),
(2, 1, 8, 2018, 100000.00, NULL, 0.00, '201808', 'Agustus 2018'),
(3, 1, 9, 2018, 100000.00, NULL, 0.00, '201809', 'September 2018'),
(4, 1, 10, 2018, 100000.00, NULL, 0.00, '201810', 'Oktober 2018'),
(5, 1, 11, 2018, 100000.00, '2018-11-19', 100000.00, '201811', 'November 2018'),
(6, 1, 12, 2018, 100000.00, NULL, 0.00, '201812', 'Desember 2018'),
(7, 1, 1, 2019, 100000.00, NULL, 0.00, '201901', 'Januari 2019'),
(8, 1, 2, 2019, 100000.00, NULL, 0.00, '201902', 'Februari 2019'),
(9, 1, 3, 2019, 100000.00, NULL, 0.00, '201903', 'Maret 2019'),
(10, 1, 4, 2019, 100000.00, NULL, 0.00, '201904', 'April 2019'),
(11, 1, 5, 2019, 100000.00, NULL, 0.00, '201905', 'Mei 2019'),
(12, 1, 6, 2019, 100000.00, NULL, 0.00, '201906', 'Juni 2019');

-- --------------------------------------------------------

--
-- Table structure for table `t08_nonrutin`
--

CREATE TABLE `t08_nonrutin` (
  `id` int(11) NOT NULL,
  `Jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t08_nonrutin`
--

INSERT INTO `t08_nonrutin` (`id`, `Jenis`) VALUES
(1, 'Dana SPM BP3MNU'),
(2, 'Daftar Ulang');

-- --------------------------------------------------------

--
-- Table structure for table `t09_siswanonrutin`
--

CREATE TABLE `t09_siswanonrutin` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `nonrutin_id` int(11) NOT NULL,
  `Nilai` float(14,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t09_siswanonrutin`
--

INSERT INTO `t09_siswanonrutin` (`id`, `siswa_id`, `nonrutin_id`, `Nilai`) VALUES
(1, 1, 1, 200000.00);

-- --------------------------------------------------------

--
-- Table structure for table `t09_siswanonrutintemp`
--

CREATE TABLE `t09_siswanonrutintemp` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `nonrutin_id` int(11) NOT NULL,
  `siswanonrutin_id` int(11) NOT NULL,
  `Nilai` float(14,2) DEFAULT '0.00',
  `Bayar` float(14,2) DEFAULT '0.00',
  `Sisa` float(14,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t09_siswanonrutintemp`
--

INSERT INTO `t09_siswanonrutintemp` (`id`, `siswa_id`, `nonrutin_id`, `siswanonrutin_id`, `Nilai`, `Bayar`, `Sisa`) VALUES
(1, 1, 1, 1, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `t10_siswanonrutinbayar`
--

CREATE TABLE `t10_siswanonrutinbayar` (
  `id` int(11) NOT NULL,
  `siswanonrutin_id` int(11) NOT NULL,
  `Nilai` float(14,2) DEFAULT '0.00',
  `Tanggal_Bayar` date DEFAULT NULL,
  `Bayar` float(14,2) DEFAULT '0.00',
  `Sisa` float(14,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t10_siswanonrutinbayar`
--

INSERT INTO `t10_siswanonrutinbayar` (`id`, `siswanonrutin_id`, `Nilai`, `Tanggal_Bayar`, `Bayar`, `Sisa`) VALUES
(1, 1, 200000.00, '2018-11-16', 60000.00, 140000.00),
(2, 1, 140000.00, '2018-11-16', 50000.00, 90000.00),
(3, 1, 90000.00, '2018-11-19', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `t92_periodeold`
--

CREATE TABLE `t92_periodeold` (
  `id` int(11) NOT NULL,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `Tahun_Bulan` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t93_periode`
--

CREATE TABLE `t93_periode` (
  `id` int(11) NOT NULL,
  `Bulan` tinyint(4) NOT NULL,
  `Tahun` smallint(6) NOT NULL,
  `Tahun_Bulan` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t93_periode`
--

INSERT INTO `t93_periode` (`id`, `Bulan`, `Tahun`, `Tahun_Bulan`) VALUES
(1, 11, 2018, '201811');

-- --------------------------------------------------------

--
-- Table structure for table `t99_audittrail`
--

CREATE TABLE `t99_audittrail` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t99_audittrail`
--

INSERT INTO `t99_audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(12, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '2', '', '1'),
(13, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '2', '', '1'),
(14, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '2', '', '0001'),
(15, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '2', '', 'Adi'),
(16, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '2', '', '2'),
(17, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(18, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '3', '', '2'),
(19, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '3', '', '1'),
(20, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '3', '', '0'),
(21, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '3', '', '3'),
(22, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '4', '', '2'),
(23, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '4', '', '2'),
(24, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '4', '', '0'),
(25, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '4', '', '4'),
(26, '2018-11-12 13:25:42', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(27, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '3', '', '1'),
(28, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '3', '', '1'),
(29, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '3', '', '0002'),
(30, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '3', '', 'Budi'),
(31, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '3', '', '3'),
(32, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(33, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '5', '', '3'),
(34, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '5', '', '1'),
(35, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '5', '', '0'),
(36, '2018-11-12 13:26:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '5', '', '5'),
(37, '2018-11-12 13:26:34', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '6', '', '3'),
(38, '2018-11-12 13:26:34', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '6', '', '2'),
(39, '2018-11-12 13:26:34', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '6', '', '0'),
(40, '2018-11-12 13:26:34', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '6', '', '6'),
(41, '2018-11-12 13:26:34', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(42, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '1', '', '1'),
(43, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '1', '', '1'),
(44, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '1', '', '0001'),
(45, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '1', '', 'Adi'),
(46, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '1', '', '1'),
(47, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(48, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '1', '', '1'),
(49, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '1', '', '1'),
(50, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '1', '', '75000'),
(51, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '1', '', '1'),
(52, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '2', '', '1'),
(53, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '2', '', '2'),
(54, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '2', '', '100000'),
(55, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '2', '', '2'),
(56, '2018-11-12 14:45:50', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(57, '2018-11-12 15:05:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '2', '', '1'),
(58, '2018-11-12 15:05:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '2', '', '1'),
(59, '2018-11-12 15:05:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '2', '', '0002'),
(60, '2018-11-12 15:05:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '2', '', 'Budi'),
(61, '2018-11-12 15:05:33', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '2', '', '2'),
(62, '2018-11-12 15:05:33', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(63, '2018-11-12 15:06:07', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '3', '', '2'),
(64, '2018-11-12 15:06:07', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '3', '', '1'),
(65, '2018-11-12 15:06:07', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '3', '', '50000'),
(66, '2018-11-12 15:06:07', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'id', '3', '', '3'),
(67, '2018-11-12 15:06:20', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '5', '', '2'),
(68, '2018-11-12 15:06:20', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '5', '', '2'),
(69, '2018-11-12 15:06:20', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '5', '', '60000'),
(70, '2018-11-12 15:06:20', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'id', '5', '', '5'),
(71, '2018-11-12 16:29:23', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', '*** Batch update begin ***', 't07_siswarutinbayar', '', '', '', ''),
(72, '2018-11-12 16:29:23', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', 'U', 't07_siswarutinbayar', 'Tanggal_Bayar', '37', NULL, '2018-11-12'),
(73, '2018-11-12 16:29:23', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', 'U', 't07_siswarutinbayar', 'Tanggal_Bayar', '38', NULL, '2018-11-12'),
(74, '2018-11-12 16:29:23', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', 'U', 't07_siswarutinbayar', 'Tanggal_Bayar', '39', NULL, '2018-11-12'),
(75, '2018-11-12 16:29:24', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', '*** Batch update successful ***', 't07_siswarutinbayar', '', '', '', ''),
(76, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '3', '', '1'),
(77, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '3', '', '1'),
(78, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '3', '', '0003'),
(79, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '3', '', 'Cahyo'),
(80, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '3', '', '3'),
(81, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(82, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '6', '', '3'),
(83, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '6', '', '1'),
(84, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '6', '', '45000'),
(85, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '6', '', '6'),
(86, '2018-11-12 19:38:10', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(87, '2018-11-12 19:41:48', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '4', '', '1'),
(88, '2018-11-12 19:41:48', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '4', '', '1'),
(89, '2018-11-12 19:41:48', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '4', '', '0004'),
(90, '2018-11-12 19:41:48', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '4', '', 'Danang'),
(91, '2018-11-12 19:41:48', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '4', '', '4'),
(92, '2018-11-12 19:41:49', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(93, '2018-11-12 19:41:49', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '7', '', '4'),
(94, '2018-11-12 19:41:49', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '7', '', '1'),
(95, '2018-11-12 19:41:49', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '7', '', '35000'),
(96, '2018-11-12 19:41:49', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '7', '', '7'),
(97, '2018-11-12 19:41:49', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(98, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '5', '', '1'),
(99, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '5', '', '1'),
(100, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '5', '', '0005'),
(101, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '5', '', 'Eko'),
(102, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '5', '', '5'),
(103, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(104, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '8', '', '5'),
(105, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '8', '', '3'),
(106, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '8', '', '10000'),
(107, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '8', '', '8'),
(108, '2018-11-12 19:44:08', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(109, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '6', '', '1'),
(110, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '6', '', '1'),
(111, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '6', '', '006'),
(112, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '6', '', 'Farid'),
(113, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '6', '', '6'),
(114, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(115, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '9', '', '6'),
(116, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '9', '', '4'),
(117, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '9', '', '85500'),
(118, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '9', '', '9'),
(119, '2018-11-12 19:58:44', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(120, '2018-11-12 20:01:06', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '10', '', '6'),
(121, '2018-11-12 20:01:06', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '10', '', '1'),
(122, '2018-11-12 20:01:06', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '10', '', '90000'),
(123, '2018-11-12 20:01:06', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'id', '10', '', '10'),
(124, '2018-11-12 20:03:16', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '11', '', '6'),
(125, '2018-11-12 20:03:16', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '11', '', '2'),
(126, '2018-11-12 20:03:16', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '11', '', '105000'),
(127, '2018-11-12 20:03:16', '/pembayaran4/t06_siswarutinadd.php', '-1', 'A', 't06_siswarutin', 'id', '11', '', '11'),
(128, '2018-11-12 20:13:18', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', '*** Batch update begin ***', 't07_siswarutinbayar', '', '', '', ''),
(129, '2018-11-12 20:13:18', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', 'U', 't07_siswarutinbayar', 'Tanggal_Bayar', '85', NULL, '2018-11-12'),
(130, '2018-11-12 20:13:18', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', '*** Batch update successful ***', 't07_siswarutinbayar', '', '', '', ''),
(131, '2018-11-12 20:16:47', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', '*** Batch update begin ***', 't07_siswarutinbayar', '', '', '', ''),
(132, '2018-11-12 20:16:47', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', 'U', 't07_siswarutinbayar', 'Tanggal_Bayar', '86', NULL, '2018-11-12'),
(133, '2018-11-12 20:16:47', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', '*** Batch update successful ***', 't07_siswarutinbayar', '', '', '', ''),
(134, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '7', '', '1'),
(135, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '7', '', '1'),
(136, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '7', '', '0007'),
(137, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '7', '', 'Gunawan'),
(138, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '7', '', '7'),
(139, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(140, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '12', '', '7'),
(141, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '12', '', '1'),
(142, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '12', '', '58500'),
(143, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '12', '', '12'),
(144, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '13', '', '7'),
(145, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '13', '', '2'),
(146, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '13', '', '59500'),
(147, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '13', '', '13'),
(148, '2018-11-12 22:49:17', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(149, '2018-11-13 12:33:00', '/pembayaran4/t08_nonrutinadd.php', '-1', 'A', 't08_nonrutin', 'Jenis', '1', '', 'Dana SPM BP3MNU'),
(150, '2018-11-13 12:33:00', '/pembayaran4/t08_nonrutinadd.php', '-1', 'A', 't08_nonrutin', 'id', '1', '', '1'),
(151, '2018-11-13 12:33:11', '/pembayaran4/t08_nonrutinadd.php', '-1', 'A', 't08_nonrutin', 'Jenis', '2', '', 'Daftar Ulang'),
(152, '2018-11-13 12:33:11', '/pembayaran4/t08_nonrutinadd.php', '-1', 'A', 't08_nonrutin', 'id', '2', '', '2'),
(153, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '8', '', '1'),
(154, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '8', '', '1'),
(155, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '8', '', '0008'),
(156, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '8', '', 'Hari'),
(157, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '8', '', '8'),
(158, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(159, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '14', '', '8'),
(160, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '14', '', '1'),
(161, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '14', '', '150000'),
(162, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '14', '', '14'),
(163, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(164, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't09_siswanonrutin', '', '', '', ''),
(165, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'siswa_id', '1', '', '8'),
(166, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'nonrutin_id', '1', '', '1'),
(167, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'Nilai', '1', '', '4000000'),
(168, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'id', '1', '', '1'),
(169, '2018-11-13 12:45:40', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't09_siswanonrutin', '', '', '', ''),
(170, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '9', '', '1'),
(171, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '9', '', '1'),
(172, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '9', '', '0009'),
(173, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '9', '', 'Inggrid'),
(174, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '9', '', '9'),
(175, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(176, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '15', '', '9'),
(177, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '15', '', '1'),
(178, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '15', '', '90000'),
(179, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '15', '', '15'),
(180, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(181, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't09_siswanonrutin', '', '', '', ''),
(182, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '1', '', '1'),
(183, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '1', '', '1'),
(184, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '1', '', '0001'),
(185, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '1', '', 'Ahmad'),
(186, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '1', '', '1'),
(187, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(188, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '1', '', '1'),
(189, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '1', '', '1'),
(190, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '1', '', '100000'),
(191, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '1', '', '1'),
(192, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '2', '', '1'),
(193, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '2', '', '2'),
(194, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '2', '', '110000'),
(195, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '2', '', '2'),
(196, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(197, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't09_siswanonrutin', '', '', '', ''),
(198, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'siswa_id', '1', '', '1'),
(199, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'nonrutin_id', '1', '', '1'),
(200, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'Nilai', '1', '', '1750000'),
(201, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'id', '1', '', '1'),
(202, '2018-11-14 10:16:00', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't09_siswanonrutin', '', '', '', ''),
(203, '2018-11-15 10:23:52', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(204, '2018-11-15 10:23:52', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'siswarutin_id', '1', '1', '0'),
(205, '2018-11-15 10:23:52', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', NULL, '201807'),
(206, '2018-11-15 10:23:52', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', NULL, '201807'),
(207, '2018-11-15 10:23:52', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'siswarutin_id', '2', '2', '0'),
(208, '2018-11-15 10:23:52', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(209, '2018-11-15 10:23:52', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(210, '2018-11-15 10:23:52', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'siswanonrutin_id', '1', '1', '0'),
(211, '2018-11-15 10:23:52', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(212, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '1', '', '1'),
(213, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '1', '', '1'),
(214, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '1', '', '0001'),
(215, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '1', '', 'Anwar'),
(216, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '1', '', '1'),
(217, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(218, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '1', '', '1'),
(219, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '1', '', '1'),
(220, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '1', '', '75000'),
(221, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '1', '', '1'),
(222, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(223, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't09_siswanonrutin', '', '', '', ''),
(224, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'siswa_id', '1', '', '1'),
(225, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'nonrutin_id', '1', '', '1'),
(226, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'Nilai', '1', '', '85000'),
(227, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'id', '1', '', '1'),
(228, '2018-11-15 11:24:02', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't09_siswanonrutin', '', '', '', ''),
(229, '2018-11-15 11:24:34', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(230, '2018-11-15 11:24:34', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'siswarutin_id', '1', '1', '0'),
(231, '2018-11-15 11:24:34', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', NULL, '201807'),
(232, '2018-11-15 11:24:34', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', NULL, '201807'),
(233, '2018-11-15 11:24:34', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(234, '2018-11-15 11:24:34', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(235, '2018-11-15 11:24:34', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'siswanonrutin_id', '1', '1', '0'),
(236, '2018-11-15 11:24:34', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(237, '2018-11-15 12:24:23', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(238, '2018-11-15 12:24:23', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'siswarutin_id', '1', '1', '0'),
(239, '2018-11-15 12:24:23', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', '201807', '201808'),
(240, '2018-11-15 12:24:23', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', '201807', '201808'),
(241, '2018-11-15 12:24:23', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(242, '2018-11-15 12:24:23', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(243, '2018-11-15 12:24:23', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'siswanonrutin_id', '1', '1', '0'),
(244, '2018-11-15 12:24:23', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(245, '2018-11-15 12:26:12', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(246, '2018-11-15 12:26:12', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', '201808', '201809'),
(247, '2018-11-15 12:26:12', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', '201808', '201810'),
(248, '2018-11-15 12:26:12', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(249, '2018-11-15 12:26:12', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(250, '2018-11-15 12:26:12', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(251, '2018-11-15 12:32:55', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(252, '2018-11-15 12:32:55', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', '201809', '201811'),
(253, '2018-11-15 12:32:55', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', '201810', '201901'),
(254, '2018-11-15 12:32:55', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(255, '2018-11-15 12:32:55', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(256, '2018-11-15 12:32:55', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(257, '2018-11-15 12:36:00', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(258, '2018-11-15 12:36:00', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', NULL, '201811'),
(259, '2018-11-15 12:36:00', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', NULL, '201901'),
(260, '2018-11-15 12:36:00', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(261, '2018-11-15 12:36:00', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(262, '2018-11-15 12:36:00', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(263, '2018-11-15 12:39:03', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(264, '2018-11-15 12:39:03', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', NULL, '201811'),
(265, '2018-11-15 12:39:03', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', NULL, '201901'),
(266, '2018-11-15 12:39:03', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(267, '2018-11-15 12:39:03', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(268, '2018-11-15 12:39:03', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(275, '2018-11-15 12:47:25', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(276, '2018-11-15 12:47:25', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', NULL, '201811'),
(277, '2018-11-15 12:47:25', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', NULL, '201901'),
(278, '2018-11-15 12:47:25', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(279, '2018-11-15 12:47:25', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(280, '2018-11-15 12:47:25', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(281, '2018-11-15 12:50:06', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(282, '2018-11-15 12:50:06', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', '201811', '201902'),
(283, '2018-11-15 12:50:06', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', '201901', '201905'),
(284, '2018-11-15 12:50:06', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(285, '2018-11-15 12:50:06', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(286, '2018-11-15 12:50:06', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(287, '2018-11-15 12:50:41', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(288, '2018-11-15 12:50:41', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', '201902', '201906'),
(289, '2018-11-15 12:50:41', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', '201905', '201906'),
(290, '2018-11-15 12:50:41', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(291, '2018-11-15 12:50:41', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(292, '2018-11-15 12:50:42', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(293, '2018-11-15 12:54:57', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(294, '2018-11-15 12:54:57', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Awal', '1', '201906', '201904'),
(295, '2018-11-15 12:54:57', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Periode_Akhir', '1', '201906', '201905'),
(296, '2018-11-15 12:54:57', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(297, '2018-11-15 12:54:57', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(298, '2018-11-15 12:54:57', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(299, '2018-11-15 13:05:15', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(300, '2018-11-15 13:05:15', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(301, '2018-11-15 13:05:15', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(302, '2018-11-15 13:05:15', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(303, '2018-11-15 13:05:38', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(304, '2018-11-15 13:05:38', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(305, '2018-11-15 13:05:38', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(306, '2018-11-15 13:05:38', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(307, '2018-11-15 13:16:53', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(308, '2018-11-15 13:16:53', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(309, '2018-11-15 13:16:53', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(310, '2018-11-15 13:16:53', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(311, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '1', '', '1'),
(312, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '1', '', '1'),
(313, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '1', '', '1'),
(314, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '1', '', 'Adira'),
(315, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '1', '', '1'),
(316, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(317, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '1', '', '1'),
(318, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '1', '', '2'),
(319, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '1', '', '76000'),
(320, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '1', '', '1'),
(321, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(322, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't09_siswanonrutin', '', '', '', ''),
(323, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'siswa_id', '1', '', '1'),
(324, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'nonrutin_id', '1', '', '2'),
(325, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'Nilai', '1', '', '77000'),
(326, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'id', '1', '', '1'),
(327, '2018-11-15 15:52:41', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't09_siswanonrutin', '', '', '', ''),
(328, '2018-11-15 16:00:44', '/pembayaran4/t04_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutin', '', '', '', ''),
(329, '2018-11-15 16:00:44', '/pembayaran4/t04_siswaedit.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '2', '', '1'),
(330, '2018-11-15 16:00:44', '/pembayaran4/t04_siswaedit.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '2', '', '1'),
(331, '2018-11-15 16:00:44', '/pembayaran4/t04_siswaedit.php', '-1', 'A', 't06_siswarutin', 'Nilai', '2', '', '78000'),
(332, '2018-11-15 16:00:44', '/pembayaran4/t04_siswaedit.php', '-1', 'A', 't06_siswarutin', 'id', '2', '', '2'),
(333, '2018-11-15 16:00:44', '/pembayaran4/t04_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutin', '', '', '', ''),
(334, '2018-11-15 16:00:44', '/pembayaran4/t04_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutin', '', '', '', ''),
(335, '2018-11-15 16:00:44', '/pembayaran4/t04_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutin', '', '', '', ''),
(336, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '1', '', '1'),
(337, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '1', '', '1'),
(338, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '1', '', '1'),
(339, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '1', '', 'Adam'),
(340, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '1', '', '1'),
(341, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(342, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '1', '', '1'),
(343, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '1', '', '3'),
(344, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '1', '', '79000'),
(345, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '1', '', '1'),
(346, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(347, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't09_siswanonrutin', '', '', '', ''),
(348, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'siswa_id', '1', '', '1'),
(349, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'nonrutin_id', '1', '', '2'),
(350, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'Nilai', '1', '', '80000'),
(351, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'id', '1', '', '1'),
(352, '2018-11-15 16:01:53', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't09_siswanonrutin', '', '', '', ''),
(353, '2018-11-15 17:08:07', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(354, '2018-11-15 17:08:07', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Nilai', '1', '0.00', '316000'),
(355, '2018-11-15 17:08:07', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(356, '2018-11-15 17:08:07', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(357, '2018-11-15 17:08:07', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(358, '2018-11-15 17:21:59', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(359, '2018-11-15 17:21:59', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't06_siswarutintemp', 'Nilai', '1', '316000.00', '0'),
(360, '2018-11-15 17:21:59', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(361, '2018-11-15 17:21:59', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(362, '2018-11-15 17:21:59', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(363, '2018-11-15 17:22:27', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(364, '2018-11-15 17:22:27', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(365, '2018-11-15 17:22:27', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(366, '2018-11-15 17:22:27', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(367, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'sekolah_id', '1', '', '1'),
(368, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'kelas_id', '1', '', '1'),
(369, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'NIS', '1', '', '1'),
(370, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'Nama', '1', '', 'Abdi'),
(371, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't04_siswa', 'id', '1', '', '1'),
(372, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't06_siswarutin', '', '', '', ''),
(373, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'siswa_id', '1', '', '1'),
(374, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'rutin_id', '1', '', '1'),
(375, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'Nilai', '1', '', '100000'),
(376, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't06_siswarutin', 'id', '1', '', '1'),
(377, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't06_siswarutin', '', '', '', ''),
(378, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't09_siswanonrutin', '', '', '', ''),
(379, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'siswa_id', '1', '', '1'),
(380, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'nonrutin_id', '1', '', '1'),
(381, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'Nilai', '1', '', '200000'),
(382, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', 'A', 't09_siswanonrutin', 'id', '1', '', '1'),
(383, '2018-11-16 08:55:46', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert successful ***', 't09_siswanonrutin', '', '', '', ''),
(384, '2018-11-16 09:36:08', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(385, '2018-11-16 09:36:08', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(386, '2018-11-16 09:36:08', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(387, '2018-11-16 09:36:08', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'Bayar', '1', '0.00', '80000'),
(388, '2018-11-16 09:36:08', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'Sisa', '1', '200000.00', '120000'),
(389, '2018-11-16 09:36:08', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(390, '2018-11-16 09:43:38', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(391, '2018-11-16 09:43:38', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(392, '2018-11-16 09:43:38', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(393, '2018-11-16 09:43:38', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'Bayar', '1', '0.00', '70000'),
(394, '2018-11-16 09:43:38', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'Sisa', '1', '0.00', '130000'),
(395, '2018-11-16 09:43:38', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'Nilai', '1', '200000.00', '130000'),
(396, '2018-11-16 09:43:38', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(397, '2018-11-16 09:47:36', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(398, '2018-11-16 09:47:36', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(399, '2018-11-16 09:47:36', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(400, '2018-11-16 09:47:36', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'Nilai', '1', '200000.00', '140000'),
(401, '2018-11-16 09:47:36', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(402, '2018-11-16 09:48:19', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(403, '2018-11-16 09:48:19', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(404, '2018-11-16 09:48:19', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(405, '2018-11-16 09:48:19', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'Nilai', '1', '140000.00', '90000'),
(406, '2018-11-16 09:48:19', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', ''),
(407, '2018-11-19 07:17:31', '/pembayaran4/t93_periodeedit.php', '-1', 'U', 't93_periode', 'Bulan', '1', '11', '10'),
(408, '2018-11-19 07:17:31', '/pembayaran4/t93_periodeedit.php', '-1', 'U', 't93_periode', 'Tahun_Bulan', '1', '201811', '201810'),
(409, '2018-11-19 08:21:06', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't06_siswarutintemp', '', '', '', ''),
(410, '2018-11-19 08:21:06', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't06_siswarutintemp', '', '', '', ''),
(411, '2018-11-19 08:21:06', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update begin ***', 't09_siswanonrutintemp', '', '', '', ''),
(412, '2018-11-19 08:21:06', '/pembayaran4/v01_siswaedit.php', '-1', 'U', 't09_siswanonrutintemp', 'Nilai', '1', '90000.00', '0.00'),
(413, '2018-11-19 08:21:06', '/pembayaran4/v01_siswaedit.php', '-1', '*** Batch update successful ***', 't09_siswanonrutintemp', '', '', '', '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v01_siswa`
-- (See below for the actual view)
--
CREATE TABLE `v01_siswa` (
`id` int(11)
,`sekolah_id` int(11)
,`kelas_id` int(11)
,`NIS` varchar(100)
,`Nama` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v02_siswa`
-- (See below for the actual view)
--
CREATE TABLE `v02_siswa` (
`siswarutin_id` int(11)
,`siswa_id` int(11)
,`rutin_id` int(11)
,`sekolah_id` int(11)
,`kelas_id` int(11)
,`NIS` varchar(100)
,`Nama` varchar(100)
,`Kelas` varchar(100)
,`Sekolah` varchar(100)
,`Periode_Tahun_Bulan` varchar(6)
,`Periode_Text` varchar(14)
);

-- --------------------------------------------------------

--
-- Structure for view `v01_siswa`
--
DROP TABLE IF EXISTS `v01_siswa`;

CREATE VIEW `v01_siswa`  AS  select `t04_siswa`.`id` AS `id`,`t04_siswa`.`sekolah_id` AS `sekolah_id`,`t04_siswa`.`kelas_id` AS `kelas_id`,`t04_siswa`.`NIS` AS `NIS`,`t04_siswa`.`Nama` AS `Nama` from `t04_siswa` ;

-- --------------------------------------------------------

--
-- Structure for view `v02_siswa`
--
DROP TABLE IF EXISTS `v02_siswa`;

CREATE VIEW `v02_siswa`  AS  select `a`.`siswarutin_id` AS `siswarutin_id`,`b`.`siswa_id` AS `siswa_id`,`b`.`rutin_id` AS `rutin_id`,`c`.`sekolah_id` AS `sekolah_id`,`c`.`kelas_id` AS `kelas_id`,`c`.`NIS` AS `NIS`,`c`.`Nama` AS `Nama`,`d`.`Kelas` AS `Kelas`,`e`.`Sekolah` AS `Sekolah`,`a`.`Periode_Tahun_Bulan` AS `Periode_Tahun_Bulan`,`a`.`Periode_Text` AS `Periode_Text` from ((((`t07_siswarutinbayar` `a` left join `t06_siswarutin` `b` on((`a`.`siswarutin_id` = `b`.`id`))) left join `t04_siswa` `c` on((`b`.`siswa_id` = `c`.`id`))) left join `t03_kelas` `d` on((`c`.`kelas_id` = `d`.`id`))) left join `t02_sekolah` `e` on((`c`.`sekolah_id` = `e`.`id`))) where ((`a`.`Tanggal_Bayar` is not null) and (`a`.`Periode_Tahun_Bulan` = '201811')) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t01_tahunajaran`
--
ALTER TABLE `t01_tahunajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t02_sekolah`
--
ALTER TABLE `t02_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t03_kelas`
--
ALTER TABLE `t03_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t04_siswa`
--
ALTER TABLE `t04_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t05_rutin`
--
ALTER TABLE `t05_rutin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t06_siswarutin`
--
ALTER TABLE `t06_siswarutin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_id_n_rutin_id` (`siswa_id`,`rutin_id`);

--
-- Indexes for table `t06_siswarutintemp`
--
ALTER TABLE `t06_siswarutintemp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t07_siswarutinbayar`
--
ALTER TABLE `t07_siswarutinbayar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t08_nonrutin`
--
ALTER TABLE `t08_nonrutin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t09_siswanonrutin`
--
ALTER TABLE `t09_siswanonrutin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_id_n_nonrutin_id` (`siswa_id`,`nonrutin_id`) USING BTREE;

--
-- Indexes for table `t09_siswanonrutintemp`
--
ALTER TABLE `t09_siswanonrutintemp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t10_siswanonrutinbayar`
--
ALTER TABLE `t10_siswanonrutinbayar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t92_periodeold`
--
ALTER TABLE `t92_periodeold`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t93_periode`
--
ALTER TABLE `t93_periode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t01_tahunajaran`
--
ALTER TABLE `t01_tahunajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t02_sekolah`
--
ALTER TABLE `t02_sekolah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t03_kelas`
--
ALTER TABLE `t03_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `t04_siswa`
--
ALTER TABLE `t04_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t05_rutin`
--
ALTER TABLE `t05_rutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t06_siswarutin`
--
ALTER TABLE `t06_siswarutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t06_siswarutintemp`
--
ALTER TABLE `t06_siswarutintemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t07_siswarutinbayar`
--
ALTER TABLE `t07_siswarutinbayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `t08_nonrutin`
--
ALTER TABLE `t08_nonrutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t09_siswanonrutin`
--
ALTER TABLE `t09_siswanonrutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t09_siswanonrutintemp`
--
ALTER TABLE `t09_siswanonrutintemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t10_siswanonrutinbayar`
--
ALTER TABLE `t10_siswanonrutinbayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t92_periodeold`
--
ALTER TABLE `t92_periodeold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t93_periode`
--
ALTER TABLE `t93_periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=414;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
