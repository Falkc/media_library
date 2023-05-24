<?php

namespace App\Controller;

use DateTime;
use App\Model\GameRepository;
use App\Lib\DatabaseConnection;
use App\Model\CategoryRepository;

class HomeController
{
    public function index()
    {
        $categoryRepository = new CategoryRepository;
        $gameRepository = new GameRepository();
        $database = new DatabaseConnection();
        $categoryRepository->connection = $database;
        $gameRepository->connection = $database;

        $informationRepository->connection = $database;

        $date = new DateTime($informationRepository->getDeadLine());
        $phase = $informationRepository->getPhase();
        $nbGames = $gameRepository->getGamesNb();
        $NbGamesByPage = 16;
        $nbPages = ceil($nbGames / $NbGamesByPage); //on calcul le nombre de pages
        if (empty($_GET['page'])) {
            $page = 1;
        } else if ($_GET['page'] > $nbPages) {
            header("Location:".SITE);
        } else $page = $_GET['page'];

        $games = $gameRepository->getSomeGames(($page - 1) * $NbGamesByPage, $NbGamesByPage);

        for($i=0; $i<count($games); $i++){
            $games[$i]->category = $categoryRepository->getGameCategoryById($games[$i]->id);
        }

        require('View/home.php');
    }
}
