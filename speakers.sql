-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 21, 2024 at 05:54 PM
-- Server version: 8.0.36-28
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
--
-- Table structure for table `speakers`
--

CREATE TABLE `speakers` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hostname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `unique_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `maxview` int NOT NULL DEFAULT '100',
  `rmdates` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sem_date` date NOT NULL,
  `sem_time` time NOT NULL DEFAULT '11:00:00',
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'TBD',
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'TBD',
  `abstract` text COLLATE utf8mb4_general_ci NOT NULL,
  `zlink` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'TBD',
  `affiliation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `pastevent` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `speakers`
--
ALTER TABLE `speakers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `speakers`
--
ALTER TABLE `speakers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
