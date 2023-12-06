-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2023 at 02:32 PM
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
-- Database: `db_ilmu`
--

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
  `alamat` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `npm`, `foto_mahasiswa`, `nama_mahasiswa`, `gender`, `tanggal_lahir`, `alamat`) VALUES
(1, '22081010181', '22081010181.jpg', 'Bahiskara Ananda Arryanto', 'Pria', '17-03-2004', 'Cipunegara 51'),
(2, '22081010182', '22081010182.jpg', 'Anisa Salsabila', 'Wanita', '20-08-2003', 'Jalan Raya Cibubur No. 123'),
(3, '22081010183', '22081010183.jpg', 'Muhammad Iqbal', 'Pria', '27-09-2002', 'Jalan Gatot Subroto No. 45'),
(4, '22081010184', '22081010184.jpg', 'Sarah Azzahra', 'Perempuan', '14-12-2003', 'Jalan Pahlawan No. 9'),
(5, '22081010185', '22081010185.jpg', 'Ahmad Fauzi', 'Wanita', '07-07-2004', 'Jalan Sudirman No. 101'),
(12, '22081010186', '22081010186.png', 'Ardiansyah Ardiyanto', 'Pria', '07-03-2003', 'Jl. Rungkut No. 12'),
(21, 'ddd', 'ddd.png', 'ddd', 'Pria', 'ddd', 'ddd'),
(22, 'fdfdfd', 'fdfdfd.png', 'fdfdfd', 'Pria', 'fdfdfd', 'dfdf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
