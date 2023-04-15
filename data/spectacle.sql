-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 15 avr. 2023 à 19:11
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `spectacle`
--

-- --------------------------------------------------------

--
-- Structure de la table `actor`
--

DROP TABLE IF EXISTS `actor`;
CREATE TABLE IF NOT EXISTS `actor` (
  `id_a` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname_a` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_a` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender_a` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_a`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `actor`
--

INSERT INTO `actor` (`id_a`, `firstname_a`, `name_a`, `gender_a`) VALUES
(1, 'Tommy', 'Serain', 'Male'),
(2, 'Jean-louis', 'Strozza', 'Male'),
(3, 'Mirella', 'Strozza', 'Female');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_r` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_r` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_a` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_r`),
  KEY `id_a` (`id_a`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_r`, `name_r`, `id_a`) VALUES
(1, 'Gaulois Saoul', 1),
(2, 'Chef fagot', 2),
(3, 'Sir de Beaujeu', 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`id_a`) REFERENCES `actor` (`id_a`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
