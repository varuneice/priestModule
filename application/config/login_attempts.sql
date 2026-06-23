-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2026 at 12:53 PM
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
-- Database: `durgab5_hdbs_payment_prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `action` varchar(20) NOT NULL DEFAULT 'login' COMMENT 'login | payment',
  `identifier` varchar(255) NOT NULL COMMENT 'Client IP address',
  `attempted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tracks failed login and payment submission attempts for rate limiting.';

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `action`, `identifier`, `attempted_at`) VALUES
(1, 'payment', '::1', '2026-02-27 11:45:32'),
(2, 'payment', '::1', '2026-03-02 16:49:15'),
(3, 'payment', '::1', '2026-03-02 16:49:54'),
(4, 'payment', '::1', '2026-03-02 16:50:33'),
(5, 'payment', '::1', '2026-03-02 16:54:46'),
(6, 'payment', '::1', '2026-03-03 21:13:23'),
(7, 'payment', '::1', '2026-03-03 21:18:51'),
(8, 'payment', '::1', '2026-03-03 21:53:24'),
(9, 'payment', '::1', '2026-03-12 15:02:51'),
(10, 'payment', '::1', '2026-03-12 15:03:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lookup` (`action`,`identifier`,`attempted_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
