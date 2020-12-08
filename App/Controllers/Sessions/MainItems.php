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

    public function getAllItems(): array
    {
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM images');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute();
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

    public function searchCategory($category)
    {
        $query = "SELECT * FROM categories WHERE parent_id = ?";
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare($query);
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute([$category]);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

    public function getItemsFromCatalog($category): array
    {
        $categorySearch = $this->searchCategory($category);
        $categoryArray = [];
        if (!empty($categorySearch)) {
            foreach($categorySearch as $key => $value) {
                array_push($categoryArray, $value['id']);
            }
            $category = $categoryArray;
        } else {
            array_push($categoryArray, $category);
            $category = $categoryArray;
        }

        $parametersArray = array_merge($parametersArray, $category);

        $place_holders = implode(',', array_fill(0, count($category), '?'));
        $catalogString = "category_id IN ($place_holders)";

        $query = "SELECT id FROM catalog WHERE $catalogString";
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare($query);
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute($category);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }
}