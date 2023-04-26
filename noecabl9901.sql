-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 26 avr. 2023 à 13:39
-- Version du serveur : 10.5.18-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `noecabl9901`
--

-- --------------------------------------------------------

--
-- Structure de la table `attribution`
--

CREATE TABLE `attribution` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `attribution`
--

INSERT INTO `attribution` (`id`, `game_id`, `user_id`) VALUES
(1, 37, 2),
(2, 39, 2),
(3, 40, 2),
(4, 45, 2),
(5, 39, 3),
(6, 41, 3),
(7, 95, 3),
(8, 38, 4),
(9, 45, 4),
(10, 38, 5),
(11, 38, 6),
(12, 40, 7),
(13, 42, 7),
(14, 40, 8),
(15, 45, 8),
(16, 43, 11),
(17, 42, 12);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL
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
(1, 47),
(1, 53),
(1, 76),
(1, 77),
(1, 78),
(1, 105),
(1, 108),
(1, 114),
(2, 52),
(2, 56),
(2, 95),
(2, 96),
(2, 97),
(2, 98),
(2, 99),
(2, 100),
(2, 101),
(2, 102),
(2, 103),
(2, 104),
(3, 42),
(3, 54),
(3, 66),
(3, 72),
(3, 84),
(3, 85),
(3, 86),
(3, 87),
(3, 88),
(3, 89),
(3, 90),
(3, 91),
(3, 92),
(3, 93),
(3, 94),
(3, 106),
(3, 107),
(4, 55),
(4, 79),
(4, 80),
(4, 81),
(4, 82);

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `nb_copies` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`id`, `name`, `slug`, `description`, `image`, `nb_copies`) VALUES
(42, 'Arbre à boules', 'arbre-boules', 'Arbre à boules', 'arbre_a_boules.png', '1'),
(66, 'Boîtes encastrements', 'bo-tes-encastrements', 'Jeu d\'encastrement', 'boites encastrements.jpg', '3'),
(72, 'Lot de figurines animaux de la ferme', 'lot-de-figurines-animaux-de-la-ferme', 'lot de figurine', 'lot de figurines animaux de la ferme.jpg', '2'),
(76, 'Cubes souples OIBO', 'cubes-souples-oibo', 'Exploration tactile unique ! Ces petits accessoires communément appelés « fidgets » sont d’excellents moyens de canaliser l’attention. Ils ont un effet positif dans l’aide à la concentration d’enfants ou d’adultes souffrant de TDAH (troubles déficitaires de l’attention avec ou sans hyperactivité) ou TSA (troubles du spectre de l’autisme). Ce figdet est un jouet sensoriel élastique, empilable, roulable, compressible et facile à saisir pour les petites mains. Ce fidget qui combine balle et cube offre des avantages éducatifs (géométrie, construction...) tout en apprenant la coordination œil-main et la motricité fine.', 'cubes_oibo.jpg', '3'),
(77, 'Encastrement &quot;La ferme&quot;', 'encastrement-la-ferme', 'Exerce la motricité fine. Enrichir le vocabulaire. Apprentissage des formes et des couleurs.', 'encastrement_la_ferme.jpg', '3'),
(78, 'Livre en tissu', 'livre-en-tissu', 'Idéal pour les tout-petits ! Livre en tissu pour éveiller tous les sens de Bébé ! Chaque page est conçue pour développer un sens spécifique et est dotée de marque-pages indiquant le sens stimulé. un miroir, un pouêt, des textures variées, un anneau parfumé à mordiller…', 'livre_en_tissu.jpg', '3'),
(79, 'Puzzle animaux', 'puzzle-animaux', 'Puzzles représentant des animaux de grande taille, destinés aux enfants. Confectionnés avec de grandes pièces en carton épais, résistant et de grande qualité.', 'puzzle_animaux.png', '3'),
(80, 'Puzzle aliments', 'puzzle-aliments', 'Des puzzles représentant des aliments de grande taille, destinés aux enfants. Confectionnés avec de grandes pièces en carton épais, résistant et de grande qualité.', 'puzzle_aliments.jpg', '3'),
(81, 'Puzzle lapin', 'puzzle-lapin', 'Encastrement à gros boutons pour les plus petits. Visuels réels. Développe la motricité, la coordination œil-main et l\'imagination.', 'puzzle_lapin.jpg', '3'),
(82, 'Puzzle mains', 'puzzle-mains', 'Jeu d\'encastrement composé d\'une base en bois comportant les empreintes de 2 mains (paume + doigts) et des pièces correspondantes.', 'puzzle_mains.png', '3'),
(84, 'Imagier', 'imagier', 'Imagiers réalistes en lien avec l\'univers de la personne.', 'imagier.jpg', '3'),
(85, 'Balle d\'activité', 'balle-d-activit', 'Grâce à leur structure aérée, ces balles sont adaptées aux plus petites mains. Elles stimulent l\'éveil des sens par leurs formes et leurs couleurs. Très légère et très souple, Bébé peut saisir, lancer, aplatir la balle sans modifier sa forme d\'origine.', 'balle_activité.png', '3'),
(86, 'Blocs de construction', 'blocs-de-construction', 'Réalisées en plastique résistant, ces pièces offrent aux enfants la possibilité de réaliser des constructions aussi diverses qu\'originales. Ces pièces en plastique de grande taille aux formes arrondies conviennent parfaitement à la préhension des plus jeunes.', 'blocs de construction.jpg', '3'),
(87, 'Boites à encastrement', 'boites-encastrement', 'Que de précision et de patience faut-il pour empiler les cubes mais quel plaisir ensuite de les faire dégringoler ! Les cubes peuvent être regroupés et empilés en fonction de divers critères symbolisés sur les différentes faces : couleurs, formes, animaux, chiffres... Les jouets gigognes font partie des essentiels pour les bébés. Ils sont évolutifs au gré des étapes du développement psychomoteur. Multi-activités en perspective : empiler ou encastrer du plus grand au plus petit, jouer avec le sable et l\'eau grâce à leurs différents perçages ou jouer à cache-cache grâce aux ouvertures en plaçant un objet dans un gobelet et demander à l\'enfant de le retrouver !', 'boites_a_encastrement.jpg', '3'),
(88, 'Construction magnétique', 'construction-magn-tique', 'Les jeux de construction associent l\'exploration tactile et la stimulation sensorielle grâce aux pièces de différentes formes. Les pièces sont de grande taille, au toucher doux pour une préhension facile par les plus petits.', 'https://static.wesco.fr/media/catalog/product/cache/7ccc10e5a8277e9f8854785247b9d41d/5/2/52756_p_52756_p@p2@xl.jpg', '3'),
(89, 'Encastrement tactile', 'encastrement-tactile', 'Très bel encastrement pour associer les couleurs ou textures par la reconnaissance visuelle et tactile.', 'https://static.wesco.fr/media/catalog/product/cache/7ccc10e5a8277e9f8854785247b9d41d/5/6/56470_p_56470_p@p2@xl.jpg', '2'),
(90, 'Formes à visser', 'formes-visser', 'Tout en vissant les grosses pièces de bois, les enfants trient, comptent et découvrent les formes et les couleurs. Le plateau antiglisse et ses poignées en silicone facilitent sa prise en main.', 'https://static.wesco.fr/media/catalog/product/cache/7ccc10e5a8277e9f8854785247b9d41d/5/7/57536_p_57536_p@p2@xl.jpg', '3'),
(91, 'Figurines animaux de la ferme', 'figurines-animaux-de-la-ferme', 'Ces figurines animales au réalisme étonnant sont un excellent support pédagogique pour faire découvrir aux enfants de nombreux mondes animaliers : la savane, la forêt, les champs, la ferme... Des heures de plaisir assurées mais aussi de nombreuses discussions : Que mangent-ils ? Où vivent-ils ? etc.', 'https://static.wesco.fr/media/catalog/product/cache/7ccc10e5a8277e9f8854785247b9d41d/5/2/52823_p_52823_p@p2@xl.jpg', '2'),
(92, 'Figurines animaux de la savane', 'figurines-animaux-de-la-savane', 'Ces figurines animales au réalisme étonnant sont un excellent support pédagogique pour faire découvrir aux enfants de nombreux mondes animaliers : la savane, la forêt, les champs, la ferme... Des heures de plaisir assurées mais aussi de nombreuses discussions : Que mangent-ils ? Où vivent-ils ? etc.', 'https://static.wesco.fr/media/catalog/product/cache/7ccc10e5a8277e9f8854785247b9d41d/3/3/33096_p_33096_p@p2@xl.jpg', '2'),
(93, 'Perles animaux à enfiler', 'perles-animaux-enfiler', '12 grosses perles en bois à enfiler sur le thème des animaux spécialement conçues pour les 18 mois et plus. Jeu qui aide au développement de la motricité fine.', 'https://www.serpent-a-lunettes.com/6953-large_default/1504vil-perles-animaux-familiers-loisirs-creatifs-construction-science-et-nature.jpg', '3'),
(94, 'Tap Tap établi', 'tap-tap-tabli', 'Que c\'est drôle d\'encastrer des formes en tapant dessus avec un marteau ! Le jeu du tap tap favorise la relation cause à effet, développe la dextérité et l\'habileté. Simple d\'utilisation, ce jeu du marteau ne contient pas de formes spécifiques. Les tiges peuvent être encastrées dans n\'importe quel trou.', 'https://static.wesco.fr/media/catalog/product/cache/7ccc10e5a8277e9f8854785247b9d41d/5/7/57031_p_57031_p@p2@xl.jpg', '3'),
(95, 'A ce soir', 'a-ce-soir', 'Quand on passe la journée loin de l\'autre, c\'est bon de se la raconter. Mais quand on est tout petit, comme Sam, ou un peu plus grand, comme Léa, on n\'a pas encore de mots, ou si peu, pour en parler.« À ce soir ! » est un livre pour dire, avec des images, les paroles rassurantes et le gros baiser du matin, les jouets, les copains, la purée, le dodo, les disputes et les câlins, la fatigue du soir ...et la joie de se retrouver !', 'https://static.fnac-static.com/multimedia/Images/FR/NR/a5/9f/9a/10133413/1540-1/tsp20220703072731/A-ce-soir-tout-carton.jpg', '3'),
(96, 'Au revoir', 'au-revoir', 'Une série de six petits livres à regarder, à écouter et à sentir avec le tout-petit... Des livres qui racontent les bébés. Des livres qui rencontrent les bébés. Des livres qui parlent de la vie de tous les jours : les mots qui racontent les émotions partagées, les rires et les larmes...', 'https://static.fnac-static.com/multimedia/Images/FR/NR/19/15/15/1381657/1540-1/tsp20220701103715/Au-revoir.jpg', '1'),
(97, 'Bye bye les couches', 'bye-bye-les-couches', 'Ce livre va aider les jeunes enfants à comprendre pourquoi et comment utiliser un pot. Ils seront plus sûrs d\'eux pendant cet apprentissage et pourront bientôt dire : \'bye-bye les couches !\' La petite enfance est la période des sourires, des câlins mais aussi des grands apprentissages en lien avec les étapes essentielles du développement des tout-petits. Apprendre à exprimer sa colère sans mordre et sans crier, à se séparer de sa tétine ou de sa couche ou encore à ne plus mettre les doigts dans le nez génèrent souvent de la frustration chez les enfants. Ils voudraient être plus autonomes alors qu\'ils ont encore besoin d aide. La collection « Grandir dans la bienveillance » de l\'Atelier des Parents propose une série de 6 livres pour faciliter ces apprentissages à l\'aide d outils de communication qui leur permettront d\'acquérir jour après jour plus d\'autonomie et de confiance en eux. Une double page est dédiée aux parents et aux professionnels. Ils y trouveront des idées pour gérer les différentes étapes du développement des enfants.', 'https://m.media-amazon.com/images/I/61Ml5hcRq7L._SX469_BO1,204,203,200_.jpg', '1'),
(98, 'Bye bye les morsures', 'bye-bye-les-morsures', 'A l\'aide de mots simples et de jolis dessins, ce livre propose aux jeunes enfants d\'apprendre à gérer leurs émotions ou leurs poussées dentaires sans mordre les personnes. La petite enfance est la période des sourires, des câlins mais aussi des grands apprentissages en lien avec les étapes essentielles du développement des tout-petits. Apprendre à exprimer sa colère sans mordre et sans crier, à se séparer de sa tétine ou de sa couche ou encore à ne plus mettre les doigts dans le nez génèrent souvent de la frustration chez les enfants. Ils voudraient être plus autonomes alors qu\'ils ont encore besoin d\'aide. La collection « Grandir dans la bienveillance » de l\'Atelier des Parents propose une série de 6 livres pour faciliter ces apprentissages à l\'aide d\'outils de communication qui leur permettront d\'acquérir jour après jour plus d\'autonomie et de confiance en eux. Une double page est dédiée aux parents et aux professionnels. Ils y trouveront des idées pour gérer les différentes étapes du développement des enfants.', 'livres_bye_bye_les_morsures.jpg', '1'),
(99, 'Grosse colère', 'grosse-col-re', 'Robert a passé une très mauvaise journée. Il n\'est pas de bonne humeur et en plus, son papa l\'a envoyé dans sa chambre. Alors Robert sent tout à coup monter une Chose terrible. Une Chose qui peut faire de gros, gros dégâts... si on ne l\'arrête pas à temps.', 'https://static.fnac-static.com/multimedia/Images/FR/NR/33/18/12/1185843/1540-1/tsp20220701103639/Groe-colere.jpg', '3'),
(100, 'Il était un petit navire', 'il-tait-un-petit-navire', 'Il était un petit navire, il était un petit navire... Découvrez la comptine préférée des petits moussaillons dans la collection des &quot;Comptines à toucher&quot;. Écouter la comptine, regarder les images de Xavier Deneux, toucher les matières : une expérience sensorielle complète pour les bébés !  Une matière différente à chaque page et un très beau pop-up De nombreuses matières : la voile, la coque du bateau, la corde du mât, mais aussi des animations à manipuler : une sirène sur les flots, et un magnifique navire en pop-up...', 'https://static.fnac-static.com/multimedia/Images/FR/NR/71/87/28/2656113/1540-1/tsp20230113092639/Il-etait-un-petit-navire.jpg', '2'),
(101, 'Le repas', 'le-repas', 'Que font Lou et Mouf le matin ? Comment se préparent-t-ils pour aller dormir ? Est-ce que Lou est gourmand ? Que trouve-t-on dans la salle de bain ? Les petites aventures de Lou et son doudou, à se raconter au jour le jour. Quatre imagiers sans texte mettant en scène les deux héros des tout-petits et leurs premières expériences de vie pour échanger joyeusement et librement avec bébé dans toutes les langues !', 'https://static.fnac-static.com/multimedia/Images/FR/NR/ec/11/cc/13373932/1540-1/tsp20230315075934/Images-de-Lou-et-Mouf-le-repas-Les.jpg', '1'),
(102, 'Le bain de Berk', 'le-bain-de-berk', 'L\'autre jour un truc terrible est arrivé dans mon bain. J\'ai posé Berk sur le bord de la baignoire et je suis allé jouer dans ma chambre, le temps que l\'eau finisse de couler. Le problème, c\'est qu\'il a glissé, et PLOUF ! Trouillette ma tortue a paniqué : « Berk se noie ! ». Drago, Poulp et Aspiro étaient prêts à tout pour l\'aider mais qu\'est-ce que le doudou-chouchou essayait de leur dire, la bouche remplie d\'eau ?', 'https://static.fnac-static.com/multimedia/Images/FR/NR/22/38/8d/9254946/1540-1/tsp20220701104210/Bain-de-berk-Le.jpg', '2'),
(103, 'Un bébé à la maison', 'un-b-b-la-maison', 'Accueillir un bébé à la maison, c\'est un grand bouleversement pour tout le monde, même pour le bébé. Ça oblige chacun à changer un peu sa manière de vivre et d\'être ensemble. Parfois, ça ne se passe pas bien, mais finalement c\'est formidable de devenir un grand frère ou une grande soeur, même si on est à la fois très jaloux, très malheureux, très fâché et très, très content...', 'https://static.fnac-static.com/multimedia/Images/FR/NR/b4/d8/1d/1956020/1540-1/tsp20220715063229/Un-bebe-a-la-maison.jpg', '2'),
(104, 'La sieste', 'la-sieste', '\'Pourquoi je fais la sieste ? Parce que j\'ai besoin d\'un bon repos pour être au top niveau.\' C\'est le message que ce livre vous aidera à faire passer aux plus jeunes qui ont parfois de la difficulté avec la sieste. Il suffit d\'observer les très jeunes enfants pour comprendre qu\'ils sont véritablement multitâches. Ils se déplacent dans tous les sens en jouant, ils explorent, ils expérimentent et surtout ils apprennent. Lorsque vient le temps d\'arrêter une activité pour : partir faire les courses, ranger les jouets, dire « au revoir », être attentif, aller se coucher ou encore passer à table, il est difficile pour eux d\'accepter sans sourciller et de s\'y mettre aussitôt. La collection « Grandir dans la bienveillance » de l\'Atelier des Parents propose une série de 10 livres pour faciliter le quotidien des tout petits. Les outils proposés favoriseront leur coopération au moment des routines (repas, coucher, sieste, rangement…), des transitions, de l\'apprentissage du retour au calme ou de l\'attention. Ils grandiront avec plus de confiance en eux. Une double page est dédiée aux parents et aux professionnels. Ils y trouveront des idées pour gérer les différents temps de la journée.', 'https://m.media-amazon.com/images/I/61uw7E63B3L._SY462_BO1,204,203,200_.jpg', '1'),
(105, 'Malette d\'apprentissage des fermetures', 'malette-d-apprentissage-des-fermetures', 'De la taille d\'un grand livre, cette superbe sacoche contient 14 types de fermeture différents ! Boutons, lacets, boucles, fermeture éclair, clips etc... Un outil d\'entraînement très pratique pour l\'initiation à l\'habillement.', 'https://www.serpent-a-lunettes.com/18897-large_default/mallette-d-apprentissage-des-fermetures.jpg', '3'),
(106, 'Puzzle aimanté', 'puzzle-aimant', 'Tout le monde à bord! Une baguette magnétique guide les billes à travers ce labyrinthe portatif.  Toutes les méthodes sont bonnes pour jouer avec ce labyrinthe. Déplacez les billes dans le labyrinthe puis déplacez-les dans le sens inverse.', 'https://www.serpent-a-lunettes.com/6405-large_default/e1701hap-choo-choo-tracks-puzzles.jpg', '3'),
(107, 'Animaux aimantés', 'animaux-aimant-s', 'Les jeunes enfants pourront découvrir la magie du magnétisme en toute sécurité avec SmartMax et sa nouvelle collection : «My First» (Mon Tout Premier). Les formes de grandes tailles des « animaux » en deux parties sont très agréables au toucher et s’aimantent immédiatement au bâtonnet.', 'https://www.serpent-a-lunettes.com/20697-large_default/lot-de-4-animaux-magnetiques-smartmax.jpg', '3');

