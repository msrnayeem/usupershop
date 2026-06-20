-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2026 at 05:53 AM
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
-- Database: `usupersh_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'About U Super Shop', '<p><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</span><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</span><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><span style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</span><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>', 1, 1, '2022-08-28 04:31:07', '2024-11-20 02:22:23');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `sub_location_id` bigint(20) UNSIGNED NOT NULL,
  `area_name` varchar(255) NOT NULL,
  `deliveryCharge` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `division_id`, `location_id`, `sub_location_id`, `area_name`, `deliveryCharge`, `created_at`, `updated_at`) VALUES
(4, 1, 4, 0, 'Dhaka Area', 70, '2024-12-27 08:04:31', '2024-12-27 08:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `bankinfo`
--

CREATE TABLE `bankinfo` (
  `id` int(11) NOT NULL,
  `accountno` char(30) NOT NULL,
  `accounttype` char(20) NOT NULL,
  `accountholder` char(30) NOT NULL,
  `branch` char(30) DEFAULT NULL,
  `bankname` char(30) NOT NULL,
  `asset` decimal(12,2) DEFAULT 0.00,
  `status` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `banner_images`
--

CREATE TABLE `banner_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_small_image_one` varchar(255) DEFAULT NULL,
  `banner_small_image_two` varchar(255) DEFAULT NULL,
  `offer_banner_image_one` varchar(255) DEFAULT NULL,
  `offer_banner_image_two` varchar(255) DEFAULT NULL,
  `deals_banner_image_one` varchar(255) DEFAULT NULL,
  `deals_banner_image_two` varchar(255) DEFAULT NULL,
  `featured_banner_image_one` varchar(255) DEFAULT NULL,
  `featured_banner_image_two` varchar(255) DEFAULT NULL,
  `category_banner_image` varchar(255) DEFAULT NULL,
  `bestseller_banner_image_one` varchar(255) DEFAULT NULL,
  `bestseller_banner_image_two` varchar(255) DEFAULT NULL,
  `shop_page_banner` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner_images`
--

