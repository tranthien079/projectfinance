-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 20, 2023 lúc 03:42 PM
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
-- Cơ sở dữ liệu: `finance2`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `type` varchar(16) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `accounts`
--

INSERT INTO `accounts` (`id`, `user`, `name`, `balance`, `type`, `status`, `created_at`, `updated_at`) VALUES
(0, NULL, 'Other', 0, 'Bank', 'Active', '2019-02-21 07:21:51', '2019-02-21 13:33:07'),
(1, 1, 'Paypal', -13888889, 'E-Wallet', 'Active', '2019-02-21 07:08:32', '2023-10-05 08:03:22'),
(2, 1, 'My Bank', -100001111111, 'Bank', 'Active', '2019-02-21 07:21:51', '2023-10-18 11:34:37'),
(3, 1, 'Cash', -20088908889, 'Cash', 'Active', '2019-02-22 07:46:08', '2023-10-19 04:57:26'),
(4, 1, 'Credit Card', -2011791027808, 'Card', 'Active', '2019-02-22 07:46:38', '2023-10-19 03:40:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookbank`
--

CREATE TABLE `bookbank` (
  `id` int(11) NOT NULL,
  `namebb` varchar(200) NOT NULL,
  `namebank` varchar(100) NOT NULL,
  `senddate` date NOT NULL,
  `term` int(11) NOT NULL,
  `interest` float NOT NULL,
  `nonterminterest` float NOT NULL,
  `numberdaysinterest` int(11) NOT NULL,
  `payinterest` enum('end','begin','monthlyperiod') NOT NULL DEFAULT 'end',
  `amount` double NOT NULL,
  `Finalizefund` enum('renewpandi','renewp','finalize') NOT NULL DEFAULT 'renewpandi',
  `interpretation` varchar(200) NOT NULL,
  `status` enum('settled','notyet') DEFAULT 'notyet',
  `account` int(11) DEFAULT NULL,
  `user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('Income','Expense') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `budget` double NOT NULL DEFAULT 0,
  `id_catalog` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `user`, `name`, `type`, `budget`, `id_catalog`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ăn uống', 'Expense', 31805347, 0, '2019-02-09 10:15:08', '2023-10-18 08:54:41'),
(2, 1, 'Đi chợ', 'Expense', 0, 1, '2019-02-19 13:05:06', '2023-10-18 08:50:52'),
(3, 1, 'Ăn tiệm', 'Expense', 0, 1, '2019-02-19 13:05:17', '2023-10-18 08:51:08'),
(4, 1, 'Cafe', 'Expense', 0, 1, '2019-02-19 13:19:50', '2023-10-18 08:52:58'),
(8, 1, 'Ăn sáng', 'Expense', 0, 1, '2019-02-22 07:52:58', '2023-10-18 08:52:55'),
(9, 1, 'Ăn trưa', 'Expense', 0, 1, '2021-03-14 00:41:55', '2023-10-18 08:52:53'),
(10, 1, 'Ăn tối', 'Expense', 0, 1, '2021-03-14 00:41:55', '2023-10-18 08:52:51'),
(11, 1, 'Dịch vụ sinh hoạt', 'Expense', 0, 0, '2021-03-14 00:41:55', '2023-10-18 08:56:21'),
(12, 1, 'Điện', 'Expense', 0, 11, '2023-10-18 08:52:41', '2023-10-18 08:56:13'),
(13, 1, 'Nước', 'Expense', 0, 11, '2023-10-18 08:55:46', '2023-10-18 08:56:10'),
(14, 1, 'Internet', 'Expense', 0, 11, '2023-10-18 08:57:30', '2023-10-18 08:57:30'),
(15, 1, 'Điện thoại di dộng', 'Expense', 0, 11, '2023-10-18 08:57:41', '2023-10-18 08:58:04'),
(16, 1, 'Gas', 'Expense', 0, 11, '2023-10-18 08:58:15', '2023-10-18 09:00:06'),
(17, 1, 'Truyền hình', 'Expense', 0, 11, '2023-10-18 08:58:27', '2023-10-18 09:00:13'),
(18, 1, 'Điện thoại cố định', 'Expense', 0, 11, '2023-10-18 08:58:35', '2023-10-18 09:00:16'),
(19, 1, 'Thuê người giúp việc', 'Expense', 0, 11, '2023-10-18 08:58:44', '2023-10-18 09:00:20'),
(20, 1, 'Đi lại', 'Expense', 0, 0, '2023-10-18 08:58:47', '2023-10-18 09:00:50'),
(21, 1, 'Xăng xe', 'Expense', 0, 20, '2023-10-18 09:01:02', '2023-10-18 09:04:32'),
(22, 1, 'Bảo hiểm xe', 'Expense', 0, 20, '2023-10-18 09:01:08', '2023-10-18 09:04:33'),
(23, 1, 'Sửa chữa, bảo dưỡng xe', 'Expense', 0, 20, '2023-10-18 09:01:15', '2023-10-18 09:04:35'),
(24, 1, 'Gửi xe', 'Expense', 0, 20, '2023-10-18 09:01:18', '2023-10-18 09:04:36'),
(25, 1, 'Rửa xe', 'Expense', 0, 20, '2023-10-18 09:01:21', '2023-10-18 09:04:36'),
(26, 1, 'Taxi/thuê xe', 'Expense', 0, 20, '2023-10-18 09:01:33', '2023-10-18 09:04:44'),
(27, 1, 'Con cái', 'Expense', 0, 0, '2023-10-18 09:04:53', '2023-10-18 09:06:53'),
(28, 1, 'Học phí', 'Expense', 0, 27, '2023-10-18 09:04:57', '2023-10-18 09:07:01'),
(29, 1, 'Sách vở', 'Expense', 0, 27, '2023-10-18 09:05:22', '2023-10-18 09:07:08'),
(30, 1, 'Sữa', 'Expense', 0, 27, '2023-10-18 09:05:28', '2023-10-18 09:07:18'),
(31, 1, 'Đồ chơi', 'Expense', 0, 27, '2023-10-18 09:05:34', '2023-10-18 09:07:29'),
(32, 1, 'Tiền tiêu vặt', 'Expense', 0, 27, '2023-10-18 09:05:54', '2023-10-18 09:07:32'),
(33, 1, 'Trang phục', 'Expense', 0, 0, '2023-10-18 09:08:44', '2023-10-18 09:12:07'),
(34, 1, 'Quần áo', 'Expense', 0, 33, '2023-10-18 09:08:47', '2023-10-18 09:14:39'),
(35, 1, 'Giày dép', 'Expense', 0, 33, '2023-10-18 09:08:59', '2023-10-18 09:14:40'),
(36, 1, 'Phụ kiện khác', 'Expense', 0, 33, '2023-10-18 09:09:03', '2023-10-18 09:14:42'),
(37, 1, 'Hiếu hỉ', 'Expense', 0, 0, '2023-10-18 09:09:13', '2023-10-18 09:15:16'),
(38, 1, 'Cưới xin', 'Expense', 0, 37, '2023-10-18 09:09:18', '2023-10-18 09:14:58'),
(39, 1, 'Ma chay', 'Expense', 0, 37, '2023-10-18 09:09:21', '2023-10-18 09:15:01'),
(40, 1, 'Thăm hỏi', 'Expense', 0, 37, '2023-10-18 09:09:25', '2023-10-18 09:15:02'),
(41, 1, 'Biếu tặng', 'Expense', 0, 37, '2023-10-18 09:09:31', '2023-10-18 09:15:20'),
(42, 1, 'Sức khỏe', 'Expense', 0, 0, '2023-10-18 09:09:45', '2023-10-18 09:18:30'),
(43, 1, 'Khám chữa bệnh', 'Expense', 0, 42, '2023-10-18 09:09:50', '2023-10-18 09:16:12'),
(44, 1, 'Thuốc men', 'Expense', 0, 42, '2023-10-18 09:09:57', '2023-10-18 09:16:15'),
(45, 1, 'Thể thao', 'Expense', 0, 42, '2023-10-18 09:10:02', '2023-10-18 09:16:16'),
(46, 1, 'Nhà cửa', 'Expense', 0, 0, '2023-10-18 09:10:06', '2023-10-18 09:18:32'),
(47, 1, 'Mua sắm đồ đạc', 'Expense', 0, 46, '2023-10-18 09:10:11', '2023-10-18 09:17:30'),
(48, 1, 'Sửa chữa nhà cửa', 'Expense', 0, 46, '2023-10-18 09:10:14', '2023-10-18 09:17:32'),
(49, 1, 'Thuê nhà', 'Expense', 0, 46, '2023-10-18 09:10:22', '2023-10-18 09:17:34'),
(50, 1, 'Hưởng thụ', 'Expense', 0, 0, '2023-10-18 09:10:26', '2023-10-18 09:18:36'),
(51, 1, 'Vui chơi giải trí', 'Expense', 0, 50, '2023-10-18 09:10:30', '2023-10-18 09:18:15'),
(52, 1, 'Du lịch', 'Expense', 0, 50, '2023-10-18 09:10:34', '2023-10-18 09:18:18'),
(53, 1, 'Làm đẹp', 'Expense', 0, 50, '2023-10-18 09:10:38', '2023-10-18 09:18:19'),
(54, 1, 'Phim ảnh ca nhạc', 'Expense', 0, 50, '2023-10-18 09:10:45', '2023-10-18 09:18:20'),
(55, 1, 'Phát triển bản thân', 'Expense', 0, 0, '2023-10-18 09:18:59', '2023-10-18 09:20:38'),
(56, 1, 'Học hành', 'Expense', 0, 55, '2023-10-18 09:19:06', '2023-10-18 09:20:18'),
(57, 1, 'Giao lưu, quan hệ', 'Expense', 0, 55, '2023-10-18 09:19:10', '2023-10-18 09:20:21'),
(58, 1, 'Ngân hàng', 'Expense', 0, 0, '2023-10-18 09:19:15', '2023-10-18 09:20:42'),
(59, 1, 'Phí chuyển khoản', 'Expense', 0, 58, '2023-10-18 09:19:21', '2023-10-18 09:20:48'),
(60, 1, 'Lương', 'Income', 0, NULL, '2023-10-18 09:21:08', '2023-10-18 09:23:50'),
(61, 1, 'Thưởng', 'Income', 0, NULL, '2023-10-18 09:21:42', '2023-10-18 09:23:45'),
(62, 1, 'Được cho/tặng', 'Income', 0, NULL, '2023-10-18 09:21:47', '2023-10-18 09:23:13'),
(63, 1, 'Tiền lãi', 'Income', 0, NULL, '2023-10-18 09:22:03', '2023-10-18 09:23:15'),
(64, 1, 'Khác', 'Income', 0, NULL, '2023-10-18 09:22:11', '2023-10-18 09:23:14'),
(65, 1, 'Lãi tiết kiệm', 'Income', 0, NULL, '2023-10-18 09:22:28', '2023-10-18 09:23:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_expense`
--

CREATE TABLE `category_expense` (
  `id` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_expense` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category_expense`
--

INSERT INTO `category_expense` (`id`, `id_category`, `id_expense`) VALUES
(25, 3, 31),
(26, 2, 31),
(27, 58, 32),
(28, 59, 32),
(42, 59, 34),
(43, 55, 34),
(44, 57, 34),
(45, 56, 34);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(56) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`) VALUES
(1, 'United Arab Emirates Dirham', 'AED'),
(4, 'Armenia Dram', 'AMD'),
(5, 'Netherlands Antilles Guilder', 'ANG'),
(7, 'Argentina Peso', 'ARS'),
(8, 'Australia Dollar', 'AUD'),
(9, 'Aruba Guilder', 'AWG'),
(11, 'Bosnia and Herzegovina Convertible Marka', 'BAM'),
(13, 'Bangladesh Taka', 'BDT'),
(15, 'Bahrain Dinar', 'BHD'),
(17, 'Bermuda Dollar', 'BMD'),
(18, 'Brunei Darussalam Dollar', 'BND'),
(19, 'Bolivia Boliviano', 'BOB'),
(20, 'Brazil Real', 'BRL'),
(21, 'Bahamas Dollar', 'BSD'),
(24, 'Botswana Pula', 'BWP'),
(26, 'Belize Dollar', 'BZD'),
(27, 'Canada Dollar', 'CAD'),
(29, 'Switzerland Franc', 'CHF'),
(30, 'Chile Peso', 'CLP'),
(31, 'China Yuan Renminbi', 'CNY'),
(32, 'Colombia Peso', 'COP'),
(33, 'Costa Rica Colon', 'CRC'),
(34, 'Cuba Convertible Peso', 'CUC'),
(35, 'Cuba Peso', 'CUP'),
(37, 'Czech ReKoruna', 'CZK'),
(39, 'Denmark Krone', 'DKK'),
(40, 'Dominican RePeso', 'DOP'),
(42, 'Egypt Pound', 'EGP'),
(45, 'Euro Member Countries', 'EUR'),
(48, 'United Kingdom Pound', 'GBP'),
(52, 'Gibraltar Pound', 'GIP'),
(55, 'Guatemala Quetzal', 'GTQ'),
(57, 'Hong Kong Dollar', 'HKD'),
(58, 'Honduras Lempira', 'HNL'),
(59, 'Croatia Kuna', 'HRK'),
(61, 'Hungary Forint', 'HUF'),
(62, 'Indonesia Rupiah', 'IDR'),
(63, 'Israel Shekel', 'ILS'),
(65, 'India Rupee', 'INR'),
(67, 'Iran Rial', 'IRR'),
(68, 'Iceland Krona', 'ISK'),
(70, 'Jamaica Dollar', 'JMD'),
(71, 'Jordan Dinar', 'JOD'),
(72, 'Japan Yen', 'JPY'),
(73, 'Kenya Shilling', 'KES'),
(78, 'Korea (South) Won', 'KRW'),
(79, 'Kuwait Dinar', 'KWD'),
(80, 'Cayman Islands Dollar', 'KYD'),
(83, 'Lebanon Pound', 'LBP'),
(87, 'Lithuania Litas', 'LTL'),
(88, 'Latvia Lat', 'LVL'),
(93, 'Macedonia Denar', 'MKD'),
(98, 'Mauritius Rupee', 'MUR'),
(101, 'Mexico Peso', 'MXN'),
(102, 'Malaysia Ringgit', 'MYR'),
(107, 'Norway Krone', 'NOK'),
(108, 'Nepal Rupee', 'NPR'),
(109, 'New Zealand Dollar', 'NZD'),
(110, 'Oman Rial', 'OMR'),
(112, 'Peru Nuevo Sol', 'PEN'),
(114, 'Philippines Peso', 'PHP'),
(115, 'Pakistan Rupee', 'PKR'),
(116, 'Poland Zloty', 'PLN'),
(119, 'Romania New Leu', 'RON'),
(121, 'Russia Ruble', 'RUB'),
(123, 'Saudi Arabia Riyal', 'SAR'),
(127, 'Sweden Krona', 'SEK'),
(128, 'Singapore Dollar', 'SGD'),
(135, 'El Salvador Colon', 'SVC'),
(137, 'Swaziland Lilangeni', 'SZL'),
(138, 'Thailand Baht', 'THB'),
(142, 'Tonga Paanga', 'TOP'),
(143, 'Turkey Lira', 'TRY'),
(147, 'Tanzania Shilling', 'TZS'),
(148, 'Ukraine Hryvna', 'UAH'),
(150, 'United States Dollar', 'USD'),
(151, 'Uruguay Peso', 'UYU'),
(153, 'Venezuela Bolivar', 'VEF'),
(154, 'Viet Nam Dong', 'VND'),
(155, 'Vanuatu Vatu', 'VUV'),
(158, 'East Caribbean Dollar', 'XCD'),
(163, 'South Africa Rand', 'ZAR'),
(164, 'Zimbabwe Dollar', 'ZWD');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `directory`
--

CREATE TABLE `directory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `directory`
--

INSERT INTO `directory` (`id`, `name`, `user`) VALUES
(1, 'Vỹ', 1),
(2, 'Thảo nhi', 1),
(3, 'Hoa Tiến', 1),
(4, 'Phương', 1),
(5, 'Thiện Lê', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `expensedetail`
--

CREATE TABLE `expensedetail` (
  `id` int(11) NOT NULL,
  `expense` int(11) NOT NULL,
  `directory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `account` int(11) DEFAULT 0,
  `expense_date` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `expenses`
--

INSERT INTO `expenses` (`id`, `user`, `title`, `amount`, `account`, `expense_date`, `updated_at`) VALUES
(31, 1, 'ấdas', 11111111, 2, '2023-10-17', '2023-10-18 11:34:37'),
(32, 1, 'Thien thang 10', 100000, 4, '2023-10-06', '2023-10-18 11:52:50'),
(34, 1, 'tien ngay 19 thang 10', 123123, 2, '2023-10-18', '2023-10-19 04:57:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `account` int(11) DEFAULT NULL,
  `income_group` varchar(255) DEFAULT NULL,
  `category` int(11) DEFAULT 0,
  `income_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `income`
--

INSERT INTO `income` (`id`, `user`, `title`, `amount`, `account`, `income_group`, `category`, `income_date`, `created_at`, `updated_at`) VALUES
(11, 1, 'đâsd', 111111, 1, NULL, 10, '2023-09-25', '2023-09-25 15:39:07', '2023-09-25 15:39:07'),
(12, 1, 'sadasdsd', 11111111, 3, NULL, 9, '2023-09-25', '2023-09-25 15:39:46', '2023-09-25 15:39:46'),
(14, 1, 'ádasda', 3123123, 3, NULL, 11, '2023-09-23', '2023-09-25 15:43:32', '2023-09-25 15:43:32'),
(17, 1, 'adasdas', 11111111, 4, NULL, 10, '2023-09-28', '2023-10-01 12:20:12', '2023-10-01 12:20:12'),
(19, 1, 'luong 10000000', 10000000, 2, NULL, 9, '2023-11-18', '2023-10-01 13:57:20', '2023-10-01 13:57:20'),
(20, 1, 'luong thien tra tien 1h06', 10000000, 4, NULL, 65, '2023-10-07', '2023-10-01 13:59:58', '2023-10-01 13:59:58'),
(21, 1, 'ádasdas', 10000000, 3, NULL, 10, '2023-10-19', '2023-10-02 09:05:28', '2023-10-02 09:05:28'),
(22, 1, 'ádasd', 1000000000, 1, NULL, 10, '2023-10-04', '2023-10-05 08:03:22', '2023-10-05 08:03:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `incomedetail`
--

CREATE TABLE `incomedetail` (
  `id` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `directory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `timezones`
--

CREATE TABLE `timezones` (
  `id` int(11) NOT NULL,
  `name` varchar(31) NOT NULL,
  `zone` varchar(272) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `timezones`
--

INSERT INTO `timezones` (`id`, `name`, `zone`) VALUES
(1, '(UTC-11:00) Pacific/Pago_Pago', 'Pacific/Pago_Pago'),
(2, '(UTC-11:00) Pacific/Niue', 'Pacific/Niue'),
(3, '(UTC-11:00) Pacific/Midway', 'Pacific/Midway'),
(4, '(UTC-10:00) Pacific/Tahiti', 'Pacific/Tahiti'),
(5, '(UTC-10:00) America/Adak', 'America/Adak'),
(6, '(UTC-10:00) Pacific/Rarotonga', 'Pacific/Rarotonga'),
(7, '(UTC-10:00) Pacific/Honolulu', 'Pacific/Honolulu'),
(8, '(UTC-09:30) Pacific/Marquesas', 'Pacific/Marquesas'),
(9, '(UTC-09:00) Pacific/Gambier', 'Pacific/Gambier'),
(10, '(UTC-09:00) America/Sitka', 'America/Sitka'),
(11, '(UTC-09:00) America/Anchorage', 'America/Anchorage'),
(12, '(UTC-09:00) America/Yakutat', 'America/Yakutat'),
(13, '(UTC-09:00) America/Metlakatla', 'America/Metlakatla'),
(14, '(UTC-09:00) America/Juneau', 'America/Juneau'),
(15, '(UTC-09:00) America/Nome', 'America/Nome'),
(16, '(UTC-08:00) Pacific/Pitcairn', 'Pacific/Pitcairn'),
(17, '(UTC-08:00) America/Tijuana', 'America/Tijuana'),
(18, '(UTC-08:00) America/Vancouver', 'America/Vancouver'),
(19, '(UTC-08:00) America/Los_Angeles', 'America/Los_Angeles'),
(20, '(UTC-08:00) America/Whitehorse', 'America/Whitehorse'),
(21, '(UTC-08:00) America/Dawson', 'America/Dawson'),
(22, '(UTC-07:00) America/Cambridge_B', 'America/Cambridge_Bay'),
(23, '(UTC-07:00) America/Mazatlan', 'America/Mazatlan'),
(24, '(UTC-07:00) America/Boise', 'America/Boise'),
(25, '(UTC-07:00) America/Creston', 'America/Creston'),
(26, '(UTC-07:00) America/Yellowknife', 'America/Yellowknife'),
(27, '(UTC-07:00) America/Phoenix', 'America/Phoenix'),
(28, '(UTC-07:00) America/Chihuahua', 'America/Chihuahua'),
(29, '(UTC-07:00) America/Dawson_Cree', 'America/Dawson_Creek'),
(30, '(UTC-07:00) America/Inuvik', 'America/Inuvik'),
(31, '(UTC-07:00) America/Ojinaga', 'America/Ojinaga'),
(32, '(UTC-07:00) America/Denver', 'America/Denver'),
(33, '(UTC-07:00) America/Edmonton', 'America/Edmonton'),
(34, '(UTC-07:00) America/Hermosillo', 'America/Hermosillo'),
(35, '(UTC-07:00) America/Fort_Nelson', 'America/Fort_Nelson'),
(36, '(UTC-06:00) America/El_Salvador', 'America/El_Salvador'),
(37, '(UTC-06:00) America/Indiana/Tel', 'America/Indiana/Tell_City'),
(38, '(UTC-06:00) America/Costa_Rica', 'America/Costa_Rica'),
(39, '(UTC-06:00) America/Indiana/Kno', 'America/Indiana/Knox'),
(40, '(UTC-06:00) America/Bahia_Bande', 'America/Bahia_Banderas'),
(41, '(UTC-06:00) America/Guatemala', 'America/Guatemala'),
(42, '(UTC-06:00) America/Belize', 'America/Belize'),
(43, '(UTC-06:00) America/Managua', 'America/Managua'),
(44, '(UTC-06:00) America/Swift_Curre', 'America/Swift_Current'),
(45, '(UTC-06:00) America/Mexico_City', 'America/Mexico_City'),
(46, '(UTC-06:00) America/Resolute', 'America/Resolute'),
(47, '(UTC-06:00) America/Regina', 'America/Regina'),
(48, '(UTC-06:00) America/Rankin_Inle', 'America/Rankin_Inlet'),
(49, '(UTC-06:00) America/Rainy_River', 'America/Rainy_River'),
(50, '(UTC-06:00) America/North_Dakot', 'America/North_Dakota/New_Salem'),
(51, '(UTC-06:00) America/North_Dakot', 'America/North_Dakota/Center'),
(52, '(UTC-06:00) America/North_Dakot', 'America/North_Dakota/Beulah'),
(53, '(UTC-06:00) America/Tegucigalpa', 'America/Tegucigalpa'),
(54, '(UTC-06:00) America/Monterrey', 'America/Monterrey'),
(55, '(UTC-06:00) Pacific/Galapagos', 'Pacific/Galapagos'),
(56, '(UTC-06:00) America/Chicago', 'America/Chicago'),
(57, '(UTC-06:00) America/Merida', 'America/Merida'),
(58, '(UTC-06:00) America/Winnipeg', 'America/Winnipeg'),
(59, '(UTC-06:00) America/Menominee', 'America/Menominee'),
(60, '(UTC-06:00) America/Matamoros', 'America/Matamoros'),
(61, '(UTC-05:00) America/Iqaluit', 'America/Iqaluit'),
(62, '(UTC-05:00) America/Rio_Branco', 'America/Rio_Branco'),
(63, '(UTC-05:00) America/Lima', 'America/Lima'),
(64, '(UTC-05:00) America/Kentucky/Mo', 'America/Kentucky/Monticello'),
(65, '(UTC-05:00) America/Kentucky/Lo', 'America/Kentucky/Louisville'),
(66, '(UTC-05:00) America/Cayman', 'America/Cayman'),
(67, '(UTC-05:00) America/Pangnirtung', 'America/Pangnirtung'),
(68, '(UTC-05:00) America/Panama', 'America/Panama'),
(69, '(UTC-05:00) America/Jamaica', 'America/Jamaica'),
(70, '(UTC-05:00) America/Detroit', 'America/Detroit'),
(71, '(UTC-05:00) America/Indiana/Win', 'America/Indiana/Winamac'),
(72, '(UTC-05:00) America/Eirunepe', 'America/Eirunepe'),
(73, '(UTC-05:00) America/Indiana/Vin', 'America/Indiana/Vincennes'),
(74, '(UTC-05:00) America/New_York', 'America/New_York'),
(75, '(UTC-05:00) America/Grand_Turk', 'America/Grand_Turk'),
(76, '(UTC-05:00) America/Nassau', 'America/Nassau'),
(77, '(UTC-05:00) America/Guayaquil', 'America/Guayaquil'),
(78, '(UTC-05:00) America/Havana', 'America/Havana'),
(79, '(UTC-05:00) America/Indiana/Ind', 'America/Indiana/Indianapolis'),
(80, '(UTC-05:00) America/Indiana/Mar', 'America/Indiana/Marengo'),
(81, '(UTC-05:00) America/Indiana/Pet', 'America/Indiana/Petersburg'),
(82, '(UTC-05:00) America/Indiana/Vev', 'America/Indiana/Vevay'),
(83, '(UTC-05:00) America/Nipigon', 'America/Nipigon'),
(84, '(UTC-05:00) America/Port-au-Pri', 'America/Port-au-Prince'),
(85, '(UTC-05:00) America/Thunder_Bay', 'America/Thunder_Bay'),
(86, '(UTC-05:00) America/Cancun', 'America/Cancun'),
(87, '(UTC-05:00) America/Bogota', 'America/Bogota'),
(88, '(UTC-05:00) Pacific/Easter', 'Pacific/Easter'),
(89, '(UTC-05:00) America/Toronto', 'America/Toronto'),
(90, '(UTC-05:00) America/Atikokan', 'America/Atikokan'),
(91, '(UTC-04:00) America/Marigot', 'America/Marigot'),
(92, '(UTC-04:00) America/St_Barthele', 'America/St_Barthelemy'),
(93, '(UTC-04:00) America/St_Kitts', 'America/St_Kitts'),
(94, '(UTC-04:00) America/St_Lucia', 'America/St_Lucia'),
(95, '(UTC-04:00) America/La_Paz', 'America/La_Paz'),
(96, '(UTC-04:00) America/St_Thomas', 'America/St_Thomas'),
(97, '(UTC-04:00) America/St_Vincent', 'America/St_Vincent'),
(98, '(UTC-04:00) America/Lower_Princ', 'America/Lower_Princes'),
(99, '(UTC-04:00) America/Thule', 'America/Thule'),
(100, '(UTC-04:00) America/Manaus', 'America/Manaus'),
(101, '(UTC-04:00) America/Caracas', 'America/Caracas'),
(102, '(UTC-04:00) America/Martinique', 'America/Martinique'),
(103, '(UTC-04:00) America/Antigua', 'America/Antigua'),
(104, '(UTC-04:00) America/Tortola', 'America/Tortola'),
(105, '(UTC-04:00) America/Moncton', 'America/Moncton'),
(106, '(UTC-04:00) America/Montserrat', 'America/Montserrat'),
(107, '(UTC-04:00) Atlantic/Bermuda', 'Atlantic/Bermuda'),
(108, '(UTC-04:00) America/Santo_Domin', 'America/Santo_Domingo'),
(109, '(UTC-04:00) America/Port_of_Spa', 'America/Port_of_Spain'),
(110, '(UTC-04:00) America/Porto_Velho', 'America/Porto_Velho'),
(111, '(UTC-04:00) America/Puerto_Rico', 'America/Puerto_Rico'),
(112, '(UTC-04:00) America/Anguilla', 'America/Anguilla'),
(113, '(UTC-04:00) America/Kralendijk', 'America/Kralendijk'),
(114, '(UTC-04:00) America/Halifax', 'America/Halifax'),
(115, '(UTC-04:00) America/Curacao', 'America/Curacao'),
(116, '(UTC-04:00) America/Barbados', 'America/Barbados'),
(117, '(UTC-04:00) America/Glace_Bay', 'America/Glace_Bay'),
(118, '(UTC-04:00) America/Goose_Bay', 'America/Goose_Bay'),
(119, '(UTC-04:00) America/Grenada', 'America/Grenada'),
(120, '(UTC-04:00) America/Guadeloupe', 'America/Guadeloupe'),
(121, '(UTC-04:00) America/Dominica', 'America/Dominica'),
(122, '(UTC-04:00) America/Blanc-Sablo', 'America/Blanc-Sablon'),
(123, '(UTC-04:00) America/Aruba', 'America/Aruba'),
(124, '(UTC-04:00) America/Guyana', 'America/Guyana'),
(125, '(UTC-04:00) America/Boa_Vista', 'America/Boa_Vista'),
(126, '(UTC-03:30) America/St_Johns', 'America/St_Johns'),
(127, '(UTC-03:00) America/Paramaribo', 'America/Paramaribo'),
(128, '(UTC-03:00) Atlantic/Stanley', 'Atlantic/Stanley'),
(129, '(UTC-03:00) America/Cuiaba', 'America/Cuiaba'),
(130, '(UTC-03:00) America/Santiago', 'America/Santiago'),
(131, '(UTC-03:00) America/Belem', 'America/Belem'),
(132, '(UTC-03:00) America/Miquelon', 'America/Miquelon'),
(133, '(UTC-03:00) America/Campo_Grand', 'America/Campo_Grande'),
(134, '(UTC-03:00) America/Argentina/S', 'America/Argentina/Salta'),
(135, '(UTC-03:00) America/Punta_Arena', 'America/Punta_Arenas'),
(136, '(UTC-03:00) Antarctica/Palmer', 'Antarctica/Palmer'),
(137, '(UTC-03:00) America/Recife', 'America/Recife'),
(138, '(UTC-03:00) America/Bahia', 'America/Bahia'),
(139, '(UTC-03:00) America/Montevideo', 'America/Montevideo'),
(140, '(UTC-03:00) Antarctica/Rothera', 'Antarctica/Rothera'),
(141, '(UTC-03:00) America/Asuncion', 'America/Asuncion'),
(142, '(UTC-03:00) America/Argentina/S', 'America/Argentina/San_Juan'),
(143, '(UTC-03:00) America/Argentina/R', 'America/Argentina/Rio_Gallegos'),
(144, '(UTC-03:00) America/Argentina/M', 'America/Argentina/Mendoza'),
(145, '(UTC-03:00) America/Argentina/L', 'America/Argentina/La_Rioja'),
(146, '(UTC-03:00) America/Argentina/J', 'America/Argentina/Jujuy'),
(147, '(UTC-03:00) America/Argentina/C', 'America/Argentina/Cordoba'),
(148, '(UTC-03:00) America/Argentina/C', 'America/Argentina/Catamarca'),
(149, '(UTC-03:00) America/Argentina/B', 'America/Argentina/Buenos_Aires'),
(150, '(UTC-03:00) America/Araguaina', 'America/Araguaina'),
(151, '(UTC-03:00) America/Argentina/U', 'America/Argentina/Ushuaia'),
(152, '(UTC-03:00) America/Santarem', 'America/Santarem'),
(153, '(UTC-03:00) America/Cayenne', 'America/Cayenne'),
(154, '(UTC-03:00) America/Argentina/S', 'America/Argentina/San_Luis'),
(155, '(UTC-03:00) America/Fortaleza', 'America/Fortaleza'),
(156, '(UTC-03:00) America/Maceio', 'America/Maceio'),
(157, '(UTC-03:00) America/Godthab', 'America/Godthab'),
(158, '(UTC-03:00) America/Argentina/T', 'America/Argentina/Tucuman'),
(159, '(UTC-02:00) America/Noronha', 'America/Noronha'),
(160, '(UTC-02:00) America/Sao_Paulo', 'America/Sao_Paulo'),
(161, '(UTC-02:00) Atlantic/South_Geor', 'Atlantic/South_Georgia'),
(162, '(UTC-01:00) Atlantic/Azores', 'Atlantic/Azores'),
(163, '(UTC-01:00) Atlantic/Cape_Verde', 'Atlantic/Cape_Verde'),
(164, '(UTC-01:00) America/Scoresbysun', 'America/Scoresbysund'),
(165, '(UTC+00:00) Atlantic/St_Helena', 'Atlantic/St_Helena'),
(166, '(UTC+00:00) Africa/Accra', 'Africa/Accra'),
(167, '(UTC+00:00) Atlantic/Reykjavik', 'Atlantic/Reykjavik'),
(168, '(UTC+00:00) Antarctica/Troll', 'Antarctica/Troll'),
(169, '(UTC+00:00) Atlantic/Faroe', 'Atlantic/Faroe'),
(170, '(UTC+00:00) Europe/London', 'Europe/London'),
(171, '(UTC+00:00) Europe/Lisbon', 'Europe/Lisbon'),
(172, '(UTC+00:00) Atlantic/Canary', 'Atlantic/Canary'),
(173, '(UTC+00:00) Europe/Jersey', 'Europe/Jersey'),
(174, '(UTC+00:00) Europe/Isle_of_Man', 'Europe/Isle_of_Man'),
(175, '(UTC+00:00) Europe/Guernsey', 'Europe/Guernsey'),
(176, '(UTC+00:00) Atlantic/Madeira', 'Atlantic/Madeira'),
(177, '(UTC+00:00) Africa/Abidjan', 'Africa/Abidjan'),
(178, '(UTC+00:00) Europe/Dublin', 'Europe/Dublin'),
(179, '(UTC+00:00) Africa/Monrovia', 'Africa/Monrovia'),
(180, '(UTC+00:00) America/Danmarkshav', 'America/Danmarkshavn'),
(181, '(UTC+00:00) Africa/El_Aaiun', 'Africa/El_Aaiun'),
(182, '(UTC+00:00) Africa/Freetown', 'Africa/Freetown'),
(183, '(UTC+00:00) Africa/Dakar', 'Africa/Dakar'),
(184, '(UTC+00:00) Africa/Conakry', 'Africa/Conakry'),
(185, '(UTC+00:00) Africa/Bissau', 'Africa/Bissau'),
(186, '(UTC+00:00) Africa/Lome', 'Africa/Lome'),
(187, '(UTC+00:00) Africa/Banjul', 'Africa/Banjul'),
(188, '(UTC+00:00) Africa/Bamako', 'Africa/Bamako'),
(189, '(UTC+00:00) Africa/Casablanca', 'Africa/Casablanca'),
(190, '(UTC+00:00) Africa/Nouakchott', 'Africa/Nouakchott'),
(191, '(UTC+00:00) Africa/Ouagadougou', 'Africa/Ouagadougou'),
(192, '(UTC+00:00) Africa/Sao_Tome', 'Africa/Sao_Tome'),
(193, '(UTC+01:00) Europe/Rome', 'Europe/Rome'),
(194, '(UTC+01:00) Europe/Budapest', 'Europe/Budapest'),
(195, '(UTC+01:00) Europe/San_Marino', 'Europe/San_Marino'),
(196, '(UTC+01:00) Europe/Sarajevo', 'Europe/Sarajevo'),
(197, '(UTC+01:00) Europe/Skopje', 'Europe/Skopje'),
(198, '(UTC+01:00) Europe/Stockholm', 'Europe/Stockholm'),
(199, '(UTC+01:00) Europe/Belgrade', 'Europe/Belgrade'),
(200, '(UTC+01:00) Europe/Podgorica', 'Europe/Podgorica'),
(201, '(UTC+01:00) Europe/Tirane', 'Europe/Tirane'),
(202, '(UTC+01:00) Europe/Vaduz', 'Europe/Vaduz'),
(203, '(UTC+01:00) Europe/Vatican', 'Europe/Vatican'),
(204, '(UTC+01:00) Europe/Busingen', 'Europe/Busingen'),
(205, '(UTC+01:00) Europe/Vienna', 'Europe/Vienna'),
(206, '(UTC+01:00) Europe/Copenhagen', 'Europe/Copenhagen'),
(207, '(UTC+01:00) Europe/Warsaw', 'Europe/Warsaw'),
(208, '(UTC+01:00) Europe/Prague', 'Europe/Prague'),
(209, '(UTC+01:00) Europe/Monaco', 'Europe/Monaco'),
(210, '(UTC+01:00) Europe/Paris', 'Europe/Paris'),
(211, '(UTC+01:00) Europe/Bratislava', 'Europe/Bratislava'),
(212, '(UTC+01:00) Europe/Amsterdam', 'Europe/Amsterdam'),
(213, '(UTC+01:00) Africa/Algiers', 'Africa/Algiers'),
(214, '(UTC+01:00) Europe/Berlin', 'Europe/Berlin'),
(215, '(UTC+01:00) Europe/Ljubljana', 'Europe/Ljubljana'),
(216, '(UTC+01:00) Africa/Bangui', 'Africa/Bangui'),
(217, '(UTC+01:00) Europe/Luxembourg', 'Europe/Luxembourg'),
(218, '(UTC+01:00) Africa/Brazzaville', 'Africa/Brazzaville'),
(219, '(UTC+01:00) Europe/Oslo', 'Europe/Oslo'),
(220, '(UTC+01:00) Europe/Zurich', 'Europe/Zurich'),
(221, '(UTC+01:00) Africa/Ceuta', 'Africa/Ceuta'),
(222, '(UTC+01:00) Europe/Brussels', 'Europe/Brussels'),
(223, '(UTC+01:00) Europe/Madrid', 'Europe/Madrid'),
(224, '(UTC+01:00) Europe/Malta', 'Europe/Malta'),
(225, '(UTC+01:00) Europe/Andorra', 'Europe/Andorra'),
(226, '(UTC+01:00) Europe/Zagreb', 'Europe/Zagreb'),
(227, '(UTC+01:00) Europe/Gibraltar', 'Europe/Gibraltar'),
(228, '(UTC+01:00) Africa/Ndjamena', 'Africa/Ndjamena'),
(229, '(UTC+01:00) Africa/Libreville', 'Africa/Libreville'),
(230, '(UTC+01:00) Africa/Malabo', 'Africa/Malabo'),
(231, '(UTC+01:00) Africa/Tunis', 'Africa/Tunis'),
(232, '(UTC+01:00) Africa/Kinshasa', 'Africa/Kinshasa'),
(233, '(UTC+01:00) Africa/Luanda', 'Africa/Luanda'),
(234, '(UTC+01:00) Africa/Porto-Novo', 'Africa/Porto-Novo'),
(235, '(UTC+01:00) Africa/Niamey', 'Africa/Niamey'),
(236, '(UTC+01:00) Africa/Douala', 'Africa/Douala'),
(237, '(UTC+01:00) Africa/Lagos', 'Africa/Lagos'),
(238, '(UTC+02:00) Africa/Maputo', 'Africa/Maputo'),
(239, '(UTC+02:00) Asia/Nicosia', 'Asia/Nicosia'),
(240, '(UTC+02:00) Africa/Lusaka', 'Africa/Lusaka'),
(241, '(UTC+02:00) Europe/Tallinn', 'Europe/Tallinn'),
(242, '(UTC+02:00) Africa/Lubumbashi', 'Africa/Lubumbashi'),
(243, '(UTC+02:00) Europe/Sofia', 'Europe/Sofia'),
(244, '(UTC+02:00) Europe/Vilnius', 'Europe/Vilnius'),
(245, '(UTC+02:00) Africa/Blantyre', 'Africa/Blantyre'),
(246, '(UTC+02:00) Africa/Bujumbura', 'Africa/Bujumbura'),
(247, '(UTC+02:00) Africa/Cairo', 'Africa/Cairo'),
(248, '(UTC+02:00) Africa/Kigali', 'Africa/Kigali'),
(249, '(UTC+02:00) Africa/Khartoum', 'Africa/Khartoum'),
(250, '(UTC+02:00) Asia/Amman', 'Asia/Amman'),
(251, '(UTC+02:00) Europe/Riga', 'Europe/Riga'),
(252, '(UTC+02:00) Europe/Mariehamn', 'Europe/Mariehamn'),
(253, '(UTC+02:00) Africa/Gaborone', 'Africa/Gaborone'),
(254, '(UTC+02:00) Europe/Uzhgorod', 'Europe/Uzhgorod'),
(255, '(UTC+02:00) Europe/Kiev', 'Europe/Kiev'),
(256, '(UTC+02:00) Africa/Johannesburg', 'Africa/Johannesburg'),
(257, '(UTC+02:00) Asia/Jerusalem', 'Asia/Jerusalem'),
(258, '(UTC+02:00) Asia/Damascus', 'Asia/Damascus'),
(259, '(UTC+02:00) Africa/Windhoek', 'Africa/Windhoek'),
(260, '(UTC+02:00) Europe/Chisinau', 'Europe/Chisinau'),
(261, '(UTC+02:00) Africa/Tripoli', 'Africa/Tripoli'),
(262, '(UTC+02:00) Asia/Famagusta', 'Asia/Famagusta'),
(263, '(UTC+02:00) Asia/Gaza', 'Asia/Gaza'),
(264, '(UTC+02:00) Asia/Hebron', 'Asia/Hebron'),
(265, '(UTC+02:00) Europe/Bucharest', 'Europe/Bucharest'),
(266, '(UTC+02:00) Europe/Athens', 'Europe/Athens'),
(267, '(UTC+02:00) Africa/Harare', 'Africa/Harare'),
(268, '(UTC+02:00) Europe/Zaporozhye', 'Europe/Zaporozhye'),
(269, '(UTC+02:00) Africa/Mbabane', 'Africa/Mbabane'),
(270, '(UTC+02:00) Europe/Helsinki', 'Europe/Helsinki'),
(271, '(UTC+02:00) Africa/Maseru', 'Africa/Maseru'),
(272, '(UTC+02:00) Asia/Beirut', 'Asia/Beirut'),
(273, '(UTC+02:00) Europe/Kaliningrad', 'Europe/Kaliningrad'),
(274, '(UTC+03:00) Africa/Mogadishu', 'Africa/Mogadishu'),
(275, '(UTC+03:00) Europe/Kirov', 'Europe/Kirov'),
(276, '(UTC+03:00) Africa/Addis_Ababa', 'Africa/Addis_Ababa'),
(277, '(UTC+03:00) Africa/Kampala', 'Africa/Kampala'),
(278, '(UTC+03:00) Europe/Istanbul', 'Europe/Istanbul'),
(279, '(UTC+03:00) Africa/Asmara', 'Africa/Asmara'),
(280, '(UTC+03:00) Africa/Juba', 'Africa/Juba'),
(281, '(UTC+03:00) Europe/Minsk', 'Europe/Minsk'),
(282, '(UTC+03:00) Antarctica/Syowa', 'Antarctica/Syowa'),
(283, '(UTC+03:00) Africa/Nairobi', 'Africa/Nairobi'),
(284, '(UTC+03:00) Indian/Mayotte', 'Indian/Mayotte'),
(285, '(UTC+03:00) Europe/Moscow', 'Europe/Moscow'),
(286, '(UTC+03:00) Asia/Riyadh', 'Asia/Riyadh'),
(287, '(UTC+03:00) Indian/Comoro', 'Indian/Comoro'),
(288, '(UTC+03:00) Indian/Antananarivo', 'Indian/Antananarivo'),
(289, '(UTC+03:00) Africa/Dar_es_Salaa', 'Africa/Dar_es_Salaam'),
(290, '(UTC+03:00) Africa/Djibouti', 'Africa/Djibouti'),
(291, '(UTC+03:00) Europe/Volgograd', 'Europe/Volgograd'),
(292, '(UTC+03:00) Asia/Kuwait', 'Asia/Kuwait'),
(293, '(UTC+03:00) Asia/Aden', 'Asia/Aden'),
(294, '(UTC+03:00) Asia/Baghdad', 'Asia/Baghdad'),
(295, '(UTC+03:00) Asia/Qatar', 'Asia/Qatar'),
(296, '(UTC+03:00) Europe/Simferopol', 'Europe/Simferopol'),
(297, '(UTC+03:00) Asia/Bahrain', 'Asia/Bahrain'),
(298, '(UTC+03:30) Asia/Tehran', 'Asia/Tehran'),
(299, '(UTC+04:00) Europe/Saratov', 'Europe/Saratov'),
(300, '(UTC+04:00) Asia/Baku', 'Asia/Baku'),
(301, '(UTC+04:00) Indian/Reunion', 'Indian/Reunion'),
(302, '(UTC+04:00) Asia/Tbilisi', 'Asia/Tbilisi'),
(303, '(UTC+04:00) Europe/Samara', 'Europe/Samara'),
(304, '(UTC+04:00) Asia/Yerevan', 'Asia/Yerevan'),
(305, '(UTC+04:00) Asia/Muscat', 'Asia/Muscat'),
(306, '(UTC+04:00) Europe/Ulyanovsk', 'Europe/Ulyanovsk'),
(307, '(UTC+04:00) Indian/Mahe', 'Indian/Mahe'),
(308, '(UTC+04:00) Asia/Dubai', 'Asia/Dubai'),
(309, '(UTC+04:00) Indian/Mauritius', 'Indian/Mauritius'),
(310, '(UTC+04:00) Europe/Astrakhan', 'Europe/Astrakhan'),
(311, '(UTC+04:30) Asia/Kabul', 'Asia/Kabul'),
(312, '(UTC+05:00) Indian/Kerguelen', 'Indian/Kerguelen'),
(313, '(UTC+05:00) Asia/Dushanbe', 'Asia/Dushanbe'),
(314, '(UTC+05:00) Indian/Maldives', 'Indian/Maldives'),
(315, '(UTC+05:00) Asia/Tashkent', 'Asia/Tashkent'),
(316, '(UTC+05:00) Asia/Karachi', 'Asia/Karachi'),
(317, '(UTC+05:00) Asia/Samarkand', 'Asia/Samarkand'),
(318, '(UTC+05:00) Asia/Yekaterinburg', 'Asia/Yekaterinburg'),
(319, '(UTC+05:00) Asia/Aqtau', 'Asia/Aqtau'),
(320, '(UTC+05:00) Antarctica/Mawson', 'Antarctica/Mawson'),
(321, '(UTC+05:00) Asia/Oral', 'Asia/Oral'),
(322, '(UTC+05:00) Asia/Atyrau', 'Asia/Atyrau'),
(323, '(UTC+05:00) Asia/Ashgabat', 'Asia/Ashgabat'),
(324, '(UTC+05:00) Asia/Aqtobe', 'Asia/Aqtobe'),
(325, '(UTC+05:30) Asia/Kolkata', 'Asia/Kolkata'),
(326, '(UTC+05:30) Asia/Colombo', 'Asia/Colombo'),
(327, '(UTC+05:45) Asia/Kathmandu', 'Asia/Kathmandu'),
(328, '(UTC+06:00) Indian/Chagos', 'Indian/Chagos'),
(329, '(UTC+06:00) Asia/Almaty', 'Asia/Almaty'),
(330, '(UTC+06:00) Asia/Urumqi', 'Asia/Urumqi'),
(331, '(UTC+06:00) Asia/Bishkek', 'Asia/Bishkek'),
(332, '(UTC+06:00) Asia/Qyzylorda', 'Asia/Qyzylorda'),
(333, '(UTC+06:00) Antarctica/Vostok', 'Antarctica/Vostok'),
(334, '(UTC+06:00) Asia/Dhaka', 'Asia/Dhaka'),
(335, '(UTC+06:00) Asia/Omsk', 'Asia/Omsk'),
(336, '(UTC+06:00) Asia/Thimphu', 'Asia/Thimphu'),
(337, '(UTC+06:30) Indian/Cocos', 'Indian/Cocos'),
(338, '(UTC+06:30) Asia/Yangon', 'Asia/Yangon'),
(339, '(UTC+07:00) Asia/Pontianak', 'Asia/Pontianak'),
(340, '(UTC+07:00) Asia/Phnom_Penh', 'Asia/Phnom_Penh'),
(341, '(UTC+07:00) Indian/Christmas', 'Indian/Christmas'),
(342, '(UTC+07:00) Asia/Novokuznetsk', 'Asia/Novokuznetsk'),
(343, '(UTC+07:00) Asia/Jakarta', 'Asia/Jakarta'),
(344, '(UTC+07:00) Asia/Hovd', 'Asia/Hovd'),
(345, '(UTC+07:00) Asia/Ho_Chi_Minh', 'Asia/Ho_Chi_Minh'),
(346, '(UTC+07:00) Asia/Bangkok', 'Asia/Bangkok'),
(347, '(UTC+07:00) Asia/Krasnoyarsk', 'Asia/Krasnoyarsk'),
(348, '(UTC+07:00) Asia/Novosibirsk', 'Asia/Novosibirsk'),
(349, '(UTC+07:00) Asia/Tomsk', 'Asia/Tomsk'),
(350, '(UTC+07:00) Asia/Vientiane', 'Asia/Vientiane'),
(351, '(UTC+07:00) Antarctica/Davis', 'Antarctica/Davis'),
(352, '(UTC+07:00) Asia/Barnaul', 'Asia/Barnaul'),
(353, '(UTC+08:00) Asia/Irkutsk', 'Asia/Irkutsk'),
(354, '(UTC+08:00) Asia/Hong_Kong', 'Asia/Hong_Kong'),
(355, '(UTC+08:00) Asia/Kuala_Lumpur', 'Asia/Kuala_Lumpur'),
(356, '(UTC+08:00) Asia/Kuching', 'Asia/Kuching'),
(357, '(UTC+08:00) Asia/Macau', 'Asia/Macau'),
(358, '(UTC+08:00) Australia/Perth', 'Australia/Perth'),
(359, '(UTC+08:00) Asia/Makassar', 'Asia/Makassar'),
(360, '(UTC+08:00) Asia/Manila', 'Asia/Manila'),
(361, '(UTC+08:00) Asia/Ulaanbaatar', 'Asia/Ulaanbaatar'),
(362, '(UTC+08:00) Asia/Singapore', 'Asia/Singapore'),
(363, '(UTC+08:00) Asia/Taipei', 'Asia/Taipei'),
(364, '(UTC+08:00) Asia/Choibalsan', 'Asia/Choibalsan'),
(365, '(UTC+08:00) Asia/Brunei', 'Asia/Brunei'),
(366, '(UTC+08:00) Asia/Shanghai', 'Asia/Shanghai'),
(367, '(UTC+08:30) Asia/Pyongyang', 'Asia/Pyongyang'),
(368, '(UTC+08:45) Australia/Eucla', 'Australia/Eucla'),
(369, '(UTC+09:00) Asia/Dili', 'Asia/Dili'),
(370, '(UTC+09:00) Asia/Chita', 'Asia/Chita'),
(371, '(UTC+09:00) Asia/Khandyga', 'Asia/Khandyga'),
(372, '(UTC+09:00) Asia/Jayapura', 'Asia/Jayapura'),
(373, '(UTC+09:00) Asia/Seoul', 'Asia/Seoul'),
(374, '(UTC+09:00) Pacific/Palau', 'Pacific/Palau'),
(375, '(UTC+09:00) Asia/Tokyo', 'Asia/Tokyo'),
(376, '(UTC+09:00) Asia/Yakutsk', 'Asia/Yakutsk'),
(377, '(UTC+09:30) Australia/Darwin', 'Australia/Darwin'),
(378, '(UTC+10:00) Asia/Ust-Nera', 'Asia/Ust-Nera'),
(379, '(UTC+10:00) Pacific/Saipan', 'Pacific/Saipan'),
(380, '(UTC+10:00) Pacific/Guam', 'Pacific/Guam'),
(381, '(UTC+10:00) Antarctica/DumontDU', 'Antarctica/DumontDUrville'),
(382, '(UTC+10:00) Asia/Vladivostok', 'Asia/Vladivostok'),
(383, '(UTC+10:00) Australia/Lindeman', 'Australia/Lindeman'),
(384, '(UTC+10:00) Australia/Brisbane', 'Australia/Brisbane'),
(385, '(UTC+10:00) Pacific/Port_Moresb', 'Pacific/Port_Moresby'),
(386, '(UTC+10:00) Pacific/Chuuk', 'Pacific/Chuuk'),
(387, '(UTC+10:30) Australia/Adelaide', 'Australia/Adelaide'),
(388, '(UTC+10:30) Australia/Broken_Hi', 'Australia/Broken_Hill'),
(389, '(UTC+11:00) Pacific/Guadalcanal', 'Pacific/Guadalcanal'),
(390, '(UTC+11:00) Antarctica/Casey', 'Antarctica/Casey'),
(391, '(UTC+11:00) Antarctica/Macquari', 'Antarctica/Macquarie'),
(392, '(UTC+11:00) Pacific/Kosrae', 'Pacific/Kosrae'),
(393, '(UTC+11:00) Pacific/Norfolk', 'Pacific/Norfolk'),
(394, '(UTC+11:00) Pacific/Noumea', 'Pacific/Noumea'),
(395, '(UTC+11:00) Pacific/Pohnpei', 'Pacific/Pohnpei'),
(396, '(UTC+11:00) Australia/Sydney', 'Australia/Sydney'),
(397, '(UTC+11:00) Pacific/Efate', 'Pacific/Efate'),
(398, '(UTC+11:00) Australia/Melbourne', 'Australia/Melbourne'),
(399, '(UTC+11:00) Australia/Lord_Howe', 'Australia/Lord_Howe'),
(400, '(UTC+11:00) Australia/Hobart', 'Australia/Hobart'),
(401, '(UTC+11:00) Australia/Currie', 'Australia/Currie'),
(402, '(UTC+11:00) Asia/Srednekolymsk', 'Asia/Srednekolymsk'),
(403, '(UTC+11:00) Pacific/Bougainvill', 'Pacific/Bougainville'),
(404, '(UTC+11:00) Asia/Sakhalin', 'Asia/Sakhalin'),
(405, '(UTC+11:00) Asia/Magadan', 'Asia/Magadan'),
(406, '(UTC+12:00) Pacific/Funafuti', 'Pacific/Funafuti'),
(407, '(UTC+12:00) Asia/Kamchatka', 'Asia/Kamchatka'),
(408, '(UTC+12:00) Pacific/Wake', 'Pacific/Wake'),
(409, '(UTC+12:00) Pacific/Tarawa', 'Pacific/Tarawa'),
(410, '(UTC+12:00) Pacific/Wallis', 'Pacific/Wallis'),
(411, '(UTC+12:00) Pacific/Fiji', 'Pacific/Fiji'),
(412, '(UTC+12:00) Pacific/Nauru', 'Pacific/Nauru'),
(413, '(UTC+12:00) Asia/Anadyr', 'Asia/Anadyr'),
(414, '(UTC+12:00) Pacific/Majuro', 'Pacific/Majuro'),
(415, '(UTC+12:00) Pacific/Kwajalein', 'Pacific/Kwajalein'),
(416, '(UTC+13:00) Antarctica/McMurdo', 'Antarctica/McMurdo'),
(417, '(UTC+13:00) Pacific/Enderbury', 'Pacific/Enderbury'),
(418, '(UTC+13:00) Pacific/Tongatapu', 'Pacific/Tongatapu'),
(419, '(UTC+13:00) Pacific/Fakaofo', 'Pacific/Fakaofo'),
(420, '(UTC+13:00) Pacific/Auckland', 'Pacific/Auckland'),
(421, '(UTC+13:45) Pacific/Chatham', 'Pacific/Chatham'),
(422, '(UTC+14:00) Pacific/Apia', 'Pacific/Apia'),
(423, '(UTC+14:00) Pacific/Kiritimati', 'Pacific/Kiritimati');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(16) NOT NULL,
  `lname` varchar(16) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `token` varchar(256) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `monthly_spending` double NOT NULL DEFAULT 0,
  `annual_spending` double NOT NULL DEFAULT 0,
  `monthly_saving` double NOT NULL DEFAULT 0,
  `monthly_earning` double NOT NULL DEFAULT 0,
  `lang` varchar(32) NOT NULL DEFAULT 'en_US',
  `timezone` varchar(64) NOT NULL DEFAULT 'Africa/Nairobi',
  `currency` varchar(8) NOT NULL DEFAULT 'USD',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `phone`, `address`, `password`, `avatar`, `token`, `role`, `status`, `monthly_spending`, `annual_spending`, `monthly_saving`, `monthly_earning`, `lang`, `timezone`, `currency`, `created_at`, `updated_at`) VALUES
(1, 'Thiện', 'Trần', 'admin123@gmail.com', '+254720783834', 'Nairobi, Kenya.', '$2y$10$z3SGEWPJNe6glCbiuB7mYODbIG93ONZJuGfK9EDAah5BNQGoGiOHq', '', '', 'admin', 'Active', 50000000, 600000000, 1000000000, 120000000, 'en_US', 'Indian/Mayotte', 'USD', '2019-02-07 12:47:21', '2023-09-23 11:22:29'),
(2, 'Trần', 'Thiện', 'admin456@gmail.com', NULL, NULL, '$2y$10$czt6Hmk8yF8sFEmJOVyrB.oC8cDK8jPE09yRjMsjyrToBDOmjjW0O', NULL, NULL, 'admin', 'Active', 0, 0, 0, 0, 'en_US', 'Africa/Nairobi', 'USD', '2023-10-03 21:52:54', '2023-10-03 21:52:54'),
(3, 'Long Vỹ', 'Hứa Hồng', 'longvy2911@gmail.com', NULL, NULL, '$2y$10$eNDU.m14.VFBC5uu6Hr10OU8GijSCNkKmZ2nxM4EyBiI3kjuRh/zO', NULL, NULL, 'admin', 'Active', 0, 0, 0, 0, 'en_US', 'Africa/Nairobi', 'USD', '2023-10-03 21:56:23', '2023-10-03 21:56:23'),
(4, 'Huỳnh', 'Thảo Nhi', 'thaonhi1202@gmail.com', NULL, NULL, '$2y$10$nht01jpWtXxaC1D/Xa4CdO8u0y8NFdwF1eKwCOn5VsRJuwIZXDBhu', NULL, NULL, 'admin', 'Active', 0, 0, 0, 0, 'en_US', 'Africa/Nairobi', 'USD', '2023-10-03 21:58:30', '2023-10-03 21:58:30'),
(5, 'Từ', 'Văn Tú', 'vantu756@gmail.com', NULL, NULL, '$2y$10$N2scbVqPiSjLv54RKB7x/uGMd27/NraDBtWVtMf2qJOUN5uuNlPP6', NULL, NULL, 'admin', 'Active', 0, 0, 0, 0, 'en_US', 'Africa/Nairobi', 'USD', '2023-10-03 22:06:40', '2023-10-03 22:06:40');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Chỉ mục cho bảng `bookbank`
--
ALTER TABLE `bookbank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Fk_bookbank_account` (`account`),
  ADD KEY `Fk_bookbank_` (`user`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `uploaded_by` (`user`);

--
-- Chỉ mục cho bảng `category_expense`
--
ALTER TABLE `category_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_expense1` (`id_category`),
  ADD KEY `fk_category_expense2` (`id_expense`);

--
-- Chỉ mục cho bảng `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `directory`
--
ALTER TABLE `directory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_danhba_user1` (`user`);

--
-- Chỉ mục cho bảng `expensedetail`
--
ALTER TABLE `expensedetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_expense_directory1` (`expense`),
  ADD KEY `fk_expense_directory2` (`directory`);

--
-- Chỉ mục cho bảng `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `expenses_ibfk_2` (`account`);

--
-- Chỉ mục cho bảng `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `account` (`account`),
  ADD KEY `income_ibfk_3` (`category`);

--
-- Chỉ mục cho bảng `incomedetail`
--
ALTER TABLE `incomedetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_income_directory1` (`income`),
  ADD KEY `fk_income_directory2` (`directory`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `bookbank`
--
ALTER TABLE `bookbank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `category_expense`
--
ALTER TABLE `category_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT cho bảng `directory`
--
ALTER TABLE `directory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `expensedetail`
--
ALTER TABLE `expensedetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `incomedetail`
--
ALTER TABLE `incomedetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=424;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `bookbank`
--
ALTER TABLE `bookbank`
  ADD CONSTRAINT `Fk_bookbank_` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk_bookbank_account` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `category_expense`
--
ALTER TABLE `category_expense`
  ADD CONSTRAINT `fk_category_expense1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category_expense2` FOREIGN KEY (`id_expense`) REFERENCES `expenses` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `directory`
--
ALTER TABLE `directory`
  ADD CONSTRAINT `fk_danhba_user1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `expensedetail`
--
ALTER TABLE `expensedetail`
  ADD CONSTRAINT `fk_expense_directory1` FOREIGN KEY (`expense`) REFERENCES `expenses` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expense_directory2` FOREIGN KEY (`directory`) REFERENCES `directory` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `income_ibfk_2` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `income_ibfk_3` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `incomedetail`
--
ALTER TABLE `incomedetail`
  ADD CONSTRAINT `fk_income_directory1` FOREIGN KEY (`income`) REFERENCES `income` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_income_directory2` FOREIGN KEY (`directory`) REFERENCES `directory` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
