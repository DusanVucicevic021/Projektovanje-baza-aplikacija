-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 02:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lekarska_ordinacija`
--

-- --------------------------------------------------------

--
-- Table structure for table `dijagnoze`
--

CREATE TABLE `dijagnoze` (
  `id` int(11) NOT NULL,
  `br_kartona` int(11) NOT NULL,
  `naziv` varchar(10000) NOT NULL,
  `opis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dijagnoze`
--

INSERT INTO `dijagnoze` (`id`, `br_kartona`, `naziv`, `opis`) VALUES
(1, 2, 'Akutni stresni poremećaj', 'Akutni stresni poremećaj (ASPD) je mentalni poremećaj koji se može razviti kod osoba koje su doživele ili su bile izložene traumatičnom događaju ili situaciji. Ovaj poremećaj karakteriše kratkotrajna, ali intenzivna reakcija na stres, obično se javlja u periodu od nekoliko dana do nekoliko nedelja nakon traume. '),
(2, 1, 'Policistični ovarijalni sindrom (PCOS)', 'To je hormonalni poremećaj koji utječe na reproduktivni sustav žene. Karakterizira ga formiranje brojnih cista na jajnicima, što može uzrokovati različite simptome kao što su nepravilni menstrualni ciklusi, povećana razina muških hormona (androgena) u tijelu što može rezultirati aknama, povećanjem dlakavosti, i poteškoćama s konceptom. Pored toga, PCOS može biti povezan s drugim zdravstvenim problemima kao što su pretilost, inzulinska rezistencija, dijabetes tipa 2, poremećaji spavanja, depresija i anksioznost. Dijagnoza se obično postavlja na temelju simptoma, fizikalnog pregleda, ultrazvuka i laboratorijskih testova koji uključuju mjerenje razine hormona.'),
(3, 8, 'Sinusitis', 'Sinusitis je medicinski termin koji se koristi za opisivanje upale sinusa, što su šupljine u kostima lica koje su povezane sa nosom. Ova upala može biti uzrokovana infekcijom, alergijama ili drugim faktorima.'),
(6, 4, 'Labaratorijski nalaz ', 'Leukociti u urinu: 0-5 leukocita/uL\r\nEritrociti u urinu: 0-2 eritrocita/uL\r\nBakterije u urinu: Normalno nema bakterija\r\nGlukoza u urinu: Negativno\r\nProtein u urinu: 0-20 mg/dL\r\nKrv u urinu: Negativno\r\nNitriti u urinu: Negativno\r\nLeukociti u krvi: 4,000-11,000 leukocita/uL\r\nEritrociti u krvi: 4.2-5.4 miliona/mm^3\r\nHemoglobin u krvi: 13.5-17.5 g/dL'),
(7, 9, 'Hipertenzija', 'Visok krvni pritisak');

-- --------------------------------------------------------

--
-- Table structure for table `lekari`
--

CREATE TABLE `lekari` (
  `id` int(11) NOT NULL,
  `ime_i_prezime` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lekari`
--

INSERT INTO `lekari` (`id`, `ime_i_prezime`, `username`, `password`) VALUES
(1, 'dr Marko Jovanović', 'marko.jovanovic', 'lozinka1'),
(2, 'dr Ana Petrović', 'ana.petrovic', 'lozinka12'),
(3, 'dr Jovana Popović', 'jovana.popovic', 'lozinka123'),
(4, 'dr Nikola Stojanović', 'nikola.stojanovic', 'lozinka1234'),
(5, 'dr Milica Nikolić', 'milica.nikolic', 'lozinka12345'),
(6, 'dr Stefan Đorđević', 'stefan.djurdjevic', 'lozinka54321'),
(7, 'dr Aleksandar Simić', 'aleksandar.simic', 'lozinka4321'),
(8, 'dr Filip Stevanović', 'filip.stevanovic', 'lozinka321'),
(9, 'dr Ivana Lukić', 'ivana.lukic', 'lozinka21'),
(10, 'dr Marija Kovačević', 'marija.kovacevic', 'lozinka'),
(11, 'dr Luka Radovanović', 'luka.radovanovic', 'lozinka0');

-- --------------------------------------------------------

--
-- Table structure for table `pacijenti`
--

