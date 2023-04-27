<?php

namespace App\Controller;

use App\Model\GameRepository;
use App\Lib\DatabaseConnection;
use App\Model\CategoryRepository;
use App\Model\WishesRepository;

class WishesController
{

    public function addwish()
    {
        $phase = managePhase(1);
        $wishRepository = new WishesRepository;
        $gameRepository = new GameRepository;
        $database = new DatabaseConnection;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;


        $game = $gameRepository->getGameBySlug($_GET['game_slug']);
        $wishRepository->addwish($_SESSION['id'], $game->id);
        header("Location:" . SITE . "/game/" . $game->slug);
    }
    public function deletewishandredirect()
    {
        $phase = managePhase(1);
        $game = $this->deletewish($_GET['game_slug']);
        $redirect = $_GET['redirect'];
        if ($redirect == 0) {
            header("Location:" . SITE . "/game/" . $game->slug);
        }
        if ($redirect == 1) {
            header("Location:" . SITE . "/showwishes/");
        }
    }
    private function deletewish($game_slug)
    {
        $phase = managePhase(1);
        $wishRepository = new WishesRepository;
        $gameRepository = new GameRepository;
        $database = new DatabaseConnection;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;

        $game = $gameRepository->getGameBySlug($game_slug);
        $wishRepository->deletewish($_SESSION['id'], $game->id);
        return $game;
    }
    public function showwishes()
    {
        $phase = managePhase(1);
        $wishRepository = new WishesRepository;
        $gameRepository = new GameRepository;
        $categoryRepository = new CategoryRepository;
        $database = new DatabaseConnection;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;
        $categoryRepository->connection = $database;

        $games = $wishRepository->getwishes();
        foreach ($games as $game) {
            $game->category = $categoryRepository->getGameCategoryById($game->id);
        }
        if (empty($games)) {
            $errorMsg = 'Vous n\'avez pas encore séléctionné de voeux !';
        }

        require('View/wishes.php');
    }
}
