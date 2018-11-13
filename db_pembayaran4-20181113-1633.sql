-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2018 at 10:32 AM
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
(1, 1, 1, '0001', 'Adi'),
(2, 1, 1, '0002', 'Budi'),
(3, 1, 1, '0003', 'Cahyo'),
(4, 1, 1, '0004', 'Danang'),
(5, 1, 1, '0005', 'Eko'),
(6, 1, 1, '006', 'Farid'),
(7, 1, 1, '0007', 'Gunawan'),
(8, 1, 1, '0008', 'Hari'),
(9, 1, 1, '0009', 'Inggrid');

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
(1, 1, 1, 75000.00),
(2, 1, 2, 100000.00),
(3, 2, 1, 50000.00),
(5, 2, 2, 60000.00),
(6, 3, 1, 45000.00),
(7, 4, 1, 35000.00),
(8, 5, 3, 10000.00),
(9, 6, 4, 85500.00),
(10, 6, 1, 90000.00),
(11, 6, 2, 105000.00),
(12, 7, 1, 58500.00),
(13, 7, 2, 59500.00),
(14, 8, 1, 150000.00),
(15, 9, 1, 90000.00);

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
  `Nilai` float(14,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t06_siswarutintemp`
--

INSERT INTO `t06_siswarutintemp` (`id`, `siswa_id`, `rutin_id`, `siswarutin_id`, `Periode_Awal`, `Periode_Akhir`, `Nilai`) VALUES
(1, 7, 1, 12, '201807', '201807', 0.00),
(2, 7, 2, 13, NULL, NULL, 0.00),
(3, 8, 1, 14, NULL, NULL, 0.00),
(4, 9, 1, 15, NULL, NULL, 0.00);

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
(1, 1, 7, 2018, 75000.00, NULL, 0.00, NULL, NULL),
(2, 1, 8, 2018, 75000.00, NULL, 0.00, NULL, NULL),
(3, 1, 9, 2018, 75000.00, NULL, 0.00, NULL, NULL),
(4, 1, 10, 2018, 75000.00, NULL, 0.00, NULL, NULL),
(5, 1, 11, 2018, 75000.00, NULL, 0.00, NULL, NULL),
(6, 1, 12, 2018, 75000.00, NULL, 0.00, NULL, NULL),
(7, 1, 1, 2019, 75000.00, NULL, 0.00, NULL, NULL),
(8, 1, 2, 2019, 75000.00, NULL, 0.00, NULL, NULL),
(9, 1, 3, 2019, 75000.00, NULL, 0.00, NULL, NULL),
(10, 1, 4, 2019, 75000.00, NULL, 0.00, NULL, NULL),
(11, 1, 5, 2019, 75000.00, NULL, 0.00, NULL, NULL),
(12, 1, 6, 2019, 75000.00, NULL, 0.00, NULL, NULL),
(13, 2, 7, 2018, 100000.00, NULL, 0.00, NULL, NULL),
(14, 2, 8, 2018, 100000.00, NULL, 0.00, NULL, NULL),
(15, 2, 9, 2018, 100000.00, NULL, 0.00, NULL, NULL),
(16, 2, 10, 2018, 100000.00, NULL, 0.00, NULL, NULL),
(17, 2, 11, 2018, 100000.00, NULL, 0.00, NULL, NULL),
(18, 2, 12, 2018, 100000.00, NULL, 0.00, NULL, NULL),
(19, 2, 1, 2019, 100000.00, NULL, 0.00, NULL, NULL),
(20, 2, 2, 2019, 100000.00, NULL, 0.00, NULL, NULL),
(21, 2, 3, 2019, 100000.00, NULL, 0.00, NULL, NULL),
(22, 2, 4, 2019, 100000.00, NULL, 0.00, NULL, NULL),
(23, 2, 5, 2019, 100000.00, NULL, 0.00, NULL, NULL),
(24, 2, 6, 2019, 100000.00, NULL, 0.00, NULL, NULL),
(25, 3, 7, 2018, 50000.00, NULL, 0.00, NULL, NULL),
(26, 3, 8, 2018, 50000.00, NULL, 0.00, NULL, NULL),
(27, 3, 9, 2018, 50000.00, NULL, 0.00, NULL, NULL),
(28, 3, 10, 2018, 50000.00, NULL, 0.00, NULL, NULL),
(29, 3, 11, 2018, 50000.00, NULL, 0.00, NULL, NULL),
(30, 3, 12, 2018, 50000.00, NULL, 0.00, NULL, NULL),
(31, 3, 1, 2019, 50000.00, NULL, 0.00, NULL, NULL),
(32, 3, 2, 2019, 50000.00, NULL, 0.00, NULL, NULL),
(33, 3, 3, 2019, 50000.00, NULL, 0.00, NULL, NULL),
(34, 3, 4, 2019, 50000.00, NULL, 0.00, NULL, NULL),
(35, 3, 5, 2019, 50000.00, NULL, 0.00, NULL, NULL),
(36, 3, 6, 2019, 50000.00, NULL, 0.00, NULL, NULL),
(37, 5, 7, 2018, 60000.00, '2018-11-12', 0.00, NULL, NULL),
(38, 5, 8, 2018, 60000.00, '2018-11-12', 0.00, NULL, NULL),
(39, 5, 9, 2018, 60000.00, '2018-11-12', 0.00, NULL, NULL),
(40, 5, 10, 2018, 60000.00, NULL, 0.00, NULL, NULL),
(41, 5, 11, 2018, 60000.00, NULL, 0.00, NULL, NULL),
(42, 5, 12, 2018, 60000.00, NULL, 0.00, NULL, NULL),
(43, 5, 1, 2019, 60000.00, NULL, 0.00, NULL, NULL),
(44, 5, 2, 2019, 60000.00, NULL, 0.00, NULL, NULL),
(45, 5, 3, 2019, 60000.00, NULL, 0.00, NULL, NULL),
(46, 5, 4, 2019, 60000.00, NULL, 0.00, NULL, NULL),
(47, 5, 5, 2019, 60000.00, NULL, 0.00, NULL, NULL),
(48, 5, 6, 2019, 60000.00, NULL, 0.00, NULL, NULL),
(49, 8, 7, 2018, 10000.00, NULL, 0.00, NULL, 'Juli 2018'),
(50, 8, 8, 2018, 10000.00, NULL, 0.00, NULL, 'Agustus 2018'),
(51, 8, 9, 2018, 10000.00, NULL, 0.00, NULL, 'September 2018'),
(52, 8, 10, 2018, 10000.00, NULL, 0.00, NULL, 'Oktober 2018'),
(53, 8, 11, 2018, 10000.00, NULL, 0.00, NULL, 'November 2018'),
(54, 8, 12, 2018, 10000.00, NULL, 0.00, NULL, 'Desember 2018'),
(55, 8, 1, 2019, 10000.00, NULL, 0.00, NULL, 'Januari 2019'),
(56, 8, 2, 2019, 10000.00, NULL, 0.00, NULL, 'Februari 2019'),
(57, 8, 3, 2019, 10000.00, NULL, 0.00, NULL, 'Maret 2019'),
(58, 8, 4, 2019, 10000.00, NULL, 0.00, NULL, 'April 2019'),
(59, 8, 5, 2019, 10000.00, NULL, 0.00, NULL, 'Mei 2019'),
(60, 8, 6, 2019, 10000.00, NULL, 0.00, NULL, 'Juni 2019'),
(61, 9, 7, 2018, 85500.00, NULL, 0.00, '20180', 'Juli 2018'),
(62, 9, 8, 2018, 85500.00, NULL, 0.00, '20180', 'Agustus 2018'),
(63, 9, 9, 2018, 85500.00, NULL, 0.00, '20180', 'September 2018'),
(64, 9, 10, 2018, 85500.00, NULL, 0.00, '201800', 'Oktober 2018'),
(65, 9, 11, 2018, 85500.00, NULL, 0.00, '201800', 'November 2018'),
(66, 9, 12, 2018, 85500.00, NULL, 0.00, '201800', 'Desember 2018'),
(67, 9, 1, 2019, 85500.00, NULL, 0.00, '20190', 'Januari 2019'),
(68, 9, 2, 2019, 85500.00, NULL, 0.00, '20190', 'Februari 2019'),
(69, 9, 3, 2019, 85500.00, NULL, 0.00, '20190', 'Maret 2019'),
(70, 9, 4, 2019, 85500.00, NULL, 0.00, '20190', 'April 2019'),
(71, 9, 5, 2019, 85500.00, NULL, 0.00, '20190', 'Mei 2019'),
(72, 9, 6, 2019, 85500.00, NULL, 0.00, '20190', 'Juni 2019'),
(73, 10, 7, 2018, 90000.00, NULL, 0.00, '20180', 'Juli 2018'),
(74, 10, 8, 2018, 90000.00, NULL, 0.00, '20180', 'Agustus 2018'),
(75, 10, 9, 2018, 90000.00, NULL, 0.00, '20180', 'September 2018'),
(76, 10, 10, 2018, 90000.00, NULL, 0.00, '201800', 'Oktober 2018'),
(77, 10, 11, 2018, 90000.00, NULL, 0.00, '201800', 'November 2018'),
(78, 10, 12, 2018, 90000.00, NULL, 0.00, '201800', 'Desember 2018'),
(79, 10, 1, 2019, 90000.00, NULL, 0.00, '20190', 'Januari 2019'),
(80, 10, 2, 2019, 90000.00, NULL, 0.00, '20190', 'Februari 2019'),
(81, 10, 3, 2019, 90000.00, NULL, 0.00, '20190', 'Maret 2019'),
(82, 10, 4, 2019, 90000.00, NULL, 0.00, '20190', 'April 2019'),
(83, 10, 5, 2019, 90000.00, NULL, 0.00, '20190', 'Mei 2019'),
(84, 10, 6, 2019, 90000.00, NULL, 0.00, '20190', 'Juni 2019'),
(85, 11, 7, 2018, 105000.00, '2018-11-12', 0.00, '201807', 'Juli 2018'),
(86, 11, 8, 2018, 105000.00, '2018-11-12', 0.00, '201808', 'Agustus 2018'),
(87, 11, 9, 2018, 105000.00, NULL, 0.00, '201809', 'September 2018'),
(88, 11, 10, 2018, 105000.00, NULL, 0.00, '201810', 'Oktober 2018'),
(89, 11, 11, 2018, 105000.00, NULL, 0.00, '201811', 'November 2018'),
(90, 11, 12, 2018, 105000.00, NULL, 0.00, '201812', 'Desember 2018'),
(91, 11, 1, 2019, 105000.00, NULL, 0.00, '201901', 'Januari 2019'),
(92, 11, 2, 2019, 105000.00, NULL, 0.00, '201902', 'Februari 2019'),
(93, 11, 3, 2019, 105000.00, NULL, 0.00, '201903', 'Maret 2019'),
(94, 11, 4, 2019, 105000.00, NULL, 0.00, '201904', 'April 2019'),
(95, 11, 5, 2019, 105000.00, NULL, 0.00, '201905', 'Mei 2019'),
(96, 11, 6, 2019, 105000.00, NULL, 0.00, '201906', 'Juni 2019'),
(97, 12, 7, 2018, 58500.00, NULL, 0.00, '201807', 'Juli 2018'),
(98, 12, 8, 2018, 58500.00, NULL, 0.00, '201808', 'Agustus 2018'),
(99, 12, 9, 2018, 58500.00, NULL, 0.00, '201809', 'September 2018'),
(100, 12, 10, 2018, 58500.00, NULL, 0.00, '201810', 'Oktober 2018'),
(101, 12, 11, 2018, 58500.00, NULL, 0.00, '201811', 'November 2018'),
(102, 12, 12, 2018, 58500.00, NULL, 0.00, '201812', 'Desember 2018'),
(103, 12, 1, 2019, 58500.00, NULL, 0.00, '201901', 'Januari 2019'),
(104, 12, 2, 2019, 58500.00, NULL, 0.00, '201902', 'Februari 2019'),
(105, 12, 3, 2019, 58500.00, NULL, 0.00, '201903', 'Maret 2019'),
(106, 12, 4, 2019, 58500.00, NULL, 0.00, '201904', 'April 2019'),
(107, 12, 5, 2019, 58500.00, NULL, 0.00, '201905', 'Mei 2019'),
(108, 12, 6, 2019, 58500.00, NULL, 0.00, '201906', 'Juni 2019'),
(109, 13, 7, 2018, 59500.00, NULL, 0.00, '201807', 'Juli 2018'),
(110, 13, 8, 2018, 59500.00, NULL, 0.00, '201808', 'Agustus 2018'),
(111, 13, 9, 2018, 59500.00, NULL, 0.00, '201809', 'September 2018'),
(112, 13, 10, 2018, 59500.00, NULL, 0.00, '201810', 'Oktober 2018'),
(113, 13, 11, 2018, 59500.00, NULL, 0.00, '201811', 'November 2018'),
(114, 13, 12, 2018, 59500.00, NULL, 0.00, '201812', 'Desember 2018'),
(115, 13, 1, 2019, 59500.00, NULL, 0.00, '201901', 'Januari 2019'),
(116, 13, 2, 2019, 59500.00, NULL, 0.00, '201902', 'Februari 2019'),
(117, 13, 3, 2019, 59500.00, NULL, 0.00, '201903', 'Maret 2019'),
(118, 13, 4, 2019, 59500.00, NULL, 0.00, '201904', 'April 2019'),
(119, 13, 5, 2019, 59500.00, NULL, 0.00, '201905', 'Mei 2019'),
(120, 13, 6, 2019, 59500.00, NULL, 0.00, '201906', 'Juni 2019'),
(121, 14, 7, 2018, 150000.00, NULL, 0.00, '201807', 'Juli 2018'),
(122, 14, 8, 2018, 150000.00, NULL, 0.00, '201808', 'Agustus 2018'),
(123, 14, 9, 2018, 150000.00, NULL, 0.00, '201809', 'September 2018'),
(124, 14, 10, 2018, 150000.00, NULL, 0.00, '201810', 'Oktober 2018'),
(125, 14, 11, 2018, 150000.00, NULL, 0.00, '201811', 'November 2018'),
(126, 14, 12, 2018, 150000.00, NULL, 0.00, '201812', 'Desember 2018'),
(127, 14, 1, 2019, 150000.00, NULL, 0.00, '201901', 'Januari 2019'),
(128, 14, 2, 2019, 150000.00, NULL, 0.00, '201902', 'Februari 2019'),
(129, 14, 3, 2019, 150000.00, NULL, 0.00, '201903', 'Maret 2019'),
(130, 14, 4, 2019, 150000.00, NULL, 0.00, '201904', 'April 2019'),
(131, 14, 5, 2019, 150000.00, NULL, 0.00, '201905', 'Mei 2019'),
(132, 14, 6, 2019, 150000.00, NULL, 0.00, '201906', 'Juni 2019'),
(133, 15, 7, 2018, 90000.00, NULL, 0.00, '201807', 'Juli 2018'),
(134, 15, 8, 2018, 90000.00, NULL, 0.00, '201808', 'Agustus 2018'),
(135, 15, 9, 2018, 90000.00, NULL, 0.00, '201809', 'September 2018'),
(136, 15, 10, 2018, 90000.00, NULL, 0.00, '201810', 'Oktober 2018'),
(137, 15, 11, 2018, 90000.00, NULL, 0.00, '201811', 'November 2018'),
(138, 15, 12, 2018, 90000.00, NULL, 0.00, '201812', 'Desember 2018'),
(139, 15, 1, 2019, 90000.00, NULL, 0.00, '201901', 'Januari 2019'),
(140, 15, 2, 2019, 90000.00, NULL, 0.00, '201902', 'Februari 2019'),
(141, 15, 3, 2019, 90000.00, NULL, 0.00, '201903', 'Maret 2019'),
(142, 15, 4, 2019, 90000.00, NULL, 0.00, '201904', 'April 2019'),
(143, 15, 5, 2019, 90000.00, NULL, 0.00, '201905', 'Mei 2019'),
(144, 15, 6, 2019, 90000.00, NULL, 0.00, '201906', 'Juni 2019');

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
(1, 8, 1, 4000000.00);

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
(181, '2018-11-13 12:50:44', '/pembayaran4/t04_siswaadd.php', '-1', '*** Batch insert begin ***', 't09_siswanonrutin', '', '', '', '');

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
-- Structure for view `v01_siswa`
--
DROP TABLE IF EXISTS `v01_siswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v01_siswa`  AS  select `t04_siswa`.`id` AS `id`,`t04_siswa`.`sekolah_id` AS `sekolah_id`,`t04_siswa`.`kelas_id` AS `kelas_id`,`t04_siswa`.`NIS` AS `NIS`,`t04_siswa`.`Nama` AS `Nama` from `t04_siswa` ;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `t05_rutin`
--
ALTER TABLE `t05_rutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t06_siswarutin`
--
ALTER TABLE `t06_siswarutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `t06_siswarutintemp`
--
ALTER TABLE `t06_siswarutintemp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t07_siswarutinbayar`
--
ALTER TABLE `t07_siswarutinbayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `t08_nonrutin`
--
ALTER TABLE `t08_nonrutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t09_siswanonrutin`
--
ALTER TABLE `t09_siswanonrutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
