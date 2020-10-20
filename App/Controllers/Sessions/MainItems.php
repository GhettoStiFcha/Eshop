<?php

namespace Controllers\Sessions;

use \PDO;
use Database\MysqlConnection;

class MainItems
{
    private $db;
    private $connection;

    public function __construct()
    {

        $this->connection = MysqlConnection::connect();

    }

    public function getAllItems()
    {
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM images WHERE id>6');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute();
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }
}