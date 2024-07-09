-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2024 at 05:42 PM
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
-- Database: `api_resful_kytucxa`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id_account` int(11) NOT NULL,
  `user_account` varchar(255) NOT NULL,
  `pass_account` varchar(255) NOT NULL,
  `type_account` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id_account`, `user_account`, `pass_account`, `type_account`) VALUES
(1, 'nguyenvana', 'password123', 'student'),
(2, 'tranthib', 'password456', 'student'),
(3, 'phamdinhc', 'password789', 'student'),
(4, 'hoangthid', 'password101112', 'student'),
(5, 'levane', 'password131415', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `MaHD` int(11) NOT NULL,
  `MaPhong` varchar(255) NOT NULL,
  `Thang` int(11) NOT NULL,
  `TienDien` decimal(10,2) NOT NULL,
  `TienNuoc` decimal(10,2) NOT NULL,
  `TienMang` decimal(10,2) NOT NULL,
  `TinhTrang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`MaHD`, `MaPhong`, `Thang`, `TienDien`, `TienNuoc`, `TienMang`, `TinhTrang`) VALUES
(1, '101', 1, 200000.00, 150000.00, 50000.00, 'Đã thanh toán'),
(2, '101', 2, 210000.00, 155000.00, 52000.00, 'Chưa thanh toán'),
(3, '102', 1, 220000.00, 160000.00, 53000.00, 'Chưa thanh toán'),
(4, '102', 2, 230000.00, 165000.00, 54000.00, 'Đã thanh toán'),
(5, '201', 1, 240000.00, 170000.00, 55000.00, 'Đã thanh toán');

-- --------------------------------------------------------

--
-- Table structure for table `khu`
--

CREATE TABLE `khu` (
  `MaKhu` varchar(255) NOT NULL,
  `TenKhu` varchar(255) NOT NULL,
  `GioiTinh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khu`
--

INSERT INTO `khu` (`MaKhu`, `TenKhu`, `GioiTinh`) VALUES
('A', 'Khu A', 'Nam'),
('B', 'Khu B', 'Nữ');

-- --------------------------------------------------------

--
-- Table structure for table `phong`
--

CREATE TABLE `phong` (
  `MaPhong` varchar(255) NOT NULL,
  `MaKhu` varchar(255) NOT NULL,
  `SoNguoiToiDa` int(11) NOT NULL,
  `SoNguoiHienTai` int(11) NOT NULL,
  `Gia` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phong`
--

INSERT INTO `phong` (`MaPhong`, `MaKhu`, `SoNguoiToiDa`, `SoNguoiHienTai`, `Gia`) VALUES
('101', 'A', 2, 1, 1500000),
('102', 'A', 3, 2, 1800000),
('201', 'B', 2, 1, 1600000),
('202', 'B', 4, 3, 1900000);

-- --------------------------------------------------------

--
-- Table structure for table `sinhvien`
--

CREATE TABLE `sinhvien` (
  `MaSV` varchar(11) NOT NULL,
  `HoTen` varchar(255) NOT NULL,
  `NgaySinh` varchar(255) NOT NULL,
  `GioiTinh` varchar(255) NOT NULL,
  `DiaChi` varchar(255) NOT NULL,
  `SDT` varchar(15) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `MaPhong` varchar(225) NOT NULL,
  `TenKhu` varchar(255) NOT NULL,
  `user_account` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sinhvien`
--

INSERT INTO `sinhvien` (`MaSV`, `HoTen`, `NgaySinh`, `GioiTinh`, `DiaChi`, `SDT`, `Mail`, `MaPhong`, `TenKhu`, `user_account`) VALUES
('1', '1', '2024-04-04', 'Nữ', '1', '11', '132@gmail.com', '101', 'Khu B', 'tranthib'),
('4', '4', '2024-04-17', 'Nữ', '6', '655', '6@gmail.com', '201', 'Khu A', 'hoangthid'),
('Má', '2', '2024-04-06', 'Nữ', '23a@gmail.com', '25', '2@mail.com', '201', 'Khu A', 'hoangthid'),
('SV1', 'Nguyễn Văn A', '2024-04-15', 'Nam', '123 Đường ABC', '0123456789', 'nguyenvana@exaple.co', '101', 'Khu A', 'nguyenvana'),
('SV11', 'ánh', '2024-04-15', 'Nữ', '111q@gmail.com', 'e', '32424', '101', 'Khu B', 'hoangthid'),
('SV2', 'Trần Thị B', '2024-04-16', 'Nam', '456 Đường XYZ', '242148888888888', 'tranthib@gmail.com', '102', 'Khu A', 'tranthib'),
('SV3', 'Phạm Đình C', '2024-04-23', 'Nam', '789 Đường DEF', '0369852147', 'phamdinhc@example.co', '201', 'Khu B', 'phamdinhc'),
('SV4', 'Hoàng Thị D', '2024-04-22', 'Nữ', '321 Đường HIJ', '0963258741', 'hoangthid@example.com', '202', 'Khu B', 'hoangthid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id_account`),
  ADD UNIQUE KEY `user_account` (`user_account`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHD`),
  ADD KEY `MaPhong` (`MaPhong`);

--
-- Indexes for table `khu`
--
ALTER TABLE `khu`
  ADD PRIMARY KEY (`MaKhu`);

--
-- Indexes for table `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`MaPhong`),
  ADD KEY `phong_ibfk_1` (`MaKhu`);

--
-- Indexes for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD PRIMARY KEY (`MaSV`),
  ADD KEY `user_account` (`user_account`),
  ADD KEY `MaPhong` (`MaPhong`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `MaHD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`);

--
-- Constraints for table `phong`
--
ALTER TABLE `phong`
  ADD CONSTRAINT `phong_ibfk_1` FOREIGN KEY (`MaKhu`) REFERENCES `khu` (`MaKhu`);

--
-- Constraints for table `sinhvien`
--
ALTER TABLE `sinhvien`
  ADD CONSTRAINT `sinhvien_ibfk_1` FOREIGN KEY (`user_account`) REFERENCES `accounts` (`user_account`),
  ADD CONSTRAINT `sinhvien_ibfk_2` FOREIGN KEY (`MaPhong`) REFERENCES `phong` (`MaPhong`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
