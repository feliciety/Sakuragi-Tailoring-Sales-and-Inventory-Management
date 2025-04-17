-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2025 at 08:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sakuragi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branch_id` bigint(20) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `location` text NOT NULL,
  `phone_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `shift` enum('Morning','Afternoon','Night') NOT NULL,
  `hire_date` date NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `status` enum('Active','Resigned','Terminated') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` bigint(20) NOT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `supplier_id` bigint(20) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) DEFAULT 10,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(100) NOT NULL,
  `unit` varchar(50) DEFAULT 'pcs'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) NOT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `employee_id` bigint(20) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','In Progress','Completed','Cancelled','Refunded') DEFAULT 'Pending',
  `total_price` decimal(10,2) NOT NULL,
  `payment_status` enum('Pending','Paid','Refunded') DEFAULT 'Pending',
  `expected_completion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` bigint(20) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) DEFAULT 'PHP',
  `payment_method` enum('Cash','Card','Online Transfer','Crypto') NOT NULL,
  `status` enum('Pending','Completed','Failed','Refunded') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` enum('admin','manager','employee','customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` bigint(20) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `status` enum('Active','Inactive','Suspended') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `branch_id`, `role_id`, `full_name`, `email`, `password`, `phone_number`, `status`, `created_at`) VALUES
(0, NULL, 2, 'New User', 'cjaylao447@gmail.com', '$2y$10$CR57kWDTlOwkPVlr.KP2fuxl1.2c4QZgssMHonh0nsI43cuerCfpK', '0000000000', 'Active', '2025-04-13 10:27:35'),
(0, NULL, 2, 'New User', 'cjaylao407@gmail.com', '$2y$10$OsPFvRTX.ndBDp.Mz5vLh.fJWvs09do8Mif1ylaP/TcIP7chuh7/m', '0000000000', 'Active', '2025-04-13 10:27:42'),
(0, NULL, 2, 'New User', 'cjaylao123@gmail.com', '$2y$10$f8H6cOSyzW2l.R00uusx2u14TfAuq94oFd7WBM7bE2QWUsrLn4Xg2', '0000000000', 'Active', '2025-04-13 10:28:09'),
(0, NULL, 2, 'New User', 'cjaylao321@gmail.com', '$2y$10$l.GumCipAn7ALTj4h8rBe.dBNuYiY8cvuqlxKB.HsC0rF7d24zcl.', '0000000000', 'Active', '2025-04-13 10:28:27'),
(0, NULL, 2, 'New User', 'cjaylao7@gmail.com', '$2y$10$XT/XPliopOkcnbxrP6QQMeD5quNB1DF28y0L93I5XnThUMh6SfrKG', '0000000000', 'Active', '2025-04-13 10:28:45'),
(0, NULL, 2, 'New User', 'cjaylao07@gmail.com', '$2y$10$YD2opd7TADYQ6vEVHMT.7eoqIdksAzOVSmtOmA8stcLdUy4/1FL3O', '0000000000', 'Active', '2025-04-13 10:29:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD UNIQUE KEY `material_name` (`material_name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `branch_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`branch_id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`),
  ADD CONSTRAINT `inventory_ibfk_3` FOREIGN KEY (`material_id`) REFERENCES `materials` (`material_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
