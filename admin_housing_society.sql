-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 01, 2020 at 11:14 AM
-- Server version: 5.6.47
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin_housing_society`
--

-- --------------------------------------------------------

--
-- Table structure for table `hsm_master_modules`
--

CREATE TABLE `hsm_master_modules` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `create_datetime` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_datetime` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT ' [ 0 => Disabled, 1 => Enabled ]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hsm_master_society`
--

CREATE TABLE `hsm_master_society` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `registration_number` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `create_datetime` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_datetime` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hsm_master_society`
--

INSERT INTO `hsm_master_society` (`id`, `name`, `registration_number`, `address`, `email`, `contact_number`, `logo`, `create_datetime`, `create_by`, `update_datetime`, `update_by`, `status`) VALUES
(1, 'Apna Adda', 'HS0001001', 'Sector-15, Noida Uttarpradesh', 'apnaadda@gmail.com', '9878987678', NULL, '2020-05-15 15:27:39', 1, '2020-05-15 15:27:39', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hsm_users`
--

CREATE TABLE `hsm_users` (
  `id` int(11) NOT NULL,
  `access_level` int(11) NOT NULL COMMENT '[1 => Super Admin, 2 => Society Admin, 3 => Society User]',
  `fk_master_society_id` int(11) NOT NULL,
  `fk_society_user_type_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `blood_group` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `joining_date` date NOT NULL,
  `fk_designation_id` int(11) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `fk_user_status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hsm_users`
--

INSERT INTO `hsm_users` (`id`, `access_level`, `fk_master_society_id`, `fk_society_user_type_id`, `user_name`, `password`, `api_key`, `first_name`, `last_name`, `contact`, `email`, `address`, `blood_group`, `birth_date`, `joining_date`, `fk_designation_id`, `create_datetime`, `create_by`, `update_datetime`, `update_by`, `fk_user_status_id`) VALUES
(1, 1, -1, -1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'testapikey111', 'Manish', 'Kumar', '9873826567', 'manishk@indovisionservices.in', 'Okhla Phase-1, New Delhi - 110020', 'O +ve', '1987-12-27', '2020-05-15', 1, '2020-05-15 15:38:29', 1, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hsm_visitors`
--

CREATE TABLE `hsm_visitors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `mobile` varchar(10) NOT NULL,
  `otp_verification_status` int(11) NOT NULL DEFAULT '0' COMMENT '1 => verified, 0 => Not Verified',
  `alternate_contact` varchar(20) DEFAULT NULL,
  `address_line1` text,
  `address_line2` text,
  `address_line3` text,
  `fk_city_id` int(11) DEFAULT NULL,
  `pin_code` varchar(6) DEFAULT NULL,
  `create_datetime` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_datetime` datetime NOT NULL,
  `update_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hsm_visitors`
--

INSERT INTO `hsm_visitors` (`id`, `first_name`, `last_name`, `mobile`, `otp_verification_status`, `alternate_contact`, `address_line1`, `address_line2`, `address_line3`, `fk_city_id`, `pin_code`, `create_datetime`, `create_by`, `update_datetime`, `update_by`) VALUES
(1, 'Vinay', 'Kaushik', '9998234567', 1, '0621-20987', 'Test Address Line 1', 'Test Address Line 2', 'Test Address Line 3', 1, '843119', '2020-05-30 08:47:04', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hsm_visitors_visits`
--

CREATE TABLE `hsm_visitors_visits` (
  `id` int(11) NOT NULL,
  `fk_visitor_id` int(11) NOT NULL,
  `fk_visit_person_id` int(11) NOT NULL,
  `purpose` text,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `vehicle_detail` text,
  `create_datetime` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_datetime` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hsm_visitors_visits`
--

INSERT INTO `hsm_visitors_visits` (`id`, `fk_visitor_id`, `fk_visit_person_id`, `purpose`, `in_time`, `out_time`, `vehicle_detail`, `create_datetime`, `create_by`, `update_datetime`, `update_by`, `status`) VALUES
(1, 1, 1, 'Meeting', '2020-05-29 19:30:00', '0000-00-00 00:00:00', 'HR89765 Hundai', '2020-05-30 08:50:36', 1, NULL, NULL, 1),
(2, 1, 1, 'Meeting', '2020-05-29 19:30:00', '0000-00-00 00:00:00', 'HR89765 Hundai', '2020-05-30 13:12:57', 1, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hsm_master_modules`
--
ALTER TABLE `hsm_master_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hsm_master_society`
--
ALTER TABLE `hsm_master_society`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hsm_users`
--
ALTER TABLE `hsm_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hsm_visitors`
--
ALTER TABLE `hsm_visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hsm_visitors_visits`
--
ALTER TABLE `hsm_visitors_visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hsm_master_modules`
--
ALTER TABLE `hsm_master_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hsm_master_society`
--
ALTER TABLE `hsm_master_society`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hsm_users`
--
ALTER TABLE `hsm_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hsm_visitors`
--
ALTER TABLE `hsm_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hsm_visitors_visits`
--
ALTER TABLE `hsm_visitors_visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
