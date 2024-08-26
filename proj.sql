-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Aug 26. 21:10
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `proj`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `event_date` datetime NOT NULL,
  `place` varchar(255) NOT NULL,
  `type` enum('Meghívás alapú','Publikus','Hírességek') NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `event_invitations`
--

CREATE TABLE `event_invitations` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `invitee_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bring_item` text DEFAULT NULL,
  `status` enum('Még nem válaszolt','Jön','Nem jön','Talán jön') DEFAULT 'Még nem válaszolt',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `event_ratings`
--

CREATE TABLE `event_ratings` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` tinyint(1) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `event_ratings`
--

INSERT INTO `event_ratings` (`id`, `event_id`, `user_id`, `rating`) VALUES
(1, 7, 6, 5);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `past_events`
--

CREATE TABLE `past_events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `event_date` datetime NOT NULL,
  `place` varchar(255) DEFAULT NULL,
  `type` enum('Meghívás alapú','Publikus','Hírességek') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `past_events`
--

INSERT INTO `past_events` (`id`, `name`, `event_date`, `place`, `type`, `created_at`) VALUES
(2, 'asd', '2024-08-25 00:58:00', 'asd', 'Meghívás alapú', '2024-08-26 15:07:52'),
(5, 'asd', '2024-08-25 19:08:00', 'asdasdas', 'Publikus', '2024-08-26 15:17:24'),
(6, 'asda2', '2024-08-26 16:16:00', 'asdsadsad', 'Publikus', '2024-08-26 15:07:52'),
(7, 'asdsadsada', '2024-08-25 20:11:00', 'asdasdasd', 'Hírességek', '2024-08-26 15:20:30'),
(9, 'asdasdas', '2024-08-26 01:25:00', 'asdasdasd', 'Meghívás alapú', '2024-08-26 17:25:38');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `past_event_invitations`
--

CREATE TABLE `past_event_invitations` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bring_item` text DEFAULT NULL,
  `status` enum('Még nem válaszolt','Jön','Nem jön','Talán jön') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `past_event_invitations`
--

INSERT INTO `past_event_invitations` (`id`, `event_id`, `user_id`, `bring_item`, `status`) VALUES
(1, 7, 6, '', 'Jön');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `adminlevel` int(11) DEFAULT NULL,
  `banned` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `wants_to_be_celebrity` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `create_datetime`, `adminlevel`, `banned`, `description`, `wants_to_be_celebrity`) VALUES
(1, 'Erik', 'pecsierik02@gmail.com', '2ac13174447d86f2918c7dcd1895e7a6', '2023-06-07 21:17:31', 2, 0, 'teszt', 0),
(2, 'Erik2', 'pecsierik01@gmail.com', '2ac13174447d86f2918c7dcd1895e7a6', '2023-08-25 16:02:38', 0, 0, 'új leírás teszt', 0),
(3, 'Teszt', 'valami@gmail.com', '2ac13174447d86f2918c7dcd1895e7a6', '2023-08-25 16:53:50', 0, 0, 'teszt', 0),
(5, 'VTS', 'vts@gmail.com', 'ce2403ca5fc076f684e0b2db7619856c', '2023-08-28 11:07:00', 0, NULL, NULL, 0),
(6, 'mtas', 'asd@gmail.com', '38913e1d6a7b94cb0f55994f679f5956', '2024-08-20 17:13:45', 2, NULL, ' ', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `device` varchar(50) NOT NULL,
  `os` varchar(50) NOT NULL,
  `browser` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `event_invitations`
--
ALTER TABLE `event_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_invitation` (`event_id`,`id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `event_ratings`
--
ALTER TABLE `event_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_id` (`event_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `past_events`
--
ALTER TABLE `past_events`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `past_event_invitations`
--
ALTER TABLE `past_event_invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `event_invitations`
--
ALTER TABLE `event_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `event_ratings`
--
ALTER TABLE `event_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `past_events`
--
ALTER TABLE `past_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT a táblához `past_event_invitations`
--
ALTER TABLE `past_event_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `event_invitations`
--
ALTER TABLE `event_invitations`
  ADD CONSTRAINT `event_invitations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_invitations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `event_ratings`
--
ALTER TABLE `event_ratings`
  ADD CONSTRAINT `event_ratings_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `past_events` (`id`),
  ADD CONSTRAINT `event_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `past_event_invitations`
--
ALTER TABLE `past_event_invitations`
  ADD CONSTRAINT `past_event_invitations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `past_events` (`id`),
  ADD CONSTRAINT `past_event_invitations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
