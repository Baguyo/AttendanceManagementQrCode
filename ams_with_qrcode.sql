-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2022 at 07:56 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ams_with_qrcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowance`
--

CREATE TABLE `allowance` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `allowance`
--

INSERT INTO `allowance` (`id`, `name`, `amount`) VALUES
(1, 'food', 1000),
(4, 'Transportation', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `appeal`
--

CREATE TABLE `appeal` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `reason` text NOT NULL,
  `time_status` varchar(64) NOT NULL,
  `time` time NOT NULL,
  `status` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appeal`
--

INSERT INTO `appeal` (`id`, `user_id`, `date`, `reason`, `time_status`, `time`, `status`) VALUES
(10, 64, '2022-07-08', 'brownout', 'first_time_out', '17:00:00', 'approve'),
(13, 64, '2022-07-15', 'brownout', 'first_time_in', '08:00:00', 'approve'),
(14, 64, '2022-07-15', 'brownout', 'first_time_out', '12:00:00', 'approve'),
(18, 64, '2022-08-07', 'brownout', 'first_time_out', '12:05:00', 'approve'),
(21, 64, '2022-08-11', 'brownout', 'second_time_out', '12:15:00', 'approve');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `first_time_in` time DEFAULT '00:00:00',
  `first_time_out` time DEFAULT '00:00:00',
  `second_time_in` time DEFAULT '00:00:00',
  `second_time_out` time DEFAULT '00:00:00',
  `third_time_in` time DEFAULT '00:00:00',
  `third_time_out` time DEFAULT '00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `date`, `first_time_in`, `first_time_out`, `second_time_in`, `second_time_out`, `third_time_in`, `third_time_out`) VALUES
(284, 63, '2022-07-02', '13:17:23', '13:18:21', '13:20:21', '13:21:32', '13:22:00', '14:27:54'),
(301, 64, '2022-07-06', '09:00:00', '12:00:00', '13:00:00', '18:00:00', '00:00:00', '00:00:00'),
(312, 64, '2022-07-15', '10:00:00', '11:30:00', '13:00:00', '15:00:00', '00:00:00', '00:00:00'),
(313, 64, '2022-08-07', '08:00:00', '17:00:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00'),
(317, 64, '2022-08-11', '11:47:00', '11:59:07', '12:08:29', '12:15:00', '00:00:00', '00:00:00'),
(318, 64, '2022-08-28', '09:22:41', '09:58:00', '00:00:00', '00:00:00', '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `deduction`
--

CREATE TABLE `deduction` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deduction`
--

INSERT INTO `deduction` (`id`, `name`, `amount`) VALUES
(1, 'Pag-ibig', 700),
(2, 'SSS', 500),
(18, 'Philhealth', 500);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(2, 'Accounting'),
(3, 'Hr department'),
(5, 'IT department');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  `rate_per_hour` int(11) NOT NULL,
  `rate_per_overtime` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `position_name`, `rate_per_hour`, `rate_per_overtime`, `department_id`, `time_start`, `time_end`) VALUES
(2, 'Web developer', 300, 400, 5, '08:00:00', '17:00:00'),
(6, 'Data analyst', 200, 300, 5, '08:00:00', '17:00:00'),
(7, 'test', 100, 150, 2, '08:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Date_and_time` datetime NOT NULL,
  `time_in_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `user_id`, `Date_and_time`, `time_in_image`) VALUES
(78, 0, '0000-00-00 00:00:00', 'report'),
(93, 0, '0000-00-00 00:00:00', 'report'),
(94, 0, '0000-00-00 00:00:00', 'report'),
(96, 0, '0000-00-00 00:00:00', 'report'),
(169, 0, '0000-00-00 00:00:00', 'report'),
(171, 0, '0000-00-00 00:00:00', 'report'),
(173, 0, '0000-00-00 00:00:00', 'report'),
(176, 0, '0000-00-00 00:00:00', 'report'),
(181, 0, '0000-00-00 00:00:00', 'report'),
(223, 0, '0000-00-00 00:00:00', 'report'),
(224, 24, '2022-05-21 09:10:18', 'reportchec20220521091018webcam.jpg'),
(225, 0, '0000-00-00 00:00:00', 'report'),
(226, 0, '0000-00-00 00:00:00', 'report'),
(227, 0, '0000-00-00 00:00:00', 'report'),
(228, 0, '0000-00-00 00:00:00', 'report'),
(229, 24, '2022-05-21 09:10:21', 'reportchec20220521091021webcam.jpg'),
(230, 0, '0000-00-00 00:00:00', 'report'),
(231, 24, '2022-05-21 09:10:23', 'reportchec20220521091023webcam.jpg'),
(233, 0, '0000-00-00 00:00:00', 'report'),
(240, 0, '0000-00-00 00:00:00', 'report'),
(255, 2, '2022-05-22 10:33:48', 'reportbaguyo20220522103348webcam.jpg'),
(256, 2, '2022-05-22 10:38:37', 'reportbaguyo20220522103837webcam.jpg'),
(257, 2, '2022-05-22 10:38:39', 'reportbaguyo20220522103839webcam.jpg'),
(258, 2, '2022-05-22 10:38:43', 'reportbaguyo20220522103843webcam.jpg'),
(259, 2, '2022-05-22 10:38:44', 'reportbaguyo20220522103844webcam.jpg'),
(260, 2, '2022-05-22 10:38:44', 'reportbaguyo20220522103844webcam.jpg'),
(261, 2, '2022-05-22 10:38:45', 'reportbaguyo20220522103845webcam.jpg'),
(262, 2, '2022-05-22 10:38:45', 'reportbaguyo20220522103845webcam.jpg'),
(273, 39, '2022-05-22 14:03:05', 'reportbaguyo20220522140305webcam.jpg'),
(274, 39, '2022-05-22 14:10:42', 'reportbaguyo20220522141042webcam.jpg'),
(275, 39, '2022-05-22 14:28:59', 'reportbaguyo20220522142859webcam.jpg'),
(276, 43, '2022-06-28 13:51:41', 'reportcheck20220628135141webcam.jpg'),
(277, 39, '2022-06-28 13:30:02', 'reportbaguyo20220628133002webcam.jpg'),
(278, 43, '2022-06-28 13:49:11', 'reportcheck20220628134911webcam.jpg'),
(279, 39, '2022-06-28 13:34:19', 'reportbaguyo20220628133419webcam.jpg'),
(280, 2, '2022-06-29 12:02:28', 'reportbaguyo20220629120228webcam.jpg'),
(281, 2, '2022-06-29 12:10:16', 'reportbaguyo20220629121016webcam.jpg'),
(282, 63, '0000-00-00 00:00:00', 'report'),
(283, 64, '0000-00-00 00:00:00', 'report'),
(284, 0, '0000-00-00 00:00:00', 'report'),
(285, 63, '0000-00-00 00:00:00', 'report');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `position` varchar(255) NOT NULL,
  `total_salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`id`, `user_id`, `date_from`, `date_to`, `position`, `total_salary`) VALUES
