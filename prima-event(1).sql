-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 24 nov. 2019 à 14:44
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `prima-event`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_unitaire` double NOT NULL,
  `prix_casse` double NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66DCD6110` (`stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `designation`, `prix_unitaire`, `prix_casse`, `stock_id`) VALUES
(1, 'Assiette', 400, 800, NULL),
(2, 'Chapiteaux', 90000, 90000, NULL),
(3, 'Verre', 3000, 3000, NULL),
(4, 'Fourchette', 15000, 15000, NULL),
(5, 'vase', 50000, 50000, NULL),
(6, 'Couteaux', 3000, 3000, NULL),
(7, 'Chaise', 15000, 15000, NULL),
(8, 'sous verre', 1000, 1000, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `caution`
--

DROP TABLE IF EXISTS `caution`;
CREATE TABLE IF NOT EXISTS `caution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `caution`
--

INSERT INTO `caution` (`id`, `reference`, `prix`) VALUES
(1, '20191110104125', 250000),
(2, '20191124100334', 84000),
(3, '20191124103616', 100000),
(4, '20191124105206', 50000),
(5, '11111', 100000);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `type_client_id` int(11) DEFAULT NULL,
  `cin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C7440455DCD6110` (`stock_id`),
  KEY `IDX_C7440455AD2D2831` (`type_client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `nom`, `telephone`, `adresse`, `stock_id`, `type_client_id`, `cin`, `stat`) VALUES
(1, 'razafindrakoto', '0340000000', 'dans l\'espace et dans la lune', NULL, 3, NULL, NULL),
(2, 'Carlton', '2245685', 'Anosy', NULL, 2, '1221205623', '4586611007862'),
(3, 'Tana Event', '0324533000', 'Ivato', NULL, 2, '15526631545222', '175120 45861145'),
(4, 'Sunrise hotel', '22 698 53', 'Ambanidia', NULL, 2, '056 65421 3656 466', '7596 13165 346 333'),
(5, 'CBI', '0000000', 'olm kiii', NULL, 2, '4621218523332', '1488956232145663');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id`, `nom`, `telephone`, `adresse`) VALUES
(1, 'Autre event', '0340000000', 'ambohipo');

-- --------------------------------------------------------

--
-- Structure de la table `indemnite`
--

DROP TABLE IF EXISTS `indemnite`;
CREATE TABLE IF NOT EXISTS `indemnite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refence` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `indemnite`
--

INSERT INTO `indemnite` (`id`, `refence`, `prix`) VALUES
(1, '11111', 10000);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191021190318', '2019-10-21 19:03:33'),
('20191021190455', '2019-10-21 19:05:05'),
('20191024190518', '2019-10-24 19:05:33'),
('20191024190811', '2019-10-24 19:08:21'),
('20191024191057', '2019-10-24 19:11:14'),
('20191024191214', '2019-10-24 19:12:47'),
('20191024191608', '2019-10-24 19:16:28'),
('20191024191910', '2019-10-24 19:19:24'),
('20191024194653', '2019-10-24 19:47:01'),
('20191024195027', '2019-10-24 19:50:34'),
('20191024195916', '2019-10-24 19:59:35'),
('20191024200238', '2019-10-24 20:02:49'),
('20191031172321', '2019-10-31 17:23:44'),
('20191031181108', '2019-10-31 18:11:28'),
('20191031182858', '2019-10-31 18:29:27'),
('20191031183332', '2019-10-31 18:36:44'),
('20191101052248', '2019-11-01 05:23:59'),
('20191101092649', '2019-11-01 09:27:33'),
('20191103055711', '2019-11-03 05:57:31'),
('20191103092057', '2019-11-03 09:21:22'),
('20191104150847', '2019-11-04 15:09:27'),
('20191104152640', '2019-11-04 15:27:19'),
('20191104162617', '2019-11-04 16:26:30'),
('20191106160226', '2019-11-06 16:03:04'),
('20191107012841', '2019-11-07 01:29:11'),
('20191109064253', '2019-11-09 06:43:04'),
('20191109065612', '2019-11-09 06:56:31'),
('20191109074507', '2019-11-09 07:46:11'),
('20191109083729', '2019-11-09 08:38:10'),
('20191109083958', '2019-11-09 08:40:09'),
('20191110073040', '2019-11-10 07:31:28'),
('20191110111217', '2019-11-10 11:12:31'),
('20191110112321', '2019-11-10 11:23:33'),
('20191117052329', '2019-11-17 05:24:18'),
('20191117060328', '2019-11-17 06:03:52'),
('20191117060615', '2019-11-17 06:06:33'),
('20191117071502', '2019-11-17 07:15:11'),
('20191117071933', '2019-11-17 07:20:28');

-- --------------------------------------------------------

--
-- Structure de la table `mode`
--

DROP TABLE IF EXISTS `mode`;
CREATE TABLE IF NOT EXISTS `mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mode`
--

INSERT INTO `mode` (`id`, `mode`) VALUES
(1, 'commande'),
(2, 'effectif'),
(3, 'annuler');

-- --------------------------------------------------------

--
-- Structure de la table `motif_payement`
--

DROP TABLE IF EXISTS `motif_payement`;
CREATE TABLE IF NOT EXISTS `motif_payement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `motif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `motif_payement`
--

INSERT INTO `motif_payement` (`id`, `motif`) VALUES
(1, 'Location'),
(2, 'Avance'),
(3, 'Reste'),
(4, 'Transport'),
(5, 'Refacturation');

-- --------------------------------------------------------

--
-- Structure de la table `mouvement`
--

DROP TABLE IF EXISTS `mouvement`;
CREATE TABLE IF NOT EXISTS `mouvement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mouvement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5B51FC3EDCD6110` (`stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mouvement`
--

INSERT INTO `mouvement` (`id`, `mouvement`, `stock_id`) VALUES
(1, 'sortie', NULL),
(2, 'ajout', NULL),
(3, 'retour', NULL),
(4, 'cassure', NULL),
(5, 'usure', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `paye`
--

DROP TABLE IF EXISTS `paye`;
CREATE TABLE IF NOT EXISTS `paye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refstock` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_payement` date NOT NULL,
  `tva` tinyint(1) NOT NULL,
  `payement_id` int(11) DEFAULT NULL,
  `typepayement_id` int(11) DEFAULT NULL,
  `type_payement_id` int(11) DEFAULT NULL,
  `montant` double NOT NULL,
  `motif_payement_id` int(11) DEFAULT NULL,
  `ref_payement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C04B89FF868C0609` (`payement_id`),
  KEY `IDX_C04B89FFF8C42054` (`typepayement_id`),
  KEY `IDX_C04B89FFCD95D198` (`type_payement_id`),
  KEY `IDX_C04B89FFBC4657A1` (`motif_payement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paye`
--

INSERT INTO `paye` (`id`, `refstock`, `date_payement`, `tva`, `payement_id`, `typepayement_id`, `type_payement_id`, `montant`, `motif_payement_id`, `ref_payement`) VALUES
(1, '20191031194030', '2019-11-01', 1, 1, 2, NULL, 150000, NULL, NULL),
(2, '20191103090930', '2019-11-06', 1, 1, 3, NULL, 140000, 1, NULL),
(3, '20191103090930', '2019-11-06', 1, 1, 3, NULL, 140000, 1, NULL),
(4, '20191106162416', '2019-11-06', 1, 1, 3, NULL, 140000, 1, NULL),
(5, '20191106162509', '2019-11-06', 1, 1, 3, NULL, 140000, 1, NULL),
(6, '20191106162600', '2019-11-06', 1, 1, 3, NULL, 140000, 1, NULL),
(7, '20191103090930', '2019-11-06', 1, 1, 3, NULL, 140000, 1, NULL),
(8, '20191103090930', '2019-11-06', 1, 1, 3, NULL, 140000, 1, NULL),
(9, '20191103090930', '2019-11-06', 1, 1, 1, NULL, 140000, 1, NULL),
(10, '20191103090930', '2019-11-06', 1, 1, 1, NULL, 50000, 2, NULL),
(11, '20191103090930', '2019-11-06', 1, 1, 2, NULL, 1000, 3, NULL),
(12, '20191102164517', '2019-11-10', 1, 1, 2, NULL, 100000, 1, NULL),
(13, '20191110071620', '2019-11-10', 1, 1, 1, NULL, 600000, 1, NULL),
(14, '20191110071620', '2019-11-10', 1, 1, 1, NULL, 600000, 1, NULL),
(15, '20191110071620', '2019-11-10', 1, 1, 1, NULL, 600000, 1, NULL),
(16, '20191110100508', '2019-11-10', 1, 1, 2, NULL, 600000, 1, NULL),
(17, '20191110100508', '2019-11-10', 1, 1, 2, NULL, 600000, 1, NULL),
(18, '20191110104125', '2019-11-10', 1, 1, 2, NULL, 500000, 1, NULL),
(19, '20191124100334', '2019-11-24', 1, 1, 2, NULL, 336000, 2, '20191124101938'),
(20, '20191124105206', '2019-11-24', 1, 1, NULL, NULL, 1740000, NULL, '20191124105554'),
(21, '20191124105206', '2019-11-24', 1, 1, 3, NULL, 1450000, 1, '20191124115617'),
(22, '20191124105206', '2019-11-24', 1, 1, 3, NULL, 1450000, 1, '20191124115617'),
(23, '0', '2019-11-24', 1, 2, 2, NULL, 4000000, 3, '20191124142648');

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

DROP TABLE IF EXISTS `payement`;
CREATE TABLE IF NOT EXISTS `payement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paye_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B20A7885D3964A07` (`paye_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `payement`
--

INSERT INTO `payement` (`id`, `mode`, `paye_id`) VALUES
(1, 'entrée', NULL),
(2, 'sortie', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `privilege`
--

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privilege` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_87209A8719EB6921` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `privilege`
--

INSERT INTO `privilege` (`id`, `privilege`, `client_id`) VALUES
(1, 'normale', NULL),
(2, 'privilegier', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `remise`
--

DROP TABLE IF EXISTS `remise`;
CREATE TABLE IF NOT EXISTS `remise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `remise`
--

INSERT INTO `remise` (`id`, `reference`, `taux`) VALUES
(1, '20191103090930', 30),
(2, '20191103090930', 30),
(3, '20191103090930', 30),
(4, '20191103090930', 30),
(5, '20191103090930', 30),
(6, '20191103090930', 30),
(7, '20191103090930', 30),
(8, '20191103090930', 30),
(9, '20191103090930', 30),
(10, '20191124105206', 100000),
(11, '20191124105206', 10000),
(12, '20191124105206', 10000),
(13, '20191124105206', 10000),
(14, '20191124105206', 10000),
(15, '20191124105206', 10000),
(16, '20191124105206', 10000),
(17, '20191124105206', 10000),
(18, '20191124105206', 10000),
(19, '20191124105206', 10000),
(20, '20191124105206', 10000),
(21, '20191124105206', 10000),
(22, '20191124105206', 10000),
(23, '20191124105206', 10000),
(24, '20191124105206', 10000),
(25, '20191124105206', 10000),
(26, '20191124105206', 10000),
(27, '20191124105206', 10000),
(28, '20191124105206', 10000),
(29, '20191124105206', 10000),
(30, '20191124105206', 10000),
(31, '20191124105206', 10000),
(32, '20191124105206', 10000),
(33, '20191124105206', 10000),
(34, '20191124105206', 10000),
(35, '20191124105206', 10000),
(36, '11111', 10000000);

-- --------------------------------------------------------

--
-- Structure de la table `retour`
--

DROP TABLE IF EXISTS `retour`;
CREATE TABLE IF NOT EXISTS `retour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `quantite_sortie` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_retour` date NOT NULL,
  `quantite_retourner` int(11) NOT NULL,
  `cassure` int(11) NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ED6FD3217294869C` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `retour_article`
--

DROP TABLE IF EXISTS `retour_article`;
CREATE TABLE IF NOT EXISTS `retour_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `quantitesortie` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_retour` date NOT NULL,
  `quatite_retourner` int(11) NOT NULL,
  `cassure` int(11) NOT NULL,
  `prix` double NOT NULL,
  `reste` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F0632AEA7294869C` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `retour_article`
--

INSERT INTO `retour_article` (`id`, `article_id`, `quantitesortie`, `reference`, `date_retour`, `quatite_retourner`, `cassure`, `prix`, `reste`) VALUES
(1, 1, 6, '20191110104125', '2019-11-10', 0, 0, 0, 6);

-- --------------------------------------------------------

--
-- Structure de la table `retour_client`
--

DROP TABLE IF EXISTS `retour_client`;
CREATE TABLE IF NOT EXISTS `retour_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'STOCK'),
(2, 'COMMERCIALE'),
(3, 'CAISSE'),
(4, 'ADMIN'),
(5, 'SUPERVISEUR');

-- --------------------------------------------------------

--
-- Structure de la table `sortie_article`
--

DROP TABLE IF EXISTS `sortie_article`;
CREATE TABLE IF NOT EXISTS `sortie_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `refernce` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite_commander` int(11) NOT NULL,
  `quantite_sortie` int(11) NOT NULL,
  `date` date NOT NULL,
  `reste` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C0EA050B7294869C` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sortie_article`
--

INSERT INTO `sortie_article` (`id`, `article_id`, `refernce`, `quantite_commander`, `quantite_sortie`, `date`, `reste`) VALUES
(1, 3, '20191110071620', 200, 100, '2019-11-10', 100),
(2, 3, '20191110071620', 100, 60, '2019-11-10', 40),
(7, 3, '20191110071620', 40, 40, '2019-11-10', 0),
(8, 3, '20191110071620', 0, 0, '2019-11-10', 0),
(9, 1, '20191110100508', 200, 200, '2019-11-10', NULL),
(10, 3, '20191110100508', 200, 200, '2019-11-10', NULL),
(11, 4, '20191110104125', 120, 75, '2019-11-10', 45),
(12, 1, '20191110104125', 30, 10, '2019-11-10', 20),
(13, 5, '20191110104125', 10, 6, '2019-11-10', 4),
(14, 4, '20191110104125', 45, 45, '2019-11-10', 0),
(15, 1, '20191110104125', 20, 10, '2019-11-10', 10),
(16, 5, '20191110104125', 4, 0, '2019-11-10', 4),
(17, 4, '20191110104125', 0, 0, '2019-11-10', 0),
(18, 1, '20191110104125', 10, 6, '2019-11-10', 4),
(19, 1, '20191110104125', 4, 0, '2019-11-10', 4);

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_commande` date DEFAULT NULL,
  `date_sortie_prevue` date DEFAULT NULL,
  `date_sortie_effectif` date DEFAULT NULL,
  `date_retour_prevu` date DEFAULT NULL,
  `date_retour_effectif` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `mouvement_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `mode_id` int(11) DEFAULT NULL,
  `user_sortie_id` int(11) DEFAULT NULL,
  `user_retour_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `quantite_louer` int(11) DEFAULT NULL,
  `nb_jour` int(11) DEFAULT NULL,
  `date_de_validation_proformat` date DEFAULT NULL,
  `commentaire` longtext COLLATE utf8mb4_unicode_ci,
  `remise` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4B365660A76ED395` (`user_id`),
  KEY `IDX_4B3656607294869C` (`article_id`),
  KEY `IDX_4B365660ECD1C222` (`mouvement_id`),
  KEY `IDX_4B36566019EB6921` (`client_id`),
  KEY `IDX_4B36566077E5854A` (`mode_id`),
  KEY `IDX_4B365660CC9254B7` (`user_sortie_id`),
  KEY `IDX_4B36566028368EFB` (`user_retour_id`),
  KEY `IDX_4B36566064D218E` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `quantite`, `reference`, `date_commande`, `date_sortie_prevue`, `date_sortie_effectif`, `date_retour_prevu`, `date_retour_effectif`, `user_id`, `article_id`, `mouvement_id`, `client_id`, `mode_id`, `user_sortie_id`, `user_retour_id`, `location_id`, `quantite_louer`, `nb_jour`, `date_de_validation_proformat`, `commentaire`, `remise`) VALUES
(2, 12, '20191031191436', '2019-10-31', '2018-01-01', '2019-11-01', '2018-02-01', NULL, 1, 1, 1, 1, 3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 12, '20191031194030', '2019-10-31', '2014-04-01', '2019-11-01', '2017-04-04', '2019-11-01', 1, 1, 3, 1, 2, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 12, '20191031194030', '2019-10-31', '2014-04-01', '2019-11-01', '2017-04-04', '2019-11-01', 1, 1, 3, 1, 2, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 12, '20191031194030', '2019-10-31', '2014-04-01', '2019-11-01', '2017-04-04', '2019-11-01', 1, 1, 3, 1, 2, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, '20191102164517', '2019-11-02', '2019-11-02', '2019-11-03', '2019-11-05', NULL, 1, 1, 1, 1, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 24, '20191103064705', '2019-11-03', NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 2, '20191103090930', '2019-11-03', '2019-11-07', '2019-11-17', '2019-11-11', NULL, 1, 2, 1, 1, 3, 1, NULL, NULL, NULL, NULL, '2019-11-09', NULL, NULL),
(9, 60, '20191109072536', '2019-11-09', '2020-01-01', '2019-11-09', '2020-01-04', NULL, 1, 1, 1, 1, 2, 1, NULL, NULL, NULL, 4, NULL, NULL, NULL),
(10, 2, '20191109081409', '2019-11-09', '2019-11-10', '2019-11-17', '2019-11-15', NULL, 1, 2, 1, 1, 3, 1, NULL, NULL, NULL, 5, NULL, NULL, NULL),
(11, 30, '20191109102021', '2019-11-09', '2019-11-09', '2019-11-17', '2019-11-12', NULL, 1, 1, 1, 1, 3, 1, NULL, NULL, NULL, 3, NULL, NULL, NULL),
(12, 600, '20191109102516', '2019-11-09', NULL, NULL, NULL, NULL, 1, 3, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 100, '20191109102636', '2019-11-09', '2019-11-12', '2019-11-24', '2019-11-16', NULL, 1, 3, 1, 2, 2, 1, NULL, NULL, NULL, 4, NULL, NULL, NULL),
(14, 200, '20191110071620', '2019-11-10', '2019-11-11', '2019-11-17', '2019-11-13', NULL, 1, 3, 1, 2, 2, 1, NULL, NULL, NULL, 3, NULL, NULL, NULL),
(15, 200, '20191110100508', '2019-11-10', '2019-11-16', '2019-11-24', '2019-11-20', NULL, 1, 1, 1, 2, 2, 1, NULL, NULL, NULL, 4, '2019-11-10', NULL, NULL),
(16, 200, '20191110100508', '2019-11-10', '2019-11-16', '2019-11-24', '2019-11-20', NULL, 1, 3, 1, 2, 2, 1, NULL, NULL, NULL, 4, '2019-11-10', NULL, NULL),
(17, 300, '20191110103731', '2019-11-10', NULL, NULL, NULL, NULL, 1, 4, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 150, '20191110103731', '2019-11-10', NULL, NULL, NULL, NULL, 1, 5, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 120, '20191110103939', '2019-11-10', '2019-11-18', '2019-11-24', '2019-11-23', NULL, 1, 4, 1, 3, 2, 1, NULL, NULL, NULL, 5, NULL, NULL, NULL),
(20, 120, '20191110104125', '2019-11-10', '2019-11-21', NULL, '2019-11-26', NULL, 1, 4, 1, 3, 1, NULL, NULL, NULL, NULL, 5, '2019-11-10', NULL, NULL),
(21, 30, '20191110104125', '2019-11-10', '2019-11-21', NULL, '2019-11-26', NULL, 1, 1, 1, 3, 1, NULL, NULL, NULL, NULL, 5, '2019-11-10', NULL, NULL),
(22, 10, '20191110104125', '2019-11-10', '2019-11-21', NULL, '2019-11-26', NULL, 1, 5, 1, 3, 1, NULL, NULL, NULL, NULL, 5, '2019-11-10', NULL, NULL),
(23, 450, '20191124095738', '2019-11-24', NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 600, '20191124095940', '2019-11-24', NULL, NULL, NULL, NULL, 1, 6, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 400, '20191124100118', '2019-11-24', NULL, NULL, NULL, NULL, 1, 6, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 100, '20191124100334', '2019-11-24', '2019-12-06', '2019-11-24', '2019-12-11', NULL, 1, 6, 1, 4, 2, 1, NULL, NULL, NULL, 5, '2019-11-24', NULL, 4000),
(27, 100, '20191124100334', '2019-11-24', '2019-12-06', '2019-11-24', '2019-12-11', NULL, 1, 1, 1, 4, 2, 1, NULL, NULL, NULL, 5, '2019-11-24', NULL, NULL),
(28, 600, '20191124103103', '2019-11-24', NULL, NULL, NULL, NULL, 1, 3, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 65, '20191124103103', '2019-11-24', NULL, NULL, NULL, NULL, 1, 5, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 800, '20191124103250', '2019-11-24', NULL, NULL, NULL, NULL, 1, 7, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 400, '20191124103529', '2019-11-24', NULL, NULL, NULL, NULL, 1, 7, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 200, '20191124103616', '2019-11-24', '2019-12-08', '2019-11-24', '2019-12-13', NULL, 1, 7, 1, 2, 2, 1, NULL, NULL, NULL, 5, '2019-11-24', NULL, 30000),
(33, 100, '20191124104616', '2019-11-24', '2019-12-14', '2019-11-24', '2019-12-18', NULL, 1, 7, 1, 4, 2, 1, NULL, NULL, NULL, 4, '2019-11-24', NULL, 50000),
(34, 100, '20191124105206', '2019-11-24', '2019-11-24', '2019-11-24', '2019-11-28', NULL, 1, 7, 1, 3, 2, 1, NULL, NULL, NULL, NULL, '2019-11-24', NULL, 50000),
(35, 600, '20191124110011', '2019-11-24', NULL, NULL, NULL, NULL, 1, 8, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 600, '20191124110102', '2019-11-24', NULL, NULL, NULL, NULL, 1, 8, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 400, '20191124110232', '2019-11-24', '2019-11-24', '2019-11-24', '2019-11-24', NULL, 1, 8, 1, 5, 2, 1, NULL, NULL, NULL, 1, '2019-11-24', NULL, 20000),
(38, 400, '20191124123131', '2019-11-24', NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 400, '20191124123752', '2019-11-24', '2019-11-25', NULL, '2019-11-27', NULL, 1, 1, 1, 2, 1, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL),
(40, 10, '20191124124728', '2019-11-24', '2019-11-24', NULL, '2019-11-27', NULL, 1, 2, 1, 1, 1, NULL, NULL, NULL, NULL, 4, '2019-11-24', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `taux_refacturation`
--

DROP TABLE IF EXISTS `taux_refacturation`;
CREATE TABLE IF NOT EXISTS `taux_refacturation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taux` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transport`
--

DROP TABLE IF EXISTS `transport`;
CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transport`
--

INSERT INTO `transport` (`id`, `reference`, `prix`) VALUES
(1, '20191106161213', 20000),
(2, '20191106161331', 20000),
(3, '20191106161342', 20000),
(4, '20191106161824', 20000),
(5, '20191106162725', 20000),
(6, '20191103090930', 20000),
(7, '11111', 10000);

-- --------------------------------------------------------

--
-- Structure de la table `tva`
--

DROP TABLE IF EXISTS `tva`;
CREATE TABLE IF NOT EXISTS `tva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tva` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tva`
--

INSERT INTO `tva` (`id`, `tva`) VALUES
(1, 20);

-- --------------------------------------------------------

--
-- Structure de la table `type_client`
--

DROP TABLE IF EXISTS `type_client`;
CREATE TABLE IF NOT EXISTS `type_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_client`
--

INSERT INTO `type_client` (`id`, `type`) VALUES
(1, 'particulier'),
(2, 'entreprise'),
(3, 'Sans facture');

-- --------------------------------------------------------

--
-- Structure de la table `type_payement`
--

DROP TABLE IF EXISTS `type_payement`;
CREATE TABLE IF NOT EXISTS `type_payement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_payement`
--

INSERT INTO `type_payement` (`id`, `type`) VALUES
(1, 'cheque'),
(2, 'caisse'),
(3, 'mobile money');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'admin', '[\"ROLE_SUPER_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$dHh3bldXejV3bEFFZGM0Rw$IRKoS0uUzxmHE+Nl1y+SMVX1wN8d2f/W22bSsBHRF1E'),
(2, 'qqqqqqqqqq', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$M21qaEw3VFhsUzlidXpDSw$RXIhYw6HHjdmGKiZ+urM8QOFiGhIGhYx343JlY/uY6g'),
(4, 'wwww', '[\"ROLE_SUPERVISEUR\"]', '$argon2i$v=19$m=65536,t=4,p=1$UzBiOFhCVUI1OS80MXM0Zw$bV7U2OYfNSXPzllwn0mG10s+j1Y7UFHyr4t1hPEYLz0');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1D1C63B3DCD6110` (`stock_id`),
  KEY `IDX_1D1C63B3D60322AC` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `login`, `password`, `nom`, `prenom`, `stock_id`, `role_id`) VALUES
(1, 'prima-event', 'prima-event', 'prima', 'event', NULL, NULL),
(2, 'admin', 'argoni2', 'prima', 'prima', NULL, NULL),
(3, 'qqqqqqqqqq', 'argoni2', 'qqqqqqqqqq', 'qqqqqqqqqq', NULL, NULL),
(5, 'wwww', 'argoni2', 'wwww', 'wwww', NULL, 5);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66DCD6110` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_C7440455AD2D2831` FOREIGN KEY (`type_client_id`) REFERENCES `type_client` (`id`),
  ADD CONSTRAINT `FK_C7440455DCD6110` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`);

--
-- Contraintes pour la table `mouvement`
--
ALTER TABLE `mouvement`
  ADD CONSTRAINT `FK_5B51FC3EDCD6110` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`);

--
-- Contraintes pour la table `paye`
--
ALTER TABLE `paye`
  ADD CONSTRAINT `FK_C04B89FF868C0609` FOREIGN KEY (`payement_id`) REFERENCES `payement` (`id`),
  ADD CONSTRAINT `FK_C04B89FFBC4657A1` FOREIGN KEY (`motif_payement_id`) REFERENCES `motif_payement` (`id`),
  ADD CONSTRAINT `FK_C04B89FFCD95D198` FOREIGN KEY (`type_payement_id`) REFERENCES `type_payement` (`id`),
  ADD CONSTRAINT `FK_C04B89FFF8C42054` FOREIGN KEY (`typepayement_id`) REFERENCES `type_payement` (`id`);

--
-- Contraintes pour la table `payement`
--
ALTER TABLE `payement`
  ADD CONSTRAINT `FK_B20A7885D3964A07` FOREIGN KEY (`paye_id`) REFERENCES `paye` (`id`);

--
-- Contraintes pour la table `privilege`
--
ALTER TABLE `privilege`
  ADD CONSTRAINT `FK_87209A8719EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `retour`
--
ALTER TABLE `retour`
  ADD CONSTRAINT `FK_ED6FD3217294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

--
-- Contraintes pour la table `retour_article`
--
ALTER TABLE `retour_article`
  ADD CONSTRAINT `FK_F0632AEA7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

--
-- Contraintes pour la table `sortie_article`
--
ALTER TABLE `sortie_article`
  ADD CONSTRAINT `FK_C0EA050B7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `FK_4B36566019EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_4B36566028368EFB` FOREIGN KEY (`user_retour_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_4B36566064D218E` FOREIGN KEY (`location_id`) REFERENCES `fournisseur` (`id`),
  ADD CONSTRAINT `FK_4B3656607294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `FK_4B36566077E5854A` FOREIGN KEY (`mode_id`) REFERENCES `mode` (`id`),
  ADD CONSTRAINT `FK_4B365660A76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_4B365660CC9254B7` FOREIGN KEY (`user_sortie_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_4B365660ECD1C222` FOREIGN KEY (`mouvement_id`) REFERENCES `mouvement` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_1D1C63B3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `FK_1D1C63B3DCD6110` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
