-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 19, 2023 lúc 02:37 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `12_project_k71`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `idUser` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`idUser`, `username`, `password`, `role`) VALUES
(1, '1', 'c20ad4d76fe97759aa27a0c99bff6710', 'user'),
(2, '2', 'c81e728d9d4c2f636f067f89cc14862c', 'user'),
(3, 'admin', 'c4ca4238a0b923820dcc509a6f75849b', 'admin'),
(4, '3', 'c4ca4238a0b923820dcc509a6f75849b', 'user');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cauhoi`
--

CREATE TABLE `cauhoi` (
  `id_cauhoi` int(255) NOT NULL,
  `cauhoi` varchar(255) NOT NULL,
  `anh` varchar(255) NOT NULL,
  `dangcauhoi` varchar(255) NOT NULL,
  `trangthai` int(255) NOT NULL,
  `idUser` int(255) NOT NULL,
  `idKhoaHoc` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cauhoi`
--

INSERT INTO `cauhoi` (`id_cauhoi`, `cauhoi`, `anh`, `dangcauhoi`, `trangthai`, `idUser`, `idKhoaHoc`) VALUES
(10, '123', '1_2__2339c79b47034e728445c75faf604011.webp', 'Điền', 1, 2, 2),
(12, '1', '1_2__2339c79b47034e728445c75faf604011.webp', 'Điền', 1, 2, 1),
(15, '1', '', 'Điền', 1, 2, 1),
(16, '123', '', 'Điền', 1, 3, 1),
(17, 'nentangweb', 'white_ant_lookbook_dang_chieu_fall-winter_2023__51__8b999ef153164eb59453e5a764f30bf8.webp', 'Điền', 1, 3, 2),
(18, '123', '', 'Điền', 1, 1, 3),
(21, 'testcauhoi 1/12', '', 'Điền', 1, 1, 3),
(22, 'Nối cột a vs cột b', '', 'Select', 1, 4, 2),
(23, 'admin them', '', 'Điền', 1, 3, 1),
(27, 'cau hoi check boxxxx', '', 'CheckBox', 1, 3, 2),
(28, 'bnoi', '', 'Select', 1, 3, 2),
(29, 'ádasdsa', '', 'CheckBox', 1, 3, 2),
(30, 'tessst123123', '', 'Điền', 1, 1, 2),
(32, 'update cau hoi 321', '', 'Điền', 0, 1, 2),
(34, 'cau hoi check update ', '', 'CheckBox', 0, 1, 2),
(36, 'check update checkbox 122', '1_2__2339c79b47034e728445c75faf604011.webp', 'CheckBox', 0, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dapan`
--

CREATE TABLE `dapan` (
  `id_dapan` int(255) NOT NULL,
  `dapan` varchar(255) NOT NULL,
  `dapandung` int(1) NOT NULL,
  `id_cauhoi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dapan`
--

INSERT INTO `dapan` (`id_dapan`, `dapan`, `dapandung`, `id_cauhoi`) VALUES
(12, 'cau10', 1, 10),
(13, 'dap an dung cau 12', 1, 12),
(14, 'dap an dung cau 15', 1, 15),
(15, 'dap an dung cau 16', 1, 16),
(16, '1', 1, 17),
(17, 'dap an dugn cau 18', 1, 18),
(18, '1', 0, 21),
(21, '2-1', 1, 22),
(22, '4-3', 1, 22),
(23, '6-5', 1, 22),
(24, 'admin them', 1, 23),
(29, 'dap an 1', 1, 27),
(30, 'dap an 2', 0, 27),
(31, 'dap an 3', 0, 27),
(32, 'dap an 4', 1, 27),
(33, '22-11', 1, 28),
(34, '44-33', 1, 28),
(35, '66-55', 1, 28),
(36, '88-77', 1, 28),
(37, '12', 0, 29),
(38, '34', 1, 29),
(39, '56', 0, 29),
(40, 'tessst123123', 1, 30),
(42, 'cau 32 sau khi update 1233', 1, 32),
(47, '1', 1, 34),
(48, '2', 1, 34),
(49, '3', 0, 34),
(50, '4', 0, 34),
(55, '122', 1, 36),
(56, '222', 1, 36),
(57, '322', 1, 36),
(58, '422', 1, 36);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoahoc`
--

CREATE TABLE `khoahoc` (
  `idKhoaHoc` int(255) NOT NULL,
  `tenKhoaHoc` varchar(255) NOT NULL,
  `anh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khoahoc`
--

INSERT INTO `khoahoc` (`idKhoaHoc`, `tenKhoaHoc`, `anh`) VALUES
(1, 'Công nghệ web', 'http://localhost/tuan_1/images/khoahoc.jpg'),
(2, 'Nền tảng phát triển Web', 'http://localhost/tuan_1/images/khoahoc.jpg'),
(3, 'Lập trình mạng', 'http://localhost/tuan_1/images/khoahoc.jpg');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`idUser`);

--
-- Chỉ mục cho bảng `cauhoi`
--
ALTER TABLE `cauhoi`
  ADD PRIMARY KEY (`id_cauhoi`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idKhoaHoc` (`idKhoaHoc`);

--
-- Chỉ mục cho bảng `dapan`
--
ALTER TABLE `dapan`
  ADD PRIMARY KEY (`id_dapan`),
  ADD KEY `dapan_ibfk_1` (`id_cauhoi`);

--
-- Chỉ mục cho bảng `khoahoc`
--
ALTER TABLE `khoahoc`
  ADD PRIMARY KEY (`idKhoaHoc`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `idUser` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `cauhoi`
--
ALTER TABLE `cauhoi`
  MODIFY `id_cauhoi` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `dapan`
--
ALTER TABLE `dapan`
  MODIFY `id_dapan` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `khoahoc`
--
ALTER TABLE `khoahoc`
  MODIFY `idKhoaHoc` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cauhoi`
--
ALTER TABLE `cauhoi`
  ADD CONSTRAINT `cauhoi_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `account` (`idUser`),
  ADD CONSTRAINT `cauhoi_ibfk_2` FOREIGN KEY (`idKhoaHoc`) REFERENCES `khoahoc` (`idKhoaHoc`);

--
-- Các ràng buộc cho bảng `dapan`
--
ALTER TABLE `dapan`
  ADD CONSTRAINT `dapan_ibfk_1` FOREIGN KEY (`id_cauhoi`) REFERENCES `cauhoi` (`id_cauhoi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
