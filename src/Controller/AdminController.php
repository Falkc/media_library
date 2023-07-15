<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use App\Model\Entity\Wish;
use App\Model\Entity\Idtable;
use App\Model\GameRepository;
use App\Model\UserRepository;
use App\Lib\DatabaseConnection;
use App\Model\WishesRepository;
use App\Model\CategoryRepository;
use App\Model\Entity\FreeBorrowDemands;
use App\Model\FreeBorrowRepository;
use App\Model\HistoryRepository;
use App\Model\InformationRepository;

class AdminController
{
    public function addGame()
    {
        if ($_SESSION['admin'] != 1) {
            header("Location:" . SITE);
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $informationRepository = new InformationRepository();
                $gameRepository = new GameRepository();
                $categoryRepository = new CategoryRepository;
                $database = new DatabaseConnection();
                $gameRepository->connection = $database;
                $categoryRepository->connection = $database;
                $informationRepository->connection = $database;

                $phase = $informationRepository->getPhase();
                $date = new DateTime($informationRepository->getDeadLine());

                if (empty($_POST['name']) || empty($_POST['category']) || empty($_POST['nb_copies'])) {

                    $errorMsg = "Veuillez remplir tout les champs";
                } else {

                    $errorMsg = $this->checkNewGameInfo($_POST['name'], $_POST['nb_copies']);

                    if (!empty($errorMsg)) {;
                    } else {

                        if (!$gameRepository->checkNewGame($_POST['name'])) {

                            $errorMsg = "Nom de jeu déjà existant";
                        } else {
                            $uploadfile = 'Images/' . basename($_FILES['image']['name']);
                            $isUploadedFile = move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
                            if (!$isUploadedFile) {
                                $errorMsg = "L'image n'a pas pu être téléchargée";
                            } else {
                                $slug = slugify($_POST['name']);
                                $gameRepository->addGame(
                                    $_POST['name'],
                                    $slug,
                                    $_POST['description'],
                                    $_POST['nb_copies'],
                                    $_FILES['image']['name']
                                );

                                $category = $categoryRepository->checkcategory($_POST['category']);
                                $game = $gameRepository->getGameBySlug($slug);
                                $categoryRepository->addcategorytogame($category->id, $game->id);
                                $successMsg = "Le jeu a bien été ajouté";
                            }
                        }
                    }
                }
            } else {
                $categoryRepository = new CategoryRepository;
                $informationRepository = new InformationRepository();
                $database = new DatabaseConnection();
                $informationRepository->connection = $database;
                $categoryRepository->connection = $database;

                $date = new DateTime($informationRepository->getDeadLine());
                $phase = $informationRepository->getPhase();
            }
            $categories = $categoryRepository->getCategories();

            require('View/admin/addGame.php');
        }
    }
    private function checkNewGameInfo(string $name, string $nb_copies)
    {

        if (intval($nb_copies) <= 0 || !is_numeric($nb_copies)) {
            return "Le nombre d'exemplaires n'est pas correct";
        }
        if (strlen($name) > 255) return "Le nom du jeu est trop long";

        return "";
    }
    public function deleteGame()
    {
        if ($_SESSION['admin'] != 1) {
            header("Location: /media_library ");
        } else {
            $gameRepository = new GameRepository();
            $database = new DatabaseConnection();
            $gameRepository->connection = $database;

            $game = $gameRepository->deleteGame($_GET['game_id']);
            header("Location: /media_library ");
        }
    }
    public function showwishes()
    {
        if ($_SESSION['admin'] != 1) {
            header("Location:" .  SITE);
        } else {
            $phase = managePhase(1);

            $informationRepository = new InformationRepository();
            $gameRepository = new GameRepository();
            $wishesRepository = new WishesRepository();
            $userRepositary = new UserRepository();
            $database = new DatabaseConnection();
            $informationRepository->connection = $database;
            $gameRepository->connection = $database;
            $wishesRepository->connection = $database;
            $userRepositary->connection = $database;

            $informations = $wishesRepository->getwishesforadmin();
            $game_names = $wishesRepository->getDistinctGamesFromWishes();

            $date = new DateTime($informationRepository->getDeadLine());
            $allUsers = $userRepositary->getUsers();
            $allGames = $gameRepository->getGames();
            if (empty($informations)) {
                $errorMsg = 'Aucun usager n\'a émit de voeux';
            }

            if (!isset($_SESSION['constraintTable'])) {
                $_SESSION['constraintTable'] = [];
            }


            if (isset($_POST['member']) && isset($_POST['game'])) { //ajout d'un jeu
                $error = $wishesRepository->checkNewConstraint($_POST['member'], $_POST['game']);
                if ($error == 0) {
                    $constraint = ["member" => $_POST['member'], "game" => $_POST['game']];
                    $_SESSION['constraintTable'][] = $constraint;
                    $_SESSION['nbConstraint']++;
                } else if ($error == 1) {
                    $_SESSION['errorMsg2'] = 'La contrainte que vous avez essayé d\'ajouter existe déjà ! ';
                    $_SESSION['displayError'] = 1;
                } else if ($error == 2) {
                    $_SESSION['errorMsg2'] = 'Vous ne pouvez pas attribuer un nombre d\'exemplaires d\'un jeu excédent le nombre d\'exemplaires en stock !';
                    $_SESSION['displayError'] = 1;
                }
                header('Location:' . URL . 'admin/showwishes');
                die();
            }
            if (isset($_SESSION['displayError'])) {
                if ($_SESSION['displayError']) {
                    $_SESSION['displayError'] = 0;
                } else {
                    unset($_SESSION['errorMsg2']);
                }
            }

            if (!empty($_GET['pos']) ||  $_GET['pos'] === 0) { //supression d'un jeu
                $pos = $_GET['pos'];
                unset($_SESSION['constraintTable'][$pos - 1]);
                header('Location:' . URL . 'admin/showwishes');
            }

            require('View/admin/adminwish.php');
        }
    }
    public function attribution()
    {
        if ($_SESSION['admin'] != 1) {
            header("Location: " . SITE);
        } else {
            $phase = managePhase(1);
            $informationRepository = new InformationRepository();
            $gameRepository = new GameRepository();
            $wishesRepository = new WishesRepository();
            $database = new DatabaseConnection();
            $informationRepository->connection = $database;
            $gameRepository->connection = $database;
            $wishesRepository->connection = $database;

            $date = new DateTime($informationRepository->getDeadLine());

            //nb jeux

            $gamenb = $gameRepository->getGamesNb();

            //nb user non admin

            $usernb = $wishesRepository->getNbUser();

            //tableau avec le nombre d'exemplaires de chaque jeux

            $gamequantity = $gameRepository->getGamequantity();

            //tableau dont chaque élément sont des idtable donc composés d'un user_id et d'un tableau de game_id

            $gameswishedAndUsers = $wishesRepository->getidtable(); // servira aussi pour récupérer le résultat

            // récupérer les id de tous les jeux, ensuite pour chaque id on check s'il est dans games[user], s'il y est on met un 1 sinon un 0

            $games_id = $gameRepository->getGameswished(); // tableau avec game_id wished order by asc
            $wish = [];
            $i = 0;
            foreach ($gameswishedAndUsers as $gamewished) { // on parcours tous les utilisateurs
                foreach ($games_id as $game_id) { // on parcours tous les jeux
                    foreach ($gamewished->game_id as $id) { // on parcours tous les jeux demandés
                        if ($id == $game_id) {
                            $wish[$i] = 1;
                        } else if (!isset($wish[$i])) {
                            $wish[$i] = 0;
                        }
                    }
                    $i++;
                }
            }

            // gestion des contraintes
            $constraints = [];
            if (isset($_SESSION['constraintTable'])) {
                $gamesAndUsersNamesList = $wishesRepository->getGamesAndUsersNamesList();
                foreach ($_SESSION['constraintTable'] as $i => $constraintTable) {
                    $constraint = new Wish();
                    for ($j = 0; $j < $usernb; $j++) {
                        if ($constraintTable['member'] == $gamesAndUsersNamesList['user_names'][$j]) {
                            $constraint->user_id = $j + 1;
                        }
                    }
                    for ($m = 0; $m < $gamenb; $m++) {
                        if ($constraintTable['game'] == $gamesAndUsersNamesList['game_names'][$m]) {
                            $constraint->game_id = $m + 1;
                        }
                    }
                    $constraints[] = $constraint;
                }
            }
            require('script_solver.php');

            $wishesRepository->deletePastAttribution();
            for ($i = 0; $i < $gamenb * $usernb; $i++) {
                if ($attribution[$i] == 1) {
                    $wishesRepository->fillAttributionTable($gameswishedAndUsers[floor($i / $gamenb)]->user_id, $games_id[$i % $gamenb]);
                }
            }
            $informations = $wishesRepository->getattributionforadmin();

            require('View/admin/attribution.php');
        }
    }
    public function cancelAttribution()
    {
        if ($_SESSION['admin'] != 1) {
            header("Location: " . SITE);
        } else {
            $phase =  managePhase(1);
            $informationRepository = new InformationRepository();
            $database = new DatabaseConnection();
            $informationRepository->connection = $database;

            $informationRepository->modifyAttribution(0);
            header('Location:' . SITE . '/admin/showwishes/');
        }
    }
    public function acceptAttribution()
    {
        if ($_SESSION['admin'] != 1) {
            header("Location: " . SITE);
        } else {
            $phase = managePhase(1);
            $wishesRepository = new WishesRepository();
            $informationRepository = new InformationRepository();
            $historyRepository = new HistoryRepository();
            $database = new DatabaseConnection();
            $informationRepository->connection = $database;
            $wishesRepository->connection = $database;
            $historyRepository->connection = $database;

            $nb_copies_updated = $this->updateNbCopiesLeft();
            var_dump($nb_copies_updated);
            $wishesRepository->updateNbCopiesLeft($nb_copies_updated);

            $historyRepository->addToHistory();
            $wishesRepository->deleteAllFromWishes();

            if (isset($_SESSION['constraintTable'])) {
                unset($_SESSION['constraintTable']);
                unset($_SESSION['nbConstraint']);
            }

            $informationRepository->modifyPhase(2);
            $informationRepository->modifyAttribution(1);

            header('Location:' . SITE);
        }
    }
    public function passToPhase1()
    {
        if ($_SESSION['admin'] != 1) {
            header("Location: " . SITE);
        } else {
            $phase = managePhase(2);
            $now = new DateTime('now');
            if (isset($_POST['date'])) {
                $informationRepository = new InformationRepository();
                $freeBorrowRepository = new FreeBorrowRepository();
                $database = new DatabaseConnection();
                $informationRepository->connection = $database;
                $freeBorrowRepository->connection = $database;

                $date = new DateTime($_POST['date']);
                if ($date > $now && $date->format('Y-m-d') != $now->format('Y-m-d')) {
                    $informationRepository->modifyDate($date);
                    $informationRepository->modifyPhase(1);
                    $freeBorrowRepository->resetFreeBorrowTable();
                    $successMsg = 'Vous venez de passer à la phase de voeux.';
                } else {
                    $errorMsg = 'Vous devez sélectionner une date correcte.';
                }
            } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $errorMsg = 'Vous devez sélectionner une date correcte.';
            }
            require('View/admin/passToPhase1.php');
        }
    }
    public function updateDeadLine()
    {
        if ($_SESSION['admin'] != 1) {
            header("Location: " . SITE);
        } else {
            $informationRepository = new InformationRepository();
            $database = new DatabaseConnection();
            $informationRepository->connection = $database;

            $phase = managePhase(1);
            $now = new DateTime('now');
            if (isset($_POST['date'])) {
                $date = new DateTime($_POST['date']);
                if ($date > $now && $date->format('Y-m-d') != $now->format('Y-m-d')) {
                    $informationRepository->modifyDate($date);
                    $successMsg = 'La date a bien été modifiée.';
                } else {
                    $errorMsg = 'Vous devez sélectionner une date correcte.';
                }
            } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $errorMsg = 'Vous devez sélectionner une date correcte.';
            }
            require('View/admin/updateDeadLine.php');
        }
    }
    public function showHistory()
    {
        $informationRepository = new InformationRepository();
        $historyRepository = new HistoryRepository();
        $database = new DatabaseConnection();
        $informationRepository->connection = $database;
        $historyRepository->connection = $database;

        $phase = $informationRepository->getPhase();
        $date = new DateTime($informationRepository->getDeadLine());

        $dates = $historyRepository->getDates();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date_string = new DateTime($_POST['date']);
            $history = $historyRepository->getHistory($date_string);
        } else {
            if (isset($dates[0])) {
                $history = $historyRepository->getHistory($dates[0]);
            } else {
                $errorMsg = "Aucune attribution n'a encore été faite";
            }
        }
        require('View/admin/history.php');
    }
    private function updateNbCopiesLeft()
    {
        if ($_SESSION['admin'] != 1) {
            header("Location: " . SITE);
        } else {
            $phase = managePhase(1);
            $wishesRepository = new WishesRepository();
            $informationRepository = new InformationRepository();
            $historyRepository = new HistoryRepository();
            $database = new DatabaseConnection();
            $informationRepository->connection = $database;
            $wishesRepository->connection = $database;
            $historyRepository->connection = $database;

            $attributed = $wishesRepository->getNbCopiesAttributed();
            $nb_copies = $wishesRepository->getNbCopies();


            $nb_copies_updated = [];
            foreach ($nb_copies as $i => $nb_copies) {
                // echo "<br>" . "nb_copies" . "<br>";
                // var_dump($nb_copies);
                foreach ($attributed as $attr) {
                    // echo "<br>" . "attributed" . "<br>";
                    // var_dump($attr);
                    if (intval($nb_copies['id']) == intval($attr['id'])) {
                        $games['id'] = intval($nb_copies['id']);
                        $games['nbCopies'] = intval($nb_copies['nbCopies']) - intval($attr['nbAttributed']);
                        $nb_copies_updated[$i] = $games;
                        // echo "<br>" . "nb_copies_updated" . "<br>";
                        // var_dump($nb_copies_updated);
                        break;
                    } else {
                        $games['id'] = intval($nb_copies['id']);
                        $games['nbCopies'] = intval($nb_copies['nbCopies']);
                        $nb_copies_updated[$i] = $games;
                    }
                }
            }
            return $nb_copies_updated;
        }
    }
    public function showAllBorrowDemands()
    {

        if ($_SESSION['admin'] != 1) {
            header("Location: " . SITE);
        } else {
            $phase = managePhase(2);
            $freeBorrowRepository = new FreeBorrowRepository();
            $database = new DatabaseConnection();
            $freeBorrowRepository->connection = $database;

            if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['state'])) {
                $this->changeFreeBorrowState($_POST['state'], intval($_POST['user_id']), intval($_POST['game_id']), $_POST['previous_state']);
            }

            $fbdAndUser = $freeBorrowRepository->getFBDAndUser();
            require('View/admin/showAllBorrowDemands.php');
        }
    }
    private function changeFreeBorrowState($state, $user_id, $game_id, $previous_state)
    {
        if ($_SESSION['admin'] != 1) {
            header("Location: " . SITE);
        } else {
            $phase = managePhase(2);

            $freeBorrowRepository = new FreeBorrowRepository();
            $database = new DatabaseConnection();
            $freeBorrowRepository->connection = $database;

            if ($state == "En attente") {
                $value = 0;
                $freeBorrowRepository->changeFreeBorrowState($value, $game_id, $user_id);
            } else if ($state == "Refusée") {
                $value = -1;
                if ($previous_state == "Acceptée") {
                    $freeBorrowRepository->addNbCopies($game_id);
                }
                $freeBorrowRepository->changeFreeBorrowState($value, $game_id, $user_id);
            } else if ($state == "Acceptée") {
                $value = 1;
                $check = $freeBorrowRepository->checkFreeBorrowAccepting($game_id);
                if ($check == 1) {
                    $freeBorrowRepository->decreaseNbCopies($game_id);
                    $freeBorrowRepository->changeFreeBorrowState($value, $game_id, $user_id);
                }
            }
        }
    }
}
