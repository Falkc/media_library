<?php

namespace App\Model;

use App\Model\Entity\Game;
use App\Model\Entity\Wish;
use App\Model\Entity\Idtable;
use App\Lib\DatabaseConnection;
use App\Model\Entity\Adminwish;

class WishesRepository
{
    public DatabaseConnection $connection;

    public function checkWish($user_id, $game_id): int
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, user_id , game_id FROM wishes WHERE user_id=? AND game_id=? "
        );
        $statement->execute(
            [$user_id, $game_id]
        );
        $row = $statement->fetch();
        if (empty($row)) {
            return 0;
        } else {
            return 1;
        }
    }
    public function addwish($user_id, $game_id)
    {

        $insert = $this->connection->getConnection()->prepare(
            "INSERT INTO wishes(game_id, user_id) VALUES(:game_id, :user_id)"
        );
        $insert->execute([
            'game_id' => $game_id,
            'user_id' => $user_id,
        ]);
    }
    public function deletewish($user_id, $game_id)
    {
        $delete = $this->connection->getConnection()->prepare(
            "DELETE FROM wishes WHERE user_id=? AND game_id=?"
        );
        $delete->execute(
            [$user_id, $game_id]
        );
    }
    public function getwishes()
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM games WHERE id IN (SELECT game_id FROM wishes WHERE user_id = ?)'
        );
        $statement->execute([$_SESSION['id']]);
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
    public function getwishesforadmin(): array
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT u.first_name, u.last_name, GROUP_CONCAT(g.name SEPARATOR \',  \') FROM users u JOIN wishes w ON u.id = w.user_id JOIN games g ON g.id = w.game_id GROUP BY u.id ORDER BY u.last_name ASC'
        );
        $wishes = [];
        while (($row = $statement->fetch())) {
            $wish = new Adminwish();
            $wish->firstname = $row['first_name'];
            $wish->lastname = $row['last_name'];
            $wish->game_name = $row['GROUP_CONCAT(g.name SEPARATOR \',  \')'];
            $wishes[] = $wish;
        }
        $id = 'name';
        $wishesWithoutConca = $this->removeConcatenation($wishes, $id);
        return  $wishesWithoutConca;
    }


    public function getNbUser(): int //nombre d'utilisateurs qui ont fait un voeux
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT COUNT(DISTINCT id) AS nb FROM users WHERE admin=0'
        );
        return $statement->fetch()['nb'];
    }

    public function getidtable(): array
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT u.id,GROUP_CONCAT(w.game_id SEPARATOR\',\' ) FROM users u LEFT JOIN wishes w ON u.id=w.user_id WHERE u.admin=0 GROUP BY u.id'   //SELECT user_id,GROUP_CONCAT(game_id SEPARATOR\',\' ) FROM wishes  GROUP BY user_id
        );
        $wishes = [];
        while (($row = $statement->fetch())) {
            $wish = new Wish();
            $wish->user_id = $row['id'];
            if ($row['GROUP_CONCAT(w.game_id SEPARATOR\',\' )'] == NULL) {
                $wish->game_id = 'erreur';
            } else {
                $wish->game_id = $row['GROUP_CONCAT(w.game_id SEPARATOR\',\' )'];
            }


            $wishes[] = $wish;
        }
        $id = 'id';
        $gamesWished = $this->removeConcatenation($wishes, $id);

        return $gamesWished;
    }
    public function fillAttributionTable(int $user_id, int $game_id)
    {
        $insert = $this->connection->getConnection()->prepare(
            "INSERT INTO attribution (game_id, user_id) VALUES(:game_id, :user_id)"
        );
        $insert->execute([
            'game_id' => $game_id,
            'user_id' => $user_id,
        ]);
    }
    public function getattributionforadmin(): array
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT u.first_name, u.last_name, GROUP_CONCAT(g.name SEPARATOR \',  \') FROM users u JOIN attribution a ON u.id = a.user_id JOIN games g ON g.id = a.game_id GROUP BY u.id ORDER BY u.last_name ASC'
        );
        $wishes = [];
        while (($row = $statement->fetch())) {
            $wish = new Adminwish();
            $wish->firstname = $row['first_name'];
            $wish->lastname = $row['last_name'];
            $wish->game_name = $row['GROUP_CONCAT(g.name SEPARATOR \',  \')'];
            $wishes[] = $wish;
        }
        return $wishes;
    }
    public function deletePastAttribution()
    {
        $delete = $this->connection->getConnection()->query(
            'TRUNCATE TABLE attribution'
        );
    }
    private function removeConcatenation(array $wishes, string $id): array
    {
        $gamesWished = [];
        foreach ($wishes as $wish) {
            if ($id == 'id') {
                $idTable = new Idtable();
                $idTable->user_id = $wish->user_id;
                $idTable->game_id[0] = '';
                $j = 0;
                for ($i = 0; $i < strlen($wish->game_id); $i++) {
                    if ($wish->game_id[$i] != ',' && $wish->game_id[$i] != '' && is_numeric($wish->game_id[$i])) {
                        $idTable->game_id[$j] .= $wish->game_id[$i];
                    } else {
                        $j++;
                        $idTable->game_id[$j] = '';
                    }
                }
                $gamesWished[] = $idTable;
            } else {
                $nameTable = ['firstname' => $wish->firstname, 'lastname' => $wish->lastname, 'gamename' => []];
                $nameTable['gamename'][0] = '';
                $j = 0;
                for ($i = 0; $i < strlen($wish->game_name); $i++) {
                    if ($wish->game_name[$i] != ',' && $wish->game_name[$i] != '') {
                        $nameTable['gamename'][$j] .= $wish->game_name[$i];
                    } else {
                        $j++;
                        $nameTable['gamename'][$j] = '';
                    }
                }
                $gamesWished[] = $nameTable;
            }
        }
        return $gamesWished;
    }
    public function getDistinctGamesFromWishes(): array
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT DISTINCT name FROM games WHERE id IN (SELECT DISTINCT game_id FROM wishes)'
        );
        $game_names = [];
        while ($row = $statement->fetch()) {
            $game_name = $row['name'];
            $game_names[] = $game_name;
        }
        return $game_names;
    }
    public function checkNewConstraint($user_name, $game_name): int     //test si une contrainte est applicable
    {
        $statement1 = $this->connection->getConnection()->prepare(
            "SELECT nb_copies FROM games WHERE name=?"
        );
        $statement1->execute([$game_name]);
        while ($row = $statement1->fetch()) {
            $nb_copies = $row['nb_copies'];
        }
        $count = 0;
        foreach ($_SESSION['constraintTable'] as $const) {
            if (($const['member'] == $user_name && ($const['game'] == $game_name))) {
                return 1;
            }
            if (($const['game'] == $game_name)) {
                $count++;
            }
        }
        if (strval($nb_copies) <= $count) {
            return 2;
        } else if (strval($nb_copies) > $count) {
            return 0;
        }
    }
    public function getGamesAndUsersNamesList(): array
    {
        $statement1 = $this->connection->getConnection()->query(
            "SELECT name FROM games ORDER BY id ASC"
        );
        $statement2 = $this->connection->getConnection()->query(
            "SELECT first_name,last_name FROM users WHERE admin=0 ORDER BY id ASC"
        );
        $game_names = [];
        while ($row = $statement1->fetch()) {

            $game_name = $row['name'];
            $game_names[] = $game_name;
        }

        $user_names = [];
        while ($row = $statement2->fetch()) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];

            $user_names[] = ucfirst($last_name) . ' ' . ucfirst($first_name);
        }

        $gamesAndUsersNamesList = ['user_names' => $user_names, 'game_names' => $game_names];
        return $gamesAndUsersNamesList;
    }
    function getAttributionForUser(): array
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT * FROM games WHERE id IN (SELECT game_id FROM attribution WHERE user_id = ?)"
        );
        $statement->execute([$_SESSION['id']]);
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
