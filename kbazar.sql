-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 13, 2019 at 10:11 PM
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
-- Database: `prsol7yb_kbazar`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_tab`
--

CREATE TABLE `product_tab` (
  `pid` bigint(20) UNSIGNED NOT NULL,
  `rid` int(10) NOT NULL,
  `name` varchar(100)  NOT NULL,
  `price` float NOT NULL,
  `min_sale` float NOT NULL DEFAULT '1',
  `stock` float NOT NULL,
  `stock_uid` int(11) NOT NULL,
  `status` set('enabled','disabled') NOT NULL,
  `return_replace` set('only_returnable','only_replaceable','both','none')  NOT NULL,
  `description` text NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `retailer_failed_log`
--

CREATE TABLE `retailer_failed_log` (
  `ii` bigint(20) UNSIGNED NOT NULL,
  `rid` bigint(20) NOT NULL,
  `time` int(10) NOT NULL,
  `method` tinyint(4) NOT NULL
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
  `password` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `phone` bigint(10) UNSIGNED NOT NULL,
  `ac_status` set('initial','active','deactive','suspend','open','close') NOT NULL DEFAULT 'initial',
  `gender` set('male','female','other','') NOT NULL,
  `failed_attempt` tinyint(3) UNSIGNED NOT NULL DEFAULT '3',
  `flbt` int(10) UNSIGNED NOT NULL DEFAULT '600',
  `registation_date` int(10) NOT NULL
);

--
-- Dumping data for table `retailer_utab`
--

INSERT INTO `retailer_utab` (`rid`, `uname`, `password`, `name`, `phone`, `ac_status`, `gender`, `failed_attempt`, `flbt`, `registation_date`) VALUES
(1, 'testing', '$2y$08$34G74F1KP7NEPgN5arPBLekC.JU8OG4ulIigyZRkPMCoCU5MBUAk2', 'Test Account', 7908998497, 'active', 'male', 3, 600, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock_units`
--

CREATE TABLE `stock_units` (
  `suid` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(10) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `type` set('length','area','volumn','weight','other','count')  NOT NULL
);

--
-- Dumping data for table `stock_units`
--

INSERT INTO `stock_units` (`suid`, `name`, `symbol`, `type`) VALUES
(1, 'Packet', 'packet', 'count'),
(2, 'Piece', 'piece', 'count'),
(3, 'Dibba', 'dibba', 'count'),
(4, 'Bosta', 'bosta', 'count'),
(5, 'Kilogram', 'kilogram', 'weight'),
(6, 'Gram', 'gram', 'weight'),
(7, 'Miter', 'miter', 'length'),
(8, 'Feet', 'feet', 'length'),
(9, 'cm', 'cm', 'length'),
(10, 'Gauge', 'gauge', 'length'),
(11, 'Liter', 'liter', 'volumn');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `product_tab`
--
ALTER TABLE `product_tab`
  MODIFY `pid` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `retailer_failed_log`
--
ALTER TABLE `retailer_failed_log`
  MODIFY `ii` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
