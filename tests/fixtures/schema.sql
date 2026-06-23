-- MySQL dump 10.13  Distrib 5.6.41-84.1, for Linux (x86_64)
--
-- Host: localhost    Database: durgab5_HDBS_Payment
-- ------------------------------------------------------
-- Server version	5.6.39-83.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `booking_slot`
--

DROP TABLE IF EXISTS `booking_slot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_slot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `timestamp` varchar(250) DEFAULT NULL,
  `timecreated` varchar(250) DEFAULT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_slot`
--

/*!40000 ALTER TABLE `booking_slot` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_slot` ENABLE KEYS */;

--
-- Table structure for table `calendar_bloking`
--

DROP TABLE IF EXISTS `calendar_bloking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_bloking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) DEFAULT NULL,
  `from_date` varchar(250) DEFAULT NULL,
  `to_date` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_bloking`
--

/*!40000 ALTER TABLE `calendar_bloking` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar_bloking` ENABLE KEYS */;

--
-- Table structure for table `calendars`
--

DROP TABLE IF EXISTS `calendars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `description` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendars`
--

/*!40000 ALTER TABLE `calendars` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendars` ENABLE KEYS */;

--
-- Table structure for table `confirm_code`
--

DROP TABLE IF EXISTS `confirm_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `confirm_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` varchar(250) DEFAULT NULL,
  `Confirmation` text,
  `Amount` text,
  `Description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=401 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `confirm_code`
--

/*!40000 ALTER TABLE `confirm_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `confirm_code` ENABLE KEYS */;

--
-- Table structure for table `custom_date`
--

DROP TABLE IF EXISTS `custom_date`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) DEFAULT NULL,
  `tooltip` varchar(250) DEFAULT NULL,
  `timestamp` varchar(250) DEFAULT NULL,
  `timestamp_end` varchar(250) DEFAULT NULL,
  `start` varchar(250) DEFAULT NULL,
  `end` varchar(250) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `slot_lenght` float DEFAULT NULL,
  `count` float DEFAULT NULL,
  `lunch_start` varchar(250) DEFAULT NULL,
  `lunch_end` varchar(250) DEFAULT NULL,
  `is_day_off` tinyint(1) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_date`
--

/*!40000 ALTER TABLE `custom_date` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_date` ENABLE KEYS */;

--
-- Table structure for table `custom_price`
--

DROP TABLE IF EXISTS `custom_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) DEFAULT NULL,
  `start_timestamp` varchar(250) DEFAULT NULL,
  `day` varchar(250) DEFAULT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_price`
--

/*!40000 ALTER TABLE `custom_price` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_price` ENABLE KEYS */;

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) DEFAULT NULL,
  `discount_title` varchar(250) DEFAULT NULL,
  `promo_code` varchar(250) DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `type` enum('price','percent') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discount`
--

/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;

--
-- Table structure for table `i18n_field`
--

DROP TABLE IF EXISTS `i18n_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i18n_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `in_id` int(11) DEFAULT NULL,
  `field_name` varchar(250) DEFAULT NULL,
  `table_name` varchar(250) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i18n_field`
--

/*!40000 ALTER TABLE `i18n_field` DISABLE KEYS */;
/*!40000 ALTER TABLE `i18n_field` ENABLE KEYS */;

--
-- Table structure for table `i18n_languages`
--

DROP TABLE IF EXISTS `i18n_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i18n_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(250) DEFAULT NULL,
  `flag` varchar(250) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `isdefault` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i18n_languages`
--

/*!40000 ALTER TABLE `i18n_languages` DISABLE KEYS */;
/*!40000 ALTER TABLE `i18n_languages` ENABLE KEYS */;

--
-- Table structure for table `i18n_local`
--

DROP TABLE IF EXISTS `i18n_local`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i18n_local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `layout` varchar(250) DEFAULT NULL,
  `value` text,
  `field` text,
  `key` varchar(250) DEFAULT NULL,
  `arr_key` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1263 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i18n_local`
--

