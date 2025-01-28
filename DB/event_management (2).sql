-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 28, 2025 at 01:05 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`id`, `event_id`, `name`, `email`) VALUES
(4, 28, 'php dev', 'hotapar660@centerf.com'),
(5, 28, 'siqokepaqi@mailinator.com', 'sygaqype@mailinator.com'),
(7, 28, 'siqokepaqi', 'dsdfdsygaqype@mailinator.com'),
(9, 28, 'Rocket', 'hotaperrrear660@centerf.com'),
(11, 21, 'Rocket', 'daymon@site.com'),
(13, 28, 'Rocket', 'admin@gmail.com'),
(14, 28, 'SR-PRAN-Common-Common-A.M. Istiaque Hossain', 'usesdsdrname@gmail.com'),
(15, 21, 'php dev', 'adminsdsd@gmail.com'),
(16, 28, 'Rocket', 'username@gmail.com'),
(20, 28, 'SR-PRAN-Common-Common-A.M. Istiaque Hossain', 'admsdsdsin@gmail.com'),
(21, 28, 'php dev', 'admsddsdin@gmail.com'),
(24, 28, 'Rocket', 'admfdfin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `max_capacity` int NOT NULL,
  `booked` int NOT NULL DEFAULT '0',
  `created_by` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `date`, `time`, `location`, `max_capacity`, `booked`, `created_by`) VALUES
(7, 'Steel Lara2', 'Fugiat lorem distinc2', '2005-12-02', '14:00:00', NULL, 172, 0, 1),
(17, 'Jenette Boone333', 'Dolor obcaecati elig', '2024-06-12', '04:42:00', NULL, 44, 0, 1),
(18, 'Castor Bean', 'Eum officia quibusda', '2004-06-03', '23:29:00', NULL, 21, 0, 1),
(19, 'Cathleen Estrada', 'Sit optio esse dolo', '2019-05-20', '03:10:00', NULL, 70, 0, 1),
(21, 'Quamar Wilkerson2', 'Odit sint harum accu', '1982-07-05', '05:40:00', NULL, 91, 0, 1),
(23, 'Rocket33', 'ee3\r\n', '2025-01-30', '15:39:50', NULL, 3, 0, 1),
(24, 'Justin Gardner', 'Aliquam ratione aut ', '2018-11-05', '23:10:00', NULL, 97, 0, 1),
(28, 'Phoebe Rhodes', 'Unde odio veniam ve', '1977-03-23', '11:26:00', NULL, 100, 0, 1),
(29, 'Tiger Bowers2', 'Voluptatibus volupta', '2026-12-30', '11:52:00', NULL, 7, 0, 1),
(31, 'Sylvester Roachs2', 'Officia atque facili', '2029-10-09', '12:24:00', NULL, 52, 0, 1),
(32, 'Audrey Mccormickddss3', 'Consequatur recusan', '2022-08-08', '15:19:00', NULL, 81, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$//JZIChxCZwMra42OyVdBOrhN7IxNdnx51Z8cSK5Fp5LZCy4YSeFm', 'admin'),
(5, 'username', 'username@gmail.com', '$2y$10$mi8WYPO0fOGDht9DU0.rXOzpzmDO3WJ0HcJLmOeRpX/mBtr.4uwqK', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `attendees_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
