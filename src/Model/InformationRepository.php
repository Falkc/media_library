<?php

namespace App\Model;

use App\Lib\DatabaseConnection;

class InformationRepository
{
    public DatabaseConnection $connection;

    public function getPhase(): int
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT phase FROM information WHERE id=1"
        );
        $phase = $statement->fetch()['phase'];
        return $phase;
    }
    public function getAttribution(): bool // retourne 1 s'il existe une attribution 0 sinon
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT attribution FROM information WHERE id=1"
        );
        $attribution = $statement->fetch()['attribution'];
        return $attribution;
    }
    public function modifyAttribution(int $value): void
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE information SET attribution=? WHERE id=1"
        );
        $statement->execute([$value]);
    }
    public function modifyPhase(int $value): void
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE information SET phase=? WHERE id=1"
        );
        $statement->execute([$value]);
    }
    public function modifyDate(DateTime $date): void
    {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE information SET dead_line=? WHERE id=1"
        );
        $date_string = $date->format('Y-m-d H:i:s');
        $statement->execute([$date_string]);
    }
    public function getDeadLine()
    {
        $statement = $this->connection->getConnection()->query(
            "SELECT dead_line FROM information WHERE id=1"
        );
        $dead_line = $statement->fetch()['dead_line'];
        return $dead_line;
    }
}