CREATE TABLE `pacijenti` (
  `br_kartona` int(11) NOT NULL,
  `ime_i_prezime` varchar(30) NOT NULL,
  `datum_rodjenja` date NOT NULL,
  `JMBG` bigint(13) DEFAULT NULL,
  `LBO` bigint(13) DEFAULT NULL,
  `br_knjizice` bigint(11) DEFAULT NULL,
  `izabrani_lekar` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pacijenti`
--

INSERT INTO `pacijenti` (`br_kartona`, `ime_i_prezime`, `datum_rodjenja`, `JMBG`, `LBO`, `br_knjizice`, `izabrani_lekar`) VALUES
(1, 'Milica Petrovic', '1993-05-21', 9876543210123, 4567890123456, 87654321098, 'dr Nikola Stojanović'),
(2, 'Nikola Pavlovic', '1989-06-07', 1234567890123, 9876543210987, 12345678901, 'dr Luka Radovanović'),
(3, 'Ivana Novak', '1991-12-21', 2345678901234, 8765432109876, 34567890123, 'dr Luka Radovanović'),
(4, 'Dejan Petrović', '1983-12-19', 5432109876543, 2109876543210, 98765432109, 'dr Ivana Lukić'),
(5, 'Ivana Novak', '1987-12-14', 8765432109876, 3456789012345, 65432109876, 'dr Marija Kovačević'),
(6, 'Marko Janković', '1980-02-10', 1234567890123, 9876543210987, 12345678901, 'dr Milica Nikolić'),
(7, 'Jovana Stanković', '1999-07-05', 2345678901234, 8765432109876, 23456789012, 'dr Stefan Đorđević'),
(8, 'Nikola Đorđević', '1985-11-15', 3456789012345, 7654321098765, 34567890123, 'dr Ana Petrović'),
(9, 'Milica Stojković', '1990-09-25', 4567890123456, 6543210987654, 45678901234, 'dr Ana Petrović'),
(10, 'Stefan Marković', '1982-01-12', 5678901234567, 5432109876543, 56789012345, 'dr Ivana Lukić'),
(11, 'Marko Đorđević', '1988-03-03', 7890123456789, 3210987654321, 78901234567, 'dr Ana Petrović'),
(12, 'Jelena Simić', '1979-11-22', 8901234567890, 2109876543210, 89012345678, 'dr Ana Petrović'),
(13, 'Nikola Jovanović', '1996-07-06', 9012345678901, 1098765432109, 90123456789, 'dr Stefan Đorđević');

-- --------------------------------------------------------

--
-- Table structure for table `recepti`
--

CREATE TABLE `recepti` (
  `id` int(11) NOT NULL,
  `br_kartona` int(11) NOT NULL,
  `br_knjizice` int(11) NOT NULL,
  `lek` varchar(10000) NOT NULL,
  `nacin_upotrebe` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recepti`
--

INSERT INTO `recepti` (`id`, `br_kartona`, `br_knjizice`, `lek`, `nacin_upotrebe`) VALUES
(1, 2, 23152012, 'Bromazepam 3mg', '1x1 pred spavanje'),
(3, 8, 2147483647, 'Amoksicilin ', 'Na 8h po jednu tabletu'),
(4, 11, 2147483647, 'Ibuprofen 200mg', ' Uzeti jednu tabletu svakih 8 sati sa hranom.'),
(5, 3, 2147483647, 'Loratadin 10mg', 'Uzeti jednu tabletu dnevno.'),
(6, 13, 2147483647, 'Metformin 500mg', 'Uzeti jednu tabletu dva puta dnevno sa obrokom za kontrolu nivoa šećera u krvi.\r\n\r\n'),
(7, 9, 2147483647, 'Enalapril', '1 uvece');

-- --------------------------------------------------------

--
-- Table structure for table `zakazani_termini`
--

CREATE TABLE `zakazani_termini` (
  `id` int(11) NOT NULL,
  `br_kartona` int(11) DEFAULT NULL,
  `ime_i_prezime` varchar(100) DEFAULT NULL,
  `datum_vreme_zakazivanja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zakazani_termini`
--

INSERT INTO `zakazani_termini` (`id`, `br_kartona`, `ime_i_prezime`, `datum_vreme_zakazivanja`) VALUES
(8, 1, 'Milica Petrovic', '2024-05-15 11:30:00'),
(9, 2, 'Nikola Pavlovic', '2024-05-22 17:45:00'),
(10, 4, 'Dejan Petrović', '2024-05-16 18:15:00'),
(11, 8, 'Nikola Đorđević', '2024-05-16 15:15:00'),
(12, 9, 'Milica Stojković', '2024-05-19 11:45:00'),
(13, 10, 'Stefan Marković', '2024-05-21 16:45:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dijagnoze`
--
ALTER TABLE `dijagnoze`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `br_kartona` (`br_kartona`);

--
-- Indexes for table `lekari`
--
ALTER TABLE `lekari`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacijenti`
--
ALTER TABLE `pacijenti`
  ADD PRIMARY KEY (`br_kartona`);

--
-- Indexes for table `recepti`
--
ALTER TABLE `recepti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `br_kartona` (`br_kartona`);

--
-- Indexes for table `zakazani_termini`
--
ALTER TABLE `zakazani_termini`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `br_kartona` (`br_kartona`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dijagnoze`
--
ALTER TABLE `dijagnoze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lekari`
--
ALTER TABLE `lekari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pacijenti`
--
ALTER TABLE `pacijenti`
  MODIFY `br_kartona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `recepti`
--
ALTER TABLE `recepti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `zakazani_termini`
--
ALTER TABLE `zakazani_termini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dijagnoze`
--
ALTER TABLE `dijagnoze`
  ADD CONSTRAINT `dijagnoze_ibfk_1` FOREIGN KEY (`br_kartona`) REFERENCES `pacijenti` (`br_kartona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `recepti`
--
ALTER TABLE `recepti`
  ADD CONSTRAINT `recepti_ibfk_1` FOREIGN KEY (`br_kartona`) REFERENCES `pacijenti` (`br_kartona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zakazani_termini`
--
ALTER TABLE `zakazani_termini`
  ADD CONSTRAINT `zakazani_termini_ibfk_1` FOREIGN KEY (`br_kartona`) REFERENCES `pacijenti` (`br_kartona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
