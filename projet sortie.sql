-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 13 oct. 2022 à 09:29
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetsortie`
--
CREATE DATABASE IF NOT EXISTS `projetsortie` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `projetsortie`;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221004145827', '2022-10-04 16:58:32', 11191),
('DoctrineMigrations\\Version20221006122203', '2022-10-10 09:03:09', 1053),
('DoctrineMigrations\\Version20221011121935', '2022-10-11 14:19:40', 781);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE `etat` (
  `id` int(11) NOT NULL,
  `libelle` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_etat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`, `no_etat`) VALUES
(1, 'Crée', 1),
(2, 'Ouverte', 2),
(3, 'Cloturée', 3),
(4, 'En Cours', 4),
(5, 'Terminée', 5),
(6, 'Annulée', 6),
(7, 'Annulée', 7);

-- --------------------------------------------------------

--
-- Structure de la table `histosorties`
--

CREATE TABLE `histosorties` (
  `id_histoSorties` int(10) UNSIGNED NOT NULL,
  `id_sortie` int(11) DEFAULT NULL,
  `nom_sortie` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_heure_debut` datetime DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `date_limite_inscription` datetime DEFAULT NULL,
  `nb_inscriptions_max` int(11) DEFAULT NULL,
  `infos_sortie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motif_annulation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_organisateur` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `date_inscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `date_inscription`) VALUES
(1, '1992-08-01'),
(2, '1988-08-31'),
(3, '2004-10-16'),
(4, '1999-07-18'),
(5, '2005-05-19'),
(6, '2016-05-04'),
(7, '1982-03-24'),
(8, '1990-04-12'),
(9, '2002-08-20'),
(10, '2010-09-12');

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE `lieu` (
  `id` int(11) NOT NULL,
  `ville_id` int(11) DEFAULT NULL,
  `nom_lieu` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rue` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id`, `ville_id`, `nom_lieu`, `rue`, `latitude`, `longitude`) VALUES
