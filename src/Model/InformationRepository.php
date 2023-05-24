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
}
