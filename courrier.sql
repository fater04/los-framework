-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 30, 2024 at 01:53 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courrier`
--

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `role` varchar(300) DEFAULT NULL,
  `token` tinytext,
  `pseudo` varchar(300) DEFAULT NULL,
  `email` varchar(300) DEFAULT NULL,
  `nom` varchar(300) DEFAULT NULL,
  `motdepasse` tinytext,
  `statut` varchar(100) DEFAULT NULL,
  `date_creation` varchar(200) NOT NULL,
  `telephone` varchar(200) NOT NULL,
  `photo` tinytext NOT NULL,
  `derniere_connection` varchar(200) NOT NULL,
  `verified` varchar(100) NOT NULL,
  `token_device` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `role`, `token`, `pseudo`, `email`, `nom`, `motdepasse`, `statut`, `date_creation`, `telephone`, `photo`, `derniere_connection`, `verified`, `token_device`) VALUES
(1, 'super-admin', '', 'fater04', 'wilker@solutionip.app', 'wilker dorvelus', '$2y$10$KbqTj.7/vweiB4Iw72Yy4OHBZfeSwlS8CKClcpCEPLnXoIGmNITr2', 'oui', '2023-09-11 10:49:14', '31110731', 'n/a', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
