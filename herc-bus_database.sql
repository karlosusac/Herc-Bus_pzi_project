-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2020 at 09:41 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

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
(1, 'Vrh Avenije', 'Žitomislići'),
(2, 'Vrh Avenije', 'Hodbina'),
(3, 'Vrh Avenije', 'Bačevići');

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
(1, '06:30:00', '06:50:00', 45, 1, 3),
(2, '06:50:00', '07:10:00', 45, 0, 3),
(3, '13:30:00', '13:50:00', 45, 1, 3),
(4, '13:50:00', '14:10:00', 45, 0, 3),
(5, '16:15:00', '16:35:00', 45, 1, 3),
(6, '16:35:00', '16:55:00', 45, 0, 3),
(7, '06:10:00', '06:50:00', 45, 1, 2),
(8, '06:50:00', '07:30:00', 45, 0, 2),
(9, '09:30:00', '10:00:00', 45, 1, 2),
(10, '10:00:00', '10:30:00', 45, 0, 2),
(11, '16:15:00', '16:45:00', 45, 1, 2),
(12, '16:45:00', '17:15:00', 45, 0, 2),
(13, '19:30:00', '20:00:00', 45, 1, 2),
(14, '20:00:00', '20:30:00', 45, 0, 2),
(15, '11:15:00', '11:50:00', 45, 1, 1),
(16, '11:50:00', '12:25:00', 45, 0, 1),
(17, '13:40:00', '14:20:00', 45, 1, 1),
(18, '14:20:00', '15:00:00', 45, 0, 1),
(19, '18:00:00', '18:40:00', 45, 1, 1),
(20, '18:40:00', '23:59:00', 45, 0, 1);

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
(191, '2020-01-03 21:41:32', '0aa1883c6411f7873cb83dacb17b0afc2513ab9e78e8dcb0857bde1ad4612f61', 13);

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
(1, 0, 1, 3),
(2, 1, 2, 3),
(3, 2, 3, 3),
(4, 3, 8, 3),
(5, 4, 9, 3),
(6, 5, 10, 3),
(7, 0, 1, 2),
(8, 1, 2, 2),
(9, 2, 3, 2),
(10, 3, 4, 2),
(11, 4, 5, 2),
(12, 5, 7, 2),
(13, 0, 1, 1),
(14, 1, 2, 1),
(15, 2, 3, 1),
(16, 3, 4, 1),
(17, 4, 5, 1),
(18, 5, 7, 1),
(19, 6, 6, 1);

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
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ID`, `account_id`, `schedule_id`, `autobusline_id`, `departure`, `destination`, `valid_date`, `purchased`, `price`) VALUES
(46, 14, 16, 1, 19, 13, '2020-01-06', '2020-01-03 21:41:07', 0),
(47, 14, 11, 2, 7, 8, '2020-01-10', '2020-01-03 21:41:17', 0),
(48, 14, 4, 3, 6, 2, '2020-01-17', '2020-01-03 21:41:26', 0);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `session_id`
--
ALTER TABLE `session_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `stops`
--
ALTER TABLE `stops`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stops_line`
--
ALTER TABLE `stops_line`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