/*!40000 ALTER TABLE `i18n_local` DISABLE KEYS */;
/*!40000 ALTER TABLE `i18n_local` ENABLE KEYS */;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(250) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
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
  `male` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `currency` varchar(250) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `calendar_price` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `tax` float DEFAULT NULL,
  `security` float DEFAULT NULL,
  `deposit` float DEFAULT NULL,
  `calendars_number` int(10) DEFAULT NULL,
  `payment_method` varchar(250) DEFAULT NULL,
  `invoice_company` varchar(250) DEFAULT NULL,
  `invoice_name` varchar(250) DEFAULT NULL,
  `invoice_address` varchar(250) DEFAULT NULL,
  `invoice_city` varchar(250) DEFAULT NULL,
  `invoice_state` varchar(250) DEFAULT NULL,
  `invoice_zip` varchar(250) DEFAULT NULL,
  `invoice_fax` varchar(250) DEFAULT NULL,
  `invoice_phone` varchar(250) DEFAULT NULL,
  `invoice_email` varchar(250) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `information` varchar(255) NOT NULL,
  `GovtissueID` varchar(255) NOT NULL,
  `membership_type` varchar(255) NOT NULL,
  `Member_id` int(6) NOT NULL,
  `Category` enum('FP','FM','PM','BF','LM','GM','GD') DEFAULT NULL,
  `F_Name` varchar(25) DEFAULT NULL,
  `L_Name` varchar(25) DEFAULT NULL,
  `Mob_No` bigint(10) NOT NULL,
  `Sp_FName` varchar(25) DEFAULT NULL,
  `Sp_LName` varchar(25) DEFAULT NULL,
  `Address1` varchar(25) DEFAULT NULL,
  `Address2` varchar(100) DEFAULT NULL,
  `Address3` varchar(25) DEFAULT NULL,
  `City` varchar(25) DEFAULT NULL,
  `State` varchar(25) DEFAULT 'TX',
  `Country` varchar(25) DEFAULT 'USA',
  `Zip` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `Email2` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `status` enum('T','F') NOT NULL,
  `password` varchar(255) NOT NULL,
  `Tele1` varchar(20) DEFAULT NULL,
  `Tele2` varchar(20) DEFAULT NULL,
  `Child1` varchar(25) DEFAULT NULL,
  `Age1` int(11) DEFAULT NULL,
  `Child2` varchar(25) DEFAULT NULL,
  `Age2` int(11) DEFAULT NULL,
  `Child3` varchar(25) DEFAULT NULL,
  `Age3` int(11) DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Parent1` varchar(40) DEFAULT NULL,
  `Parent2` varchar(40) DEFAULT NULL,
  `remarks` text,
  `swap` enum('0','1') NOT NULL DEFAULT '0',
  `FirstSal` varchar(6) NOT NULL,
  `Payment_method` varchar(255) NOT NULL,
  `SpouseSal` varchar(6) NOT NULL,
  `CreatedOn` datetime DEFAULT NULL,
  `UpdateBy` varchar(10) DEFAULT NULL,
  `UpdateOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1920 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;

--
-- Table structure for table `members_log`
--

