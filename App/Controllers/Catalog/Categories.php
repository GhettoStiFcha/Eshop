<?php

namespace Controllers\Catalog;

use \PDO;
use Database\MysqlConnection;

class Categories
{
    private $connection;
    private $rootID = 0;

    public function __construct()
    {
        $this->connection = MysqlConnection::connect();
    }

    public function getRootCategories(): array
    {
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM categories WHERE parent_id=?');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute([$this->rootID]);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

    public function getChildCategories(int $parent): array
    {
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM categories WHERE parent_id=?');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute([$parent]);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

}