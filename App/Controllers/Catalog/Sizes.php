<?php

namespace Controllers\Catalog;

use \PDO;
use Database\MysqlConnection;

class Sizes
{
    private $connection;

    public function __construct()
    {
        $this->connection = MysqlConnection::connect();
    }

    public function getItemSizes(int $id): array
    {
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT size_id FROM added_sizes WHERE product_id=?');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute([$id]);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }


    public function getSizes(?int $sizeID): array
    {
        $statement = $this->connection->prepare('SELECT * FROM sizes WHERE id=?');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$sizeID]);
        $result = $statement->fetchAll();

        return $result;
    }
}