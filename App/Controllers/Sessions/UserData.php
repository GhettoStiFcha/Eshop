<?php

namespace Controllers\Sessions;

use \PDO;
use Database\MysqlConnection;

class UserData
{
    private $db;
    private $connection;
    private $lastInsertId;

    public function __construct()
    {
        $this->connection = MysqlConnection::connect();
        session_start();
    }

    public function insertUserData(?string $login = null, ?string $pass = null, ?string $name = null, ?string $surname = null, ?int $phone = null, ?string $email = null)
    {
        $query = "INSERT INTO users (`login`, `password`, `name`, `surname`, `phone_number`, `email`) VALUES (?, ?, ?, ?, ?, ?)";

        $statement = $this->connection->prepare($query);

        $statement->setFetchMode(PDO::FETCH_ASSOC);
        
        $result = $statement->execute([$login, $pass, $name, $surname, $phone, $email]);

        $this->lastInsertId = $this->connection->lastInsertId();

        return $result;
    }

    public function isLoginUnique(?string $login = null)
    {
        $query = "SELECT * FROM users WHERE login = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$login]);
        $result = $statement->fetch();
        return $result;
    }

    public function insertUserEmail(?string $email = null)
    {
        $query = "INSERT INTO email (`email`) VALUES (?)";

        $statement = $this->connection->prepare($query);

        $statement->setFetchMode(PDO::FETCH_ASSOC);
        
        $statement->execute([$email]);
        
        $result = $statement->fetchAll();

        return $result;
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

    public function lastInsertId()
    {
        return $this->lastInsertId;
    }
}


