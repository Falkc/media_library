<?php

namespace App\Model;

use App\Lib\DatabaseConnection;
use App\Model\Entity\FreeBorrowDemands;
use App\Model\Entity\FreeBorrowDemandsAndUserName;

class FreeBorrowRepository
{
    public DatabaseConnection $connection;

    public function addFreeBorrowToDataBase($user_id, $game_id)
    {
        $insert = $this->connection->getConnection()->prepare(
            "INSERT INTO free_borrow (game_id, user_id) VALUES(:game_id, :user_id)"
        );
        $insert->execute([
            'game_id' => $game_id,
            'user_id' => $user_id,
        ]);
    }

    public function checkFreeBorrowAddingBySlug($game_slug)
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT COUNT(id) AS nb FROM games WHERE nb_copies_left>0 AND slug=?'
        );
        $statement->execute([$game_slug]);
        return $statement->fetch()['nb'];
    }
    public function checkFreeBorrow($user_id, $game_id)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT id, user_id , game_id FROM free_borrow WHERE user_id=? AND game_id=? "
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
    public function deleteFreeBorrow($user_id, $game_id)
    {
        $delete = $this->connection->getConnection()->prepare(
            "DELETE FROM free_borrow WHERE user_id=? AND game_id=?"
        );
        $delete->execute(
            [$user_id, $game_id]
        );
    }
    public function getFreeBorrowDemands()
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM games g JOIN free_borrow f On g.id=f.game_id WHERE f.user_id =?'
        );
        $statement->execute([$_SESSION['id']]);
        $games = [];
        while (($row = $statement->fetch())) {
            $game = new FreeBorrowDemands();
            $game->id = $row['game_id'];
            $game->name = $row['name'];
            $game->slug = $row['slug'];
            $game->description = $row['description'];
            $game->image = $row['image'];
            $game->demandState = $row['state'];

            $games[] = $game;
        }
        return $games;
    }
    public function getFBDAndUser() // fbd= freeBorrowDemands
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT u.first_name, u.last_name,u.id,f.game_id, g.name, g.slug, g.description, g.image, f.state
            FROM users u 
            JOIN free_borrow f ON u.id = f.user_id 
            JOIN games g ON g.id = f.game_id 
            ORDER BY u.last_name ASC'
        );
        $fbdAndUser = [];
        while (($row = $statement->fetch())) {
            if (isset($fbdAndUser[$row['id']])) {
                $fbd = new FreeBorrowDemands();

                $fbd->id = $row['game_id'];
                $fbd->name = $row['name'];
                $fbd->slug = $row['slug'];
                $fbd->description = $row['description'];
                $fbd->image = $row['image'];
                $fbd->demandState = $row['state'];

                $fbdAndUser[$row['id']]->fbd_array[] = $fbd;
            } else {
                $fbdNUser = new FreeBorrowDemandsAndUserName();
                $fbd = new FreeBorrowDemands();

                $fbd->id = $row['game_id'];
                $fbd->name = $row['name'];
                $fbd->slug = $row['slug'];
                $fbd->description = $row['description'];
                $fbd->image = $row['image'];
                $fbd->demandState = $row['state'];

                $fbdNUser->fbd_array[] = $fbd;
                $fbdNUser->first_name = $row['first_name'];
                $fbdNUser->last_name = $row['last_name'];
                $fbdNUser->user_id = $row['id'];

                $fbdAndUser[$row['id']] = $fbdNUser;
            }
        }
        return  $fbdAndUser;
    }
    public function changeFreeBorrowState($state, $game_id, $user_id)
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE free_borrow  SET state= ? WHERE user_id = ? AND game_id= ?"
        );

        $statement->execute(
            [$state, $user_id, $game_id]
        );
    }
    public function decreaseNbCopies($game_id)
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT nb_copies_left FROM games WHERE id=?'
        );
        $statement->execute([$game_id]);
        $nb_copies_left = intval($statement->fetch()['nb_copies_left']) - 1;

        $decrease = $this->connection->getConnection()->prepare(
            'UPDATE games SET nb_copies_left= :nb_copies WHERE id= :game_id'
        );
        $decrease->execute([
            'nb_copies' => $nb_copies_left,
            'game_id' => $game_id,
        ]);
    }
    public function resetFreeBorrowTable()
    {
        $statement = $this->connection->getConnection()->query(
            "TRUNCATE TABLE free_borrow "
        );
    }
    public function checkFreeBorrowAccepting($game_id)
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM games WHERE nb_copies_left>0 AND id=?'
        );
        $statement->execute([$game_id]);
        $games = $statement->fetch();
        if (empty($games)) {
            return 0;
        } else {
            return 1;
        }
    }
    public function addNbCopies($game_id)
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT nb_copies_left FROM games WHERE id=?'
        );
        $statement->execute([$game_id]);
        $nb_copies_left = intval($statement->fetch()['nb_copies_left']) + 1;

        $increase = $this->connection->getConnection()->prepare(
            'UPDATE games SET nb_copies_left= :nb_copies WHERE id= :game_id'
        );
        $increase->execute([
            'nb_copies' => $nb_copies_left,
            'game_id' => $game_id,
        ]);
    }
}