(1, 1, 'ENI niort', '19 Av. Léo Lagrange Bâtiment B', 31.33692163, 49281.005),
(2, 7, 'Miss Jakayla Mertz MD', 'Miss Mariane Balistreri Jr.', 17363125.385983, 598353.5922),
(3, 3, 'Brielle Morar', 'Prof. Hortense Ondricka', 724634036.834, 166157269.15),
(4, 4, 'Peyton Spencer', 'Dawn Collins', 7.139488415, 449532395.888),
(5, 8, 'Mr. Matteo Maggio PhD', 'Noble Crooks', 98.5947, 18817936.018),
(6, 2, 'Heloise Wiegand PhD', 'Amelie Armstrong', 180620016, 23701.377),
(7, 5, 'Javon Powlowski', 'Stanford Howe', 1144.0980944, 308.42761),
(8, 7, 'Audie Parker', 'Jayden Roob', 66429, 471.052879585),
(9, 9, 'Mr. Jessy Walter DDS', 'Maritza Kautzer', 23380.191, 61.2),
(10, 6, 'Prof. Franz Roob', 'Mozelle Nienow', 3.6691, 216.46),
(11, 7, 'fg', 'dd', 45.2325, 0.14664);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE `participant` (
  `id` int(11) NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL,
  `administrateur` tinyint(1) NOT NULL,
  `url_photo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant`
--

INSERT INTO `participant` (`id`, `site_id`, `email`, `roles`, `password`, `pseudo`, `nom`, `prenom`, `telephone`, `actif`, `administrateur`, `url_photo`) VALUES
(1, 1, 'admin0@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$4.wQTKq9iKLXcv9vxB.3jundL/AaWEoL00T2wLCprnXrpR0RKhqB6', 'Dillan Wisoky', 'Jayce Schroeder', 'Kale Ziemann', '689-650-7622', 1, 1, NULL),
(2, 1, 'user0@gmail.com', '[\"ROLE_USER\"]', '$2y$13$jChn4DLr6DMVSQoScmfjv.g5x3I32zDXKS7D8TZV1zppwmenmCSiW', 'Ulises Adams', 'Terry Walter IV', 'Mrs. Lurline Ledner', '+1.702.798.6490', 1, 0, NULL),
(3, 2, 'admin1@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$4LVE3nv.5OSd2ozzmRuuaOQJCZ7mz3pWVM5FPCVSf9qAzfyfA9.9a', 'Jacinthe Blick', 'Geo Reinger', 'Amara King', '1-970-559-3964', 1, 1, NULL),
(4, 2, 'user1@gmail.com', '[\"ROLE_USER\"]', '$2y$13$ArLevJaa.idVaqi55Qi0/epFnLdN8XhT7dKCnr/K/Cq6gCGk6qndC', 'Juliet Kuphal', 'Gudrun West', 'Prof. Aiyana Lebsack DVM', '432-993-7102', 1, 0, NULL),
(5, 3, 'admin2@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$h2jmLoSDSm3XbEcPeSsNW.N6ojtkRcsnGg4eyoNpXsafmoiyLU3ba', 'Prof. Conor Baumbach I', 'Miss Susan Buckridge IV', 'Sophie Murazik', '707.953.2127', 1, 1, NULL),
(6, 3, 'user2@gmail.com', '[\"ROLE_USER\"]', '$2y$13$WKOXaJ7yGz6tLGNPD4O1eupkl9NNv6Ait2Ffy854Fbf6p695ZUHLW', 'Prof. Opal Heaney', 'Mrs. Sibyl Altenwerth', 'Anthony Beer', '831.866.9707', 1, 0, NULL),
(7, 4, 'admin3@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$qgPBa6Ut/l6tdvIyK8wKVOjtrvJq/j0u8rEseDYqN0T.jXz9WG.7C', 'Brooklyn Larson PhD', 'Fabian Balistreri DDS', 'Domenick Gorczany', '1-706-918-6031', 1, 1, NULL),
(8, 4, 'user3@gmail.com', '[\"ROLE_USER\"]', '$2y$13$5B5V2BEsFp/RqBF0Vw8RZewtRYZpTGnDsEl4yt//ekXlwPIYmSi76', 'Addison Hegmann Sr.', 'Mr. Fernando Miller', 'Charlotte Marvin', '+1-312-614-6085', 1, 0, NULL),
(9, 5, 'admin4@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$QJ1CLuniryGptRThGN4KJeSqZB9lw9IyAdVq2MthPDJTFEXkU0/Iq', 'Prof. Edmund Swift', 'Mrs. Alana Hamill', 'Ms. Amalia Jakubowski', '(423) 425-6644', 1, 1, NULL),
(10, 5, 'user4@gmail.com', '[\"ROLE_USER\"]', '$2y$13$5GvVgLABpXGiVuqmFx7qOOkoHfzM7tNfcZsTEUTVW2r49uVnRNCAK', 'River Spinka', 'Mr. Conor Ratke V', 'Kristy Hamill', '+15076189442', 1, 0, NULL),
(11, 6, 'admin5@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$wFigHtMpOiZ6omx39kc8i.8vZvZVYYOMKfpFsRgCzMD2ge3BREHcm', 'Janelle Bailey', 'Iva Erdman', 'Cayla Lakin', '1-559-816-4396', 1, 1, NULL),
(12, 6, 'user5@gmail.com', '[\"ROLE_USER\"]', '$2y$13$FECH.G/mh2ZS6yEEcoOja.Td6A9B00bjq/kguT2nKMhOnJkrA.mAq', 'Monserrate Lesch DVM', 'Angelo DuBuque', 'Santos Brown', '+1 (484) 640-59', 1, 0, NULL),
(13, 7, 'admin6@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$EzBvND3.pG/7VGsM1PObReVKZtQaksHPXEKYXJhyB4WJWH.EM8KIe', 'Johnnie Koss', 'Lenora Wuckert', 'Titus Skiles', '272-416-5677', 1, 1, NULL),
(14, 7, 'user6@gmail.com', '[\"ROLE_USER\"]', '$2y$13$dRhYc3n83DZwzQKJYzDEiePfFNaBYI9t9qdCCcf66lG7xJWmBDrLO', 'Miss Liza Bergnaum', 'Aniya Kuphal', 'Dusty Kutch DDS', '+1.814.628.7300', 1, 0, NULL),
(15, 8, 'admin7@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$Dsp12yHN9.R9lX.XBPl33uCtPhdKJWDhg2BMjeIwH22mbGP4dEtgK', 'Michale Streich', 'Prof. Marquise Williamson', 'Kade Friesen', '774-499-3902', 1, 1, NULL),
(16, 8, 'user7@gmail.com', '[\"ROLE_USER\"]', '$2y$13$K3Zuwe5APBpuRxvd6Qgie.jcNOw/Rv9nyeiZWy1IHERnlnd68ef7e', 'Kris Kilback', 'Miss Euna Streich III', 'Ms. Jacynthe Heidenreich', '442.457.8745', 1, 0, NULL),
(17, 9, 'admin8@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$R/gUNqM6B9SvRG0qof8vJeejMMfew/r4om3oX/tvPJVwP.7oqCxWe', 'Mr. Bernie Wehner DVM', 'Rosendo Von', 'Sister Nikolaus', '+1 (816) 648-29', 1, 1, NULL),
(18, 9, 'user8@gmail.com', '[\"ROLE_USER\"]', '$2y$13$rKZFDQR2kXpfLQ/tO1ArLOwrvg0RT2VIfBFpO6zn2up2PdAanVSte', 'Samara McGlynn', 'Mrs. Ernestina Zboncak III', 'Prof. Columbus Ankunding', '1-619-251-6625', 1, 0, NULL),
(19, 10, 'admin9@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$p3TI/yVxk2fkPvDgim3d3uFiPE1p8LW3RpbW.H44KGyTuXZ/d3nKC', 'Dr. Mikel Weimann IV', 'Uriah Baumbach', 'Margaret Effertz', '(914) 632-5331', 1, 1, NULL),
(20, 10, 'user9@gmail.com', '[\"ROLE_USER\"]', '$2y$13$SySkbkRPdRbTvMoqQGm4vuSKbCrdKp8EPxckxd0P35slcFtZF4E0y', 'Mose Watsica III', 'Prof. Hazel Abbott', 'Dr. Delores Daniel Jr.', '469.407.3809', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `participant_sortie`
--

CREATE TABLE `participant_sortie` (
  `participant_id` int(11) NOT NULL,
  `sortie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant_sortie`
--

INSERT INTO `participant_sortie` (`participant_id`, `sortie_id`) VALUES
(4, 52),
(8, 52),
(14, 52),
(16, 52),
(18, 52);

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

CREATE TABLE `site` (
  `id` int(11) NOT NULL,
  `nom_site` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `site`
--

INSERT INTO `site` (`id`, `nom_site`) VALUES
(1, 'Campus Niort'),
(2, 'Campus Nantes'),
(3, 'Campus Rennes'),
(4, 'Campus Paris'),
(5, 'Campus Brest'),
(6, 'Campus Bordeaux'),
(7, 'Campus Nimes'),
(8, 'Campus Marseille'),
(9, 'Campus Strasbourg'),
(10, 'Campus Lille');

-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

CREATE TABLE `sortie` (
  `id` int(11) NOT NULL,
  `lieu_id` int(11) DEFAULT NULL,
  `etat_id` int(11) DEFAULT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` datetime NOT NULL,
  `duree` int(11) NOT NULL,
  `date_cloture` date NOT NULL,
  `nb_inscription_max` int(11) NOT NULL,
  `description_info` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motif` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sortie`
--

INSERT INTO `sortie` (`id`, `lieu_id`, `etat_id`, `participant_id`, `site_id`, `nom`, `date_debut`, `duree`, `date_cloture`, `nb_inscription_max`, `description_info`, `url_photo`, `motif`) VALUES
(11, 1, 3, 4, 1, 'fdd', '2022-10-05 10:21:00', 9, '2022-10-03', 5, 'yyy', '', NULL),
(28, 5, 3, 4, 5, 'sdffw', '2022-10-05 15:37:00', 11, '2022-10-03', 11, 'rtrtert', '', 'rgdfg'),
(30, 5, 5, 1, 9, 'sdf', '2022-10-06 15:40:00', 2, '2022-10-04', 2, 'fgdg', '', NULL),
(31, 6, 5, 1, 9, 'fdd', '2022-10-06 15:49:00', 45, '2022-10-15', 4545, 'ff', '', NULL),
(32, 8, 2, 1, 3, 'fgdgfdg', '2022-10-18 09:14:00', 1230, '2022-10-15', 12, 'gg', '', NULL),
(33, 2, 6, 4, 7, 'fgdgfdg', '2022-10-08 09:14:00', 1230, '2022-10-06', 12, 'gg', '', 'test'),
(34, 6, 6, 1, 4, 'fgdgfdg', '2022-10-08 09:14:00', 1230, '2022-10-06', 12, 'gg', '', NULL),
(35, 1, 3, 1, 5, 'd', '2022-10-08 09:36:00', 11, '2022-10-03', 12, '44', '', NULL),
(36, 11, 4, 1, 5, 'fdd', '2022-10-08 09:45:00', 120, '2022-10-21', 12, 'rrr', '', NULL),
(37, 2, 6, 4, 6, 'fdd', '2022-10-08 09:45:00', 120, '2022-10-21', 12, 'rrr', '', 'test'),
(38, 3, 3, 1, 3, 'fdd', '2022-10-15 09:48:00', 44, '2022-10-22', 44, 'uy', '', NULL),
(50, 6, 3, 4, 2, 'test site et etat', '2022-10-21 16:15:00', 120, '2022-10-05', 5, 'test', NULL, NULL),
(51, 4, 3, 4, 2, 'fgdgfdg', '2022-10-14 16:17:00', 30, '2022-10-04', 4, 't', NULL, NULL),
(52, 6, 2, 1, 2, 'fddrtt', '2022-10-29 11:07:00', 123, '2022-10-15', 5, '14', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t1`
--

CREATE TABLE `t1` (
  `id` int(11) DEFAULT NULL,
  `nb_ins_max` int(11) DEFAULT NULL,
  `nb_ins` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `t1`
--

INSERT INTO `t1` (`id`, `nb_ins_max`, `nb_ins`) VALUES
(52, 12, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id` int(11) NOT NULL,
  `nom_ville` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `nom_ville`, `code_postal`) VALUES
(1, 'Niort', '79000'),
(2, 'Nantes', '44000'),
(3, 'Rennes', '35000'),
(4, 'Paris', '75000'),
(5, 'Brest', '29200'),
(6, 'Bordeaux', '33000'),
(7, 'Nimes', '30000'),
(8, 'Marseille', '13000'),
(9, 'Strasbourg', '67000'),
(10, 'Lille', '59000');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `histosorties`
--
ALTER TABLE `histosorties`
  ADD PRIMARY KEY (`id_histoSorties`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2F577D59A73F0036` (`ville_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D79F6B11E7927C74` (`email`),
  ADD KEY `IDX_D79F6B11F6BD1646` (`site_id`);

--
-- Index pour la table `participant_sortie`
--
ALTER TABLE `participant_sortie`
  ADD PRIMARY KEY (`participant_id`,`sortie_id`),
  ADD KEY `IDX_8E436D739D1C3019` (`participant_id`),
  ADD KEY `IDX_8E436D73CC72D953` (`sortie_id`);

--
-- Index pour la table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3C3FD3F26AB213CC` (`lieu_id`),
  ADD KEY `IDX_3C3FD3F2D5E86FF` (`etat_id`),
  ADD KEY `IDX_3C3FD3F29D1C3019` (`participant_id`),
  ADD KEY `IDX_3C3FD3F2F6BD1646` (`site_id`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `etat`
--
ALTER TABLE `etat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `histosorties`
--
ALTER TABLE `histosorties`
  MODIFY `id_histoSorties` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `participant`
--
ALTER TABLE `participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `site`
--
ALTER TABLE `site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `sortie`
--
ALTER TABLE `sortie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD CONSTRAINT `FK_2F577D59A73F0036` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `FK_D79F6B11F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);

--
-- Contraintes pour la table `participant_sortie`
--
ALTER TABLE `participant_sortie`
  ADD CONSTRAINT `FK_8E436D739D1C3019` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8E436D73CC72D953` FOREIGN KEY (`sortie_id`) REFERENCES `sortie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sortie`
--
ALTER TABLE `sortie`
  ADD CONSTRAINT `FK_3C3FD3F26AB213CC` FOREIGN KEY (`lieu_id`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F29D1C3019` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2D5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
