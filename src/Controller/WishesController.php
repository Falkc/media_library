<?php

namespace App\Controller;

use DateTime;
use App\Model\GameRepository;
use App\Lib\DatabaseConnection;
use App\Model\WishesRepository;
use App\Model\CategoryRepository;
use App\Model\InformationRepository;

class WishesController
{

    public function addwish()
    {
        $phase = managePhase(1);
        $wishRepository = new WishesRepository();
        $gameRepository = new GameRepository();
        $informationRepository = new InformationRepository();
        $database = new DatabaseConnection();
        $informationRepository->connection = $database;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;

        $date = new DateTime($informationRepository->getDeadLine());
        $check = $this->checkWishAdding();
        if ($check == 0) {
            $game = $gameRepository->getGameBySlug($_GET['game_slug']);
            $wishRepository->addwish($_SESSION['id'], $game->id);
        } else if ($check == 1) {
            $_SESSION['wishError'] = "La date limite pour la formulation des voeux est atteinte, vous ne pouvez pas ajouter de voeux !";
            $_SESSION['displayWishError'] = 1;
        } else if ($check == 2) {
            $_SESSION['wishError'] = "Vous ne pouvez pas formuler plus de 6 voeux !";
            $_SESSION['displayWishError'] = 1;
        }
        header("Location:" . SITE . "/game/" . $_GET['game_slug']);
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
        $wishRepository = new WishesRepository();
        $gameRepository = new GameRepository();
        $informationRepository = new InformationRepository();
        $database = new DatabaseConnection();
        $informationRepository->connection = $database;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;

        $date = new DateTime($informationRepository->getDeadLine());
        $game = $gameRepository->getGameBySlug($game_slug);
        $wishRepository->deletewish($_SESSION['id'], $game->id);
        return $game;
    }
    public function showwishes()
    {
        $phase = managePhase(1);
        $wishRepository = new WishesRepository();
        $gameRepository = new GameRepository();
        $categoryRepository = new CategoryRepository();
        $informationRepository = new InformationRepository();
        $database = new DatabaseConnection();
        $informationRepository->connection = $database;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;
        $categoryRepository->connection = $database;

        $date = new DateTime($informationRepository->getDeadLine());
        $games = $wishRepository->getwishes();
        foreach ($games as $game) {
            $game->category = $categoryRepository->getGameCategoryById($game->id);
        }
        if (empty($games)) {
            $errorMsg = 'Vous n\'avez pas encore séléctionné de voeux !';
        }

        require('View/wishes.php');
    }
    public function showAttribution()
    {
        $phase = managePhase(2);

        $wishRepository = new WishesRepository;
        $gameRepository = new GameRepository;
        $categoryRepository = new CategoryRepository;
        $informationRepository = new InformationRepository();
        $database = new DatabaseConnection;
        $wishRepository->connection = $database;
        $gameRepository->connection = $database;
        $categoryRepository->connection = $database;
        $informationRepository->connection = $database;
        if ($informationRepository->getAttribution() == 1) {
            $games = $wishRepository->getAttributionForUser();
            foreach ($games as $game) {
                $game->category = $categoryRepository->getGameCategoryById($game->id);
            }
            if (empty($games)) {
                $errorMsg = 'Aucun jeux ne vous a été attribué !';
            }

            require('View/myGames.php');
        } else {
            header('Location:' . SITE);
        }
    }
    private function checkWishAdding()
    {
        $informationRepository = new InformationRepository();
        $wishesRepository = new WishesRepository();
        $database = new DatabaseConnection();
        $informationRepository->connection = $database;
        $wishesRepository->connection = $database;

        $now = new DateTime('now');
        $date = new DateTime($informationRepository->getDeadLine());
        $wishNb = $wishesRepository->nbWishes();

        if ($date > $now && $date->format('Y-m-d') != $now->format('Y-m-d') && intval($wishNb) < 6) {
            var_dump(intval($wishNb));
            var_dump($wishNb);
            return 0;
        } else if ($date <= $now || $date->format('Y-m-d') == $now->format('Y-m-d')) {
            return 1;
        } else if (intval($wishNb) >= 6) {
            // var_dump($wishNb);
            return 2;
        }
    }
}
