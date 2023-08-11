-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2022 at 06:13 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_code` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leave_m` int(11) DEFAULT NULL,
  `leave_f` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`option_id`, `option_name`, `option_code`, `option_value`, `leave_m`, `leave_f`) VALUES
(168, 'leave_type', 'HL', 'Half Day Annual', 15, 15),
(169, 'leave_type', 'AL', 'Annual', 15, 15),
(172, 'leave_type', 'SL', 'Sick(Ordinary)', 5, 5),
(173, 'leave_type', 'SLM', 'Sick(Severe)', 15, 15),
(174, 'leave_type', 'PL', 'Paternity', 20, 0),
(175, 'leave_type', 'ML', 'Maternity', 0, 240),
(176, 'leave_type', 'WL', 'Wedding', 10, 15),
(177, 'leave_type', 'LWP', 'Without Pay', 0, 0),
(178, 'leave_type', 'TL', 'Training', 0, 0),
(179, 'leave_type', 'SP', 'Special', 0, 0),
(180, 'leave_type', 'CA', 'Carry Forwarded Annual', 0, 0),
(181, 'genuity_leaves_array', 'PL', 'Paternity', 20, 0),
(182, 'genuity_leaves_array', 'ML', 'Maternity', 0, 240),
(183, 'genuity_leaves_array', 'WL', 'Wedding', 10, 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
