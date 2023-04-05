<?php

namespace App\Controller;

use App\Model\GameRepository;
use App\Lib\DatabaseConnection;
use App\Model\WishesRepository;

class WishesController
{

    public function addwish()
    {

        $wishRepository = new WishesRepository;
        $gameRepository = new GameRepository;
        $database = new DatabaseConnection;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;


        $game = $gameRepository->getGameBySlug($_GET['game_slug']);
        $wishRepository->addwish($_SESSION['id'], $game->id);
        header("Location:".SITE."/game/" . $game->slug);
    }
    public function deletewishandredirect()
    {
        $game = $this->deletewish($_GET['game_slug']);
        $redirect = $_GET['redirect'];
        var_dump($redirect);
        if ($redirect == 0) {
            header("Location:".SITE."/game/" . $game->slug);
        }
        if ($redirect == 1) {
            header("Location:".SITE."/showwishes/");
        }
    }
    private function deletewish($game_slug)
    {

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
        $wishRepository = new WishesRepository;
        $gameRepository = new GameRepository;
        $database = new DatabaseConnection;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;

        $games = $wishRepository->getwishes();
        if (empty($games)) {
            $errorMsg = 'Vous n\'avez pas encore séléctionné de voeux !';
        }

        require('View/wishes.php');
    }
}