DROP TABLE IF EXISTS `members_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Createdon` datetime(6) NOT NULL,
  `Updatedby` varchar(10) NOT NULL,
  `Updatedon` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members_log`
--

/*!40000 ALTER TABLE `members_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `members_log` ENABLE KEYS */;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL DEFAULT '',
  `tab_id` tinyint(3) unsigned DEFAULT NULL,
  `group` varchar(250) DEFAULT NULL,
  `value` text,
  `title` text,
  `description` text,
  `label` text,
  `type` enum('string','text','int','float','enum','color') NOT NULL DEFAULT 'string',
  `order` int(10) unsigned DEFAULT NULL,
  `calendar_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tab_id` (`tab_id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `reg_uid` int(6) NOT NULL,
  `oid` int(6) DEFAULT NULL,
  `St_Name` varchar(40) DEFAULT NULL,
  `school` enum('KALAB','BANGLA','OTHER') DEFAULT NULL,
  `subject` varchar(40) DEFAULT NULL,
  `fee` decimal(10,2) NOT NULL,
  `session` varchar(40) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `remarks` text,
  `CreatedOn` datetime NOT NULL,
  `update_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=452 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

/*!40000 ALTER TABLE `students` DISABLE KEYS */;
/*!40000 ALTER TABLE `students` ENABLE KEYS */;

--
-- Table structure for table `time_price`
--

DROP TABLE IF EXISTS `time_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) DEFAULT NULL,
  `monday_tooltip` varchar(250) DEFAULT NULL,
  `tuesday_tooltip` varchar(250) DEFAULT NULL,
  `wednesday_tooltip` varchar(250) DEFAULT NULL,
  `thursday_tooltip` varchar(250) DEFAULT NULL,
  `friday_tooltip` varchar(250) DEFAULT NULL,
  `saturday_tooltip` varchar(250) DEFAULT NULL,
  `sunday_tooltip` varchar(250) DEFAULT NULL,
  `monday_start` varchar(250) DEFAULT NULL,
  `tuesday_start` varchar(250) DEFAULT NULL,
  `wednesday_start` varchar(250) DEFAULT NULL,
  `thursday_start` varchar(250) DEFAULT NULL,
  `friday_start` varchar(250) DEFAULT NULL,
  `saturday_start` varchar(250) DEFAULT NULL,
  `sunday_start` varchar(250) DEFAULT NULL,
  `monday_end` varchar(250) DEFAULT NULL,
  `tuesday_end` varchar(250) DEFAULT NULL,
  `wednesday_end` varchar(250) DEFAULT NULL,
  `thursday_end` varchar(250) DEFAULT NULL,
  `friday_end` varchar(250) DEFAULT NULL,
  `saturday_end` varchar(250) DEFAULT NULL,
  `sunday_end` varchar(250) DEFAULT NULL,
  `monday_price` float DEFAULT NULL,
  `tuesday_price` float DEFAULT NULL,
  `wednesday_price` float DEFAULT NULL,
  `thursday_price` float DEFAULT NULL,
  `friday_price` float DEFAULT NULL,
  `saturday_price` float DEFAULT NULL,
  `sunday_price` float DEFAULT NULL,
  `monday_slot_lenght` float DEFAULT NULL,
  `tuesday_slot_lenght` float DEFAULT NULL,
  `wednesday_slot_lenght` float DEFAULT NULL,
  `thursday_slot_lenght` float DEFAULT NULL,
  `friday_slot_lenght` float DEFAULT NULL,
  `saturday_slot_lenght` float DEFAULT NULL,
  `sunday_slot_lenght` float DEFAULT NULL,
  `monday_count` float DEFAULT NULL,
  `tuesday_count` float DEFAULT NULL,
  `wednesday_count` float DEFAULT NULL,
  `thursday_count` float DEFAULT NULL,
  `friday_count` float DEFAULT NULL,
  `saturday_count` float DEFAULT NULL,
  `sunday_count` float DEFAULT NULL,
  `monday_lunch_start` varchar(250) DEFAULT NULL,
  `tuesday_lunch_start` varchar(250) DEFAULT NULL,
  `wednesday_lunch_start` varchar(250) DEFAULT NULL,
  `thursday_lunch_start` varchar(250) DEFAULT NULL,
  `friday_lunch_start` varchar(250) DEFAULT NULL,
  `saturday_lunch_start` varchar(250) DEFAULT NULL,
  `sunday_lunch_start` varchar(250) DEFAULT NULL,
  `monday_lunch_end` varchar(250) DEFAULT NULL,
  `tuesday_lunch_end` varchar(250) DEFAULT NULL,
  `wednesday_lunch_end` varchar(250) DEFAULT NULL,
  `thursday_lunch_end` varchar(250) DEFAULT NULL,
  `friday_lunch_end` varchar(250) DEFAULT NULL,
  `saturday_lunch_end` varchar(250) DEFAULT NULL,
  `sunday_lunch_end` varchar(250) DEFAULT NULL,
  `monday_is_day_off` tinyint(1) DEFAULT NULL,
  `tuesday_is_day_off` tinyint(1) DEFAULT NULL,
  `wednesday_is_day_off` tinyint(1) DEFAULT NULL,
  `thursday_is_day_off` tinyint(1) DEFAULT NULL,
  `friday_is_day_off` tinyint(1) DEFAULT NULL,
  `saturday_is_day_off` tinyint(1) DEFAULT NULL,
  `sunday_is_day_off` tinyint(1) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_price`
--

/*!40000 ALTER TABLE `time_price` DISABLE KEYS */;
/*!40000 ALTER TABLE `time_price` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) DEFAULT NULL,
  `first` varchar(250) DEFAULT NULL,
  `last` varchar(250) DEFAULT NULL,
  `avatar` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `status` enum('T','F') DEFAULT NULL,
  `type` int(11) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-09  5:55:34
