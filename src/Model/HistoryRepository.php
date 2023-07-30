<?php

namespace App\Model;

use DateTime;
use App\Model\Entity\Idtable;
use App\Lib\DatabaseConnection;
use App\Model\Entity\Adminwish;


class HistoryRepository
{
    public DatabaseConnection $connection;

    public function getHistory(DateTime $date): array
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT u.first_name, u.last_name, GROUP_CONCAT(g.name SEPARATOR \',  \') AS game_names 
            FROM users u 
            JOIN history h ON u.id = h.user_id 
            JOIN games g ON g.id = h.game_id 
            WHERE h.date = ? 
            GROUP BY u.id 
            ORDER BY u.last_name ASC'
        );

        $date_string = $date->format('Y-m-d H:i:s');
        $statement->execute([$date_string]);
        $history = [];

        while ($row = $statement->fetch()) {
            $hist = new Adminwish();
            $hist->firstname = $row['first_name'];
            $hist->lastname = $row['last_name'];
            $hist->game_name = $row['game_names'];
            $history[] = $hist;
        }
        $id = 'name';
        $historyWithoutConca = $this->removeConcatenation($history, $id);
        return  $historyWithoutConca;
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
    public function getDates()
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT DISTINCT date FROM history ORDER BY date DESC ;"
        );
        $dates = [];
        while ($row = $statement->fetch()) {
            $date = new DateTime($row['date']);
            $dates[] = $date;
        }
        return $dates;
    }
    public function addToHistory()
    {

        $statement = $this->connection->getConnection()->query(
            "INSERT INTO history (game_id, user_id)
            SELECT game_id, user_id
            FROM attribution;"
        );
    }
}