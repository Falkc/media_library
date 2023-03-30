<?php

namespace App\Lib;

class DatabaseConnection
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if ($this->database === null) {
            $this->database = new \PDO('mysql:host=localhost;dbname=test_media_library;charset=utf8', 'root', 'root');
        }
        return $this->database;
    }
}
