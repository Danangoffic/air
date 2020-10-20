-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2020 at 09:38 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klasifikasi_air`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_latih`
--

CREATE TABLE `data_latih` (
  `id_data_latih` int(11) NOT NULL,
  `ph` float NOT NULL,
  `tds` float NOT NULL,
  `th` float NOT NULL,
  `fe` float NOT NULL,
  `mn` float NOT NULL,
  `so4` float NOT NULL,
  `tc` float NOT NULL,
  `target` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_latih`
--

INSERT INTO `data_latih` (`id_data_latih`, `ph`, `tds`, `th`, `fe`, `mn`, `so4`, `tc`, `target`) VALUES
(26, 7.1, 8, 12, 0.1, 0.002, 15, 0, 2),
(27, 7, 8, 15, 0.03, 0.005, 30, 0, 2),
(28, 6.9, 56, 23, 0.2, 0.012, 45, 0, 2),
(29, 7.3, 18, 23, 0.006, 0.005, 5, 0, 2),
(30, 7, 30, 3, 0.01, 0.003, 2, 0, 2),
(31, 6.9, 8, 4, 0.01, 0.012, 5, 0, 2),
(32, 7.6, 7, 2, 0.06, 0.013, 7, 0, 2),
(33, 7.7, 556, 132, 0.09, 0.002, 2, 0, 2),
(34, 7.6, 280, 108, 0.02, 0.012, 1, 0, 2),
(35, 8.7, 1908, 548, 0.355, 0.168, 659, 31.103, 3),
(36, 8.4, 268, 293, 0.078, 0.047, 415, 45.104, 3),
(37, 9.5, 260, 42, 0.037, 0.125, 363, 47.104, 3),
(38, 9.1, 3112, 665, 0.3, 0.6, 400, 32.104, 3),
(39, 8.6, 2712, 252, 2, 1.2, 316, 26.103, 3),
(40, 7.8, 524, 124, 0.01, 0.011, 85, 0, 2),
(41, 7.7, 536, 112, 0.03, 0.031, 15, 0, 2),
(42, 7.9, 566, 132, 0.06, 0.086, 78, 0, 2),
(43, 7.8, 240, 20, 0.02, 0.013, 15, 3, 1),
(44, 7.2, 648, 780, 0.06, 0.028, 630, 36.105, 3),
(45, 7.4, 264, 905, 0.02, 0.562, 263, 45.104, 3),
(46, 8.1, 230, 18, 0.02, 0.002, 1, 3, 1),
(47, 6.5, 68, 44, 0.01, 0.011, 15, 1, 1),
(48, 7.8, 192, 36, 0.02, 0.009, 14, 0, 1),
(49, 7.7, 497, 152, 0.02, 0.011, 82, 0, 2),
(50, 7.8, 512, 124, 0.2, 0.02, 85, 0, 2),
(51, 7.1, 320, 80, 0.01, 0.003, 23, 0, 1),
(52, 7.7, 136, 50, 0.01, 0.003, 12, 0, 1),
(53, 8.2, 320, 37.6, 0.02, 0.04, 2.24, 2, 1),
(54, 0, 0, 0, 0, 0, 0, 0, 3),
(55, 0, 0, 0, 0, 0, 0, 0, 3),
(56, 0, 0, 0, 0, 0, 0, 0, 3),
(57, 0, 0, 0, 0, 0, 0, 0, 3),
(58, 0, 0, 0, 0, 0, 0, 0, 3),
(59, 0, 0, 0, 0, 0, 0, 0, 3),
(60, 0, 0, 0, 0, 0, 0, 0, 3),
(61, 0, 0, 0, 0, 0, 0, 0, 3),
(62, 0, 0, 0, 0, 0, 0, 0, 3),
(63, 6, 0, 0, 0, 0, 0, 0, 0),
(64, 6, 0, 0, 0, 0, 0, 0, 0),
(65, 6, 0, 0, 0, 0, 0, 0, 0),
(66, 7, 476, 90, 1, 0.2, 56, 2, 3),
(67, 7, 476, 90, 1, 0.2, 56, 2, 3),
(68, 7, 476, 90, 1, 0.2, 56, 2, 3),
(69, 7, 476, 90, 1, 0.2, 56, 2, 3),
(70, 7, 476, 90, 1, 0.2, 56, 2, 3),
(71, 7, 476, 90, 1, 0.2, 56, 2, 3),
(72, 7, 476, 90, 1, 0.2, 56, 2, 3),
(73, 7, 476, 90, 1, 0.2, 56, 2, 3),
(74, 7, 476, 90, 1, 0.2, 56, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `data_percobaan`
--

CREATE TABLE `data_percobaan` (
  `id_hasil_percobaan` int(11) NOT NULL,
  `id_percobaan` int(11) NOT NULL,
  `id_klasifikasi` int(11) NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_rule_klasifikasi_air`
--

CREATE TABLE `data_rule_klasifikasi_air` (
  `id_rule` int(11) NOT NULL,
  `id_air` int(11) NOT NULL,
  `id_klasifikasi` int(11) NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_rule_klasifikasi_air`
--

INSERT INTO `data_rule_klasifikasi_air` (`id_rule`, `id_air`, `id_klasifikasi`, `bobot`) VALUES
(1, 1, 1, 9),
(2, 1, 3, 1),
(3, 1, 4, 1500),
(4, 1, 5, 500),
(5, 1, 6, 1),
(6, 1, 7, 0.5),
(7, 1, 8, 400),
(8, 1, 9, 10),
(9, 2, 1, 8.5),
(10, 2, 3, 1000),
(11, 2, 4, 500),
(12, 2, 5, 0.3),
(13, 2, 6, 0.1),
(14, 2, 7, 400),
(15, 2, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_jenis_air`
--

CREATE TABLE `master_jenis_air` (
  `id_jenis` int(11) NOT NULL,
  `kategori_jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_jenis_air`
--

INSERT INTO `master_jenis_air` (`id_jenis`, `kategori_jenis`) VALUES
(1, 'Air Bersih'),
(2, 'Air Konsumsi'),
(3, 'Air Kotor');

-- --------------------------------------------------------

--
-- Table structure for table `master_klasifikasi_air`
--

CREATE TABLE `master_klasifikasi_air` (
  `id_klasifikasi` int(11) NOT NULL,
  `nama_klasifikasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_klasifikasi_air`
--

INSERT INTO `master_klasifikasi_air` (`id_klasifikasi`, `nama_klasifikasi`) VALUES
(1, 'PH'),
(3, 'TDS'),
(4, 'TH'),
(5, 'Fe'),
(6, 'Mn'),
(7, 'SO4'),
(8, 'TC');

-- --------------------------------------------------------

--
-- Table structure for table `master_percobaan`
--

CREATE TABLE `master_percobaan` (
  `id_percobaan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_user`
--

CREATE TABLE `master_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_class` enum('admin','supervisor','penguji') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_user`
--

INSERT INTO `master_user` (`id_user`, `username`, `password`, `user_class`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_latih`
--
ALTER TABLE `data_latih`
  ADD PRIMARY KEY (`id_data_latih`);

--
-- Indexes for table `data_percobaan`
--
ALTER TABLE `data_percobaan`
  ADD PRIMARY KEY (`id_hasil_percobaan`),
  ADD KEY `id_percobaan` (`id_percobaan`),
  ADD KEY `id_klasifikasi` (`id_klasifikasi`);

--
-- Indexes for table `data_rule_klasifikasi_air`
--
ALTER TABLE `data_rule_klasifikasi_air`
  ADD PRIMARY KEY (`id_rule`),
  ADD KEY `data_rule_klasifikasi_air_ibfk_1` (`id_air`),
  ADD KEY `data_rule_klasifikasi_air_ibfk_2` (`id_klasifikasi`);

--
-- Indexes for table `master_jenis_air`
--
ALTER TABLE `master_jenis_air`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `master_klasifikasi_air`
--
ALTER TABLE `master_klasifikasi_air`
  ADD PRIMARY KEY (`id_klasifikasi`);

--
-- Indexes for table `master_percobaan`
--
ALTER TABLE `master_percobaan`
  ADD PRIMARY KEY (`id_percobaan`);

--
-- Indexes for table `master_user`
--
ALTER TABLE `master_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_latih`
--
ALTER TABLE `data_latih`
  MODIFY `id_data_latih` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `data_percobaan`
--
ALTER TABLE `data_percobaan`
  MODIFY `id_hasil_percobaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_rule_klasifikasi_air`
--
ALTER TABLE `data_rule_klasifikasi_air`
  MODIFY `id_rule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `master_jenis_air`
--
ALTER TABLE `master_jenis_air`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_klasifikasi_air`
--
ALTER TABLE `master_klasifikasi_air`
  MODIFY `id_klasifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_percobaan`
--
ALTER TABLE `master_percobaan`
  MODIFY `id_percobaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_user`
--
ALTER TABLE `master_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_percobaan`
--
ALTER TABLE `data_percobaan`
  ADD CONSTRAINT `data_percobaan_ibfk_1` FOREIGN KEY (`id_percobaan`) REFERENCES `master_percobaan` (`id_percobaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_percobaan_ibfk_2` FOREIGN KEY (`id_klasifikasi`) REFERENCES `master_klasifikasi_air` (`id_klasifikasi`);

--
-- Constraints for table `data_rule_klasifikasi_air`
--
ALTER TABLE `data_rule_klasifikasi_air`
  ADD CONSTRAINT `data_rule_klasifikasi_air_ibfk_1` FOREIGN KEY (`id_air`) REFERENCES `master_jenis_air` (`id_jenis`),
  ADD CONSTRAINT `data_rule_klasifikasi_air_ibfk_2` FOREIGN KEY (`id_klasifikasi`) REFERENCES `master_klasifikasi_air` (`id_klasifikasi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
