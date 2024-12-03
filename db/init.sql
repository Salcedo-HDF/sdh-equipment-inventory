-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 03, 2024 at 02:41 AM
-- Server version: 8.0.40
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(13, 'Cleaning Supplies'),
(12, 'Construction Supplies'),
(11, 'Dietary Supplies '),
(14, 'Electronics'),
(10, 'Medical Supplies'),
(9, 'Office Supplies');

-- --------------------------------------------------------

--
-- Table structure for table `checkin_logs`
--

CREATE TABLE `checkin_logs` (
  `id` int NOT NULL,
  `item_id` int DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantity` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `status` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `where_found` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `checkin_by` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `checkin_date` date DEFAULT NULL,
  `checkin_room` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `checkin_location` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `checkin_location_barcode` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comments` text COLLATE utf8mb4_general_ci,
  `categorie_id` int DEFAULT NULL,
  `media_id` int DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `check_out`
--

CREATE TABLE `check_out` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `checkout_by` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `checkout_date` date NOT NULL,
  `quantity` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `due_back_date` date DEFAULT NULL,
  `comments` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `check_out`
--

INSERT INTO `check_out` (`id`, `item_id`, `checkout_by`, `checkout_date`, `quantity`, `due_back_date`, `comments`) VALUES
(26, 14, 'Dana Alyka O. Alde', '2024-11-13', '10', '2024-12-07', 'None'),
(27, 37, 'Lionel Adal', '2024-11-14', '20', '2024-12-07', 'None'),
(29, 14, 'Test', '2024-11-06', '1', NULL, ''),
(30, 14, 'tests2', '2024-11-01', '1', NULL, ''),
(35, 49, 'OR', '2024-11-15', '2', NULL, ''),
(36, 20, 'Billing Office', '2024-11-15', '2', NULL, ''),
(38, 49, 'Tests', '2024-11-18', '2', NULL, ''),
(39, 14, 'Tests', '2024-11-18', '5', NULL, ''),
(41, 48, 'TEsts', '2024-11-22', '300', NULL, ''),
(42, 35, 'TEstss', '2024-11-22', '21', NULL, ''),
(43, 35, 'TEstts', '2024-11-22', '45', NULL, ''),
(44, 34, 'By testing', '2024-11-22', '20', NULL, ''),
(45, 52, 'By Testing', '2024-11-21', '4', NULL, ''),
(46, 56, 'Testing', '2024-11-22', '4', NULL, '\r\n\r\n'),
(47, 48, 'qweerty', '2024-11-21', '100', NULL, ''),
(48, 48, 'asdfdf', '2024-11-21', '50', NULL, ''),
(49, 52, 'R-jhel', '2024-11-22', '5', NULL, ''),
(50, 47, 'zxcxcxc', '2024-11-23', '32', NULL, ''),
(51, 15, 'lkjhg', '2024-11-22', '1', NULL, ''),
(52, 52, 'cvbnm', '2024-11-22', '1', NULL, ''),
(53, 52, 'mnmbnb', '2024-11-22', '1', NULL, ''),
(55, 14, 'R-jhel Tandugon', '2024-11-30', '1', NULL, 'Approve by R-jhel 11/30/2024'),
(56, 57, 'R-jhel Tandugon', '2024-11-30', '2', NULL, 'Approve!!'),
(57, 58, 'Jerome', '2024-11-30', '1', '2024-12-07', 'Check Out Testing'),
(58, 56, 'R-jhel Tandugon', '2024-11-30', '20', NULL, 'Approve by Dra Tonette'),
(59, 56, 'R-jhel Tandugon', '2024-11-30', '40', '2025-01-11', 'Approve by Dra 12/01/2024'),
(60, 58, 'R-jhel Tandugon', '2024-11-30', '41', '2024-12-06', 'Aprrove!!!!!'),
(61, 58, 'R-jhel Tandugon', '2024-11-30', '28', NULL, ''),
(62, 57, 'R-jhel Tandugon', '2024-11-30', '38', NULL, ''),
(63, 57, 'R-jhel Tandugon', '2024-11-30', '20', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `inout_logs`
--

CREATE TABLE `inout_logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inout_logs`
--

INSERT INTO `inout_logs` (`id`, `user_id`, `date`, `action`) VALUES
(1, 1, '2024-12-02 11:01:52', 'Log in'),
(2, 1, '2024-12-02 14:33:02', 'Log in'),
(3, 1, '2024-12-02 14:34:46', 'Log in'),
(4, 1, '2024-12-02 06:34:52', 'Log out'),
(5, 1, '2024-12-02 14:35:01', 'Log in'),
(6, 1, '2024-12-02 14:36:01', 'Log out'),
(7, 1, '2024-12-02 14:36:07', 'Log in'),
(8, 9, '2024-12-02 14:38:47', 'Log in'),
(9, 1, '2024-12-02 15:23:09', 'Log out'),
(10, 1, '2024-12-02 15:30:38', 'Log in'),
(11, 6, '2024-12-02 16:36:17', 'Log in'),
(12, 6, '2024-12-02 16:38:03', 'Log out');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `action` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `user` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantity` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comments` text COLLATE utf8mb4_general_ci,
  `action_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `item_id`, `action`, `user`, `quantity`, `comments`, `action_date`) VALUES
(13, 14, 'Check Out', 'R-jhel B. Tandugon', '10', NULL, '2024-11-12 00:00:00'),
(14, 14, 'Check In', 'R-jhel Tandugon', '10', NULL, '2024-11-12 09:53:34'),
(15, 14, 'Check Out', 'Dana Alyka O. Alde', '10', NULL, '2024-11-13 00:00:00'),
(16, 37, 'Check Out', 'Lionel Adal', '20', NULL, '2024-11-14 00:00:00'),
(17, 20, 'Check Out', 'Sheena', '1', NULL, '2024-11-13 00:00:00'),
(18, 48, 'Check In', 'R-jhel Tandugon', '1000', NULL, '2024-11-12 10:01:00'),
(19, 14, 'Check Out', 'Test', '1', NULL, '2024-11-06 00:00:00'),
(20, 14, 'Check Out', 'tests2', '1', NULL, '2024-11-01 00:00:00'),
(21, 49, 'Check In', 'Tests User', '6', NULL, '2024-11-15 03:11:02'),
(22, 49, 'Check Out', 'Philhealth', '2', NULL, '2024-11-14 00:00:00'),
(23, 49, 'Check In', 'R-jhel Tandugon', '2', NULL, '2024-11-15 03:20:18'),
(24, 49, 'Check Out', 'R-jhel', '2', NULL, '2024-11-15 00:00:00'),
(25, 49, 'Check In', 'R-jhel Tandugon', '2', NULL, '2024-11-15 03:31:19'),
(26, 49, 'Check Out', 'R-jhel Tandnugon', '2', NULL, '2024-11-15 03:36:26'),
(27, 50, 'Check In', 'R-jhel Tandugon', '1', NULL, '2024-11-15 11:50:21'),
(28, 49, 'Check In', 'R-jhel Tandugon', '2', NULL, '2024-11-15 03:54:03'),
(29, 49, 'Check Out', 'Billing', '2', NULL, '2024-11-15 03:56:41'),
(30, 49, 'Check In', 'R-jhel Tandugon', '2', NULL, '2024-11-15 04:00:13'),
(31, 49, 'Check Out', 'OR', '2', NULL, '2024-11-15 12:04:04'),
(32, 20, 'Check In', 'R-jhel Tandugon', '1', NULL, '2024-11-15 12:07:13'),
(33, 20, 'Check Out', 'Billing Office', '2', NULL, '2024-11-15 12:08:07'),
(34, 51, 'Check In', '', '12', NULL, '2024-11-15 15:42:20'),
(35, 52, 'Check In', '', '14 packs', NULL, '2024-11-18 11:35:09'),
(36, 52, 'Check Out', 'Lionel ', '14', NULL, '2024-11-18 11:45:12'),
(37, 52, 'Check In', 'R-jhel Tandugon', '14', NULL, '2024-11-18 11:46:28'),
(38, 53, 'Check In', '', '100', NULL, '2024-11-18 12:01:30'),
(39, 54, 'Check In', '', '50', NULL, '2024-11-18 12:04:23'),
(40, 0, 'Check In', 'R-jhel Tandugon', '50', NULL, '2024-11-18 12:06:22'),
(41, 56, 'Check In', 'R-jhel Tandugon', '5', NULL, '2024-11-18 12:07:35'),
(42, 49, 'Check Out', 'Tests', '2', NULL, '2024-11-18 14:45:08'),
(43, 14, 'Check Out', 'Tests', '5', NULL, '2024-11-18 14:45:27'),
(44, 57, 'Check In', 'R-jhel Tandugon', '1', NULL, '2024-11-19 17:10:11'),
(45, 57, 'Check Out', 'Dra Tonette', '1', NULL, '2024-11-19 17:12:28'),
(46, 57, 'Check In', 'R-jhel Tandugon', '1', NULL, '2024-11-19 17:15:05'),
(47, 58, 'Check In', 'R-jhel Tandugon', '', NULL, '2024-11-22 13:54:37'),
(48, 48, 'Check Out', 'TEsts', '300', NULL, '2024-11-22 16:11:03'),
(49, 35, 'Check Out', 'TEstss', '21', NULL, '2024-11-22 16:11:43'),
(50, 35, 'Check Out', 'TEstts', '45', NULL, '2024-11-22 16:12:05'),
(51, 34, 'Check Out', 'By testing', '20', NULL, '2024-11-22 16:12:34'),
(52, 52, 'Check Out', 'By Testing', '4', NULL, '2024-11-21 16:13:13'),
(53, 56, 'Check Out', 'Testing', '4', NULL, '2024-11-22 16:13:41'),
(54, 48, 'Check Out', 'qweerty', '100', NULL, '2024-11-21 16:14:08'),
(55, 48, 'Check Out', 'asdfdf', '50', NULL, '2024-11-21 16:14:30'),
(56, 52, 'Check Out', 'R-jhel', '5', NULL, '2024-11-22 16:15:45'),
(57, 47, 'Check Out', 'zxcxcxc', '32', NULL, '2024-11-23 16:16:36'),
(58, 15, 'Check Out', 'lkjhg', '1', NULL, '2024-11-22 16:17:39'),
(59, 52, 'Check Out', 'cvbnm', '1', NULL, '2024-11-22 16:17:58'),
(60, 52, 'Check Out', 'mnmbnb', '1', NULL, '2024-11-22 16:18:17'),
(61, 52, 'Check Out', 'fgfdg', '1', NULL, '2024-11-22 16:18:34'),
(62, 52, 'Check In', 'R-jhel Tandugon', '1', NULL, '2024-11-22 17:29:45'),
(63, 58, 'Check Out', 'Jerome', '1', NULL, '2024-11-30 13:59:31'),
(64, 58, 'Check Out', 'R-jhel Tandugon', '41', NULL, '2024-11-30 09:09:48'),
(65, 58, 'Check Out', 'R-jhel Tandugon', '28', NULL, '2024-11-30 17:13:21'),
(66, 57, 'Check Out', 'R-jhel Tandugon', '38', NULL, '2024-11-30 17:31:24'),
(67, 57, 'Check Out', 'R-jhel Tandugon', '20', NULL, '2024-11-30 17:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `file_name`, `file_type`) VALUES
(1, 'Screenshot 2024-10-22 154413.png', 'image/png'),
(2, 'Screenshot 2024-11-11 162243.png', 'image/png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `description` text,
  `status` varchar(25) NOT NULL,
  `where_found` varchar(100) DEFAULT NULL,
  `checkin_by` varchar(100) DEFAULT NULL,
  `checkin_date` date DEFAULT NULL,
  `checkin_room` varchar(100) DEFAULT NULL,
  `checkin_location` varchar(100) DEFAULT NULL,
  `checkin_location_barcode` varchar(100) DEFAULT NULL,
  `checkin_item_barcode` varchar(100) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `action` varchar(25) DEFAULT NULL,
  `categorie_id` int UNSIGNED NOT NULL,
  `media_id` int DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `description`, `status`, `where_found`, `checkin_by`, `checkin_date`, `checkin_room`, `checkin_location`, `checkin_location_barcode`, `checkin_item_barcode`, `comments`, `action`, `categorie_id`, `media_id`, `date`) VALUES
(14, 'Laptop Dell Inspiron', '2', 'Dell Inspiron', 'Works', 'Business Office', 'R-jhel', '2024-10-22', 'N/A', 'N/A', 'N/A', '01111', 'N/A', 'Check In', 9, 1, '2024-10-23 04:03:15'),
(15, 'Printer', '2', 'Canon, G1010', '?', 'COH Office', 'R-jhel', '2024-10-22', 'N/A', 'N/A', 'N/A', NULL, '', 'Check In', 9, 1, '2024-10-23 12:11:53'),
(16, 'Monitor', '1', 'Dell', 'Works', 'Business Office', 'R-jhel', '2024-10-22', 'N/A', 'N/A', 'N/A', NULL, '', 'Check In', 9, 1, '2024-10-23 12:19:22'),
(17, 'Keyboard', '3', 'Wireless Keyboard', 'Works', 'COH Office', 'R-jhel Tandugon', '2024-10-25', 'N/A', 'N/A', 'N/A', NULL, 'test comment', 'Check In', 9, 0, '2024-10-25 11:48:57'),
(19, 'Bulb', '5', 'Akari', 'Works', '2nd Floor', 'R-jhel Tandugon', '2024-10-25', 'N/A', 'N/A', '22222222', '5678uio', 'comment 5', 'Check In', 12, 0, '2024-10-25 12:02:30'),
(20, 'Scanner', '0', 'eyfueug', 'Works', 'COH Office', 'R-jhel Tandugon', '2025-10-26', 'N/A', 'N/A', '', NULL, '', 'Check In', 9, 0, '2024-10-25 12:04:52'),
(32, 'Item test1', '241', 'Tests1', 'Don\'t Work', 'qwewewwew', 'asddfdfd', '2024-11-06', 'asddfg', 'vczxcxzvxzv', '', 'sdfsasafs', '', 'Check In', 13, 0, '2024-11-05 07:30:45'),
(33, 'Item tests2', '12', '', 'Works', '', '', '2024-11-06', '', '', '', NULL, '', 'Check In', 13, 1, '2024-11-05 08:42:20'),
(34, 'Item test3', '230', '', '?', '', '', '2024-11-06', '', '', '', NULL, '', 'Check In', 13, 0, '2024-11-05 08:52:59'),
(35, 'dsfdfdf', '500', '', 'Works', '', '', '2024-11-06', '', '', '', NULL, '', 'Check In', 12, 0, '2024-11-05 09:03:35'),
(37, 'Battery', '180', 'Sony', 'Works', 'N/A', '1', '2024-11-11', 'N/A', 'N/A', 'N/A', NULL, 'Check In Battery by R-jhel', 'Check In', 9, 1, '2024-11-11 08:14:59'),
(38, 'Short Bond Paper', '50', 'Copy, Reams', 'N/A', '2nd Floor', 'R-jhel Tandugon', '2024-11-11', 'N/A', 'N/A', 'N/A', '', 'R-jhel- Check in Bond Paper 50 rims', 'Check In', 9, 2, '2024-11-11 08:27:42'),
(43, 'Long Bond Paper', '96', 'Copier, Reams', 'N/A', '2nd Floor', 'R-jhel Tandugon', '2024-11-12', 'N/A', 'N/A', 'N/A', '', 'R-jhel- Check in Long Bond Paper 50 rims', 'Check In', 9, 2, '2024-11-11 08:44:20'),
(47, 'Pen', '68', '', 'N/A', 'N/A', 'R-jhel Tandugon', '2024-11-12', 'N/A', 'N/A', 'N/A', 'N/A', '', 'Check In', 9, 1, '2024-11-12 09:13:44'),
(48, 'Tests', '545', '', '', '', 'R-jhel Tandugon', '2024-11-14', '', '', '', NULL, '', 'Check In', 13, 0, '2024-11-12 10:01:00'),
(49, 'Bins', '2', '', 'N/A', 'N/A', 'Tests User', '2024-11-15', 'Outside Storage', 'N/A', 'N/A', NULL, '', 'Check In', 12, 1, '2024-11-15 03:11:02'),
(50, 'Computer Mouse', '0', 'Mini', 'Works', 'Business Office', 'R-jhel Tandugon', '2024-11-15', 'Outside Storage', 'N/A', 'N/A', NULL, '', 'Check In', 9, 1, '2024-11-15 11:50:21'),
(52, 'Food Trays', '0', '14 Packs', 'N/A', 'N/A', 'R-jhel Tandugon', '2024-11-18', 'COH Office', 'N/A', '', '', 'None', 'Check In', 11, 1, '2024-11-18 11:35:09'),
(56, 'Blood Collection Tubes', '40', '5 packs', 'N/A', 'N/A', 'R-jhel Tandugon', '2024-11-18', '', '', '', '', '', 'Check In', 10, 1, '2024-11-18 12:07:35'),
(57, 'Radio', '40', 'Radio shock, 100 AFM Radio', 'Works', 'N/A', 'R-jhel Tandugon', '2024-11-19', 'COH', 'N/A', 'N/A', '', '', 'Check In', 14, 0, '2024-11-19 17:10:11'),
(58, 'Item1', '30', '', '', '', 'R-jhel Tandugon', '2024-11-28', '', '', '', '', '', 'Check In', 13, 0, '2024-11-22 13:54:37');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `request_by` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `quantity` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dueback_date` date DEFAULT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `date_request` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `item_id`, `request_by`, `quantity`, `dueback_date`, `comments`, `date_request`, `action`) VALUES
(6, 14, '9', '5', '2024-12-06', '', '2024-11-22 03:08:37', 'Approve'),
(7, 14, 'Dana Alyka Alde', '100', NULL, '', '2024-11-22 03:41:15', 'Approve'),
(9, 57, 'Dana Alyka Alde', '1', NULL, '', '2024-11-29 07:33:26', 'Approve'),
(10, 52, 'Dana Alyka Alde', '2', NULL, '', '2024-11-29 08:01:30', 'Approve'),
(11, 50, 'Dana Alyka Alde', '1', '2024-12-06', 'None', '2024-11-30 04:47:21', 'Approve'),
(12, 52, 'Dana Alyka Alde', '1', '2024-12-05', 'Tests\r\n', '2024-11-30 05:21:12', 'Approve'),
(13, 48, 'Dana Alyka Alde', '10', '2024-12-07', 'None', '2024-11-30 05:23:20', 'Approve'),
(14, 17, 'Dana Alyka Alde', '1', '2024-12-06', 'Comments1', '2024-11-30 05:25:52', 'Approve'),
(15, 52, 'Dana Alyka Alde', '1', '2024-12-07', 'Test Comment', '2024-11-30 05:43:53', 'Approve'),
(16, 56, 'Dana Alyka Alde', '1', '2024-12-07', 'qwerty', '2024-11-30 05:46:44', 'Approve'),
(17, 14, 'Dana Alyka Alde', '1', '2024-12-07', 'Can I request laptop for ER', '2024-11-30 05:51:14', 'Approve'),
(18, 57, 'Dana Alyka Alde', '2', '2024-12-07', 'asdf', '2024-11-30 05:53:10', 'Approve'),
(19, 56, 'Dana Alyka Alde', '20', '2024-12-31', 'Can I request?', '2024-11-30 06:02:52', 'Approve'),
(20, 56, 'Dana Alyka Alde', '40', '2025-01-11', 'Requests from ER', '2024-11-30 06:06:39', 'Approve'),
(21, 58, 'Dana Alyka Alde', '41', '2024-12-06', 'zxcv', '2024-11-30 09:09:30', 'Approve'),
(22, 58, 'Dana Alyka Alde', '28', NULL, '', '2024-11-30 09:12:33', 'Approve'),
(23, 57, 'Dana Alyka Alde', '38', NULL, '', '2024-11-30 09:31:02', 'Approve'),
(24, 57, 'Dana Alyka Alde', '20', NULL, '', '2024-11-30 09:32:25', 'Approve');

-- --------------------------------------------------------

--
-- Table structure for table `requests_log`
--

CREATE TABLE `requests_log` (
  `id` int NOT NULL,
  `item_id` int DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `request_by` varchar(100) DEFAULT NULL,
  `quantity` varchar(20) DEFAULT NULL,
  `date_request` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `requests_log`
--

INSERT INTO `requests_log` (`id`, `item_id`, `action`, `request_by`, `quantity`, `date_request`) VALUES
(1, 52, 'Request', 'Dana Alyka Alde', '2', '2024-11-29 08:01:30'),
(2, 52, 'Approve', 'R-jhel Tandugon', '1', '2024-11-29 08:07:16'),
(3, 50, 'Request', 'Dana Alyka Alde', '1', '2024-11-30 04:47:21'),
(4, 50, 'Approve', 'R-jhel Tandugon', '1', '2024-11-30 05:14:13'),
(5, 57, 'Approve', 'R-jhel Tandugon', '1', '2024-11-30 05:17:57'),
(6, 52, 'Request', 'Dana Alyka Alde', '1', '2024-11-30 05:21:12'),
(7, 48, 'Request', 'Dana Alyka Alde', '10', '2024-11-30 05:23:20'),
(8, 48, 'Approve', 'R-jhel Tandugon', '5', '2024-11-30 05:24:05'),
(9, 17, 'Request', 'Dana Alyka Alde', '1', '2024-11-30 05:25:52'),
(10, 17, 'Approve', 'R-jhel Tandugon', '1', '2024-11-30 05:26:05'),
(11, 52, 'Approve', 'R-jhel Tandugon', '1', '2024-11-30 05:37:08'),
(12, 52, 'Request', 'Dana Alyka Alde', '1', '2024-11-30 05:43:53'),
(13, 52, 'Approve', 'R-jhel Tandugon', '1', '2024-11-30 05:44:17'),
(14, 56, 'Request', 'Dana Alyka Alde', '1', '2024-11-30 05:46:44'),
(15, 56, 'Approve', 'R-jhel Tandugon', '1', '2024-11-30 05:47:19'),
(16, 14, 'Request', 'Dana Alyka Alde', '1', '2024-11-30 05:51:14'),
(17, 14, 'Approve', 'R-jhel Tandugon', '1', '2024-11-30 05:51:33'),
(18, 57, 'Request', 'Dana Alyka Alde', '2', '2024-11-30 05:53:10'),
(19, 57, 'Approve', 'R-jhel Tandugon', '2', '2024-11-30 05:56:55'),
(20, 56, 'Request', 'Dana Alyka Alde', '20', '2024-11-30 06:02:52'),
(21, 56, 'Approve', 'R-jhel Tandugon', '20', '2024-11-30 06:03:18'),
(22, 56, 'Request', 'Dana Alyka Alde', '40', '2024-11-30 06:06:39'),
(23, 56, 'Approve', 'R-jhel Tandugon', '40', '2024-11-30 06:06:59'),
(24, 58, 'Request', 'Dana Alyka Alde', '41', '2024-11-30 09:09:30'),
(25, 58, 'Approve', 'R-jhel Tandugon', '41', '2024-11-30 09:09:48'),
(26, 58, 'Request', 'Dana Alyka Alde', '28', '2024-11-30 09:12:33'),
(27, 58, 'Approve', 'R-jhel Tandugon', '28', '2024-11-30 17:13:21'),
(28, 57, 'Request', 'Dana Alyka Alde', '38', '2024-11-30 09:31:02'),
(29, 57, 'Approve', 'R-jhel Tandugon', '38', '2024-11-30 17:31:24'),
(30, 57, 'Request', 'Dana Alyka Alde', '20', '2024-11-30 09:32:25'),
(31, 57, 'Approve', 'R-jhel Tandugon', '20', '2024-11-30 17:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'R-jhel Tandugon', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, '2024-12-02 15:30:38'),
(6, 'Tests User', 'tests', '04d13fd0aa6f0197cf2c999019a607c36c81eb9f', 2, 'jcqb6kfe6.png', 1, '2024-12-02 16:36:17'),
(7, 'Test User 2', 'test2', '109f4b3c50d7b0df729d299bc6f8e9ef9066971f', 2, '9g0ktpz7.png', 1, '2024-11-16 16:29:35'),
(8, 'Lionel Adal', 'lionel', '5befb0748e190886505727a102475cc24fbaa116', 1, 'no_image.jpg', 1, '2024-11-30 17:36:07'),
(9, 'Dana Alyka Alde', 'dana', '1cb970812cb29b59faf5b8a36713647f0e484d61', 3, 'u68w4jt9.png', 1, '2024-12-02 14:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int NOT NULL,
  `group_status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'Standard', 2, 1),
(4, 'Viewer', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `checkin_logs`
--
ALTER TABLE `checkin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `check_out`
--
ALTER TABLE `check_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inout_logs`
--
ALTER TABLE `inout_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests_log`
--
ALTER TABLE `requests_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_level` (`user_level`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `checkin_logs`
--
ALTER TABLE `checkin_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_out`
--
ALTER TABLE `check_out`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `inout_logs`
--
ALTER TABLE `inout_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `requests_log`
--
ALTER TABLE `requests_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
