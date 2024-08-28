-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 28, 2024 at 08:44 PM
-- Server version: 8.0.39-0ubuntu0.20.04.1
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `void`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocked_events`
--

CREATE TABLE `blocked_events` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `comment` text,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `event_date` datetime NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('Meghívás alapú','Publikus','Hírességek') COLLATE utf8mb4_general_ci NOT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `name`, `event_date`, `place`, `type`, `comment`, `created_at`) VALUES
(18, 6, 'teszt', '2024-08-31 18:09:00', 'teszt', 'Meghívás alapú', 'teszt', '2024-08-28 16:02:24');

-- --------------------------------------------------------

--
-- Table structure for table `event_invitations`
--

CREATE TABLE `event_invitations` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `invitee_id` int NOT NULL,
  `user_id` int NOT NULL,
  `bring_item` text COLLATE utf8mb4_general_ci,
  `status` enum('Még nem válaszolt','Jön','Nem jön','Talán jön') COLLATE utf8mb4_general_ci DEFAULT 'Még nem válaszolt',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_ratings`
--

CREATE TABLE `event_ratings` (
  `id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `rating` tinyint(1) DEFAULT NULL
) ;

--
-- Dumping data for table `event_ratings`
--

INSERT INTO `event_ratings` (`id`, `event_id`, `user_id`, `rating`) VALUES
(2, 7, 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE `invitations` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `invitee_name` varchar(255) NOT NULL,
  `bring_item` text,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invitations`
--

INSERT INTO `invitations` (`id`, `event_id`, `invitee_name`, `bring_item`, `status`, `created_at`) VALUES
(2, 18, 'erik', '', 'Jön', '2024-08-28 17:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `past_events`
--

CREATE TABLE `past_events` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `event_date` datetime NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` enum('Meghívás alapú','Publikus','Hírességek') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `past_events`
--

INSERT INTO `past_events` (`id`, `name`, `event_date`, `place`, `type`, `created_at`) VALUES
(2, 'asd', '2024-08-25 00:58:00', 'asd', 'Meghívás alapú', '2024-08-26 15:07:52'),
(5, 'asd', '2024-08-25 19:08:00', 'asdasdas', 'Publikus', '2024-08-26 15:17:24'),
(6, 'asda2', '2024-08-26 16:16:00', 'asdsadsad', 'Publikus', '2024-08-26 15:07:52'),
(7, 'asdsadsada', '2024-08-25 20:11:00', 'asdasdasd', 'Hírességek', '2024-08-26 15:20:30'),
(9, 'asdasdas', '2024-08-26 01:25:00', 'asdasdasd', 'Meghívás alapú', '2024-08-26 17:25:38'),
(10, 'teszt', '2024-08-26 03:34:00', 'asd', 'Publikus', '2024-08-26 20:33:14'),
(11, 'teszt', '2024-08-26 22:39:00', 'teszt', 'Meghívás alapú', '2024-08-26 22:49:28'),
(12, 'teszt', '2024-08-28 12:23:00', 'valami', 'Publikus', '2024-08-28 14:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `past_event_invitations`
--

CREATE TABLE `past_event_invitations` (
  `id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `bring_item` text COLLATE utf8mb4_general_ci,
  `status` enum('Még nem válaszolt','Jön','Nem jön','Talán jön') COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `past_event_invitations`
--

INSERT INTO `past_event_invitations` (`id`, `event_id`, `user_id`, `bring_item`, `status`) VALUES
(1, 7, 6, '', 'Jön');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `create_datetime` datetime NOT NULL,
  `adminlevel` int DEFAULT NULL,
  `banned` int DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `wants_to_be_celebrity` tinyint(1) DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT '0',
  `reset_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `create_datetime`, `adminlevel`, `banned`, `description`, `wants_to_be_celebrity`, `verification_code`, `email_verified`, `reset_token`, `reset_expiry`) VALUES
(6, 'erik', 'pecsierik02@gmaila.com', '38913e1d6a7b94cb0f55994f679f5956', '2024-08-20 17:13:45', 2, NULL, ' ', 0, NULL, 1, NULL, NULL),
(19, 'erikerik', 'pecsierik02@gmail.com', '6a42dd6e7ca9a813693714b0d9aa1ad8', '2024-08-28 19:12:29', NULL, NULL, NULL, NULL, '3da44cdaf6983fab7681b4c96e4b9aeb', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `device` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `browser` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `ip`, `device`, `os`, `browser`, `date`, `username`) VALUES
(1, '147.91.199.133', 'Mobile', 'Android', 'Chrome', '2024-08-26 19:32:51', 'erik'),
(2, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-26 19:44:38', 'erik'),
(3, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-26 19:52:25', 'erik'),
(4, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-26 19:56:06', 'erik'),
(5, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 09:58:59', 'teszt'),
(6, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 09:59:43', 'erik'),
(7, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 10:05:30', 'erik'),
(8, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 10:19:28', 'teszt'),
(9, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 12:44:04', 'erik'),
(10, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 15:08:12', 'erik'),
(11, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 15:13:08', 'pecsierik'),
(12, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 15:38:45', 'pecsierik'),
(13, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 16:01:21', 'erik'),
(14, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 16:30:09', 'erik'),
(15, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 16:52:43', 'erik'),
(16, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 17:00:43', 'erik'),
(17, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 18:24:39', 'erikteszt'),
(18, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 18:28:46', 'erikteszt'),
(19, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 18:28:56', 'erikteszt'),
(20, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 18:44:06', 'erikteszt'),
(21, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 19:12:37', 'erikerik'),
(22, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 19:13:26', 'erikerik'),
(23, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 19:15:33', 'erikerik'),
(24, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 19:34:49', 'erikerik'),
(25, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 19:50:07', 'erikerik'),
(26, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 20:04:43', 'erikerik'),
(27, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 20:23:05', 'erikerik'),
(28, '147.91.199.133', 'Desktop', 'Windows 10', 'Opera', '2024-08-28 20:43:35', 'erikerik');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocked_events`
--
ALTER TABLE `blocked_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `event_invitations`
--
ALTER TABLE `event_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_invitation` (`event_id`,`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `event_ratings`
--
ALTER TABLE `event_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_id` (`event_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `past_events`
--
ALTER TABLE `past_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `past_event_invitations`
--
ALTER TABLE `past_event_invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocked_events`
--
ALTER TABLE `blocked_events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `event_invitations`
--
ALTER TABLE `event_invitations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_ratings`
--
ALTER TABLE `event_ratings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `past_events`
--
ALTER TABLE `past_events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `past_event_invitations`
--
ALTER TABLE `past_event_invitations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocked_events`
--
ALTER TABLE `blocked_events`
  ADD CONSTRAINT `blocked_events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_invitations`
--
ALTER TABLE `event_invitations`
  ADD CONSTRAINT `event_invitations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_invitations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `event_ratings`
--
ALTER TABLE `event_ratings`
  ADD CONSTRAINT `event_ratings_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `past_events` (`id`),
  ADD CONSTRAINT `event_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `invitations`
--
ALTER TABLE `invitations`
  ADD CONSTRAINT `invitations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `past_event_invitations`
--
ALTER TABLE `past_event_invitations`
  ADD CONSTRAINT `past_event_invitations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `past_events` (`id`),
  ADD CONSTRAINT `past_event_invitations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