-- --------------------------------------------------------

--
-- Structure de la table `information`
--

CREATE TABLE `information` (
  `id` int(11) NOT NULL,
  `deadline` datetime NOT NULL,
  `phase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `information`
--

INSERT INTO `information` (`id`, `deadline`, `phase`) VALUES
(1, '2023-04-06 11:11:14', 1);

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
  `registration_date` datetime NOT NULL DEFAULT current_timestamp(),
  `admin` tinyint(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `registration_date`, `admin`) VALUES
(1, 'maxemart@etud.univ-angers.fr', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Maxence', 'Martin', '2023-03-04 11:12:02', 1),
(2, 'nicolas@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Nicolas', 'Delanoue', '2023-03-04 13:42:07', 0),
(3, 'lola@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Lola', 'Rocard', '2023-03-09 21:16:32', 0),
(4, 'florian@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Florian', 'Louveau', '2023-03-13 13:28:56', 0),
(5, 'paul@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Paul', 'Malaval', '2023-03-13 15:23:52', 0),
(6, 'malo.sabin@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Malo', 'Sabin', '2023-03-13 15:24:24', 0),
(7, 'evan@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Evan', 'Lemonier', '2023-03-14 11:32:18', 0),
(8, 'noe@gmail.com', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1', 'Noé', 'Cabaud-Bloquel', '2023-03-14 11:34:14', 0),
(9, 'elise@example.com', '3f122fd6ff97ebdcef91e2e1af20b136397fc6442af86be4ebc20114eab8fa91', 'Élise', 'Cabaud', '2023-03-15 14:25:54', 1),
(10, 'nicolas@example.com', '807a09440428c0a8aef58bd3ece32938b0d76e638119e47619756f5c2c20ff3a', 'Nicolas', 'Delanoue', '2023-03-15 14:27:52', 0),
(11, 'pro.gamer35.ps3@gmail.com', 'c89b6896bee751d14aea049f2bd6f7b19b47f3f15b76017d46242c531ed6c0da', 'lolo', 'gullien', '2023-03-17 22:39:27', 0),
(12, 'noe.cabl@gmail.com', '31f7a65e315586ac198bd798b6629ce4903d0899476d5741a9f32e2e521b6a66', 'Cabaud--Bloquel', 'Noé', '2023-04-03 10:29:55', 0);

-- --------------------------------------------------------

--
-- Structure de la table `wishes`
--

CREATE TABLE `wishes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `wishes`
--

INSERT INTO `wishes` (`id`, `user_id`, `game_id`) VALUES
(18, 2, 37),
(20, 2, 39),
(21, 3, 39),
(22, 3, 41),
(25, 4, 37),
(26, 4, 38),
(27, 4, 45),
(28, 5, 37),
(29, 5, 38),
(30, 5, 39),
(31, 6, 37),
(32, 6, 38),
(33, 6, 39),
(34, 2, 40),
(35, 7, 37),
(36, 7, 42),
(37, 7, 40),
(38, 8, 37),
(39, 8, 45),
(40, 8, 40),
(45, 2, 45),
(46, 11, 39),
(47, 11, 43),
(48, 3, 95),
(49, 12, 42);

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
-- Index pour la table `information`
--
ALTER TABLE `information`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT pour la table `information`
--
ALTER TABLE `information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `wishes`
--
ALTER TABLE `wishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
