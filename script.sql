-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 21, 2024 lúc 09:52 PM
-- Phiên bản máy phục vụ: 10.4.25-MariaDB
-- Phiên bản PHP: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `php_qlcuahang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hangsua`
--

CREATE TABLE `hangsua` (
  `id` int(11) NOT NULL,
  `tensanpham` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `trangthai` int(11) NOT NULL,
  `ngaynhan` datetime NOT NULL,
  `ngaytra` datetime DEFAULT NULL,
  `tenkhach` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `anh` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `giasua` int(11) NOT NULL,
  `lienhe` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `thongtinloi` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `linhkien`
--

CREATE TABLE `linhkien` (
  `malinhkien` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tenlinhkien` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `chiso` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `congdung` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `giaban` int(11) DEFAULT NULL,
  `soluong` int(11) DEFAULT NULL,
  `thongtinkhac` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `giamgia` int(11) DEFAULT NULL,
  `gianhap` int(11) DEFAULT NULL,
  `trangthai` int(11) NOT NULL,
  `anh` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `taoluc` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `xoaluc` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `linhkiendaban`
--

CREATE TABLE `linhkiendaban` (
  `malk` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `giaban` int(11) NOT NULL,
  `gianhap` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `banluc` datetime NOT NULL,
  `tenkhachhang` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `linhkiensua`
--

CREATE TABLE `linhkiensua` (
  `id` int(11) NOT NULL,
  `idhangsua` int(11) NOT NULL,
  `malk` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `giaban` int(11) NOT NULL,
  `gianhap` int(11) NOT NULL,
  `soluong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `idsp` int(11) NOT NULL,
  `tensp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phanloai` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hangsx` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `loaisp` tinyint(1) DEFAULT NULL,
  `soluong` int(11) DEFAULT NULL,
  `giaban` int(11) DEFAULT NULL,
  `anhsp` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trangthai` int(11) NOT NULL,
  `thongtinkhac` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `giamgia` int(11) DEFAULT NULL,
  `gianhap` int(11) DEFAULT NULL,
  `taoluc` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `xoaluc` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`idsp`, `tensp`, `phanloai`, `hangsx`, `loaisp`, `soluong`, `giaban`, `anhsp`, `trangthai`, `thongtinkhac`, `giamgia`, `gianhap`, `taoluc`, `xoaluc`) VALUES
(1, 'Nồi cơm điện', 'Nồi cơm', 'SUNHOUSE', 1, 10, 200000, 'SP1711053811.jpg', 1, 'Điện áp?200v', 10, 150000, '1711052695', NULL),
(2, 'Chảo', 'chảo', 'SUNHOUSE', 0, 0, 100000, 'SP1711052839.jpg', 1, 'Chống dính?có*Bảo hành?1 năm', 10, 80000, '1711052805', NULL),
(3, 'nồi cơm2', 'Nồi cơm', 'COOK', 1, 10, 500000, 'SP1711053754.jpg', 1, 'Thông tin 1?dữ liệu1*Thông tin2?Dữ liệu 2', 5, 200000, '1711053754', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanphamdaban`
--

CREATE TABLE `sanphamdaban` (
  `idsp` int(11) NOT NULL,
  `giaban` int(11) NOT NULL,
  `gianhap` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `banluc` datetime NOT NULL,
  `tenkhachhang` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `tendangnhap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `matkhau` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `trangthai` int(11) NOT NULL,
  `admin` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`tendangnhap`, `matkhau`, `trangthai`, `admin`) VALUES
('ad1', '1', 8, b'1'),
('admin', '123456789', 9, b'1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthai`
--

CREATE TABLE `trangthai` (
  `id` int(11) NOT NULL,
  `tentrangthai` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthai`
--

INSERT INTO `trangthai` (`id`, `tentrangthai`) VALUES
(1, 'Đang bán'),
(2, 'Ngừng bán'),
(3, 'Đang sửa'),
(4, 'Không thể sửa'),
(5, 'Chưa sửa'),
(6, 'Còn hàng'),
(7, 'Hết hàng'),
(8, 'Bị khoá'),
(9, 'Đang hoạt động'),
(10, 'Chờ duyệt'),
(11, 'Đã sửa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthaihangsua`
--

CREATE TABLE `trangthaihangsua` (
  `idtrangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthaihangsua`
--

INSERT INTO `trangthaihangsua` (`idtrangthai`) VALUES
(3),
(4),
(5),
(11);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthailk`
--

CREATE TABLE `trangthailk` (
  `idtrangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthailk`
--

INSERT INTO `trangthailk` (`idtrangthai`) VALUES
(2),
(6),
(7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthaisp`
--

CREATE TABLE `trangthaisp` (
  `idtrangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthaisp`
--

INSERT INTO `trangthaisp` (`idtrangthai`) VALUES
(1),
(2),
(6),
(7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthaitk`
--

CREATE TABLE `trangthaitk` (
  `idtrangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthaitk`
--

INSERT INTO `trangthaitk` (`idtrangthai`) VALUES
(8),
(9),
(10);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `hangsua`
--
ALTER TABLE `hangsua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trangthaihangsua_1` (`trangthai`);

--
-- Chỉ mục cho bảng `linhkien`
--
ALTER TABLE `linhkien`
  ADD PRIMARY KEY (`malinhkien`),
  ADD KEY `trangthailk_1` (`trangthai`);

--
-- Chỉ mục cho bảng `linhkiendaban`
--
ALTER TABLE `linhkiendaban`
  ADD KEY `malk` (`malk`);

--
-- Chỉ mục cho bảng `linhkiensua`
--
ALTER TABLE `linhkiensua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idhanagsua` (`idhangsua`),
  ADD KEY `malksua` (`malk`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`idsp`),
  ADD KEY `trangthaisp` (`trangthai`),
  ADD KEY `phanloaisp` (`phanloai`);

--
-- Chỉ mục cho bảng `sanphamdaban`
--
ALTER TABLE `sanphamdaban`
  ADD KEY `idsp` (`idsp`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`tendangnhap`),
  ADD KEY `trangthaitaikhoan1` (`trangthai`);

--
-- Chỉ mục cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `trangthaihangsua`
--
ALTER TABLE `trangthaihangsua`
  ADD PRIMARY KEY (`idtrangthai`);

--
-- Chỉ mục cho bảng `trangthailk`
--
ALTER TABLE `trangthailk`
  ADD PRIMARY KEY (`idtrangthai`);

--
-- Chỉ mục cho bảng `trangthaisp`
--
ALTER TABLE `trangthaisp`
  ADD PRIMARY KEY (`idtrangthai`);

--
-- Chỉ mục cho bảng `trangthaitk`
--
ALTER TABLE `trangthaitk`
  ADD PRIMARY KEY (`idtrangthai`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `hangsua`
--
ALTER TABLE `hangsua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `idsp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `hangsua`
--
ALTER TABLE `hangsua`
  ADD CONSTRAINT `trangthaihangsua_1` FOREIGN KEY (`trangthai`) REFERENCES `trangthaihangsua` (`idtrangthai`);

--
-- Các ràng buộc cho bảng `linhkien`
--
ALTER TABLE `linhkien`
  ADD CONSTRAINT `trangthailk_1` FOREIGN KEY (`trangthai`) REFERENCES `trangthailk` (`idtrangthai`);

--
-- Các ràng buộc cho bảng `linhkiendaban`
--
ALTER TABLE `linhkiendaban`
  ADD CONSTRAINT `malk` FOREIGN KEY (`malk`) REFERENCES `linhkien` (`malinhkien`);

--
-- Các ràng buộc cho bảng `linhkiensua`
--
ALTER TABLE `linhkiensua`
  ADD CONSTRAINT `idhanagsua` FOREIGN KEY (`idhangsua`) REFERENCES `hangsua` (`id`),
  ADD CONSTRAINT `malksua` FOREIGN KEY (`malk`) REFERENCES `linhkien` (`malinhkien`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `trangthaisp` FOREIGN KEY (`trangthai`) REFERENCES `trangthaisp` (`idtrangthai`);

--
-- Các ràng buộc cho bảng `sanphamdaban`
--
ALTER TABLE `sanphamdaban`
  ADD CONSTRAINT `idsp` FOREIGN KEY (`idsp`) REFERENCES `sanpham` (`idsp`);

--
-- Các ràng buộc cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD CONSTRAINT `trangthaitaikhoan1` FOREIGN KEY (`trangthai`) REFERENCES `trangthaitk` (`idtrangthai`);

--
-- Các ràng buộc cho bảng `trangthaihangsua`
--
ALTER TABLE `trangthaihangsua`
  ADD CONSTRAINT `trangthaiahngsua` FOREIGN KEY (`idtrangthai`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `trangthailk`
--
ALTER TABLE `trangthailk`
  ADD CONSTRAINT `trangthailk` FOREIGN KEY (`idtrangthai`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `trangthaisp`
--
ALTER TABLE `trangthaisp`
  ADD CONSTRAINT `trangthaisp_1` FOREIGN KEY (`idtrangthai`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `trangthaitk`
--
ALTER TABLE `trangthaitk`
  ADD CONSTRAINT `trangthaitaikhoan` FOREIGN KEY (`idtrangthai`) REFERENCES `trangthai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
