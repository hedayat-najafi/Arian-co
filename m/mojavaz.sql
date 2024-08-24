-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2024 at 09:09 AM
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
-- Database: `mojavaz`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `postalCode` char(10) NOT NULL,
  `address` varchar(250) NOT NULL,
  `codeMelli` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`postalCode`, `address`, `codeMelli`) VALUES
('5544332210', 'ادرس 1', '4285994224'),
('5544332211', 'ادرس 2', '4285994224');

-- --------------------------------------------------------

--
-- Table structure for table `mojavez`
--

CREATE TABLE `mojavez` (
  `postalCode` char(10) NOT NULL,
  `codeMojavez` char(12) NOT NULL,
  `requestDate` varchar(20) NOT NULL,
  `verifyDate` varchar(20) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT 0,
  `description` varchar(250) NOT NULL,
  `code` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `mojavez`
--

INSERT INTO `mojavez` (`postalCode`, `codeMojavez`, `requestDate`, `verifyDate`, `Status`, `description`, `code`) VALUES
('5544332211', '112233445562', '1403/04/05', '1403/04/10', 1, 'مشکلی وجود ندارد', '111222333442'),
('5544332210', '112233445561', '1403/02/10', '1403/02/15', 1, 'مشکلی وجود ندارد', '111222333444');

-- --------------------------------------------------------

--
-- Table structure for table `mojaveztype`
--

CREATE TABLE `mojaveztype` (
  `codeMojavez` char(12) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `orgCode` char(5) NOT NULL,
  `issuPrice` int(11) NOT NULL,
  `issuTime` varchar(50) NOT NULL,
  `validTime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `mojaveztype`
--

INSERT INTO `mojaveztype` (`codeMojavez`, `title`, `description`, `orgCode`, `issuPrice`, `issuTime`, `validTime`) VALUES
('112233445561', 'راه اندازی نیروگاه خورشیدی', 'راه اندازی نیروگاه خورشیدی\r\nراه اندازی نیروگاه خورشیدی\r\nراه اندازی نیروگاه خورشیدی', '11221', 25000, '10 روز', '3 سال'),
('112233445562', 'پرورش گیاهان تزیینی', 'پرورش گیاهان تزیینی\r\nپرورش گیاهان تزیینی', '11222', 30000, '5روز', '2 سال');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `codeMelli` char(10) NOT NULL,
  `fName` varchar(150) NOT NULL,
  `lName` varchar(150) NOT NULL,
  `fatherName` varchar(150) NOT NULL,
  `birthDate` varchar(100) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `mobile` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`codeMelli`, `fName`, `lName`, `fatherName`, `birthDate`, `gender`, `mobile`) VALUES
('4285994224', 'هدایت 1', 'نجفی 1', 'حسین علی', '1366/05/11', 1, '09195814368'),
('4285994234', 'هدایت', 'نجفی', 'حسین علی', '1366/05/10', 1, '09195814368');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`postalCode`),
  ADD KEY `FK_address_person_codeMelli` (`codeMelli`);

--
-- Indexes for table `mojavez`
--
ALTER TABLE `mojavez`
  ADD PRIMARY KEY (`code`),
  ADD KEY `FK_mojavez_mojavezType_codeMojavez` (`codeMojavez`),
  ADD KEY `FK_mojavez_address_postalCode` (`postalCode`);

--
-- Indexes for table `mojaveztype`
--
ALTER TABLE `mojaveztype`
  ADD PRIMARY KEY (`codeMojavez`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`codeMelli`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_address_person_codeMelli` FOREIGN KEY (`codeMelli`) REFERENCES `person` (`codeMelli`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mojavez`
--
ALTER TABLE `mojavez`
  ADD CONSTRAINT `FK_mojavez_address_postalCode` FOREIGN KEY (`postalCode`) REFERENCES `address` (`postalCode`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_mojavez_mojavezType_codeMojavez` FOREIGN KEY (`codeMojavez`) REFERENCES `mojaveztype` (`codeMojavez`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
