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

    public function getUserData(?string $login = null, ?string $pass = null)
    {
        $query = "SELECT * FROM users WHERE login = ? AND password = ?";

        $statement = $this->connection->prepare($query);

        $statement->setFetchMode(PDO::FETCH_ASSOC);
        
        $statement->execute([$login, $pass]);
        
        $result = $statement->fetch();

        return $result;
    }

    public function getUserDataById(?int $id)
    {
        $query = "SELECT * FROM users WHERE id = ?";

        $statement = $this->connection->prepare($query);

        $statement->setFetchMode(PDO::FETCH_ASSOC);
        
        $statement->execute([$id]);
        
        $result = $statement->fetch();

        return $result;
    }
}



