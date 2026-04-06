-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 05, 2026 at 07:49 PM
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
-- Database: `mathewbo_masterDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `USER_ID` int(11) NOT NULL,
  `NAME` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PASSWORD` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `RANK` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`USER_ID`, `NAME`, `EMAIL`, `PASSWORD`, `RANK`) VALUES
(3, 'mathew', 'boulliermathew@gmail.com', '$2y$10$6VEk/tSIXcBvt0ewnJsXFufKcNl66MSZ70h.12hIQefSGmjSCyeba', 1),
(4, 'Jammie Boullier', 'sunnydayz6048@gmail.com', '$2y$10$caaD9br.LDduire28HUje.BP5aMzDt6RmHkyWQpQ7ElR/9pF38x3S', 0),
(5, 'Kyra Johnson', 'kyrab10@yahoo.com', '$2y$10$4VkHjd8z3enIG9D/rLywA.x9gGJUHVfWLFUfBuF6gJIbqnsHudu86', 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `ANNOUNCEMENT_ID` int(11) NOT NULL,
  `HEADER` text COLLATE utf8_unicode_ci NOT NULL,
  `MESSAGE` text COLLATE utf8_unicode_ci NOT NULL,
  `DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='The announcements displayed on the site.';

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`ANNOUNCEMENT_ID`, `HEADER`, `MESSAGE`, `DATE`) VALUES
(1, 'Spring Sale', '20% off any blonding service until 4/30/2026', '2026-04-05');

-- --------------------------------------------------------

--
-- Table structure for table `operation_hours`
--

CREATE TABLE `operation_hours` (
  `DAY` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') COLLATE utf8_unicode_ci NOT NULL,
  `OPEN?` tinyint(1) NOT NULL,
  `OPEN_TIME` text COLLATE utf8_unicode_ci NOT NULL,
  `CLOSE_TIME` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `operation_hours`
--

INSERT INTO `operation_hours` (`DAY`, `OPEN?`, `OPEN_TIME`, `CLOSE_TIME`) VALUES
('Tuesday', 1, '9:00 am', '5:00 pm'),
('Wednesday', 0, '9:00 am', '5:00 pm'),
('Thursday', 1, '9:00 am', '5:00 pm'),
('Friday', 1, '9:00 am', '5:00 pm'),
('Saturday', 1, '9:00 am', '5:00 pm'),
('Sunday', 0, '9:00 am', '5:00 pm'),
('Monday', 0, '10:00 am', '5:00 pm');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ORDER_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ORDER_STATUS` enum('pending','confirmed','completed','cancelled') COLLATE utf8_unicode_ci DEFAULT 'pending',
  `TOTAL` decimal(10,2) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ORDER_ID`, `USER_ID`, `ORDER_STATUS`, `TOTAL`, `CREATED_AT`) VALUES
(1, 3, 'pending', 150.00, '2026-04-05 23:25:34'),
(2, 3, 'pending', 585.00, '2026-04-05 23:27:58');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `ITEM_ID` int(11) NOT NULL,
  `ORDER_ID` int(11) NOT NULL,
  `SERVICE_ID` int(11) NOT NULL,
  `PRICE_CHARGED` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`ITEM_ID`, `ORDER_ID`, `SERVICE_ID`, `PRICE_CHARGED`) VALUES
(1, 1, 10, 150.00),
(2, 2, 10, 150.00),
(3, 2, 6, 135.00),
(4, 2, 20, 300.00);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `SERVICE_ID` int(11) NOT NULL,
  `CATEGORY` enum('Styling','Blonding','Color','Treatment') COLLATE utf8_unicode_ci NOT NULL,
  `NAME` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PRICE` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`SERVICE_ID`, `CATEGORY`, `NAME`, `PRICE`) VALUES
(1, 'Styling', 'Women\'s Cut & Blowout', 55),
(2, 'Styling', 'Child\'s Cut & Blowout', 25),
(3, 'Styling', 'Style Out', 40),
(4, 'Styling', 'Updo', 85),
(5, 'Blonding', 'Face Framing Highlights', 85),
(6, 'Blonding', 'Half Head Highlights', 135),
(7, 'Blonding', 'Full Head Highlights', 175),
(8, 'Blonding', 'Partial Balayage', 145),
(9, 'Blonding', 'Balayage', 195),
(10, 'Blonding', 'Global Retouch', 150),
(11, 'Blonding', 'Global Lighten', 225),
(12, 'Blonding', 'Color Correction', 220),
(13, 'Color', 'Retouch Application', 70),
(14, 'Color', 'First Time Application', 100),
(15, 'Color', 'Maintenance Session', 65),
(16, 'Color', 'Color Balancing', 55),
(17, 'Color', 'Root Smudge or Tap', 40),
(18, 'Treatment', 'Conditioning Treatment', 15),
(19, 'Treatment', 'Keratin Express', 125),
(20, 'Treatment', 'Keratin (Shampoo + Conditioner)', 300);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`ANNOUNCEMENT_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ORDER_ID`),
  ADD KEY `USER_ID` (`USER_ID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`ITEM_ID`),
  ADD KEY `ORDER_ID` (`ORDER_ID`),
  ADD KEY `SERVICE_ID` (`SERVICE_ID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`SERVICE_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `ANNOUNCEMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ORDER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `ITEM_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `SERVICE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `accounts` (`USER_ID`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`ORDER_ID`) REFERENCES `orders` (`ORDER_ID`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`SERVICE_ID`) REFERENCES `services` (`SERVICE_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
