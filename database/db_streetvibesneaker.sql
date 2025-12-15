-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th12 13, 2025 lúc 02:35 PM
-- Phiên bản máy phục vụ: 8.4.7
-- Phiên bản PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_streetvibesneaker`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `order_date` date NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'COD',
  `status` enum('pending','shipping','success','cancel') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `phone`, `address`, `note`, `order_date`, `total`, `payment_method`, `status`) VALUES
(4, 2, 'Huỳnh Văn Hiền', '0912345678', 'Thủ đức - TP.Hồ Chí Minh', '', '2025-12-13', 8900000.00, 'COD', 'pending'),
(3, 2, 'Huỳnh Văn Hiền', '0912345678', 'Thủ đức - TP.Hồ Chí Minh', '', '2025-12-13', 8900000.00, 'momo', 'pending'),
(5, 2, 'Huỳnh Văn Hiền', '0912345678', 'Thủ đức - TP.Hồ Chí Minh', '', '2025-12-13', 2600000.00, 'momo', 'pending'),
(6, 2, 'Huỳnh Văn Hiền', '0912345678', 'Thủ đức - TP.Hồ Chí Minh', '', '2025-12-13', 2600000.00, 'momo', 'pending'),
(7, 2, 'Huỳnh Văn Hiền', '0912345678', 'Thủ đức - TP.Hồ Chí Minh', '', '2025-12-13', 2700000.00, 'banking', 'pending'),
(8, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 4700000.00, 'banking', 'pending'),
(9, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 2700000.00, 'banking', 'cancel'),
(10, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 2600000.00, 'banking', 'cancel'),
(11, 5, 'Nguyễn Thị Yến Vy', '0912345678', 'aaaaaa', '', '2025-12-13', 2700000.00, 'momo', 'pending'),
(12, 5, 'Nguyễn Thị Yến Vy', '0912345678', 'aaaaaaaa', '', '2025-12-13', 3000000.00, 'banking', 'pending'),
(13, 5, 'Nguyễn Thị Yến Vy', '123456789', 'as', '', '2025-12-13', 2600000.00, 'momo', 'pending'),
(14, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 2700000.00, 'momo', 'cancel'),
(15, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 2700000.00, 'banking', 'cancel'),
(16, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 2700000.00, 'COD', 'shipping'),
(17, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 2600000.00, 'momo', 'cancel'),
(18, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 2600000.00, 'momo', 'shipping'),
(19, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 2600000.00, 'momo', 'cancel'),
(20, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 2600000.00, 'momo', 'cancel'),
(21, 4, 'Thái Văn Huy', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', '', '2025-12-13', 5300000.00, 'COD', 'shipping');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 2850000.00),
(2, 1, 2, 1, 1000000.00),
(3, 2, 1, 2, 2600000.00),
(4, 3, 39, 1, 3100000.00),
(5, 3, 39, 1, 3100000.00),
(6, 3, 37, 1, 2700000.00),
(7, 4, 39, 1, 3100000.00),
(8, 4, 39, 1, 3100000.00),
(9, 4, 37, 1, 2700000.00),
(10, 5, 36, 1, 2600000.00),
(11, 6, 36, 1, 2600000.00),
(12, 7, 37, 1, 2700000.00),
(13, 8, 34, 1, 2100000.00),
(14, 8, 32, 1, 2600000.00),
(15, 9, 37, 1, 2700000.00),
(16, 10, 36, 1, 2600000.00),
(17, 11, 37, 1, 2700000.00),
(18, 12, 40, 1, 3000000.00),
(19, 13, 36, 1, 2600000.00),
(20, 14, 37, 1, 2700000.00),
(21, 15, 37, 1, 2700000.00),
(22, 16, 37, 1, 2700000.00),
(23, 17, 35, 1, 2600000.00),
(24, 18, 35, 1, 2600000.00),
(25, 19, 32, 1, 2600000.00),
(26, 20, 32, 1, 2600000.00),
(27, 21, 32, 1, 2600000.00),
(28, 21, 37, 1, 2700000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `brand`, `price`, `image`, `description`, `created_at`, `quantity`) VALUES
(1, 'BLADE FF', 'Asics', 2200000.00, 'BLADE FF.png', 'Mẫu giày Asics hiệu năng cao.', '2025-12-12 18:41:44', 0),
(2, 'COURT CONTROL FF 3', 'Asics', 2600000.00, 'COURT CONTROL FF 3.png', 'Giày Asics chuyên cho sân court.', '2025-12-12 18:41:44', 0),
(3, 'COURT CONTROL FF 3 Blue', 'Asics', 2600000.00, 'COURT CONTROL FF 3 blue.png', 'Giày Asics phiên bản màu xanh.', '2025-12-12 18:41:44', 0),
(4, 'JAPAN S', 'Asics', 1800000.00, 'JAPAN S.png', 'Mẫu Asics Japan S cổ điển.', '2025-12-12 18:41:44', 0),
(5, 'JAPAN S Mint', 'Asics', 1800000.00, 'JAPAN S mint.png', 'Asics Japan S phối màu mint.', '2025-12-12 18:41:44', 0),
(6, 'JAPAN S Gold', 'Asics', 1850000.00, 'JAPAN S gold.png', 'Asics Japan S phối màu gold.', '2025-12-12 18:41:44', 0),
(7, 'JAPAN S Silver', 'Asics', 1850000.00, 'JAPAN S silver.png', 'Asics Japan S phối màu silver.', '2025-12-12 18:41:44', 0),
(8, 'JAPAN S Yellow', 'Asics', 1850000.00, 'JAPAN S yellow.png', 'Asics Japan S phối màu vàng.', '2025-12-12 18:41:44', 0),
(9, 'JAPAN S Pink', 'Asics', 1850000.00, 'JAPAN S pink.png', 'Asics Japan S phối màu hồng.', '2025-12-12 18:41:44', 0),
(10, 'Nike Book 1 EP', 'Nike', 3800000.00, 'Book 1 EP.png', 'Mẫu giày bóng rổ Nike Book 1.', '2025-12-12 18:41:44', 0),
(11, 'Nike Air Force 1 07', 'Nike', 2600000.00, 'Nike Air Force 1 ‘07.png', 'AF1 07 mẫu phổ biến nhất của Nike.', '2025-12-12 18:41:44', 0),
(12, 'Nike Blazer Mid 77 Vintage', 'Nike', 2400000.00, 'Nike Blazer Mid ‘77 Vintage.png', 'Blazer Mid phong cách cổ điển.', '2025-12-12 18:41:44', 0),
(13, 'Nike Court Vision Low', 'Nike', 1700000.00, 'Nike Court Vision Low.png', 'Giày Nike Court Vision phong cách retro.', '2025-12-12 18:41:44', 0),
(14, 'Nike GP Challenge Pro', 'Nike', 2300000.00, 'Nike GP Challenge Pro.png', 'Mẫu giày thể thao hiệu suất cao.', '2025-12-12 18:41:44', 0),
(15, 'Nike Killshot 2 Leather', 'Nike', 2200000.00, 'Nike Killshot 2 Leather.png', 'Giày Killshot 2 da cao cấp.', '2025-12-12 18:41:44', 0),
(16, 'Nike Revolution 8', 'Nike', 1500000.00, 'Nike Revolution 8.png', 'Giày chạy Nike Revolution nhẹ và êm.', '2025-12-12 18:41:44', 0),
(17, 'Nike Vaporfly 4', 'Nike', 6500000.00, 'Nike Vaporfly 4 ‘Jakob Ingebrigtsen’.png', 'Nike Vaporfly 4 phiên bản đặc biệt.', '2025-12-12 18:41:44', 0),
(18, 'Chuck 70 AT-CX Dia de Muertos', 'Converse', 2600000.00, 'CHUCK 70 AT-CX Dia de Muertos.png', 'Chuck 70 phiên bản Dia de Muertos.', '2025-12-12 18:41:44', 0),
(19, 'Chuck 70 Green High', 'Converse', 2100000.00, 'Chuck 70 green hi.png', 'Chuck 70 màu xanh lá.', '2025-12-12 18:41:44', 0),
(20, 'Chuck 70 Pink Low', 'Converse', 2100000.00, 'Chuck 70 pink low.png', 'Chuck 70 màu hồng bản low.', '2025-12-12 18:41:44', 0),
(21, 'Chuck 70 Seasonal Color', 'Converse', 2100000.00, 'CHUCK 70 SEASONAL COLOR CANVAS.png', 'Chuck 70 phối màu theo mùa.', '2025-12-12 18:41:44', 0),
(22, 'Chuck Taylor All Star 1970s Blue', 'Converse', 2000000.00, 'Chuck Taylor All Star 1970s .png', 'Chuck Taylor All Star 1970s màu xanh.', '2025-12-12 18:41:44', 0),
(23, 'Chuck Taylor All Star 1970s Black', 'Converse', 2000000.00, 'Chuck Taylor All Star 1970s low black.png', 'Chuck 1970s bản thấp màu đen.', '2025-12-12 18:41:44', 0),
(24, 'Chuck Taylor All Star 1970s White', 'Converse', 2000000.00, 'Chuck Taylor All Star 1970s white.png', 'Chuck 1970s màu trắng.', '2025-12-12 18:41:44', 0),
(25, 'Chuck Taylor Lift Dia de Muertos', 'Converse', 2300000.00, 'CHUCK TAYLOR ALL STAR LIFT Dia de Muertos.png', 'Chuck Taylor platform phiên bản đặc biệt.', '2025-12-12 18:41:44', 0),
(26, 'Converse x Brain Dead Chuck 70', 'Converse', 3500000.00, 'Converse x Brain Dead Chuck 70 hi.png', 'Hợp tác Converse x Brain Dead.', '2025-12-12 18:41:44', 0),
(27, 'Vans Knu Skool Pink', 'Vans', 1900000.00, 'Knu Skool Ping.png', 'Vans Knu Skool màu hồng.', '2025-12-12 18:41:44', 0),
(28, 'Vans LX Authentic 44', 'Vans', 1800000.00, 'LX Authentic 44.png', 'Authentic 44 cổ điển.', '2025-12-12 18:41:44', 0),
(29, 'Vans LX Old Skool', 'Vans', 1900000.00, 'LX Old Skool.png', 'Old Skool phối màu đặc biệt.', '2025-12-12 18:41:44', 0),
(30, 'Vans MTE Slip-On 98 Reissue', 'Vans', 2100000.00, 'Mte Slip-On Reissue 98.png', 'Slip-on phiên bản MTE.', '2025-12-12 18:41:44', 0),
(31, 'Vans MTE Ultrarange 2.0 SE', 'Vans', 2600000.00, 'MTE Ultrarange 2.0 SE.png', 'Ultrarange địa hình thế hệ mới.', '2025-12-12 18:41:44', 0),
(32, 'Vans MTE Ultrarange 2.0 SEE White', 'Vans', 2600000.00, 'MTE Ultrarange 2.0 SEe.png', 'Ultrarange 2.0 bản SE.', '2025-12-12 18:41:44', 0),
(33, 'Vans Old Skool Skate 36', 'Vans', 1900000.00, 'Skate Old Skool 36+.png', 'Old Skool Skate dành cho trượt ván.', '2025-12-12 18:41:44', 0),
(34, 'Vans Sk8-Hi Black', 'Vans', 2100000.00, 'Vans Sk8-Hi Black.png', 'Sk8-Hi màu đen cổ cao.', '2025-12-12 18:41:44', 0),
(35, 'NETBURNER BALLISTIC FF 3', 'Asics', 2600000.00, 'NETBURNER BALLISTIC FF 3.png', 'Giày bóng chuyền Asics cao cấp.', '2025-12-12 18:42:03', 0),
(36, 'Run Star Hike', 'Converse', 2600000.00, 'Run Star Hike.png', 'Run Star Hike đế cao phong cách.', '2025-12-12 18:42:03', 0),
(37, 'Run Star Legacy CX', 'Converse', 2700000.00, 'RUN STAR LEGACY CX.png', 'Run Star Legacy CX đế mềm CX.', '2025-12-12 18:42:03', 10),
(40, 'Converse x CDG Chuck 70', 'Converse', 3000000.00, 'Converse x CDG Chuck 70.png', 'haha', '2025-12-13 09:05:08', 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','customer') COLLATE utf8mb4_unicode_ci DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `phone`, `address`, `password`, `role`, `created_at`, `avatar`) VALUES
(1, 'Thái Văn Huy', 'admin0', 'vhuynee107@gmail.com', NULL, NULL, 'admin0', 'admin', '2025-12-12 17:57:43', 'admin_1.jpg'),
(4, 'Thái Văn Huy', 'hhuyy107', 'hhuyy107@gmail.com', '0962739043', 'Cầu Đất - Đà Lạt - Lâm Đồng', 'hhuyy107', 'customer', '2025-12-13 07:31:36', '1765611153_1.jpg'),
(5, 'Nguyễn Thị Yến Vy', 'vycutehehe19', 'vycutehehe19@gmail.com', '0912345678', 'Đà Lạt', 'vycutehehe19', 'customer', '2025-12-13 08:03:12', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
