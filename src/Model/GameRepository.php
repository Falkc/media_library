<?php

namespace App\Model;

use App\Model\Entity\Game;
use App\Lib\DatabaseConnection;
use App\Model\Entity\Category;
use App\Model\Entity\Gamequantity;

class GameRepository
{
    public DatabaseConnection $connection;

    public function getGames(): array
    {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM games ORDER BY name"
        );
        $games = [];
        while (($row = $statement->fetch())) {
            $game = new Game();
            $game->id = $row['id'];
            $game->name = $row['name'];
            $game->slug = $row['slug'];
            $game->description = $row['description'];
            $game->image = $row['image'];

            $games[] = $game;
        }
        return $games;
    }

    public function getSomeGames(int $offset, int $number): array
    {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM games ORDER BY name LIMIT $offset, $number"
        );
        $games = [];
        while (($row = $statement->fetch())) {
            $game = new Game();
            $game->id = $row['id'];
            $game->name = $row['name'];
            $game->slug = $row['slug'];
            $game->description = $row['description'];
            $game->image = $row['image'];

            $games[] = $game;
        }
        return $games;
    }

    public function getGamesNb(): int
    {

        $statement = $this->connection->getConnection()->query(
            "SELECT COUNT(id) AS nb FROM games"
        );
        return $statement->fetch()['nb'];
    }

    public function getGameBySlug(string $slug): Game
    {
        // We retrieve the game linked to the id.
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM games WHERE slug=?"
        );
        $statement->execute([$slug]);
        $row =  $statement->fetch();

        if (empty($row)) {
            return null;
        }

        $game = new Game();
        $game->id = $row['id'];
        $game->name = $row['name'];
        $game->slug = $row['slug'];
        $game->description = $row['description'];
        $game->image = $row['image'];
        $game->nb_copies = $row['nb_copies'];

        return $game;
    }
    public function getGameById(string $id): Game
    {
        // We retrieve the game linked to the id.
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM games WHERE id=?"
        );
        $statement->execute([$id]);
        $row =  $statement->fetch();

        if (empty($row)) {
            return null;
        }

        $game = new Game();
        $game->id = $row['id'];
        $game->name = $row['name'];
        $game->slug = $row['slug'];
        $game->description = $row['description'];
        $game->image = $row['image'];
        $game->nb_copies = $row['nb_copies'];

        return $game;
    }
    // methode des jeux à une catégorie
    public function getGamesByCategory(Category $category, array $linktable): array
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM games"
        );
        $games = [];
        while (($row = $statement->fetch())) {
            $game = new Game();
            $game->id = $row['id'];
            $game->name = $row['name'];
            $game->slug = $row['slug'];
            $game->description = $row['description'];
            $game->image = $row['image'];
            $game->nb_copies = $row['nb_copies'];


            $games[] = $game;
        }
        $category_games = [];
        foreach ($linktable as $link) {
            if ($link->category_id === $category->id) {
                foreach ($games as $game) {
                    if ($game->id === $link->game_id) {
                        $category_games[] = $game;
                    }
                }
            }
        }
        return $category_games;
    }

    public function checkNewGame(string $name): bool
    {
        $check = $this->connection->getConnection()->prepare(
            "SELECT * FROM games WHERE name=?"
        );
        $check->execute([$name]);

        if ($check->rowCount() == 1) return false;

        return true;
    }

    public function addGame(string $name, string $slug, string $description, string $nb_copies, string $image): void
    {
        $name = htmlspecialchars($name);
        $slug = htmlspecialchars($slug);
        $description = htmlspecialchars($description);
        $nb_copies = htmlspecialchars($nb_copies);
        $image = htmlspecialchars($image);
        $insert = $this->connection->getConnection()->prepare(
            "INSERT INTO games(name, slug, description, image, nb_copies) VALUES(:name, :slug, :description, :image, :nb_copies)"
        );
        $insert->execute([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'image' => $image,
            'nb_copies' => $nb_copies

        ]);
    }
    public function modifyGameById(string $id, string $name, string $slug, string $description, string $nb_copies, string $image): void
    {
        $id = htmlspecialchars($id);
        $name = htmlspecialchars($name);
        $slug = htmlspecialchars($slug);
        $description = htmlspecialchars($description);
        $nb_copies = htmlspecialchars($nb_copies);
        $image = htmlspecialchars($image);
        $update = $this->connection->getConnection()->prepare(
            "UPDATE games
            SET name = :name, slug = :slug, description = :description, image = :image, nb_copies = :nb_copies
            WHERE id = :id"
        );
        $update->execute([
            'id' => $id,
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'image' => $image,
            'nb_copies' => $nb_copies

        ]);
    }
    public function deleteGame($game_id)
    {
        $deletefg = $this->connection->getConnection()->prepare(
            "DELETE FROM games WHERE id=?"
        );
        $deletefg->execute([$game_id]);

        $deletefcg = $this->connection->getConnection()->prepare(
            "DELETE FROM category_game WHERE game_id=?"
        );
        $deletefcg->execute([$game_id]);
    }
    public function getGamequantity() //tableau avec les jeux numérotés de 1 à n et le nombre d'exemplaires
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT nb_copies FROM games'
        );
        $gamequantity = [];
        while ($row = $statement->fetch()) {
            $gameqt = $row['nb_copies'];

            $gamequantity[] = $gameqt;
        }
        return $gamequantity;
    }
    public function getGameswished()
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT DISTINCT(id) AS id FROM games ORDER BY id ASC"
        );
        $games = [];
        while ($row = $statement->fetch()) {
            $games[] = $row['id'];
        }
        return $games;
    }
    public function getAvailableGamesNb()
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT COUNT(id) AS nb FROM games WHERE nb_copies_left>0'
        );
        return $statement->fetch()['nb'];
    }
    public function getSomeAvailableGames(int $offset, int $number): array
    {

        $statement = $this->connection->getConnection()->query(
            "SELECT * FROM games WHERE nb_copies_left>0 ORDER BY name LIMIT $offset, $number "
        );
        $games = [];
        while (($row = $statement->fetch())) {
            $game = new Game();
            $game->id = $row['id'];
            $game->name = $row['name'];
            $game->slug = $row['slug'];
            $game->description = $row['description'];
            $game->image = $row['image'];

            $games[] = $game;
        }
        return $games;
    }
}
