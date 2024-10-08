-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 05:46 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `parking_log`
--

CREATE TABLE `parking_log` (
  `parking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_mv_file` int(11) NOT NULL,
  `time_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_out` timestamp NULL DEFAULT NULL,
  `username` text NOT NULL,
  `parking_date` date NOT NULL,
  `vehicle_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking_log`
--

INSERT INTO `parking_log` (`parking_id`, `user_id`, `user_mv_file`, `time_in`, `time_out`, `username`, `parking_date`, `vehicle_type`) VALUES
(1, 5, 21212121, '2024-09-23 03:04:12', NULL, 'Jobert Simbre', '2024-09-23', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_type` int(11) NOT NULL DEFAULT 2,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `middlename` varchar(32) NOT NULL,
  `department` int(2) NOT NULL,
  `year_group` int(2) NOT NULL,
  `section` int(2) NOT NULL,
  `mv_file` text NOT NULL,
  `body_number` text NOT NULL,
  `vehicle_type` int(2) NOT NULL,
  `user_status` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `created_at`, `updated_at`, `user_type`, `firstname`, `lastname`, `middlename`, `department`, `year_group`, `section`, `mv_file`, `body_number`, `vehicle_type`, `user_status`) VALUES
(1, 'admin@access.com', '$2y$10$N.SRTPJ9o63NISilP0gH..1naevj1Juu/k7N3un19QWW0aoqhptNq', '2024-09-08 15:37:38', '2024-09-08 15:37:38', 1, '', '', '', 0, 0, 0, '', '', 0, 1),
(6, 'jobert.simbre14@gmail.com', '$2y$10$di8sBOBiMq0MqNjlAqf4w.tH3HEwJP4V3lUCD2wx4Kjocf4ZWkHxe', '2024-09-23 03:53:08', '2024-09-23 03:53:08', 2, 'Jobert', 'Simbre', 'Gosuico', 1, 4, 1, '12312312', '21321123', 2, 0),
(7, 'jobert.simbre014@gmail.com', '$2y$10$ZMBB55Yf7bmlcDy919eNX.er8327PLqVNhXpy8bZ5S9D3e0SiFhpC', '2024-09-19 18:40:35', '2024-09-29 18:40:35', 2, 'Jebert', 'Smbre', 'Gosuica', 1, 1, 3, '12312312', '312312', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_d_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `middlename` varchar(32) NOT NULL,
  `department` int(2) NOT NULL,
  `year_group` int(2) NOT NULL,
  `section` varchar(32) NOT NULL,
  `mv_file` varchar(32) NOT NULL,
  `body_number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_d_id`, `user_id`, `firstname`, `lastname`, `middlename`, `department`, `year_group`, `section`, `mv_file`, `body_number`) VALUES
(1, 3, 'Jobert', 'Simbre', 'Gosuico', 1, 1, '1', '12312312', '21321123'),
(2, 4, 'Jobert', 'Simbre', 'Gosuico', 1, 1, '1', '12312312', '12312312');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `user_log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `action` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`user_log_id`, `user_id`, `username`, `action`) VALUES
(46, 1, 'Administrator', 'Logged out on the system'),
(47, 6, 'Jobert Simbre', 'Logged to the system'),
(48, 6, 'Jobert Simbre', 'Logged out on the system'),
(49, 6, 'Jobert Simbre', 'Logged to the system'),
(50, 6, 'Jobert Simbre', 'Logged out on the system'),
(51, 1, 'Administrator', 'Logged to the system'),
(52, 1, 'Administrator', 'Logged out on the system'),
(53, 6, 'Jobert Simbre', 'Logged to the system'),
(54, 1, 'Administrator', 'Logged to the system'),
(55, 1, 'Administrator', 'Logged out on the system'),
(56, 1, ' ', 'Logged to the system'),
(57, 1, ' ', 'Logged out on the system'),
(58, 6, 'Jobert Simbre', 'Logged to the system'),
(59, 6, 'Jobert Simbre', 'Logged out on the system'),
(60, 6, 'Jobert Simbre', 'Logged to the system'),
(61, 6, 'Jobert Simbre', 'Logged to the system'),
(62, 6, 'Jobert Simbre', 'Logged to the system'),
(63, 6, 'Jobert Simbre', 'Logged to the system'),
(64, 6, 'Jobert Simbre', 'Logged to the system'),
(65, 6, 'Jobert Simbre', 'Logged to the system'),
(66, 6, 'Jobert Simbre', 'Logged to the system'),
(67, 6, 'Jobert Simbre', 'Logged to the system'),
(68, 6, 'Jobert Simbre', 'Logged to the system'),
(69, 1, ' ', 'Logged to the system'),
(70, 1, ' ', 'Logged out on the system'),
(71, 1, 'Administrator', 'Logged to the system'),
(72, 1, 'Administrator', 'Logged out on the system'),
(73, 1, 'Administrator', 'Logged to the system'),
(74, 1, 'Administrator', 'Logged out on the system'),
(75, 1, 'Administrator', 'Logged to the system'),
(76, 1, 'Administrator', 'Logged to the system'),
(77, 1, 'Administrator', 'Backup the database named backup-parking_system-October_5_2024_8-26_pm.sql.gz'),
(78, 1, 'Administrator', 'Restore the database using backup-parking_system-October_5_2024_8-26_pm.sql.gz'),
(79, 1, 'Administrator', 'Backup the database named backup-parking_system-October_6_2024_2-34_am.sql.gz'),
(80, 1, 'Administrator', 'Backup the database named backup-parking_system-October_6_2024_2-35_am.sql.gz'),
(81, 1, 'Administrator', 'Backup the database named backup-parking_system-October_6_2024_2-35_am.sql.gz'),
(82, 1, 'Administrator', 'Backup the database named backup-parking_system-October_6_2024_2-36_am.sql.gz'),
(83, 1, 'Administrator', 'Backup the database named backup-parking_system-October_6_2024_2-36_am.sql.gz'),
(84, 1, 'Administrator', 'Backup the database named backup-parking_system-October_6_2024_2-37_am.sql.gz'),
(85, 1, 'Administrator', 'Restore the database using backup-parking_system-October_6_2024_2-37_am.sql.gz'),
(86, 1, 'Administrator', 'Backup the database named backup-parking_system-October_6_2024_2-37_am.sql.gz'),
(87, 1, 'Administrator', 'Restore the database using backup-parking_system-October_6_2024_2_37_am.sql.gz'),
(88, 1, 'Administrator', 'Backup the database named backup-parking_system-October_6_2024_3-21_am.sql.gz'),
(89, 1, 'Administrator', 'Restore the database using backup-parking_system-October_6_2024_3_21_am.sql.gz'),
(90, 1, 'Administrator', 'Backup the database named backup-parking_system-October_6_2024_3-22_am.sql.gz'),
(91, 1, 'Administrator', 'Restore the database using backup-parking_system-October_6_2024_3_22_am.sql.gz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parking_log`
--
ALTER TABLE `parking_log`
  ADD PRIMARY KEY (`parking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_d_id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`user_log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parking_log`
--
ALTER TABLE `parking_log`
  MODIFY `parking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `user_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
