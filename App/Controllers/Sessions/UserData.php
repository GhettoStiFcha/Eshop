<?php

namespace Controllers\Sessions;

use \PDO;
use Database\MysqlConnection;

class UserData
{
    public function __construct()
    {
        $this->connection = MysqlConnection::connect();
        session_start();
    }

    public function getUserData(): array
    {
        $query = "SELECT * FROM users WHERE login = ? AND password = ?";

        $statement = $this->connection->prepare($query);

        $statement->setFetchMode(PDO::FETCH_ASSOC);
        
        $statement->execute();
        
        $result = $statement->fetchAll();

        return $result;
    }
}



