<?php

namespace App\Controller;

use DateTime;
use App\Model\GameRepository;
use App\Lib\DatabaseConnection;
use App\Model\WishesRepository;
use App\Model\CategoryRepository;
use App\Model\FreeBorrowRepository;
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
        $date = new DateTime($informationRepository->getDeadLine());

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

        if ($date > $now && $date->format('Y-m-d') != $now->format('Y-m-d')) {
            var_dump(intval($wishNb));
            var_dump($wishNb);
            return 0;
        } else if ($date <= $now || $date->format('Y-m-d') == $now->format('Y-m-d')) {
            return 1;
        }
    }
    public function addWishFreeBorrow()
    {

        $informationRepository = new InformationRepository();
        $gameRepository = new GameRepository();
        $freeBorrowRepository = new FreeBorrowRepository();
        $wishesRepository = new WishesRepository();
        $database = new DatabaseConnection();
        $informationRepository->connection = $database;
        $wishesRepository->connection = $database;
        $gameRepository->connection = $database;
        $freeBorrowRepository->connection = $database;

        $phase = managePhase(2);
        $date = new DateTime($informationRepository->getDeadLine());

        $game_slug = $_GET['game_slug'];
        $check = $this->checkFreeBorrowAdding($game_slug);
        if ($check == true) {
            $game = $gameRepository->getGameBySlug($game_slug);
            $freeBorrowRepository->addFreeBorrowToDataBase($_SESSION['id'], $game->id);
            header("Location:" . SITE . "/game/" . $_GET['game_slug']);
        } else {
            header("Location:" . SITE);
        }
    }


    private function checkFreeBorrowAdding($game_slug)
    {
        $freeBorrowRepository = new FreeBorrowRepository();
        $database = new DatabaseConnection();

        $freeBorrowRepository->connection = $database;

        $check = $freeBorrowRepository->checkFreeBorrowAddingBySlug($game_slug);
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteFreeBorrowAndRedirect()
    {
        $phase = managePhase(2);
        $game = $this->deleteFreeBorrow($_GET['game_slug']);
        $redirect = $_GET['redirect'];
        if ($redirect == 0) {
            header("Location:" . SITE . "/game/" . $game->slug);
        }
        if ($redirect == 1) {
            header("Location:" . SITE . "/showFreeBorrowDemands/");
        }
    }
    private function deleteFreeBorrow($game_slug)
    {
        $phase = managePhase(2);

        $freeBorrowRepository = new FreeBorrowRepository();
        $gameRepository = new GameRepository();
        $informationRepository = new InformationRepository();
        $database = new DatabaseConnection();

        $informationRepository->connection = $database;
        $gameRepository->connection = $database;
        $freeBorrowRepository->connection = $database;

        $date = new DateTime($informationRepository->getDeadLine());
        $game = $gameRepository->getGameBySlug($game_slug);
        $freeBorrowRepository->deleteFreeBorrow($_SESSION['id'], $game->id);
        return $game;
    }
    public function showFreeBorrowDemands()
    {
        $phase = managePhase(2);

        $categoryRepository = new CategoryRepository();
        $freeBorrowRepository = new FreeBorrowRepository();
        $gameRepository = new GameRepository();
        $informationRepository = new InformationRepository();
        $database = new DatabaseConnection();

        $informationRepository->connection = $database;
        $gameRepository->connection = $database;
        $freeBorrowRepository->connection = $database;
        $categoryRepository->connection = $database;
        $date = new DateTime($informationRepository->getDeadLine());

        $games = $freeBorrowRepository->getFreeBorrowDemands();

        foreach ($games as $game) {
            $game->category = $categoryRepository->getGameCategoryById($game->id);
        }


        if (empty($games)) {
            $errorMsg = 'Vous n\'avez pas encore fait de demande d\'emprunt libre !';
        }

        require('View/freeBorrowDemands.php');
    }
}
