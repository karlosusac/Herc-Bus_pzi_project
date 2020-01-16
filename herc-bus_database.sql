-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2020 at 09:39 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `herc-bus_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `ID` int(11) NOT NULL,
  `account_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `e_mail` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`ID`, `account_name`, `password`, `name`, `lastname`, `e_mail`, `phone_number`, `admin`) VALUES
(13, '1', '1', 'Patak', 'Sharko', '1@mail', '', 0),
(14, 'karlosus', '1', 'Karlo', 'Sušac', '2@mail', '', 1),
(17, 'igorvasic', '1', 'Igor', 'Vasić', 'igorvasic@mail.com', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `autobus_line`
--

CREATE TABLE `autobus_line` (
  `ID` int(11) NOT NULL,
  `start` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `stop` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `autobus_line`
--

INSERT INTO `autobus_line` (`ID`, `start`, `stop`) VALUES
(27, 'Vrh Avenije', 'Hodbina'),
(28, 'Vrh Avenije', 'Žitomislići');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ID` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `stop_time` time NOT NULL,
  `number_of_seats` int(11) NOT NULL DEFAULT 45,
  `direction` tinyint(1) NOT NULL DEFAULT 1,
  `autobus_line_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ID`, `start_time`, `stop_time`, `number_of_seats`, `direction`, `autobus_line_id`) VALUES
(77, '06:00:00', '06:30:00', 45, 1, 27),
(83, '06:40:00', '07:30:00', 45, 0, 28),
(75, '08:00:00', '08:30:00', 45, 0, 27),
(76, '10:00:00', '10:30:00', 45, 0, 27),
(84, '11:50:00', '12:30:00', 45, 0, 28),
(78, '15:15:00', '16:00:00', 45, 1, 27),
(82, '15:15:00', '16:00:00', 45, 1, 28),
(85, '19:15:00', '20:10:00', 45, 1, 28);

-- --------------------------------------------------------

--
-- Table structure for table `session_id`
--

CREATE TABLE `session_id` (
  `id` int(11) NOT NULL,
  `login_date` datetime NOT NULL,
  `token` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `session_id`
--

INSERT INTO `session_id` (`id`, `login_date`, `token`, `account_id`) VALUES
(190, '2020-01-03 21:40:58', 'cfecdb276f634854f3ef915e2e980c312bd2fc3a30b75ea708875bd15ee72fdd', 14),
(191, '2020-01-03 21:41:32', '0aa1883c6411f7873cb83dacb17b0afc2513ab9e78e8dcb0857bde1ad4612f61', 13),
(192, '2020-01-12 09:36:02', '58a2fc6ed39fd083f55d4182bf88826dbafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(193, '2020-01-12 15:26:57', 'bd686fd640be98efaae0091fa301e6132513ab9e78e8dcb0857bde1ad4612f61', 14),
(194, '2020-01-12 15:28:34', 'a597e50502f5ff68e3e25b9114205d4a81c69420d3496e89430202205ddd99e1', 14),
(195, '2020-01-12 16:54:22', '0336dcbab05b9d5ad24f4333c7658a0e81c69420d3496e89430202205ddd99e1', 14),
(196, '2020-01-13 15:22:07', '084b6fbb10729ed4da8c3d3f5a3ae7c9bafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(197, '2020-01-14 19:57:31', '85d8ce590ad8981ca2c8286f79f599542bd2fc3a30b75ea708875bd15ee72fdd', 14),
(198, '2020-01-15 07:27:12', '0e65972dce68dad4d52d063967f0a7051c6eb9b727983de061a31a7452cd8656', 14),
(199, '2020-01-15 07:59:11', '84d9ee44e457ddef7f2c4f25dc8fa8652bd2fc3a30b75ea708875bd15ee72fdd', 14),
(200, '2020-01-15 08:08:56', '3644a684f98ea8fe223c713b77189a772bd2fc3a30b75ea708875bd15ee72fdd', 14),
(201, '2020-01-15 13:37:24', '757b505cfd34c64c85ca5b5690ee52932513ab9e78e8dcb0857bde1ad4612f61', 14),
(202, '2020-01-15 18:11:33', '854d6fae5ee42911677c739ee1734486caa9361d616e085aaea7453943e61476', 14),
(203, '2020-01-15 21:02:16', 'e2c0be24560d78c5e599c2a9c9d0bbd2bafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(204, '2020-01-16 09:18:24', '274ad4786c3abca69fa097b85867d9a4bafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(205, '2020-01-16 11:26:33', 'eae27d77ca20db309e056e3d2dcd7d69bafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(206, '2020-01-16 19:05:41', '7eabe3a1649ffa2b3ff8c02ebfd5659f2513ab9e78e8dcb0857bde1ad4612f61', 14),
(207, '2020-01-16 21:35:27', '69adc1e107f7f7d035d7baf04342e1ca81c69420d3496e89430202205ddd99e1', 14);

-- --------------------------------------------------------

--
-- Table structure for table `stops`
--

CREATE TABLE `stops` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `zone` int(11) NOT NULL DEFAULT 1,
  `position_x` float(10,6) NOT NULL,
  `position_y` float(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stops`
--

INSERT INTO `stops` (`ID`, `name`, `zone`, `position_x`, `position_y`) VALUES
(1, 'Vrh Avenije', 1, 43.351955, 17.801451),
(2, 'Ekonomska škola', 1, 43.346813, 17.799950),
(3, 'Španjolski trg', 1, 43.343651, 17.807203),
(4, 'Ortiješ', 2, 43.265862, 17.835772),
(5, 'Buna', 2, 43.250278, 17.836960),
(6, 'Žitomislići', 3, 43.206551, 17.793585),
(7, 'Hodbina', 2, 43.231480, 17.851431),
(8, 'Kolonija', 2, 43.322701, 17.820341),
(9, 'Aluminij', 2, 43.280354, 17.831245),
(10, 'Bačevići', 3, 43.271332, 17.823334);

-- --------------------------------------------------------

--
-- Table structure for table `stops_line`
--

CREATE TABLE `stops_line` (
  `ID` int(11) NOT NULL,
  `position_order` int(11) NOT NULL,
  `stops_id` int(11) NOT NULL,
  `autobus_line_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stops_line`
--

INSERT INTO `stops_line` (`ID`, `position_order`, `stops_id`, `autobus_line_id`) VALUES
(127, 0, 1, 27),
(128, 1, 2, 27),
(129, 2, 3, 27),
(130, 3, 4, 27),
(131, 4, 5, 27),
(132, 5, 7, 27),
(140, 0, 1, 28),
(141, 1, 2, 28),
(142, 2, 3, 28),
(143, 3, 4, 28),
(144, 4, 5, 28),
(145, 5, 7, 28),
(146, 6, 6, 28);

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ID` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `autobusline_id` int(11) NOT NULL,
  `departure` int(11) NOT NULL,
  `destination` int(11) NOT NULL,
  `valid_date` date NOT NULL,
  `purchased` datetime NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `account_name` (`account_name`),
  ADD UNIQUE KEY `e-mail` (`e_mail`);

--
-- Indexes for table `autobus_line`
--
ALTER TABLE `autobus_line`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique` (`start_time`,`stop_time`,`number_of_seats`,`direction`,`autobus_line_id`) USING BTREE,
  ADD KEY `schedule_autobus_line_id` (`autobus_line_id`);

--
-- Indexes for table `session_id`
--
ALTER TABLE `session_id`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id-account` (`account_id`);

--
-- Indexes for table `stops`
--
ALTER TABLE `stops`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `stops_line`
--
ALTER TABLE `stops_line`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `stops_line_autobus_id` (`autobus_line_id`),
  ADD KEY `stops_line_stops_id` (`stops_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ticket_autobus_line_id` (`autobusline_id`),
  ADD KEY `ticket_account_id` (`account_id`),
  ADD KEY `ticket_schedule_id` (`schedule_id`),
  ADD KEY `ticket_stops_line_start_id` (`departure`),
  ADD KEY `ticket_stops_line_stop_id` (`destination`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `autobus_line`
--
ALTER TABLE `autobus_line`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `session_id`
--
ALTER TABLE `session_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT for table `stops`
--
ALTER TABLE `stops`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stops_line`
--
ALTER TABLE `stops_line`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_autobus_line_id` FOREIGN KEY (`autobus_line_id`) REFERENCES `autobus_line` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `session_id`
--
ALTER TABLE `session_id`
  ADD CONSTRAINT `session_id-account` FOREIGN KEY (`account_id`) REFERENCES `account` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stops_line`
--
ALTER TABLE `stops_line`
  ADD CONSTRAINT `stops_line_autobus_id` FOREIGN KEY (`autobus_line_id`) REFERENCES `autobus_line` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stops_line_stops_id` FOREIGN KEY (`stops_id`) REFERENCES `stops` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_account_id` FOREIGN KEY (`account_id`) REFERENCES `account` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_autobus_line_id` FOREIGN KEY (`autobusline_id`) REFERENCES `autobus_line` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_schedule_id` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_stops_line_start_id` FOREIGN KEY (`departure`) REFERENCES `stops_line` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_stops_line_stop_id` FOREIGN KEY (`destination`) REFERENCES `stops_line` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
