-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2023 at 09:57 AM
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
-- Database: `bus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `username`, `password`) VALUES
(1, 'asd', 'asd'),
(10, 'admin', '$2y$10$8u5r/aJundMiolM5NUpvcubV7vQCOSxFGrIGbJQ6xpyxI7U.fTDOm');

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `busID` int(11) NOT NULL,
  `ruteID` int(11) NOT NULL,
  `agen` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `tglBerangkat` date NOT NULL,
  `wktBerangkat` time NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah_kursi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`busID`, `ruteID`, `agen`, `kelas`, `tglBerangkat`, `wktBerangkat`, `harga`, `jumlah_kursi`) VALUES
(20001, 10001, 'Karang Jati - Pasar Rebo', 'Double Decker Sleeper Seat', '2023-08-05', '19:00:00', 675000, 47),
(20002, 10001, 'Karang Jati - Harapan Jaya', 'Double Decker Sleeper Seat', '2023-08-05', '14:15:00', 775000, 43),
(20003, 10001, 'Karang Jati - Pasar Rebo', 'Executive', '2023-08-05', '09:30:00', 300000, 41),
(20004, 10002, 'Karangjati – Taman Kota', 'Double Decker  Sleeper Seat', '2023-08-05', '09:30:00', 700000, 18),
(20005, 10002, 'Karangjati – PO Harapan Jaya. Terminal', 'Double Decker  Sleeper Seat', '2023-08-05', '14:15:00', 700000, 18);

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE `rute` (
  `ruteID` int(11) NOT NULL,
  `asal` varchar(255) NOT NULL,
  `tujuan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rute`
--

INSERT INTO `rute` (`ruteID`, `asal`, `tujuan`) VALUES
(10001, 'Ngawi', 'Jakarta Timur'),
(10002, 'Ngawi', 'Jakarta Barat'),
(10003, 'Ngawi', 'Jakarta Selatan'),
(10004, 'Ngawi', 'Lampung');

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `tiketID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `busID` int(11) NOT NULL,
  `noKursi` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` int(11) NOT NULL,
  `buktiPembayaran` varchar(100) NOT NULL,
  `tglPesan` date NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tiket`
--

INSERT INTO `tiket` (`tiketID`, `userID`, `busID`, `noKursi`, `nama`, `alamat`, `telepon`, `buktiPembayaran`, `tglPesan`, `status`) VALUES
(24, 1, 20003, 27, 'asd', 'mergangsan', 12312, 'uploads/64bea3edcd28d.jpg', '2023-08-03', 'Selesai'),
(25, 1, 20002, 1, 'sad', 'jatim', 123123123, 'uploads/64bea3edcd28d.jpg', '2023-08-03', 'Success'),
(27, 1, 20002, 18, 'sad', 'ngawi', 123123, 'uploads/about.jpg', '2023-08-03', 'Ditolak'),
(28, 1, 20001, 16, 'asdasd', 'karangjati', 124124, 'uploads/about.jpg', '2023-08-04', 'Pending'),
(29, 1, 20002, 14, 'asdasd', 'yogya', 123123123, 'uploads/favicon.png', '2023-08-04', 'Pending'),
(30, 1, 20002, 5, 'asdasd', 'asddasad', 123123, 'uploads/skills-img.jpg', '2023-08-04', 'Pending'),
(31, 14, 20003, 2, 'Diki Akhmad Ilyas', 'Prawirotaman', 838123812, 'uploads/po.png', '2023-08-04', 'Success');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_wa` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `nama`, `no_wa`, `email`, `username`, `password`) VALUES
(1, 'asd', '123123', 'asd@email.com', 'asd', 'asd'),
(9, 'user', '086681928172', 'user@gmail.com', 'user', '$2y$10$oMx9dlc3y9iSgK9mo8IdF.rDs6ybV3LILt2pelox/0Ziq2/8abA5K'),
(11, 'fasfasf', '12312321', 'asfasfas@fasfasf', 'fsafasf', 'afasfasfas'),
(12, 'asdds', '213123', 'awsasd@gm.com', 'asdasd', 'admin'),
(13, 'asdasd', '213123', 'asddas@gmail.com', 'asdasd', 'asdf1234'),
(14, 'diki akhmad ilyas', '0812831283', 'diki@gmail.com', 'diki', 'diki2023');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`busID`),
  ADD KEY `ruteID` (`ruteID`);

--
-- Indexes for table `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`ruteID`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`tiketID`),
  ADD KEY `userID` (`userID`,`busID`),
  ADD KEY `busID` (`busID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rute`
--
ALTER TABLE `rute`
  MODIFY `ruteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10005;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `tiketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bus`
--
ALTER TABLE `bus`
  ADD CONSTRAINT `bus_ibfk_1` FOREIGN KEY (`ruteID`) REFERENCES `rute` (`ruteID`);

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `tiket_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `tiket_ibfk_2` FOREIGN KEY (`busID`) REFERENCES `bus` (`busID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
