<?php

namespace App\Controller;

use App\Model\GameRepository;
use App\Lib\DatabaseConnection;
use App\Model\CategoryRepository;
use App\Model\WishesRepository;

class GameController
{
    public function game()
    {
        $categoryRepository = new CategoryRepository;
        $wishRepository = new WishesRepository;
        $gameRepository = new GameRepository;
        $database = new DatabaseConnection;
        $categoryRepository->connection = $database;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;

        if (empty($_GET['game'])) {
            header("Location:".SITE);
            exit;
        }

        $game_slug = $_GET['game'];
        $game = $gameRepository->getGameBySlug($game_slug);
        $game->category = $categoryRepository->getGameCategoryById($game->id);

        if (!isset($game)) {
            $errorMsg = "Aucun jeu trouvé";
        }
        if (isset($_SESSION['id'])) {
            $checkwish = $wishRepository->checkWish($_SESSION['id'], $game->id);
        } else {
            $checkwish = 0;
        }
        require('View/game.php');
    }
}