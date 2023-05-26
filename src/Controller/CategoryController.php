<?php

namespace App\Controller;

use DateTime;
use App\Model\GameRepository;
use App\Model\Entity\Category;
use App\Lib\DatabaseConnection;
use App\Model\CategoryRepository;
use App\Model\InformationRepository;

class CategoryController
{
    public function categories()
    {
        //déclaration des classes et connexion
        $categoryRepository = new CategoryRepository;
        $gameRepository = new GameRepository;
        $informationRepository = new InformationRepository();
        $database = new DatabaseConnection;
        $categoryRepository->connection = $database;
        $gameRepository->connection = $database;
        $informationRepository->connection = $database;

        $date = new DateTime($informationRepository->getDeadLine());

        $phase = $informationRepository->getPhase();

        // calcul du nombre de page de catégorie
        $nbCategoriesByPage = 4;
        $nbCategories = $categoryRepository->getCategoriesNb();
        $nbPages = ceil($nbCategories / $nbCategoriesByPage);

        // récupération des catégories et des jeux 
        $categories = $categoryRepository->getCategories();
        $games = $gameRepository->getGames();
        $linktable = $categoryRepository->getLinkTable();

        for($i=0; $i<count($games); $i++){
            $games[$i]->category = $categoryRepository->getGameCategoryById($games[$i]->id);
        }

        require('View/categories.php');
    }
    public function category()
    {
        //déclaration des classes et connexion
        $categoryRepository = new CategoryRepository;
        $gameRepository = new GameRepository;
        $database = new DatabaseConnection;
        $categoryRepository->connection = $database;
        $gameRepository->connection = $database;
        $informationRepository = new InformationRepository();
        $informationRepository->connection = $database;

        $phase = $informationRepository->getPhase();
        $date = new DateTime($informationRepository->getDeadLine());

        // test du get
        if (empty($_GET['name'])) {
            header("Location:".SITE);
            exit;
        }
        $category_name = $_GET['name'];
        $category = $categoryRepository->getCategoryBySlug($category_name);
        if (!isset($category)) {
            $errorMsg = "Aucun jeu trouvé";
        }
        // récupération des jeux de la catégorie
        $linktable = $categoryRepository->getLinkTable();
        $games = $gameRepository->getGamesByCategory($category, $linktable);

        for($i=0; $i<count($games); $i++){
            $games[$i]->category = $categoryRepository->getGameCategoryById($games[$i]->id);
        }

        require('View/category.php');
    }
}
