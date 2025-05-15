-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 10:43 AM
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
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` bigint(20) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `total_hours` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `log_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branch_id`, `branch_name`, `location`, `phone_number`) VALUES
(1, 'Main', '123 Main St', '0921612456'),
(2, 'Davao', '456 Davao St', '0987654321'),
(3, 'Kidapawan', '789 Kidapawan St', '0921654652'),
(4, 'Tagum', '123 Tagum St', '09123456789'),
(1, 'Main', '123 Main St', '0921612456'),
(2, 'Davao', '456 Davao St', '0987654321'),
(3, 'Kidapawan', '789 Kidapawan St', '0921654652'),
(4, 'Tagum', '123 Tagum St', '09123456789'),
(1, 'Main', '123 Main St', '0921612456'),
(2, 'Davao', '456 Davao St', '0987654321'),
(3, 'Kidapawan', '789 Kidapawan St', '0921654652'),
(4, 'Tagum', '123 Tagum St', '09123456789');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `branch_id` bigint(20) NOT NULL,
  `position` varchar(100) NOT NULL,
  `department` enum('Tailoring','Printing','Customer Service','Admin') NOT NULL,
  `shift` enum('Morning','Afternoon','Evening') NOT NULL,
  `hire_date` date NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `status` enum('Active','Resigned','Terminated') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `review_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comments` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` bigint(20) NOT NULL,
  `branch_id` bigint(20) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `category` enum('Fabric','Thread','Ink','Accessories') NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) DEFAULT 10,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `branch_id`, `item_name`, `supplier_id`, `category`, `quantity`, `reorder_level`, `last_updated`) VALUES
