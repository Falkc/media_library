<?php

namespace App\Model;

use App\Lib\DatabaseConnection;
use App\Model\Entity\Category;
use App\Model\Entity\Game;
use App\Model\Entity\LinkTable;

class CategoryRepository
{
    public DatabaseConnection $connection;

    public function getCategories(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT id, name, slug FROM category"
        );
        $categories = [];
        while (($row = $statement->fetch())) {
            $category = new Category();
            $category->id = $row['id'];
            $category->name = $row['name'];
            $category->slug = $row['slug'];



            $categories[] = $category;
        }
        return $categories;
    }

    public function getCategoriesNb(): int
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT COUNT(id) AS nb FROM category"
        );
        return $statement->fetch()['nb'];
    }

    public function getLinkTable(): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT category_id, game_id FROM category_game"
        );
        $linktable = [];
        while (($row = $statement->fetch())) {
            $link = new LinkTable();
            $link->game_id = $row['game_id'];
            $link->category_id = $row['category_id'];

            $linktable[] = $link;
        }
        return $linktable;
    }
    public function getCategoryBySlug($slug)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id,name,slug FROM category WHERE slug=?"
        );
        $statement->execute([$slug]);
        $row =  $statement->fetch();
        if (empty($row)) {
            return null;
        } else {
            $category = new Category();
            $category->id = $row['id'];
            $category->name = $row['name'];
            $category->slug = $row['slug'];

            return $category;
        }
    }
    public function checkcategory($category_name)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id,name,slug FROM category WHERE name=?"
        );
        $statement->execute([$category_name]);
        $row = $statement->fetch();
        if (empty($row)) {
            return null;
        } else {
            $category = new Category();
            $category->id = $row['id'];
            $category->name = $row['name'];
            $category->slug = $row['slug'];

            return $category;
        }
    }
    public function addcategorytogame($category_id, $game_id)
    {

        $insert = $this->connection->getConnection()->prepare(
            "INSERT INTO category_game(category_id, game_id) VALUES(:category_id, :game_id)"
        );
        $insert->execute([
            'category_id' => $category_id,
            'game_id' => $game_id,
        ]);
    }
    public function modifyGameCategory($category_id, $game_id)
    {

        $insert = $this->connection->getConnection()->prepare(
            "UPDATE category_game
            SET category_id = :category_id
            WHERE game_id = :game_id"
        );
        $insert->execute([
            'category_id' => $category_id,
            'game_id' => $game_id,
        ]);
    }

    public function getGameCategoryById(string $id): Category
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT category_id FROM category_game WHERE game_id=?"
        );
        $statement->execute([$id]);
        $categoryId = $statement->fetch()['category_id'];

        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM category WHERE id=?"
        );
        $statement->execute([$categoryId]);
        $row = $statement->fetch();
        
        $category = new Category();
        $category->id = $row['id'];
        $category->name = $row['name'];
        $category->slug = $row['slug'];

        return $category;
    }
}
