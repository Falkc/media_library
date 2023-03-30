-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 13 mars 2023 à 14:30
-- Version du serveur :  5.7.24
-- Version de PHP : 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `test_media_library`
--

-- --------------------------------------------------------

--
-- Structure de la table `attribution`
--

CREATE TABLE `attribution` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `attribution`
--

INSERT INTO `attribution` (`id`, `game_id`, `user_id`) VALUES
(1, 37, 2),
(2, 38, 2),
(3, 39, 2),
(4, 40, 2),
(5, 41, 3),
(6, 45, 4),
(7, 37, 5),
(8, 38, 5),
(9, 39, 5),
(10, 37, 6),
(11, 38, 6),
(12, 39, 6);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `description`) VALUES
(1, 'Jeux 1er âge', 'jeux_1er_age', 'Pariatur modi nulla ad consequatur. Id animi enim quas odio. Qui consequatur dolores autem reiciendis libero. Eos sed nihil aut et.'),
(2, 'Livres', 'livres', 'Natus suscipit architecto et error sit voluptatum harum. Quia autem sit quo natus animi expedita. Dolorem quisquam ut aperiam minima.'),
(3, 'Jeux', 'jeux', 'Et reprehenderit quod dignissimos iusto a. Vel adipisci qui necessitatibus explicabo id vel. Reprehenderit velit possimus ab.'),
(4, 'Puzzle', 'puzzle', 'afagag');

-- --------------------------------------------------------

--
-- Structure de la table `category_game`
--

CREATE TABLE `category_game` (
  `category_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category_game`
--

INSERT INTO `category_game` (`category_id`, `game_id`) VALUES
(1, 37),
(1, 38),
(1, 45),
(1, 47),
(1, 53),
(2, 43),
(2, 44),
(2, 52),
(2, 56),
(3, 41),
(3, 42),
(3, 54),
(3, 65),
(3, 66),
(4, 39),
(4, 40),
(4, 55),
(4, 63);

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` int(11) NOT NULL,
  `nb_copies` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`id`, `name`, `slug`, `description`, `image`, `release_date`, `nb_copies`) VALUES
(37, 'Cubes souples OIBO 1er âge', 'cubes-souples-oibo-1e-ge', 'Jeu de construction', 'cubes_oibo.jpg', 2020, '3'),
(38, 'Encastrement 1er âge', 'encastrement-1er-ge', 'Jeu d\'encastrement', 'encastrement.png', 2020, '3'),
(39, 'Puzzle animaux', 'puzzle-animaux', 'Petits puzzles pour enfant sur le thème des animaux', 'puzzle_annimaux.png', 2020, '3'),
(40, 'Puzzle aliments', 'puzzle-aliments', 'Petits puzzles pour enfant sur le thème des aliments', 'puzzle_aliments.png', 2020, '3'),
(41, 'Abaque bois', 'abaque-bois', 'Abaque en bois ', 'abaque_bois.png', 2020, '3'),
(42, 'Arbre à boules', 'arbre-boules', 'Arbre à boules', 'arbre_a_boules.png', 2020, '1'),
(43, 'A ce soir ', 'a-ce-soir', 'Livre d\'images', 'livre_a_ce_soir.jpg', 2020, '3'),
(44, 'Au revoir', 'au-revoir', 'Livre d\'images', 'livre_au_revoir.jpg', 2020, '1'),
(45, 'Balle activité', 'balle-activit', 'Balle de jeu ', 'balle_activité.png', 2020, '3'),
(56, ' Bye bye les morsures', 'bye-bye-les-morsures', 'Livre d\'images', 'livres_bye_bye_les_morsures.jpg', 2020, '1'),
(63, 'Puzzle mains', 'puzzle-mains', 'Puzzle', 'puzzle_mains.png', 2020, '3'),
(65, 'Encastrement tactile', 'encastrement-tactile', 'Jeu d\'encastrement', 'encastrement_tactile.png', 2020, '2'),
(66, 'Boîtes encastrements', 'bo-tes-encastrements', 'Jeu d\'encastrement', 'boites encastrements.jpg', 2020, '3');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `registration_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` tinyint(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `registration_date`, `admin`) VALUES
(1, 'maxemart@etud.univ-angers.fr', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Maxence', 'Martin', '2023-03-04 11:12:02', 1),
(2, 'nicolas@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Nicolas', 'Delanoue', '2023-03-04 13:42:07', 0),
(3, 'lola@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Lola', 'Rocard', '2023-03-09 21:16:32', 0),
(4, 'florian@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Florian', 'Louveau', '2023-03-13 13:28:56', 0),
(5, 'paul@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Paul', 'Malaval', '2023-03-13 15:23:52', 0),
(6, 'malo.sabin@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Malo', 'Sabin', '2023-03-13 15:24:24', 0);

-- --------------------------------------------------------

--
-- Structure de la table `wishes`
--

CREATE TABLE `wishes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `wishes`
--

INSERT INTO `wishes` (`id`, `user_id`, `game_id`) VALUES
(18, 2, 37),
(20, 2, 39),
(21, 3, 39),
(22, 3, 41),
(24, 2, 38),
(25, 4, 37),
(26, 4, 38),
(27, 4, 45),
(28, 5, 37),
(29, 5, 38),
(30, 5, 39),
(31, 6, 37),
(32, 6, 38),
(33, 6, 39),
(34, 2, 40);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `attribution`
--
ALTER TABLE `attribution`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category_game`
--
ALTER TABLE `category_game`
  ADD PRIMARY KEY (`category_id`,`game_id`),
  ADD KEY `IDX_A8B04BCB12469DE2` (`category_id`),
  ADD KEY `IDX_A8B04BCBE48FD905` (`game_id`);

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wishes`
--
ALTER TABLE `wishes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `attribution`
--
ALTER TABLE `attribution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `wishes`
--
ALTER TABLE `wishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
