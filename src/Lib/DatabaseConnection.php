<?php

namespace App\Lib;

class DatabaseConnection
{
    public ?\PDO $database = null;

    public function getConnection()
    {
        if ($this->database === null) {
            $host = 'localhost';
            $user = 'noecabl9901';
            $pass = 'PZqJ7SatdHdh';
            $port = 3306;
            $db = 'noecabl9901';
            // $host = 'localhost';
            // $user = 'root';
            // $pass = '';
            // $port = '';
            // $db = 'test_media_library';
            $this->database = new \PDO('mysql:host='.$host.';port='.$port.';dbname='.$db.";charset=utf8", $user, $pass);
        }
        return $this->database;
    }
}