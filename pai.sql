-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 31 Sty 2020, 17:32
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pai`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dane`
--

CREATE TABLE `dane` (
  `id_dane` int(11) NOT NULL,
  `id_uzytkownik` int(11) DEFAULT NULL,
  `country` text DEFAULT NULL,
  `telefon` text DEFAULT NULL,
  `data_urodzin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `danepraca`
--

CREATE TABLE `danepraca` (
  `id_danepraca` int(11) NOT NULL,
  `id_uzytkownik` int(11) DEFAULT NULL,
  `miejsce` text DEFAULT NULL,
  `id_stawka` int(11) DEFAULT NULL,
  `ilosc_godzin` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `log`
--

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `id_uzytkownik` int(11) DEFAULT NULL,
  `data_logowania` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `log`
--

INSERT INTO `log` (`id_log`, `id_uzytkownik`, `data_logowania`) VALUES
(1, NULL, '2020-01-29'),
(2, NULL, '2020-01-29'),
(3, NULL, '2020-01-31');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `praca`
--

CREATE TABLE `praca` (
  `id_praca` int(11) NOT NULL,
  `id_dane` int(11) DEFAULT NULL,
  `id_danepraca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stawka`
--

CREATE TABLE `stawka` (
  `id_stawka` int(11) NOT NULL,
  `wartosc` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_uzytkownik` int(11) NOT NULL,
  `nick` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `haslo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_uzytkownik`, `nick`, `email`, `haslo`) VALUES
(1, 'Patryk', 'patryk.kaczor611@gmail.com', 'qwert'),
(2, 'Adam', 'adam@gmail.com', '$2y$10$ubyLm1JlPWXMm3bbtHzTxeW06YTjkIFQ0RLNHbG6YeAO8aRNkRVu6'),
(3, 'Patryk1', 'pat@gmail.com', '$2y$10$pMOdhb7queG76jcIl8l3MuUa8tEsHU1rxR1qXHjk64Vf8KFwfC7bm'),
(4, 'Janusz', 'jan@gmail.com', '$2y$10$YU2uyBDQET/sR/Sk0wfZ/.n.1hBXmPWBXGaLspDDWJXAea7bqQ74C'),
(5, 'malpa', 'malpa@gmail.com', 'lalalalalsda'),
(6, 'Adam122', 'patryk55351@wp.pl', '$2y$10$rgk10KsjwgcfF8RjUgrtaeVyUbbiIwZU7Cwe.33PKS3snFy8ieX7W'),
(7, 'Patryk2', 'patryk@gmail.com', '$2y$10$0wkjSiY61Jf8qh/lWxAXxu2SZfDhmRpfC/3DL2Ek76n6vLb5Z3Oge');

--
-- Wyzwalacze `uzytkownicy`
--
DELIMITER $$
CREATE TRIGGER `logowanie` AFTER INSERT ON `uzytkownicy` FOR EACH ROW INSERT INTO log VALUES(null,null,CURRENT_DATE)
$$
DELIMITER ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dane`
--
ALTER TABLE `dane`
  ADD PRIMARY KEY (`id_dane`),
  ADD KEY `id_uzytkownik` (`id_uzytkownik`) USING BTREE;

--
-- Indeksy dla tabeli `danepraca`
--
ALTER TABLE `danepraca`
  ADD PRIMARY KEY (`id_danepraca`),
  ADD KEY `id_stawka` (`id_stawka`);

--
-- Indeksy dla tabeli `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_uzytkownik` (`id_uzytkownik`) USING BTREE;

--
-- Indeksy dla tabeli `praca`
--
ALTER TABLE `praca`
  ADD PRIMARY KEY (`id_praca`),
  ADD KEY `id_dane` (`id_dane`,`id_danepraca`);

--
-- Indeksy dla tabeli `stawka`
--
ALTER TABLE `stawka`
  ADD PRIMARY KEY (`id_stawka`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_uzytkownik`);

--
-- AUTO_INCREMENT dla tabel zrzutów
--

--
-- AUTO_INCREMENT dla tabeli `dane`
--
ALTER TABLE `dane`
  MODIFY `id_dane` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `danepraca`
--
ALTER TABLE `danepraca`
  MODIFY `id_danepraca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `log`
--
ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `praca`
--
ALTER TABLE `praca`
  MODIFY `id_praca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `stawka`
--
ALTER TABLE `stawka`
  MODIFY `id_stawka` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_uzytkownik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `dane`
--
ALTER TABLE `dane`
  ADD CONSTRAINT `dane_ibfk_1` FOREIGN KEY (`id_uzytkownik`) REFERENCES `uzytkownicy` (`id_uzytkownik`);

--
-- Ograniczenia dla tabeli `danepraca`
--
ALTER TABLE `danepraca`
  ADD CONSTRAINT `danepraca_ibfk_1` FOREIGN KEY (`id_stawka`) REFERENCES `stawka` (`id_stawka`),
  ADD CONSTRAINT `danepraca_ibfk_2` FOREIGN KEY (`id_uzytkownik`) REFERENCES `uzytkownicy` (`id_uzytkownik`);

--
-- Ograniczenia dla tabeli `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`id_uzytkownik`) REFERENCES `uzytkownicy` (`id_uzytkownik`);

--
-- Ograniczenia dla tabeli `praca`
--
ALTER TABLE `praca`
  ADD CONSTRAINT `praca_ibfk_1` FOREIGN KEY (`id_dane`) REFERENCES `dane` (`id_dane`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
