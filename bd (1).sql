-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 15, 2021 at 04:27 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipe`
--

CREATE TABLE `equipe` (
  `num_equipe` int(11) NOT NULL,
  `num_chef` int(11) NOT NULL,
  `num_labo` int(11) NOT NULL,
  `nbr_chercheur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `labo`
--

CREATE TABLE `labo` (
  `num_labo` int(11) NOT NULL,
  `num_directeur` int(11) NOT NULL,
  `nbr_salle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `production_sientifique`
--

CREATE TABLE `production_sientifique` (
  `num_chercheur` int(11) NOT NULL,
  `nom_ps` varchar(25) NOT NULL,
  `categorie_ps` varchar(25) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `production_sientifique`
--

INSERT INTO `production_sientifique` (`num_chercheur`, `nom_ps`, `categorie_ps`, `description`) VALUES
(9, '2nd', 'livre', '2nd description'),
(9, 'first ps', 'article', 'first description');

-- --------------------------------------------------------

--
-- Table structure for table `projet`
--

CREATE TABLE `projet` (
  `num_projet` int(11) NOT NULL,
  `categorie` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ressource_materielle`
--

CREATE TABLE `ressource_materielle` (
  `num_ressource` int(11) NOT NULL,
  `num_salle` int(11) NOT NULL,
  `type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `salle`
--

CREATE TABLE `salle` (
  `num_salle` int(11) NOT NULL,
  `num_labo` int(11) NOT NULL,
  `type` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `date_nais` date NOT NULL,
  `adr` varchar(25) NOT NULL,
  `role` int(11) DEFAULT 1,
  `num_equipe` int(11) DEFAULT NULL,
  `num_projet` int(11) DEFAULT NULL,
  `num_labo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `pass`, `date_nais`, `adr`, `role`, `num_equipe`, `num_projet`, `num_labo`) VALUES
(9, 'yahia', 'gduio', 'yahia.hallas19@gmail.com', 'yahia', '2021-06-03', 'EF', 1, NULL, NULL, NULL),
(10, 'yahia', 'gduio', 'yh538331@gmail.com', 'yahia', '2021-06-05', 'tamalous', 1, NULL, NULL, NULL),
(11, 'yahia', 'yahia', 'yh538335@gmail.com', 'yahia', '2021-06-09', 'tamalous', 1, NULL, NULL, NULL),
(12, 'yahia', 'yahia', 'ahia.hallas19@gmail.com', 'yahia', '2021-06-17', 'EF', 1, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`num_equipe`),
  ADD KEY `num_labo` (`num_labo`),
  ADD KEY `num_chef` (`num_chef`);

--
-- Indexes for table `labo`
--
ALTER TABLE `labo`
  ADD PRIMARY KEY (`num_labo`),
  ADD KEY `num_directeur` (`num_directeur`);

--
-- Indexes for table `production_sientifique`
--
ALTER TABLE `production_sientifique`
  ADD PRIMARY KEY (`num_chercheur`,`nom_ps`);

--
-- Indexes for table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`num_projet`);

--
-- Indexes for table `ressource_materielle`
--
ALTER TABLE `ressource_materielle`
  ADD PRIMARY KEY (`num_ressource`),
  ADD KEY `num_salle` (`num_salle`);

--
-- Indexes for table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`num_salle`),
  ADD KEY `num_labo` (`num_labo`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `num_equipe` (`num_equipe`),
  ADD KEY `num_projet` (`num_projet`),
  ADD KEY `num_labo` (`num_labo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `num_equipe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labo`
--
ALTER TABLE `labo`
  MODIFY `num_labo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projet`
--
ALTER TABLE `projet`
  MODIFY `num_projet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ressource_materielle`
--
ALTER TABLE `ressource_materielle`
  MODIFY `num_ressource` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salle`
--
ALTER TABLE `salle`
  MODIFY `num_salle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `equipe_ibfk_2` FOREIGN KEY (`num_labo`) REFERENCES `labo` (`num_labo`),
  ADD CONSTRAINT `equipe_ibfk_3` FOREIGN KEY (`num_chef`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `labo`
--
ALTER TABLE `labo`
  ADD CONSTRAINT `labo_ibfk_1` FOREIGN KEY (`num_directeur`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `production_sientifique`
--
ALTER TABLE `production_sientifique`
  ADD CONSTRAINT `production_sientifique_ibfk_1` FOREIGN KEY (`num_chercheur`) REFERENCES `utilisateurs` (`id`);

--
-- Constraints for table `ressource_materielle`
--
ALTER TABLE `ressource_materielle`
  ADD CONSTRAINT `ressource_materielle_ibfk_1` FOREIGN KEY (`num_salle`) REFERENCES `salle` (`num_salle`);

--
-- Constraints for table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `salle_ibfk_1` FOREIGN KEY (`num_labo`) REFERENCES `labo` (`num_labo`);

--
-- Constraints for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`num_equipe`) REFERENCES `equipe` (`num_equipe`),
  ADD CONSTRAINT `utilisateurs_ibfk_2` FOREIGN KEY (`num_projet`) REFERENCES `projet` (`num_projet`),
  ADD CONSTRAINT `utilisateurs_ibfk_3` FOREIGN KEY (`num_labo`) REFERENCES `labo` (`num_labo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
