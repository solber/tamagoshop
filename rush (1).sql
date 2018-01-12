-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 12 jan. 2018 à 00:22
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31
CREATE DATABASE rush
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE rush;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rush`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories_ref`
--

DROP TABLE IF EXISTS `categories_ref`;
CREATE TABLE IF NOT EXISTS `categories_ref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories_ref`
--

INSERT INTO `categories_ref` (`id`, `name`) VALUES
(6, 'Blue'),
(7, 'Red'),
(8, 'Orange'),
(9, 'Purple'),
(10, 'Familly');

-- --------------------------------------------------------

--
-- Structure de la table `op_user`
--

DROP TABLE IF EXISTS `op_user`;
CREATE TABLE IF NOT EXISTS `op_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `img`) VALUES
(18, 'Red Tamagotchi', 4.00, 'img/red.jpg'),
(19, 'Blue Tamagotchi', 5.00, 'img/blue.jpg'),
(20, 'Orange Tamagotchi', 2.00, 'img/orange.jpg'),
(21, 'Purple Tamagotchi', 4.50, 'img/purple.jpg'),
(22, 'Blue Tamagotchi Family', 10.00, 'img/family-blue.jpg'),
(23, 'Green Tamagotchi Family', 10.00, 'img/family-green.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `prod_categorie`
--

DROP TABLE IF EXISTS `prod_categorie`;
CREATE TABLE IF NOT EXISTS `prod_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `prod_categorie`
--

INSERT INTO `prod_categorie` (`id`, `prod_id`, `cat_id`) VALUES
(17, 18, 7),
(18, 19, 6),
(20, 20, 8),
(21, 21, 9),
(22, 22, 10),
(23, 22, 6),
(24, 23, 10);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(9, 'solber', '$2y$10$CPVueAaNcXs.WRLBCMKyFes7RsOl8.PRbPMT46r4qkrfCA1ktsblO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
