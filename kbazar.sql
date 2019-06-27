-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 28, 2019 at 01:08 AM
-- Server version: 8.0.11
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kbazar`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_failed_log`
--

CREATE TABLE `customer_failed_log` (
  `ii` bigint(20) UNSIGNED NOT NULL,
  `cid` bigint(20) UNSIGNED NOT NULL,
  `time` int(10) UNSIGNED NOT NULL,
  `method` tinyint(4) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_utab`
--

CREATE TABLE `customer_utab` (
  `cid` bigint(20) UNSIGNED NOT NULL,
  `uname` varchar(30) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(30) NOT NULL,
  `phone` bigint(10) UNSIGNED NOT NULL,
  `ac_status` set('initial','active','deactive','suspend','open','close') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'initial',
  `gender` set('male','female','other','') NOT NULL,
  `failed_attempt` tinyint(3) UNSIGNED NOT NULL DEFAULT '3',
  `flbt` int(10) UNSIGNED NOT NULL DEFAULT '600',
  `registation_date` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oid_status`
--

CREATE TABLE `oid_status` (
  `oid` bigint(20) UNSIGNED NOT NULL,
  `status` set('New','Accepted','Rejected','Picked','Delevered','Canceled','Refund Requested','Refund Accepted','Refund Rejected','Refund Picked','Refunded','Replace Requested','Replace Accepted','Replace Rejected','Replace Picked','Exchanged','Replaced') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `who` set('Customer','Shop Owner','Delevery Man','SYSTEM') NOT NULL,
  `datetime` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `oid_status`
--

INSERT INTO `oid_status` (`oid`, `status`, `who`, `datetime`) VALUES
(1, 'New', 'Customer', 1561188051),
(1, 'Accepted', 'Shop Owner', 1561188056),
(1, 'Canceled', 'SYSTEM', 1561206383),
(1, 'Refund Requested', 'Customer', 1561544120),
(1, 'Refund Accepted', 'Shop Owner', 1561544180),
(1, 'Refund Picked', 'Delevery Man', 1561614689),
(1, 'Refunded', 'Shop Owner', 1561664187),
(2, 'New', 'Customer', 1561205726),
(2, 'Accepted', 'Shop Owner', 1561526390);

-- --------------------------------------------------------

--
-- Table structure for table `order_tab`
--

CREATE TABLE `order_tab` (
  `oid` bigint(20) UNSIGNED NOT NULL,
  `pid` bigint(20) UNSIGNED NOT NULL,
  `cid` bigint(20) UNSIGNED NOT NULL,
  `status` set('New','Accepted','Rejected','Picked','Delevered','Canceled','Refund Requested','Refund Accepted','Refund Rejected','Refund Picked','Refunded','Replace Requested','Replace Accepted','Replace Rejected','Replace Picked','Exchanged','Replaced') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `order_data` json NOT NULL,
  `datetime` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_tab`
--

INSERT INTO `order_tab` (`oid`, `pid`, `cid`, `status`, `order_data`, `datetime`) VALUES
(1, 51, 2, 'Canceled', '{\"cid\": 2, \"pid\": 51, \"ppu\": 25, \"suid\": 2, \"ordered_unit\": 6}', 1558368439),
(2, 50, 5, 'Accepted', '{\"cid\": 5, \"pid\": 50, \"ppu\": 12, \"suid\": 1, \"ordered_unit\": 2}', 1561205675);

-- --------------------------------------------------------

--
-- Table structure for table `product_tab`
--

CREATE TABLE `product_tab` (
  `pid` bigint(20) UNSIGNED NOT NULL,
  `rid` int(10) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `price` float UNSIGNED NOT NULL,
  `min_sale` float UNSIGNED NOT NULL DEFAULT '1',
  `stock` float NOT NULL,
  `stock_uid` int(2) UNSIGNED NOT NULL,
  `status` set('enabled','disabled') NOT NULL,
  `return_replace` set('only_returnable','only_replaceable','both','none') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_tab`
--

INSERT INTO `product_tab` (`pid`, `rid`, `name`, `price`, `min_sale`, `stock`, `stock_uid`, `status`, `return_replace`, `description`) VALUES
(50, 1, 'nnnn', 12, 1, 125, 8, 'enabled', 'both', 'ddddddddddddddd'),
(51, 1, 'Lifebuoy 100G', 25, 1, 23, 2, 'disabled', 'none', 'ddddddde'),
(72, 1, 'ttttttttt', 444, 1, 0, 10, 'enabled', 'both', 'jdgfjd gfj'),
(74, 1, 'ttttttttt', 444, 1, 8888, 10, 'disabled', 'both', 'jdgfjd gfj'),
(75, 1, 'Mobile', 5500, 2, 10, 2, 'disabled', 'both', 'Description'),
(76, 1, 'Logitech wireless mouse m235', 550, 1, 10, 2, 'enabled', 'both', 'Description'),
(77, 1, 'Drug', 1000, 100, 10, 2, 'enabled', 'both', 'Drug'),
(78, 1, 'Drug', 1000, 100, 2, 6, 'enabled', 'both', 'Drug'),
(79, 1, 'Koken', 10, 10, 500, 3, 'enabled', 'both', 'he he he'),
(80, 1, 'eeeee', 10, 1, 111, 11, 'enabled', 'both', 'dbSb'),
(81, 1, 'xcbxcbxcb', 111, 11, 111, 11, 'enabled', 'both', 'v   bbb'),
(83, 1, 'qqq', 44, 14, 44, 10, 'enabled', 'both', 'ooooooooooo'),
(84, 1, 'zdvd', 7, 15353, 53, 10, 'enabled', 'both', '533753'),
(85, 1, 'ssafafadf', 5, 154, 45, 9, 'enabled', 'both', 'sdfsfD'),
(86, 1, 'bSBB', 2, 12786, 5, 10, 'enabled', 'both', '278'),
(88, 1, 'aaaaa', 6, 17862, 3, 10, 'enabled', 'both', '786'),
(89, 1, 'aaaaa', 546, 1876, 26, 3, 'enabled', 'both', '786286'),
(90, 1, 'sasasasd', 868, 16292, 68, 9, 'enabled', 'both', '92\n9'),
(93, 1, 'zzzzzz', 5343, 1454, 4345, 11, 'enabled', 'both', '53534345'),
(94, 1, 'www', 1, 1, 1, 11, 'enabled', 'both', '1'),
(98, 1, 'eeeee', 774, 15, 55, 10, 'enabled', 'none', '0000000000'),
(100, 1, '1', 1, 1, 1, 9, 'enabled', 'only_replaceable', '1'),
(113, 1, 'new name can\'t be', 3, 1, 1, 7, 'disabled', 'none', '1'),
(123, 1, 'ark', 10, 0, 1, 2, 'enabled', 'only_returnable', 'null'),
(125, 1, 'dghh', 45, 1, 7, 1, 'enabled', 'none', ''),
(128, 1, 'asfa', 8, 1, 787, 9, 'enabled', 'only_returnable', ''),
(129, 1, '2200\'', 56, 1, 2000, 7, 'enabled', 'only_returnable', '');

-- --------------------------------------------------------

--
-- Table structure for table `retailer_failed_log`
--

CREATE TABLE `retailer_failed_log` (
  `ii` bigint(20) UNSIGNED NOT NULL,
  `rid` bigint(20) UNSIGNED NOT NULL,
  `time` int(10) UNSIGNED NOT NULL,
  `method` tinyint(4) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retailer_failed_log`
--

INSERT INTO `retailer_failed_log` (`ii`, `rid`, `time`, `method`) VALUES
(1, 1, 1540984618, 0),
(2, 1, 1554905342, 0);

-- --------------------------------------------------------

--
-- Table structure for table `retailer_utab`
--

CREATE TABLE `retailer_utab` (
  `rid` bigint(20) UNSIGNED NOT NULL,
  `uname` varchar(30) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(30) NOT NULL,
  `store_name` varchar(50) NOT NULL,
  `phone` bigint(10) UNSIGNED NOT NULL,
  `ac_status` set('initial','active','deactive','suspend','open','close') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'initial',
  `gender` set('male','female','other','') NOT NULL,
  `failed_attempt` tinyint(3) UNSIGNED NOT NULL DEFAULT '3',
  `flbt` int(10) UNSIGNED NOT NULL DEFAULT '600',
  `registation_date` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `retailer_utab`
--

INSERT INTO `retailer_utab` (`rid`, `uname`, `password`, `name`, `store_name`, `phone`, `ac_status`, `gender`, `failed_attempt`, `flbt`, `registation_date`) VALUES
(1, 'testing', '$2y$08$N164xGqoAW0Ejde/m5R.T.g9aNPPMPmKT9G9w4W.Ulu8jaKRXWNjm', 'Test Account', 'My Store new', 7908998497, 'active', 'male', 3, 600, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock_units`
--

CREATE TABLE `stock_units` (
  `suid` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(10) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `type` set('length','area','volumn','weight','other','count') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock_units`
--

INSERT INTO `stock_units` (`suid`, `name`, `symbol`, `type`) VALUES
(1, 'Packet', 'packet', 'count'),
(2, 'Piece', 'piece', 'count'),
(3, 'Dibba', 'dibba', 'count'),
(4, 'Bosta', 'bosta', 'count'),
(5, 'Kilogram', 'kilogram', 'weight'),
(6, 'Gram', 'g', 'weight'),
(7, 'Miter', 'miter', 'length'),
(8, 'Feet', 'feet', 'length'),
(9, 'cm', 'cm', 'length'),
(10, 'Gauge', 'gauge', 'length'),
(11, 'Liter', 'liter', 'volumn');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_failed_log`
--
ALTER TABLE `customer_failed_log`
  ADD PRIMARY KEY (`ii`),
  ADD UNIQUE KEY `ii` (`ii`);

--
-- Indexes for table `customer_utab`
--
ALTER TABLE `customer_utab`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `cid` (`cid`),
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indexes for table `oid_status`
--
ALTER TABLE `oid_status`
  ADD PRIMARY KEY (`oid`,`datetime`),
  ADD UNIQUE KEY `oid` (`oid`,`datetime`);

--
-- Indexes for table `order_tab`
--
ALTER TABLE `order_tab`
  ADD PRIMARY KEY (`oid`),
  ADD UNIQUE KEY `oid` (`oid`);

--
-- Indexes for table `product_tab`
--
ALTER TABLE `product_tab`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `pid` (`pid`);

--
-- Indexes for table `retailer_failed_log`
--
ALTER TABLE `retailer_failed_log`
  ADD PRIMARY KEY (`ii`),
  ADD UNIQUE KEY `ii` (`ii`);

--
-- Indexes for table `retailer_utab`
--
ALTER TABLE `retailer_utab`
  ADD PRIMARY KEY (`rid`),
  ADD UNIQUE KEY `rid` (`rid`),
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indexes for table `stock_units`
--
ALTER TABLE `stock_units`
  ADD PRIMARY KEY (`suid`),
  ADD UNIQUE KEY `suid` (`suid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_failed_log`
--
ALTER TABLE `customer_failed_log`
  MODIFY `ii` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer_utab`
--
ALTER TABLE `customer_utab`
  MODIFY `cid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_tab`
--
ALTER TABLE `order_tab`
  MODIFY `oid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_tab`
--
ALTER TABLE `product_tab`
  MODIFY `pid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `retailer_failed_log`
--
ALTER TABLE `retailer_failed_log`
  MODIFY `ii` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `retailer_utab`
--
ALTER TABLE `retailer_utab`
  MODIFY `rid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_units`
--
ALTER TABLE `stock_units`
  MODIFY `suid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
