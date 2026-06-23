-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 20, 2026 at 01:22 AM
-- Server version: 5.7.44-48
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `durgab5_HDBS_Payment_Prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `calendar_id` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `booking_number` varchar(250) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `first_name` varchar(250) DEFAULT NULL,
  `second_name` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `company` varchar(250) DEFAULT NULL,
  `address_1` varchar(250) DEFAULT NULL,
  `address_2` varchar(250) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `state` varchar(250) DEFAULT NULL,
  `zip` varchar(250) DEFAULT NULL,
  `country` varchar(250) DEFAULT NULL,
  `fax` varchar(250) DEFAULT NULL,
  `gender` varchar(250) DEFAULT NULL,
  `additional` text,
  `promo_code` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `calendars_price` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `security` float DEFAULT NULL,
  `deposit` float DEFAULT NULL,
  `payment_method` varchar(250) DEFAULT NULL,
  `cc_type` varchar(250) DEFAULT NULL,
  `cc_num` varchar(250) DEFAULT NULL,
  `cc_code` varchar(250) DEFAULT NULL,
  `cc_exp_month` varchar(250) DEFAULT NULL,
  `cc_exp_year` varchar(250) DEFAULT NULL,
  `created` varchar(250) DEFAULT NULL,
  `confirm_code` varchar(255) DEFAULT NULL,
  `stripe_return` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `paid_amount` varchar(255) DEFAULT NULL,
  `stripe_product` varchar(255) DEFAULT NULL,
  `date` varchar(250) DEFAULT NULL,
  `finalDate` varchar(50) DEFAULT NULL,
  `Member_id` int(11) DEFAULT NULL,
  `checkbankname` varchar(255) DEFAULT NULL,
  `checkno` varchar(255) DEFAULT NULL,
  `checkAmount` varchar(255) DEFAULT NULL,
  `CheckDate` varchar(255) DEFAULT NULL,
  `CheckDepositAccount` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservations`
--

-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2954;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
