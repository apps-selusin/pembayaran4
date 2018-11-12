-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 12, 2018 at 10:30 AM
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
(2, 1, 1, '0002', 'Budi');

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
(5, 2, 2, 60000.00);

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
  `Periode` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t07_siswarutinbayar`
--

INSERT INTO `t07_siswarutinbayar` (`id`, `siswarutin_id`, `Bulan`, `Tahun`, `Nilai`, `Tanggal_Bayar`, `Nilai_Bayar`, `Periode`) VALUES
(1, 1, 7, 2018, 75000.00, NULL, 0.00, NULL),
(2, 1, 8, 2018, 75000.00, NULL, 0.00, NULL),
(3, 1, 9, 2018, 75000.00, NULL, 0.00, NULL),
(4, 1, 10, 2018, 75000.00, NULL, 0.00, NULL),
(5, 1, 11, 2018, 75000.00, NULL, 0.00, NULL),
(6, 1, 12, 2018, 75000.00, NULL, 0.00, NULL),
(7, 1, 1, 2019, 75000.00, NULL, 0.00, NULL),
(8, 1, 2, 2019, 75000.00, NULL, 0.00, NULL),
(9, 1, 3, 2019, 75000.00, NULL, 0.00, NULL),
(10, 1, 4, 2019, 75000.00, NULL, 0.00, NULL),
(11, 1, 5, 2019, 75000.00, NULL, 0.00, NULL),
(12, 1, 6, 2019, 75000.00, NULL, 0.00, NULL),
(13, 2, 7, 2018, 100000.00, NULL, 0.00, NULL),
(14, 2, 8, 2018, 100000.00, NULL, 0.00, NULL),
(15, 2, 9, 2018, 100000.00, NULL, 0.00, NULL),
(16, 2, 10, 2018, 100000.00, NULL, 0.00, NULL),
(17, 2, 11, 2018, 100000.00, NULL, 0.00, NULL),
(18, 2, 12, 2018, 100000.00, NULL, 0.00, NULL),
(19, 2, 1, 2019, 100000.00, NULL, 0.00, NULL),
(20, 2, 2, 2019, 100000.00, NULL, 0.00, NULL),
(21, 2, 3, 2019, 100000.00, NULL, 0.00, NULL),
(22, 2, 4, 2019, 100000.00, NULL, 0.00, NULL),
(23, 2, 5, 2019, 100000.00, NULL, 0.00, NULL),
(24, 2, 6, 2019, 100000.00, NULL, 0.00, NULL),
(25, 3, 7, 2018, 50000.00, NULL, 0.00, NULL),
(26, 3, 8, 2018, 50000.00, NULL, 0.00, NULL),
(27, 3, 9, 2018, 50000.00, NULL, 0.00, NULL),
(28, 3, 10, 2018, 50000.00, NULL, 0.00, NULL),
(29, 3, 11, 2018, 50000.00, NULL, 0.00, NULL),
(30, 3, 12, 2018, 50000.00, NULL, 0.00, NULL),
(31, 3, 1, 2019, 50000.00, NULL, 0.00, NULL),
(32, 3, 2, 2019, 50000.00, NULL, 0.00, NULL),
(33, 3, 3, 2019, 50000.00, NULL, 0.00, NULL),
(34, 3, 4, 2019, 50000.00, NULL, 0.00, NULL),
(35, 3, 5, 2019, 50000.00, NULL, 0.00, NULL),
(36, 3, 6, 2019, 50000.00, NULL, 0.00, NULL),
(37, 5, 7, 2018, 60000.00, '2018-11-12', 0.00, NULL),
(38, 5, 8, 2018, 60000.00, '2018-11-12', 0.00, NULL),
(39, 5, 9, 2018, 60000.00, '2018-11-12', 0.00, NULL),
(40, 5, 10, 2018, 60000.00, NULL, 0.00, NULL),
(41, 5, 11, 2018, 60000.00, NULL, 0.00, NULL),
(42, 5, 12, 2018, 60000.00, NULL, 0.00, NULL),
(43, 5, 1, 2019, 60000.00, NULL, 0.00, NULL),
(44, 5, 2, 2019, 60000.00, NULL, 0.00, NULL),
(45, 5, 3, 2019, 60000.00, NULL, 0.00, NULL),
(46, 5, 4, 2019, 60000.00, NULL, 0.00, NULL),
(47, 5, 5, 2019, 60000.00, NULL, 0.00, NULL),
(48, 5, 6, 2019, 60000.00, NULL, 0.00, NULL);

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
(75, '2018-11-12 16:29:24', '/pembayaran4/t07_siswarutinbayarupdate.php', '-1', '*** Batch update successful ***', 't07_siswarutinbayar', '', '', '', '');

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
-- Indexes for table `t07_siswarutinbayar`
--
ALTER TABLE `t07_siswarutinbayar`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t05_rutin`
--
ALTER TABLE `t05_rutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t06_siswarutin`
--
ALTER TABLE `t06_siswarutin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t07_siswarutinbayar`
--
ALTER TABLE `t07_siswarutinbayar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `t99_audittrail`
--
ALTER TABLE `t99_audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
