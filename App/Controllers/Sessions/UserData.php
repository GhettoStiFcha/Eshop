<?php

namespace Controllers\Sessions;

use \PDO;
use Database\MysqlConnection;

class UserData
{
    private $db;
    private $connection;

    public function __construct()
    {
        $this->connection = MysqlConnection::connect();
        session_start();
    }

    public function getUserData(string $login, string $pass): array
    {
        $query = "SELECT * FROM users WHERE login = ? AND password = ?";

        $statement = $this->connection->prepare($query);

        $statement->setFetchMode(PDO::FETCH_ASSOC);
        
        $statement->execute([$login, $pass]);
        
        $result = $statement->fetchAll();

        return $result;
    }
}