(24, 64, '2022-07-01', '2022-07-31', 'Web developer', 5598),
(25, 64, '2022-07-01', '2022-08-07', 'Web developer', 6822),
(28, 64, '2022-08-01', '2022-08-16', 'Web developer', 2490);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) NOT NULL,
  `qrcode_path` text NOT NULL,
  `position_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `user_role`, `user_image`, `qr_code`, `qrcode_path`, `position_id`) VALUES
(1, 'emerson', '$2y$11$sMxD3hLqubFnNyjp01PNR.H0Y46x5WGxy0DqaDQWgUM1NUDYZw3c2', 'emerson123', 'emerson123', 'admin', 'pic1.png', '', '', 0),
(64, 'checking', '$2y$11$UYlcUnp0NDtM.4XhN68LU.WH/irFpUgOxM8xdav8KL4TsjW9KvZ9q', 'checking', 'checking', 'user', 'adbmsyPrelim.png', 'efb9fc9765881e7a4bd3216c370927fb', '64checkingchecking.png', 2),
(69, 'test', '$2y$11$C9Fl88JKM.GsTeMazqdnluxrGEziS0uiNwjyM6aayXoksQiipSEKm', 'tes', 'TEST', 'user', '', 'e50e8f3231a51a912ae83b41a0983ac7', '69tesTEST.png', 0),
(74, 'With position', '$2y$11$eOcJjO9gWS6YGwRDjChZveB4jFXr3m3grywCszRoque0lf9kPqzEi', 'With position', 'With position', 'user', '', '77456c9ec4f37c978f5910d758f83dac', '74With positionWith position.png', 2),
(77, 'baguyo', '$2y$11$7wd1A//eA0/jdWwMv4TY7.8TL1aacrSOj0I2//QREgAWkWITvHjd6', 'baguyo', 'baguyo', 'admin', '', 'ab7d4aa8c487a6e0f637f9427c6b4602', '77baguyobaguyo.png', 0),
(78, 'janedoe', '$2y$11$lx2SOu629dqMxl2RSfTWU.2fq2OcshUzTSor1ByUtUfj/0Z/B9cN2', 'jane', 'doe', 'user', '', 'a8c0d2a9d332574951a8e4a0af7d516f', '78janedoe.png', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_allowance`
--

CREATE TABLE `user_allowance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `allowance_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_allowance`
--

INSERT INTO `user_allowance` (`id`, `user_id`, `allowance_id`) VALUES
(6, 74, 1),
(7, 74, 4),
(8, 64, 1),
(9, 64, 4),
(15, 78, 1),
(16, 78, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_deduction`
--

CREATE TABLE `user_deduction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deduction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_deduction`
--

INSERT INTO `user_deduction` (`id`, `user_id`, `deduction_id`) VALUES
(67, 74, 1),
(68, 74, 2),
(69, 64, 1),
(70, 64, 2),
(71, 64, 18),
(81, 69, 1),
(82, 69, 2),
(83, 69, 18),
(84, 78, 2),
(85, 78, 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allowance`
--
ALTER TABLE `allowance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appeal`
--
ALTER TABLE `appeal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduction`
--
ALTER TABLE `deduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_allowance`
--
ALTER TABLE `user_allowance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_allowance_ibfk_1` (`user_id`),
  ADD KEY `allowance_id` (`allowance_id`);

--
-- Indexes for table `user_deduction`
--
ALTER TABLE `user_deduction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deduction_id` (`deduction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allowance`
--
ALTER TABLE `allowance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `appeal`
--
ALTER TABLE `appeal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `deduction`
--
ALTER TABLE `deduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `user_allowance`
--
ALTER TABLE `user_allowance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_deduction`
--
ALTER TABLE `user_deduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_allowance`
--
ALTER TABLE `user_allowance`
  ADD CONSTRAINT `user_allowance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_allowance_ibfk_2` FOREIGN KEY (`allowance_id`) REFERENCES `allowance` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_deduction`
--
ALTER TABLE `user_deduction`
  ADD CONSTRAINT `user_deduction_ibfk_1` FOREIGN KEY (`deduction_id`) REFERENCES `deduction` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_deduction_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
