<?php

namespace App\Controller;

use DateTime;
use App\Model\GameRepository;
use App\Lib\DatabaseConnection;
use App\Model\CategoryRepository;
use App\Model\InformationRepository;

class HomeController
{
    public function index()
    {
        $categoryRepository = new CategoryRepository;
        $gameRepository = new GameRepository();
        $informationRepository = new InformationRepository();
        $database = new DatabaseConnection();
        $categoryRepository->connection = $database;
        $gameRepository->connection = $database;

        $informationRepository->connection = $database;

        $date = new DateTime($informationRepository->getDeadLine());
        $phase = $informationRepository->getPhase();
        if ($phase == 1) {
            $nbGames = $gameRepository->getGamesNb();
            $NbGamesByPage = 12;
            $nbPages = ceil($nbGames / $NbGamesByPage); //on calcul le nombre de pages
            if (empty($_GET['page'])) {
                $page = 1;
            } else if ($_GET['page'] > $nbPages) {
                header("Location:" . SITE);
            } else $page = $_GET['page'];

            $games = $gameRepository->getSomeGames(($page - 1) * $NbGamesByPage, $NbGamesByPage);

            for ($i = 0; $i < count($games); $i++) {
                $games[$i]->category = $categoryRepository->getGameCategoryById($games[$i]->id);
            }
        } else {
            $nbGames = $gameRepository->getAvailableGamesNb();
            $NbGamesByPage = 12;
            $nbPages = ceil($nbGames / $NbGamesByPage); //on calcul le nombre de pages
            if (empty($_GET['page'])) {
                $page = 1;
            } else if ($_GET['page'] > $nbPages) {
                header("Location:" . SITE);
            } else $page = $_GET['page'];

            $games = $gameRepository->getSomeAvailableGames(($page - 1) * $NbGamesByPage, $NbGamesByPage);

            for ($i = 0; $i < count($games); $i++) {
                $games[$i]->category = $categoryRepository->getGameCategoryById($games[$i]->id);
            }
            if ($nbGames == 0) {
                $errMsg = "Tous les jeux ont été attribués";
            }
        }

        require('View/home.php');
    }
}
