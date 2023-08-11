-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2022 at 08:19 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

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
-- Table structure for table `roster_slots`
--

CREATE TABLE `roster_slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dept_code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slot_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roster_slots`
--

INSERT INTO `roster_slots` (`id`, `dept_code`, `slot_no`, `from`, `to`, `created_at`, `updated_at`) VALUES
(1, 'SY', '1', '08:15:00', '17:15:00', NULL, NULL),
(3, 'SY', '3', '13:15:00', '22:15:00', NULL, NULL),
(4, 'SY', '4', '22:00:00', '08:15:00', NULL, NULL),
(5, 'CA', '1', '07:00:00', '15:00:00', NULL, NULL),
(6, 'CA', '2', '15:00:00', '23:00:00', NULL, NULL),
(7, 'CA', '3', '23:00:00', '07:00:00', NULL, NULL),
(8, 'TE', '1', '08:00:00', '17:00:00', NULL, NULL),
(9, 'TE', '2', '11:00:00', '20:00:00', NULL, NULL),
(14, 'SY', '2', '09:15:00', '18:15:00', NULL, NULL),
(15, 'TR', '1', '09:00:00', '18:00:00', NULL, NULL),
(16, 'TR', '2', '10:15:00', '19:15:00', NULL, NULL),
(17, 'TR', '1', '09:00:00', '18:00:00', NULL, NULL),
(18, 'TR', '1', '09:00:00', '18:00:00', NULL, NULL),
(20, 'TR', '3', '08:30:00', '17:30:00', NULL, NULL),
(21, 'TR', '4', '10:30:00', '19:30:00', NULL, NULL),
(23, 'CU', '1', '20:00:00', '04:00:00', NULL, NULL),
(24, 'CU', '1', '21:00:00', '05:00:00', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roster_slots`
--
ALTER TABLE `roster_slots`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roster_slots`
--
ALTER TABLE `roster_slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
