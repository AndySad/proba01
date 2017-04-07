-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Mar 2017, 17:15
-- Wersja serwera: 10.0.17-MariaDB
-- Wersja PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `program`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tydzien`
--

CREATE TABLE `tydzien` (
  `id` int(11) NOT NULL,
  `tydzien_od` date NOT NULL,
  `piesn_1` int(11) NOT NULL,
  `piesn_2` int(11) NOT NULL,
  `piesn_3` int(11) NOT NULL,
  `rozdzialy_do_czytania` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `tydzien`
--

INSERT INTO `tydzien` (`id`, `tydzien_od`, `piesn_1`, `piesn_2`, `piesn_3`, `rozdzialy_do_czytania`) VALUES
(1, '2017-03-06', 23, 149, 74, 'JEREMIASZA 1-4');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zebranie_w_tygodniu_punkty`
--

CREATE TABLE `zebranie_w_tygodniu_punkty` (
  `id` int(11) NOT NULL,
  `tydzien_id` int(11) NOT NULL,
  `punkt_rodzaj_id` int(11) NOT NULL,
  `punkt_temat` varchar(255) NOT NULL,
  `punkt_czas` int(11) NOT NULL,
  `punkt_opis` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `tydzien`
--
ALTER TABLE `tydzien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tydzien_od` (`tydzien_od`);

--
-- Indexes for table `zebranie_w_tygodniu_punkty`
--
ALTER TABLE `zebranie_w_tygodniu_punkty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `X1_nr_zebrania` (`tydzien_id`,`punkt_rodzaj_id`),
  ADD KEY `X2_rodzaj_punktu` (`punkt_rodzaj_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `tydzien`
--
ALTER TABLE `tydzien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `zebranie_w_tygodniu_punkty`
--
ALTER TABLE `zebranie_w_tygodniu_punkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `zebranie_w_tygodniu_punkty`
--
ALTER TABLE `zebranie_w_tygodniu_punkty`
  ADD CONSTRAINT `zebranie_w_tygodniu_punkty_ibfk_1` FOREIGN KEY (`tydzien_id`) REFERENCES `tydzien` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
