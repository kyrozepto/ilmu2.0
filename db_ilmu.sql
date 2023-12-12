-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 11:12 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ilmu`
--

-- --------------------------------------------------------

--
-- Table structure for table `filter_kota`
--

CREATE TABLE `filter_kota` (
  `id` int(11) NOT NULL,
  `nama_kota` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `filter_kota`
--

INSERT INTO `filter_kota` (`id`, `nama_kota`) VALUES
(1, 'Surabaya'),
(2, 'Depok'),
(3, 'Sidoarjo');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `npm` varchar(11) NOT NULL,
  `foto_mahasiswa` varchar(50) NOT NULL,
  `nama_mahasiswa` varchar(50) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `tanggal_lahir` varchar(15) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `jurusan` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `npm`, `foto_mahasiswa`, `nama_mahasiswa`, `gender`, `tanggal_lahir`, `alamat`, `jurusan`) VALUES
(1, '22081010181', '22081010181.svg', 'Bahiskara Ananda Arryanto', 'Pria', '17-03-2004', 'Jl. Cipunegara No. 21, Surabaya', '081'),
(2, '22081010182', '22081010182.svg', 'Anisa Salsabila', 'Wanita', '20-08-2003', 'Jl. Raya Cibubur No. 12, Depok', '081'),
(3, '22081010183', '22081010183.svg', 'Muhammad Iqbal', 'Pria', '27-09-2002', 'Jl. Gatot Subroto No. 45, Surabaya', '081'),
(4, '22081010184', '22081010184.svg', 'Sarah Azzahra', 'Wanita', '14-12-2003', 'Jl. Pahlawan No. 9, Surabaya', '081'),
(5, '22081010185', '22081010185.svg', 'Ahmad Fauzi', 'Pria', '07-07-2004', 'Jl. Sudirman No. 101, Surabaya', '081'),
(12, '22081010186', '22081010186.svg', 'Ardiansyah Ardiyanto', 'Pria', '07-03-2003', 'Jl. Rungkut No. 12, Surabaya', '081');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_mahasiswa`
--

CREATE TABLE `nilai_mahasiswa` (
  `id_nilai` int(11) NOT NULL,
  `npm` varchar(11) NOT NULL,
  `nama_mahasiswa` varchar(50) NOT NULL,
  `tugas` int(11) DEFAULT NULL,
  `uts` int(11) DEFAULT NULL,
  `uas` int(11) DEFAULT NULL,
  `tugas_akhir` int(11) DEFAULT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `predikat` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai_mahasiswa`
--

INSERT INTO `nilai_mahasiswa` (`id_nilai`, `npm`, `nama_mahasiswa`, `tugas`, `uts`, `uas`, `tugas_akhir`, `ipk`, `predikat`) VALUES
(1, '22081010181', 'Bahiskara Ananda Arryanto', 80, 75, 85, 90, 3.30, 'B+'),
(2, '22081010182', 'Anisa Salsabila', 75, 70, 80, 85, 3.10, 'B'),
(3, '22081010183', 'Muhammad Iqbal', 85, 80, 90, 95, 3.50, 'A-'),
(4, '22081010184', 'Sarah Azzahra', 88, 85, 96, 78, 3.47, 'B+'),
(5, '22081010185', 'Ahmad Fauzi', 90, 85, 95, 92, 3.62, 'A-'),
(6, '22081010186', 'Ardiansyah Ardiyanto', 78, 82, 88, 91, 3.39, 'B+');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `filter_kota`
--
ALTER TABLE `filter_kota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD KEY `idx_mahasiswa_npm` (`npm`);

--
-- Indexes for table `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `npm` (`npm`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `filter_kota`
--
ALTER TABLE `filter_kota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nilai_mahasiswa`
--
ALTER TABLE `nilai_mahasiswa`
  ADD CONSTRAINT `nilai_mahasiswa_ibfk_1` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
