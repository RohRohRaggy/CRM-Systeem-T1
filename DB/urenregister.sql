-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 11 jun 2026 om 11:59
-- Serverversie: 9.1.0
-- PHP-versie: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urenregister`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

DROP TABLE IF EXISTS `klanten`;
CREATE TABLE IF NOT EXISTS `klanten` (
  `klanten_ID` int NOT NULL AUTO_INCREMENT,
  `Voornaam` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Tussenvoegsel` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Achternaam` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bedrijfsnaam` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `functie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `PhoneNumber` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`klanten_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1100000153 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `klanten`
--

INSERT INTO `klanten` (`klanten_ID`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `bedrijfsnaam`, `functie`, `email`, `PhoneNumber`) VALUES
(104, 'Jan', 'de', 'Vries', 'bedrijf1', 'Project Manager', 'jan.devries@email.com', '0612345678'),
(103, 'Piet', '', 'Jansen', 'SuperCoolBedrijf', 'Developer', 'piet.jansen@email.com', '0612345679'),
(105, 'Klaas', '', 'Bakker', 'TechnoLogica BV', 'Designer', 'klaas.bakker@email.com', '0612345680'),
(106, 'Lisa', '', 'Smit', 'InnovatieCorp', 'Consultant', 'lisa.smit@email.com', '0612345681'),
(107, 'Emma', '', 'Visser', 'DesignHub', 'Accountmanager', 'emma.visser@email.com', '0612345682'),
(108, 'Noah', '', 'Meijer', 'CodeMasters', 'CEO', 'noah.meijer@email.com', '0612345683'),
(109, 'Daan', '', 'Mulder', 'WebWizards', 'CFO', 'daan.mulder@email.com', '0612345684'),
(110, 'Sophie', '', 'Bos', 'DataDynamics', 'Marketing Manager', 'sophie.bos@email.com', '0612345685'),
(111, 'Lucas', '', 'Vos', 'CloudCompany', 'HR Manager', 'lucas.vos@email.com', '0612345686'),
(112, 'Mila', '', 'Peters', 'SmartSolutions', 'Sales Representative', 'mila.peters@email.com', '0612345687'),
(113, 'Finn', '', 'Hendriks', 'bedrijf1', 'Project Manager', 'finn.hendriks@email.com', '0612345688'),
(114, 'Sara', '', 'Dekker', 'SuperCoolBedrijf', 'Developer', 'sara.dekker@email.com', '0612345689'),
(115, 'Levi', '', 'Brouwer', 'TechnoLogica BV', 'Designer', 'levi.brouwer@email.com', '0612345690'),
(116, 'Julia', '', 'Kuiper', 'InnovatieCorp', 'Consultant', 'julia.kuiper@email.com', '0612345691'),
(117, 'Sem', 'van', 'Dijk', 'DesignHub', 'Accountmanager', 'sem.vandijk@email.com', '0612345692'),
(118, 'Nina', '', 'Timmer', 'CodeMasters', 'CEO', 'nina.timmer@email.com', '0612345693'),
(119, 'Lars', '', 'Vermeer', 'WebWizards', 'CFO', 'lars.vermeer@email.com', '0612345694'),
(120, 'Eva', 'van', 'Leeuwen', 'DataDynamics', 'Marketing Manager', 'eva.vanleeuwen@email.com', '0612345695'),
(121, 'Mats', '', 'Prins', 'CloudCompany', 'HR Manager', 'mats.prins@email.com', '0612345696'),
(122, 'Tess', '', 'Blom', 'SmartSolutions', 'Sales Representative', 'tess.blom@email.com', '0612345697'),
(123, 'Bram', 'van der', 'Meer', 'bedrijf1', 'Project Manager', 'bram.meer@email.com', '0612345698'),
(124, 'Zoe', '', 'Sanders', 'SuperCoolBedrijf', 'Developer', 'zoe.sanders@email.com', '0612345699'),
(125, 'Tim', '', 'Koster', 'TechnoLogica BV', 'Designer', 'tim.koster@email.com', '0612345700'),
(126, 'Amber', '', 'Hoekstra', 'InnovatieCorp', 'Consultant', 'amber.hoekstra@email.com', '0612345701'),
(127, 'Nick', 'van', 'Rijn', 'DesignHub', 'Accountmanager', 'nick.vanrijn@email.com', '0612345702'),
(128, 'Iris', '', 'Post', 'CodeMasters', 'CEO', 'iris.post@email.com', '0612345703'),
(129, 'Ruben', '', 'Willems', 'WebWizards', 'CFO', 'ruben.willems@email.com', '0612345704'),
(130, 'Sanne', '', 'Kok', 'DataDynamics', 'Marketing Manager', 'sanne.kok@email.com', '0612345705'),
(131, 'Thomas', '', 'Vink', 'CloudCompany', 'HR Manager', 'thomas.vink@email.com', '0612345706'),
(132, 'Fleur', 'van', 'Dam', 'SmartSolutions', 'Sales Representative', 'fleur.vandam@email.com', '0612345707'),
(133, 'Gijs', '', 'Scholten', 'bedrijf1', 'Project Manager', 'gijs.scholten@email.com', '0612345708'),
(134, 'Lotte', 'van den', 'Berg', 'SuperCoolBedrijf', 'Developer', 'lotte.vandenberg@email.com', '0612345709'),
(135, 'Koen', '', 'Dijkstra', 'TechnoLogica BV', 'Designer', 'koen.dijkstra@email.com', '0612345710'),
(136, 'Anouk', '', 'Smits', 'InnovatieCorp', 'Consultant', 'anouk.smits@email.com', '0612345711'),
(137, 'Rick', '', 'Evers', 'DesignHub', 'Accountmanager', 'rick.evers@email.com', '0612345712'),
(138, 'Femke', 'van', 'Loon', 'CodeMasters', 'CEO', 'femke.vanloon@email.com', '0612345713'),
(139, 'Wouter', '', 'Martens', 'WebWizards', 'CFO', 'wouter.martens@email.com', '0612345714'),
(140, 'Ilse', '', 'Gerrits', 'DataDynamics', 'Marketing Manager', 'ilse.gerrits@email.com', '0612345715'),
(141, 'Jelle', '', 'Verhoeven', 'CloudCompany', 'HR Manager', 'jelle.verhoeven@email.com', '0612345716'),
(142, 'Maud', 'van', 'Beek', 'SmartSolutions', 'Sales Representative', 'maud.vanbeek@email.com', '0612345717'),
(143, 'Bas', 'van', 'Kessel', 'bedrijf1', 'Project Manager', 'bas.vankessel@email.com', '0612345718'),
(144, 'Naomi', '', 'Rutgers', 'SuperCoolBedrijf', 'Developer', 'naomi.rutgers@email.com', '0612345719'),
(145, 'Roy', '', 'Schouten', 'TechnoLogica BV', 'Designer', 'roy.schouten@email.com', '0612345720'),
(146, 'Elin', 'van', 'Doorn', 'InnovatieCorp', 'Consultant', 'elin.vandoorn@email.com', '0612345721'),
(147, 'Stefan', '', 'Mol', 'DesignHub', 'Accountmanager', 'stefan.mol@email.com', '0612345722'),
(148, 'Mirthe', 'van', 'Ginkel', 'CodeMasters', 'CEO', 'mirthe.vanginkel@email.com', '0612345723'),
(149, 'Kevin', '', 'Jacobs', 'WebWizards', 'CFO', 'kevin.jacobs@email.com', '0612345724'),
(150, 'Danique', '', 'Wolters', 'DataDynamics', 'Marketing Manager', 'danique.wolters@email.com', '0612345725'),
(151, 'Patrick', 'de', 'Boer', 'CloudCompany', 'HR Manager', 'patrick.deboer@email.com', '0612345726'),
(152, 'Laura', 'van', 'Dalen', 'SmartSolutions', 'Sales Representative', 'laura.vandalen@email.com', '0612345727');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `medewerkers`
--

