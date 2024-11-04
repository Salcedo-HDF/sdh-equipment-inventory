-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 10:10 AM
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
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(13, 'Cleaning Supplies'),
(12, 'Construction Supplies'),
(11, 'Dietary Supplies '),
(10, 'Medical Supplies'),
(9, 'Office Supplies');

-- --------------------------------------------------------

--
-- Table structure for table `checkin_logs`
--

CREATE TABLE `checkin_logs` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `quantity` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `where_found` varchar(100) DEFAULT NULL,
  `checkin_by` varchar(100) DEFAULT NULL,
  `checkin_date` date DEFAULT NULL,
  `checkin_room` varchar(100) DEFAULT NULL,
  `checkin_location` varchar(100) DEFAULT NULL,
  `checkin_location_barcode` varchar(100) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `check_out`
--

CREATE TABLE `check_out` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `checkout_by` varchar(100) NOT NULL,
  `checkout_date` date NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `due_back_date` date NOT NULL,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `check_out`
--

INSERT INTO `check_out` (`id`, `item_id`, `checkout_by`, `checkout_date`, `quantity`, `due_back_date`, `comments`) VALUES
(2, 15, 'R-jhel B.', '2024-10-25', '1', '0000-00-00', 'qwerty'),
(6, 19, 'Kuya Angelo', '2024-10-25', '6', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `action` varchar(20) NOT NULL,
  `user` varchar(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `action_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `item_id`, `action`, `user`, `quantity`, `comments`, `action_date`) VALUES
(1, 17, 'Check In', 'R-jhel Tand', 2, NULL, '2024-10-25 03:57:49'),
(2, 19, 'Check In', 'R-jhel Tand', 12, NULL, '2024-10-25 04:02:30'),
(3, 20, 'Check In', 'R-jhel Tand', 2, NULL, '2024-10-25 04:04:52'),
(4, 19, 'Check Out', 'Kuya Angelo', 6, NULL, '2024-10-24 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `file_name`, `file_type`) VALUES
(1, 'Screenshot 2024-10-22 154413.png', 'image/png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
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
  `categorie_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `description`, `status`, `where_found`, `checkin_by`, `checkin_date`, `checkin_room`, `checkin_location`, `checkin_location_barcode`, `checkin_item_barcode`, `comments`, `action`, `categorie_id`, `media_id`, `date`) VALUES
(14, 'Laptop Dell Inspiron', '142', 'Dell Inspiron', 'Works', 'Business Office', 'R-jhel', '2024-10-22', 'N/A', 'N/A', 'N/A', '01111', 'N/A', 'Check In', 9, 1, '2024-10-23 04:03:15'),
(15, 'Printer', '2', 'Canon, G1010', '?', 'COH Office', 'R-jhel', '2024-10-22', 'N/A', 'N/A', 'N/A', NULL, '', 'Check In', 9, 1, '2024-10-23 12:11:53'),
(16, 'Monitor', '1', 'Dell', 'Works', 'Business Office', 'R-jhel', '2024-10-22', 'N/A', 'N/A', 'N/A', NULL, '', 'Check In', 9, 1, '2024-10-23 12:19:22'),
(17, 'Keyboard', '4', 'Wireless Keyboard', 'Works', 'COH Office', 'R-jhel Tandugon', '2024-10-25', 'N/A', 'N/A', 'N/A', NULL, 'test comment', 'Check In', 9, 0, '2024-10-25 11:48:57'),
(19, 'Bulb', '6', 'Akari', 'Works', '2nd Floor', 'R-jhel Tandugon', '2024-10-25', 'N/A', 'N/A', '22222222', NULL, 'comment 5', 'Check In', 12, 0, '2024-10-25 12:02:30'),
(20, 'Scanner', '2', 'eyfueug', 'Works', 'COH Office', 'R-jhel Tandugon', '2025-10-26', 'N/A', 'N/A', '', NULL, '', 'Check In', 9, 0, '2024-10-25 12:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'R-jhel Tandugon', 'SDH-Admin', '6151b82fb3e57e8274f9f2f53e4d9f4daab30ee7', 1, 'no_image.png', 1, '2024-10-29 03:34:26'),
(6, 'R-jhel Tandugon', 'tests', '04d13fd0aa6f0197cf2c999019a607c36c81eb9f', 2, 'jcqb6kfe6.png', 1, '2024-10-23 08:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'special', 2, 1);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `checkin_logs`
--
ALTER TABLE `checkin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `check_out`
--
ALTER TABLE `check_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
