-- Fix for order_details table
DROP TABLE IF EXISTS `order_details`;

CREATE TABLE `order_details` (
  `order_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `service_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_detail_id`),
  KEY `order_id` (`order_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Make sure orders table has the right columns
ALTER TABLE `orders` 
ADD COLUMN IF NOT EXISTS `user_id` bigint(20) NOT NULL AFTER `order_id`,
ADD COLUMN IF NOT EXISTS `service_id` bigint(20) DEFAULT NULL AFTER `user_id`,
ADD COLUMN IF NOT EXISTS `total_price` decimal(10,2) NOT NULL AFTER `service_id`,
ADD COLUMN IF NOT EXISTS `status` enum('Pending','In Progress','Completed','Cancelled','Refunded') DEFAULT 'Pending' AFTER `total_price`,
ADD COLUMN IF NOT EXISTS `payment_status` enum('Pending','Paid','Refunded') DEFAULT 'Pending' AFTER `status`,
ADD COLUMN IF NOT EXISTS `order_date` datetime DEFAULT current_timestamp() AFTER `payment_status`,
ADD COLUMN IF NOT EXISTS `branch_id` bigint(20) DEFAULT 1 AFTER `order_date`,
ADD COLUMN IF NOT EXISTS `employee_id` bigint(20) DEFAULT NULL AFTER `branch_id`,
ADD COLUMN IF NOT EXISTS `expected_completion` date DEFAULT NULL AFTER `employee_id`;

-- Make sure payments table has the right columns
CREATE TABLE IF NOT EXISTS `payments` (
    `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
    `order_id` bigint(20) NOT NULL,
    `payment_date` datetime DEFAULT current_timestamp(),
    `amount` decimal(10,2) NOT NULL,
    `payment_method` enum('GCash','Bank Transfer','Cash') DEFAULT NULL,
    `reference_number` varchar(100) DEFAULT NULL,
    `proof_file_name` varchar(255) DEFAULT NULL,
    `proof_file_path` varchar(255) DEFAULT NULL,
    `status` enum('Pending Verification','Verified','Rejected') DEFAULT 'Pending Verification',
    `verified_by` bigint(20) DEFAULT NULL,
    `verified_at` datetime DEFAULT NULL,
    `admin_notes` text DEFAULT NULL,
    PRIMARY KEY (`payment_id`),
    KEY `order_id` (`order_id`),
    CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Make sure services table exists
CREATE TABLE IF NOT EXISTS `services` (
  `service_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `service_name` VARCHAR(255) NOT NULL,
  `service_description` TEXT DEFAULT NULL,
  `service_price` DECIMAL(10,2) NOT NULL,
  `service_category` ENUM('Embroidery', 'Sublimation', 'Screen Printing', 'Alterations', 'Patches') NOT NULL,
  `is_active` BOOLEAN DEFAULT TRUE,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample data to services if it's empty
INSERT INTO `services` (`service_name`, `service_description`, `service_price`, `service_category`, `is_active`)
SELECT 'Embroidery', 'High-quality embroidery services for custom designs.', 500.00, 'Embroidery', TRUE
WHERE NOT EXISTS (SELECT 1 FROM `services` LIMIT 1);

INSERT INTO `services` (`service_name`, `service_description`, `service_price`, `service_category`, `is_active`)
SELECT 'Sublimation', 'Custom sublimation printing for vibrant designs.', 750.00, 'Sublimation', TRUE
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `service_name` = 'Sublimation');

INSERT INTO `services` (`service_name`, `service_description`, `service_price`, `service_category`, `is_active`)
SELECT 'Screen Printing', 'Durable screen printing for various materials.', 600.00, 'Screen Printing', TRUE
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `service_name` = 'Screen Printing');

INSERT INTO `services` (`service_name`, `service_description`, `service_price`, `service_category`, `is_active`)
SELECT 'Alterations', 'Professional alterations for a perfect fit.', 300.00, 'Alterations', TRUE
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `service_name` = 'Alterations');

INSERT INTO `services` (`service_name`, `service_description`, `service_price`, `service_category`, `is_active`)
SELECT 'Patches', 'Custom patches for clothing and accessories.', 400.00, 'Patches', TRUE
WHERE NOT EXISTS (SELECT 1 FROM `services` WHERE `service_name` = 'Patches');