DROP TABLE IF EXISTS `medewerkers`;
CREATE TABLE IF NOT EXISTS `medewerkers` (
  `medewerker_ID` int NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tussenvoegsel` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `achternaam` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `geboortedatum` date NOT NULL,
  `functie` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `werkmail` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kantoorruimte` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `uren` int DEFAULT NULL,
  PRIMARY KEY (`medewerker_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2000000054 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `medewerkers`
--

INSERT INTO `medewerkers` (`medewerker_ID`, `voornaam`, `tussenvoegsel`, `achternaam`, `geboortedatum`, `functie`, `werkmail`, `kantoorruimte`, `uren`) VALUES
(1, 'Jan', '', 'Kramer', '1985-01-12', 'Developer', 'jan.kramer@bedrijf.nl', 'A1', 40),
(2, 'Dennis', '', 'Groen', '1990-03-22', 'Designer', 'dennis.groen@bedrijf.nl', 'A2', 40),
(3, 'Mark', '', 'Kuipers', '1987-07-15', 'Project Manager', 'mark.kuipers@bedrijf.nl', 'A3', 40),
(4, 'Niels', '', 'Schipper', '1992-09-18', 'Consultant', 'niels.schipper@bedrijf.nl', 'A4', 40),
(5, 'Tom', '', 'Veldman', '1994-11-30', 'HR Manager', 'tom.veldman@bedrijf.nl', 'A5', 40),
(6, 'Jeroen', '', 'Baars', '1983-05-14', 'CEO', 'jeroen.baars@bedrijf.nl', 'B1', 40),
(7, 'Sven', '', 'Wessels', '1988-08-09', 'CFO', 'sven.wessels@bedrijf.nl', 'B2', 40),
(8, 'Thijs', '', 'Boersma', '1991-12-01', 'Marketing Manager', 'thijs.boersma@bedrijf.nl', 'B3', 40),
(9, 'Robin', '', 'Hofman', '1989-04-21', 'HR Manager', 'robin.hofman@bedrijf.nl', 'B4', 40),
(10, 'Dylan', '', 'Koning', '1996-02-11', 'Sales Representative', 'dylan.koning@bedrijf.nl', 'B5', 40),
(11, 'Bjorn', '', 'Nieuwenhuis', '1993-06-18', 'Developer', 'bjorn.nieuwenhuis@bedrijf.nl', 'C1', 40),
(12, 'Martijn', '', 'Zuidema', '1986-10-27', 'Developer', 'martijn.zuidema@bedrijf.nl', 'C2', 40),
(13, 'Erik', '', 'Otter', '1988-03-03', 'Designer', 'erik.otter@bedrijf.nl', 'C3', 40),
(14, 'Hugo', '', 'Rietveld', '1992-07-19', 'Consultant', 'hugo.rietveld@bedrijf.nl', 'C4', 40),
(15, 'Stijn', 'van', 'Hees', '1988-02-25', 'Accountmanager', 'stijn.vanhees@bedrijf.nl', 'C5', 40),
(16, 'Koos', '', 'Verschuren', '1991-11-13', 'CEO', 'koos.verschuren@bedrijf.nl', 'D1', 40),
(17, 'Bart', '', 'Looman', '1984-06-06', 'CFO', 'bart.looman@bedrijf.nl', 'D2', 40),
(18, 'Joris', 'van', 'Etten', '1990-09-29', 'Marketing Manager', 'joris.vanetten@bedrijf.nl', 'D3', 40),
(19, 'Wim', '', 'Schellekens', '1987-12-15', 'HR Manager', 'wim.schellekens@bedrijf.nl', 'D4', 40),
(20, 'Kees', '', 'Brands', '1995-04-04', 'Sales Representative', 'kees.brands@bedrijf.nl', 'D5', 40),
(21, 'Henk', 'van der', 'Pol', '1986-08-08', 'Project Manager', 'henk.pol@bedrijf.nl', 'E1', 40),
(22, 'Ralph', '', 'Kleijn', '1993-01-21', 'Developer', 'ralph.kleijn@bedrijf.nl', 'E2', 40),
(23, 'Joost', '', 'Terlouw', '1989-05-30', 'Designer', 'joost.terlouw@bedrijf.nl', 'E3', 40),
(24, 'Sander', '', 'Verbeek', '1994-07-12', 'Consultant', 'sander.verbeek@bedrijf.nl', 'E4', 40),
(25, 'Maurice', 'van', 'Aalst', '1988-03-27', 'Accountmanager', 'maurice.vanaalst@bedrijf.nl', 'E5', 40),
(26, 'Frank', '', 'Kool', '1992-09-09', 'CEO', 'frank.kool@bedrijf.nl', 'F1', 40),
(27, 'Leo', '', 'Hoogland', '1985-11-23', 'CFO', 'leo.hoogland@bedrijf.nl', 'F2', 40),
(28, 'Basjan', '', 'Vernooy', '1991-06-16', 'Marketing Manager', 'basjan.vernooy@bedrijf.nl', 'F3', 40),
(29, 'Rik', '', 'Tempelman', '1987-02-02', 'HR Manager', 'rik.tempelman@bedrijf.nl', 'F4', 40),
(30, 'Timo', 'van', 'Houten', '1996-12-12', 'Sales Representative', 'timo.vanhouten@bedrijf.nl', 'F5', 40),
(31, 'Gerben', '', 'Slagter', '1983-04-18', 'Project Manager', 'gerben.slagter@bedrijf.nl', 'G1', 40),
(32, 'Pim', '', 'Doedens', '1990-10-10', 'Developer', 'pim.doedens@bedrijf.nl', 'G2', 40),
(33, 'Dirk', '', 'Kruizinga', '1989-01-05', 'Designer', 'dirk.kruizinga@bedrijf.nl', 'G3', 40),
(34, 'Arno', '', 'Witkamp', '1993-03-22', 'Consultant', 'arno.witkamp@bedrijf.nl', 'G4', 40),
(35, 'Koert', '', 'Banning', '1988-07-07', 'Accountmanager', 'koert.banning@bedrijf.nl', 'G5', 40),
(36, 'Frits', 'van', 'Beers', '1991-05-25', 'CEO', 'frits.vanbeers@bedrijf.nl', 'H1', 40),
(37, 'Karel', '', 'Steenhuis', '1984-09-14', 'CFO', 'karel.steenhuis@bedrijf.nl', 'H2', 40),
(38, 'Nico', '', 'Kamps', '1992-11-30', 'Marketing Manager', 'nico.kamps@bedrijf.nl', 'H3', 40),
(39, 'Otto', '', 'Meursing', '1987-08-19', 'HR Manager', 'otto.meursing@bedrijf.nl', 'H4', 40),
(40, 'Ruud', 'van', 'Zanten', '1995-02-08', 'Sales Representative', 'ruud.vanzanten@bedrijf.nl', 'H5', 40),
(41, 'Eddy', 'van', 'Vliet', '1986-06-11', 'Project Manager', 'eddy.vanvliet@bedrijf.nl', 'I1', 40),
(42, 'Harm', '', 'Talsma', '1994-12-03', 'Developer', 'harm.talsma@bedrijf.nl', 'I2', 40),
(43, 'Geert', '', 'Bosma', '1989-04-26', 'Designer', 'geert.bosma@bedrijf.nl', 'I3', 40),
(44, 'Janus', 'van', 'Raalte', '1993-09-17', 'Consultant', 'janus.vanraalte@bedrijf.nl', 'I4', 40),
(45, 'Wessel', '', 'Koopman', '1988-01-29', 'Accountmanager', 'wessel.koopman@bedrijf.nl', 'I5', 40),
(46, 'Teun', 'van', 'Gorp', '1992-07-07', 'CEO', 'teun.vangorp@bedrijf.nl', 'J1', 40),
(47, 'Casper', '', 'Helder', '1985-10-20', 'CFO', 'casper.helder@bedrijf.nl', 'J2', 40),
(48, 'Boudewijn', '', 'Kieft', '1991-03-14', 'Marketing Manager', 'boudewijn.kieft@bedrijf.nl', 'J3', 40),
(49, 'Sjoerd', '', 'Ravensberg', '1987-06-06', 'HR Manager', 'sjoerd.ravensberg@bedrijf.nl', 'J4', 40),
(50, 'Laurens', 'van', 'Rooij', '1995-11-11', 'Sales Representative', 'laurens.vanrooij@bedrijf.nl', 'J5', 40);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `medewerker_rechten`
--

DROP TABLE IF EXISTS `medewerker_rechten`;
CREATE TABLE IF NOT EXISTS `medewerker_rechten` (
  `medewerker_id` int NOT NULL,
  `wachtwoord` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`medewerker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `medewerker_rechten`
--

INSERT INTO `medewerker_rechten` (`medewerker_id`, `wachtwoord`, `rol`) VALUES
(1, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(2, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(3, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(4, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(5, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(6, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(7, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(8, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(9, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(10, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(11, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(12, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(13, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(14, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(15, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(16, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(17, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(18, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(19, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(20, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(21, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(22, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(23, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(24, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(25, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(26, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(27, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(28, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(29, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(30, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(31, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(32, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(33, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(34, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(35, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(36, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(37, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(38, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(39, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(40, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(41, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(42, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(43, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(44, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker'),
(45, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(46, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(47, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(48, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(49, '$2y$10$5/axeA85Y5EhbyNQ.q6DCesEiOsH5YBWLG2BEeEWZpil45P7SmEMK', 'admin'),
(50, '$2y$10$H.0rZjp0Du3pw2j/DIL10ujHSWmeOd.3z3W9zUJxxRqA2nA1Bd396', 'medewerker');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `opdrachten`
--

DROP TABLE IF EXISTS `opdrachten`;
CREATE TABLE IF NOT EXISTS `opdrachten` (
  `Opdrachten_ID` int NOT NULL AUTO_INCREMENT,
  `Klantnaam` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Titel` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Omschrijving` text COLLATE utf8mb4_general_ci NOT NULL,
  `Aanvraagdatum` date NOT NULL,
  `Benodigde_kennis` text COLLATE utf8mb4_general_ci NOT NULL,
  `uurloon` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Opdrachten_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1100000104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `opdrachten`
--

INSERT INTO `opdrachten` (`Opdrachten_ID`, `Klantnaam`, `Titel`, `Omschrijving`, `Aanvraagdatum`, `Benodigde_kennis`, `uurloon`) VALUES
(51, 'SuperCoolBedrijf', 'API ontwikkeling', 'REST API bouwen voor mobiele app', '2025-01-12', 'PHP, Laravel', 65.00),
(54, 'bedrijf1', 'Website redesign', 'Complete redesign van bedrijfswebsite', '2025-01-10', 'HTML, CSS, UX', 65.00),
(55, 'TechnoLogica BV', 'Logo design', 'Nieuw logo ontwerpen', '2025-01-15', 'Photoshop, Illustrator', 65.00),
(56, 'InnovatieCorp', 'Consultancy IT', 'Advies over IT infrastructuur', '2025-01-18', 'ITIL, Netwerken', 65.00),
(57, 'DesignHub', 'Marketing campagne', 'Online campagne opzetten', '2025-01-20', 'SEO, SEA', 65.00),
(58, 'CodeMasters', 'SaaS platform', 'Nieuw platform ontwikkelen', '2025-01-22', 'Node.js, React', 65.00),
(59, 'WebWizards', 'Financieel systeem', 'Boekhoudsoftware bouwen', '2025-01-25', 'Java, Spring', 65.00),
(60, 'DataDynamics', 'Data analyse', 'Dashboard bouwen', '2025-01-28', 'Python, PowerBI', 65.00),
(61, 'CloudCompany', 'Cloud migratie', 'Migratie naar AWS', '2025-02-01', 'AWS, DevOps', 65.00),
(62, 'SmartSolutions', 'CRM systeem', 'CRM implementeren', '2025-02-03', 'Salesforce', 65.00),
(63, 'bedrijf1', 'Project planning tool', 'Tool voor projectbeheer', '2025-02-05', 'Angular, Firebase', 65.00),
(64, 'SuperCoolBedrijf', 'Bug fixing', 'Bugs oplossen in bestaande app', '2025-02-07', 'JavaScript', 65.00),
(65, 'TechnoLogica BV', 'UX audit', 'Gebruiksvriendelijkheid verbeteren', '2025-02-09', 'UX research', 65.00),
(66, 'InnovatieCorp', 'Security audit', 'Beveiliging testen', '2025-02-11', 'Cybersecurity', 65.00),
(67, 'DesignHub', 'Branding', 'Nieuwe huisstijl ontwikkelen', '2025-02-13', 'Design', 65.00),
(68, 'CodeMasters', 'AI integratie', 'AI toevoegen aan app', '2025-02-15', 'Python, AI', 65.00),
(69, 'WebWizards', 'ERP systeem', 'ERP implementeren', '2025-02-17', 'SAP', 65.00),
(70, 'DataDynamics', 'Big data project', 'Data pipeline bouwen', '2025-02-19', 'Hadoop', 65.00),
(71, 'CloudCompany', 'Server setup', 'Servers configureren', '2025-02-21', 'Linux', 65.00),
(72, 'SmartSolutions', 'Sales dashboard', 'Dashboard maken', '2025-02-23', 'Tableau', 65.00),
(73, 'bedrijf1', 'Mobiele app', 'iOS app bouwen', '2025-02-25', 'Swift', 65.00),
(74, 'SuperCoolBedrijf', 'Android app', 'Android app ontwikkelen', '2025-02-27', 'Kotlin', 65.00),
(75, 'TechnoLogica BV', 'Animatie design', 'Animaties maken', '2025-03-01', 'After Effects', 65.00),
(76, 'InnovatieCorp', 'Proces optimalisatie', 'Bedrijfsprocessen verbeteren', '2025-03-03', 'Lean', 65.00),
(77, 'DesignHub', 'Landing page', 'Nieuwe landingspagina', '2025-03-05', 'HTML, CSS', 65.00),
(78, 'CodeMasters', 'Microservices', 'Architectuur bouwen', '2025-03-07', 'Docker', 65.00),
(79, 'WebWizards', 'Backend upgrade', 'Upgrade backend systeem', '2025-03-09', 'PHP', 65.00),
(80, 'DataDynamics', 'ML model', 'Machine learning model bouwen', '2025-03-11', 'Python', 65.00),
(81, 'CloudCompany', 'CI/CD pipeline', 'Pipeline opzetten', '2025-03-13', 'Jenkins', 65.00),
(82, 'SmartSolutions', 'Klantenportaal', 'Portaal ontwikkelen', '2025-03-15', 'Vue.js', 65.00),
(83, 'bedrijf1', 'Intranet', 'Intern platform bouwen', '2025-03-17', 'SharePoint', 65.00),
(84, 'SuperCoolBedrijf', 'Chat applicatie', 'Realtime chat bouwen', '2025-03-19', 'Socket.io', 65.00),
(85, 'TechnoLogica BV', '3D design', '3D modellen maken', '2025-03-21', 'Blender', 65.00),
(86, 'InnovatieCorp', 'Risico analyse', 'Risico’s in kaart brengen', '2025-03-23', 'Analyse', 65.00),
(87, 'DesignHub', 'Social media', 'Social media strategie', '2025-03-25', 'Marketing', 65.00),
(88, 'CodeMasters', 'Blockchain app', 'Blockchain implementatie', '2025-03-27', 'Solidity', 65.00),
(89, 'WebWizards', 'Webshop', 'E-commerce bouwen', '2025-03-29', 'Magento', 65.00),
(90, 'DataDynamics', 'ETL proces', 'ETL pipeline maken', '2025-03-31', 'SQL', 65.00),
(91, 'CloudCompany', 'Kubernetes cluster', 'Cluster opzetten', '2025-04-02', 'Kubernetes', 65.00),
(92, 'SmartSolutions', 'Support systeem', 'Ticket systeem bouwen', '2025-04-04', 'Zendesk', 65.00),
(93, 'bedrijf1', 'HR systeem', 'HR software ontwikkelen', '2025-04-06', 'HRM', 65.00),
(94, 'SuperCoolBedrijf', 'Test automatisering', 'Tests automatiseren', '2025-04-08', 'Selenium', 65.00),
(95, 'TechnoLogica BV', 'Illustraties', 'Custom illustraties maken', '2025-04-10', 'Illustrator', 65.00),
(96, 'InnovatieCorp', 'Training IT', 'Training geven', '2025-04-12', 'Coaching', 65.00),
(97, 'DesignHub', 'Portfolio site', 'Portfolio website bouwen', '2025-04-14', 'HTML', 65.00),
(98, 'CodeMasters', 'Refactoring', 'Code verbeteren', '2025-04-16', 'Clean code', 65.00),
(99, 'WebWizards', 'Hosting setup', 'Hosting configureren', '2025-04-18', 'cPanel', 65.00),
(100, 'DataDynamics', 'Reporting tool', 'Rapportage tool bouwen', '2025-04-20', 'PowerBI', 65.00),
(101, 'CloudCompany', 'Backup systeem', 'Backups automatiseren', '2025-04-22', 'Azure', 65.00),
(102, 'SmartSolutions', 'E-mail systeem', 'Mailserver opzetten', '2025-04-24', 'SMTP', 65.00);

-- --------------------------------------------------------

--
-- Stand-in structuur voor view `rapportage_overzicht`
-- (Zie onder voor de actuele view)
--
DROP VIEW IF EXISTS `rapportage_overzicht`;
CREATE TABLE IF NOT EXISTS `rapportage_overzicht` (
`maand` int
,`totaal_uren` decimal(32,0)
,`totale_omzet` decimal(34,0)
);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
CREATE TABLE IF NOT EXISTS `support_tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'open',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

--
-- Gegevens worden geëxporteerd voor tabel `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `created`, `name`, `email`, `subject`, `message`, `status`) VALUES
(1, '2026-06-03 14:07:31', 'Jafer', 'Jaferasad10@gmail.com', 'test', 'ik test', 'open'),
(2, '2026-06-03 14:09:23', 'jon', 'Jaferasad10@gmail.com', 'pizza', 'eet', 'open');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `werkzaamheden`
--

DROP TABLE IF EXISTS `werkzaamheden`;
CREATE TABLE IF NOT EXISTS `werkzaamheden` (
  `werkzaamheden_ID` int NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tussenvoegsel` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `achternaam` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `gewerkte_uren` int NOT NULL,
  `opdracht_titel` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `omschrijving_werkzaamheden` text COLLATE utf8mb4_general_ci NOT NULL,
  `datum` date DEFAULT NULL,
  `opdracht_id` int DEFAULT NULL,
  `medewerker_id` int DEFAULT NULL,
  PRIMARY KEY (`werkzaamheden_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2000000054 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `werkzaamheden`
--

INSERT INTO `werkzaamheden` (`werkzaamheden_ID`, `voornaam`, `tussenvoegsel`, `achternaam`, `gewerkte_uren`, `opdracht_titel`, `omschrijving_werkzaamheden`, `datum`, `opdracht_id`, `medewerker_id`) VALUES
(1, 'jan', '', 'Kramer', 5, 'API ontwikkeling', 'API endpoints bouwen', '2026-06-01', 51, 1),
(2, 'Dennis', '', 'Groen', 6, 'API ontwikkeling', 'API endpoints bouwen', '2026-06-02', 51, 2),
(3, 'Mark', '', 'Kuipers', 7, 'Logo design', 'Concepten uitwerken', '2026-06-03', 55, 3),
(4, 'Niels', '', 'Schipper', 5, 'Consultancy IT', 'Analyse infrastructuur', '2026-06-04', 56, 4),
(5, 'Tom', '', 'Veldman', 4, 'Marketing campagne', 'Campagne planning', '2026-06-05', 57, 5),
(6, 'Jeroen', '', 'Baars', 9, 'SaaS platform', 'Backend ontwikkeling', '2026-06-06', 58, 6),
(7, 'Sven', '', 'Wessels', 8, 'Financieel systeem', 'Database ontwerp', '2026-06-07', 59, 7),
(8, 'Thijs', '', 'Boersma', 6, 'Data analyse', 'Dashboard maken', '2026-06-08', 60, 8),
(9, 'Robin', '', 'Hofman', 7, 'Cloud migratie', 'Migratie uitvoeren', '2026-06-08', 61, 9),
(10, 'Dylan', '', 'Koning', 5, 'CRM systeem', 'Configuratie CRM', '2026-06-09', 63, 10),
(11, 'Bjorn', '', 'Nieuwenhuis', 8, 'Project planning tool', 'Frontend bouwen', '2026-06-09', 63, 11),
(12, 'Martijn', '', 'Zuidema', 6, 'Bug fixing', 'Fouten oplossen', '2026-06-10', 64, 12),
(13, 'Erik', '', 'Otter', 7, 'UX audit', 'UX verbeteringen voorstellen', '2026-06-10', 65, 13),
(14, 'Hugo', '', 'Rietveld', 5, 'Security audit', 'Security scan uitvoeren', '2026-06-10', 66, 14),
(15, 'Stijn', 'van', 'Hees', 4, 'Branding', 'Huisstijl ontwerpen', '2026-06-10', 67, 15),
(16, 'Koos', '', 'Verschuren', 9, 'AI integratie', 'Machine learning model trainen', '2026-06-10', 68, 16),
(17, 'Bart', '', 'Looman', 8, 'ERP systeem', 'Implementatie ERP', '2026-06-11', 69, 17),
(18, 'Joris', 'van', 'Etten', 6, 'Big data project', 'Data pipeline bouwen', '2026-06-11', 70, 18),
(19, 'Wim', '', 'Schellekens', 7, 'Server setup', 'Servers configureren', '2026-06-11', 58, 19),
(20, 'Kees', '', 'Brands', 5, 'Sales dashboard', 'Dashboard ontwikkelen', '2026-06-11', 60, 20),
(21, 'Henk', 'van der', 'Pol', 8, 'Mobiele app', 'iOS app bouwen', '2026-06-11', 58, 21),
(22, 'Ralph', '', 'Kleijn', 6, 'Android app', 'Android features ontwikkelen', '2026-06-11', 58, 22),
(23, 'Joost', '', 'Terlouw', 7, 'Animatie design', 'Animaties maken', '2026-06-11', 55, 23),
(24, 'Sander', '', 'Verbeek', 5, 'Proces optimalisatie', 'Proces analyse', '2026-06-11', 57, 24),
(25, 'Maurice', 'van', 'Aalst', 4, 'Landing page', 'Pagina ontwerpen', '2026-06-11', 54, 25),
(26, 'Frank', '', 'Kool', 9, 'Microservices', 'Services opzetten', NULL, NULL, NULL),
(27, 'Leo', '', 'Hoogland', 8, 'Backend upgrade', 'Backend refactoren', '2026-06-12', 51, 1),
(28, 'Basjan', '', 'Vernooy', 6, 'ML model', 'Model trainen', '2026-06-12', 54, 2),
(29, 'Rik', '', 'Tempelman', 7, 'CI/CD pipeline', 'Pipeline bouwen', '2026-06-12', 55, 3),
(30, 'Timo', 'van', 'Houten', 5, 'Klantenportaal', 'Portaal ontwikkelen', '2026-06-12', 56, 4),
(31, 'Gerben', '', 'Slagter', 8, 'Intranet', 'Intern platform bouwen', '2026-06-12', 57, 5),
(32, 'Pim', '', 'Doedens', 6, 'Chat applicatie', 'Realtime chat bouwen', '2026-06-12', 58, 6),
(33, 'Dirk', '', 'Kruizinga', 7, '3D design', '3D modellen maken', '2026-06-12', 59, 7),
(34, 'Arno', '', 'Witkamp', 5, 'Risico analyse', 'Risico analyse uitvoeren', '2026-06-13', 60, 8),
(35, 'Koert', '', 'Banning', 4, 'Social media', 'Posts plannen', '2026-06-13', 61, 9),
(36, 'Frits', 'van', 'Beers', 9, 'Blockchain app', 'Smart contracts schrijven', '2026-06-13', 62, 10),
(37, 'Karel', '', 'Steenhuis', 8, 'Webshop', 'E-commerce bouwen', '2026-06-13', 63, 11),
(38, 'Nico', '', 'Kamps', 6, 'ETL proces', 'Data verwerken', '2026-06-13', 64, 12),
(39, 'Otto', '', 'Meursing', 7, 'Kubernetes cluster', 'Cluster opzetten', '2026-06-13', 65, 13),
(40, 'Ruud', 'van', 'Zanten', 5, 'Support systeem', 'Ticketsysteem bouwen', '2026-06-13', 66, 14),
(41, 'Eddy', 'van', 'Vliet', 8, 'HR systeem', 'HR software bouwen', '2026-06-14', 67, 15),
(42, 'Harm', '', 'Talsma', 6, 'Test automatisering', 'Tests schrijven', '2026-06-14', 68, 16),
(43, 'Geert', '', 'Bosma', 7, 'Illustraties', 'Illustraties maken', '2026-06-14', 69, 17),
(44, 'Janus', 'van', 'Raalte', 5, 'Training IT', 'Training geven', '2026-06-14', 70, 18),
(45, 'Wessel', '', 'Koopman', 4, 'Portfolio site', 'Website bouwen', '2026-06-14', 51, 19),
(46, 'Teun', 'van', 'Gorp', 9, 'Refactoring', 'Code verbeteren', '2026-06-14', 54, 20),
(47, 'Casper', '', 'Helder', 8, 'Hosting setup', 'Hosting configureren', '2026-06-14', 55, 21),
(48, 'Boudewijn', '', 'Kieft', 6, 'Reporting tool', 'Rapportages maken', '2026-06-14', 56, 22),
(49, 'Sjoerd', '', 'Ravensberg', 7, 'Backup systeem', 'Backups instellen', '2026-06-14', 57, 23),
(50, 'Laurens', 'van', 'Rooij', 5, 'E-mail systeem', 'Mailserver configureren', '2026-06-14', 70, 26);

-- --------------------------------------------------------

--
-- Structuur voor de view `rapportage_overzicht`
--
DROP TABLE IF EXISTS `rapportage_overzicht`;

DROP VIEW IF EXISTS `rapportage_overzicht`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `rapportage_overzicht`  AS SELECT month(`werkzaamheden`.`datum`) AS `maand`, sum(`werkzaamheden`.`gewerkte_uren`) AS `totaal_uren`, sum((`werkzaamheden`.`gewerkte_uren` * 65)) AS `totale_omzet` FROM `werkzaamheden` GROUP BY month(`werkzaamheden`.`datum`) ;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `medewerker_rechten`
--
ALTER TABLE `medewerker_rechten`
  ADD CONSTRAINT `medewerker_rechten_ibfk_1` FOREIGN KEY (`medewerker_id`) REFERENCES `medewerkers` (`medewerker_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