INSERT INTO `banner_images` (`id`, `banner_small_image_one`, `banner_small_image_two`, `offer_banner_image_one`, `offer_banner_image_two`, `deals_banner_image_one`, `deals_banner_image_two`, `featured_banner_image_one`, `featured_banner_image_two`, `category_banner_image`, `bestseller_banner_image_one`, `bestseller_banner_image_two`, `shop_page_banner`, `created_at`, `updated_at`) VALUES
(1, '202501200902slider-2.png', '202501200902slider-1.png', NULL, NULL, NULL, NULL, NULL, NULL, '202501200902Red simple sale Facebook Cover .png', NULL, NULL, '202501200908istockphoto-1345105817-612x612.jpg', '2025-01-20 03:02:27', '2025-01-20 03:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(1000) DEFAULT NULL,
  `meta_description` varchar(2000) DEFAULT NULL,
  `meta_keywords` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
(1, 'New Brand', 1, NULL, '2025-07-26 13:34:11', '2025-07-26 13:34:11', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cookie_id` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `size_id` varchar(20) DEFAULT NULL,
  `color_id` varchar(20) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `drop_selling_price` decimal(22,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `cookie_id`, `product_id`, `qty`, `size_id`, `color_id`, `price`, `drop_selling_price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1753216187p2QeOF2e1w', 18, 1, '66', '22', NULL, 0.0000, '2025-08-01 05:51:52', '2025-08-01 05:51:52', NULL),
(3, '1754677107afkeAdWrfh', 34, 1, '118', '41', NULL, 0.0000, '2025-08-08 12:18:27', '2025-08-08 12:18:27', NULL),
(4, '1754731906FC9RfwjVE7', 11, 1, '40', '14', NULL, 0.0000, '2025-08-09 03:31:46', '2025-08-09 03:31:46', NULL),
(8, '17551052795opPTRNuD2', 32, 2, '108', '37', NULL, 0.0000, '2025-08-17 10:12:09', '2025-08-17 10:12:31', NULL),
(10, '1755447180wtzlakfKwm', 11, 1, '40', '14', NULL, 0.0000, '2025-08-17 10:13:26', '2025-08-17 10:13:26', NULL),
(11, '1756137765X7Et2JP6vv', 34, 1, '117', '41', NULL, 0.0000, '2025-08-25 10:02:45', '2025-08-25 10:02:45', NULL),
(12, '1756137806ECRskx8oVJ', 34, 1, '117', '41', NULL, 0.0000, '2025-08-25 10:03:26', '2025-08-25 10:03:26', NULL),
(15, '1756137765X7Et2JP6vv', 40, 1, '123', '46', NULL, 0.0000, '2025-09-04 06:25:37', '2025-09-04 06:25:37', NULL),
(18, '17578114289bjQOlcavg', 22, 1, '74', '26', NULL, 0.0000, '2025-09-18 20:04:45', '2025-09-18 20:04:45', NULL),
(19, '1758247592x53WmntztI', 38, 1, '122', '45', NULL, 0.0000, '2025-09-18 20:06:32', '2025-09-18 20:06:32', NULL),
(21, '1758735802tu6NNXGY0j', 23, 1, '79', '27', NULL, 0.0000, '2025-09-24 11:43:22', '2025-09-24 11:43:22', NULL),
(23, '1760331957GJ7THdngOt', 10, 1, '38', '13', NULL, 0.0000, '2025-10-12 23:05:57', '2025-10-12 23:05:57', NULL),
(24, '1760331957GJ7THdngOt', 29, 1, '98', '34', NULL, 0.0000, '2025-10-12 23:07:14', '2025-10-12 23:07:14', NULL),
(33, '1760693099pgXKaeVjKN', 42, 1, '140', '54', NULL, 0.0000, '2025-10-17 03:24:59', '2025-10-17 03:24:59', NULL),
(38, '1760693457VezL0tDiWo', 42, 1, '139', '54', NULL, 0.0000, '2025-10-17 03:37:40', '2025-10-17 03:37:40', NULL),
(41, '17606925750xiV6FRuxj', 42, 3, '139', '54', NULL, 0.0000, '2025-10-21 18:29:24', '2025-10-21 18:29:24', NULL),
(47, '17610930089r4KyEKFMM', 38, 2, '122', '45', NULL, 0.0000, '2025-10-21 18:36:41', '2025-10-21 18:36:41', NULL),
(48, '1761214411rbIERpQ4La', 9, 1, '34', '12', NULL, 0.0000, '2025-10-23 04:13:31', '2025-10-23 04:13:31', NULL),
(56, '1761654585JLHjniNWSG', 11, 1, '143', '56', NULL, 0.0000, '2025-10-28 06:29:45', '2025-10-28 06:29:45', NULL),
(57, '1761654367FyCgitlEe9', 33, 1, '111', '38', NULL, 0.0000, '2025-11-01 06:27:10', '2025-11-01 06:27:10', NULL),
(58, '1762110728OOaYyDYHMz', 8, 1, '134', '52', NULL, 0.0000, '2025-11-02 13:12:08', '2025-11-02 13:12:08', NULL),
(59, '1761644012yu2GCd0gtQ', 38, 1, '122', '45', NULL, 0.0000, '2025-11-05 04:44:37', '2025-11-05 04:44:37', NULL),
(60, '1762364705eKMYe2VXcJ', 41, 1, '131', '51', NULL, 0.0000, '2025-11-05 11:45:05', '2025-11-05 11:45:05', NULL),
(61, '1762887578WOeWuoLojN', 32, 1, '108', '37', NULL, 0.0000, '2025-11-11 12:59:38', '2025-11-11 12:59:38', NULL),
(62, '1763774397DLYRXbOTcQ', 42, 1, '139', '54', NULL, 3500.0000, '2025-11-21 19:19:57', '2025-11-21 19:19:57', NULL),
(64, '1763803956HItljU7ho2', 38, 1, '122', '45', NULL, 5000.0000, '2025-11-22 03:45:13', '2025-11-22 03:45:56', NULL),
(65, '17638052501B1r4jXWuR', 38, 1, '122', '45', NULL, 1000.0000, '2025-11-22 03:54:10', '2025-11-22 03:54:19', NULL),
(66, '1763806031p2nP8OGim4', 40, 1, '126', '47', NULL, 2000.0000, '2025-11-22 04:07:11', '2025-11-22 04:07:11', NULL),
(67, '1763806031Qt9M86JFEU', 40, 1, '126', '47', NULL, 1500.0000, '2025-11-22 04:07:11', '2025-11-22 04:07:11', NULL),
(68, '1763806031bskv2U4mpr', 40, 1, '126', '47', NULL, 2000.0000, '2025-11-22 04:07:11', '2025-11-22 04:07:11', NULL),
(69, '1763807101dn0zOF2Vp9', 43, 1, '147', '58', NULL, 1000.0000, '2025-11-22 04:25:01', '2025-11-22 04:25:01', NULL),
(70, '1763774397DLYRXbOTcQ', 43, 1, '145', '57', NULL, 0.0000, '2025-11-22 18:36:00', '2025-11-22 18:36:00', NULL),
(71, '1763774397DLYRXbOTcQ', 40, 2, '125', '47', NULL, 0.0000, '2025-11-22 18:40:50', '2025-11-22 18:41:13', NULL),
(72, '1764084157mQQqLPBwi8', 11, 3, '142', '56', NULL, 0.0000, '2025-11-25 09:22:37', '2025-11-25 09:22:37', NULL),
(73, '1764660628tIx3QP2fbg', 28, 1, '96', '33', NULL, 0.0000, '2025-12-02 01:30:28', '2025-12-02 01:30:28', NULL),
(74, '1764660628tIx3QP2fbg', 2, 1, '4', '2', NULL, 0.0000, '2025-12-02 01:30:51', '2025-12-02 01:30:51', NULL),
(75, '1765985488jUvqxDkj3n', 43, 2, '146', '57', NULL, 0.0000, '2025-12-17 09:31:28', '2025-12-17 09:31:32', NULL),
(76, '1766549421enxlFCfa22', 16, 1, '59', '20', NULL, 500.0000, '2025-12-23 22:10:21', '2025-12-23 22:11:01', NULL),
(78, '1768329383SuLP7d44UA', 27, 1, '92', '32', NULL, 0.0000, '2026-01-13 12:36:23', '2026-01-13 12:38:20', NULL),
(80, '1768492280akwproK5ot', 43, 1, '146', '57', NULL, 0.0000, '2026-01-15 09:51:20', '2026-01-15 09:51:32', NULL),
(83, '1769338841Vj8LxXUE8l', 30, 1, '273', '100', NULL, 0.0000, '2026-01-25 05:00:41', '2026-01-25 05:00:41', NULL),
(84, '1769340297hYyQb3hQHG', 7, 1, '204', '77', NULL, 0.0000, '2026-01-25 05:24:57', '2026-01-25 05:24:57', NULL),
(86, '1769340429iPEU3onLPq', 32, 1, '279', '102', NULL, 0.0000, '2026-01-25 05:30:30', '2026-01-25 05:30:30', NULL),
(87, '1769341763PIvhnKDsFZ', 10, 1, '215', '81', NULL, 0.0000, '2026-01-25 05:49:23', '2026-01-25 05:49:23', NULL),
(88, '1769342546WLKIyiktfL', 43, 1, '291', '107', NULL, 0.0000, '2026-01-25 06:02:26', '2026-01-25 06:02:26', NULL),
(91, '1769496700RPdMGOWPmU', 33, 1, '281', '103', NULL, 0.0000, '2026-01-27 00:51:40', '2026-01-27 00:51:40', NULL),
(94, '1769848218F2Kv2wCedE', 33, 1, '298', '111', NULL, 0.0000, '2026-01-31 02:59:01', '2026-01-31 02:59:32', '2026-01-31 02:59:32'),
(95, '17701038190IntVE19Rn', 33, 1, '298', '111', NULL, 1000.0000, '2026-02-03 01:30:19', '2026-02-03 01:30:36', '2026-02-03 01:30:36'),
(96, '1770105468c0iXrXWELV', 33, 1, '298', '111', NULL, 1000.0000, '2026-02-03 01:57:48', '2026-02-03 01:58:05', '2026-02-03 01:58:05'),
(97, '1770105565krWIXc1JwE', 33, 1, '298', '111', NULL, 0.0000, '2026-02-03 01:59:25', '2026-02-03 02:00:23', '2026-02-03 02:00:23'),
(98, '1770105921CCYC9RHTWK', 33, 1, '297', '111', NULL, 0.0000, '2026-02-03 02:05:21', '2026-02-03 02:05:33', '2026-02-03 02:05:33'),
(99, '1770106292Tc32B6ict0', 32, 1, '279', '102', NULL, 0.0000, '2026-02-03 02:11:32', '2026-02-03 02:11:45', '2026-02-03 02:11:45'),
(100, '1770106393C2ijg1Mk3U', 33, 1, '298', '111', NULL, 0.0000, '2026-02-03 02:13:13', '2026-02-03 02:13:30', '2026-02-03 02:13:30'),
(101, '1770106488MZuoG4ku6g', 33, 1, '298', '111', NULL, 0.0000, '2026-02-03 02:14:48', '2026-02-03 02:15:27', '2026-02-03 02:15:27'),
(103, '1770216725ntUDWFE0Nd', 11, 1, '219', '82', NULL, 0.0000, '2026-02-07 00:49:31', '2026-02-07 00:49:43', '2026-02-07 00:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_bn` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cat_slug` varchar(100) NOT NULL,
  `cat_icon` longtext DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `is_show` tinyint(4) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(1000) DEFAULT NULL,
  `meta_description` varchar(2000) DEFAULT NULL,
  `meta_keywords` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `name_bn`, `cat_slug`, `cat_icon`, `image`, `is_show`, `created_by`, `updated_by`, `created_at`, `updated_at`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
(1, 't-shirt', 'টি-শার্ট', 't-shirt', NULL, '202507271836t shat 120px.jpg', 0, 1, 1, '2025-07-26 13:40:53', '2025-07-27 12:36:24', NULL, NULL, NULL),
(2, 'shirt', 'শার্ট', 'shirt', NULL, '202507271840shat120.jpg', 0, 1, NULL, '2025-07-27 12:40:42', '2025-07-27 12:40:42', NULL, NULL, NULL),
(3, 'panjabi', 'পাঞ্জাবি', 'panjabi', NULL, '202507271846panjabi120.jpg', 0, 1, NULL, '2025-07-27 12:46:59', '2025-07-27 12:46:59', NULL, NULL, NULL),
(4, 'Gift', 'উপহার', 'gift', NULL, '202507271900gift120.jpg', 0, 1, NULL, '2025-07-27 13:00:24', '2025-07-27 13:00:24', NULL, NULL, NULL),
(5, 'U SUPER SHOP', 'ইউ সুপার শপ', 'u-super-shop', NULL, '20250727190267.jpg', 0, 1, NULL, '2025-07-27 13:02:29', '2025-07-27 13:02:29', NULL, NULL, NULL),
(6, 'watch', 'ঘড়ি', 'watch', NULL, '202507281741watch 120.jpg', 0, 1, 1, '2025-07-28 11:32:26', '2025-07-28 11:41:49', NULL, NULL, NULL),
(7, 'couple set', 'কাপল সেট', 'couple-set', NULL, '202507281741couple_set_resized_120x120.jpg', 0, 1, NULL, '2025-07-28 11:41:36', '2025-07-28 11:41:36', NULL, NULL, NULL),
(8, 'baby fashion', 'শিশুর ফ্যাশন', 'baby-fashion', NULL, '202507291535baby(1).jpg', 0, 1, NULL, '2025-07-29 09:35:17', '2025-07-29 09:35:17', NULL, NULL, NULL),
(9, 'personal care', 'ব্যক্তিগত', 'personal-care', NULL, '202507291540personal care(1).png', 0, 1, NULL, '2025-07-29 09:40:40', '2025-07-29 09:40:40', NULL, NULL, NULL),
(10, 'Boys And Girls', 'ছেলে ও মেয়ে', 'boys-and-girls', NULL, '202507291604Outfits For Boys And Girls(1).jpg', 0, 1, NULL, '2025-07-29 10:04:26', '2025-07-29 10:04:26', NULL, NULL, NULL),
(11, 'Baby care', 'শিশুর যত্ন', 'baby-care', NULL, '202507291610baby care(1).jpg', 0, 1, NULL, '2025-07-29 10:10:38', '2025-07-29 10:10:38', NULL, NULL, NULL),
(12, 'glasses', 'চশমা', 'glasses', NULL, '202507291721চশমা(1).png', 0, 1, 1, '2025-07-29 11:15:39', '2025-07-29 11:21:29', NULL, NULL, NULL),
(13, 'New Stock', 'নতুন স্টক', 'new-stock', NULL, '202507291716120ppp.jpg', 0, 1, NULL, '2025-07-29 11:16:58', '2025-07-29 11:16:58', NULL, NULL, NULL),
(14, 'three piece', 'থ্রি পিস', 'three-piece', NULL, '202507291726three piece(1).jpg', 0, 1, NULL, '2025-07-29 11:26:22', '2025-07-29 11:26:22', NULL, NULL, NULL),
(15, 'jewellery', 'গহনা', 'jewellery', NULL, '202507291858jewellery(1).jpg', 0, 1, NULL, '2025-07-29 12:58:54', '2025-07-29 12:58:54', NULL, NULL, NULL),
(16, 'new fashion', 'নতুন ফ্যাশন', 'new-fashion', NULL, '202507291904120ppp(1).jpg', 0, 1, NULL, '2025-07-29 13:04:18', '2025-07-29 13:04:18', NULL, NULL, NULL),
(17, 'saree', 'শাড়ি', 'saree', NULL, '202507310443PS-179.jpg', 0, 1, NULL, '2025-07-30 22:43:48', '2025-07-30 22:43:48', NULL, NULL, NULL),
(18, 'good shoes', 'সু জুতা', 'good-shoes', NULL, '202508031618images (1).jpg', 0, 1, NULL, '2025-08-03 10:18:46', '2025-08-03 10:18:46', NULL, NULL, NULL),
(19, 'Sandal shoes', 'সেন্ডেল জুতা', 'sandal-shoes', NULL, '2025080318171a0da81c7a77278dc010ce5d4d2e1d1f (1).jpg', 0, 1, NULL, '2025-08-03 12:17:02', '2025-08-03 12:17:02', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'mix color', 1, NULL, '2025-07-26 13:34:57', '2025-07-26 13:34:57'),
(2, 'One Color', 1, NULL, '2025-07-29 07:51:10', '2025-07-29 07:51:10'),
(3, 'Red', 1, NULL, '2025-07-29 07:59:46', '2025-07-29 07:59:46'),
(4, 'Blue', 1, NULL, '2025-07-29 08:00:10', '2025-07-29 08:00:10'),
(5, 'Green', 1, NULL, '2025-07-29 08:00:40', '2025-07-29 08:00:40'),
(6, 'Yellow', 1, NULL, '2025-07-29 08:00:59', '2025-07-29 08:00:59'),
(7, 'Orange', 1, NULL, '2025-07-29 08:01:28', '2025-07-29 08:01:28'),
(8, 'Pink', 1, NULL, '2025-07-29 08:01:47', '2025-07-29 08:01:47'),
(9, 'Purple', 1, NULL, '2025-07-29 08:02:18', '2025-07-29 08:02:18'),
(10, 'Black', 1, NULL, '2025-07-29 08:02:40', '2025-07-29 08:02:40'),
(11, 'Brown', 1, NULL, '2025-07-29 08:03:02', '2025-07-29 08:03:02'),
(12, 'White', 1, NULL, '2025-07-29 08:03:24', '2025-07-29 08:03:24'),
(13, 'Gray', 1, NULL, '2025-07-29 08:03:44', '2025-07-29 08:03:44'),
(14, 'Magenta', 1, NULL, '2025-07-29 08:04:18', '2025-07-29 08:04:18'),
(15, 'Mix One Color', 1, NULL, '2026-01-18 13:47:50', '2026-01-18 13:47:50');

-- --------------------------------------------------------

--
-- Table structure for table `color_settings`
--

CREATE TABLE `color_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `element_name` varchar(255) NOT NULL,
  `color_code` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `color_settings`
--

INSERT INTO `color_settings` (`id`, `element_name`, `color_code`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'header_bg', '#1e25fa', 'Header Background', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(2, 'header_text', '#e6197c', 'Header Text', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(3, 'footer_bg', '#3219f0', 'Footer Background', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(4, 'footer_text', '#1915e5', 'Footer Text', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(5, 'search_icon_bg', '#020ffd', 'Search Icon Background', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(6, 'search_icon_color', '#fafafa', 'Search Icon Color', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(7, 'add_to_cart_bg', '#28a745', 'Add to Cart Background', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(8, 'add_to_cart_text', '#030303', 'Add to Cart Text', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(9, 'price_color', '#ff1182', 'Price Color', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(10, 'primary_button', '#0008ff', 'Primary Button', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(11, 'secondary_button', '#ff245b', 'Secondary Button', '2025-08-23 10:03:04', '2025-12-28 12:29:01'),
(12, 'sub_header_bg', '#0a26f5', ' Sub Header Background', '2025-08-23 10:20:37', '2025-12-28 12:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `commission_ledgers`
--

CREATE TABLE `commission_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reseller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `debit_balance` decimal(8,2) DEFAULT NULL,
  `credit_balance` decimal(8,2) DEFAULT NULL,
  `payment_mood` varchar(15) DEFAULT NULL,
  `reference` varchar(15) DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `status` enum('pending','confirmed','delivered','return','canceled','packaging') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commission_ledgers`
--

INSERT INTO `commission_ledgers` (`id`, `reseller_id`, `order_id`, `debit_balance`, `credit_balance`, `payment_mood`, `reference`, `entry_date`, `status`, `created_at`, `updated_at`) VALUES
(34, 216, 251, NULL, 35.00, '398', '123456789', '2025-05-22', 'pending', '2025-05-22 06:39:15', NULL),
(35, 216, 251, NULL, 35.00, '398', '123456789', '2025-05-22', 'pending', '2025-05-22 06:39:15', NULL),
(36, 216, 252, NULL, 35.00, '399', '123456789', '2025-05-22', 'pending', '2025-05-22 06:45:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `communications`
--

CREATE TABLE `communications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `facebook_icon` varchar(120) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `youtube_icon` varchar(120) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `twitter_icon` varchar(120) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `instagram_icon` varchar(120) DEFAULT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `telegram_icon` varchar(120) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `whatsapp_icon` varchar(255) DEFAULT NULL,
  `created_by` varchar(91) DEFAULT NULL,
  `updated_by` varchar(91) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `address`, `mobile`, `email`, `facebook`, `facebook_icon`, `youtube`, `youtube_icon`, `twitter`, `twitter_icon`, `instagram`, `instagram_icon`, `telegram`, `telegram_icon`, `whatsapp`, `whatsapp_icon`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'Dhaka Bangladesh', '01816622128', 'info@usupershop.com', 'https://www.facebook.com/share/1VjqK6xoDm/', '202501190700facebook.png', 'https://youtube.com/@usupershop?feature=shared', '202501190700youtube.png', 'https://www.tiktok.com/@usupershop', '202502222027055c37d715cdb3b9146b3a8afed24218.png', 'https://www.instagram.com/usupershop?igsh=MXducXBidGE5NzRsNQ==', '202501190700instagram.png', 'https://t.me/usupershop1', '202501190700telegram.png', 'https://wa.me/8801816622128', '202501190700whatsapp.png', '1', '1', '2024-11-15 13:57:16', '2025-02-22 14:31:05');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `country`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Bangladesh', 1, '2022-08-31 12:03:24', '2022-08-31 12:03:24'),
(2, NULL, 'France', 1, '2022-08-31 12:03:24', '2022-08-31 12:03:24'),
(3, NULL, 'Germany', 1, '2022-08-31 12:04:55', '2022-08-31 12:04:55'),
(4, NULL, 'Belgium', 1, '2022-08-31 12:04:55', '2022-08-31 12:04:55'),
(5, NULL, 'USA', 1, '2022-08-31 12:04:55', '2022-08-31 12:04:55'),
(6, NULL, 'UK', 1, '2022-08-31 12:06:11', '2022-08-31 12:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `promoCode` varchar(255) NOT NULL,
  `canBeUsed` int(11) NOT NULL DEFAULT 1,
  `available` int(11) NOT NULL DEFAULT 1,
  `availableFor` int(11) NOT NULL COMMENT '0=Customer, 1=Staff, 2=Both, 3=Vendor, 4=Seller\r\n',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount_type` int(11) NOT NULL,
  `discount_amount` varchar(255) NOT NULL,
  `min_amount` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `name`, `promoCode`, `canBeUsed`, `available`, `availableFor`, `start_date`, `end_date`, `discount_type`, `discount_amount`, `min_amount`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 'seller 777', 'AB123', 24, 1000, 0, '2025-09-08', '2026-08-10', 2, '277', '777', 1, 1, 1, '2025-08-08 09:07:16', '2025-08-17 12:11:01'),
(6, 'product', 'FKB5R', 24, 100, 0, '2025-08-08', '2026-08-08', 2, '100', '1000', 1, 1, NULL, '2025-08-08 09:11:57', '2025-08-08 09:11:57'),
(7, 'NewVendor', 'new4578', 10, 4, 4, '2025-08-17', '2025-08-28', 1, '10', '100', 1, 1, NULL, '2025-08-17 09:31:58', '2025-08-17 09:31:58'),
(8, 'MD Masum Rana', '100dd', 15, 15, 0, '2025-08-20', '2025-08-21', 1, '10', '500', 1, 1, NULL, '2025-08-19 10:32:47', '2025-08-19 10:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_product`
--

CREATE TABLE `coupon_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `coupon_product`
--

INSERT INTO `coupon_product` (`id`, `coupon_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 8, 31, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `client_id` varchar(255) DEFAULT NULL,
  `client_secret` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `store_id` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `client_id`, `client_secret`, `api_key`, `store_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Pathao', '7N1aMJQbWm', 'wRcaibZkUdSNz2EI9ZyuXLlNrnAv0TdPUPXMnD39', 't5fgg', 'dsdsa', 1, '2025-09-03 06:10:13', '2025-09-03 12:42:44'),
(2, 'Steadfast', NULL, '2iiqxtgqnztsc9u9esshh2xf', '8tglqf4sskogfpaqw236zymkvcjhomli', NULL, 1, '2025-09-03 12:40:23', '2025-09-03 12:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `daily_expense`
--

CREATE TABLE `daily_expense` (
  `id` int(10) UNSIGNED NOT NULL,
  `expense_type` varchar(50) DEFAULT NULL,
  `date` date NOT NULL,
  `expense_account` varchar(25) NOT NULL,
  `holder` varchar(25) NOT NULL,
  `description` text DEFAULT NULL,
  `reference_no` varchar(25) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_mode` varchar(25) DEFAULT NULL,
  `paid_to` varchar(50) DEFAULT NULL,
  `entry_date` date NOT NULL,
  `operator_id` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `daily_expense`
--

INSERT INTO `daily_expense` (`id`, `expense_type`, `date`, `expense_account`, `holder`, `description`, `reference_no`, `amount`, `payment_mode`, `paid_to`, `entry_date`, `operator_id`) VALUES
(1, 'Product Purchase', '2022-11-19', '9', 'admin', NULL, '2022-11-19001', 50000.00, 'Cash', NULL, '2022-11-19', 'admin'),
(2, 'Product Purchase', '2022-11-19', '9', 'admin', NULL, '2022-11-19002', 2315.00, 'Cash', NULL, '2022-11-19', 'admin'),
(3, 'Product Purchase', '2022-11-19', '9', 'admin', NULL, '202211190001', 850.00, 'Cash', NULL, '2022-11-19', 'admin'),
(4, 'General Expense', '2022-11-19', '114', 'E0001', '', '6776', 200.00, 'cash', NULL, '2022-11-19', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `daily_income`
--

CREATE TABLE `daily_income` (
  `id` bigint(20) NOT NULL,
  `date` date DEFAULT NULL,
  `collection_account` varchar(25) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `reference_no` varchar(25) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(25) NOT NULL,
  `received_from` varchar(50) DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `author` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `daily_income`
--

INSERT INTO `daily_income` (`id`, `date`, `collection_account`, `description`, `reference_no`, `amount`, `payment_mode`, `received_from`, `entry_date`, `branch_id`, `author`) VALUES
(1, '2022-11-19', '5', NULL, 'S1221119123503', 1470.00, '0', '0', '2022-11-19', NULL, 'admin'),
(2, '2022-11-19', '5', NULL, 'S1221119191102', 2450.00, '0', '0', '2022-11-19', NULL, 'admin'),
(3, '2022-11-19', '5', NULL, 'S1221119193434', 10370.00, '0', '0', '2022-11-19', NULL, 'admin'),
(4, '2022-11-19', '5', NULL, 'S1221119200604', 1000.00, '0', '0', '2022-11-19', NULL, 'admin'),
(5, '2022-11-26', '5', NULL, 'S1221126160034', 1650.00, '0', '0', '2022-11-26', NULL, 'admin'),
(6, '2022-11-26', '5', NULL, 'S1221126201427', 1650.00, '0', '0', '2022-11-26', NULL, 'admin'),
(7, '2022-11-26', '13', 'Due Collection', 'DC-1221126082520', 300.00, '1', 'C0001', '2022-11-26', NULL, 'admin'),
(8, '2022-12-07', '5', NULL, 'S1221207165516', 2600.00, '0', '0', '2022-12-07', NULL, 'admin'),
(9, '2022-12-07', '5', NULL, 'S1221207183203', 1303.40, '0', '0', '2022-12-07', NULL, 'admin'),
(10, '2022-12-07', '5', NULL, 'S1221207184651', 6500.00, '0', '0', '2022-12-07', NULL, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `daily_sales`
--

CREATE TABLE `daily_sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_no` varchar(45) NOT NULL,
  `date` datetime NOT NULL,
  `cus_type` int(11) NOT NULL,
  `pay_type` int(11) NOT NULL,
  `cheque_type` varchar(15) DEFAULT NULL,
  `cus_code` varchar(12) DEFAULT NULL,
  `cus_mobile` varchar(12) NOT NULL,
  `cus_name` varchar(45) DEFAULT NULL,
  `cus_address` text DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `sub_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `vat` decimal(12,2) UNSIGNED DEFAULT 0.00,
  `total` decimal(12,2) UNSIGNED DEFAULT 0.00,
  `charge` decimal(12,2) DEFAULT 0.00,
  `disc` decimal(12,2) DEFAULT 0.00,
  `payable` decimal(12,2) UNSIGNED DEFAULT 0.00,
  `cash` decimal(12,2) DEFAULT 0.00,
  `due` decimal(12,2) DEFAULT 0.00,
  `change` decimal(12,2) DEFAULT 0.00,
  `sales_man` varchar(45) DEFAULT NULL,
  `sts` int(11) DEFAULT 1,
  `branch` int(10) UNSIGNED DEFAULT 0,
  `is_sync` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `daily_sales`
--

INSERT INTO `daily_sales` (`id`, `invoice_no`, `date`, `cus_type`, `pay_type`, `cheque_type`, `cus_code`, `cus_mobile`, `cus_name`, `cus_address`, `shipping_address`, `note`, `sub_total`, `vat`, `total`, `charge`, `disc`, `payable`, `cash`, `due`, `change`, `sales_man`, `sts`, `branch`, `is_sync`) VALUES
(1, 'S1221119123503', '2022-11-19 12:35:54', 2, 0, '', '0', '00000000000', 'N/A', 'N/A', 'N/A', '', 1470.00, 0.00, 1470.00, 0.00, 0.00, 1470.00, 1470.00, 0.00, 0.00, 'admin', 1, 0, 0),
(2, 'S1221119191102', '2022-11-19 19:11:12', 2, 0, '', '0', '00000000000', 'N/A', 'N/A', 'N/A', '', 2450.00, 0.00, 2450.00, 0.00, 0.00, 2450.00, 2450.00, 0.00, 0.00, 'admin', 1, 0, 0),
(3, 'S1221119193434', '2022-11-19 19:34:49', 2, 0, '', '0', '00000000000', 'N/A', 'N/A', 'N/A', '', 10370.00, 0.00, 10370.00, 0.00, 0.00, 10370.00, 10370.00, 0.00, 0.00, 'admin', 1, 0, 0),
(4, 'S1221119200604', '2022-11-19 20:06:34', 1, 0, '', 'C0001', '01726808982', 'Liton', 'Rangpur', '', '', 1350.00, 0.00, 1350.00, 0.00, 0.00, 1350.00, 1000.00, 350.00, 0.00, 'admin', 1, 0, 0),
(5, 'S1221126160034', '2022-11-26 16:01:05', 0, 0, '', '0', '017272233333', '3333', '33', '33', '', 1650.00, 0.00, 1650.00, 0.00, 0.00, 1650.00, 1650.00, 0.00, 0.00, 'admin', 1, 0, 0),
(6, 'S1221126201427', '2022-11-26 20:14:53', 2, 0, '', '0', '00000000000', 'N/A', 'N/A', 'N/A', '', 1650.00, 0.00, 1650.00, 0.00, 0.00, 1650.00, 1650.00, 0.00, 0.00, 'admin', 1, 0, 0),
(7, 'S1221207165516', '2022-12-07 16:55:38', 2, 0, '', '0', '00000000000', 'N/A', 'N/A', 'N/A', '', 2600.00, 0.00, 2600.00, 0.00, 0.00, 2600.00, 2600.00, 0.00, 0.00, 'admin', 1, 0, 0),
(8, 'S1221207183203', '2022-12-07 18:33:31', 0, 0, '', '0', '01726808986', 'Md Abdur Razzak Sarker', 'Dhaka, Bangladesh', 'Dhaka, Bangladesh', '', 1330.00, 0.00, 1330.00, 0.00, 26.60, 1303.40, 1303.40, 0.00, 0.00, 'admin', 1, 0, 0),
(9, 'S1221207184651', '2022-12-07 18:47:07', 2, 0, '', '0', '00000000000', 'N/A', 'N/A', 'N/A', '', 6500.00, 0.00, 6500.00, 0.00, 0.00, 6500.00, 6500.00, 0.00, 0.00, 'admin', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `daily_sales_items`
--

CREATE TABLE `daily_sales_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_no` varchar(45) NOT NULL,
  `pr_code` varchar(20) NOT NULL,
  `desc` varchar(45) NOT NULL,
  `qty` double NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(12,2) NOT NULL,
  `vat` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(10) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `daily_sales_items`
--

INSERT INTO `daily_sales_items` (`id`, `invoice_no`, `pr_code`, `desc`, `qty`, `price`, `sub_total`, `vat`, `unit`, `date`, `type`) VALUES
(1, 'S1221119123503', '000011', 'Kinder Hippo Cocoa Cream 103G', 3, 490.00, 1470.00, 0.00, '', '2022-11-19 12:35:54', 'Product'),
(2, 'S1221119191102', '000011', 'Kinder Hippo Cocoa Cream 103G', 5, 490.00, 2450.00, 0.00, '', '2022-11-19 19:11:12', 'Product'),
(3, 'S1221119193434', '000011', 'Kinder Hippo Cocoa Cream 103G', 8, 490.00, 3920.00, 0.00, '', '2022-11-19 19:34:49', 'Product'),
(4, 'S1221119193434', '000001', 'Kinder Bueno Mini 108g', 4, 1350.00, 5400.00, 0.00, 'Pcs', '2022-11-19 19:34:49', 'Product'),
(5, 'S1221119193434', '000013', 'Galaxy Smooth Caramel (135gm)', 3, 350.00, 1050.00, 0.00, '', '2022-11-19 19:34:49', 'Product'),
(6, 'S1221119200604', '000001', 'Kinder Bueno Mini 108g', 1, 1350.00, 1350.00, 0.00, 'Pcs', '2022-11-19 20:06:34', 'Product'),
(7, 'S1221126160034', '000013', 'Galaxy Smooth Caramel (135gm)', 1, 350.00, 350.00, 0.00, '', '2022-11-26 16:01:05', 'Product'),
(8, 'S1221126160034', '000001', 'Kinder Bueno Mini 108g', 1, 1300.00, 1300.00, 0.00, 'Pcs', '2022-11-26 16:01:05', 'Product'),
(9, 'S1221126201427', '000001', 'Kinder Bueno Mini 108g', 1, 1300.00, 1300.00, 0.00, 'Pcs', '2022-11-26 20:14:53', 'Product'),
(10, 'S1221126201427', '000013', 'Galaxy Smooth Caramel (135gm)', 1, 350.00, 350.00, 0.00, '', '2022-11-26 20:14:53', 'Product'),
(11, 'S1221207165516', '000001', 'Kinder Bueno Mini 108g', 2, 1300.00, 2600.00, 0.00, 'Pcs', '2022-12-07 16:55:38', 'Product'),
(12, 'S1221207183203', '000011', 'Kinder Hippo Cocoa Cream 103G', 2, 490.00, 980.00, 0.00, '', '2022-12-07 18:33:31', 'Product'),
(13, 'S1221207183203', '000035', 'Malteser Teasers Bar (100gm)', 1, 350.00, 350.00, 0.00, '', '2022-12-07 18:33:31', 'Product'),
(14, 'S1221207184651', '000001', 'Kinder Bueno Mini 108g', 5, 1300.00, 6500.00, 0.00, 'Pcs', '2022-12-07 18:47:07', 'Product');

-- --------------------------------------------------------

--
-- Table structure for table `deliverychargezone`
--

CREATE TABLE `deliverychargezone` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zone_area` varchar(120) DEFAULT NULL,
  `zone_charge` int(11) DEFAULT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliverychargezone`
--

INSERT INTO `deliverychargezone` (`id`, `zone_area`, `zone_charge`, `created_at`) VALUES
(1, 'Inside Dhaka', 1, '2025-02-02 07:56:55.219482'),
(2, 'Surrounding Dhaka', 100, '0000-00-00 00:00:00.000000'),
(3, 'Inside Dhaka', 70, '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_zones`
--

CREATE TABLE `delivery_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zone_area` varchar(120) DEFAULT NULL,
  `zone_charge` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_zones`
--

INSERT INTO `delivery_zones` (`id`, `zone_area`, `zone_charge`, `created_at`, `updated_at`) VALUES
(1, 'Inside Dhaka', 1, '2025-01-07 10:36:35', '2025-01-07 10:36:39'),
(2, 'Surrounding Dhaka', 100, '2025-01-07 10:36:35', '2025-01-07 10:36:39'),
(3, 'Outside Dhaka', 130, '2025-01-07 10:36:35', '2025-01-07 10:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `division_name`, `created_at`, `updated_at`) VALUES
(1, 'Inside Dhaka', '2022-10-22 07:59:29', '2022-10-22 08:13:27'),
(3, 'Outside Dhaka', '2024-12-27 08:02:54', '2024-12-27 08:02:54');

-- --------------------------------------------------------

--
-- Table structure for table `dkn_users`
--

CREATE TABLE `dkn_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `branch_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `type` int(10) UNSIGNED DEFAULT NULL,
  `is_sync` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `dkn_users`
--

INSERT INTO `dkn_users` (`id`, `username`, `password`, `name`, `position`, `branch_id`, `type`, `is_sync`) VALUES
(1, 'admin', 'gam@pos1', 'Gamma Admin', 'Administrator', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dropshipper_fees`
--

CREATE TABLE `dropshipper_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_type_of_dropshipper` varchar(255) DEFAULT NULL,
  `subscription_fees` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dropshipper_fees`
--

INSERT INTO `dropshipper_fees` (`id`, `account_type_of_dropshipper`, `subscription_fees`, `created_at`, `updated_at`) VALUES
(1, 'Seller', 1.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Vendor', 2.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Dropshiper', 3.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dropshipper_product_prices`
--

CREATE TABLE `dropshipper_product_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipper_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipper_profits`
--

CREATE TABLE `dropshipper_profits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipper_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `total_profit` decimal(10,2) NOT NULL,
  `status` enum('pending','approved','paid') NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropshipper_referral_codes`
--

CREATE TABLE `dropshipper_referral_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dropshipper_id` bigint(20) UNSIGNED NOT NULL,
  `referral_code` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finance_accounts_credit_item`
--

CREATE TABLE `finance_accounts_credit_item` (
  `id` bigint(20) NOT NULL,
  `account_to_credit` varchar(25) NOT NULL,
  `credit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `journal_entry_id` int(10) UNSIGNED NOT NULL,
  `invoice_no` varchar(25) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `finance_accounts_credit_item`
--

INSERT INTO `finance_accounts_credit_item` (`id`, `account_to_credit`, `credit`, `journal_entry_id`, `invoice_no`, `branch_id`, `status`) VALUES
(1, '2', 50000.00, 1, '2022-11-19001', NULL, '0'),
(2, '14', 7850.00, 1, '2022-11-19001', NULL, '0'),
(3, '5', 1470.00, 2, 'S1221119123503', NULL, '1'),
(4, '5', 2450.00, 3, 'S1221119191102', NULL, '1'),
(5, '5', 10370.00, 4, 'S1221119193434', NULL, '1'),
(6, '2', 2315.00, 5, '2022-11-19002', NULL, '0'),
(7, '2', 850.00, 6, '202211190001', NULL, '0'),
(8, '2', 7850.00, 7, 'DP-1221119080024', NULL, '1'),
(9, '5', 1350.00, 8, 'S1221119200604', NULL, '1'),
(10, '2', 200.00, 9, '6776', NULL, '1'),
(11, '5', 1650.00, 10, 'S1221126160034', NULL, '1'),
(12, '5', 1650.00, 11, 'S1221126201427', NULL, '1'),
(13, '13', 300.00, 12, 'DC-1221126082520', NULL, '1'),
(14, '5', 2600.00, 13, 'S1221207165516', NULL, '1'),
(15, '5', 1303.40, 14, 'S1221207183203', NULL, '1'),
(16, '5', 6500.00, 15, 'S1221207184651', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `finance_accounts_debit_item`
--

CREATE TABLE `finance_accounts_debit_item` (
  `id` bigint(20) NOT NULL,
  `account_to_debit` varchar(25) NOT NULL,
  `debit` decimal(12,2) DEFAULT 0.00,
  `journal_entry_id` int(10) UNSIGNED NOT NULL,
  `invoice_no` varchar(25) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `finance_accounts_debit_item`
--

INSERT INTO `finance_accounts_debit_item` (`id`, `account_to_debit`, `debit`, `journal_entry_id`, `invoice_no`, `branch_id`, `status`) VALUES
(1, '9', 57850.00, 1, '2022-11-19001', NULL, '1'),
(2, '2', 1470.00, 2, 'S1221119123503', NULL, '0'),
(3, '2', 2450.00, 3, 'S1221119191102', NULL, '0'),
(4, '2', 10370.00, 4, 'S1221119193434', NULL, '0'),
(5, '9', 2315.00, 5, '2022-11-19002', NULL, '1'),
(6, '9', 850.00, 6, '202211190001', NULL, '1'),
(7, '14', 7850.00, 7, 'DP-1221119080024', NULL, '0'),
(8, '2', 1000.00, 8, 'S1221119200604', NULL, '0'),
(9, '13', 350.00, 8, 'S1221119200604', NULL, '0'),
(10, '114', 200.00, 9, '6776', NULL, '0'),
(11, '2', 1650.00, 10, 'S1221126160034', NULL, '0'),
(12, '2', 1650.00, 11, 'S1221126201427', NULL, '0'),
(13, '2', 300.00, 12, 'DC-1221126082520', NULL, '0'),
(14, '2', 2600.00, 13, 'S1221207165516', NULL, '0'),
(15, '2', 1303.40, 14, 'S1221207183203', NULL, '0'),
(16, '2', 6500.00, 15, 'S1221207184651', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `finance_account_head`
--

CREATE TABLE `finance_account_head` (
  `id` bigint(20) NOT NULL,
  `account_head_name` varchar(100) NOT NULL,
  `account_code_name` varchar(25) DEFAULT NULL,
  `account_group` varchar(20) DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `finance_account_head`
--

INSERT INTO `finance_account_head` (`id`, `account_head_name`, `account_code_name`, `account_group`, `status`) VALUES
(1, 'Capital', '', 'Capital', 1),
(2, 'Cash', '', 'Asset', 1),
(3, 'Bank Account', '', 'Asset', 1),
(4, 'Bank Charge', '', 'Expense', 1),
(5, 'Sales', '', 'Income', 1),
(6, 'Sales Discount', '', 'Expense', 1),
(7, 'Sales Return', '', 'Expense', 1),
(8, 'Sales VAT', '', 'Expense', 1),
(9, 'Purchase', '', 'Expense', 1),
(10, 'Purchase Discount', '', 'Expense', 0),
(11, 'Purchase Return', '', 'Income', 1),
(12, 'Purchase VAT', '', 'Expense', 0),
(13, 'Trade Debtors', '', 'Asset', 1),
(14, 'Trade Creditors', '', 'Liability', 1),
(15, 'Salary Expenses', '', 'Expense', 1),
(16, 'Salary Advance', '', 'Asset', 1),
(17, 'Salary Payable', '', 'Liability', 1),
(135, 'Fine Collection', '', 'Collection', 0),
(134, 'Installment Collection', '', 'Collection', 0),
(104, 'Miscellaneous Expenses', '', 'Expense', 1),
(105, 'Commission Received', '', 'Income', 1),
(106, 'Computer & Accessories', '', 'Asset', 1),
(107, 'Conveyance & Traveling Expenses', '', 'Expense', 1),
(109, 'Dish Bill', '', 'Expense', 1),
(133, 'Monthly Profit Based Fixed Deposit (MFD)', '', 'Liability', 0),
(111, 'Drawings', '', 'Expense', 1),
(112, 'Electric Bill', '', 'Expense', 1),
(114, 'Entertainment', '', 'Expense', 1),
(115, 'Festival Bonus', '', 'Expense', 1),
(116, 'Furniture & Fittings', '', 'Asset', 1),
(117, 'House Rent', '', 'Expense', 1),
(118, 'Internet Bill', '', 'Expense', 1),
(119, 'Labour Charge', '', 'Expense', 1),
(120, 'Mobile Bill', '', 'Expense', 1),
(121, 'Newspaper Bill', '', 'Expense', 1),
(122, 'Office Decoration', '', 'Asset', 1),
(123, 'Office Equipments', '', 'Asset', 1),
(124, 'Office Expenses', '', 'Expense', 1),
(125, 'Printing & Stationery', '', 'Expense', 1),
(126, 'Repair & Maintenance', '', 'Asset', 1),
(128, 'Unexpected Income', '', 'Income', 1),
(129, 'Unexpected Loss', '', 'Expense', 1),
(19, 'Loan', '', 'Liability', 0),
(130, 'Profit Disburse', '', 'Expense', 0),
(131, 'Loan Disburse', '', 'Expense', 0),
(132, 'Repairing Expense', '', 'Expense', 1),
(137, 'Savings Collection', '', 'Collection', 0),
(136, 'Dues Collection', '', 'Collection', 0),
(18, 'Service Revenue', '', 'Income', 1),
(139, 'Outstanding expense', '', 'Asset', 1),
(140, 'Outstanding income', '', 'Liability', 1);

-- --------------------------------------------------------

--
-- Table structure for table `finance_bank_ledger`
--

CREATE TABLE `finance_bank_ledger` (
  `id` int(11) NOT NULL,
  `TransactionDate` date NOT NULL,
  `AccountNo` varchar(30) NOT NULL,
  `ChequeNo` varchar(50) DEFAULT NULL,
  `TransactionType` char(20) NOT NULL,
  `TransactionHolder` varchar(30) DEFAULT NULL,
  `Withdraw` decimal(12,2) DEFAULT NULL,
  `Deposit` decimal(12,2) DEFAULT NULL,
  `Balance` decimal(12,2) DEFAULT NULL,
  `TransactionBank` char(30) DEFAULT NULL,
  `tr_bank_ac_no` varchar(50) DEFAULT NULL,
  `tr_bank_ac_holder` varchar(30) DEFAULT NULL,
  `Reference` varchar(100) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `Author` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `finance_cheque_deposit`
--

CREATE TABLE `finance_cheque_deposit` (
  `id` bigint(20) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_no` varchar(200) DEFAULT NULL,
  `slip_no` varchar(150) DEFAULT NULL,
  `cheque_amount` double DEFAULT NULL,
  `cheque_number` varchar(25) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_deposit_date` date DEFAULT NULL,
  `customer_id` varchar(50) DEFAULT NULL,
  `customer_bank_name` varchar(250) DEFAULT NULL,
  `invoice_id` varchar(25) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `tr_status` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finance_cheque_payment`
--

CREATE TABLE `finance_cheque_payment` (
  `id` bigint(20) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `supplier_id` varchar(20) DEFAULT NULL,
  `cheque_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cheque_number` varchar(25) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `invoice_id` varchar(25) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finance_cheque_received`
--

CREATE TABLE `finance_cheque_received` (
  `id` bigint(20) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `customer_id` varchar(20) DEFAULT NULL,
  `cheque_amount` double NOT NULL DEFAULT 0,
  `cheque_number` varchar(25) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_deposit_date` date DEFAULT NULL,
  `invoice_id` varchar(25) NOT NULL,
  `status` varchar(30) DEFAULT NULL,
  `tr_status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finance_customer_ledger`
--

CREATE TABLE `finance_customer_ledger` (
  `id` bigint(20) NOT NULL,
  `customer_id` varchar(25) NOT NULL,
  `transaction_date` date NOT NULL,
  `invoice_no` varchar(25) NOT NULL,
  `description` text DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paid_amount` decimal(12,2) DEFAULT 0.00,
  `due_amount` decimal(12,2) DEFAULT 0.00,
  `balance` decimal(12,2) DEFAULT 0.00,
  `status` varchar(25) DEFAULT NULL,
  `payment_type` int(10) UNSIGNED DEFAULT 0 COMMENT '''0 is cash 1 is cheque'''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `finance_customer_ledger`
--

INSERT INTO `finance_customer_ledger` (`id`, `customer_id`, `transaction_date`, `invoice_no`, `description`, `total_amount`, `paid_amount`, `due_amount`, `balance`, `status`, `payment_type`) VALUES
(1, 'S0001', '2022-11-19', '2022-11-19001', 'Purchase Product', 50000.00, 57850.00, 7850.00, -7850.00, 'Purchase', 0),
(2, '0', '2022-11-19', 'S1221119123503', 'Sales Product', 1470.00, 1470.00, 0.00, 0.00, 'Sales', 0),
(3, '0', '2022-11-19', 'S1221119191102', 'Sales Product', 2450.00, 2450.00, 0.00, 0.00, 'Sales', 0),
(4, '0', '2022-11-19', 'S1221119193434', 'Sales Product', 10370.00, 10370.00, 0.00, 0.00, 'Sales', 0),
(5, 'S0001', '2022-11-19', '2022-11-19002', 'Purchase Product', 2315.00, 2315.00, 0.00, -7850.00, 'Purchase', 0),
(6, 'S0001', '2022-11-19', '202211190001', 'Purchase Product', 850.00, 850.00, 0.00, -7850.00, 'Purchase', 0),
(7, 'S0001', '2022-11-19', 'DP-1221119080024', 'Due Payment', 7850.00, 0.00, 0.00, 0.00, 'Payment', 0),
(8, 'C0001', '2022-11-19', 'S1221119200604', 'Sales Product', 1350.00, 1000.00, 350.00, 350.00, 'Sales', 0),
(9, '0', '2022-11-26', 'S1221126160034', 'Sales Product', 1650.00, 1650.00, 0.00, 0.00, 'Sales', 0),
(10, '0', '2022-11-26', 'S1221126201427', 'Sales Product', 1650.00, 1650.00, 0.00, 0.00, 'Sales', 0),
(11, 'C0001', '2022-11-26', 'DC-1221126082520', 'Due Collection', 0.00, 300.00, 0.00, 50.00, 'Collection', 0),
(12, '0', '2022-12-07', 'S1221207165516', 'Sales Product', 2600.00, 2600.00, 0.00, 0.00, 'Sales', 0),
(13, '0', '2022-12-07', 'S1221207183203', 'Sales Product', 1303.40, 1303.40, 0.00, 0.00, 'Sales', 0),
(14, '0', '2022-12-07', 'S1221207184651', 'Sales Product', 6500.00, 6500.00, 0.00, 0.00, 'Sales', 0);

-- --------------------------------------------------------

--
-- Table structure for table `finance_due_collection`
--

CREATE TABLE `finance_due_collection` (
  `id` int(11) NOT NULL,
  `receipt_no` varchar(20) NOT NULL,
  `customer_id` varchar(20) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(20) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `cheque_date` date DEFAULT NULL,
  `bank` varchar(25) DEFAULT NULL,
  `branch` varchar(30) DEFAULT NULL,
  `cheque_no` varchar(20) DEFAULT NULL,
  `ac_no` varchar(30) DEFAULT NULL,
  `ac_holder` varchar(30) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `author` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `finance_due_collection`
--

INSERT INTO `finance_due_collection` (`id`, `receipt_no`, `customer_id`, `amount`, `payment_mode`, `payment_date`, `cheque_date`, `bank`, `branch`, `cheque_no`, `ac_no`, `ac_holder`, `comments`, `author`, `status`) VALUES
(1, 'DC-1221126082520', 'C0001', 300.00, '0', '2022-11-26', NULL, NULL, NULL, NULL, NULL, NULL, '', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `finance_due_payment`
--

CREATE TABLE `finance_due_payment` (
  `id` int(11) NOT NULL,
  `receipt_no` varchar(20) NOT NULL,
  `vendor_id` varchar(20) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_mode` varchar(20) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `payment_date` date NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `author` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `finance_due_payment`
--

INSERT INTO `finance_due_payment` (`id`, `receipt_no`, `vendor_id`, `amount`, `payment_mode`, `comments`, `payment_date`, `branch_id`, `author`, `status`) VALUES
(1, 'DP-1221119080024', 'S0001', 7850.00, '0', '', '2022-11-19', NULL, 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `finance_journal_entry`
--

CREATE TABLE `finance_journal_entry` (
  `id` bigint(20) NOT NULL,
  `reference_id` varchar(25) NOT NULL,
  `date` date NOT NULL,
  `explanation` text DEFAULT NULL,
  `reference` varchar(150) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `finance_journal_entry`
--

INSERT INTO `finance_journal_entry` (`id`, `reference_id`, `date`, `explanation`, `reference`, `branch_id`, `type`) VALUES
(1, '2022-11-19001', '2022-11-19', '2022-11-19001-----Amin Hossain', 'Purchase', NULL, 'Purchase'),
(2, 'S1221119123503', '2022-11-19', 'S1221119123503-----General Sales', 'Sales', NULL, 'Sales'),
(3, 'S1221119191102', '2022-11-19', 'S1221119191102-----General Sales', 'Sales', NULL, 'Sales'),
(4, 'S1221119193434', '2022-11-19', 'S1221119193434-----General Sales', 'Sales', NULL, 'Sales'),
(5, '2022-11-19002', '2022-11-19', '2022-11-19002-----Amin Hossain', 'Purchase', NULL, 'Purchase'),
(6, '202211190001', '2022-11-19', '202211190001-----Amin Hossain', 'Purchase', NULL, 'Purchase'),
(7, 'DP-1221119080024', '2022-11-19', 'DP-1221119080024-----Amin Hossain', 'Due Payment', NULL, 'Due Payment'),
(8, 'S1221119200604', '2022-11-19', 'S1221119200604-----General Sales', 'Sales', NULL, 'Sales'),
(9, '6776', '2022-11-19', '6776-----General Expense', 'Expense', NULL, 'Expense'),
(10, 'S1221126160034', '2022-11-26', 'S1221126160034-----General Sales', 'Sales', NULL, 'Sales'),
(11, 'S1221126201427', '2022-11-26', 'S1221126201427-----General Sales', 'Sales', NULL, 'Sales'),
(12, 'DC-1221126082520', '2022-11-26', 'DC-1221126082520-----Liton', 'Due Collection', NULL, 'Due Collection'),
(13, 'S1221207165516', '2022-12-07', 'S1221207165516-----General Sales', 'Sales', NULL, 'Sales'),
(14, 'S1221207183203', '2022-12-07', 'S1221207183203-----General Sales', 'Sales', NULL, 'Sales'),
(15, 'S1221207184651', '2022-12-07', 'S1221207184651-----General Sales', 'Sales', NULL, 'Sales');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `division_id`, `location_name`, `created_at`, `updated_at`) VALUES
(4, 1, 'Dhaka', '2024-12-27 08:00:36', '2024-12-27 08:06:23'),
(5, 1, 'Dhaka Out Side', '2024-12-27 08:01:37', '2024-12-27 08:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `login_activity`
--

CREATE TABLE `login_activity` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(45) NOT NULL,
  `activity_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `action` text DEFAULT NULL,
  `user` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logos`
--

CREATE TABLE `logos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logos`
--

INSERT INTO `logos` (`id`, `name`, `image`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'U Super Shop', '202411210953tt22.png', 1, 1, '2022-08-10 23:53:07', '2024-11-20 21:53:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_08_09_150343_create_brands_table', 1),
(6, '2022_08_09_150509_create_colors_table', 1),
(7, '2022_08_09_150529_create_sizes_table', 1),
(8, '2022_08_09_150553_create_products_table', 1),
(9, '2022_08_09_150616_create_categories_table', 1),
(10, '2022_08_10_054345_create_product_sizes_table', 1),
(11, '2022_08_10_054507_create_product_colors_table', 1),
(12, '2022_08_10_054827_create_product_sub_images_table', 1),
(13, '2022_08_11_081817_create_sliders_table', 2),
(14, '2022_08_11_111217_create_logos_table', 3),
(15, '2022_08_24_070232_create_shippings_table', 4),
(16, '2022_08_24_070842_create_payments_table', 4),
(17, '2022_08_24_070857_create_orders_table', 4),
(18, '2022_08_24_071004_create_order_details_table', 4),
(19, '2022_08_27_184857_create_contacts_table', 5),
(20, '2022_08_28_100424_create_abouts_table', 6),
(21, '2022_08_28_130945_create_communications_table', 7),
(22, '2022_08_31_115828_create_countries_table', 8),
(23, '2022_09_28_055139_create_coupons_table', 9),
(24, '2022_10_22_052946_create_divisions_table', 10),
(25, '2022_10_22_053114_create_locations_table', 10),
(26, '2022_10_22_053133_create_sub_locations_table', 10),
(27, '2022_10_22_053147_create_areas_table', 10),
(28, '2023_01_17_133225_create_subcategories_table', 11),
(29, '2020_12_25_164117_create_wishlists_table', 12),
(30, '2023_03_18_164117_create_wishlists_table', 13),
(31, '2024_10_16_045336_create_seller_payments_table', 14),
(32, '2024_10_16_045840_create_subscription_fees_table', 14),
(33, '2024_10_17_112355_create_my_shops_table', 15),
(34, '2024_11_06_045305_create_commission_ledgers_table', 16),
(35, '2025_01_07_102221_create_deliveryzones_table', 17),
(36, '2025_01_11_082305_create_seller_emails_table', 18),
(37, '2025_01_14_033417_create_seller_fees_table', 19),
(38, '2025_01_14_051819_create_wallets_table', 20),
(39, '2025_01_20_062727_create_banner_images_table', 21),
(40, '2025_01_23_092239_create_profile_verifies_table', 22),
(44, '2025_01_24_092240_create_wallets_table', 23),
(46, '2025_02_01_102911_create_payment_gateways_table', 24),
(47, '2025_05_31_062453_create_carts_table', 25),
(48, '2025_08_23_154041_create_color_settings_table', 26),
(49, '2025_09_03_115609_create_couriers_table', 27),
(50, '2025_01_08_081850_create_payments_transaction_table', 28),
(51, '2025_09_04_090921_create_product_variants_table', 29),
(52, '2025_09_06_144934_add_courier_fields_to_orders_table', 30),
(53, '2025_09_10_090738_add_sale_price_to_products_table', 31),
(54, '2025_09_14_001141_add_min_max_price_to_products_table', 32),
(55, '2025_09_19_051726_add_dropshipper_fields_to_orders_table', 33),
(56, '2025_09_19_052222_add_dropshipper_fields_to_order_details_table', 34),
(57, '2025_09_19_052407_create_dropshipper_referral_codes_table', 35),
(58, '2025_09_19_053132_create_dropshipper_profits_table', 36),
(59, '2025_09_19_053250_create_dropshipper_product_prices_table', 37),
(60, '2025_09_21_004013_add_courier_fields_to_orders_table', 38),
(61, '2025_10_22_005441_create_payment_settings_table', 39),
(62, '2026_01_25_114413_add_missing_fields_to_order_details_table', 40),
(63, '2026_02_01_120000_add_status_timestamps_to_orders_table', 41);

-- --------------------------------------------------------

--
-- Table structure for table `my_shops`
--

CREATE TABLE `my_shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `my_shops`
--

INSERT INTO `my_shops` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2025-07-31 14:37:09', NULL),
(2, 3, 3, '2025-07-31 14:37:12', NULL),
(3, 6, 19, '2025-08-01 07:50:25', NULL),
(4, 6, 1, '2025-08-06 01:09:50', NULL),
(5, 6, 5, '2025-08-07 08:59:27', NULL),
(6, 6, 6, '2025-08-07 08:59:28', NULL),
(7, 6, 7, '2025-08-07 08:59:30', NULL),
(8, 6, 8, '2025-08-07 08:59:31', NULL),
(10, 11, 2, '2025-08-12 09:52:42', NULL),
(11, 11, 3, '2025-08-12 09:52:44', NULL),
(12, 11, 4, '2025-08-12 09:52:46', NULL),
(13, 11, 1, '2025-08-12 09:55:07', NULL),
(14, 11, 10, '2025-08-12 10:01:54', NULL),
(15, 14, 36, '2025-08-18 09:59:36', NULL),
(16, 14, 41, '2025-09-26 11:57:37', NULL),
(17, 23, 2, '2025-11-01 22:31:34', NULL),
(18, 24, 1, '2025-11-04 21:48:21', NULL),
(19, 24, 2, '2025-11-04 21:48:23', NULL),
(20, 24, 3, '2025-11-04 21:48:25', NULL),
(21, 24, 4, '2025-11-04 21:48:27', NULL),
(22, 24, 6, '2025-11-04 21:48:31', NULL),
(23, 14, 1, '2025-11-05 11:47:12', NULL),
(24, 14, 3, '2025-11-05 11:47:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'user_id=customer_id',
  `dropshipper_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `coupon_discount` double DEFAULT NULL,
  `delivery_charge` decimal(11,0) DEFAULT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,0) DEFAULT NULL,
  `dropshipper_profit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','confirmed','canceled','packaging','delivered','return') NOT NULL DEFAULT 'pending',
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `packaging_at` timestamp NULL DEFAULT NULL,
  `shipment_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `returned_at` timestamp NULL DEFAULT NULL,
  `canceled_at` timestamp NULL DEFAULT NULL,
  `courier_id` varchar(255) DEFAULT NULL,
  `courier_priority` varchar(255) NOT NULL DEFAULT 'normal',
  `courier_notes` text DEFAULT NULL,
  `courier_tracking_id` varchar(255) DEFAULT NULL,
  `courier_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`courier_response`)),
  `courier_assigned_at` timestamp NULL DEFAULT NULL,
  `order_type` enum('regular','dropship_referral') NOT NULL DEFAULT 'regular',
  `courier_assigned_by` bigint(20) UNSIGNED DEFAULT NULL,
  `shop_id` int(11) DEFAULT 0,
  `order_payment` enum('Paid','Unpaid','Canceled','Failed') NOT NULL DEFAULT 'Unpaid',
  `pay_method` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=none, 1=bkash, 2=eps, 3=cod',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tran_id` longtext DEFAULT NULL,
  `payment_method` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0- none, 1=bkash, 2-eps, 3-cod'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `dropshipper_id`, `shipping_id`, `payment_id`, `order_no`, `invoice_no`, `coupon_discount`, `delivery_charge`, `order_total`, `grand_total`, `dropshipper_profit`, `status`, `confirmed_at`, `packaging_at`, `shipment_at`, `delivered_at`, `returned_at`, `canceled_at`, `courier_id`, `courier_priority`, `courier_notes`, `courier_tracking_id`, `courier_response`, `courier_assigned_at`, `order_type`, `courier_assigned_by`, `shop_id`, `order_payment`, `pay_method`, `created_at`, `updated_at`, `tran_id`, `payment_method`) VALUES
(1, 5, NULL, 1, 1, '17540491941', '1_1754049194', 0, 1, 100.00, 101, 0.00, 'packaging', '2025-09-22 19:03:49', '2025-09-22 19:03:49', NULL, NULL, NULL, NULL, 'steadfast', 'normal', NULL, 'SFR250923STD62613ABD', '{\"status\":200,\"message\":\"Consignment has been created successfully.\",\"consignment\":{\"consignment_id\":175725001,\"invoice\":\"17540491941\",\"tracking_code\":\"SFR250923STD62613ABD\",\"recipient_name\":\"Customer\",\"recipient_phone\":\"01700000000\",\"recipient_address\":\"Dhaka, Bangladesh\",\"recipient_email\":null,\"alternative_phone\":null,\"item_description\":null,\"total_lot\":1,\"cod_amount\":0,\"status\":\"in_review\",\"note\":\"Order from U Super Shop\",\"created_at\":\"2025-09-23T01:03:49.000000Z\",\"updated_at\":\"2025-09-23T01:03:49.000000Z\"}}', '2025-09-22 19:03:49', 'regular', 1, 0, 'Paid', 3, '2025-08-01 05:53:14', '2025-09-22 19:03:49', NULL, 0),
(2, 5, NULL, 2, 2, '17546771802', '2_1754677180', 0, 1, 91.00, 92, 0.00, 'packaging', '2025-09-26 09:39:46', '2025-09-26 09:39:46', NULL, NULL, NULL, NULL, 'pathao', 'normal', NULL, 'DT2609259M22ZW', '{\"message\":\"Order Created Successfully\",\"type\":\"success\",\"code\":200,\"data\":{\"consignment_id\":\"DT2609259M22ZW\",\"merchant_order_id\":\"17546771802\",\"order_status\":\"Pending\",\"delivery_fee\":60}}', '2025-09-26 09:39:46', 'regular', 1, 0, 'Paid', 3, '2025-08-08 12:19:40', '2025-09-26 09:39:46', NULL, 0),
(3, 15, NULL, 3, 3, '17561379513', '3_1756137951', 0, 1, 91.00, 92, 0.00, 'confirmed', '2025-09-06 08:56:20', NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Paid', 3, '2025-08-25 10:05:51', '2025-09-06 08:56:20', NULL, 0),
(8, 18, NULL, 9, 8, '17583278244', NULL, NULL, 0, 700.00, 700, 0.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'redx', 'normal', NULL, 'MOCK_REDX_1758589148', '{\"mock\":true,\"courier\":\"redx\"}', '2025-09-22 18:59:08', 'regular', 1, 0, 'Unpaid', 0, '2025-09-19 18:23:44', '2025-09-26 09:40:04', NULL, 0),
(9, 18, NULL, 10, 9, '17583280969', '9', NULL, 0, 700.00, 700, 0.00, 'delivered', '2025-10-12 22:16:06', '2025-10-12 22:16:06', '2025-10-12 22:16:06', '2025-10-12 22:16:06', NULL, NULL, 'redx', 'normal', NULL, 'MOCK_REDX_1758901272', '{\"mock\":true,\"courier\":\"redx\"}', '2025-09-26 09:41:12', 'regular', 1, 0, 'Unpaid', 0, '2025-09-19 18:28:16', '2025-10-12 22:16:06', NULL, 0),
(10, 18, NULL, 11, 10, '175832923010', 'INV-20250920-0010', NULL, 0, 800.00, 800, 0.00, 'packaging', '2025-09-26 09:40:33', '2025-09-26 09:40:33', NULL, NULL, NULL, NULL, 'pathao', 'normal', NULL, 'DT260925BN8Q9A', '{\"message\":\"Order Created Successfully\",\"type\":\"success\",\"code\":200,\"data\":{\"consignment_id\":\"DT260925BN8Q9A\",\"merchant_order_id\":\"175832923010\",\"order_status\":\"Pending\",\"delivery_fee\":60}}', '2025-09-26 09:40:33', 'regular', 1, 0, 'Unpaid', 0, '2025-09-19 18:47:10', '2025-09-26 09:40:33', NULL, 0),
(11, 18, NULL, 12, 11, '175832952411', 'INV-20250920-0011', NULL, 0, 900.00, 900, 0.00, 'canceled', NULL, NULL, NULL, NULL, NULL, '2025-09-26 09:40:16', 'steadfast', 'normal', NULL, 'SFR250926ST8B74912BD', '{\"status\":200,\"message\":\"Consignment has been created successfully.\",\"consignment\":{\"consignment_id\":176729292,\"invoice\":\"175832952411\",\"tracking_code\":\"SFR250926ST8B74912BD\",\"recipient_name\":\"Customer\",\"recipient_phone\":\"01700000000\",\"recipient_address\":\"Dhaka, Bangladesh\",\"recipient_email\":null,\"alternative_phone\":null,\"item_description\":null,\"total_lot\":1,\"cod_amount\":0,\"status\":\"in_review\",\"note\":\"Order from U Super Shop\",\"created_at\":\"2025-09-26T15:40:15.000000Z\",\"updated_at\":\"2025-09-26T15:40:15.000000Z\"}}', '2025-09-26 09:40:16', 'regular', 1, 0, 'Unpaid', 0, '2025-09-19 18:52:04', '2025-09-26 09:40:16', NULL, 0),
(12, 18, NULL, 13, 12, '175930191612', 'INV-20251001-0012', NULL, 0, 1000.00, 1000, 0.00, 'return', '2025-10-01 00:58:36', '2025-10-01 00:58:36', '2025-10-01 00:58:36', '2025-10-01 00:58:36', '2025-10-01 00:58:36', NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 0, '2025-10-01 00:58:36', '2025-10-01 00:58:36', NULL, 0),
(13, 18, NULL, 14, 13, '175988541313', 'INV-20251008-0013', NULL, 0, 1400.00, 1400, 0.00, 'canceled', NULL, NULL, NULL, NULL, NULL, '2026-01-10 03:07:32', NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 0, '2025-10-07 19:03:33', '2026-01-10 03:07:32', NULL, 0),
(14, 23, NULL, 15, 14, '176205927314', 'INV-20251102-0014', NULL, 0, 850.00, 850, 0.00, 'delivered', '2025-11-01 22:58:03', '2025-11-01 22:58:03', '2025-11-01 22:58:03', '2025-11-01 22:58:03', NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 0, '2025-11-01 22:54:33', '2025-11-01 22:58:03', NULL, 0),
(15, 24, 24, 16, 15, '176230305015', 'INV-20251105-0015', NULL, 0, 910.00, 910, 0.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 0, '2025-11-04 18:37:30', '2025-11-04 18:37:30', NULL, 0),
(16, 25, NULL, 17, 16, '176233951016', '16_1762339510', 0, 100, 380.00, 480, 0.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 3, '2025-11-05 04:45:10', '2025-11-05 04:45:10', NULL, 0),
(17, 24, 24, 18, 17, '176239317017', 'INV-20251106-0017', NULL, 0, 950.00, 950, 0.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 0, '2025-11-05 19:39:30', '2025-11-05 19:39:30', NULL, 0),
(18, 6, 6, 19, 18, '176380483318', '18_1763804833', 0, 1, 5000.00, 5001, 0.00, 'delivered', '2025-12-27 02:30:22', '2025-12-27 02:30:22', '2025-12-27 02:30:22', '2025-12-27 02:30:22', NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 3, '2025-11-22 03:47:13', '2025-12-27 02:30:22', NULL, 0),
(19, 6, 6, 20, 19, '176380533519', '19_1763805335', 0, 1, 1000.00, 1001, 0.00, 'confirmed', '2025-11-22 03:56:52', NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Paid', 3, '2025-11-22 03:55:35', '2025-11-22 03:56:52', NULL, 0),
(20, 6, 6, 21, 20, '176380719020', '20_1763807190', 0, 1, 1000.00, 1001, 0.00, 'delivered', '2026-01-17 07:05:00', '2026-01-17 07:05:00', '2026-01-17 07:05:00', '2026-01-17 07:05:00', NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Paid', 3, '2025-11-22 04:26:30', '2026-01-17 07:05:00', NULL, 0),
(29, 25, NULL, 58, 57, '176984997221', '29_1769849972', 0, 130, 800.00, 930, 0.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 3, '2026-01-31 02:59:32', '2026-01-31 02:59:32', NULL, 0),
(30, 6, 6, 59, 58, '177010383630', '30_1770103836', 0, 130, 1000.00, 1130, 200.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 1, '2026-02-03 01:30:36', '2026-02-03 01:30:36', NULL, 0),
(31, 6, 6, 60, 59, '177010548531', '31_1770105485', 0, 130, 1000.00, 1130, 200.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 1, '2026-02-03 01:58:05', '2026-02-03 01:58:05', NULL, 0),
(32, 25, NULL, 61, 60, '177010562332', '32_1770105623', 0, 130, 800.00, 930, 0.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 1, '2026-02-03 02:00:23', '2026-02-03 02:00:23', NULL, 0),
(33, 25, NULL, 62, 61, '177010593333', '33_1770105933', 0, 130, 800.00, 930, 0.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 1, '2026-02-03 02:05:33', '2026-02-03 02:05:33', NULL, 0),
(34, 25, NULL, 63, 62, '177010630534', '34_1770106305', 0, 130, 800.00, 930, 0.00, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 1, '2026-02-03 02:11:45', '2026-02-03 02:11:45', NULL, 0),
(35, 25, NULL, 64, 63, '177010641035', '35_1770106410', 0, 130, 800.00, 930, 0.00, 'delivered', NULL, NULL, NULL, '2026-02-07 01:17:47', NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 1, '2026-02-03 02:13:30', '2026-02-07 01:17:47', NULL, 0),
(36, 25, NULL, 65, 64, '177010652736', '36_1770106527', 0, 130, 800.00, 930, 0.00, 'delivered', NULL, NULL, NULL, '2026-02-07 01:17:47', NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 1, '2026-02-03 02:15:27', '2026-02-07 01:17:47', NULL, 0),
(37, 25, NULL, 66, 65, '177044698337', '37_1770446983', 0, 130, 600.00, 730, 0.00, 'delivered', '2026-02-07 01:20:12', '2026-02-07 01:20:28', NULL, '2026-02-07 01:17:15', NULL, NULL, NULL, 'normal', NULL, NULL, NULL, NULL, 'regular', NULL, 0, 'Unpaid', 3, '2026-02-07 00:49:43', '2026-02-07 01:37:02', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` varchar(60) DEFAULT NULL,
  `reseller_id` varchar(60) DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color_id` int(11) NOT NULL,
  `color_name` varchar(120) DEFAULT NULL,
  `size_id` int(11) NOT NULL,
  `size_name` varchar(120) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `buy_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sell_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `dropshipper_sell_price` decimal(10,2) DEFAULT NULL,
  `dropshipper_profit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `vendor_id`, `reseller_id`, `order_id`, `product_id`, `color_id`, `color_name`, `size_id`, `size_name`, `quantity`, `buy_price`, `sell_price`, `dropshipper_sell_price`, `dropshipper_profit`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 1, 18, 22, NULL, 66, NULL, 1, 0.00, 0.00, NULL, 0.00, '2025-08-01 05:53:14', NULL),
(2, '4', NULL, 2, 34, 41, NULL, 118, NULL, 1, 130.00, 130.00, NULL, 0.00, '2025-08-08 12:19:40', NULL),
(3, '4', NULL, 3, 34, 41, NULL, 117, NULL, 1, 130.00, 130.00, NULL, 0.00, '2025-08-25 10:05:51', NULL),
(4, '1', '18', 8, 40, 47, NULL, 125, NULL, 1, 900.00, 700.00, NULL, 0.00, '2025-09-19 18:23:44', '2025-09-19 18:23:44'),
(5, '1', '18', 9, 40, 47, NULL, 125, NULL, 1, 900.00, 700.00, NULL, 0.00, '2025-09-19 18:28:16', '2025-09-19 18:28:16'),
(6, '1', '18', 10, 40, 47, NULL, 125, NULL, 1, 900.00, 800.00, NULL, 0.00, '2025-09-19 18:47:10', '2025-09-19 18:47:10'),
(7, '1', '18', 11, 40, 47, NULL, 125, NULL, 1, 900.00, 900.00, NULL, 0.00, '2025-09-19 18:52:04', '2025-09-19 18:52:04'),
(8, '1', '18', 12, 41, 50, NULL, 131, NULL, 1, 1000.00, 1000.00, NULL, 0.00, '2025-10-01 00:58:36', '2025-10-01 00:58:36'),
(9, '1', '18', 13, 41, 50, NULL, 130, NULL, 2, 1000.00, 700.00, NULL, 0.00, '2025-10-07 19:03:33', '2025-10-07 19:03:33'),
(10, '1', '23', 14, 41, 49, NULL, 131, NULL, 1, 1000.00, 850.00, 850.00, 50.00, '2025-11-01 22:54:33', '2025-11-01 22:54:33'),
(11, '1', '24', 15, 40, 47, NULL, 125, NULL, 1, 900.00, 910.00, 910.00, 410.00, '2025-11-04 18:37:30', '2025-11-04 18:37:30'),
(12, '10', NULL, 16, 38, 45, 'One Color', 122, 'M', 1, 500.00, 380.00, NULL, 0.00, '2025-11-05 04:45:10', NULL),
(13, '1', '24', 17, 40, 47, NULL, 125, NULL, 1, 900.00, 950.00, 950.00, 450.00, '2025-11-05 19:39:30', '2025-11-05 19:39:30'),
(14, '10', NULL, 18, 38, 45, 'One Color', 122, 'M', 1, 500.00, 5000.00, 5000.00, 4620.00, '2025-11-22 03:47:13', NULL),
(15, '10', NULL, 19, 38, 45, 'One Color', 122, 'M', 1, 500.00, 1000.00, 1000.00, 620.00, '2025-11-22 03:55:35', NULL),
(16, '1', NULL, 20, 43, 58, 'Red', 147, 'XL', 1, 1000.00, 1000.00, 1000.00, 250.00, '2025-11-22 04:26:30', NULL),
(25, '1', NULL, 29, 33, 111, 'mix color', 298, 'M', 1, 800.00, 800.00, 0.00, 0.00, '2026-01-31 02:59:32', NULL),
(26, '1', NULL, 30, 33, 111, 'mix color', 298, 'M', 1, 800.00, 1000.00, 1000.00, 200.00, '2026-02-03 01:30:36', NULL),
(27, '1', NULL, 31, 33, 111, 'mix color', 298, 'M', 1, 800.00, 1000.00, 1000.00, 200.00, '2026-02-03 01:58:05', NULL),
(28, '1', NULL, 32, 33, 111, 'mix color', 298, 'M', 1, 800.00, 800.00, 0.00, 0.00, '2026-02-03 02:00:23', NULL),
(29, '1', NULL, 33, 33, 111, 'mix color', 297, 'L', 1, 800.00, 800.00, 0.00, 0.00, '2026-02-03 02:05:33', NULL),
(30, '1', NULL, 34, 32, 102, 'mix color', 279, 'M', 1, 800.00, 800.00, 0.00, 0.00, '2026-02-03 02:11:45', NULL),
(31, '1', NULL, 35, 33, 111, 'mix color', 298, 'M', 1, 800.00, 800.00, 0.00, 0.00, '2026-02-03 02:13:30', NULL),
(32, '1', NULL, 36, 33, 111, 'mix color', 298, 'M', 1, 800.00, 800.00, 0.00, 0.00, '2026-02-03 02:15:27', NULL),
(33, '1', NULL, 37, 11, 82, 'mix color', 219, 'M', 1, 600.00, 600.00, 0.00, 0.00, '2026-02-07 00:49:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `page-slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `page-slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Terms and Conditions', 'terms-and-condition', '<h3 style=\"margin-top: 20px; margin-bottom: 30px; font-family: &quot;Open Sans&quot;, sans-serif; font-weight: bold; line-height: 1.1; color: rgb(85, 85, 85); font-size: 14px; text-transform: uppercase;\">Intellectual Propertly</h3><h3 style=\"margin-top: 20px; margin-bottom: 10px; font-family: &quot;Open Sans&quot;, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 24px;\"><ol style=\"margin-bottom: 10px; padding-left: 22px; font-size: 13px;\"><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum.</li><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li></ol></h3><h3 style=\"margin-top: 20px; margin-bottom: 30px; font-family: &quot;Open Sans&quot;, sans-serif; font-weight: bold; line-height: 1.1; color: rgb(85, 85, 85); font-size: 14px; text-transform: uppercase;\">Termination</h3><h3 style=\"margin-top: 20px; margin-bottom: 10px; font-family: &quot;Open Sans&quot;, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 24px;\"><ol style=\"margin-bottom: 10px; padding-left: 22px; font-size: 13px;\"><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum.</li><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li><li style=\"color: rgb(102, 102, 102); padding-bottom: 20px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed ultrices interdum. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li></ol></h3><h3 style=\"margin-top: 20px; margin-bottom: 30px; font-family: &quot;Open Sans&quot;, sans-serif; font-weight: bold; line-height: 1.1; color: rgb(85, 85, 85); font-size: 14px; text-transform: uppercase;\">Changes to this agreement</h3><h3 style=\"margin-top: 20px; margin-bottom: 10px; font-family: &quot;Open Sans&quot;, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 24px;\"><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; font-size: 15px;\">We reserve the right, at our sole discretion, to modify or replace these Terms and Conditions by posting the updated terms on the Site. Your continued use of the Site after any such changes constitutes your acceptance of the new Terms and Conditions.</p></h3><h3 style=\"margin-top: 20px; margin-bottom: 30px; font-family: &quot;Open Sans&quot;, sans-serif; font-weight: bold; line-height: 1.1; color: rgb(85, 85, 85); font-size: 14px; text-transform: uppercase;\">Contact Us</h3><h3 style=\"margin-top: 20px; margin-bottom: 10px; font-family: &quot;Open Sans&quot;, sans-serif; line-height: 1.1; color: rgb(51, 51, 51); font-size: 24px;\"><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; font-size: 15px;\">If you have any questions about this Agreement, please contact us filling this&nbsp;<a href=\"https://usupershop.com/terms-and-condition#\" class=\"contact-form\" style=\"color: rgb(51, 51, 51); background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; transition: 0.2s linear; outline: none !important;\">contact form</a></p></h3>', '2025-03-23 00:15:49', '2025-05-10 23:31:53'),
(2, 'Privacy Policy for U Super Shop', 'privacy-policy', '<p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Last Updated: 11/04/2025</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Welcome to U Super Shop (\"we,\" \"our,\" or \"us\"). We are committed to protecting your privacy and ensuring the security of your personal data. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our website, mobile app, and services.</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">By accessing or using U Super Shop, you agree to this Privacy Policy. If you disagree, please do not use our services.</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">1. Information We Collect</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">A. Personal Information</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">When you register, shop, or sell on U Super Shop, we may collect:</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Name, email, phone number, shipping/billing address</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Payment details (credit/debit cards, UPI, mobile wallets – processed securely via PCI-compliant gateways)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Government ID (for seller verification, if applicable)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Profile data (preferences, wishlists, order history)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">B. Automated Data</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Device Information: IP address, browser type, OS version</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Usage Data: Pages visited, clicks, session duration</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Cookies &amp; Tracking: We use cookies for analytics, personalization, and ads (you can disable them in browser settings).</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">C. Third-Party Data</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Social media logins (Facebook, Google)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Payment processors (local gateways)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Analytics tools (Google Analytics, Firebase)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">2. How We Use Your Data</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">We process your information to:</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">✔ Process orders, payments, and deliveries</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">✔ Verify seller identities &amp; prevent fraud</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">✔ Improve app performance &amp; user experience</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">✔ Send promotional offers (opt-out anytime)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">✔ Comply with legal obligations (tax, fraud prevention)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">3. Data Sharing &amp; Disclosure</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">We do not sell your data. However, we may share it with:</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Sellers/Delivery Partners (only for order fulfillment)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Payment Processors (to complete transactions)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Law Enforcement (if required by law)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Business Transfers (in case of mergers/acquisitions)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">4. Data Security</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">We implement:</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">SSL encryption for all transactions</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Secure servers with access controls</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Regular security audits</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Note: No method is 100% secure—always protect your login credentials.</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">5. Your Rights</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Depending on your location, you may:</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Access, correct, or delete your data</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Opt out of marketing emails (via \"Unsubscribe\" link)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Withdraw consent (contact us at info@usupershop.com)</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Lodge complaints with your local data authority</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">6. Third-Party Links</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">Our app/website may link to external sites (e.g., seller stores). We are not responsible for their privacy practices.</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">7. Children’s Privacy</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">U Super Shop is not for users under 13. We do not knowingly collect children’s data.</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">8. Policy Updates</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">We may update this policy periodically. Check the \"Last Updated\" date for changes. Continued use of U Super Shop means you accept the revised policy.</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\"><br></span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">9. Contact Us</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">For questions or data requests, email:</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">📧 Email: info@usupershop.com</span></font></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 15px;\">🏢 Address: Dhaka,Bangladesh 1000</span></font></p>', '2025-03-23 00:17:12', '2025-05-10 23:40:58'),
(3, 'Return Policy', 'return-policy', '<h2 style=\"margin-top: 20px; margin-bottom: 20px; font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; line-height: 1.1; color: rgb(33, 37, 41); background-color: rgb(243, 243, 243);\"><font color=\"#333333\" face=\"Open Sans, sans-serif\"><span style=\"font-size: 13px;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</span></font></h2>', '2025-03-23 00:17:42', '2025-05-10 23:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `otp` varchar(120) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `mobile`, `token`, `otp`, `created_at`) VALUES
('mrabdou100012@gmail.com', NULL, 'Gm56JtDE7YtatTL9xGunPk2hqyqwrpG5KH7zVLuQMmuYciFHs15xPRyCaok1N5nB', '264661', '2025-11-02 12:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `transaction_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_method`, `transaction_no`, `created_at`, `updated_at`) VALUES
(1, 'cod', NULL, '2025-08-01 05:53:14', '2025-08-01 05:53:14'),
(2, 'cod', NULL, '2025-08-08 12:19:40', '2025-08-08 12:19:40'),
(3, 'cod', NULL, '2025-08-25 10:05:51', '2025-08-25 10:05:51'),
(8, 'cod', NULL, '2025-09-19 18:23:44', '2025-09-19 18:23:44'),
(9, 'cod', NULL, '2025-09-19 18:28:16', '2025-09-19 18:28:16'),
(10, 'cod', NULL, '2025-09-19 18:47:10', '2025-09-19 18:47:10'),
(11, 'cod', NULL, '2025-09-19 18:52:04', '2025-09-19 18:52:04'),
(12, 'cod', NULL, '2025-10-01 00:58:36', '2025-10-01 00:58:36'),
(13, 'cod', NULL, '2025-10-07 19:03:33', '2025-10-07 19:03:33'),
(14, 'bkash', NULL, '2025-11-01 22:54:33', '2025-11-01 22:54:33'),
(15, 'bkash', NULL, '2025-11-04 18:37:30', '2025-11-04 18:37:30'),
(16, 'cod', NULL, '2025-11-05 04:45:10', '2025-11-05 04:45:10'),
(17, 'bkash', NULL, '2025-11-05 19:39:30', '2025-11-05 19:39:30'),
(18, 'cod', NULL, '2025-11-22 03:47:13', '2025-11-22 03:47:13'),
(19, 'cod', NULL, '2025-11-22 03:55:35', '2025-11-22 03:55:35'),
(20, 'cod', NULL, '2025-11-22 04:26:30', '2025-11-22 04:26:30'),
(57, 'cod', NULL, '2026-01-31 02:59:32', '2026-01-31 02:59:32'),
(58, 'bkash', NULL, '2026-02-03 01:30:36', '2026-02-03 01:30:36'),
(59, 'bkash', NULL, '2026-02-03 01:58:05', '2026-02-03 01:58:05'),
(60, 'bkash', NULL, '2026-02-03 02:00:23', '2026-02-03 02:00:23'),
(61, 'bkash', NULL, '2026-02-03 02:05:33', '2026-02-03 02:05:33'),
(62, 'bkash', NULL, '2026-02-03 02:11:45', '2026-02-03 02:11:45'),
(63, 'bkash', NULL, '2026-02-03 02:13:30', '2026-02-03 02:13:30'),
(64, 'bkash', NULL, '2026-02-03 02:15:27', '2026-02-03 02:15:27'),
(65, 'cod', NULL, '2026-02-07 00:49:43', '2026-02-07 00:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `payments_transaction`
--

CREATE TABLE `payments_transaction` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `trxID` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `credit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `debit` decimal(15,2) NOT NULL DEFAULT 0.00,
  `order_note` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments_transaction`
--

INSERT INTO `payments_transaction` (`id`, `client_id`, `order_id`, `transaction_type`, `trxID`, `payment_method`, `credit`, `debit`, `order_note`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'bkash_payment', 'CH166764ZI', 'bkash', 1.00, 0.00, 'order bkash payment', 0, NULL, NULL),
(2, 5, 2, 'bkash_payment', 'CH92D05B2G', 'bkash', 1.00, 0.00, 'order bkash payment', 0, NULL, NULL),
(4, 6, 19, 'bkash_payment', 'CKM0FBOEMO', 'bkash', 1.00, 0.00, 'order bkash payment', 0, NULL, NULL),
(5, 6, 20, 'bkash_payment', 'CKM9FCNKO5', 'bkash', 1.00, 0.00, 'order bkash payment', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `BKASH_USERNAME` varchar(255) DEFAULT NULL,
  `BKASH_PASSWORD` varchar(255) DEFAULT NULL,
  `BKASH_API_KEY` varchar(255) DEFAULT NULL,
  `BKASH_SECRET_KEY` varchar(255) DEFAULT NULL,
  `NAGAD_USERNAME` varchar(255) DEFAULT NULL,
  `NAGAD_PASSWORD` varchar(255) DEFAULT NULL,
  `NAGAD_API_KEY` varchar(255) DEFAULT NULL,
  `NAGAD_SECRET_KEY` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `active_status`, `BKASH_USERNAME`, `BKASH_PASSWORD`, `BKASH_API_KEY`, `BKASH_SECRET_KEY`, `NAGAD_USERNAME`, `NAGAD_PASSWORD`, `NAGAD_API_KEY`, `NAGAD_SECRET_KEY`, `created_at`, `updated_at`) VALUES
(1, 1, '01996166687', '-b0LIx}U%wO', 'yKWFhQzRxOpQkaMixu4EC7SUtc', 'rcL1L3K6tEYIw1DIIrtyBzrtauWQ2PVoLLloQn3G5H5oyvg5yAoG', 'fbsbfuwufq3411321', '231werwe22318uifh', 'fdaqaf3123552sf', 'sdgvbwf75453', '2025-02-02 00:12:18', '2025-02-02 00:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) NOT NULL COMMENT 'bKash, Nagad, Rocket',
  `number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `user_id`, `method`, `number`, `created_at`, `updated_at`) VALUES
(1, 10, 'Nagad', '01860871112', '2025-10-21 19:07:51', '2025-10-21 19:25:34'),
(2, 14, 'Bkash', '01816622128', '2025-11-04 08:09:09', '2025-11-04 08:09:09'),
(3, 24, 'Nagad', '01816622128', '2025-11-04 21:47:07', '2025-11-04 21:47:14'),
(4, 6, 'Bkash', '01816622128', '2025-11-05 11:52:52', '2025-11-22 03:03:20'),
(5, 6, 'Nagad', '01812266125', '2025-11-25 12:48:05', '2025-11-25 12:48:05'),
(6, 14, 'Nagad', '01617311817', '2025-12-08 20:42:48', '2025-12-08 20:42:48'),
(7, 14, 'Rocket', '0185858545', '2025-12-08 20:42:55', '2025-12-08 20:42:55');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person_info`
--

CREATE TABLE `person_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `person_id` varchar(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  `com_name` char(30) DEFAULT NULL,
  `person_type` int(11) NOT NULL,
  `balance` varchar(10) NOT NULL,
  `mobile` varchar(45) NOT NULL,
  `secondary_con` varchar(13) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `web` varchar(45) DEFAULT NULL,
  `added_time` datetime NOT NULL,
  `max_credit` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `person_info`
--

INSERT INTO `person_info` (`id`, `person_id`, `name`, `com_name`, `person_type`, `balance`, `mobile`, `secondary_con`, `email`, `address`, `web`, `added_time`, `max_credit`) VALUES
(1, 'S0001', 'Amin Hossain', 'TA Trading', 1, '0', '01712040919', '', '', '190, Gulshan Shopping Center, Gulshan 1, Dhaka-1212', 'www.trtradingbd.com', '2022-11-19 11:29:15', '0'),
(2, 'C0001', 'Liton', 'Tamanna Pharma', 0, '0', '01726808982', '', '', 'Rangpur', '', '2022-11-19 20:05:31', '0');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(6) UNSIGNED ZEROFILL DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `cat_slug` varchar(50) DEFAULT NULL,
  `subcategory_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model` varchar(25) DEFAULT NULL,
  `ptype` char(15) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `alert_label` tinyint(4) DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_bn` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `slug` varchar(191) DEFAULT NULL,
  `unit` char(10) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `trade_price` double NOT NULL,
  `price` double NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `min_price` decimal(10,2) DEFAULT NULL,
  `max_price` decimal(10,2) DEFAULT NULL,
  `prate` double DEFAULT 0,
  `srate` double DEFAULT 0,
  `vat` double DEFAULT 0,
  `discount_type` tinyint(4) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `short_desc` longtext DEFAULT NULL,
  `short_desc_bn` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `long_desc` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `hot_deals` tinyint(4) DEFAULT NULL,
  `featured` tinyint(4) DEFAULT NULL,
  `special_offer` tinyint(4) DEFAULT NULL,
  `special_deals` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 2,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(1000) DEFAULT NULL,
  `meta_description` varchar(2000) DEFAULT NULL,
  `meta_keywords` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `category_id`, `cat_slug`, `subcategory_id`, `brand_id`, `model`, `ptype`, `quantity`, `alert_label`, `user_id`, `name`, `name_bn`, `sku`, `slug`, `unit`, `country_id`, `trade_price`, `price`, `sale_price`, `min_price`, `max_price`, `prate`, `srate`, `vat`, `discount_type`, `discount`, `short_desc`, `short_desc_bn`, `long_desc`, `image`, `hot_deals`, `featured`, `special_offer`, `special_deals`, `status`, `created_at`, `updated_at`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
(1, NULL, 1, NULL, 1, 1, NULL, NULL, 50, 0, 1, 't-shirt', 'টি-শার্ট', 'U0001', 't-shirt74be1d95-8ccc-40f7-b6c4-30cf8b', NULL, 1, 600, 650, 520.00, 400.00, 620.00, 0, 0, 0, 2, 200, 'delivery one time only 7days', 'বিস্তারিত দেখুন', '<div class=\"xdj266r x14z9mp xat24cr x1lziwak x1vvkbs x126k92a\" style=\"margin: 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\"><span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"🆕\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/ta5/1/16/1f195.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span> নতুন কালেকশন চেইন শার্ট <span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"🔥\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t50/1/16/1f525.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span></div><div dir=\"auto\" style=\"font-family: inherit;\">সেরা মান, স্টাইলিশ ডিজাইন এবং ১০০% কোয়ালিটি গ্যারান্টি <span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"✅\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t33/1/16/2705.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span></div><div dir=\"auto\" style=\"font-family: inherit;\"><span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"💰\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t5a/1/16/1f4b0.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span> মাত্র ৬০০ টাকা!</div><div dir=\"auto\" style=\"font-family: inherit;\"><span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"📏\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t2f/1/16/1f4cf.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span> সাইজ: M / L / XL</div><div dir=\"auto\" style=\"font-family: inherit;\"><span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"📦\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t3d/1/16/1f4e6.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span> স্টকে সীমিত পরিমাণে প্রোডাক্ট!</div><div dir=\"auto\" style=\"font-family: inherit;\">অর্ডার <span class=\"html-span xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs\" style=\"margin: 0px; text-align: inherit; padding: 0px; overflow-wrap: break-word; font-family: inherit;\"><a tabindex=\"-1\" class=\"html-a xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs\" style=\"color: rgb(56, 88, 152); cursor: pointer; margin: 0px; text-align: inherit; padding: 0px; overflow-wrap: break-word; font-family: inherit;\"></a></span>কনফার্ম করতে ইনবক্স করুন অথবা কল করুন <span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"📞\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t4d/1/16/1f4de.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span> 01816622128</div><div dir=\"auto\" style=\"font-family: inherit;\"><span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"💬\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t6e/1/16/1f4ac.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span> হোয়াটসঅ্যাপে অর্ডার দিন, বাসায় বসেই ডেলিভারি নিন <span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"🏠\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tf6/1/16/1f3e0.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span></div></div><div class=\"x14z9mp xat24cr x1lziwak x1vvkbs xtlvy1s x126k92a\" style=\"margin: 0.5em 0px 0px; overflow-wrap: break-word; white-space-collapse: preserve; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px;\"><div dir=\"auto\" style=\"font-family: inherit;\"><span class=\"html-span xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x3nfvp2 x1j61x8r x1fcty0u xdj266r xat24cr xm2jcoa x1mpyi22 xxymvpz xlup9mm x1kky2od\" style=\"text-align: inherit; padding: 0px; overflow-wrap: break-word; margin: 0px 1px; display: inline-flex; vertical-align: middle; width: 16px; height: 16px; font-family: inherit;\"><img height=\"16\" width=\"16\" class=\"xz74otr x15mokao x1ga7v0g x16uus16 xbiv7yw\" alt=\"👉\" referrerpolicy=\"origin-when-cross-origin\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t51/1/16/1f449.png\" style=\"border: 0px; border-radius: 0px; object-fit: fill;\"></span> এখনই অর্ডার করুন, অফার সীমিত সময়ের জন্য </div></div>', '202601151908202507261949DAI1[1].png', 0, 0, 0, 0, 1, '2025-07-26 13:49:51', '2026-01-28 02:50:39', 'U Super Shop Premium Sports T-Shirt', 'Premium U-Super Shop sports t-shirt with modern design, breathable fabric, and comfortable fit—perfect for daily wear and active use.', 'U Super Shop t-shirt, sports jersey, printed t-shirt, breathable t-shirt, casual wear, athletic jersey, stylish t-shirt, men sports wear'),
(2, NULL, 1, NULL, 1, 1, NULL, NULL, 51, 0, 1, 't-shirt', 'টি-শার্ট', 'U0002', 't-shirt250988f8-c7cb-490e-8ad7-0054c6', NULL, 1, 650, 650, 520.00, 400.00, 620.00, 0, 0, 0, 2, 200, 'delivery one time only 7days', 'বিস্তারিত দেখুন', '<div>🆕 নতুন কালেকশন চেইন শার্ট 🔥</div><div>সেরা মান, স্টাইলিশ ডিজাইন এবং ১০০% কোয়ালিটি গ্যারান্টি ✅</div><div>💰 মাত্র ৬০০ টাকা!</div><div>📏 সাইজ: M / L / XL</div><div>📦 স্টকে সীমিত পরিমাণে প্রোডাক্ট!</div><div>অর্ডার কনফার্ম করতে ইনবক্স করুন অথবা কল করুন 📞 01816622128</div><div>💬 হোয়াটসঅ্যাপে অর্ডার দিন, বাসায় বসেই ডেলিভারি নিন 🏠</div><div>👉 এখনই অর্ডার করুন, অফার সীমিত সময়ের জন্য</div>', '202507262004DAI1.png', 0, 0, 0, 0, 1, '2025-07-26 14:04:49', '2026-01-28 02:51:08', 'U Super Shop Premium Sports T-Shirt', 'Premium U-Super Shop sports t-shirt with modern design, breathable fabric, and comfortable fit—perfect for daily wear and active use', 'U Super Shop t-shirt, sports jersey, printed t-shirt, breathable t-shirt, casual wear, athletic jersey, stylish t-shirt, men sports wear'),
(3, NULL, 1, NULL, 1, 1, NULL, NULL, 50, 0, 1, 't-shirt', 'টি-শার্ট', 'U0003', 't-shirt53e3640e-2a6c-4fde-bf75-fabc18', NULL, 1, 520, 650, 520.00, 300.00, 520.00, 0, 0, 0, 2, 130, '<p>Delivery time only 7days</p>', '<p>বিস্তারিত দেখুন</p>', '<p>new collection Chinese t-shirt<br>Size:👕Small, Medium, Large<br>40=M size: Long 40\" chest 42\"<br>42=L size: Long 42\" chest 44\"<br>44=XL size: Long 44\" chest 46\"<br>100% Color Guarantee✅<br></p><p>অডার কনফার্ম করার পর আমাদের হোয়াটসঅ্যাপ নাম্বারে যোগাযোগ করুন&nbsp; 01816622128 Support 24/7 Hours ✅<br><br>ডেলিভারি ম্যানকে আগে টাকা বুঝিয়ে দিয়ে প্রোডাক্টটি বুঝে নিবেন। ডেলিভারি ম্যান থাকা অবস্থায় অবশ্যই আপনার অর্ডার চেক করে নিবেন।📦🎊🎁 ডেলিভারি ম্যান চলে আসার পর কোনো অভিযোগ গ্রহণ করা হবে না।<br><br>thanks for connecting u super shop ✅ all time unlimited offer 🎁</p>', '20250728175860.jpg', 0, 0, 0, 0, 1, '2025-07-28 11:58:21', '2026-01-28 02:51:08', 'Men’s Striped Polo T-Shirt | New Arrival at U Super Shop', 'Buy men’s striped polo t-shirt in Bangladesh. Comfortable, stylish & perfect for daily wear. Order online from U Super Shop', 'men polo t-shirt Bangladesh, striped polo shirt BD, casual t-shirt for men, men fashion Bangladesh, U Super Shop'),
(4, NULL, 1, NULL, 1, 1, NULL, NULL, 10, 0, 1, 't-shirt', 'টি-শার্ট', 'U0004', 't-shirtfd530deb-2367-4b4f-9c5e-f38256', NULL, 1, 520, 650, 520.00, 300.00, 520.00, 0, 0, 0, 2, 130, 'Delivery Time Only 7Day\'s', '<p><span style=\"font-size: 1rem;\">বিস্তারিত দেখুন</span></p>', '<p>new collection Chinese t-shirt<br>Size:👕Small, Medium, Large<br>40=M size: Long 40\" chest 42\"<br>42=L size: Long 42\" chest 44\"<br>44=XL size: Long 44\" chest 46\"<br>100% Color Guarantee✅<br></p><p>অডার কনফার্ম করার পর আমাদের হোয়াটসঅ্যাপ নাম্বারে যোগাযোগ করুন&nbsp; 01816622128 Support 24/7 Hours ✅<br><br>ডেলিভারি ম্যানকে আগে টাকা বুঝিয়ে দিয়ে প্রোডাক্টটি বুঝে নিবেন। ডেলিভারি ম্যান থাকা অবস্থায় অবশ্যই আপনার অর্ডার চেক করে নিবেন।📦🎊🎁 ডেলিভারি ম্যান চলে আসার পর কোনো অভিযোগ গ্রহণ করা হবে না।<br><br>thanks for connecting u super shop ✅ all time unlimited offer 🎁</p>', '20250728180672.jpg', 0, 0, 0, 0, 1, '2025-07-28 12:06:35', '2026-01-28 02:51:08', 'Men’s Striped Polo T-Shirt Bangladesh | U Super Shop', 'Buy stylish men’s striped polo t-shirt in Bangladesh. Soft fabric, modern fit, perfect for everyday wear. Order now', 'men polo t-shirt Bangladesh, striped polo shirt BD, casual t-shirt for men, men fashion BD, U Super Shop polo'),
(5, NULL, 2, NULL, 2, 1, NULL, NULL, 10, 0, 1, 'shirt', 'শার্ট', 'U0005', 'shirtd0633397-16d9-4a64-abed-7d257b', NULL, 1, 600, 950, 760.00, 400.00, 620.00, 0, 0, 0, 2, 350, '<p>Delivery Time Only 7Day\'s</p>', '<p>&nbsp;বিস্তারিত দেখুন</p>', '<p>🆕 নতুন কালেকশন চেইন শার্ট 🔥<br>সেরা মান, স্টাইলিশ ডিজাইন এবং ১০০% কোয়ালিটি গ্যারান্টি ✅<br>💰 মাত্র ৬০০ টাকা!<br>📏 সাইজ: M / L / XL<br>📦 স্টকে সীমিত পরিমাণে প্রোডাক্ট!<br>অর্ডার কনফার্ম করুন অথবা কল করুন 📞 01816622128<br>💬 হোয়াটসঅ্যাপে অর্ডার দিন, বাসায় বসেই ডেলিভারি নিন 🏠<br><br>👉 এখনই অর্ডার করুন, অফার সীমিত সময়ের জন্য 🎁</p>', '20250728182152.jpg', 0, 0, 0, 0, 1, '2025-07-28 12:21:42', '2026-01-28 02:51:08', 'Men’s Shirt | স্টাইলিশ শার্ট অনলাইনে কিনুন বাংলাদেশ | U Super Shop', 'স্টাইলিশ ও আরামদায়ক Men’s Shirt অনলাইনে কিনুন বাংলাদেশ থেকে। Best quality shirt at best price. Fast delivery available – U Super Shop', 'men shirt Bangladesh, শার্ট অনলাইনে কিনুন, stylish shirt BD, U Super Shop shirt, buy men shirt online BD, fashion shirt Bangladesh'),
(6, NULL, 2, NULL, 2, 1, NULL, NULL, 150, 0, 1, 'shirt', 'শার্ট', 'U0006', 'shirt77f3c782-bf4d-4a88-a12c-b502b0', NULL, 1, 600, 950, 760.00, 400.00, 620.00, 0, 0, 0, 2, 350, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🆕 নতুন কালেকশন চেইন শার্ট 🔥<br>সেরা মান, স্টাইলিশ ডিজাইন এবং ১০০% কোয়ালিটি গ্যারান্টি ✅<br>💰 মাত্র ৬০০ টাকা!<br>📏 সাইজ: M / L / XL<br>📦 স্টকে সীমিত পরিমাণে প্রোডাক্ট!<br>অর্ডার কনফার্ম করুন অথবা কল করুন 📞 01816622128<br>💬 হোয়াটসঅ্যাপে অর্ডার দিন, বাসায় বসেই ডেলিভারি নিন 🏠<br><br>👉 এখনই অর্ডার করুন, অফার সীমিত সময়ের জন্য 🎁</p>', '20250728182553.jpg', 1, 1, 1, 1, 1, '2025-07-28 12:25:08', '2026-01-28 02:51:08', 'Men’s Shirt | স্টাইলিশ শার্ট অনলাইনে কিনুন বাংলাদেশ | U Super Shop', 'স্টাইলিশ ও আরামদায়ক Men’s Shirt অনলাইনে কিনুন বাংলাদেশ থেকে। Best quality shirt at best price. Fast delivery available – U Super Shop', 'men shirt Bangladesh, শার্ট অনলাইনে কিনুন, stylish shirt BD, U Super Shop shirt, buy men shirt online BD, fashion shirt Bangladesh'),
(7, NULL, 2, NULL, 2, 1, NULL, NULL, 21, 0, 1, 'shirt', 'শার্ট', 'U0007', 'shirt523f2cf3-6947-40fc-86a5-6c5eca', NULL, 1, 600, 950, 760.00, 400.00, 620.00, 0, 0, 0, 2, 350, '<p>Delivery Time Only 7Day\'s</p>', '<p>&nbsp;বিস্তারিত দেখুন</p>', '<p>🆕 নতুন কালেকশন চেইন শার্ট 🔥<br>সেরা মান, স্টাইলিশ ডিজাইন এবং ১০০% কোয়ালিটি গ্যারান্টি ✅<br>💰 মাত্র ৬০০ টাকা!<br>📏 সাইজ: M / L / XL<br>📦 স্টকে সীমিত পরিমাণে প্রোডাক্ট!<br>অর্ডার কনফার্ম করুন অথবা কল করুন 📞 01816622128<br>💬 হোয়াটসঅ্যাপে অর্ডার দিন, বাসায় বসেই ডেলিভারি নিন 🏠<br><br>👉 এখনই অর্ডার করুন, অফার সীমিত সময়ের জন্য 🎁</p>', '20250728182855.jpg', 1, 1, 1, 1, 1, '2025-07-28 12:28:13', '2026-01-28 02:51:08', 'Men’s Shirt | স্টাইলিশ শার্ট অনলাইনে কিনুন বাংলাদেশ | U Super Shop', 'স্টাইলিশ ও আরামদায়ক Men’s Shirt অনলাইনে কিনুন বাংলাদেশ থেকে। Best quality shirt at best price. Fast delivery available – U Super Shop', 'men shirt Bangladesh, শার্ট অনলাইনে কিনুন, stylish shirt BD, U Super Shop shirt, buy men shirt online BD, fashion shirt Bangladesh'),
(8, NULL, 2, NULL, 2, 1, NULL, NULL, 34, 0, 1, 'shirt', 'শার্ট', 'U0008', 'shirtc9cd09de-6656-4da0-bd16-900f17', NULL, 1, 600, 950, 760.00, 400.00, 620.00, 0, 0, 0, 2, 350, '<p>Delivery Time Only 7Day\'s</p>', '<p>&nbsp;বিস্তারিত দেখুন</p>', '<p>🆕 নতুন কালেকশন চেইন শার্ট 🔥<br>সেরা মান, স্টাইলিশ ডিজাইন এবং ১০০% কোয়ালিটি গ্যারান্টি ✅<br>💰 মাত্র ৬০০ টাকা!<br>📏 সাইজ: M / L / XL<br>📦 স্টকে সীমিত পরিমাণে প্রোডাক্ট!<br>অর্ডার কনফার্ম করুন অথবা কল করুন 📞 01816622128<br>💬 হোয়াটসঅ্যাপে অর্ডার দিন, বাসায় বসেই ডেলিভারি নিন 🏠<br><br>👉 এখনই অর্ডার করুন, অফার সীমিত সময়ের জন্য 🎁</p>', '20250728183256.jpg', 1, 1, 1, 1, 1, '2025-07-28 12:32:01', '2026-01-28 02:51:08', 'Men’s Shirt | স্টাইলিশ শার্ট অনলাইনে বাংলাদেশ – U Super Shop', 'স্টাইলিশ ও আরামদায়ক Men’s Shirt বাংলাদেশে অনলাইনে কিনুন। Best price & fast delivery – U Super Shop', 'men shirt BD, শার্ট অনলাইনে কিনুন, stylish shirt Bangladesh, buy shirt online BD, U Super Shop'),
(9, NULL, 2, NULL, 2, 1, NULL, NULL, 66, 0, 1, 'shirt', 'শার্ট', 'U0009', 'shirtab7f17a7-b488-47a4-99c5-906290', NULL, 1, 600, 950, 760.00, 400.00, 620.00, 0, 0, 0, 2, 350, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🆕 নতুন কালেকশন চেইন শার্ট 🔥<br>সেরা মান, স্টাইলিশ ডিজাইন এবং ১০০% কোয়ালিটি গ্যারান্টি ✅<br>💰 মাত্র ৬০০ টাকা!<br>📏 সাইজ: M / L / XL<br>📦 স্টকে সীমিত পরিমাণে প্রোডাক্ট!<br>অর্ডার কনফার্ম করুন অথবা কল করুন 📞 01816622128<br>💬 হোয়াটসঅ্যাপে অর্ডার দিন, বাসায় বসেই ডেলিভারি নিন 🏠<br><br>👉 এখনই অর্ডার করুন, অফার সীমিত সময়ের জন্য&nbsp;</p>', '20250728183457.jpg', 1, 1, 1, 1, 1, '2025-07-28 12:34:11', '2026-01-28 02:51:08', 'Men’s Shirt | স্টাইলিশ শার্ট অনলাইনে বাংলাদেশ – U Super Shop', 'স্টাইলিশ ও আরামদায়ক Men’s Shirt বাংলাদেশে অনলাইনে কিনুন। Best price & fast delivery – U Super Shop', 'men shirt BD, শার্ট অনলাইনে কিনুন, stylish shirt Bangladesh, buy shirt online BD, U Super Shop'),
(10, NULL, 2, NULL, 2, 1, NULL, NULL, 45, 0, 1, 'shirt', 'শার্ট', '5658', 'shirtad004398-1b3e-48af-ae60-9fe7da', NULL, 1, 600, 950, 760.00, 400.00, 620.00, 0, 0, 0, 2, 350, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🆕 নতুন কালেকশন চেইন শার্ট 🔥<br>সেরা মান, স্টাইলিশ ডিজাইন এবং ১০০% কোয়ালিটি গ্যারান্টি ✅<br>💰 মাত্র ৬০০ টাকা!<br>📏 সাইজ: M / L / XL<br>📦 স্টকে সীমিত পরিমাণে প্রোডাক্ট!<br>অর্ডার কনফার্ম করুন অথবা কল করুন 📞 01816622128<br>💬 হোয়াটসঅ্যাপে অর্ডার দিন, বাসায় বসেই ডেলিভারি নিন 🏠<br><br>👉 এখনই অর্ডার করুন, অফার সীমিত সময়ের জন্য 🎁</p>', '20250728183658.jpg', 1, 1, 1, 1, 1, '2025-07-28 12:36:25', '2026-01-28 02:51:08', 'Men’s Shirt | স্টাইলিশ শার্ট অনলাইনে বাংলাদেশ – U Super Shop', 'স্টাইলিশ ও আরামদায়ক Men’s Shirt বাংলাদেশে অনলাইনে কিনুন। Best price & fast delivery – U Super Shop', 'men shirt BD, শার্ট অনলাইনে কিনুন, stylish shirt Bangladesh, buy shirt online BD, U Super Shop'),
(11, NULL, 2, NULL, 2, 1, NULL, NULL, 50, 0, 1, 'shirt', 'শার্ট', '2652', 'shirt96327495-16ac-4a11-8aaf-8ff89e', NULL, 1, 600, 950, 760.00, 400.00, 620.00, 0, 0, 0, 2, 350, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🆕 নতুন কালেকশন চেইন শার্ট 🔥<br>সেরা মান, স্টাইলিশ ডিজাইন এবং ১০০% কোয়ালিটি গ্যারান্টি ✅<br>💰 মাত্র ৬০০ টাকা!<br>📏 সাইজ: M / L / XL<br>📦 স্টকে সীমিত পরিমাণে প্রোডাক্ট!<br>অর্ডার কনফার্ম করুন অথবা কল করুন 📞 01816622128<br>💬 হোয়াটসঅ্যাপে অর্ডার দিন, বাসায় বসেই ডেলিভারি নিন 🏠<br><br>👉 এখনই অর্ডার করুন, অফার সীমিত সময়ের জন্য 🎁</p>', '202507281839u0051.jpg', 1, 1, 1, 1, 1, '2025-07-28 12:39:13', '2026-02-07 00:49:43', 'Men’s Shirt | স্টাইলিশ শার্ট অনলাইনে বাংলাদেশ – U Super Shop', 'স্টাইলিশ ও আরামদায়ক Men’s Shirt বাংলাদেশে অনলাইনে কিনুন। Best price & fast delivery – U Super Shop', 'men shirt BD, শার্ট অনলাইনে কিনুন, stylish shirt Bangladesh, buy shirt online BD, U Super Shop'),
(12, NULL, 3, NULL, 3, 1, NULL, NULL, 1506, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', 'u82254', 'new-collection-stylish-striped-soft-cotton-punjabi967c7155-0d5b-4584-af4b-0b0371', NULL, 1, 800, 1150, 920.00, 600.00, 1150.00, 0, 0, 0, 2, 350, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202507301754p2.jpg', 0, 0, 0, 0, 1, '2025-07-30 11:54:13', '2026-01-28 02:51:08', 'Stylish Striped Cotton Punjabi | সফট কটন পাঞ্জাবি বাংলাদেশ – U Super Shop', 'New Collection Stylish Striped Soft Cotton Punjabi কিনুন বাংলাদেশে। Comfortable, premium quality & best price – U Super Shop', 'cotton punjabi BD, striped punjabi Bangladesh, পাঞ্জাবি অনলাইনে কিনুন, stylish punjabi BD, U Super Shop punjabi'),
(13, NULL, 3, NULL, 3, 1, NULL, NULL, 1852, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', 'u45421', 'new-collection-stylish-striped-soft-cotton-punjabia860e6bc-be20-4563-a24b-cec449', NULL, 1, 800, 1150, 920.00, 600.00, 1150.00, 0, 0, 0, 2, 350, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202507301759p4.jpg', 0, 0, 0, 0, 1, '2025-07-30 11:59:35', '2026-01-28 02:51:08', 'Stylish Striped Cotton Punjabi | সফট কটন পাঞ্জাবি বাংলাদেশ – U Super Shop', 'New Collection Stylish Striped Soft Cotton Punjabi কিনুন বাংলাদেশে। Comfortable, premium quality & best price – U Super Shop', 'cotton punjabi BD, striped punjabi Bangladesh, পাঞ্জাবি অনলাইনে কিনুন, stylish punjabi BD, U Super Shop punjabi'),
(14, NULL, 3, NULL, 3, 1, NULL, NULL, 150, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', 'u5622', 'new-collection-stylish-striped-soft-cotton-punjabi22db93de-70ea-4988-95ac-dce5aa', NULL, 1, 780, 1150, 920.00, 580.00, 1100.00, 0, 0, 0, 2, 370, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন <br></p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202507301804p3.jpg', 0, 0, 0, 0, 1, '2025-07-30 12:04:08', '2026-01-28 02:51:08', 'Stylish Striped Cotton Punjabi | সফট কটন পাঞ্জাবি বাংলাদেশ – U Super Shop', 'New Collection Stylish Striped Soft Cotton Punjabi কিনুন বাংলাদেশে। Comfortable, premium quality & best price – U Super Shop', 'cotton punjabi BD, striped punjabi Bangladesh, পাঞ্জাবি অনলাইনে কিনুন, stylish punjabi BD, U Super Shop punjabi'),
(15, NULL, 3, NULL, 3, 1, NULL, NULL, 451, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', 'u1512', 'new-collection-stylish-striped-soft-cotton-punjabi8d45d357-9379-4973-90bb-26eff0', NULL, 1, 750, 1250, 1000.00, 600.00, 1200.00, 0, 0, 0, 2, 500, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202507301808p10.jpg', 0, 0, 0, 0, 1, '2025-07-30 12:08:32', '2026-01-28 02:51:08', 'Stylish Striped Cotton Punjabi | সফট কটন পাঞ্জাবি বাংলাদেশ – U Super Shop', 'New Collection Stylish Striped Soft Cotton Punjabi কিনুন বাংলাদেশে। Comfortable, premium quality & best price – U Super Shop', 'cotton punjabi BD, striped punjabi Bangladesh, পাঞ্জাবি অনলাইনে কিনুন, stylish punjabi BD, U Super Shop punjabi'),
(16, NULL, 3, NULL, 3, 1, NULL, NULL, 885, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', 'u4441', 'new-collection-stylish-striped-soft-cotton-punjabie3afa4fa-637c-440e-a3d9-e19056', NULL, 1, 750, 1250, 1000.00, NULL, NULL, 0, 0, 0, 2, 500, '<p>elivery Time Only 3.Day\'s</p>', '<p>বিস্তারিত দেখুন <br></p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202507301811p12.jpg', NULL, NULL, 0, NULL, 1, '2025-07-30 12:11:14', '2026-01-28 02:51:08', NULL, NULL, NULL),
(17, NULL, 3, NULL, 3, 1, NULL, NULL, 355, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', 'u54644', 'new-collection-stylish-striped-soft-cotton-punjabi22f10cf0-0830-40c4-a86a-2e8865', NULL, 1, 750, 1250, 1000.00, NULL, NULL, 0, 0, 0, 2, 500, '<p>Delivery Time Only 3.Day\'s</p>', '<p>বিস্তারিত দেখুন&nbsp;</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202507301814p12.jpg', NULL, NULL, 0, NULL, 1, '2025-07-30 12:14:29', '2026-01-28 02:51:08', NULL, NULL, NULL),
(19, NULL, 3, NULL, 3, 1, NULL, NULL, 800, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'নতুন কালেকশন: স্টাইলিশ স্ট্রাইপড নরম সুতির পাঞ্জাবি', '12622', 'hhhhhhhhhhhhmmm', NULL, 1, 800, 1050, 840.00, 520.00, 1020.00, 0, 0, 0, 2, 250, '<p>delivery one time only 7days</p>', '<p>বিস্তারিত দেখুন</p>', '🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!', '202508011140U012.jpg', 0, 0, 0, 0, 1, '2025-08-01 05:40:26', '2026-01-28 02:51:08', 'Eid Offer Stylish Punjabi | ঈদ স্পেশাল পাঞ্জাবি BD – U Super Shop', 'ঈদ উপলক্ষে Stylish Striped Cotton Punjabi কিনুন বাংলাদেশে। Eid special offer, best price & fast delivery – U Super Shop', 'eid punjabi BD, ঈদ অফার পাঞ্জাবি, stylish punjabi Bangladesh, U Super Shop eid offer'),
(20, NULL, 3, NULL, 3, 1, NULL, NULL, 782, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '26121', 'new-collection-stylish-striped-soft-cotton-punjabid78c2bdf-081a-4d78-b6eb-0c2ac2', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s&nbsp;</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508012153U001.jpg', 0, 0, 0, 0, 1, '2025-08-01 15:53:54', '2026-01-28 02:51:08', 'Stylish Striped Cotton Punjabi | সফট কটন পাঞ্জাবি বাংলাদেশ – U Super Shop', 'New Collection Stylish Striped Soft Cotton Punjabi কিনুন বাংলাদেশে। Comfortable, premium quality & best price – U Super Shop', 'cotton punjabi BD, striped punjabi Bangladesh, পাঞ্জাবি অনলাইনে কিনুন, stylish punjabi BD, U Super Shop punjabi'),
(21, NULL, 3, NULL, 3, 1, NULL, NULL, 965, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '6632', 'new-collection-stylish-striped-soft-cotton-punjabib34b7291-9b2f-4a70-b66d-4c9d8d', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p><span style=\"font-size: 1rem;\">Delivery Time Only 7Day\'s&nbsp;</span></p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508012157U002.jpg', 0, 0, 1, 0, 1, '2025-08-01 15:57:33', '2026-01-28 02:51:08', 'Stylish Striped Cotton Punjabi | সফট কটন পাঞ্জাবি বাংলাদেশ – U Super Shop', 'New Collection Stylish Striped Soft Cotton Punjabi কিনুন বাংলাদেশে। Comfortable, premium quality & best price – U Super Shop', 'cotton punjabi BD, striped punjabi Bangladesh, পাঞ্জাবি অনলাইনে কিনুন, stylish punjabi BD, U Super Shop punjabi'),
(22, NULL, 3, NULL, 3, 1, NULL, NULL, 595, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '33253', 'new-collection-stylish-striped-soft-cotton-punjabieb798084-9e04-4ce5-8c7b-f5639e', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s&nbsp;</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508012201U003.jpg', 0, 0, 1, 0, 1, '2025-08-01 16:01:32', '2026-01-28 02:51:08', 'Stylish Striped Cotton Punjabi | সফট কটন পাঞ্জাবি বাংলাদেশ – U Super Shop', 'New Collection Stylish Striped Soft Cotton Punjabi কিনুন বাংলাদেশে। Comfortable, premium quality & best price – U Super Shop', 'cotton punjabi BD, striped punjabi Bangladesh, পাঞ্জাবি অনলাইনে কিনুন, stylish punjabi BD, U Super Shop punjabi'),
(23, NULL, 3, NULL, 3, 1, NULL, NULL, 664, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '544554', 'new-collection-stylish-striped-soft-cotton-punjabic0ffbf55-0416-4fd7-ac11-0b26c3', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p>delivery one time only 7days</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508012205U004.jpg', 0, 0, 1, 0, 1, '2025-08-01 16:05:06', '2026-01-28 02:51:08', 'Stylish Striped Cotton Punjabi | সফট কটন পাঞ্জাবি বাংলাদেশ – U Super Shop', 'New Collection Stylish Striped Soft Cotton Punjabi কিনুন বাংলাদেশে। Comfortable, premium quality & best price – U Super Shop', 'cotton punjabi BD, striped punjabi Bangladesh, পাঞ্জাবি অনলাইনে কিনুন, stylish punjabi BD, U Super Shop punjabi'),
(24, NULL, 3, NULL, 3, 1, NULL, NULL, 395, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '56564', 'new-collection-stylish-striped-soft-cotton-punjabi6b9205e5-820a-46ef-aa34-7c0bed', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p><span style=\"font-size: 1rem;\">Delivery Time Only 7Day\'s&nbsp;</span></p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508012208U005.jpg', 0, 0, 0, 0, 1, '2025-08-01 16:08:12', '2026-01-28 02:51:08', 'Ramadan Offer Cotton Punjabi | রমজান স্পেশাল পাঞ্জাবি BD – U Super Shop', 'রমজান অফারে Stylish Soft Cotton Punjabi কিনুন বাংলাদেশে। Special discount, premium quality & fast delivery – U Super Shop', 'ramadan punjabi BD, রমজান অফার পাঞ্জাবি, cotton punjabi Bangladesh, U Super Shop ramadan offer'),
(25, NULL, 3, NULL, 3, 1, NULL, NULL, 652, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '135212', 'new-collection-stylish-striped-soft-cotton-punjabif6aae8c1-2303-48f5-86ac-5281df', NULL, 1, 800, 1020, 816.00, 700.00, 1020.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s&nbsp;</p>', 'বিস্তারিত দেখুন', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508012213U006.jpg', 0, 0, 1, 0, 1, '2025-08-01 16:13:07', '2026-01-28 02:51:08', 'Ramadan Offer Cotton Punjabi | রমজান স্পেশাল পাঞ্জাবি BD – U Super Shop', 'রমজান অফারে Stylish Soft Cotton Punjabi কিনুন বাংলাদেশে। Special discount, premium quality & fast delivery – U Super Shop', 'ramadan punjabi BD, রমজান অফার পাঞ্জাবি, cotton punjabi Bangladesh, U Super Shop ramadan offer'),
(26, NULL, 3, NULL, 3, 1, NULL, NULL, 541, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '62241', 'new-collection-stylish-striped-soft-cotton-punjabif73b84ec-56a6-4624-b84b-7d71b8', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508021356U007.jpg', 0, 0, 0, 0, 1, '2025-08-02 07:56:06', '2026-01-28 02:51:08', 'Eid Offer Stylish Punjabi | ঈদ স্পেশাল পাঞ্জাবি BD – U Super Shop', 'ঈদ উপলক্ষে Stylish Striped Cotton Punjabi কিনুন বাংলাদেশে। Eid special offer, best price & fast delivery – U Super Shop.', 'eid punjabi BD, ঈদ অফার পাঞ্জাবি, stylish punjabi Bangladesh, U Super Shop eid offer'),
(27, NULL, 3, NULL, 3, 1, NULL, NULL, 754, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '6524', 'new-collection-stylish-striped-soft-cotton-punjabia01fdb5f-0601-4aef-a2a5-1eeca2', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508021414U008.jpg', 0, 0, 1, 1, 1, '2025-08-02 08:13:24', '2026-01-28 02:51:08', 'Eid Offer Stylish Punjabi | ঈদ স্পেশাল পাঞ্জাবি BD – U Super Shop', 'ঈদ উপলক্ষে Stylish Striped Cotton Punjabi কিনুন বাংলাদেশে। Eid special offer, best price & fast delivery – U Super Shop.', 'eid punjabi BD, ঈদ অফার পাঞ্জাবি, stylish punjabi Bangladesh, U Super Shop eid offer'),
(28, NULL, 3, NULL, 3, 1, NULL, NULL, 694, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '6558', 'new-collection-stylish-striped-soft-cotton-punjabib5963e37-bd29-4453-8b14-7c22ba', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s</p>', 'বিস্তারিত দেখুন', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508021419U009.jpg', 0, 0, 0, 0, 1, '2025-08-02 08:19:41', '2026-01-28 02:51:08', 'Eid Offer Stylish Punjabi | ঈদ স্পেশাল পাঞ্জাবি BD – U Super Shop', 'ঈদ উপলক্ষে Stylish Striped Cotton Punjabi কিনুন বাংলাদেশে। Eid special offer, best price & fast delivery – U Super Shop', 'eid punjabi BD, ঈদ অফার পাঞ্জাবি, stylish punjabi Bangladesh, U Super Shop eid offer'),
(29, NULL, 3, NULL, 3, 1, NULL, NULL, 1584, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '51254', 'new-collection-stylish-striped-soft-cotton-punjabi9f7f98d7-6dec-4e4d-9142-676890', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508021422U010.jpg', 0, 0, 0, 0, 1, '2025-08-02 08:22:07', '2026-01-28 02:51:08', 'Eid Offer Stylish Punjabi | ঈদ স্পেশাল পাঞ্জাবি BD – U Super Shop', 'ঈদ উপলক্ষে Stylish Striped Cotton Punjabi কিনুন বাংলাদেশে। Eid special offer, best price & fast delivery – U Super Shop', 'eid punjabi BD, ঈদ অফার পাঞ্জাবি, stylish punjabi Bangladesh, U Super Shop eid offer'),
(30, NULL, 3, NULL, 3, 1, NULL, NULL, 3000, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '6554', 'new-collection-stylish-striped-soft-cotton-punjabi8168d218-713a-438f-a873-318c67', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508021424U011.jpg', 0, 0, 1, 0, 1, '2025-08-02 08:24:17', '2026-01-28 02:51:08', 'Eid Offer Stylish Punjabi | ঈদ স্পেশাল পাঞ্জাবি BD – U Super Shop', 'ঈদ উপলক্ষে Stylish Striped Cotton Punjabi কিনুন বাংলাদেশে। Eid special offer, best price & fast delivery – U Super Shop', 'eid punjabi BD, ঈদ অফার পাঞ্জাবি, stylish punjabi Bangladesh, U Super Shop eid offer'),
(31, NULL, 3, NULL, 3, 1, NULL, NULL, 2812, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '35512', 'new-collection-stylish-striped-soft-cotton-punjabi48fc9508-4709-4bad-8dde-628e47', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p><span style=\"font-size: 1rem;\">Delivery Time Only 7Day\'s</span></p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508021426U012.jpg', 0, 0, 0, 0, 1, '2025-08-02 08:26:58', '2026-01-28 02:51:08', 'Eid Offer Stylish Punjabi | ঈদ স্পেশাল পাঞ্জাবি BD – U Super Shop', 'ঈদ উপলক্ষে Stylish Striped Cotton Punjabi কিনুন বাংলাদেশে। Eid special offer, best price & fast delivery – U Super Shop.', 'eid punjabi BD, ঈদ অফার পাঞ্জাবি, stylish punjabi Bangladesh, U Super Shop eid offer'),
(32, NULL, 3, NULL, 3, 1, NULL, NULL, 2544, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '51265', 'new-collection-stylish-striped-soft-cotton-punjabie11dc090-15c8-403f-b5fd-e17206', NULL, 1, 800, 1020, 816.00, 520.00, 1020.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508021429db2f5041-5f28-4d31-91f0-638d620dd9d8.png', 0, 0, 1, 0, 1, '2025-08-02 08:29:37', '2026-02-03 02:11:45', 'Eid Offer Stylish Punjabi | ঈদ স্পেশাল পাঞ্জাবি BD – U Super Shop', 'ঈদ উপলক্ষে Stylish Striped Cotton Punjabi কিনুন বাংলাদেশে। Eid special offer, best price & fast delivery – U Super Shop', 'eid punjabi BD, ঈদ অফার পাঞ্জাবি, stylish punjabi Bangladesh, U Super Shop eid offer'),
(33, NULL, 3, NULL, 3, 1, NULL, NULL, 577, 0, 1, 'New Collection: Stylish Striped Soft Cotton Punjabi', 'পাঞ্জাবি', '54211', 'new-collection-stylish-striped-soft-cotton-punjabi657e7cfc-5523-4d65-8584-edee0a', NULL, 1, 800, 1020, 700.00, 720.00, 1200.00, 0, 0, 0, 2, 220, '<p>Delivery Time Only 7Day\'s</p>', '<p>বিস্তারিত দেখুন</p>', '<p>🎉 Special Offer – 75% Off!<br>🔥 মাত্র ৮০০ টাকা!<br>🚀 মাত্র ৩ দিনের মধ্যে ডেলিভারি<br>✅ 100% অরিজিনাল ও হ্যান্ডপেইন্টেড পাঞ্জাবি<br>✅ পেমেন্ট ও ডেলিভারি গ্যারান্টি সহ<br><br>🧵 New Collection: Stylish Striped Soft Cotton Punjabi<br>🎨 Hand Paint Work | 💯 Color Guarantee<br>Limited Stock<br><br>📏 Available Sizes:<br>S (38)<br>M (40)<br>L (42)<br>XL (44)<br>XXL (46)<br><br>📞 অর্ডার কনফার্ম করার পর WhatsApp যোগাযোগ করুন: 01816622128<br>📦 ডেলিভারির সময় প্রোডাক্ট চেক করে নিন। ডেলিভারি ম্যান চলে যাওয়ার পরে কোনো অভিযোগ গ্রহণযোগ্য নয়।<br><br>🌐 Shop Now: www.usupershop.com<br>🛍 U Super Shop – Always Unlimited Offer!</p>', '202508021431new ai.png', 0, 0, 1, 0, 1, '2025-08-02 08:31:50', '2026-02-03 02:15:27', 'Eid Offer Stylish Punjabi | ঈদ স্পেশাল পাঞ্জাবি BD – U Super Shop', 'ঈদ উপলক্ষে Stylish Striped Cotton Punjabi কিনুন বাংলাদেশে। Eid special offer, best price & fast delivery – U Super Shop', 'eid punjabi BD, ঈদ অফার পাঞ্জাবি, stylish punjabi Bangladesh, U Super Shop eid offer'),
(41, NULL, 1, NULL, 1, 1, NULL, NULL, 6, 0, 1, 'test999', 'test555', 'test999', 'test999e1a17537-b7ed-494c-9ee2-92c583', NULL, 1, 1000, 1000, 800.00, 620.00, 1200.00, 0, 0, 0, 2, 200, '<p>test888</p>', '<p>666</p>', '<p>333</p>', '20250926174254.jpg', 1, 0, 0, 0, 2, '2025-09-26 11:42:52', '2025-11-01 22:54:33', NULL, NULL, NULL),
(43, NULL, 2, NULL, 2, 1, NULL, NULL, 9, 0, 1, 'test testing', 'fast gggggg', 'test1500', 'test-testing31d9b022-9b0b-4ace-a03d-6cc63d', NULL, 1, 1000, 800, 640.00, 600.00, 900.00, 0, 0, 0, 2, 100, '<p>rssssdccccccccccccccccccccccccc</p>', '<p>lllllllllllllllljjjjjjjjjjjjjjjjjjjjjjjjjjj</p>', '<p>this good proudct</p>', '20251122101655.jpg', 0, 0, 1, 0, 1, '2025-11-22 04:16:37', '2026-01-28 02:51:08', 'offers all time', '30days', 'offers'),
(44, NULL, 17, NULL, 10, 1, NULL, NULL, 20, 0, 1, 'জুমকোলতা ছামার কাতান শাড়ি Matching Blouse Piece Included', 'Jhumkolata Chamar Katan Saree Matching Blouse Piece Included', 'U0051', 'jumkolta-chamar-katan-sari-matching-blouse-piece-includedc4d7b28f-457b-4ff5-80ab-c7a265', NULL, 1, 1300, 1750, 1400.00, 1100.00, 1500.00, 0, 0, 0, 2, 450, '<p>delivery one time only 7days</p>', '<p>বিস্তারিত দেখুন</p>', '<div>বাংলা:</div><div>✨ রমজান ও ঈদের স্পেশাল অফার ✨</div><div>জুমকোলতা ছামার কাতান শাড়ি</div><div>✔ ম্যাচিং ব্লাউজ পিসসহ</div><div>📦 সারা বাংলাদেশে ডেলিভারি</div><div>🛒 Order Now – www.usupershop.cpm</div><div><br></div><div>English:</div><div>✨ Ramadan &amp; Eid Special Offer ✨</div><div>Jumkolota Shamar Katan Saree</div><div>✔ Matching Blouse Piece Included</div><div>📦 Delivery All Over Bangladesh</div><div>🛒 Order Now – <a href=\"http://www.usupershop.cpm\" target=\"_blank\">www.usupershop.cpm</a><br></div>', '202601182002usupershop1.jpg', 0, 0, 1, 0, 1, '2026-01-18 14:02:43', '2026-01-28 02:51:08', 'জুমকোলতা ছামার কাতান শাড়ি | ব্লাউজ পিসসহ | U Super Shop', 'জুমকোলতা ছামার কাতান শাড়ি | ব্লাউজ পিসসহ | U Super Shop', 'জুমকোলতা কাতান শাড়ি, ছামার কাতান শাড়ি, ব্লাউজ পিসসহ শাড়ি, ঈদের শাড়ি, রমজানের শাড়ি, বাংলাদেশ শাড়ি, ইউ সুপার শপ');
INSERT INTO `products` (`id`, `product_id`, `category_id`, `cat_slug`, `subcategory_id`, `brand_id`, `model`, `ptype`, `quantity`, `alert_label`, `user_id`, `name`, `name_bn`, `sku`, `slug`, `unit`, `country_id`, `trade_price`, `price`, `sale_price`, `min_price`, `max_price`, `prate`, `srate`, `vat`, `discount_type`, `discount`, `short_desc`, `short_desc_bn`, `long_desc`, `image`, `hot_deals`, `featured`, `special_offer`, `special_deals`, `status`, `created_at`, `updated_at`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
(45, NULL, 17, NULL, 10, 1, NULL, NULL, 100, 0, 1, 'Jumkolota Shamar Katan Saree Matching Blouse', 'জুমকোলতা ছামার কাতান শাড়ি  ম্যাচিং ব্লাউজ পিসসহ', 'U00520', 'jumkolota-shamar-katan-saree-matching-blouse48a5f710-90e1-4e9f-9907-9a627f', NULL, 1, 1300, 1750, 1400.00, 1200.00, 1500.00, 0, 0, 0, 2, 450, NULL, NULL, '<p><span data-start=\"1183\" data-end=\"1193\" style=\"font-weight: bolder;\">বাংলা:</span><br data-start=\"1193\" data-end=\"1196\">✨ রমজান ও ঈদের স্পেশাল অফার ✨<br data-start=\"1225\" data-end=\"1228\">জুমকোলতা ছামার কাতান শাড়ি<br data-start=\"1253\" data-end=\"1256\">✔ ম্যাচিং ব্লাউজ পিসসহ<br data-start=\"1278\" data-end=\"1281\">📦 সারা বাংলাদেশে ডেলিভারি<br data-start=\"1307\" data-end=\"1310\">🛒 Order Now –www.usupershop.com<br><br><span data-start=\"1347\" data-end=\"1359\" style=\"font-weight: bolder;\">English:</span><br data-start=\"1359\" data-end=\"1362\">✨ Ramadan &amp; Eid Special Offer ✨<br data-start=\"1393\" data-end=\"1396\">Jumkolota Shamar Katan Saree<br data-start=\"1424\" data-end=\"1427\">✔ Matching Blouse Piece Included<br data-start=\"1459\" data-end=\"1462\">📦 Delivery All Over Bangladesh<br data-start=\"1493\" data-end=\"1496\">🛒 Order Now –&nbsp;<a data-start=\"1511\" data-end=\"1529\" rel=\"noopener\" target=\"_new\" class=\"decorated-link\" href=\"http://www.usupershop.com/\" style=\"background-color: rgb(255, 255, 255);\"></a>&nbsp;www.usupershop.com</p>', '202601191901usupershop2.jpg', NULL, NULL, 1, NULL, 1, '2026-01-19 13:01:54', '2026-01-28 02:51:08', 'জুমকোলতা ছামার কাতান শাড়ি | ব্লাউজ পিসসহ | U Super Shop', 'জুমকোলতা ছামার কাতান শাড়ি এখন পাচ্ছেন ম্যাচিং ব্লাউজ পিসসহ। রমজান ও ঈদের বিশেষ অফার চলছে। অর্ডার করুন এখনই – www.usupershop.com\r\n (Bangladesh)', 'জুমকোলতা কাতান শাড়ি, ছামার কাতান শাড়ি, ব্লাউজ পিসসহ শাড়ি, ঈদের শাড়ি, রমজানের শাড়ি, বাংলাদেশ শাড়ি, ইউ সুপার শপ');

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

CREATE TABLE `product_colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`id`, `product_id`, `color_id`, `created_at`, `updated_at`) VALUES
(20, 16, 1, '2025-07-30 12:11:14', '2025-07-30 12:11:14'),
(21, 17, 1, '2025-07-30 12:14:29', '2025-07-30 12:14:29'),
(49, 41, 3, '2025-09-26 11:48:14', '2025-09-26 11:48:14'),
(50, 41, 4, '2025-09-26 11:48:14', '2025-09-26 11:48:14'),
(51, 41, 5, '2025-09-26 11:48:14', '2025-09-26 11:48:14'),
(65, 2, 1, '2026-01-15 13:24:36', '2026-01-15 13:24:36'),
(68, 1, 1, '2026-01-15 13:37:44', '2026-01-15 13:37:44'),
(70, 3, 1, '2026-01-16 08:12:42', '2026-01-16 08:12:42'),
(71, 4, 1, '2026-01-16 08:33:34', '2026-01-16 08:33:34'),
(73, 5, 1, '2026-01-17 12:05:20', '2026-01-17 12:05:20'),
(74, 6, 1, '2026-01-17 12:07:01', '2026-01-17 12:07:01'),
(77, 7, 1, '2026-01-17 12:16:52', '2026-01-17 12:16:52'),
(78, 8, 1, '2026-01-17 12:18:03', '2026-01-17 12:18:03'),
(79, 9, 1, '2026-01-17 12:20:22', '2026-01-17 12:20:22'),
(81, 10, 1, '2026-01-17 12:23:25', '2026-01-17 12:23:25'),
(82, 11, 1, '2026-01-17 12:25:37', '2026-01-17 12:25:37'),
(83, 12, 1, '2026-01-17 12:31:51', '2026-01-17 12:31:51'),
(84, 13, 1, '2026-01-17 12:33:30', '2026-01-17 12:33:30'),
(85, 14, 1, '2026-01-17 12:35:10', '2026-01-17 12:35:10'),
(86, 15, 1, '2026-01-17 12:37:02', '2026-01-17 12:37:02'),
(87, 20, 1, '2026-01-17 12:44:55', '2026-01-17 12:44:55'),
(88, 21, 1, '2026-01-17 12:47:57', '2026-01-17 12:47:57'),
(89, 22, 1, '2026-01-17 12:50:10', '2026-01-17 12:50:10'),
(91, 23, 1, '2026-01-17 13:06:52', '2026-01-17 13:06:52'),
(93, 24, 1, '2026-01-17 13:20:25', '2026-01-17 13:20:25'),
(94, 25, 1, '2026-01-17 13:23:22', '2026-01-17 13:23:22'),
(96, 26, 1, '2026-01-17 13:27:16', '2026-01-17 13:27:16'),
(97, 27, 1, '2026-01-17 13:27:56', '2026-01-17 13:27:56'),
(98, 28, 1, '2026-01-17 13:29:30', '2026-01-17 13:29:30'),
(99, 29, 1, '2026-01-17 13:30:48', '2026-01-17 13:30:48'),
(100, 30, 1, '2026-01-17 13:33:13', '2026-01-17 13:33:13'),
(101, 31, 1, '2026-01-17 13:36:05', '2026-01-17 13:36:05'),
(102, 32, 1, '2026-01-17 13:37:41', '2026-01-17 13:37:41'),
(105, 19, 2, '2026-01-17 13:46:01', '2026-01-17 13:46:01'),
(107, 43, 2, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(108, 43, 3, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(109, 45, 15, '2026-01-19 13:01:54', '2026-01-19 13:01:54'),
(110, 44, 15, '2026-01-19 13:02:24', '2026-01-19 13:02:24'),
(111, 33, 1, '2026-01-28 03:18:12', '2026-01-28 03:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size_id`, `created_at`, `updated_at`) VALUES
(58, 16, 1, '2025-07-30 12:11:14', '2025-07-30 12:11:14'),
(59, 16, 2, '2025-07-30 12:11:14', '2025-07-30 12:11:14'),
(60, 16, 3, '2025-07-30 12:11:14', '2025-07-30 12:11:14'),
(61, 17, 1, '2025-07-30 12:14:29', '2025-07-30 12:14:29'),
(62, 17, 2, '2025-07-30 12:14:29', '2025-07-30 12:14:29'),
(63, 17, 3, '2025-07-30 12:14:29', '2025-07-30 12:14:29'),
(130, 41, 1, '2025-09-26 11:48:14', '2025-09-26 11:48:14'),
(131, 41, 2, '2025-09-26 11:48:14', '2025-09-26 11:48:14'),
(132, 41, 3, '2025-09-26 11:48:14', '2025-09-26 11:48:14'),
(167, 2, 1, '2026-01-15 13:24:36', '2026-01-15 13:24:36'),
(168, 2, 2, '2026-01-15 13:24:36', '2026-01-15 13:24:36'),
(169, 2, 3, '2026-01-15 13:24:36', '2026-01-15 13:24:36'),
(176, 1, 1, '2026-01-15 13:37:44', '2026-01-15 13:37:44'),
(177, 1, 2, '2026-01-15 13:37:44', '2026-01-15 13:37:44'),
(178, 1, 3, '2026-01-15 13:37:44', '2026-01-15 13:37:44'),
(182, 3, 1, '2026-01-16 08:12:42', '2026-01-16 08:12:42'),
(183, 3, 2, '2026-01-16 08:12:42', '2026-01-16 08:12:42'),
(184, 3, 3, '2026-01-16 08:12:42', '2026-01-16 08:12:42'),
(185, 4, 1, '2026-01-16 08:33:34', '2026-01-16 08:33:34'),
(186, 4, 2, '2026-01-16 08:33:34', '2026-01-16 08:33:34'),
(187, 4, 3, '2026-01-16 08:33:34', '2026-01-16 08:33:34'),
(191, 5, 1, '2026-01-17 12:05:20', '2026-01-17 12:05:20'),
(192, 5, 2, '2026-01-17 12:05:20', '2026-01-17 12:05:20'),
(193, 5, 3, '2026-01-17 12:05:20', '2026-01-17 12:05:20'),
(194, 6, 1, '2026-01-17 12:07:01', '2026-01-17 12:07:01'),
(195, 6, 2, '2026-01-17 12:07:01', '2026-01-17 12:07:01'),
(196, 6, 3, '2026-01-17 12:07:01', '2026-01-17 12:07:01'),
(203, 7, 1, '2026-01-17 12:16:52', '2026-01-17 12:16:52'),
(204, 7, 2, '2026-01-17 12:16:52', '2026-01-17 12:16:52'),
(205, 7, 3, '2026-01-17 12:16:52', '2026-01-17 12:16:52'),
(206, 8, 1, '2026-01-17 12:18:03', '2026-01-17 12:18:03'),
(207, 8, 2, '2026-01-17 12:18:03', '2026-01-17 12:18:03'),
(208, 8, 3, '2026-01-17 12:18:03', '2026-01-17 12:18:03'),
(209, 9, 1, '2026-01-17 12:20:22', '2026-01-17 12:20:22'),
(210, 9, 2, '2026-01-17 12:20:22', '2026-01-17 12:20:22'),
(211, 9, 3, '2026-01-17 12:20:22', '2026-01-17 12:20:22'),
(215, 10, 1, '2026-01-17 12:23:25', '2026-01-17 12:23:25'),
(216, 10, 2, '2026-01-17 12:23:25', '2026-01-17 12:23:25'),
(217, 10, 3, '2026-01-17 12:23:25', '2026-01-17 12:23:25'),
(218, 11, 1, '2026-01-17 12:25:37', '2026-01-17 12:25:37'),
(219, 11, 2, '2026-01-17 12:25:37', '2026-01-17 12:25:37'),
(220, 11, 3, '2026-01-17 12:25:37', '2026-01-17 12:25:37'),
(221, 12, 1, '2026-01-17 12:31:51', '2026-01-17 12:31:51'),
(222, 12, 2, '2026-01-17 12:31:51', '2026-01-17 12:31:51'),
(223, 12, 3, '2026-01-17 12:31:51', '2026-01-17 12:31:51'),
(224, 13, 1, '2026-01-17 12:33:30', '2026-01-17 12:33:30'),
(225, 13, 2, '2026-01-17 12:33:30', '2026-01-17 12:33:30'),
(226, 13, 3, '2026-01-17 12:33:30', '2026-01-17 12:33:30'),
(227, 14, 1, '2026-01-17 12:35:10', '2026-01-17 12:35:10'),
(228, 14, 2, '2026-01-17 12:35:10', '2026-01-17 12:35:10'),
(229, 14, 3, '2026-01-17 12:35:10', '2026-01-17 12:35:10'),
(230, 15, 1, '2026-01-17 12:37:02', '2026-01-17 12:37:02'),
(231, 15, 2, '2026-01-17 12:37:02', '2026-01-17 12:37:02'),
(232, 15, 3, '2026-01-17 12:37:02', '2026-01-17 12:37:02'),
(233, 20, 1, '2026-01-17 12:44:55', '2026-01-17 12:44:55'),
(234, 20, 2, '2026-01-17 12:44:55', '2026-01-17 12:44:55'),
(235, 20, 3, '2026-01-17 12:44:55', '2026-01-17 12:44:55'),
(236, 21, 1, '2026-01-17 12:47:57', '2026-01-17 12:47:57'),
(237, 21, 2, '2026-01-17 12:47:57', '2026-01-17 12:47:57'),
(238, 21, 3, '2026-01-17 12:47:57', '2026-01-17 12:47:57'),
(239, 22, 1, '2026-01-17 12:50:10', '2026-01-17 12:50:10'),
(240, 22, 2, '2026-01-17 12:50:10', '2026-01-17 12:50:10'),
(241, 22, 3, '2026-01-17 12:50:10', '2026-01-17 12:50:10'),
(245, 23, 1, '2026-01-17 13:06:52', '2026-01-17 13:06:52'),
(246, 23, 2, '2026-01-17 13:06:52', '2026-01-17 13:06:52'),
(247, 23, 3, '2026-01-17 13:06:52', '2026-01-17 13:06:52'),
(251, 24, 1, '2026-01-17 13:20:25', '2026-01-17 13:20:25'),
(252, 24, 2, '2026-01-17 13:20:25', '2026-01-17 13:20:25'),
(253, 24, 3, '2026-01-17 13:20:25', '2026-01-17 13:20:25'),
(254, 25, 1, '2026-01-17 13:23:22', '2026-01-17 13:23:22'),
(255, 25, 2, '2026-01-17 13:23:22', '2026-01-17 13:23:22'),
(256, 25, 3, '2026-01-17 13:23:22', '2026-01-17 13:23:22'),
(260, 26, 1, '2026-01-17 13:27:16', '2026-01-17 13:27:16'),
(261, 26, 2, '2026-01-17 13:27:16', '2026-01-17 13:27:16'),
(262, 26, 3, '2026-01-17 13:27:16', '2026-01-17 13:27:16'),
(263, 27, 1, '2026-01-17 13:27:56', '2026-01-17 13:27:56'),
(264, 27, 2, '2026-01-17 13:27:56', '2026-01-17 13:27:56'),
(265, 27, 3, '2026-01-17 13:27:56', '2026-01-17 13:27:56'),
(266, 28, 1, '2026-01-17 13:29:30', '2026-01-17 13:29:30'),
(267, 28, 2, '2026-01-17 13:29:30', '2026-01-17 13:29:30'),
(268, 28, 3, '2026-01-17 13:29:30', '2026-01-17 13:29:30'),
(269, 29, 1, '2026-01-17 13:30:48', '2026-01-17 13:30:48'),
(270, 29, 2, '2026-01-17 13:30:48', '2026-01-17 13:30:48'),
(271, 29, 3, '2026-01-17 13:30:48', '2026-01-17 13:30:48'),
(272, 30, 1, '2026-01-17 13:33:13', '2026-01-17 13:33:13'),
(273, 30, 2, '2026-01-17 13:33:13', '2026-01-17 13:33:13'),
(274, 30, 3, '2026-01-17 13:33:13', '2026-01-17 13:33:13'),
(275, 31, 1, '2026-01-17 13:36:05', '2026-01-17 13:36:05'),
(276, 31, 2, '2026-01-17 13:36:05', '2026-01-17 13:36:05'),
(277, 31, 3, '2026-01-17 13:36:05', '2026-01-17 13:36:05'),
(278, 32, 1, '2026-01-17 13:37:41', '2026-01-17 13:37:41'),
(279, 32, 2, '2026-01-17 13:37:41', '2026-01-17 13:37:41'),
(280, 32, 3, '2026-01-17 13:37:41', '2026-01-17 13:37:41'),
(287, 19, 1, '2026-01-17 13:46:01', '2026-01-17 13:46:01'),
(288, 19, 2, '2026-01-17 13:46:01', '2026-01-17 13:46:01'),
(289, 19, 3, '2026-01-17 13:46:01', '2026-01-17 13:46:01'),
(291, 43, 1, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(292, 43, 2, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(293, 43, 3, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(294, 43, 4, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(295, 45, 5, '2026-01-19 13:01:54', '2026-01-19 13:01:54'),
(296, 44, 5, '2026-01-19 13:02:24', '2026-01-19 13:02:24'),
(297, 33, 1, '2026-01-28 03:18:12', '2026-01-28 03:18:12'),
(298, 33, 2, '2026-01-28 03:18:12', '2026-01-28 03:18:12'),
(299, 33, 3, '2026-01-28 03:18:12', '2026-01-28 03:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_images`
--

CREATE TABLE `product_sub_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sub_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sub_images`
--

INSERT INTO `product_sub_images` (`id`, `product_id`, `sub_image`, `created_at`, `updated_at`) VALUES
(1, 1, '202507261949DAI1.png', '2025-07-26 13:49:51', '2025-07-26 13:49:51'),
(2, 2, '202507262004DAI1.png', '2025-07-26 14:04:49', '2025-07-26 14:04:49'),
(3, 3, '20250728175860.jpg', '2025-07-28 11:58:21', '2025-07-28 11:58:21'),
(4, 3, '20250728175861.jpg', '2025-07-28 11:58:21', '2025-07-28 11:58:21'),
(5, 4, '20250728180672.jpg', '2025-07-28 12:06:35', '2025-07-28 12:06:35'),
(6, 5, '20250728182152.jpg', '2025-07-28 12:21:42', '2025-07-28 12:21:42'),
(7, 6, '20250728182553.jpg', '2025-07-28 12:25:08', '2025-07-28 12:25:08'),
(8, 7, '20250728182855.jpg', '2025-07-28 12:28:13', '2025-07-28 12:28:13'),
(9, 8, '20250728183256.jpg', '2025-07-28 12:32:01', '2025-07-28 12:32:01'),
(10, 9, '20250728183457.jpg', '2025-07-28 12:34:11', '2025-07-28 12:34:11'),
(11, 10, '20250728183658.jpg', '2025-07-28 12:36:26', '2025-07-28 12:36:26'),
(12, 11, '202507281839u0051.jpg', '2025-07-28 12:39:13', '2025-07-28 12:39:13'),
(13, 12, '202507301754p2.jpg', '2025-07-30 11:54:13', '2025-07-30 11:54:13'),
(14, 12, '202507301754p3.jpg', '2025-07-30 11:54:13', '2025-07-30 11:54:13'),
(15, 12, '202507301754p4.jpg', '2025-07-30 11:54:13', '2025-07-30 11:54:13'),
(16, 13, '202507301759p2.jpg', '2025-07-30 11:59:35', '2025-07-30 11:59:35'),
(17, 13, '202507301759p3.jpg', '2025-07-30 11:59:35', '2025-07-30 11:59:35'),
(18, 13, '202507301759p4.jpg', '2025-07-30 11:59:35', '2025-07-30 11:59:35'),
(19, 14, '202507301804p2.jpg', '2025-07-30 12:04:08', '2025-07-30 12:04:08'),
(20, 14, '202507301804p3.jpg', '2025-07-30 12:04:08', '2025-07-30 12:04:08'),
(21, 14, '202507301804p4.jpg', '2025-07-30 12:04:08', '2025-07-30 12:04:08'),
(22, 15, '202507301808p10.jpg', '2025-07-30 12:08:32', '2025-07-30 12:08:32'),
(23, 15, '202507301808p11.jpg', '2025-07-30 12:08:32', '2025-07-30 12:08:32'),
(24, 15, '202507301808p12.jpg', '2025-07-30 12:08:32', '2025-07-30 12:08:32'),
(25, 16, '202507301811p12.jpg', '2025-07-30 12:11:14', '2025-07-30 12:11:14'),
(26, 17, '202507301814p12.jpg', '2025-07-30 12:14:29', '2025-07-30 12:14:29'),
(33, 19, '202508011140U012.jpg', '2025-08-01 05:40:26', '2025-08-01 05:40:26'),
(34, 20, '202508012153U001.jpg', '2025-08-01 15:53:54', '2025-08-01 15:53:54'),
(35, 21, '202508012157U002.jpg', '2025-08-01 15:57:33', '2025-08-01 15:57:33'),
(36, 22, '202508012201U003.jpg', '2025-08-01 16:01:32', '2025-08-01 16:01:32'),
(37, 23, '202508012205U004.jpg', '2025-08-01 16:05:06', '2025-08-01 16:05:06'),
(38, 24, '202508012208U005.jpg', '2025-08-01 16:08:12', '2025-08-01 16:08:12'),
(39, 25, '202508012213U006.jpg', '2025-08-01 16:13:07', '2025-08-01 16:13:07'),
(40, 26, '202508021356U007.jpg', '2025-08-02 07:56:06', '2025-08-02 07:56:06'),
(42, 27, '202508021414U008.jpg', '2025-08-02 08:14:17', '2025-08-02 08:14:17'),
(43, 28, '202508021419U009.jpg', '2025-08-02 08:19:41', '2025-08-02 08:19:41'),
(44, 29, '202508021422U010.jpg', '2025-08-02 08:22:07', '2025-08-02 08:22:07'),
(45, 30, '202508021424U011.jpg', '2025-08-02 08:24:17', '2025-08-02 08:24:17'),
(46, 31, '202508021426U012.jpg', '2025-08-02 08:26:58', '2025-08-02 08:26:58'),
(47, 32, '202508021429db2f5041-5f28-4d31-91f0-638d620dd9d8.png', '2025-08-02 08:29:37', '2025-08-02 08:29:37'),
(48, 33, '202508021431new ai.png', '2025-08-02 08:31:50', '2025-08-02 08:31:50'),
(56, 41, '20250926174254.jpg', '2025-09-26 11:42:52', '2025-09-26 11:42:52'),
(58, 43, '20251122101654.jpg', '2025-11-22 04:16:37', '2025-11-22 04:16:37'),
(59, 43, '20251122101655.jpg', '2025-11-22 04:16:37', '2025-11-22 04:16:37'),
(60, 43, '20251122101656.jpg', '2025-11-22 04:16:37', '2025-11-22 04:16:37'),
(61, 43, '20251122101657.jpg', '2025-11-22 04:16:37', '2025-11-22 04:16:37'),
(62, 44, '202601182002usupershop1.jpg', '2026-01-18 14:02:43', '2026-01-18 14:02:43'),
(63, 45, '202601191901usupershop2.jpg', '2026-01-19 13:01:54', '2026-01-19 13:01:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `size_id` bigint(20) UNSIGNED NOT NULL,
  `additional_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `color_id`, `size_id`, `additional_price`, `stock_quantity`, `sku`, `status`, `created_at`, `updated_at`) VALUES
(3, 41, 3, 1, 10.00, 5, NULL, 1, '2025-09-26 11:42:52', '2025-09-26 11:42:52'),
(4, 41, 3, 2, 20.00, 6, NULL, 1, '2025-09-26 11:42:52', '2025-09-26 11:42:52'),
(5, 41, 3, 3, 30.00, 7, NULL, 1, '2025-09-26 11:42:52', '2025-09-26 11:42:52'),
(40, 2, 1, 1, 0.00, 50, 'U0002', 1, '2026-01-15 13:24:36', '2026-01-15 13:24:36'),
(41, 2, 1, 2, 0.00, 50, 'U0002', 1, '2026-01-15 13:24:36', '2026-01-15 13:24:36'),
(42, 2, 1, 3, 0.00, 50, 'U0002', 1, '2026-01-15 13:24:36', '2026-01-15 13:24:36'),
(49, 1, 1, 1, 0.00, 50, 'U0001', 1, '2026-01-15 13:37:44', '2026-01-15 13:37:44'),
(50, 1, 1, 2, 0.00, 50, 'U0001', 1, '2026-01-15 13:37:44', '2026-01-15 13:37:44'),
(51, 1, 1, 3, 0.00, 50, 'U0001', 1, '2026-01-15 13:37:44', '2026-01-15 13:37:44'),
(55, 3, 1, 1, 0.00, 0, '50', 1, '2026-01-16 08:12:42', '2026-01-16 08:12:42'),
(56, 3, 1, 2, 0.00, 0, '50', 1, '2026-01-16 08:12:42', '2026-01-16 08:12:42'),
(57, 3, 1, 3, 0.00, 0, '50', 1, '2026-01-16 08:12:42', '2026-01-16 08:12:42'),
(58, 4, 1, 1, 0.00, 0, NULL, 1, '2026-01-16 08:33:34', '2026-01-16 08:33:34'),
(59, 4, 1, 2, 0.00, 0, NULL, 1, '2026-01-16 08:33:34', '2026-01-16 08:33:34'),
(60, 4, 1, 3, 0.00, 0, NULL, 1, '2026-01-16 08:33:34', '2026-01-16 08:33:34'),
(64, 5, 1, 1, 0.00, 3, 'U0005', 1, '2026-01-17 12:05:20', '2026-01-17 12:05:20'),
(65, 5, 1, 2, 0.00, 3, 'U0005', 1, '2026-01-17 12:05:20', '2026-01-17 12:05:20'),
(66, 5, 1, 3, 0.00, 3, 'U0005', 1, '2026-01-17 12:05:20', '2026-01-17 12:05:20'),
(67, 6, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 12:07:01', '2026-01-17 12:07:01'),
(68, 6, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 12:07:01', '2026-01-17 12:07:01'),
(69, 6, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 12:07:01', '2026-01-17 12:07:01'),
(76, 7, 1, 1, 0.00, 0, 'U0007', 1, '2026-01-17 12:16:52', '2026-01-17 12:16:52'),
(77, 7, 1, 2, 0.00, 0, 'U0007', 1, '2026-01-17 12:16:52', '2026-01-17 12:16:52'),
(78, 7, 1, 3, 0.00, 0, 'U0007', 1, '2026-01-17 12:16:52', '2026-01-17 12:16:52'),
(79, 8, 1, 1, 0.00, 50, 'U0008', 1, '2026-01-17 12:18:03', '2026-01-17 12:18:03'),
(80, 8, 1, 2, 0.00, 50, 'U0008', 1, '2026-01-17 12:18:03', '2026-01-17 12:18:03'),
(81, 8, 1, 3, 0.00, 50, 'U0008', 1, '2026-01-17 12:18:03', '2026-01-17 12:18:03'),
(82, 9, 1, 1, 0.00, 0, 'U0009', 1, '2026-01-17 12:20:22', '2026-01-17 12:20:22'),
(83, 9, 1, 2, 0.00, 0, 'U0009', 1, '2026-01-17 12:20:22', '2026-01-17 12:20:22'),
(84, 9, 1, 3, 0.00, 0, 'U0009', 1, '2026-01-17 12:20:22', '2026-01-17 12:20:22'),
(88, 10, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 12:23:25', '2026-01-17 12:23:25'),
(89, 10, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 12:23:25', '2026-01-17 12:23:25'),
(90, 10, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 12:23:25', '2026-01-17 12:23:25'),
(91, 11, 1, 1, 0.00, 0, '554544', 1, '2026-01-17 12:25:37', '2026-01-17 12:25:37'),
(92, 11, 1, 2, 0.00, 0, '31120542', 1, '2026-01-17 12:25:37', '2026-01-17 12:25:37'),
(93, 11, 1, 3, 0.00, 0, '3613', 1, '2026-01-17 12:25:37', '2026-01-17 12:25:37'),
(94, 12, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 12:31:51', '2026-01-17 12:31:51'),
(95, 12, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 12:31:51', '2026-01-17 12:31:51'),
(96, 12, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 12:31:51', '2026-01-17 12:31:51'),
(97, 13, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 12:33:30', '2026-01-17 12:33:30'),
(98, 13, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 12:33:30', '2026-01-17 12:33:30'),
(99, 13, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 12:33:30', '2026-01-17 12:33:30'),
(100, 14, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 12:35:10', '2026-01-17 12:35:10'),
(101, 14, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 12:35:10', '2026-01-17 12:35:10'),
(102, 14, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 12:35:10', '2026-01-17 12:35:10'),
(103, 15, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 12:37:02', '2026-01-17 12:37:02'),
(104, 15, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 12:37:02', '2026-01-17 12:37:02'),
(105, 15, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 12:37:02', '2026-01-17 12:37:02'),
(106, 20, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 12:44:55', '2026-01-17 12:44:55'),
(107, 20, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 12:44:55', '2026-01-17 12:44:55'),
(108, 20, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 12:44:55', '2026-01-17 12:44:55'),
(109, 21, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 12:47:57', '2026-01-17 12:47:57'),
(110, 21, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 12:47:57', '2026-01-17 12:47:57'),
(111, 21, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 12:47:57', '2026-01-17 12:47:57'),
(112, 22, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 12:50:10', '2026-01-17 12:50:10'),
(113, 22, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 12:50:10', '2026-01-17 12:50:10'),
(114, 22, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 12:50:10', '2026-01-17 12:50:10'),
(118, 23, 1, 1, 0.00, 0, '1689419', 1, '2026-01-17 13:06:52', '2026-01-17 13:06:52'),
(119, 23, 1, 2, 0.00, 0, '48166', 1, '2026-01-17 13:06:52', '2026-01-17 13:06:52'),
(120, 23, 1, 3, 0.00, 0, '684468787', 1, '2026-01-17 13:06:52', '2026-01-17 13:06:52'),
(124, 24, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 13:20:25', '2026-01-17 13:20:25'),
(125, 24, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 13:20:25', '2026-01-17 13:20:25'),
(126, 24, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 13:20:25', '2026-01-17 13:20:25'),
(127, 25, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 13:23:22', '2026-01-17 13:23:22'),
(128, 25, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 13:23:22', '2026-01-17 13:23:22'),
(129, 25, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 13:23:22', '2026-01-17 13:23:22'),
(133, 26, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 13:27:16', '2026-01-17 13:27:16'),
(134, 26, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 13:27:16', '2026-01-17 13:27:16'),
(135, 26, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 13:27:16', '2026-01-17 13:27:16'),
(136, 27, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 13:27:56', '2026-01-17 13:27:56'),
(137, 27, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 13:27:56', '2026-01-17 13:27:56'),
(138, 27, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 13:27:56', '2026-01-17 13:27:56'),
(139, 28, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 13:29:30', '2026-01-17 13:29:30'),
(140, 28, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 13:29:30', '2026-01-17 13:29:30'),
(141, 28, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 13:29:30', '2026-01-17 13:29:30'),
(142, 29, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 13:30:48', '2026-01-17 13:30:48'),
(143, 29, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 13:30:48', '2026-01-17 13:30:48'),
(144, 29, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 13:30:48', '2026-01-17 13:30:48'),
(145, 30, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 13:33:13', '2026-01-17 13:33:13'),
(146, 30, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 13:33:13', '2026-01-17 13:33:13'),
(147, 30, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 13:33:13', '2026-01-17 13:33:13'),
(148, 31, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 13:36:05', '2026-01-17 13:36:05'),
(149, 31, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 13:36:05', '2026-01-17 13:36:05'),
(150, 31, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 13:36:05', '2026-01-17 13:36:05'),
(151, 32, 1, 1, 0.00, 0, NULL, 1, '2026-01-17 13:37:41', '2026-01-17 13:37:41'),
(152, 32, 1, 2, 0.00, 0, NULL, 1, '2026-01-17 13:37:41', '2026-01-17 13:37:41'),
(153, 32, 1, 3, 0.00, 0, NULL, 1, '2026-01-17 13:37:41', '2026-01-17 13:37:41'),
(160, 19, 2, 1, 0.00, 0, NULL, 1, '2026-01-17 13:46:01', '2026-01-17 13:46:01'),
(161, 19, 2, 2, 0.00, 0, NULL, 1, '2026-01-17 13:46:01', '2026-01-17 13:46:01'),
(162, 19, 2, 3, 0.00, 0, NULL, 1, '2026-01-17 13:46:01', '2026-01-17 13:46:01'),
(164, 43, 2, 1, 20.00, 10, NULL, 1, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(165, 43, 2, 2, 30.00, 5, NULL, 1, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(166, 43, 3, 3, 50.00, 100, NULL, 1, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(167, 43, 3, 4, 10.00, 66, NULL, 1, '2026-01-19 12:29:08', '2026-01-19 12:29:08'),
(168, 45, 15, 5, 0.00, 50, 'u0052', 1, '2026-01-19 13:01:54', '2026-01-19 13:01:54'),
(169, 44, 15, 5, 0.00, 0, NULL, 1, '2026-01-19 13:02:24', '2026-01-19 13:02:24'),
(170, 33, 1, 1, 0.00, 0, NULL, 1, '2026-01-28 03:18:12', '2026-01-28 03:18:12'),
(171, 33, 1, 2, 0.00, 0, NULL, 1, '2026-01-28 03:18:12', '2026-01-28 03:18:12'),
(172, 33, 1, 3, 0.00, 0, NULL, 1, '2026-01-28 03:18:12', '2026-01-28 03:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `profile_verifies`
--

CREATE TABLE `profile_verifies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nid_no` varchar(255) DEFAULT NULL,
  `birthdate` varchar(255) NOT NULL,
  `front_image` varchar(255) DEFAULT NULL,
  `back_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile_verifies`
--

INSERT INTO `profile_verifies` (`id`, `user_id`, `nid_no`, `birthdate`, `front_image`, `back_image`, `created_at`, `updated_at`) VALUES
(1, 4, '5412549542', '1997-11-11', '202508011142_U004.jpg', '202508011142_U006.jpg', '2025-08-01 05:42:38', '2025-08-01 05:42:38'),
(2, 6, '1234567890', '1995-12-12', '202508071530_tttttttttttttttttttttt.png', '202508071530_Erorr.png', '2025-08-07 09:30:19', '2025-08-07 09:30:19'),
(3, 11, '1502240227', '1996-12-28', '202508072018_IMG_20250807_220629.jpg', '202508072018_IMG_20250807_220703.jpg', '2025-08-07 14:18:54', '2025-08-07 14:18:54'),
(4, 10, '12334974', '2025-09-08', '202509071019_download.png', '202509071019_download.png', '2025-09-07 04:19:15', '2025-09-07 04:19:15'),
(5, 18, '58945', '2025-09-08', '202509081140_download.png', '202509081140_download.png', '2025-09-08 05:40:26', '2025-09-08 05:40:26'),
(6, 16, '5894545', '2025-10-22', '202510170044_2.png', '202510170044_24.png', '2025-10-16 18:44:28', '2025-10-16 18:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice`
--

CREATE TABLE `purchase_invoice` (
  `id` int(10) UNSIGNED NOT NULL,
  `invnumber` varchar(15) NOT NULL,
  `purdate` date NOT NULL,
  `supplier` int(11) NOT NULL,
  `supplier_inv` varchar(15) DEFAULT NULL,
  `vat_amount` varchar(10) NOT NULL,
  `total_without_vat` varchar(10) NOT NULL,
  `subtotal` varchar(10) NOT NULL,
  `transport` varchar(10) NOT NULL,
  `discount` varchar(10) NOT NULL,
  `grandtotal` varchar(10) NOT NULL,
  `pamount` varchar(10) NOT NULL,
  `damount` varchar(10) NOT NULL,
  `pay_by` varchar(5) NOT NULL,
  `notes` varchar(100) NOT NULL,
  `added_by` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `purchase_invoice`
--

INSERT INTO `purchase_invoice` (`id`, `invnumber`, `purdate`, `supplier`, `supplier_inv`, `vat_amount`, `total_without_vat`, `subtotal`, `transport`, `discount`, `grandtotal`, `pamount`, `damount`, `pay_by`, `notes`, `added_by`) VALUES
(1, '2022-11-19001', '2022-11-19', 1, '121234532', '0', '57850', '57850', '0', '0', '57850', '50000', '7850', 'Cash', '', 'admin'),
(2, '2022-11-19002', '2022-11-19', 1, 'as0987654321', '0', '2315', '2315', '0', '0', '2315', '2315', '0', 'Cash', '', 'admin'),
(3, '202211190001', '2022-11-19', 1, 'as0987654322', '0', '850', '850', '0', '0', '850', '850', '0', 'Cash', '', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_item`
--

CREATE TABLE `purchase_invoice_item` (
  `id` int(11) NOT NULL,
  `ref` varchar(15) NOT NULL,
  `p_date` date DEFAULT NULL,
  `supplier` varchar(12) DEFAULT NULL,
  `product` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `quantity` double NOT NULL,
  `rate` decimal(12,2) NOT NULL,
  `vat` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `purchase_invoice_item`
--

INSERT INTO `purchase_invoice_item` (`id`, `ref`, `p_date`, `supplier`, `product`, `unit`, `quantity`, `rate`, `vat`, `total`) VALUES
(1, '2022-11-19001', '2022-11-19', '1', 13, '', 21, 350.00, 0.00, 7350.00),
(2, '2022-11-19001', '2022-11-19', '1', 1, '', 20, 1300.00, 0.00, 26000.00),
(3, '2022-11-19001', '2022-11-19', '1', 11, '', 50, 490.00, 0.00, 24500.00),
(4, '2022-11-19002', '2022-11-19', '1', 11, '', 4, 490.00, 0.00, 1960.00),
(5, '2022-11-19002', '2022-11-19', '1', 1, 'Pcs', 5, 1.00, 0.00, 5.00),
(6, '2022-11-19002', '2022-11-19', '1', 35, '', 1, 350.00, 0.00, 350.00),
(7, '202211190001', '2022-11-19', '1', 155, '', 1, 370.00, 0.00, 370.00),
(8, '202211190001', '2022-11-19', '1', 110, '', 1, 480.00, 0.00, 480.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_invoice`
--

CREATE TABLE `purchase_return_invoice` (
  `id` int(10) UNSIGNED NOT NULL,
  `invnumber` varchar(15) NOT NULL,
  `purdate` date NOT NULL,
  `supplier` int(11) NOT NULL,
  `grandtotal` varchar(10) NOT NULL,
  `notes` varchar(100) NOT NULL,
  `added_by` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_invoice_item`
--

CREATE TABLE `purchase_return_invoice_item` (
  `id` int(11) NOT NULL,
  `ref` varchar(15) NOT NULL,
  `p_date` date DEFAULT NULL,
  `supplier` varchar(12) DEFAULT NULL,
  `product` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `quantity` varchar(10) NOT NULL,
  `rate` varchar(10) NOT NULL,
  `total` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return`
--

CREATE TABLE `sales_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice` varchar(45) NOT NULL,
  `return_date` date NOT NULL,
  `cus_type` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `customer_id` varchar(45) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `name` varchar(45) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL,
  `sales_man` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_items`
--

CREATE TABLE `sales_return_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_no` varchar(45) NOT NULL,
  `pr_code` varchar(20) NOT NULL,
  `desc` varchar(45) NOT NULL,
  `qty` double NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(12,2) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `seller_emails`
--

CREATE TABLE `seller_emails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_email` varchar(255) DEFAULT NULL,
  `seller_mobile` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_emails`
--

INSERT INTO `seller_emails` (`id`, `seller_email`, `seller_mobile`, `code`, `created_at`, `updated_at`) VALUES
(1, 'rafi@usupershop.com', NULL, 'J7LKBYBL', '2025-07-26 10:53:29', '2025-07-26 10:53:29'),
(2, 'rafi123@gmail.com', NULL, 'GBYTPEG9', '2025-07-29 13:17:46', '2025-07-29 13:17:46'),
(3, '01719142015mhbbmst@gmail.com', NULL, 'EGBT7IR1', '2025-07-31 12:57:11', '2025-07-31 12:57:11'),
(4, 'rafigggg@gmail.com', NULL, 'KMXQ7LFS', '2025-08-01 07:45:50', '2025-08-01 07:45:50'),
(5, 'z.ill.ur.78489@gmail.com', NULL, 'KO8KXDMT', '2025-08-04 00:19:38', '2025-08-04 00:19:38'),
(6, 'all@gmail.com', NULL, '20FPD0AH', '2025-08-06 22:36:14', '2025-08-06 22:36:14'),
(7, 'allahu@gmail.com', NULL, 'EPJ9WSMM', '2025-08-06 22:52:38', '2025-08-06 22:52:38'),
(8, 'sele@gmail.com', NULL, 'X0SWN6TA', '2025-08-07 09:25:30', '2025-08-07 09:25:30'),
(9, 'mhin@gmail.com', NULL, 'CBGWBB19', '2025-08-07 14:04:54', '2025-08-07 14:04:54'),
(10, 'ra4444fi@gmail.com', NULL, '88V4YU3K', '2025-08-13 10:04:28', '2025-08-13 10:04:28'),
(11, 'rafi5555@gmail.com', NULL, 'MPHAVUC3', '2025-08-13 10:06:45', '2025-08-13 10:06:45'),
(12, 'masummx3@gmail.com', NULL, 'BMMTNHTW', '2025-09-03 09:01:51', '2025-11-04 18:26:48'),
(13, 'masum@gmail.com', NULL, 'KSVPMWU7', '2025-09-08 03:08:28', '2025-09-08 03:08:28'),
(14, 'masumtelecomand@gmail.com', NULL, 'YPNXILED', '2025-09-08 03:12:56', '2025-09-08 03:12:56'),
(15, 'dropshipper@gmail.com', NULL, 'YMIMK3NM', '2025-11-01 22:23:02', '2025-11-01 22:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `seller_fees`
--

CREATE TABLE `seller_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_type_of_myshop` varchar(255) DEFAULT NULL,
  `subscription_fees` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_fees`
--

INSERT INTO `seller_fees` (`id`, `account_type_of_myshop`, `subscription_fees`, `created_at`, `updated_at`) VALUES
(1, 'Seller', 200.00, '2025-01-14 04:27:20', '2026-04-12 10:20:51'),
(3, 'Vendor', 300.00, '2025-01-14 04:29:33', '2026-04-12 10:20:39'),
(5, 'Dropshiper', 500.00, '2025-08-14 10:31:33', '2026-04-12 10:20:18');

-- --------------------------------------------------------

--
-- Table structure for table `seller_payments`
--

CREATE TABLE `seller_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `app_name` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `refer_commission_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = flat, 1 = percentage',
  `refer_commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `app_name`, `keywords`, `description`, `refer_commission_type`, `refer_commission`, `created_at`, `updated_at`) VALUES
(1, 'usupershop.com', 'usupershop.com', 'usupershop.com', 1, 200.00, '2025-04-04 23:15:40', '2025-08-07 13:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'user_id = customer_id',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shippings`
--

INSERT INTO `shippings` (`id`, `user_id`, `name`, `email`, `mobile`, `address`, `created_at`, `updated_at`) VALUES
(1, 5, 'Rafi Islam', 'rafi@gmail.com', '01816622128', 'Dhaka Bangladesh', '2025-08-01 05:53:14', '2025-08-01 05:53:14'),
(2, 5, 'Rafi Islam Alamgir', 'rafi@gmail.com', '01816622128', 'Dhaka Bangladesh', '2025-08-08 12:19:40', '2025-08-08 12:19:40'),
(3, 15, 'MD Masum Rana', 'masummx3@gmail.com', '01799593940', 'Gangni\nMeherpur', '2025-08-25 10:05:51', '2025-08-25 10:05:51'),
(9, 18, 'MD Masum Rana', NULL, '01799593940', 'Gangni\r\nMeherpur', '2025-09-19 18:23:44', '2025-09-19 18:23:44'),
(10, 18, 'MD Masum Rana', NULL, '01799593940', 'Gangni\r\nMeherpur', '2025-09-19 18:28:16', '2025-09-19 18:28:16'),
(11, 18, 'Programming Banner', NULL, '01719333823', 'daa', '2025-09-19 18:47:10', '2025-09-19 18:47:10'),
(12, 18, 'Programming Banner', NULL, '01719333823', 'okl', '2025-09-19 18:52:04', '2025-09-19 18:52:04'),
(13, 18, 'Mr', NULL, '01816622120', 'Bangladesh', '2025-10-01 00:58:36', '2025-10-01 00:58:36'),
(14, 18, 'MD Masum Rana', NULL, '01799593940', 'Gangni\r\nMeherpur', '2025-10-07 19:03:33', '2025-10-07 19:03:33'),
(15, 23, 'MD Masum Rana', NULL, '01799593940', 'Gangni\r\nMeherpur', '2025-11-01 22:54:33', '2025-11-01 22:54:33'),
(16, 24, 'Programming Banner', NULL, '01719333823', 'as', '2025-11-04 18:37:30', '2025-11-04 18:37:30'),
(17, 25, 'MD AL MAMUN', NULL, '01670122630', 'Kawran Bazar', '2025-11-05 04:45:10', '2025-11-05 04:45:10'),
(18, 24, 'MD Masum Rana', NULL, '01799593940', 'Gangni\r\nMeherpur', '2025-11-05 19:39:30', '2025-11-05 19:39:30'),
(19, 6, 'rafi islam', NULL, '01816622128', 'dhaka', '2025-11-22 03:47:13', '2025-11-22 03:47:13'),
(20, 6, 'rafi', NULL, '01816622128', 'dhaka', '2025-11-22 03:55:35', '2025-11-22 03:55:35'),
(21, 6, 'rafi', NULL, '01816622128', 'gfffffffffffffffffffffffffff', '2025-11-22 04:26:30', '2025-11-22 04:26:30'),
(58, 25, 'MD AL MAMUN', 'customer@gmail.com', '01842299275', 'Chandrima 6 No rod ,Chadgong,chittagong', '2026-01-31 02:59:32', '2026-01-31 02:59:32'),
(59, 6, 'MD AL MAMUN', 'customer@gmail.com', '01842299275', 'Chandrima 6 No rod ,Chadgong,chittagong', '2026-02-03 01:30:36', '2026-02-03 01:30:36'),
(60, 6, 'Imamul Ahasan', 'imam@gmail.com', '01842299275', 'kotowali,chittagong', '2026-02-03 01:58:05', '2026-02-03 01:58:05'),
(61, 25, 'MD AL MAMUN', 'customer@gmail.com', '01670122630', 'Chandrima 6 No rod ,Chadgong,chittagong', '2026-02-03 02:00:23', '2026-02-03 02:00:23'),
(62, 25, 'MD AL MAMUN', 'customer@gmail.com', '01670122630', 'Chandrima 6 No rod ,Chadgong,chittagong', '2026-02-03 02:05:33', '2026-02-03 02:05:33'),
(63, 25, 'MD AL MAMUN', 'customer@gmail.com', '01670122630', 'Chandrima 6 No rod ,Chadgong,chittagong', '2026-02-03 02:11:45', '2026-02-03 02:11:45'),
(64, 25, 'MD AL MAMUN', 'customer@gmail.com', '01670122630', 'Chandrima 6 No rod ,Chadgong,chittagong', '2026-02-03 02:13:30', '2026-02-03 02:13:30'),
(65, 25, 'MD AL MAMUN', 'customer@gmail.com', '01670122630', 'Chandrima 6 No rod ,Chadgong,chittagong', '2026-02-03 02:15:27', '2026-02-03 02:15:27'),
(66, 25, 'Abdullah Sayed', 'sayed121@gmail.com', '01842299275', 'Chandrima 6 No rod ,Chadgong,chittagong', '2026-02-07 00:49:43', '2026-02-07 00:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'L', 1, NULL, '2025-07-26 13:35:23', '2025-07-26 13:35:23'),
(2, 'M', 1, NULL, '2025-07-26 13:35:42', '2025-07-26 13:35:42'),
(3, 'XL', 1, NULL, '2025-07-26 13:36:03', '2025-07-26 13:36:03'),
(4, 'One Size', 1, NULL, '2025-07-29 07:51:51', '2025-07-29 07:51:51'),
(5, 'NO SIZE', 1, NULL, '2026-01-18 13:46:08', '2026-01-18 13:46:08');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `name`, `image`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Slider image 01', '202411201548slide4.jpg', 1, 1, '2022-09-06 23:38:43', '2024-11-20 09:48:12'),
(2, 'Slider Image 02', '202411201547slide3.jpg', 1, 1, '2023-01-17 07:16:10', '2024-11-20 09:47:59'),
(3, 'Slider Image 03', '202411201547slide2.jpg', 1, 1, '2024-11-19 22:20:45', '2024-11-20 09:47:46'),
(4, 'https://youtube.com/@usupershop?feature=shared', '202411201549slide1.jpg', 1, 1, '2024-11-19 22:21:02', '2024-11-28 12:30:55'),
(20, 'নতুন পণ্য', '202505040445202505032027Picsart_25-05-03_23-14-57-788 (1).jpg', 1, 1, '2025-05-03 14:27:46', '2025-05-03 22:45:15'),
(21, 'Test', '202505051156Picsart_25-05-05_14-45-49-835.jpg', 1, 1, '2025-05-03 22:40:53', '2025-05-05 05:56:52'),
(22, 'Test 1280x487', '202505040451202505032027Picsart_25-05-03_23-14-57-788 (1).jpg', 1, 1, '2025-05-03 22:41:41', '2025-05-03 22:51:01'),
(24, 'Test 6', '202505070823Picsart_25-05-07_11-14-06-782.jpg', 1, NULL, '2025-05-07 02:23:11', '2025-05-07 02:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `apiKey` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `SenderName` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms`
--

INSERT INTO `sms` (`id`, `apiKey`, `userName`, `SenderName`, `created_at`, `updated_at`) VALUES
(1, 'EB07K15Y5CIRORIERU82P1NB9', 'mrabdou100012@gmail.com', 'U SuperShop', '2025-04-08 00:17:48', '2025-04-08 22:24:58');

-- --------------------------------------------------------

--
-- Table structure for table `staff_info`
--

CREATE TABLE `staff_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `staff_id` varchar(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  `mobile` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `added_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `staff_info`
--

INSERT INTO `staff_info` (`id`, `staff_id`, `name`, `mobile`, `email`, `address`, `added_time`) VALUES
(1, 'E0001', 'Torikul Islam', '0188276897667', '', 'TEE', '2022-11-19 20:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcat_slug` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(1000) DEFAULT NULL,
  `meta_description` varchar(2000) DEFAULT NULL,
  `meta_keywords` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`, `subcat_slug`, `created_by`, `updated_by`, `created_at`, `updated_at`, `meta_title`, `meta_description`, `meta_keywords`) VALUES
(1, 't-shirt', 1, 't-shirt', 1, NULL, '2025-07-26 13:41:45', '2025-07-26 13:41:45', NULL, NULL, NULL),
(2, 'shirt', 2, 'shirt', 1, NULL, '2025-07-27 13:04:11', '2025-07-27 13:04:11', NULL, NULL, NULL),
(3, 'panjabi', 3, 'panjabi', 1, NULL, '2025-07-27 13:04:46', '2025-07-27 13:04:46', NULL, NULL, NULL),
(4, 'Gift', 4, 'gift', 1, NULL, '2025-07-27 13:05:11', '2025-07-27 13:05:11', NULL, NULL, NULL),
(5, 'U SUPER SHOP', 5, 'u-super-shop', 1, NULL, '2025-07-27 13:05:52', '2025-07-27 13:05:52', NULL, NULL, NULL),
(6, 'jewellery', 15, 'jewellery', 1, NULL, '2025-07-29 13:00:53', '2025-07-29 13:00:53', NULL, NULL, NULL),
(7, 'three piece', 14, 'three-piece', 1, NULL, '2025-07-29 13:01:47', '2025-07-29 13:01:47', NULL, NULL, NULL),
(8, 'personal care', 9, 'personal-care', 1, NULL, '2025-07-29 13:02:37', '2025-07-29 13:02:37', NULL, NULL, NULL),
(9, 'new fashion', 16, 'new-fashion', 1, NULL, '2025-07-29 13:04:46', '2025-07-29 13:04:46', NULL, NULL, NULL),
(10, 'saree', 17, 'saree', 1, NULL, '2025-07-30 22:44:17', '2025-07-30 22:44:17', NULL, NULL, NULL),
(11, 'good shoes', 18, 'good-shoes', 1, NULL, '2025-08-03 10:19:22', '2025-08-03 10:19:22', NULL, NULL, NULL),
(12, 'Sandal shoes', 19, 'sandal-shoes', 1, NULL, '2025-08-03 12:17:52', '2025-08-03 12:17:52', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscription_fees`
--

CREATE TABLE `subscription_fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `referral_no` varchar(255) NOT NULL,
  `seller_type` varchar(255) NOT NULL,
  `transction_mode` varchar(255) DEFAULT NULL,
  `subscription_fee` varchar(255) DEFAULT NULL,
  `transsaction_no` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT 'unpaid=0, paid=1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_fees`
--

INSERT INTO `subscription_fees` (`id`, `seller_id`, `referral_no`, `seller_type`, `transction_mode`, `subscription_fee`, `transsaction_no`, `status`, `created_at`, `updated_at`, `date`) VALUES
(1, 2, '5331631', 'General Vendor', 'Bkash', '2.00', NULL, 1, '2025-07-27 02:28:28', '2025-07-27 02:29:20', '1753604960'),
(2, 3, '2542252', 'General Seller', 'Bkash', '1.00', NULL, 1, '2025-07-29 13:18:40', '2025-07-29 13:19:38', '1753816778'),
(3, 4, '9527367', 'General Vendor', 'Bkash', '2.00', NULL, 1, '2025-07-31 12:59:58', '2025-07-31 13:01:01', '1753988461'),
(4, 6, '5346855', 'General Seller', 'Bkash', '1.00', NULL, 1, '2025-08-01 07:46:46', '2025-08-01 07:47:43', '1754056063'),
(5, 7, '1950856', 'General Vendor', 'Bkash', '2.00', NULL, 0, '2025-08-04 00:20:44', '2025-08-04 00:20:44', '1754288444'),
(6, 7, '5218229', 'General Vendor', 'Bkash', '2.00', NULL, 0, '2025-08-04 00:21:22', '2025-08-04 00:21:22', '1754288482'),
(7, 7, '1989983', 'General Vendor', 'Bkash', '2.00', NULL, 0, '2025-08-04 00:22:05', '2025-08-04 00:22:05', '1754288525'),
(8, 7, '2007353', 'General Vendor', 'Bkash', '2.00', NULL, 1, '2025-08-04 00:23:02', '2025-08-04 00:23:38', '1754288618'),
(9, 10, '2962656', 'General Vendor', 'Bkash', '2.00', NULL, 1, '2025-08-07 09:27:18', '2025-08-07 09:28:22', '1754580502'),
(10, 11, '5536914', 'General Seller', 'Bkash', '1.00', NULL, 1, '2025-08-07 14:06:50', '2025-08-07 14:07:37', '1754597257'),
(11, 14, '7570196', 'General Seller', 'Bkash', '1.00', NULL, 1, '2025-08-13 10:08:59', '2025-08-13 10:09:57', '1755101397'),
(12, 16, '9980591', 'Seller', 'Bkash', '1.00', NULL, 1, '2025-09-03 09:03:03', '2025-09-03 09:06:28', '1756911988'),
(13, 18, '2660873', 'Dropshiper', 'Bkash', '3.00', NULL, 1, '2025-09-08 04:55:18', '2025-09-08 04:56:21', '1757328981'),
(14, 18, '2521485', 'Dropshiper', 'Bkash', '3.00', NULL, 0, '2025-09-08 05:39:00', '2025-09-08 05:39:00', '1757331539');

-- --------------------------------------------------------

--
-- Table structure for table `sub_locations`
--

CREATE TABLE `sub_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `sub_location_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_purchase`
--

CREATE TABLE `temp_purchase` (
  `id` int(10) UNSIGNED NOT NULL,
  `inv` varchar(15) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `product` varchar(45) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `quantity` varchar(10) NOT NULL,
  `rate` varchar(10) NOT NULL,
  `vat` varchar(10) NOT NULL,
  `total` varchar(10) NOT NULL,
  `author` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_purchase_return`
--

CREATE TABLE `temp_purchase_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `inv` varchar(15) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `product` varchar(45) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `quantity` varchar(10) NOT NULL,
  `rate` varchar(10) NOT NULL,
  `total` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_sales_item`
--

CREATE TABLE `temp_sales_item` (
  `id` varchar(25) NOT NULL,
  `qty` double NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `name` varchar(45) NOT NULL,
  `vat` double NOT NULL,
  `unit` varchar(15) NOT NULL,
  `type` varchar(15) NOT NULL,
  `cart_type` varchar(20) NOT NULL,
  `sales_man` varchar(15) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `from_user_id` bigint(20) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `wallet_type` tinyint(4) NOT NULL DEFAULT 0,
  `tnx_type` tinyint(4) NOT NULL DEFAULT 0,
  `credit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `debit` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` varchar(250) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 2,
  `in_status` tinyint(4) NOT NULL DEFAULT 1,
  `date` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `from_user_id`, `payment_id`, `wallet_type`, `tnx_type`, `credit`, `debit`, `note`, `description`, `status`, `in_status`, `date`, `created_at`, `updated_at`) VALUES
(2, 4, 5, NULL, 1, 4, 104.00, 0.00, '80% Product Sales from Order No : 17546771802', '{\"item_id\":2,\"order_id\":\"2\",\"order_no\":\"17546771802\",\"product_id\":\"34\",\"customer_id\":\"5\",\"vendor_id\":\"4\",\"reseller_id\":null,\"vendor_commission\":80,\"reseller_commission\":0,\"admin_commission\":20,\"vendor_amount\":104,\"reseller_commission_amount\":0,\"admin_commission_amount\":26}', 1, 1, '1754740723', '2025-08-09 05:58:43', '2025-08-09 05:58:43'),
(3, 1, 5, NULL, 2, 6, 26.00, 0.00, '20% Product Sales Commission from Order No : 17546771802', '{\"item_id\":2,\"order_id\":\"2\",\"order_no\":\"17546771802\",\"product_id\":\"34\",\"customer_id\":\"5\",\"vendor_id\":\"4\",\"reseller_id\":null,\"vendor_commission\":80,\"reseller_commission\":0,\"admin_commission\":20,\"vendor_amount\":104,\"reseller_commission_amount\":0,\"admin_commission_amount\":26}', 1, 1, '1754740723', '2025-08-09 05:58:43', '2025-08-09 05:58:43'),
(4, 4, 15, NULL, 1, 4, 104.00, 0.00, '80% Product Sales from Order No : 17561379513', '{\"item_id\":3,\"order_id\":\"3\",\"order_no\":\"17561379513\",\"product_id\":\"34\",\"customer_id\":\"15\",\"vendor_id\":\"4\",\"reseller_id\":null,\"vendor_commission\":80,\"reseller_commission\":0,\"admin_commission\":20,\"vendor_amount\":104,\"reseller_commission_amount\":0,\"admin_commission_amount\":26}', 1, 1, '1756925042', '2025-09-03 12:44:02', '2025-09-03 12:44:02'),
(5, 1, 15, NULL, 2, 6, 26.00, 0.00, '20% Product Sales Commission from Order No : 17561379513', '{\"item_id\":3,\"order_id\":\"3\",\"order_no\":\"17561379513\",\"product_id\":\"34\",\"customer_id\":\"15\",\"vendor_id\":\"4\",\"reseller_id\":null,\"vendor_commission\":80,\"reseller_commission\":0,\"admin_commission\":20,\"vendor_amount\":104,\"reseller_commission_amount\":0,\"admin_commission_amount\":26}', 1, 1, '1756925042', '2025-09-03 12:44:02', '2025-09-03 12:44:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usertype` varchar(255) DEFAULT NULL,
  `refer_code` varchar(100) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(51) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `code` varchar(91) DEFAULT NULL,
  `forget_otp` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT 'Male',
  `image` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `account_type` varchar(91) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `subscription_plan` varchar(60) DEFAULT NULL,
  `terms` varchar(91) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 = inactive, 1 = active, 2 = suspended',
  `is_profile_verify` tinyint(4) DEFAULT 0,
  `payment_status` tinyint(4) DEFAULT NULL COMMENT '0 = unpaid, 1 = paid',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `commission` int(11) DEFAULT 0,
  `balance` decimal(10,2) DEFAULT 0.00,
  `refer_commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sales_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reseller_commission_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_reseller` int(2) DEFAULT NULL,
  `reseller_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usertype`, `refer_code`, `name`, `email`, `role`, `email_verified_at`, `password`, `mobile`, `provider_id`, `code`, `forget_otp`, `address`, `gender`, `image`, `logo`, `account_type`, `shop_name`, `subscription_plan`, `terms`, `status`, `is_profile_verify`, `payment_status`, `remember_token`, `created_at`, `updated_at`, `commission`, `balance`, `refer_commission`, `sales_amount`, `reseller_commission_amount`, `is_reseller`, `reseller_id`) VALUES
(1, 'admin', 'UFV4EIJQ', 'rafi islam', 'admin@gmail.com', 'admin', NULL, '$2y$10$PkMOYoeM6gf9Sll0MbQcmeXI8g8HqrPrcJzdiIOOgS0pVcMgDZwoC', '01816622128', NULL, NULL, NULL, 'Dhaka Bangladesh', 'Male', '202507082053mastercard-visa-cards-logos-icons-701751695036083sdqsk5ncvn-removebg-preview.png', NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, '2022-08-10 00:06:32', '2026-02-07 01:37:02', 0, 3400.00, 0.00, 0.00, 0.00, NULL, NULL),
(2, 'vendor', 'J7LKBYBL', 'Rafi', 'rafi@gmail.com', NULL, '2025-07-27 02:27:37', '$2y$10$nIhPxemYKs.4ncWNDr2h..fAF2XVVWrtPTlQ.UNaDcsX2RULJlwey', '01816622100', NULL, '547875', NULL, 'Dhaka Bangladesh', 'Male', NULL, NULL, 'vendor', 'Rafi Shop', '1753488000', 'yes', 0, 0, 0, NULL, '2025-07-26 10:53:29', '2025-08-20 09:04:45', 10, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(3, 'seller', 'GBYTPEG9', 'rafi islam', 'rafi123@gmail.com', NULL, '2025-07-31 04:44:24', '$2y$10$kvM97Bf66f9wO7fAgWhSXug/oikJKOH5GRXxDd3LSwPQ//1ijbTLi', '01816622129', NULL, '893979', NULL, 'dhaka', 'Male', NULL, NULL, 'seller', 'rafi99', '1753747200', 'yes', 0, 0, 1, NULL, '2025-07-29 13:17:46', '2025-12-30 13:07:22', 10, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(4, 'vendor', 'EGBT7IR1', 'Mister MR', '01719142015mhbbmst@gmail.com', NULL, '2025-08-01 05:32:05', '$2y$10$LbyoXQagD3SzAzMMJcduEeYrIN0AggRT1iBVyIipYe29YZokhDPMi', '01719142015', NULL, NULL, NULL, 'Dhaka', 'Male', NULL, NULL, 'vendor', 'Mister mr', '1753920000', 'yes', 2, 1, 2, NULL, '2025-07-31 12:57:11', '2025-11-04 08:02:20', 10, 208.00, 0.00, 208.00, 0.00, NULL, NULL),
(5, 'customer', 'OVSVWWCE', 'Rafi', 'rafiqww@gmail.com', NULL, '2025-08-01 05:50:57', '$2y$10$arDlmSsrsIavJmp/ZFPrfu.TQCjKhXAfGMMnsZXHDyDoF0mbgz7eG', '01816622120', NULL, NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-08-01 05:50:17', '2025-12-08 19:43:27', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(6, 'dropshipper', 'KMXQ7LFS', 'rafi2', 'dropshipper@gmail.com', NULL, '2025-08-01 07:46:20', '$2y$10$sqSW05qof7xqHhC6b1Uvfueho3nAhUHtccxf6yWU.30GAvAuakmiy', '01816622199', NULL, NULL, NULL, 'dhaka', 'Male', NULL, NULL, 'seller', 'rafi2', '1754006400', 'yes', 1, 1, 1, NULL, '2025-08-01 07:45:50', '2026-01-18 11:40:46', 10, 5000.00, 0.00, 0.00, 0.00, 1, NULL),
(7, 'vendor', 'KO8KXDMT', 'Md Zillur Rahman Rahman', 'z.i@gmail.com', NULL, '2025-08-04 00:19:58', '$2y$10$xERuyP9eTbWyqG4N2al8buMC6wSa429IL8RplC9bheHrdsLGBJ3Y6', '011122222541', NULL, NULL, NULL, 'Web School Address', 'Male', NULL, NULL, 'vendor', 'Test', '1754265600', 'yes', 2, 0, 2, NULL, '2025-08-04 00:19:38', '2025-11-04 07:58:31', 10, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(8, 'seller', '20FPD0AH', 'রাত্রে তারা', 'all@gmail.com', NULL, NULL, '$2y$10$bfL8/8akHIz/m0lLYxpB0e7TeyeBeC0VUCOXpW.AIRwi9RIqN2Yru', '01612386499', NULL, '529087', NULL, 'Dhaka', 'Male', NULL, NULL, 'seller', 'সন্ধ্যার তারা', '1754524800', 'yes', 0, 0, 0, NULL, '2025-08-06 22:36:14', '2025-12-30 13:07:22', 10, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(9, 'seller', 'EPJ9WSMM', 'রাত্রে তারা', 'allahu@gmail.com', NULL, '2025-08-06 22:55:04', '$2y$10$tQnPY/FFK.L7b.kg7KtwhOTvdfjrVf69YPUW02kY/AWEgWgvyUPVS', '01619570271', NULL, NULL, NULL, 'Dhaka', 'Male', NULL, NULL, 'seller', 'সন্ধ্যার তারা', '1754524800', 'yes', 1, 0, 0, NULL, '2025-08-06 22:52:38', '2025-12-30 13:07:22', 10, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(10, 'vendor', 'X0SWN6TA', 'Test vendor', 'sele@gmail.com', NULL, '2025-08-07 09:25:59', '$2y$10$45igsEx./6tmCmkB3p7Q2OQTBfc3Hs08XE7zS7QkFvDNjdzfN6Afi', '01889164555', NULL, NULL, NULL, 'Dhaka', 'Male', NULL, NULL, 'vendor', 'Sele shop', '1754524800', 'yes', 2, 1, 2, NULL, '2025-08-07 09:25:30', '2025-11-04 07:59:08', 10, 200.00, 0.00, 0.00, 0.00, NULL, NULL),
(11, 'vendor', 'CBGWBB19', 'Mhin', 'vendor@gmail.com', NULL, '2025-08-07 14:05:40', '$2y$10$sqSW05qof7xqHhC6b1Uvfueho3nAhUHtccxf6yWU.30GAvAuakmiy', '01642163922', NULL, NULL, NULL, 'Bangladesh', 'Male', NULL, NULL, 'seller', 'Mhin', '1754524800', 'yes', 1, 1, 1, NULL, '2025-08-07 14:04:54', '2026-01-18 11:55:42', 10, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(13, 'vendor', '88V4YU3K', 'rafi islam 5', 'ra4444fi@gmail.com', NULL, NULL, '$2y$10$fMN16LyaXq7sVkl7j9v.W.TC6lwiAkXcxwFM85TcK57SYIdmOQQg.', '01816622151', NULL, '686392', NULL, 'dhaka', 'Male', NULL, NULL, 'vendor', 'test55', '1755043200', 'yes', 0, 0, 0, NULL, '2025-08-13 10:04:28', '2025-08-20 09:04:45', 10, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(14, 'seller', 'MPHAVUC3', 'rafi', 'seller@gmail.com', NULL, '2025-08-13 10:07:27', '$2y$10$sqSW05qof7xqHhC6b1Uvfueho3nAhUHtccxf6yWU.30GAvAuakmiy', '01816622124', NULL, NULL, NULL, 'dhaka', 'Male', NULL, NULL, 'seller', 'test55', '1755043200', 'yes', 1, 0, 1, NULL, '2025-08-13 10:06:45', '2026-01-18 11:49:43', 10, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(17, NULL, 'KSVPMWU7', 'MD Masum Rana', 'masum@gmail.com', NULL, NULL, '$2y$10$ZPOl1byVHnVDNpvb.P/hxOgDmK6lf6A5fpqXujdUmsKTTrrXkLxZ6', '01799593940', NULL, '201241', NULL, 'Gangni', 'Male', NULL, NULL, 'dropshipper', 'test55', '1757289600', 'yes', 2, 0, 0, NULL, '2025-09-08 03:08:28', '2025-09-30 17:59:20', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(18, NULL, 'YPNXILED', 'MD Masum Rana', 'masumtelecomand@gmail.com', NULL, '2025-09-08 03:13:31', '$2y$10$8A1a0DGR3HJZ0I2nTkGaVO7v0HwjWBzCNrpK58VkHX.x4bR3QHAKa', '01860871112', NULL, NULL, NULL, 'Gangni', 'Male', NULL, NULL, 'dropshipper', 'test55', '1757289600', 'yes', 1, 1, 1, NULL, '2025-09-08 03:12:56', '2025-11-01 06:26:20', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(19, 'customer', 'CYLCJVIL', 'Programming Banner', 'masum12@gmail.com', NULL, NULL, '$2y$10$bE16rMo8Ie.tvYOXHQpZ2uGtNl19nd05PCwQkKPqBhERiEx89zK6O', '01719333824', NULL, '272897', NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, '2025-09-18 20:09:15', '2025-09-18 20:09:15', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(21, 'admin', NULL, 'mr abdou', 'mrabdou100012@gmail.com', 'admin', NULL, '$2y$10$nq/mA/po.eYDiuMhPJqOmODzV/EtBh3hF.wc4QKafbpamXdZfO4Zq', NULL, NULL, NULL, '264661', NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-10-23 11:15:37', '2025-11-02 12:41:49', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(24, 'dropshipper', 'BMMTNHTW', 'Programming Banner', 'rrrr3@gmail.com', NULL, '2025-11-04 18:27:14', '$2y$10$CBNLrsV0npqQzHeFXdNDbuyuVAkZYDnRCmBulwYJ6FtVk.srgZ9c2', '01755555222', NULL, NULL, NULL, 'dhaka mir', 'Male', NULL, NULL, 'dropshipper', 'U SUPER SHOP Banner', '1762300800', 'yes', 1, 0, 1, NULL, '2025-11-04 18:26:48', '2025-12-11 11:26:52', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(25, 'customer', 'WNISIAJO', 'MD AL MAMUN', 'customer@gmail.com', NULL, '2025-11-05 04:44:00', '$2y$10$sqSW05qof7xqHhC6b1Uvfueho3nAhUHtccxf6yWU.30GAvAuakmiy', '01670122630', NULL, NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-11-05 04:43:39', '2025-12-30 22:31:32', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(26, 'admin', NULL, 'New Admin', 'newadmin@usupershop.com', NULL, NULL, '$2y$10$9Jq22XQZL6NDGMW1us6ZGebIzg7FD6nA1ZSSG.PD0O2NavC40T/2G', NULL, NULL, NULL, NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2026-01-23 06:22:00', '2026-01-23 06:22:00', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(27, 'customer', 'CS0BEAHG', 'Imamul Ahasan', 'imam@gmail.com', NULL, '2026-01-25 11:11:30', '$2y$10$L3W228Mj.LTaZ4c0RGiF2.0h79GLW1Nn.jbjl98fBgkwzV/6of1.y', '01842299275', NULL, '681826', NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, '2026-01-25 05:08:29', '2026-01-31 02:33:07', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL),
(43, 'customer', 'L5JVX3VS', 'Imamul Ahasan', 'ahasan11@gmail.com', NULL, NULL, '$2y$10$wk//mZmIBySDkAzhCqvrkeCXPCYuGia0jM9xPNI1xOv6ZlcyzTbIW', '+8801842297276', NULL, '291716', NULL, NULL, 'Male', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, '2026-04-12 10:18:30', '2026-04-12 10:18:30', 0, 0.00, 0.00, 0.00, 0.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_status`
--

CREATE TABLE `users_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `last_time` datetime NOT NULL,
  `status` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_status`
--

INSERT INTO `users_status` (`id`, `user_id`, `ip`, `last_time`, `status`) VALUES
(1, 'admin', '103.183.116.146', '2022-12-17 11:02:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission` varchar(255) NOT NULL,
  `role_id` varchar(45) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`user_id`, `permission`, `role_id`) VALUES
(13, '9,10,11,13,17,31,18,19,20,21,28,29', '4'),
(14, '9,10,11,13,17,31,18,19,20,21,22,23,24,25,26,28,29,30', '3');

-- --------------------------------------------------------

--
-- Table structure for table `user_permission_type`
--

CREATE TABLE `user_permission_type` (
  `id_type` int(10) UNSIGNED NOT NULL,
  `type_name` varchar(45) NOT NULL,
  `uri` varchar(150) DEFAULT NULL,
  `ref` int(10) UNSIGNED DEFAULT 0,
  `sts` int(10) UNSIGNED DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `user_permission_type`
--

INSERT INTO `user_permission_type` (`id_type`, `type_name`, `uri`, `ref`, `sts`) VALUES
(1, 'HOME', 'home', 0, 1),
(2, 'SALES', 'sales', 0, 1),
(3, 'PURCHASE', 'purchase', 0, 1),
(4, 'STOCK', 'stock', 0, 1),
(5, 'MARKETING', 'marketing', 0, 1),
(6, 'REPORT', 'report', 0, 1),
(7, 'BANKING', 'banking', 0, 1),
(8, 'ACCOUNTS', 'accounts', 0, 1),
(9, 'Daily Graph', '', 1, 1),
(10, 'New Sales', '', 2, 1),
(11, 'Sales Report', 'daily_sales', 2, 1),
(12, 'Sales Return', 'sales_return', 2, 1),
(13, 'Purchase Report', '', 3, 1),
(14, 'New Purchase', 'new_purchase', 3, 1),
(15, 'Purchase Return', 'purchase_return', 3, 1),
(16, 'New Purchase Return', 'new_purchase_return', 3, 1),
(17, 'Stock Report', '', 4, 1),
(18, 'Print Quotation', 'marketing', 5, 1),
(19, 'Cus/Sup Ledger', '', 6, 1),
(20, 'Journal Report', 'journal_reports', 6, 1),
(21, 'Ledger Book', 'ledger', 6, 1),
(22, 'Trial Balance', 'trial_balance', 6, 1),
(23, 'Income Statement', 'income_stm', 6, 1),
(24, 'Withdraw', '', 7, 1),
(25, 'Deposit', 'deposit', 7, 1),
(26, 'Bank Statement', 'statement', 7, 1),
(28, 'Collection From Customers', '', 8, 1),
(29, 'Payment To Vendors', 'due_payment', 8, 1),
(30, 'Expenditure Entry', 'daily_expense', 8, 1),
(31, 'Purchase Item Report', 'vendor_pur_item', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(30) NOT NULL,
  `role_desc` varchar(45) NOT NULL,
  `permission` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role_name`, `role_desc`, `permission`) VALUES
(1, 'Sales Man', 'Only Sales', '10,11,13,17,18,19,20,21'),
(2, 'See Only', 'Sales', '9,13,18,19'),
(3, 'All', 'All', '9,10,11,13,17,31,18,19,20,21,22,23,24,25,26,28,29,30'),
(4, 'Sales', 'Only Sales', '9,10,11,13,17,31,18,19,20,21,28,29');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) CHARACTER SET utf32 COLLATE utf32_general_ci DEFAULT 'Bkash',
  `transaction_status` enum('received','waiting','pending') NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `transaction_date` varchar(255) DEFAULT NULL,
  `transaction_balance` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `mobile_no`, `payment_type`, `transaction_status`, `transaction_id`, `transaction_date`, `transaction_balance`, `created_at`, `updated_at`) VALUES
(1, 46, '01867871200', 'Bkash', 'received', 'rteywergwe', NULL, NULL, '2025-01-25 00:46:46', '2025-01-25 01:19:12'),
(2, 46, '01867871200', 'Bkash', 'waiting', NULL, NULL, NULL, '2025-01-25 01:17:05', '2025-01-25 01:17:05'),
(3, 100, '01816622128', 'Bkash', 'waiting', NULL, NULL, NULL, '2025-02-05 11:11:44', '2025-02-05 11:11:44'),
(4, 85, '01933441244', 'Bkash', 'waiting', NULL, NULL, NULL, '2025-02-05 23:48:25', '2025-02-05 23:48:25'),
(5, 65, '01877766622', 'Bkash', 'received', '123456789]', NULL, NULL, '2025-02-06 05:39:57', '2025-05-02 14:10:24'),
(6, 57, '01816622128', 'Bkash', 'waiting', NULL, NULL, NULL, '2025-04-17 10:42:18', '2025-04-17 10:42:18'),
(7, 168, '01933441244', 'Bkash', 'received', '78954214', '2025-05-04 05:51:21', 200, '2025-05-03 23:24:29', '2025-05-03 23:51:21'),
(8, 162, '01932401533', 'Bkash', 'received', '98745621', '2025-05-04 05:51:33', 200, '2025-05-03 23:49:45', '2025-05-03 23:51:33'),
(9, 168, '01932401533', 'Bkash', 'received', 'yt9856274pay', '2025-05-04 06:23:20', 200, '2025-05-04 00:20:49', '2025-05-04 00:23:20'),
(10, 160, '0192401532', 'Bkash', 'received', '123456655', '2025-05-04 19:42:11', 200, '2025-05-04 00:41:16', '2025-05-04 13:42:11'),
(11, 165, '01816622128', 'Bkash', 'received', '1234567io', '2025-05-05 14:32:46', 200, '2025-05-05 08:27:51', '2025-05-05 08:32:46'),
(12, 168, '01933441244', 'Bkash', 'waiting', NULL, NULL, NULL, '2025-05-10 02:05:40', '2025-05-10 02:05:40'),
(13, 10, '01860871112', 'Bkash', 'received', 'Sf5yth6Gjk', '2025-09-07 10:25:18', 5000, '2025-09-07 04:24:21', '2025-09-07 04:25:18'),
(14, 18, '0181665566546', 'Bkash', 'received', '12774855', '2025-10-17 11:16:19', 6100, '2025-10-01 00:53:17', '2025-10-17 05:16:19'),
(15, 6, '01816622128', 'Bkash', 'waiting', NULL, NULL, NULL, '2025-10-17 05:26:40', '2025-10-17 05:26:40'),
(16, 10, '01860871112', 'Bkash', 'received', 'sss', '2025-10-22 01:22:43', 5000, '2025-10-20 21:41:12', '2025-10-21 19:22:43'),
(17, 10, '01860871112', 'Nagad', 'waiting', NULL, NULL, NULL, '2025-10-21 19:26:08', '2025-10-21 19:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `customer_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 4, 8, '2023-03-18 00:04:51', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankinfo`
--
ALTER TABLE `bankinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner_images`
--
ALTER TABLE `banner_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `color_settings`
--
ALTER TABLE `color_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commission_ledgers`
--
ALTER TABLE `commission_ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `communications`
--
ALTER TABLE `communications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_product`
--
ALTER TABLE `coupon_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_product_coupon_id_product_id_unique` (`coupon_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_expense`
--
ALTER TABLE `daily_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_income`
--
ALTER TABLE `daily_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_sales`
--
ALTER TABLE `daily_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_sales_items`
--
ALTER TABLE `daily_sales_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliverychargezone`
--
ALTER TABLE `deliverychargezone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_zones`
--
ALTER TABLE `delivery_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dkn_users`
--
ALTER TABLE `dkn_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropshipper_fees`
--
ALTER TABLE `dropshipper_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropshipper_product_prices`
--
ALTER TABLE `dropshipper_product_prices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dropshipper_product_prices_dropshipper_id_product_id_unique` (`dropshipper_id`,`product_id`),
  ADD KEY `dropshipper_product_prices_product_id_foreign` (`product_id`);

--
-- Indexes for table `dropshipper_profits`
--
ALTER TABLE `dropshipper_profits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dropshipper_profits_dropshipper_id_foreign` (`dropshipper_id`),
  ADD KEY `dropshipper_profits_order_id_foreign` (`order_id`);

--
-- Indexes for table `dropshipper_referral_codes`
--
ALTER TABLE `dropshipper_referral_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dropshipper_referral_codes_referral_code_unique` (`referral_code`),
  ADD KEY `dropshipper_referral_codes_dropshipper_id_foreign` (`dropshipper_id`),
  ADD KEY `dropshipper_referral_codes_referral_code_index` (`referral_code`);

--
-- Indexes for table `finance_accounts_credit_item`
--
ALTER TABLE `finance_accounts_credit_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_accounts_debit_item`
--
ALTER TABLE `finance_accounts_debit_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_account_head`
--
ALTER TABLE `finance_account_head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_bank_ledger`
--
ALTER TABLE `finance_bank_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_cheque_deposit`
--
ALTER TABLE `finance_cheque_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_cheque_payment`
--
ALTER TABLE `finance_cheque_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_cheque_received`
--
ALTER TABLE `finance_cheque_received`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_customer_ledger`
--
ALTER TABLE `finance_customer_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_due_collection`
--
ALTER TABLE `finance_due_collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_due_payment`
--
ALTER TABLE `finance_due_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_journal_entry`
--
ALTER TABLE `finance_journal_entry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_activity`
--
ALTER TABLE `login_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `my_shops`
--
ALTER TABLE `my_shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_courier_assigned_by_foreign` (`courier_assigned_by`),
  ADD KEY `orders_dropshipper_id_foreign` (`dropshipper_id`),
  ADD KEY `orders_courier_id_status_index` (`courier_id`,`status`),
  ADD KEY `orders_courier_tracking_id_index` (`courier_tracking_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments_transaction`
--
ALTER TABLE `payments_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person_info`
--
ALTER TABLE `person_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sub_images`
--
ALTER TABLE `product_sub_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_product_color_size` (`product_id`,`color_id`,`size_id`),
  ADD KEY `product_variants_color_id_foreign` (`color_id`),
  ADD KEY `product_variants_size_id_foreign` (`size_id`);

--
-- Indexes for table `profile_verifies`
--
ALTER TABLE `profile_verifies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profile_verifies_nid_no_unique` (`nid_no`),
  ADD KEY `profile_verifies_user_id_foreign` (`user_id`);

--
-- Indexes for table `purchase_invoice`
--
ALTER TABLE `purchase_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_invoice_item`
--
ALTER TABLE `purchase_invoice_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_invoice`
--
ALTER TABLE `purchase_return_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_invoice_item`
--
ALTER TABLE `purchase_return_invoice_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return`
--
ALTER TABLE `sales_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_emails`
--
ALTER TABLE `seller_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_fees`
--
ALTER TABLE `seller_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_payments`
--
ALTER TABLE `seller_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_info`
--
ALTER TABLE `staff_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_fees`
--
ALTER TABLE `subscription_fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `sub_locations`
--
ALTER TABLE `sub_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_purchase`
--
ALTER TABLE `temp_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_purchase_return`
--
ALTER TABLE `temp_purchase_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_status`
--
ALTER TABLE `users_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_permission_type`
--
ALTER TABLE `user_permission_type`
  ADD PRIMARY KEY (`id_type`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallets_user_id_foreign` (`user_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bankinfo`
--
ALTER TABLE `bankinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner_images`
--
ALTER TABLE `banner_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `color_settings`
--
ALTER TABLE `color_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `commission_ledgers`
--
ALTER TABLE `commission_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `communications`
--
ALTER TABLE `communications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `coupon_product`
--
ALTER TABLE `coupon_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `daily_expense`
--
ALTER TABLE `daily_expense`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `daily_income`
--
ALTER TABLE `daily_income`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `daily_sales`
--
ALTER TABLE `daily_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `daily_sales_items`
--
ALTER TABLE `daily_sales_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `deliverychargezone`
--
ALTER TABLE `deliverychargezone`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_zones`
--
ALTER TABLE `delivery_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dkn_users`
--
ALTER TABLE `dkn_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dropshipper_fees`
--
ALTER TABLE `dropshipper_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dropshipper_product_prices`
--
ALTER TABLE `dropshipper_product_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipper_profits`
--
ALTER TABLE `dropshipper_profits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropshipper_referral_codes`
--
ALTER TABLE `dropshipper_referral_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finance_accounts_credit_item`
--
ALTER TABLE `finance_accounts_credit_item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `finance_accounts_debit_item`
--
ALTER TABLE `finance_accounts_debit_item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `finance_account_head`
--
ALTER TABLE `finance_account_head`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `finance_bank_ledger`
--
ALTER TABLE `finance_bank_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finance_cheque_deposit`
--
ALTER TABLE `finance_cheque_deposit`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finance_cheque_payment`
--
ALTER TABLE `finance_cheque_payment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finance_cheque_received`
--
ALTER TABLE `finance_cheque_received`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finance_customer_ledger`
--
ALTER TABLE `finance_customer_ledger`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `finance_due_collection`
--
ALTER TABLE `finance_due_collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `finance_due_payment`
--
ALTER TABLE `finance_due_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `finance_journal_entry`
--
ALTER TABLE `finance_journal_entry`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_activity`
--
ALTER TABLE `login_activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logos`
--
ALTER TABLE `logos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `my_shops`
--
ALTER TABLE `my_shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `payments_transaction`
--
ALTER TABLE `payments_transaction`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `person_info`
--
ALTER TABLE `person_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;

--
-- AUTO_INCREMENT for table `product_sub_images`
--
ALTER TABLE `product_sub_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `profile_verifies`
--
ALTER TABLE `profile_verifies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase_invoice`
--
ALTER TABLE `purchase_invoice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchase_invoice_item`
--
ALTER TABLE `purchase_invoice_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchase_return_invoice`
--
ALTER TABLE `purchase_return_invoice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_invoice_item`
--
ALTER TABLE `purchase_return_invoice_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return`
--
ALTER TABLE `sales_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_items`
--
ALTER TABLE `sales_return_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_emails`
--
ALTER TABLE `seller_emails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `seller_fees`
--
ALTER TABLE `seller_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seller_payments`
--
ALTER TABLE `seller_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_info`
--
ALTER TABLE `staff_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subscription_fees`
--
ALTER TABLE `subscription_fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sub_locations`
--
ALTER TABLE `sub_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_purchase`
--
ALTER TABLE `temp_purchase`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_purchase_return`
--
ALTER TABLE `temp_purchase_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users_status`
--
ALTER TABLE `users_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_permission_type`
--
ALTER TABLE `user_permission_type`
  MODIFY `id_type` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupon_product`
--
ALTER TABLE `coupon_product`
  ADD CONSTRAINT `coupon_product_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshipper_product_prices`
--
ALTER TABLE `dropshipper_product_prices`
  ADD CONSTRAINT `dropshipper_product_prices_dropshipper_id_foreign` FOREIGN KEY (`dropshipper_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dropshipper_product_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshipper_profits`
--
ALTER TABLE `dropshipper_profits`
  ADD CONSTRAINT `dropshipper_profits_dropshipper_id_foreign` FOREIGN KEY (`dropshipper_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dropshipper_profits_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropshipper_referral_codes`
--
ALTER TABLE `dropshipper_referral_codes`
  ADD CONSTRAINT `dropshipper_referral_codes_dropshipper_id_foreign` FOREIGN KEY (`dropshipper_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_courier_assigned_by_foreign` FOREIGN KEY (`courier_assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_dropshipper_id_foreign` FOREIGN KEY (`dropshipper_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments_transaction`
--
ALTER TABLE `payments_transaction`
  ADD CONSTRAINT `client_id` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD CONSTRAINT `payment_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variants_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
