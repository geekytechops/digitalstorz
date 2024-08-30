-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 26, 2024 at 08:10 PM
-- Server version: 8.0.39-cll-lve
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kol14747_UAT_digitalstorz`
--

-- --------------------------------------------------------

--
-- Table structure for table `adm_companies`
--

CREATE TABLE `adm_companies` (
  `cp_id` int NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `added_date` datetime NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adm_companies`
--

INSERT INTO `adm_companies` (`cp_id`, `company_name`, `added_date`, `status`) VALUES
(19, 'Vivo', '2019-01-29 19:36:17', '0'),
(18, 'Lenovo', '2019-01-29 19:36:11', '1'),
(17, 'Moto', '2019-01-29 19:35:48', '1'),
(16, 'Asus', '2019-01-29 19:35:42', '1'),
(15, 'Mi', '2019-01-29 19:35:37', '1'),
(14, 'Samsung', '2019-01-29 19:35:31', '1'),
(13, 'Apple', '2019-01-29 12:21:03', '1'),
(20, 'One Plus', '2019-01-29 19:36:23', '1'),
(21, 'Oppo', '2019-01-29 19:36:29', '1'),
(22, 'Realme', '2019-01-29 19:36:38', '1'),
(23, 'Nokia', '2019-01-29 19:36:47', '1'),
(24, 'Letv', '2019-01-29 19:36:55', '1'),
(25, 'LG', '2019-01-29 19:37:21', '1'),
(26, 'Sony', '2019-01-29 19:41:15', '1'),
(27, 'Honor', '2019-01-29 23:41:07', '1'),
(28, 'HTC', '2019-01-29 23:41:15', '1'),
(29, 'Google', '2019-01-29 23:41:50', '1');

-- --------------------------------------------------------

--
-- Table structure for table `adm_cust_mob_add`
--