(1, 1, 'White Linen Fabric', 1, 'Fabric', 20, 10, '2025-05-05 00:00:00'),
(2, 1, 'Black Nylon Thread', 2, 'Thread', 15, 10, '2025-05-04 00:00:00'),
(3, 1, 'Blue Denim Fabric', 3, 'Fabric', 30, 10, '2025-05-03 00:00:00'),
(4, 1, 'Green Silk Ribbon', 4, 'Accessories', 8, 10, '2025-05-02 00:00:00'),
(5, 1, 'Yellow Cotton Yarn', 5, 'Accessories', 25, 10, '2025-05-01 00:00:00'),
(6, 2, 'Black Nylon Thread', 2, 'Thread', 97, 155, '2025-05-15 08:33:20'),
(7, 2, 'White Linen Fabric', 2, 'Ink', 82, 10, '2025-05-15 08:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_stock_log`
--

CREATE TABLE `inventory_stock_log` (
  `log_id` bigint(20) NOT NULL,
  `inventory_id` bigint(20) NOT NULL,
  `change_type` enum('in','out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `supplier_id` bigint(20) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_stock_log`
--

INSERT INTO `inventory_stock_log` (`log_id`, `inventory_id`, `change_type`, `quantity`, `supplier_id`, `note`, `created_at`) VALUES
(1, 1, 'in', 10, 1, 'Initial stock', '2025-05-01 10:00:00'),
(2, 1, 'out', 5, NULL, 'Sample out', '2025-05-02 10:00:00'),
(3, 2, 'in', 20, 2, 'Initial stock', '2025-05-01 10:00:00'),
(4, 2, 'out', 10, NULL, 'Sample out', '2025-05-02 10:00:00'),
(5, 3, 'in', 15, 3, 'Initial stock', '2025-05-01 10:00:00'),
(6, 3, 'out', 5, NULL, 'Sample out', '2025-05-02 10:00:00'),
(7, 4, 'in', 25, 4, 'Initial stock', '2025-05-01 10:00:00'),
(8, 4, 'out', 10, NULL, 'Sample out', '2025-05-02 10:00:00'),
(9, 5, 'in', 30, 5, 'Initial stock', '2025-05-01 10:00:00'),
(10, 5, 'out', 15, NULL, 'Sample out', '2025-05-02 10:00:00'),
(11, 6, 'in', 10, 2, '', '2025-05-15 07:38:02'),
(12, 6, 'out', 50, NULL, '', '2025-05-15 07:38:08'),
(13, 6, 'in', 20, 2, '', '2025-05-15 07:38:16'),
(14, 6, 'in', 20, 2, '', '2025-05-15 07:38:19'),
(15, 6, 'in', 50, 2, '', '2025-05-15 07:38:26'),
(16, 6, 'out', 20, NULL, '', '2025-05-15 07:39:44'),
(17, 6, 'in', 10, 2, '', '2025-05-15 07:39:52'),
(18, 6, 'in', 10, 2, '', '2025-05-15 07:43:19'),
(19, 6, 'out', 10, NULL, '', '2025-05-15 07:43:23'),
(20, 6, 'out', 20, NULL, '', '2025-05-15 07:49:50'),
(21, 6, 'out', 50, NULL, '', '2025-05-15 07:49:54'),
(22, 6, 'in', 20, 2, '', '2025-05-15 07:49:59'),
(23, 6, 'in', 50, 2, '', '2025-05-15 07:50:01'),
(24, 6, 'in', 20, 2, '', '2025-05-15 07:59:18'),
(25, 6, 'in', 55, 2, '', '2025-05-15 08:00:56'),
(27, 6, 'in', 22, 2, '', '2025-05-15 08:03:27'),
(28, 6, 'out', 25, NULL, '', '2025-05-15 08:03:32'),
(29, 6, 'in', 22, 1, '', '2025-05-15 08:08:16'),
(30, 6, 'in', 25, NULL, '', '2025-05-15 08:09:59'),
(31, 6, 'out', 100, NULL, '', '2025-05-15 08:10:04'),
(32, 6, 'out', 19, NULL, '', '2025-05-15 08:10:10'),
(33, 6, 'in', 1999, NULL, '', '2025-05-15 08:10:27'),
(34, 6, 'out', 1888, NULL, '', '2025-05-15 08:12:16'),
(35, 6, 'out', 1888, NULL, '', '2025-05-15 08:12:16'),
(36, 6, 'in', 222, NULL, '', '2025-05-15 08:12:23'),
(37, 6, 'in', 1400, NULL, '', '2025-05-15 08:12:27'),
(38, 6, 'in', 155, NULL, '', '2025-05-15 08:12:31'),
(39, 6, 'in', 155, NULL, '', '2025-05-15 08:12:34'),
(40, 6, 'in', 155, NULL, '', '2025-05-15 08:12:38'),
(41, 6, 'out', 155, NULL, '', '2025-05-15 08:12:46'),
(42, 6, 'out', 155, NULL, '', '2025-05-15 08:12:49'),
(43, 7, 'in', 55, NULL, '', '2025-05-15 08:15:13'),
(44, 7, 'in', 12, NULL, '', '2025-05-15 08:15:18'),
(45, 6, 'in', 22, 2, '', '2025-05-15 08:18:16'),
(46, 6, 'in', 50, 2, '', '2025-05-15 08:27:41'),
(47, 6, 'in', 25, 2, '', '2025-05-15 08:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('Paid','Pending','Overdue') DEFAULT 'Pending',
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loyalty`
--

CREATE TABLE `loyalty` (
  `loyalty_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `total_orders` int(11) NOT NULL DEFAULT 0,
  `free_shirts_earned` int(11) NOT NULL DEFAULT 0,
  `free_shirts_claimed` int(11) NOT NULL DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Sent','Pending','Failed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) NOT NULL,
  `branch_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `employee_id` bigint(20) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','In Progress','Completed','Cancelled','Refunded') DEFAULT 'Pending',
  `total_price` decimal(10,2) NOT NULL,
  `payment_status` enum('Pending','Paid','Refunded') DEFAULT 'Pending',
  `expected_completion` date DEFAULT NULL,
  `design_file_id` bigint(20) DEFAULT NULL,
  `service_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `service_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_workflow`
--

CREATE TABLE `order_workflow` (
  `workflow_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `stage` enum('Designing','Printing','Embroidery','Quality Check','Packaging','Shipped') DEFAULT 'Designing',
  `assigned_employee` bigint(20) DEFAULT NULL,
  `expected_completion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('GCash','Bank Transfer','Cash') NOT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `proof_file_name` varchar(255) DEFAULT NULL,
  `proof_file_path` varchar(255) DEFAULT NULL,
  `status` enum('Pending Verification','Verified','Rejected') DEFAULT 'Pending Verification',
  `verified_by` bigint(20) DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `admin_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` bigint(20) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `service_description` text DEFAULT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `service_category` enum('Embroidery','Sublimation','Screen Printing','Alterations','Patches') NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `service_description`, `service_price`, `service_category`, `is_active`) VALUES
(1, 'Embroidery', 'High-quality embroidery services for custom designs.', 500.00, 'Embroidery', 1),
(2, 'Sublimation', 'Custom sublimation printing for vibrant designs.', 750.00, 'Sublimation', 1),
(3, 'Screen Printing', 'Durable screen printing for various materials.', 600.00, 'Screen Printing', 1),
(4, 'Alterations', 'Professional alterations for a perfect fit.', 300.00, 'Alterations', 1),
(5, 'Patches', 'Custom patches for clothing and accessories.', 400.00, 'Patches', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `delivery_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `courier_name` varchar(255) NOT NULL,
  `tracking_number` varchar(50) NOT NULL,
  `delivery_status` enum('Pending','Shipped','Delivered','Returned') DEFAULT 'Pending',
  `estimated_arrival` date DEFAULT NULL,
  `actual_delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sizes_pricing`
--

CREATE TABLE `sizes_pricing` (
  `id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes_pricing`
--

INSERT INTO `sizes_pricing` (`id`, `size`, `quantity`, `price`) VALUES
(1, 'Small', 1, 200.00),
(2, 'Medium', 1, 200.00),
(3, 'Large', 1, 200.00);

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
  `address` text NOT NULL,
  `materials_supplied` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `contact_person`, `phone_number`, `email`, `address`, `materials_supplied`) VALUES
(1, 'Global Supply Co.', 'John Doe', '1234567890', 'global1@globalsupply.com', '123 Global St.', 'Material 1, Material 2'),
(2, 'Elite Suppliers', 'Jane Smith', '0987654321', 'elite1@elitesuppliers.com', '456 Elite Ave.', 'Material 3, Material 4'),
(3, 'Premier Supply Group', 'Michael Johnson', '1122334455', 'premier1@premiersupply.com', '789 Premier Blvd.', 'Material 5, Material 6'),
(4, 'NextGen Suppliers', 'Emily Davis', '2233445566', 'nextgen1@nextgensuppliers.com', '321 NextGen Rd.', 'Material 7, Material 8'),
(5, 'Reliable Supply Hub', 'David Wilson', '3344556677', 'reliable1@reliablesupply.com', '654 Reliable Ln.', 'Material 9, Material 10');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `uploads_id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` bigint(20) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL,
  `branch_id` bigint(20) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `role` enum('admin','manager','employee','customer') DEFAULT 'customer',
  `status` enum('Active','Inactive','Suspended') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `branch_id`, `full_name`, `email`, `password`, `phone_number`, `role`, `status`, `created_at`) VALUES
(1, NULL, 'Fe Anne L. Malasarte', 'fe@example.com', '$2y$10$va1D.8msOF/WcP/ReyQ/CODkQGlnd7G1ZDOFTuTHCelmlknp0JOWS', '09758373702', 'customer', 'Active', '2025-04-29 07:06:43'),
(2, NULL, 'admin', 'admin@example.com', '$2y$10$tuHBZXcGSM8bMupz1fN1V.kLI55u0GdphzhuSlIQJQYeq3OSmK1Cm', '12344321', 'customer', 'Active', '2025-04-29 08:02:21'),
(3, NULL, 'employee', 'employee@example.com', '$2y$10$5OO4Qf4q8Wq5XKasRP4X4uQk19rnUFPk5eSKSyBWV7/Q8Ve0TOc12', '09758373702', 'customer', 'Active', '2025-04-30 15:40:19'),
(4, NULL, 'Cjay Lao', 'a@gmail.com', '$2y$10$nFmm5sanK4RIYc8e9e7ag.QOpWgjTq4w31y8YUbyZ3BvrxL3UJDDS', '0953478378', 'admin', 'Active', '2025-05-07 02:05:44'),
(5, NULL, 'Jay Employee', 'e@gmail.com', '$2y$10$NlrQL.v8Yij1QIeF/HM1u.7PwVQyRTOgEPKQ5i6cKYOxF1s0ntrAO', '09237182378', 'employee', 'Active', '2025-05-07 02:06:10'),
(6, NULL, 'Customer Jay', 'C@gmail.com', '$2y$10$R./38BJtTrFoqnAgNQjjUeAnzbBCtticH0DRDd5.k2whEoZ0Ykona', '1230981293', 'customer', 'Active', '2025-05-07 02:06:30'),
(7, NULL, 'Jay lao', 'jay@gmail.com', '$2y$10$PzNfPugpKlNPRxgj/NqoaueCq3jv39opVHcuvpfZGz8u9gZvlQaqS', '132190831298', 'customer', 'Active', '2025-05-07 02:40:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD KEY `attendance_ibfk_1` (`employee_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `inventory_stock_log`
--
ALTER TABLE `inventory_stock_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `loyalty`
--
ALTER TABLE `loyalty`
  ADD PRIMARY KEY (`loyalty_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `idx_orders_status` (`status`),
  ADD KEY `idx_orders_payment_status` (`payment_status`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `order_workflow`
--
ALTER TABLE `order_workflow`
  ADD PRIMARY KEY (`workflow_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `assigned_employee` (`assigned_employee`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payments_ibfk_1` (`order_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`delivery_id`),
  ADD UNIQUE KEY `tracking_number` (`tracking_number`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `sizes_pricing`
--
ALTER TABLE `sizes_pricing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD KEY `uploads_ibfk_1` (`user_id`),
  ADD KEY `uploads_ibfk_2` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `branch_id` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `review_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory_stock_log`
--
ALTER TABLE `inventory_stock_log`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loyalty`
--
ALTER TABLE `loyalty`
  MODIFY `loyalty_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_workflow`
--
ALTER TABLE `order_workflow`
  MODIFY `workflow_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `delivery_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sizes_pricing`
--
ALTER TABLE `sizes_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`);

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `inventory_stock_log`
--
ALTER TABLE `inventory_stock_log`
  ADD CONSTRAINT `inventory_stock_log_ibfk_1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`inventory_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_stock_log_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE SET NULL;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `loyalty`
--
ALTER TABLE `loyalty`
  ADD CONSTRAINT `loyalty_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `order_workflow`
--
ALTER TABLE `order_workflow`
  ADD CONSTRAINT `order_workflow_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_workflow_ibfk_2` FOREIGN KEY (`assigned_employee`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uploads_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
