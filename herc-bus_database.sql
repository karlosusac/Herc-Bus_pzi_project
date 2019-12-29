-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2019 at 09:04 PM
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
(14, 'karlosus', '1', 'Karlo', 'Sušac', '2@mail', '', 0),
(15, '123', '', '123', '123', '123@mail', '', 0),
(16, 'test123', '', '123', 'test', 't123@mail', '', 0);

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
(20, '18:40:00', '19:20:00', 45, 0, 1);

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
(75, '2019-12-25 23:16:10', 'd09bf41544a3365a46c9077ebb5e35c381c69420d3496e89430202205ddd99e1', 13),
(76, '2019-12-25 23:16:13', 'fbd7939d674997cdb4692d34de8633c41c6eb9b727983de061a31a7452cd8656', 13),
(77, '2019-12-25 23:16:18', '28dd2c7955ce926456240b2ff0100bdecaa9361d616e085aaea7453943e61476', 13),
(78, '2019-12-25 23:17:32', '35f4a8d465e6e1edc05f3d8ab658c5511c6eb9b727983de061a31a7452cd8656', 13),
(79, '2019-12-25 23:17:43', 'd1fe173d08e959397adf34b1d77e88d781c69420d3496e89430202205ddd99e1', 13),
(80, '2019-12-25 23:17:52', 'f033ab37c30201f73f142449d037028d81c69420d3496e89430202205ddd99e1', 13),
(81, '2019-12-25 23:18:13', '43ec517d68b6edd3015b3edc9a11367b2bd2fc3a30b75ea708875bd15ee72fdd', 13),
(82, '2019-12-25 23:18:15', '9778d5d219c5080b9a6a17bef029331c1c6eb9b727983de061a31a7452cd8656', 13),
(83, '2019-12-25 23:20:02', 'fe9fc289c3ff0af142b6d3bead98a9232513ab9e78e8dcb0857bde1ad4612f61', 13),
(84, '2019-12-25 23:23:06', '68d30a9594728bc39aa24be94b319d212bd2fc3a30b75ea708875bd15ee72fdd', 13),
(85, '2019-12-25 23:23:09', '3ef815416f775098fe977004015c61931c6eb9b727983de061a31a7452cd8656', 13),
(86, '2019-12-25 23:23:27', '93db85ed909c13838ff95ccfa94cebd9bafebf4d94ccfe0e4913e9e8e2d51e05', 13),
(87, '2019-12-25 23:24:06', 'c7e1249ffc03eb9ded908c236bd1996d81c69420d3496e89430202205ddd99e1', 13),
(88, '2019-12-25 23:25:06', '2a38a4a9316c49e5a833517c45d310702513ab9e78e8dcb0857bde1ad4612f61', 13),
(89, '2019-12-25 23:27:38', '7647966b7343c29048673252e490f7362bd2fc3a30b75ea708875bd15ee72fdd', 13),
(90, '2019-12-25 23:27:59', '8613985ec49eb8f757ae6439e879bb2a2513ab9e78e8dcb0857bde1ad4612f61', 13),
(91, '2019-12-26 20:10:37', '54229abfcfa5649e7003b83dd4755294bafebf4d94ccfe0e4913e9e8e2d51e05', 13),
(92, '2019-12-26 22:02:36', '92cc227532d17e56e07902b254dfad10caa9361d616e085aaea7453943e61476', 13),
(93, '2019-12-26 22:04:10', '98dce83da57b0395e163467c9dae521b2513ab9e78e8dcb0857bde1ad4612f61', 13),
(94, '2019-12-26 22:04:38', 'f4b9ec30ad9f68f89b29639786cb62ef2bd2fc3a30b75ea708875bd15ee72fdd', 13),
(95, '2019-12-26 22:10:35', '812b4ba287f5ee0bc9d43bbf5bbe87fb2513ab9e78e8dcb0857bde1ad4612f61', 13),
(96, '2019-12-26 22:11:57', '26657d5ff9020d2abefe558796b995842bd2fc3a30b75ea708875bd15ee72fdd', 13),
(97, '2019-12-26 22:12:03', 'e2ef524fbf3d9fe611d5a8e90fefdc9ccaa9361d616e085aaea7453943e61476', 13),
(98, '2019-12-26 22:12:58', 'ed3d2c21991e3bef5e069713af9fa6cacaa9361d616e085aaea7453943e61476', 13),
(99, '2019-12-26 22:23:30', 'ac627ab1ccbdb62ec96e702f07f6425b81c69420d3496e89430202205ddd99e1', 13),
(100, '2019-12-26 22:33:44', 'f899139df5e1059396431415e770c6ddcaa9361d616e085aaea7453943e61476', 13),
(101, '2019-12-26 22:34:58', '38b3eff8baf56627478ec76a704e9b521c6eb9b727983de061a31a7452cd8656', 13),
(102, '2019-12-26 22:41:27', 'ec8956637a99787bd197eacd77acce5ecaa9361d616e085aaea7453943e61476', 13),
(103, '2019-12-26 22:45:40', '6974ce5ac660610b44d9b9fed0ff95482bd2fc3a30b75ea708875bd15ee72fdd', 13),
(104, '2019-12-26 23:13:03', 'c9e1074f5b3f9fc8ea15d152add072941c6eb9b727983de061a31a7452cd8656', 13),
(105, '2019-12-26 23:13:35', '65b9eea6e1cc6bb9f0cd2a47751a186f2513ab9e78e8dcb0857bde1ad4612f61', 13),
(106, '2019-12-26 23:15:44', 'f0935e4cd5920aa6c7c996a5ee53a70f2bd2fc3a30b75ea708875bd15ee72fdd', 13),
(107, '2019-12-26 23:16:17', 'a97da629b098b75c294dffdc3e4639042bd2fc3a30b75ea708875bd15ee72fdd', 13),
(108, '2019-12-27 11:18:38', 'a3c65c2974270fd093ee8a9bf8ae7d0bbafebf4d94ccfe0e4913e9e8e2d51e05', 13),
(109, '2019-12-27 12:52:23', '2723d092b63885e0d7c260cc007e8b9d1c6eb9b727983de061a31a7452cd8656', 14),
(110, '2019-12-27 13:09:56', '5f93f983524def3dca464469d2cf9f3e1c6eb9b727983de061a31a7452cd8656', 14),
(111, '2019-12-27 16:10:57', '698d51a19d8a121ce581499d7b7016682bd2fc3a30b75ea708875bd15ee72fdd', 14),
(112, '2019-12-27 19:03:37', '7f6ffaa6bb0b408017b62254211691b52bd2fc3a30b75ea708875bd15ee72fdd', 14),
(113, '2019-12-27 19:34:51', '73278a4a86960eeb576a8fd4c9ec6997bafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(114, '2019-12-28 00:05:47', '5fd0b37cd7dbbb00f97ba6ce92bf5add81c69420d3496e89430202205ddd99e1', 14),
(115, '2019-12-28 11:47:18', '2b44928ae11fb9384c4cf38708677c48caa9361d616e085aaea7453943e61476', 14),
(116, '2019-12-28 11:57:39', 'c45147dee729311ef5b5c3003946c48f2513ab9e78e8dcb0857bde1ad4612f61', 15),
(117, '2019-12-28 12:12:32', 'eb160de1de89d9058fcb0b968dbbbd682513ab9e78e8dcb0857bde1ad4612f61', 16),
(118, '2019-12-28 12:25:37', '5ef059938ba799aaa845e1c2e8a762bdbafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(119, '2019-12-28 12:29:40', '07e1cd7dca89a1678042477183b7ac3fbafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(120, '2019-12-28 12:35:30', 'da4fb5c6e93e74d3df8527599fa6264281c69420d3496e89430202205ddd99e1', 14),
(121, '2019-12-28 18:48:04', '4c56ff4ce4aaf9573aa5dff913df997acaa9361d616e085aaea7453943e61476', 14),
(122, '2019-12-28 21:40:38', 'a0a080f42e6f13b3a2df133f073095dd81c69420d3496e89430202205ddd99e1', 14),
(123, '2019-12-29 09:58:41', '202cb962ac59075b964b07152d234b702bd2fc3a30b75ea708875bd15ee72fdd', 14),
(124, '2019-12-29 11:34:39', 'c8ffe9a587b126f152ed3d89a146b445caa9361d616e085aaea7453943e61476', 14),
(125, '2019-12-29 13:53:30', '3def184ad8f4755ff269862ea77393ddcaa9361d616e085aaea7453943e61476', 14),
(126, '2019-12-29 17:15:35', '069059b7ef840f0c74a814ec9237b6eccaa9361d616e085aaea7453943e61476', 14),
(127, '2019-12-29 17:15:48', 'ec5decca5ed3d6b8079e2e7e7bacc9f21c6eb9b727983de061a31a7452cd8656', 14),
(128, '2019-12-29 17:15:57', '76dc611d6ebaafc66cc0879c71b5db5c1c6eb9b727983de061a31a7452cd8656', 14),
(129, '2019-12-29 17:17:25', 'd1f491a404d6854880943e5c3cd9ca25bafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(130, '2019-12-29 17:18:14', '9b8619251a19057cff70779273e95aa681c69420d3496e89430202205ddd99e1', 14),
(131, '2019-12-29 17:18:41', '1afa34a7f984eeabdbb0a7d494132ee51c6eb9b727983de061a31a7452cd8656', 14),
(132, '2019-12-29 19:37:13', '65ded5353c5ee48d0b7d48c591b8f43081c69420d3496e89430202205ddd99e1', 14),
(133, '2019-12-29 19:41:53', '9fc3d7152ba9336a670e36d0ed79bc431c6eb9b727983de061a31a7452cd8656', 14),
(134, '2019-12-29 20:01:02', '02522a2b2726fb0a03bb19f2d8d9524d81c69420d3496e89430202205ddd99e1', 14),
(135, '2019-12-29 20:03:18', '7f1de29e6da19d22b51c68001e7e0e542bd2fc3a30b75ea708875bd15ee72fdd', 14),
(136, '2019-12-29 20:14:49', '42a0e188f5033bc65bf8d78622277c4e81c69420d3496e89430202205ddd99e1', 14),
(137, '2019-12-29 20:18:21', '3988c7f88ebcb58c6ce932b957b6f3322bd2fc3a30b75ea708875bd15ee72fdd', 13),
(138, '2019-12-29 20:20:01', '013d407166ec4fa56eb1e1f8cbe183b9bafebf4d94ccfe0e4913e9e8e2d51e05', 14),
(139, '2019-12-29 20:44:58', 'e00da03b685a0dd18fb6a08af0923de0caa9361d616e085aaea7453943e61476', 14);

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
  `stops_line_start_id` int(11) NOT NULL,
  `stops_line_stop_id` int(11) NOT NULL,
  `valid_date` date NOT NULL
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
  ADD KEY `ticket_stops_line_start_id` (`stops_line_start_id`),
  ADD KEY `ticket_stops_line_stop_id` (`stops_line_stop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `ticket_stops_line_start_id` FOREIGN KEY (`stops_line_start_id`) REFERENCES `stops_line` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_stops_line_stop_id` FOREIGN KEY (`stops_line_stop_id`) REFERENCES `stops_line` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
