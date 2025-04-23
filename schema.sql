-- Wildlife Zoo Management System Database Schema
-- Version: 1.0
-- Created: 2023-06-20

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Database: `zoo_management`

CREATE DATABASE IF NOT EXISTS `zoo_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zoo_management`;

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','staff','user') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `species` varchar(100) NOT NULL,
  `habitat` varchar(100) DEFAULT NULL,
  `diet` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','relocated','deceased') NOT NULL DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `animals_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `tickets`
--

CREATE TABLE tickets (
 full_name VARCHAR(255) NOT NULL,
 email VARCHAR(255) NOT NULL,
 phone VARCHAR(20) NOT NULL,
 ticket_type VARCHAR(50) NOT NULL,
 adults INT NOT NULL,
 children INT NOT NULL,
 total_amount DECIMAL(10, 2) NOT NULL,
 booking_date DATETIME NOT NULL
);



 ALTER TABLE tickets
 ADD COLUMN ticket_id INT PRIMARY KEY AUTO_INCREMENT;
--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 
-- Default data
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `role`, `status`, `last_login`) VALUES
(1, 'admin', 'admin@zoo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', '+919876543210', 'admin', 'active', NOW());

INSERT INTO `settings` (`setting_key`, `setting_value`, `description`) VALUES
('zoo_name', 'Wildlife Adventure Zoo', 'Name of the zoo'),
('contact_email', 'info@wildlifezoo.com', 'Primary contact email'),
('contact_phone', '+91 1800 123 4567', 'Primary contact number'),
('opening_hours', '9:00 AM - 6:00 PM', 'Zoo opening hours'),
('indian_adult_price', '200', 'Ticket price for Indian adults'),
('indian_child_price', '100', 'Ticket price for Indian children'),
('foreign_adult_price', '20', 'Ticket price for foreign adults (USD)'),
('foreign_child_price', '10', 'Ticket price for foreign children (USD)');

SET FOREIGN_KEY_CHECKS = 1;