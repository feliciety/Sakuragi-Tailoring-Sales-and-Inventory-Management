-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 02:06 PM
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
-- Database: `sakuragits_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

-- Updated sakuragits_db schema

CREATE TABLE `users` (
  `user_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `branch_id` BIGINT(20) DEFAULT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(20) NOT NULL,
  `shipping_address` TEXT DEFAULT NULL, -- 🆕 Added shipping address
  `role` ENUM('admin','customer') DEFAULT 'customer',
  `status` ENUM('Active','Inactive','Suspended') DEFAULT 'Active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `orders` (
  `order_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT(20) NOT NULL,
  `order_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('Pending','In Progress','Completed','Cancelled','Refunded') DEFAULT 'Pending',
  `total_price` DECIMAL(10,2) NOT NULL,
  `payment_status` ENUM('Pending','Paid','Refunded') DEFAULT 'Pending',
  `expected_completion` DATE DEFAULT NULL,
  `free_shirts` INT(11) DEFAULT 0,
  `coupon_code` VARCHAR(50) DEFAULT NULL, -- 🆕 Optional coupon
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `order_items` (
  `item_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT(20) NOT NULL,
  `service_type` VARCHAR(100) NOT NULL,
  `size` ENUM('XXS','XS','S','M','L','XL','XXL') NOT NULL,
  `quantity` INT(11) NOT NULL DEFAULT 1,
  `price_per_unit` DECIMAL(10,2) NOT NULL,
  `is_free` TINYINT(1) DEFAULT 0,
  `custom_details` TEXT DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `branch_id`, `full_name`, `email`, `password`, `phone_number`, `role`, `status`, `created_at`) VALUES
(1, NULL, 'feanneMalasarte', 'fe@example.com', '$2y$10$jGEt4isGQUgFD1lyyhWscusrMzHHHBGgFfneQFk1qw2G5Tne6CyrC', '09758373702', 'customer', 'Active', '2025-04-18 09:29:47'),
(2, NULL, 'fefe', 'fefe@example.com', '$2y$10$JW3qwb1B6TQr3MP8W2izWeJxeLTChlT4yzKEPJ7AkR4ng0.OKpF7O', '09758373702', 'customer', 'Active', '2025-04-18 13:24:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