CREATE TABLE `adm_cust_mob_add` (
  `entry_id` int NOT NULL,
  `customer_name` text NOT NULL,
  `mobile_name` text NOT NULL,
  `mobile_defect` text NOT NULL,
  `mobile_defect_2` varchar(5) NOT NULL,
  `mobile_defect_3` varchar(5) NOT NULL,
  `mobile_defect_4` text NOT NULL,
  `cust_contact` varchar(15) NOT NULL,
  `cust_alt_contact` text NOT NULL,
  `send_sms_to_alt` text NOT NULL,
  `imei_serial_num` text NOT NULL,
  `exp_delivery` date NOT NULL,
  `est_amount` text NOT NULL,
  `adv_amount` text NOT NULL,
  `remarks` text NOT NULL,
  `added_date` datetime NOT NULL,
  `status` text NOT NULL,
  `rejected` varchar(5) NOT NULL,
  `rejected_reason` varchar(100) NOT NULL,
  `delete_status` varchar(10) NOT NULL,
  `actual_amount` varchar(50) NOT NULL,
  `adjustments` varchar(50) NOT NULL,
  `gst_amount` varchar(20) NOT NULL,
  `payment_mode` varchar(25) NOT NULL,
  `added_by` varchar(25) NOT NULL,
  `store_id` varchar(10) NOT NULL,
  `repair_by` varchar(25) NOT NULL,
  `deliver_by` varchar(25) NOT NULL,
  `delivered_date` datetime NOT NULL,
  `spare_cost` varchar(10) NOT NULL,
  `repair_date` datetime NOT NULL,
  `adv_payment_mode` varchar(25) NOT NULL,
  `gst` varchar(20) NOT NULL,
  `customer_gst_no` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `adm_mobile_defects`
--

CREATE TABLE `adm_mobile_defects` (
  `defect_id` int NOT NULL,
  `defect_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `default_defect` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_id` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `active` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `adm_mobile_defects`
--

INSERT INTO `adm_mobile_defects` (`defect_id`, `defect_name`, `default_defect`, `store_id`, `active`) VALUES
(1, 'Display Damage', 'yes', '', '1'),
(2, 'Phone Dead', 'yes', '', '1'),
(3, 'Water Damage - Dead', 'yes', '', '1'),
(4, 'Touch Screen Damage', 'yes', '', '1'),
(5, 'Touch and Display', 'yes', '', '1'),
(6, 'Mike Problem', 'yes', '', '1'),
(7, 'Speaker Problem', 'yes', '', '1'),
(8, 'Mother Board Problem', 'yes', '', '1'),
(9, 'Charging Port', 'yes', '', '1'),
(10, 'Ringer Problem', 'yes', '', '1'),
(11, 'Power Key', 'yes', '', '1'),
(12, 'Home Key', 'yes', '', '1'),
(13, 'Volume Key', 'yes', '', '1'),
(14, 'Lighting Problem', 'yes', '', '1'),
(15, 'Sensor Problem', 'yes', '', '1'),
(16, 'Rear Camera Problem', 'yes', '', '1'),
(17, 'front Camera Problem', 'yes', '', '1'),
(18, 'Network Problem', 'yes', '', '1'),
(19, 'Hands Free Connector', 'yes', '', '1'),
(20, 'Unlock', 'yes', '', '1'),
(21, 'Unknown', 'yes', '', '1'),
(22, 'Software Problem', 'yes', '', '1'),
(23, 'Others', 'yes', '', '1'),
(24, 'IMEI Repair', 'yes', '', '1'),
(25, 'Body Panel', 'yes', '', '1'),
(26, 'Battery Connector', 'yes', '', '1'),
(27, 'Battery Replace', 'yes', '', '1'),
(28, 'Auto Off', 'yes', '', '1'),
(29, 'Auto Restart', 'yes', '', '1'),
(30, 'Phone Hang', 'yes', '', '1'),
(31, 'Not Charging', 'yes', '', '1'),
(32, 'No Service', 'yes', '', '1'),
(33, 'White Display', 'yes', '', '1'),
(34, 'Wifi Not Working', 'yes', '', '1'),
(35, 'Bluetooth Not Working', 'yes', '', '1'),
(36, 'Sim Tray', 'yes', '', '1'),
(39, 'Google unlock', 'yes', '', '1'),
(40, 'Network Unlock ', 'yes', '', '1'),
(41, 'Touch connector', 'yes', '', '1'),
(42, 'Display Connector', 'yes', '', '1'),
(43, 'Pattern Unlock', 'yes', '', '1'),
(44, 'Mi Account Unlock ', 'yes', '', '1'),
(45, 'No Sim', 'yes', '', '1'),
(46, 'Back Panel ', 'yes', '', '1'),
(47, 'Board Power Short', 'yes', '', '1'),
(48, 'Display Refix', 'yes', '', '1'),
(49, 'Touch Glass', 'yes', '', '1'),
(50, 'Charging PCB', 'yes', '', '1'),
(51, 'Rear Camera Glass', 'yes', '', '1'),
(52, 'Iphone nand ic replacement (for 4013 Error)', 'yes', '', '1'),
(53, 'Sd card issues', 'yes', '', '1'),
(54, 'Heating Problem', 'yes', '', '1'),
(55, 'No Vibration', 'yes', '', '1'),
(56, 'Charging PCB Flex ', 'yes', '', '1'),
(57, 'Body Bend', 'yes', '', '1'),
(58, 'Safe Mode', 'yes', '', '1'),
(59, 'Keypad Problem', 'yes', '', '1'),
(60, 'Tab Dead', 'yes', '', '1'),
(61, 'Icloud Id', 'yes', '', '1'),
(62, 'switch off on calling', 'yes', '', '1'),
(63, 'Battery Repair', 'yes', '', '1'),
(64, 'Fastboot Mode', 'yes', '', '1'),
(65, 'SIM IC', 'yes', '', '1'),
(66, 'Power Damage', 'yes', '', '1'),
(67, 'Charging temperature problem', 'yes', '', '1'),
(68, 'Temporary unlock', 'yes', '', '1'),
(69, 'Charging Issue', 'yes', '', '1'),
(70, 'Dispaly Ic hardware defect', 'yes', '', '1'),
(71, 'General Service', 'yes', '', '1'),
(72, 'Touch Ic', 'yes', '', '1'),
(73, 'Dispaly Frame', 'yes', '', '1'),
(74, 'Strip', 'yes', '', '1'),
(75, 'Battery Temperature Issues', 'yes', '', '1'),
(76, 'Audio issue', 'yes', '', '1'),
(77, 'Error 9 ', 'yes', '', '1'),
(78, 'Test', 'yes', '', '1'),
(79, 'Hard Drive Error', 'yes', '', '1'),
(80, 'Baseband issue', 'yes', '', '1'),
(81, 'No screen After Sleep Mode', 'yes', '', '1'),
(82, 'Battery Draining', 'yes', '', '1'),
(86, 'Silent Key', 'yes', '', '1'),
(84, 'Hang On Logo', 'yes', '', '1'),
(85, 'Face ID', 'yes', '', '1'),
(87, 'Fingerprint Issue', 'yes', '', '1'),
(88, 'Data Recovery', 'yes', '', '1'),
(89, 'Display Flex ', 'yes', '', '1'),
(90, 'Touch Issue', 'yes', '', '1'),
(91, 'Flash Light Replacement', 'yes', '', '1'),
(92, 'Back & Recent Button', 'yes', '', '1'),
(93, 'Back Panel Fix', 'yes', '', '1'),
(94, 'Imei Info', 'yes', '', '1'),
(104, 'Test Defect KOLORS', '', '25', '1'),
(107, 'Water damage', '', '50', ''),
(108, 'Water damage', '', '50', ''),
(109, 'Broken', '', '50', ''),
(111, '18W Adapter', '', '25', ''),
(112, 'test 1', '', '25', ''),
(113, 'test 2', '', '25', '');

-- --------------------------------------------------------

--
-- Table structure for table `adm_ph_models`
--

CREATE TABLE `adm_ph_models` (
  `mod_id` int NOT NULL,
  `company_id` int NOT NULL,
  `model_no` varchar(50) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `added_date` datetime NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adm_ph_models`
--

INSERT INTO `adm_ph_models` (`mod_id`, `company_id`, `model_no`, `model_name`, `added_date`, `status`) VALUES
(52, 13, 'Iphone 12', 'Iphone 12', '2021-01-22 15:55:57', '1'),
(51, 20, 'Iphone 12', 'Iphone 12', '2021-01-22 15:55:24', '0'),
(50, 14, 'S10 Plus', 'S10 Plus', '2020-12-18 12:23:33', '1'),
(49, 21, 'F1S', 'F1S', '2019-05-03 20:13:21', '1'),
(48, 14, 'S10', 'S10', '2019-02-20 14:06:37', '1'),
(47, 14, 'S7 Edge', 'S7 Edge', '2019-01-29 19:42:28', '1'),
(46, 13, '6s Plus', '6s Plus', '2019-01-29 19:30:51', '1'),
(45, 13, '6S', '6S', '2019-01-29 12:22:19', '1');

-- --------------------------------------------------------

--
-- Table structure for table `adm_product_category`
--

CREATE TABLE `adm_product_category` (
  `p_cat_id` int NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `added_date` datetime NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adm_product_category`
--

INSERT INTO `adm_product_category` (`p_cat_id`, `category_name`, `added_date`, `status`) VALUES
(15, '6D Tempered Glass', '2019-01-29 23:43:57', '1'),
(14, 'Ear Phones', '2019-01-29 19:31:57', '1'),
(13, 'Flip Covers', '2019-01-29 19:31:39', '1'),
(12, 'Pouches', '2019-01-29 19:31:29', '1'),
(11, 'Tempered Glass', '2019-01-29 12:21:25', '1'),
(16, 'UV Glue Glass', '2019-01-29 23:44:18', '1'),
(17, 'USB Cable', '2019-01-29 23:44:44', '1'),
(18, 'ERD USB Cable V8', '2019-01-29 23:45:07', '1'),
(19, 'ERD Charger V8', '2019-01-29 23:45:53', '1'),
(20, 'Power Bank', '2019-01-29 23:46:22', '1'),
(21, 'Original Charger', '2019-01-29 23:47:05', '1'),
(22, 'Original Battery', '2019-01-29 23:47:33', '1'),
(23, '3500 Chargers', '2019-01-29 23:48:08', '1'),
(24, 'N70 Chargers', '2019-01-29 23:48:24', '1'),
(25, 'ERD USB Cable IPHONE 5', '2019-01-29 23:49:14', '1'),
(26, 'ERD USB Cable IPHONE 4', '2019-01-29 23:49:30', '1'),
(27, 'SAMSUNG TAB CABLES', '2019-01-29 23:50:04', '1'),
(28, 'ERD CAR CHARGER', '2019-01-29 23:51:14', '1'),
(29, 'ERD 2 MET CABLE', '2019-01-29 23:51:38', '1');

-- --------------------------------------------------------

--
-- Table structure for table `adm_prod_inv_cr_tran`
--

CREATE TABLE `adm_prod_inv_cr_tran` (
  `inv_cr_id` int NOT NULL,
  `company_id` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `model_id` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `prod_cat_id` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `inv_prod_qty` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `added_date` datetime NOT NULL,
  `comments` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `actual_price` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sale_price` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adm_prod_sale_tran`
--

CREATE TABLE `adm_prod_sale_tran` (
  `sale_id` int NOT NULL,
  `company_id` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `model_id` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `prod_cat_id` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sale_qty` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sale_price` varchar(5) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `cust_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `cust_contact` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `remarks` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `added_date` datetime NOT NULL,
  `payment_mode` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sold_by` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_registration_hiteshora`
--

CREATE TABLE `customer_registration_hiteshora` (
  `cust_id` int NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `cust_surname` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `cust_email` varchar(100) NOT NULL,
  `cust_phone` varchar(12) NOT NULL,
  `cust_profession` varchar(100) NOT NULL,
  `work_palce` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `cust_address1` varchar(500) NOT NULL,
  `cust_address2` varchar(500) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `vehicle_reg_no` varchar(15) NOT NULL,
  `vechicle_insurer` varchar(50) NOT NULL,
  `add_date` datetime NOT NULL,
  `status` varchar(1) NOT NULL,
  `terms` varchar(10) NOT NULL,
  `recevied_from` varchar(200) NOT NULL,
  `cheque_no` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cust_kolors_retailer_credits`
--

CREATE TABLE `cust_kolors_retailer_credits` (
  `retailer_id` int NOT NULL,
  `retailer_credits` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cust_kolors_retailer_credits_transactions`
--

CREATE TABLE `cust_kolors_retailer_credits_transactions` (
  `transaction_id` int NOT NULL,
  `retailer_id` int NOT NULL,
  `transaction_amount` varchar(10) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `transaction_type` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cust_kolors_retailer_debits_transactions`
--

CREATE TABLE `cust_kolors_retailer_debits_transactions` (
  `transaction_id` int NOT NULL,
  `retailer_id` int NOT NULL,
  `transaction_amount` varchar(10) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cust_kolors_retail_users`
--

CREATE TABLE `cust_kolors_retail_users` (
  `retailer_id` int NOT NULL,
  `retailer_role` varchar(20) NOT NULL,
  `retailer_name` varchar(50) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL,
  `outlet_name` varchar(50) NOT NULL,
  `outlet_address` varchar(250) NOT NULL,
  `status` varchar(1) NOT NULL,
  `add_date` datetime NOT NULL,
  `passkey` varchar(150) NOT NULL,
  `email_verified` varchar(15) NOT NULL,
  `mobile_verified` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cust_kolors_services_list`
--

CREATE TABLE `cust_kolors_services_list` (
  `service_id` int NOT NULL,
  `service_name` varchar(250) NOT NULL,
  `service_category` varchar(150) NOT NULL,
  `customer_price` varchar(10) NOT NULL,
  `retail_price` varchar(5) NOT NULL,
  `duration` varchar(25) NOT NULL,
  `add_date` datetime NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cust_kolors_users_list`
--

CREATE TABLE `cust_kolors_users_list` (
  `user_id` int NOT NULL,
  `store_id` varchar(15) NOT NULL,
  `admin_id` varchar(20) NOT NULL,
  `store_name` varchar(200) NOT NULL,
  `user_role` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(256) NOT NULL,
  `staff_name` varchar(50) NOT NULL,
  `staff_dob` varchar(15) NOT NULL,
  `staff_mobile` varchar(15) NOT NULL,
  `staff_email` varchar(50) NOT NULL,
  `staff_residence` varchar(500) NOT NULL,
  `status` varchar(1) NOT NULL,
  `subscription_plan` varchar(50) NOT NULL,
  `subscription_date` date NOT NULL,
  `add_date` datetime NOT NULL,
  `last_update_date` date NOT NULL,
  `refered_by` varchar(20) NOT NULL,
  `payment_transaction_no` varchar(100) NOT NULL,
  `mobile_no_verified` varchar(20) NOT NULL,
  `email_id_verified` varchar(20) NOT NULL,
  `trail_availed` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cust_kolors_users_list`
--

INSERT INTO `cust_kolors_users_list` (`user_id`, `store_id`, `admin_id`, `store_name`, `user_role`, `username`, `password`, `staff_name`, `staff_dob`, `staff_mobile`, `staff_email`, `staff_residence`, `status`, `subscription_plan`, `subscription_date`, `add_date`, `last_update_date`, `refered_by`, `payment_transaction_no`, `mobile_no_verified`, `email_id_verified`, `trail_availed`) VALUES
(1001, '1', '1001', 'Digital Storz', 'superadmin', 'superadmin', '$2y$10$PdzqoxJf78BBpKF8ONDJoO/LemJ4hqSOpWzjreusG/0K7aHzGeNT6', 'Admin DigitalStorz.com', '2012-09-04', '9703777755', 'kolorsmobileservices@gmail.com', 'Nizampet', '1', 'annual', '2023-08-29', '2014-09-22 00:34:55', '2022-06-23', '', '', '', '', ''),
(1003, '2', '', 'SIVA MOBILES', 'admin', '9703777755', '$2y$10$hEZeTi6o9jlk3jYbnjnwVuJaTP/4FpqhRw4XMYwGAh7/A71Op.sBS', 'Sivananda T', '', '9703777755', 'sivananda7@gmail.com', '', '1', 'trail', '2024-08-25', '2024-08-25 14:48:44', '0000-00-00', '', '', 'yes', '', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `cust_retail_unlock_orders`
--

CREATE TABLE `cust_retail_unlock_orders` (
  `order_id` int NOT NULL,
  `service_id` int NOT NULL,
  `imei_no` varchar(20) NOT NULL,
  `retailer_id` varchar(10) NOT NULL,
  `cust_name` varchar(50) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `order_amount` varchar(10) NOT NULL,
  `order_placed_date` datetime NOT NULL,
  `customer/retailer` varchar(1) NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `comments` varchar(250) NOT NULL,
  `retailer_comments` varchar(500) NOT NULL,
  `debit_transaction_id` varchar(15) NOT NULL,
  `credit_transaction_id` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_activity`
--

CREATE TABLE `login_activity` (
  `login_txn_num` int NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime NOT NULL,
  `device_type` varchar(100) NOT NULL,
  `device_id` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `ip_address` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_activity`
--

INSERT INTO `login_activity` (`login_txn_num`, `user_name`, `login_time`, `logout_time`, `device_type`, `device_id`, `device_name`, `session_id`, `ip_address`) VALUES
(1, '9703777755', '2024-08-25 14:31:08', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(2, 'superadmin', '2024-08-25 14:37:30', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(3, '9703777755', '2024-08-25 14:43:25', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(4, '9703777755', '2024-08-25 14:54:40', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(5, '9703777755', '2024-08-25 14:54:55', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(6, '9703777755', '2024-08-25 15:10:28', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(7, '9703777755', '2024-08-25 15:20:45', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(8, '9703777755', '2024-08-25 15:32:21', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(9, 'superadmin', '2024-08-25 15:32:52', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(10, '9703777755', '2024-08-25 15:33:10', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(11, '9703777755', '2024-08-25 15:34:28', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(12, 'superadmin', '2024-08-25 15:34:45', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(13, '9703777755', '2024-08-25 15:34:57', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(14, 'superadmin', '2024-08-25 15:40:46', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(15, '9703777755', '2024-08-25 15:41:06', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(16, 'superadmin', '2024-08-25 15:42:19', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(17, '9703777755', '2024-08-25 15:42:44', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(18, '9703777755', '2024-08-25 15:49:33', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', 'pcao1rovf58b81c6hbv0lo2sq6', '116.86.50.132'),
(19, '9703777755', '2024-08-26 19:35:29', '0000-00-00 00:00:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Sa', '', '', '5bppehvvatqakqllmra0jl3bq4', '116.86.50.132');

-- --------------------------------------------------------

--
-- Table structure for table `payment_modes`
--

CREATE TABLE `payment_modes` (
  `payment_id` int NOT NULL,
  `payment_name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_modes`
--

INSERT INTO `payment_modes` (`payment_id`, `payment_name`) VALUES
(1, 'Cash'),
(2, 'Card'),
(3, 'Gpay'),
(4, 'PhonePe'),
(5, 'PayTm'),
(6, 'Other Wallet');

-- --------------------------------------------------------

--
-- Table structure for table `prod_cart_temp`
--

CREATE TABLE `prod_cart_temp` (
  `cart_id` int NOT NULL,
  `session_id` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `barcode_id1` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `barcode_id2` int NOT NULL,
  `barcode_id3` int NOT NULL,
  `barcode_id4` int NOT NULL,
  `barcode_id5` int NOT NULL,
  `barcode_id6` int NOT NULL,
  `barcode_id7` int NOT NULL,
  `barcode_id8` int NOT NULL,
  `barcode_id9` int NOT NULL,
  `barcode_id10` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `store_id` int NOT NULL,
  `store_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_contact` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_address1` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_address2` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `referal_code` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `admin_user` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `added_date` datetime NOT NULL,
  `message_sent_count` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `use_preloaded_defects` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `last_update_date` datetime NOT NULL,
  `kyc_status` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_reg_certificate` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_owner_id_proof` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `store_gst_no` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`store_id`, `store_name`, `store_contact`, `store_address1`, `store_address2`, `referal_code`, `admin_user`, `added_date`, `message_sent_count`, `use_preloaded_defects`, `last_update_date`, `kyc_status`, `store_reg_certificate`, `store_owner_id_proof`, `store_gst_no`) VALUES
(1, 'SIVA MOBILE STORE', '9703777755', 'NAGARJUNA HOMES', 'NIZAMPET ROAD, HYDERABAD, 500085', '', '1002', '2024-08-25 14:31:45', '', 'yes', '0000-00-00 00:00:00', 'Rejected', '1_9703777755_store_reg_cert.jpeg', '', ''),
(2, 'SIVA MOBILES', '9703777755', 'NIZAMPET', 'HYDERABAD', '', '1003', '2024-08-25 14:55:46', '', 'yes', '0000-00-00 00:00:00', 'Completed', '2_9703777755_store_reg_cert.jpeg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `sub_plan_id` int NOT NULL,
  `sub_plan_name` varchar(50) NOT NULL,
  `sub_plan_amount` varchar(20) NOT NULL,
  `sub_plan_validity` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`sub_plan_id`, `sub_plan_name`, `sub_plan_amount`, `sub_plan_validity`) VALUES
(2, 'trail', '0', '7');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plan_history`
--

CREATE TABLE `subscription_plan_history` (
  `sl_no` int NOT NULL,
  `store_username` varchar(20) NOT NULL,
  `store_name` varchar(50) NOT NULL,
  `subscription_plan` varchar(25) NOT NULL,
  `payment_transaction_no` varchar(50) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `added_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adm_companies`
--
ALTER TABLE `adm_companies`
  ADD PRIMARY KEY (`cp_id`);

--
-- Indexes for table `adm_cust_mob_add`
--
ALTER TABLE `adm_cust_mob_add`
  ADD PRIMARY KEY (`entry_id`);

--
-- Indexes for table `adm_mobile_defects`
--
ALTER TABLE `adm_mobile_defects`
  ADD PRIMARY KEY (`defect_id`);

--
-- Indexes for table `adm_ph_models`
--
ALTER TABLE `adm_ph_models`
  ADD PRIMARY KEY (`mod_id`);

--
-- Indexes for table `adm_product_category`
--
ALTER TABLE `adm_product_category`
  ADD PRIMARY KEY (`p_cat_id`);

--
-- Indexes for table `adm_prod_inv_cr_tran`
--
ALTER TABLE `adm_prod_inv_cr_tran`
  ADD UNIQUE KEY `inv_cr_id` (`inv_cr_id`);

--
-- Indexes for table `adm_prod_sale_tran`
--
ALTER TABLE `adm_prod_sale_tran`
  ADD UNIQUE KEY `sale_id` (`sale_id`);

--
-- Indexes for table `customer_registration_hiteshora`
--
ALTER TABLE `customer_registration_hiteshora`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `cust_kolors_retailer_credits`
--
ALTER TABLE `cust_kolors_retailer_credits`
  ADD PRIMARY KEY (`retailer_id`);

--
-- Indexes for table `cust_kolors_retailer_credits_transactions`
--
ALTER TABLE `cust_kolors_retailer_credits_transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `cust_kolors_retailer_debits_transactions`
--
ALTER TABLE `cust_kolors_retailer_debits_transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `cust_kolors_retail_users`
--
ALTER TABLE `cust_kolors_retail_users`
  ADD PRIMARY KEY (`retailer_id`);

--
-- Indexes for table `cust_kolors_services_list`
--
ALTER TABLE `cust_kolors_services_list`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `cust_kolors_users_list`
--
ALTER TABLE `cust_kolors_users_list`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `cust_retail_unlock_orders`
--
ALTER TABLE `cust_retail_unlock_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `login_activity`
--
ALTER TABLE `login_activity`
  ADD PRIMARY KEY (`login_txn_num`);

--
-- Indexes for table `payment_modes`
--
ALTER TABLE `payment_modes`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `prod_cart_temp`
--
ALTER TABLE `prod_cart_temp`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`sub_plan_id`);

--
-- Indexes for table `subscription_plan_history`
--
ALTER TABLE `subscription_plan_history`
  ADD PRIMARY KEY (`sl_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adm_companies`
--
ALTER TABLE `adm_companies`
  MODIFY `cp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `adm_cust_mob_add`
--
ALTER TABLE `adm_cust_mob_add`
  MODIFY `entry_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adm_mobile_defects`
--
ALTER TABLE `adm_mobile_defects`
  MODIFY `defect_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `adm_ph_models`
--
ALTER TABLE `adm_ph_models`
  MODIFY `mod_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `adm_product_category`
--
ALTER TABLE `adm_product_category`
  MODIFY `p_cat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `adm_prod_inv_cr_tran`
--
ALTER TABLE `adm_prod_inv_cr_tran`
  MODIFY `inv_cr_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adm_prod_sale_tran`
--
ALTER TABLE `adm_prod_sale_tran`
  MODIFY `sale_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_registration_hiteshora`
--
ALTER TABLE `customer_registration_hiteshora`
  MODIFY `cust_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust_kolors_retailer_credits_transactions`
--
ALTER TABLE `cust_kolors_retailer_credits_transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust_kolors_retailer_debits_transactions`
--
ALTER TABLE `cust_kolors_retailer_debits_transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust_kolors_retail_users`
--
ALTER TABLE `cust_kolors_retail_users`
  MODIFY `retailer_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust_kolors_services_list`
--
ALTER TABLE `cust_kolors_services_list`
  MODIFY `service_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cust_kolors_users_list`
--
ALTER TABLE `cust_kolors_users_list`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1004;

--
-- AUTO_INCREMENT for table `cust_retail_unlock_orders`
--
ALTER TABLE `cust_retail_unlock_orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_activity`
--
ALTER TABLE `login_activity`
  MODIFY `login_txn_num` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payment_modes`
--
ALTER TABLE `payment_modes`
  MODIFY `payment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prod_cart_temp`
--
ALTER TABLE `prod_cart_temp`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `store_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `sub_plan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscription_plan_history`
--
ALTER TABLE `subscription_plan_history`
  MODIFY `sl_no` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
