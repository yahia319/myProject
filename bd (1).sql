-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 19, 2021 at 09:12 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

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
-- Table structure for table `avoir_domaine`
--

CREATE TABLE `avoir_domaine` (
  `id_utilisateur` int(11) NOT NULL,
  `num_domaine` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `avoir_domaine`
--

INSERT INTO `avoir_domaine` (`id_utilisateur`, `num_domaine`) VALUES
(13, 1),
(13, 2);

-- --------------------------------------------------------

--
-- Table structure for table `domaine_interet`
--

CREATE TABLE `domaine_interet` (
  `num_domaine` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `domaine_interet`
--

INSERT INTO `domaine_interet` (`num_domaine`, `nom`) VALUES
(1, 'data science'),
(2, 'Semantic Web');

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

--
-- Dumping data for table `equipe`
--

INSERT INTO `equipe` (`num_equipe`, `num_chef`, `num_labo`, `nbr_chercheur`) VALUES
(1, 10, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `labo`
--

CREATE TABLE `labo` (
  `num_labo` int(11) NOT NULL,
  `num_directeur` int(11) NOT NULL,
  `nbr_salle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `labo`
--

INSERT INTO `labo` (`num_labo`, `num_directeur`, `nbr_salle`) VALUES
(1, 9, 2);

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
(9, 'first ps', 'article', 'first description'),
(13, 'dsqsds', 'sqqdsd', ''),
(13, 'LDS', 'info', 'test'),
(13, 'lll', 'lll', 'll\r\n'),
(13, 'OIP', 'PPO', 'sd'),
(13, 'qdsqdk', 'sdsd', ''),
(13, 'qsdsqd', 'sdqsd', ''),
(13, 'qsdsqdsqdsd', 'sdsqd', ''),
(13, 'sdsdsd', 'sdsd', ''),
(13, 'sqdlkqsldj', 'sd', ''),
(13, 'ze', 'ze', '');

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
(9, 'yahia directeur labo 1', 'gduio', 'yahia.hallas19@gmail.com', 'yahia', '2021-06-03', 'EF', 1, 1, NULL, 1),
(10, 'yahia chef equipe 1', 'gduio', 'yh538331@gmail.com', 'yahia', '2021-06-05', 'tamalous', 1, 1, NULL, 1),
(11, 'yahia', 'yahia', 'yh538335@gmail.com', 'yahia', '2021-06-09', 'tamalous', 1, 1, NULL, 1),
(12, 'yahia', 'yahia', 'ahia.hallas19@gmail.com', 'yahia', '2021-06-17', 'EF', 2, 1, NULL, 1),
(13, 'nas', 'che', 'nacer.cheniki@gmail.com', '1', '1990-04-21', 'ta', 1, 1, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avoir_domaine`
--
ALTER TABLE `avoir_domaine`
  ADD KEY `id_utilisateur_index` (`id_utilisateur`),
  ADD KEY `domaine_index` (`num_domaine`);

--
-- Indexes for table `domaine_interet`
--
ALTER TABLE `domaine_interet`
  ADD PRIMARY KEY (`num_domaine`);

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
  MODIFY `num_equipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `labo`
--
ALTER TABLE `labo`
  MODIFY `num_labo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `avoir_domaine`
--
ALTER TABLE `avoir_domaine`
  ADD CONSTRAINT `avoir_domaine_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `avoir_domaine_ibfk_2` FOREIGN KEY (`num_domaine`) REFERENCES `domaine_interet` (`num_domaine`);

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
