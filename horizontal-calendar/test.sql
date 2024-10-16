-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Paź 16, 2024 at 11:56 PM
-- Wersja serwera: 8.0.39-0ubuntu0.24.04.2
-- Wersja PHP: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `contracts`
--

CREATE TABLE `contracts` (
  `fiscal_year` year NOT NULL,
  `contract_number` int NOT NULL,
  `bok` char(3) COLLATE utf8mb4_polish_ci NOT NULL DEFAULT 'CHO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`fiscal_year`, `contract_number`, `bok`) VALUES
('2021', 1, 'CHO'),
('2021', 2, 'CHO'),
('2021', 3, 'BYT'),
('2021', 4, 'CHO'),
('2021', 5, 'TUC'),
('2021', 6, 'CHO'),
('2022', 7, 'CHO');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `holiday_countries`
--

CREATE TABLE `holiday_countries` (
  `id` int UNSIGNED NOT NULL,
  `country` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `region` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `meta` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL,
  `datasource` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `holiday_countries`
--

INSERT INTO `holiday_countries` (`id`, `country`, `region`, `meta`, `datasource`) VALUES
(53, 'pl', 'Chojnice', '', ''),
(54, 'de', 'Berlin', 'Pole meta', 'Pole datasource'),
(55, 'at', 'Austria', '', ''),
(56, 'ch', 'Szwajcaria', '', ''),
(57, 'pl', 'Charzykowy', 'Pole meta', 'Pole datasource'),
(58, 'pl', 'Warszawa', 'Pole meta', 'Pole datasource'),
(59, 'pl', 'Gdańsk', 'Pole meta', 'Pole datasource');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `holiday_periods`
--

CREATE TABLE `holiday_periods` (
  `id` int UNSIGNED NOT NULL DEFAULT '1' COMMENT 'regionid',
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `meta` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `holiday_periods`
--

INSERT INTO `holiday_periods` (`id`, `startdate`, `enddate`, `meta`) VALUES
(53, '2024-10-11', '2024-10-18', 'Pole meta'),
(57, '2024-10-01', '2024-10-04', 'Test Perioda'),
(58, '2024-10-01', '2024-10-14', 'Pole meta');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`contract_number`,`fiscal_year`);

--
-- Indeksy dla tabeli `holiday_countries`
--
ALTER TABLE `holiday_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `holiday_periods`
--
ALTER TABLE `holiday_periods`
  ADD UNIQUE KEY `id` (`id`,`startdate`,`enddate`,`meta`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name_unique` (`name`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `contract_number` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `holiday_countries`
--
ALTER TABLE `holiday_countries`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
