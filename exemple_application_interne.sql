-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 27 août 2021 à 12:57
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `appli_interne`
--

-- --------------------------------------------------------

--
-- Structure de la table `ap_access`
--

DROP TABLE IF EXISTS `ap_access`;
CREATE TABLE IF NOT EXISTS `ap_access` (
  `id_tab` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `_view` tinyint(1) NOT NULL DEFAULT '0',
  `_add` tinyint(1) NOT NULL DEFAULT '0',
  `_edit` tinyint(1) NOT NULL DEFAULT '0',
  `_delete` tinyint(1) NOT NULL DEFAULT '0',
  KEY `id_role` (`id_role`),
  KEY `id_tab` (`id_tab`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_access_productcare_state`
--

DROP TABLE IF EXISTS `ap_access_productcare_state`;
CREATE TABLE IF NOT EXISTS `ap_access_productcare_state` (
  `id_role` int(11) NOT NULL,
  `id_productcare_state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_employee`
--

DROP TABLE IF EXISTS `ap_employee`;
CREATE TABLE IF NOT EXISTS `ap_employee` (
  `id_employee` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL,
  `notif` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `checkin` tinyint(1) NOT NULL DEFAULT '1',
  `hour_count` int(11) NOT NULL DEFAULT '0',
  `weekly_workhour` int(11) NOT NULL DEFAULT '35',
  PRIMARY KEY (`id_employee`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_holiday_request`
--

DROP TABLE IF EXISTS `ap_holiday_request`;
CREATE TABLE IF NOT EXISTS `ap_holiday_request` (
  `id_holiday_request` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_holiday_request`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_information_tab_attachment`
--

DROP TABLE IF EXISTS `ap_information_tab_attachment`;
CREATE TABLE IF NOT EXISTS `ap_information_tab_attachment` (
  `id_information_tab_attachment` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file` varchar(40) NOT NULL,
  `file_name` varchar(128) NOT NULL,
  `file_size` bigint(10) UNSIGNED NOT NULL DEFAULT '0',
  `mime` varchar(128) NOT NULL,
  `rh_actuality` tinyint(1) NOT NULL DEFAULT '0',
  `qse_actuality` tinyint(1) NOT NULL DEFAULT '0',
  `rh_mutuelle` tinyint(1) NOT NULL DEFAULT '0',
  `rh_planning` tinyint(1) NOT NULL DEFAULT '0',
  `qse_quality` tinyint(1) NOT NULL DEFAULT '0',
  `qse_security` tinyint(1) NOT NULL DEFAULT '0',
  `rh_cse` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_information_tab_attachment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_noncompliance`
--

DROP TABLE IF EXISTS `ap_noncompliance`;
CREATE TABLE IF NOT EXISTS `ap_noncompliance` (
  `id_noncompliance` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `_show` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_noncompliance`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ap_noncompliance`
--

INSERT INTO `ap_noncompliance` (`id_noncompliance`, `name`, `_show`) VALUES
(1, 'À réutiliser', 1),
(2, 'Rebus', 1),
(3, 'Dérogation', 1),
(4, 'Retour atelier', 0),
(5, 'Réparé', 0),
(6, 'Utilisé', 0);

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_bp`
--

DROP TABLE IF EXISTS `ap_productcare_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_bp` (
  `id_productcare_bp` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_employee` int(11) DEFAULT NULL,
  `id_order` int(11) NOT NULL DEFAULT '0',
  `id_invoice` varchar(200) DEFAULT NULL,
  `id_productcare_location` int(11) NOT NULL,
  `id_shop` int(11) DEFAULT '1',
  `current_state` int(11) NOT NULL,
  `customer` varchar(64) DEFAULT NULL,
  `company` varchar(64) DEFAULT NULL,
  `message` text,
  `delivery_date` datetime NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `charger` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_bp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_detail_bp`
--

DROP TABLE IF EXISTS `ap_productcare_detail_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_detail_bp` (
  `id_productcare_detail_bp` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_parent` int(10) NOT NULL,
  `id_productcare_bp` int(10) NOT NULL,
  `id_product` int(10) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `ean` varchar(55) NOT NULL,
  `position_number` int(11) DEFAULT NULL,
  `current_state` int(10) NOT NULL,
  `product_quantity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `delivery_date` date NOT NULL,
  `tracking_number` varchar(55) NOT NULL,
  `tracking_number_return` varchar(55) DEFAULT NULL,
  `is_battery` tinyint(1) NOT NULL,
  `noncompliance` int(11) DEFAULT NULL,
  `id_noncompliance_bp` int(11) DEFAULT NULL,
  `warranty` varchar(55) DEFAULT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_detail_bp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_detail_history_bp`
--

DROP TABLE IF EXISTS `ap_productcare_detail_history_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_detail_history_bp` (
  `id_productcare_history_bp` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_employee` int(10) NOT NULL,
  `id_productcare_detail_bp` int(10) NOT NULL,
  `id_productcare_detail_state_bp` int(10) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_history_bp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_detail_noncompliance_bp`
--

DROP TABLE IF EXISTS `ap_productcare_detail_noncompliance_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_detail_noncompliance_bp` (
  `id_productcare_detail_noncompliance_bp` int(11) NOT NULL,
  `id_productcare_detail_bp` int(11) DEFAULT NULL,
  `ean` varchar(55) NOT NULL,
  `id_productcare_state` int(11) DEFAULT NULL,
  `id_noncompliance` int(11) NOT NULL DEFAULT '0',
  `id_productcare_bp_old` int(11) NOT NULL,
  `id_productcare_bp_new` int(11) DEFAULT NULL,
  `product` varchar(600) DEFAULT NULL,
  `message` varchar(1200) DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_detail_noncompliance_history_bp`
--

DROP TABLE IF EXISTS `ap_productcare_detail_noncompliance_history_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_detail_noncompliance_history_bp` (
  `id_productcare_detail_noncompliance_history_bp` int(11) NOT NULL,
  `id_productcare_detail_noncompliance_bp` int(11) NOT NULL,
  `id_noncompliance` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `date_add` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_detail_state_bp`
--

DROP TABLE IF EXISTS `ap_productcare_detail_state_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_detail_state_bp` (
  `id_productcare_detail_state_bp` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `color` varchar(32) DEFAULT NULL,
  `state_order` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_productcare_detail_state_bp`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ap_productcare_detail_state_bp`
--

INSERT INTO `ap_productcare_detail_state_bp` (`id_productcare_detail_state_bp`, `color`, `state_order`, `name`) VALUES
(1, '#a3ebff', 8, 'Batterie(s) réceptionnée(s)'),
(2, '#87c6ff', 9, 'Coque(s) réceptionné(s)'),
(3, '#6e00d6', 10, 'Coque(s) à fournir'),
(4, '#e513ff', 2, 'Pack assemblé'),
(5, '#ffa10f', 5, 'A tester'),
(6, '#35ff1b', 13, 'Expédié'),
(9, '#0fb000', 12, 'A expédier '),
(10, '#00afb4', 1, 'Pack à assembler'),
(11, '#ce001a', 15, 'Pas de commande'),
(13, '#0000ff', 7, 'En attente de réception'),
(14, '#fdb700', 11, 'En attente d\'expédition'),
(16, '#a300e0', 14, 'Expédié SA'),
(19, '#200008', 16, 'Refabrication du pack'),
(20, '#c7ff04', 3, 'Pack poinçonné'),
(21, '#ffca6c', 4, 'BMS soudé'),
(22, '#fff418', 17, 'Retour atelier - Défaut'),
(23, '#31d4ff', 18, 'Commande validée'),
(24, '#ff0000', 6, 'Rupture BMS'),
(25, '#b77400', 19, 'Erreur Comande'),
(26, 'grey', 20, 'Coque assemblée');

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_history_bp`
--

DROP TABLE IF EXISTS `ap_productcare_history_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_history_bp` (
  `id_productcare_global_history_bp` int(11) NOT NULL AUTO_INCREMENT,
  `id_productcare_bp` int(11) NOT NULL,
  `id_productcare_state_bp` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_global_history_bp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_location`
--

DROP TABLE IF EXISTS `ap_productcare_location`;
CREATE TABLE IF NOT EXISTS `ap_productcare_location` (
  `id_productcare_location` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `in_use` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_productcare_location`)
) ENGINE=InnoDB AUTO_INCREMENT=337 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ap_productcare_location`
--

INSERT INTO `ap_productcare_location` (`id_productcare_location`, `name`, `active`, `in_use`) VALUES
(3, 'A1', 1, 0),
(4, 'A2', 1, 0),
(5, 'A3', 1, 0),
(6, 'A4', 1, 0),
(7, 'A5', 1, 0),
(8, 'A6', 1, 0),
(9, 'A7', 1, 0),
(10, 'B1', 1, 0),
(11, 'B2', 1, 0),
(12, 'B3', 1, 0),
(13, 'B4', 1, 0),
(14, 'B5', 1, 0),
(15, 'B6', 1, 0),
(16, 'B7', 1, 0),
(17, 'C1', 1, 0),
(18, 'C2', 1, 0),
(19, 'C3', 1, 0),
(20, 'C4', 1, 0),
(21, 'C5', 1, 0),
(22, 'C6', 1, 0),
(23, 'C7', 1, 0),
(24, 'D1', 1, 0),
(25, 'D2', 1, 0),
(26, 'D3', 1, 0),
(27, 'D4', 1, 0),
(28, 'D5', 1, 0),
(29, 'D6', 1, 0),
(30, 'D7', 1, 0),
(31, 'E1', 1, 0),
(32, 'E2', 1, 0),
(33, 'E3', 1, 0),
(34, 'E4', 1, 0),
(35, 'E5', 1, 0),
(36, 'E6', 1, 0),
(37, 'E7', 1, 0),
(38, 'F1', 1, 0),
(39, 'F2', 1, 0),
(40, 'F3', 1, 0),
(41, 'F4', 1, 0),
(42, 'F5', 1, 0),
(43, 'F6', 1, 0),
(44, 'Aucun', 1, 0),
(45, 'G1', 1, 0),
(46, 'G2', 1, 0),
(47, 'G3', 1, 0),
(48, 'G4', 1, 0),
(49, 'G5', 1, 0),
(50, 'G6', 1, 0),
(51, 'G7', 1, 0),
(52, 'F7', 1, 0),
(53, 'SAV1', 1, 0),
(54, 'SAV2', 1, 0),
(55, 'SAV3', 1, 0),
(56, 'SAV4', 1, 0),
(57, 'SAV5', 1, 0),
(58, 'SAV6', 1, 0),
(59, 'SAV7', 1, 0),
(60, 'I1', 1, 0),
(61, 'I2', 1, 0),
(62, 'I3', 1, 0),
(63, 'I4', 1, 0),
(64, 'I5', 1, 0),
(65, 'I6', 1, 0),
(66, 'J1', 1, 0),
(67, 'H1', 1, 0),
(68, 'H2', 1, 0),
(69, 'H3', 1, 0),
(70, 'H4', 1, 0),
(71, 'H5', 1, 0),
(72, 'H6', 1, 0),
(73, 'K1', 1, 0),
(74, 'K2', 1, 0),
(75, 'K3', 1, 0),
(76, 'K4', 1, 0),
(77, 'K5', 1, 0),
(78, 'K6', 1, 0),
(79, 'J2', 1, 0),
(80, 'J3', 1, 0),
(81, 'J4', 1, 0),
(82, 'J5', 1, 0),
(83, 'J6', 1, 0),
(84, 'A8', 1, 0),
(85, 'B8', 1, 0),
(86, 'C8', 1, 0),
(87, 'D8', 1, 0),
(88, 'E8', 1, 0),
(89, 'F8', 1, 0),
(90, 'G8', 1, 0),
(91, 'H7', 1, 0),
(92, 'I7', 1, 0),
(93, 'J7', 1, 0),
(94, 'K7', 1, 0),
(95, 'SAV8', 1, 0),
(96, 'Cartons', 1, 0),
(97, 'A9', 1, 0),
(98, 'A10', 1, 0),
(99, 'A11', 1, 0),
(100, 'A12', 1, 0),
(101, 'B9', 1, 0),
(102, 'B10', 1, 0),
(103, 'B11', 1, 0),
(104, 'B12', 1, 0),
(105, 'C9', 1, 0),
(106, 'C10', 1, 0),
(107, 'C11', 1, 0),
(108, 'C12', 1, 0),
(109, 'D9', 1, 0),
(110, 'D10', 1, 0),
(111, 'D11', 1, 0),
(112, 'D12', 1, 0),
(113, 'E9', 1, 0),
(114, 'E10', 1, 0),
(115, 'E11', 1, 0),
(116, 'E12', 1, 0),
(118, 'F9', 1, 0),
(119, 'F10', 1, 0),
(120, 'F11', 1, 0),
(121, 'F12', 1, 0),
(122, 'G9', 1, 0),
(123, 'G10', 1, 0),
(124, 'G11', 1, 0),
(125, 'G12', 1, 0),
(127, 'H9', 1, 0),
(128, 'H10', 1, 0),
(129, 'H11', 1, 0),
(130, 'H12', 1, 0),
(131, 'H8', 1, 0),
(132, 'I8', 1, 0),
(133, 'I9', 1, 0),
(134, 'I10', 1, 0),
(135, 'l11', 1, 0),
(136, 'I12', 1, 0),
(137, 'K8', 1, 0),
(138, 'K9', 1, 0),
(139, 'K10', 1, 0),
(140, 'K11', 1, 0),
(141, 'K12', 1, 0),
(143, 'SAV9', 1, 0),
(144, 'SAV10', 1, 0),
(145, 'SAV11', 1, 0),
(146, 'SAV12', 1, 0),
(147, 'J8', 1, 0),
(148, 'J9', 1, 0),
(149, 'J10', 1, 0),
(150, 'J11', 1, 0),
(151, 'J12', 1, 0),
(152, 'ATT1', 1, 0),
(153, 'ATT2', 1, 0),
(154, 'ATT3', 1, 0),
(155, 'ATT4', 1, 0),
(156, 'ATT5', 1, 0),
(157, 'ATT6', 1, 0),
(158, 'ATT7', 1, 0),
(159, 'ATT8', 1, 0),
(160, 'L1', 1, 0),
(161, 'L2', 1, 0),
(162, 'L3', 1, 0),
(163, 'L4', 1, 0),
(164, 'L5', 1, 0),
(165, 'L6', 1, 0),
(166, 'L7', 1, 0),
(167, 'L8', 1, 0),
(176, 'L9', 1, 0),
(178, 'L10', 1, 0),
(179, 'L11', 1, 0),
(180, 'L12', 1, 0),
(181, 'M1', 1, 0),
(182, 'M2', 1, 0),
(183, 'M3', 1, 0),
(184, 'M4', 1, 0),
(185, 'M5', 1, 0),
(186, 'M6', 1, 0),
(187, 'M7', 1, 0),
(188, 'M8', 1, 0),
(189, 'M9', 1, 0),
(190, 'M10', 1, 0),
(191, 'M11', 1, 0),
(192, 'M12', 1, 0),
(193, 'N1', 1, 0),
(194, 'N2', 1, 0),
(195, 'N3', 1, 0),
(196, 'N4', 1, 0),
(197, 'N5', 1, 0),
(198, 'N6', 1, 0),
(199, 'N7', 1, 0),
(200, 'N8', 1, 0),
(201, 'N9', 1, 0),
(202, 'N10', 1, 0),
(203, 'N11', 1, 0),
(204, 'O1', 1, 0),
(205, 'O2', 1, 0),
(206, 'O3', 1, 0),
(207, 'O4', 1, 0),
(208, 'O5', 1, 0),
(209, 'O6', 1, 0),
(210, 'O7', 1, 0),
(211, 'O8', 1, 0),
(212, 'O9', 1, 0),
(213, 'O10', 1, 0),
(214, 'O11', 1, 0),
(215, 'P1', 1, 0),
(216, 'N12', 1, 0),
(217, 'O12', 1, 0),
(218, 'P2', 1, 0),
(219, 'P3', 1, 0),
(220, 'P4', 1, 0),
(221, 'P5', 1, 0),
(222, 'P6', 1, 0),
(223, 'P7', 1, 0),
(224, 'P8', 1, 0),
(225, 'P9', 1, 0),
(226, 'P10', 1, 0),
(227, 'P11', 1, 0),
(228, 'P12', 1, 0),
(229, 'Q1', 1, 0),
(230, 'Q2', 1, 0),
(231, 'Q3', 1, 0),
(232, 'Q4', 1, 0),
(233, 'Q5', 1, 0),
(234, 'Q6', 1, 0),
(235, 'Q7', 1, 0),
(236, 'Q8', 1, 0),
(237, 'Q9', 1, 0),
(238, 'Q10', 1, 0),
(239, 'Q11', 1, 0),
(240, 'Q12', 1, 0),
(241, 'R1', 1, 0),
(242, 'R2', 1, 0),
(243, 'R3', 1, 0),
(244, 'R4', 1, 0),
(245, 'R5', 1, 0),
(246, 'R6', 1, 0),
(247, 'R7', 1, 0),
(248, 'R8', 1, 0),
(249, 'R9', 1, 0),
(250, 'R10', 1, 0),
(251, 'R11', 1, 0),
(252, 'R12', 1, 0),
(253, 'T1', 1, 0),
(254, 'T2', 1, 0),
(255, 'T3', 1, 0),
(256, 'T4', 1, 0),
(257, 'T5', 1, 0),
(258, 'T6', 1, 0),
(259, 'T7', 1, 0),
(260, 'T8', 1, 0),
(261, 'T9', 1, 0),
(262, 'T10', 1, 0),
(263, 'T11', 1, 0),
(264, 'T12', 1, 0),
(265, 'U1', 1, 0),
(266, 'U2', 1, 0),
(267, 'U3', 1, 0),
(268, 'U4', 1, 0),
(269, 'U5', 1, 0),
(270, 'U6', 1, 0),
(271, 'U7', 1, 0),
(272, 'U8', 1, 0),
(273, 'U9', 1, 0),
(274, 'U10', 1, 0),
(275, 'U11', 1, 0),
(276, 'U12', 1, 0),
(277, 'V1', 1, 0),
(278, 'V2', 1, 0),
(279, 'V3', 1, 0),
(280, 'V4', 1, 0),
(281, 'V5', 1, 0),
(282, 'V6', 1, 0),
(283, 'V7', 1, 0),
(284, 'V8', 1, 0),
(285, 'V9', 1, 0),
(286, 'V10', 1, 0),
(287, 'V11', 1, 0),
(288, 'V12', 1, 0),
(289, 'W1', 1, 0),
(290, 'W2', 1, 0),
(291, 'W3', 1, 0),
(292, 'W4', 1, 0),
(293, 'W5', 1, 0),
(294, 'W6', 1, 0),
(295, 'W7', 1, 0),
(296, 'W8', 1, 0),
(297, 'W9', 1, 0),
(298, 'W10', 1, 0),
(299, 'W11', 1, 0),
(300, 'W12', 1, 0),
(301, 'X1', 1, 0),
(302, 'X2', 1, 0),
(303, 'X3', 1, 0),
(304, 'X4', 1, 0),
(305, 'X5', 1, 0),
(306, 'X6', 1, 0),
(307, 'X7', 1, 0),
(308, 'X8', 1, 0),
(309, 'X9', 1, 0),
(310, 'X10', 1, 0),
(311, 'X11', 1, 0),
(312, 'X12', 1, 0),
(313, 'Y1', 1, 0),
(314, 'Y2', 1, 0),
(315, 'Y3', 1, 0),
(316, 'Y4', 1, 0),
(317, 'Y5', 1, 0),
(318, 'Y6', 1, 0),
(319, 'Y7', 1, 0),
(320, 'Y8', 1, 0),
(321, 'Y9', 1, 0),
(322, 'Y10', 1, 0),
(323, 'Y11', 1, 0),
(324, 'Y12', 1, 0),
(325, 'S1', 1, 0),
(326, 'S2', 1, 0),
(327, 'S3', 1, 0),
(328, 'S4', 1, 0),
(329, 'S5', 1, 0),
(330, 'S6', 1, 0),
(331, 'S7', 1, 0),
(332, 'S8', 1, 0),
(333, 'S9', 1, 0),
(334, 'S10', 1, 0),
(335, 'S11', 1, 0),
(336, 'S12', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_location_history`
--

DROP TABLE IF EXISTS `ap_productcare_location_history`;
CREATE TABLE IF NOT EXISTS `ap_productcare_location_history` (
  `id_productcare_location_history` int(11) NOT NULL AUTO_INCREMENT,
  `id_productcare_location` int(11) NOT NULL,
  `id_productcare` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_location_history`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_notification_history`
--

DROP TABLE IF EXISTS `ap_productcare_notification_history`;
CREATE TABLE IF NOT EXISTS `ap_productcare_notification_history` (
  `id_productcare_notification_history` int(11) NOT NULL AUTO_INCREMENT,
  `id_productcare` int(11) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `id_employee_target` int(11) NOT NULL,
  `notification` text NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_notification_history`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav`
--

DROP TABLE IF EXISTS `ap_productcare_sav`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav` (
  `id_productcare_sav` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_productcare_sav_old` int(11) DEFAULT NULL,
  `id_shop` int(10) NOT NULL,
  `id_order` int(10) DEFAULT NULL,
  `reference` text,
  `current_state` int(10) DEFAULT NULL,
  `customer` varchar(64) DEFAULT NULL,
  `company` varchar(64) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `message` text,
  `id_sav_location` int(10) DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `warranty` int(11) NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  `delivery_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_productcare_sav`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_bp`
--

DROP TABLE IF EXISTS `ap_productcare_sav_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_bp` (
  `id_productcare_sav_bp` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_productcare_sav_bp_old` int(11) DEFAULT NULL,
  `id_shop` int(10) NOT NULL,
  `id_order` int(10) DEFAULT NULL,
  `reference` text,
  `current_state` int(10) DEFAULT NULL,
  `customer` varchar(64) DEFAULT NULL,
  `company` varchar(64) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `message` text,
  `id_sav_location` int(10) DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `warranty` int(11) NOT NULL DEFAULT '0',
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  `delivery_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_productcare_sav_bp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_detail_bp`
--

DROP TABLE IF EXISTS `ap_productcare_sav_detail_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_detail_bp` (
  `id_productcare_sav_bp_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_productcare_sav_bp` int(10) NOT NULL,
  `ean` varchar(55) DEFAULT NULL,
  `id_product_bp` int(10) DEFAULT NULL,
  `id_sav_reclamation_bp` int(10) NOT NULL,
  `id_sav_solution_bp` int(10) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `current_state` int(10) NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `date_add` datetime NOT NULL,
  `date_upd` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_sav_bp_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_detail_history_bp`
--

DROP TABLE IF EXISTS `ap_productcare_sav_detail_history_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_detail_history_bp` (
  `id_productcare_sav_detail_history_bp` int(11) NOT NULL AUTO_INCREMENT,
  `id_employee` int(11) NOT NULL,
  `id_productcare_sav_detail_bp` int(11) NOT NULL,
  `id_productcare_sav_detail_state_bp` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_sav_detail_history_bp`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ap_productcare_sav_detail_history_bp`
--

INSERT INTO `ap_productcare_sav_detail_history_bp` (`id_productcare_sav_detail_history_bp`, `id_employee`, `id_productcare_sav_detail_bp`, `id_productcare_sav_detail_state_bp`, `date_add`) VALUES
(1, 44, 13, 2, '2021-05-20 15:49:49'),
(2, 44, 13, 1, '2021-05-20 15:52:43'),
(3, 44, 17, 2, '2021-05-20 16:16:16'),
(4, 44, 19, 1, '2021-05-20 16:54:04'),
(5, 44, 20, 1, '2021-05-20 17:00:29'),
(6, 44, 21, 1, '2021-05-20 17:03:47'),
(7, 44, 22, 1, '2021-05-21 09:51:15'),
(8, 44, 21, 2, '2021-05-21 11:03:25'),
(9, 44, 23, 1, '2021-05-21 11:33:10'),
(10, 44, 21, 3, '2021-05-21 14:28:17'),
(11, 44, 24, 2, '2021-05-21 14:46:51'),
(12, 44, 21, 10, '2021-06-07 17:02:32'),
(13, 44, 24, 10, '2021-06-07 17:04:05'),
(14, 44, 21, 1, '2021-06-07 17:10:56'),
(15, 44, 21, 10, '2021-06-07 17:12:00'),
(16, 44, 21, 2, '2021-06-07 17:27:19'),
(17, 44, 21, 10, '2021-06-07 17:28:10'),
(18, 44, 21, 1, '2021-06-07 17:29:32'),
(19, 44, 21, 10, '2021-06-07 17:29:51'),
(20, 44, 20, 10, '2021-06-07 18:10:02'),
(21, 44, 20, 1, '2021-06-07 18:10:42'),
(22, 44, 20, 10, '2021-06-08 10:27:37'),
(23, 44, 20, 1, '2021-06-08 10:29:09'),
(24, 44, 20, 10, '2021-06-08 10:29:20'),
(25, 44, 20, 1, '2021-06-08 10:30:13'),
(26, 44, 20, 10, '2021-06-08 10:30:25'),
(27, 44, 25, 1, '2021-07-06 16:45:26');

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_detail_reclamation_history_bp`
--

DROP TABLE IF EXISTS `ap_productcare_sav_detail_reclamation_history_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_detail_reclamation_history_bp` (
  `id_productcare_sav_detail_reclamation_history_bp` int(11) NOT NULL AUTO_INCREMENT,
  `id_employee` int(11) NOT NULL,
  `id_productcare_sav_detail_bp` int(11) NOT NULL,
  `id_sav_reclamation_bp` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_sav_detail_reclamation_history_bp`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ap_productcare_sav_detail_reclamation_history_bp`
--

INSERT INTO `ap_productcare_sav_detail_reclamation_history_bp` (`id_productcare_sav_detail_reclamation_history_bp`, `id_employee`, `id_productcare_sav_detail_bp`, `id_sav_reclamation_bp`, `date_add`) VALUES
(1, 44, 21, 3, '2021-05-21 11:03:03'),
(2, 44, 20, 3, '2021-05-21 11:32:50'),
(3, 44, 23, 4, '2021-05-21 11:36:54'),
(4, 44, 20, 4, '2021-05-21 11:40:58'),
(5, 44, 21, 4, '2021-05-21 14:17:46');

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_detail_slution_history_bp`
--

DROP TABLE IF EXISTS `ap_productcare_sav_detail_slution_history_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_detail_slution_history_bp` (
  `id_productcare_sav_detail_solution_history` int(11) NOT NULL AUTO_INCREMENT,
  `id_employee` int(11) NOT NULL,
  `id_productcare_sav_detail` int(11) NOT NULL,
  `id_sav_solution` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_sav_detail_solution_history`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_detail_solution_history_bp`
--

DROP TABLE IF EXISTS `ap_productcare_sav_detail_solution_history_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_detail_solution_history_bp` (
  `id_productcare_sav_detail_solution_history` int(11) NOT NULL AUTO_INCREMENT,
  `id_employee` int(11) NOT NULL,
  `id_productcare_sav_detail` int(11) NOT NULL,
  `id_sav_solution` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_productcare_sav_detail_solution_history`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_detail_state_bp`
--

DROP TABLE IF EXISTS `ap_productcare_sav_detail_state_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_detail_state_bp` (
  `id_productcare_sav_detail_state_bp` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(32) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '1',
  `state_order` int(11) NOT NULL,
  PRIMARY KEY (`id_productcare_sav_detail_state_bp`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ap_productcare_sav_detail_state_bp`
--

INSERT INTO `ap_productcare_sav_detail_state_bp` (`id_productcare_sav_detail_state_bp`, `name`, `color`, `archived`, `state_order`) VALUES
(1, 'En attente de réception', '#0000ff', 0, 1),
(2, 'Batterie(s) réceptionnée(s)', '#a3ebff', 0, 2),
(3, 'En cours de traitement', '#e5d0ff', 0, 3),
(4, 'En charge', '#b17b00', 0, 4),
(5, 'A tester', '#ffa10f', 0, 6),
(6, 'En attente', '#ff6851', 0, 7),
(7, 'SAV Traité', '#d8ff2c', 0, 8),
(8, 'Expédié', '#35ff1b', 0, 9),
(9, 'Rééquilibrage', '#cdfffa', 0, 5),
(10, 'Refabrication du pack', '#000000', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_reclamation_bp`
--

DROP TABLE IF EXISTS `ap_productcare_sav_reclamation_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_reclamation_bp` (
  `id_sav_reclamation_bp` int(10) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `active` int(10) NOT NULL DEFAULT '1',
  `default_reclamation` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ap_productcare_sav_reclamation_bp`
--

INSERT INTO `ap_productcare_sav_reclamation_bp` (`id_sav_reclamation_bp`, `position`, `name`, `active`, `default_reclamation`) VALUES
(1, 0, 'Non défini', 1, 1),
(2, 0, 'Batterie ne fonctionne pas', 1, 0),
(3, 0, 'Vélo ne s’allume pas', 1, 0),
(4, 0, 'Perte d’assistance', 1, 0),
(5, 0, 'Perte de puissance', 1, 0),
(6, 0, 'Problème d’autonomie', 1, 0),
(7, 0, 'Problème de communication', 1, 0),
(8, 0, 'Message d’erreur', 1, 0),
(9, 0, 'Batterie non calée', 1, 0),
(10, 0, 'Batterie tombée', 1, 0),
(11, 0, 'Inversement de polarité', 1, 0),
(12, 0, 'Problème de charge', 1, 0),
(13, 0, 'Problème de chargeur', 1, 0),
(14, 0, 'Problème de barillet', 1, 0),
(15, 0, 'Interrupteur', 1, 0),
(16, 0, 'Coupure batterie', 1, 0),
(17, 0, 'Autre', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_solution_bp`
--

DROP TABLE IF EXISTS `ap_productcare_sav_solution_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_solution_bp` (
  `id_sav_solution_bp` int(10) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `active` int(10) NOT NULL DEFAULT '1',
  `default_solution` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ap_productcare_sav_solution_bp`
--

INSERT INTO `ap_productcare_sav_solution_bp` (`id_sav_solution_bp`, `position`, `name`, `active`, `default_solution`) VALUES
(1, 0, 'Non défini', 1, 1),
(2, 0, 'Remplacement carte BMS', 1, 0),
(3, 0, 'Remplacement carte de Nico', 1, 0),
(4, 0, 'Fusible de charge', 1, 0),
(5, 0, 'Fusible de décharge', 1, 0),
(6, 0, 'Câblage', 1, 0),
(7, 0, 'Batterie endommagée', 1, 0),
(8, 0, 'Batterie endommagée, bricolage client', 1, 0),
(9, 0, 'Batterie endommagée, a pris l’eau', 1, 0),
(10, 0, 'Chargeur', 1, 0),
(11, 0, 'RAS', 1, 0),
(12, 0, 'Changement de barillet', 1, 0),
(13, 0, 'Plusieurs solutions', 1, 0),
(14, 0, 'Autres', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_sav_state`
--

DROP TABLE IF EXISTS `ap_productcare_sav_state`;
CREATE TABLE IF NOT EXISTS `ap_productcare_sav_state` (
  `id_productcare_sav_state` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_productcare_sav_state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_soft_list`
--

DROP TABLE IF EXISTS `ap_productcare_soft_list`;
CREATE TABLE IF NOT EXISTS `ap_productcare_soft_list` (
  `id_soft` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_soft`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ap_productcare_soft_list`
--

INSERT INTO `ap_productcare_soft_list` (`id_soft`, `name`, `active`) VALUES
(1, 'BH_STROMER_36V', 1),
(2, 'BH_STROMER_48V', 1),
(3, 'BIONX_24V', 1),
(4, 'BIONX_36V', 1),
(5, 'BIONX_48V', 1),
(6, 'BIONX_I2C_24V', 1),
(7, 'BIONX_I2C_36V', 1),
(8, 'BIONX_RC3_24V', 1),
(9, 'BIONX_RC3_36V', 1),
(10, 'BIONX_RC3_48V', 1),
(11, 'BIONX_RC3_48V_TEST_20MINUTES', 1),
(12, 'BIONX_REV64_24V', 1),
(13, 'BIONX_REV64_36V', 1),
(14, 'BIONX_REV64_48V', 1),
(15, 'BIONX_Universel_24V', 1),
(16, 'BIONX_Universel_36V', 1),
(17, 'BIONX_Universel_48V', 1),
(18, 'BMZ_36V_8AH', 1),
(19, 'BMZ_36V_11AH', 1),
(20, 'BMZ_36V_I4AH', 1),
(21, 'BMZ_36V_17AH', 1),
(22, 'BROSE_36V', 1),
(23, 'BROSE_36V_300s', 1),
(24, 'DECATHLON_36V', 1),
(25, 'GIANT_36V_8AH', 1),
(26, 'GIANT_36V_11AH', 1),
(27, 'GIANT_36V_I4AH', 1),
(28, 'GIANT_36V_17AH', 1),
(29, 'IMPULSE_I2C_24V', 1),
(30, 'IMPULSE_I2C_36V', 1),
(31, 'IMPULSE_I2C_48V', 1),
(32, 'PANASONIC_24V', 1),
(33, 'PANASONIC_36V', 1),
(34, 'PANASONIC_48V', 1),
(35, 'PEDEGO_36V', 1),
(36, 'PEDEGO_48V', 1),
(37, 'PEUGEOT_36V', 1),
(38, 'POLARIS_48V', 1),
(39, 'TranzX_24V_8AH', 1),
(40, 'TranzX_24V_11AH', 1),
(41, 'TranzX_24V_I4AH', 1),
(42, 'TranzX_24V_17AH', 1),
(43, 'TranzX_36V_8AH', 1),
(44, 'TranzX_36V_11AH', 1),
(45, 'TranzX_36V_I4AH', 1),
(46, 'TranzX_36V_17AH', 1),
(47, 'YAMAHA_36V_8AH', 1),
(48, 'YAMAHA_36V_11AH', 1),
(49, 'YAMAHA_36V_I4AH', 1),
(50, 'YAMAHA_36V_17AH', 1),
(51, 'YAMAHA_GIANT_36V', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_state_bp`
--

DROP TABLE IF EXISTS `ap_productcare_state_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_state_bp` (
  `id_productcare_state_bp` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `color` varchar(32) DEFAULT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id_productcare_state_bp`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ap_productcare_state_bp`
--

INSERT INTO `ap_productcare_state_bp` (`id_productcare_state_bp`, `color`, `active`, `position`) VALUES
(1, '#a3ebff', 0, 0),
(5, '#e513ff', 0, 0),
(6, '#35ff1b', 0, 0),
(8, '#3f00c4', 0, 0),
(9, '#ffa10f', 0, 0),
(10, '#B3AFAE', 0, 0),
(11, '#ffffff', 0, 0),
(13, '#ffffff', 0, 0),
(15, '#870086', 0, 0),
(19, '#ff0000', 0, 0),
(20, '#ff0000', 0, 0),
(21, '#ff0000', 0, 0),
(22, '#00980f', 0, 0),
(23, '#ffff00', 0, 0),
(24, '#B3AFAE', 0, 0),
(25, '#ff0000', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ap_productcare_state_lang_bp`
--

DROP TABLE IF EXISTS `ap_productcare_state_lang_bp`;
CREATE TABLE IF NOT EXISTS `ap_productcare_state_lang_bp` (
  `id_productcare_state_bp` int(10) UNSIGNED NOT NULL,
  `id_lang` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ap_productcare_state_lang_bp`
--

INSERT INTO `ap_productcare_state_lang_bp` (`id_productcare_state_bp`, `id_lang`, `name`) VALUES
(1, 2, 'Commande validée'),
(5, 2, 'Fabrication en cours'),
(6, 2, 'Expédié'),
(8, 2, 'Commande en attente de validation'),
(9, 2, 'A tester'),
(10, 2, 'A expédier - en attente de paiement'),
(11, 2, 'A expédier'),
(13, 2, 'En attente enlèvement client '),
(15, 2, 'Commande Remboursée'),
(19, 2, 'Rupture BMS'),
(20, 2, 'Rupture Cellule 29E'),
(21, 2, 'Rupture Cellule 35E'),
(22, 2, 'Départ Partiel'),
(23, 2, 'Fabrication Planifiée'),
(24, 2, 'Changement de chargeur non payé'),
(25, 2, 'Commande annulée');

-- --------------------------------------------------------

--
-- Structure de la table `ap_role`
--

DROP TABLE IF EXISTS `ap_role`;
CREATE TABLE IF NOT EXISTS `ap_role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_staff_checkin`
--

DROP TABLE IF EXISTS `ap_staff_checkin`;
CREATE TABLE IF NOT EXISTS `ap_staff_checkin` (
  `id_staff_checkin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_employee` int(10) NOT NULL,
  `date` date NOT NULL,
  `day` int(11) NOT NULL,
  `hour_count` int(11) NOT NULL DEFAULT '0',
  `monday_morning_start` varchar(30) DEFAULT '',
  `monday_morning_end` varchar(30) DEFAULT '',
  `monday_afternoon_start` varchar(10) DEFAULT '',
  `monday_afternoon_end` varchar(30) DEFAULT '',
  `monday` int(11) DEFAULT NULL,
  `tuesday_morning_start` varchar(30) DEFAULT '',
  `tuesday_morning_end` varchar(30) DEFAULT '',
  `tuesday_afternoon_start` varchar(10) DEFAULT '',
  `tuesday_afternoon_end` varchar(30) DEFAULT '',
  `tuesday` int(11) DEFAULT NULL,
  `wednesday_morning_start` varchar(30) DEFAULT '',
  `wednesday_morning_end` varchar(30) DEFAULT '',
  `wednesday_afternoon_start` varchar(10) DEFAULT '',
  `wednesday_afternoon_end` varchar(30) DEFAULT '',
  `wednesday` int(11) DEFAULT NULL,
  `thursday_morning_start` varchar(30) DEFAULT '',
  `thursday_morning_end` varchar(30) DEFAULT '',
  `thursday_afternoon_start` varchar(10) DEFAULT '',
  `thursday_afternoon_end` varchar(30) DEFAULT '',
  `thursday` int(11) DEFAULT NULL,
  `friday_morning_start` varchar(30) DEFAULT '',
  `friday_morning_end` varchar(30) DEFAULT '',
  `friday_afternoon_start` varchar(10) DEFAULT '',
  `friday_afternoon_end` varchar(30) DEFAULT '',
  `friday` int(11) DEFAULT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`id_staff_checkin`),
  KEY `id_employee` (`id_employee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ap_staff_checkin_justification`
--

DROP TABLE IF EXISTS `ap_staff_checkin_justification`;
CREATE TABLE IF NOT EXISTS `ap_staff_checkin_justification` (
  `id_staff_checkin_justification` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `validate_hour` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_staff_checkin_justification`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ap_staff_checkin_justification`
--

INSERT INTO `ap_staff_checkin_justification` (`id_staff_checkin_justification`, `name`, `validate_hour`) VALUES
(1, 'Formation', 1),
(2, 'Arrêt de travail -1an', 0),
(3, 'Arrêt de travail', 1),
(4, 'École', 1),
(5, 'Congés', 1),
(6, 'Férié', 1),
(7, 'Absence justifiée', 0),
(8, 'Absence injustifiée', 0),
(10, 'Congé Maternité', 0),
(11, 'Modulation', 0);

-- --------------------------------------------------------

--
-- Structure de la table `ap_tab`
--

DROP TABLE IF EXISTS `ap_tab`;
CREATE TABLE IF NOT EXISTS `ap_tab` (
  `id_tab` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_tab`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ap_access`
--
ALTER TABLE `ap_access`
  ADD CONSTRAINT `ap_access_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `ap_role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ap_access_ibfk_2` FOREIGN KEY (`id_tab`) REFERENCES `ap_tab` (`id_tab`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `ap_employee`
--
ALTER TABLE `ap_employee`
  ADD CONSTRAINT `ap_employee_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `ap_role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `ap_staff_checkin`
--
ALTER TABLE `ap_staff_checkin`
  ADD CONSTRAINT `ap_staff_checkin_ibfk_1` FOREIGN KEY (`id_employee`) REFERENCES `ap_employee` (`id_employee`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
