<?php

namespace Controllers\Catalog;

use \PDO;
use Database\MysqlConnection;

class CatalogItems
{
    private $db;
    private $connection;

    public function __construct()
    {

        $this->connection = MysqlConnection::connect();
        
    }

    public function getItem(int $id)
    {
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM catalog WHERE id=?');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute([$id]);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetch();

        return $result;
    }

    public function getAllItems()
    {
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM catalog');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute();
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

    public function getRangeItems(int $from, int $to): array
    {
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM catalog WHERE id BETWEEN ? and ?');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute([$from, $to]);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

    public function getItemsByPrice(int $min, int $max): array
    {
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM catalog WHERE price BETWEEN ? and ?');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute([$min, $max]);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

    public function getItemsByName(string $name): array
    {
        $insertString = "%$name%";
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM catalog WHERE name LIKE ?');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute([$insertString]);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

    public function getAllParameters(string $name): array
    {
        $insertString = "%$name%";
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare('SELECT * FROM catalog WHERE name LIKE ?');
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute([$insertString]);
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

    public function getItemsByMultipleIDs(array $items): array
    {
        $place_holders = implode(',', array_fill(0, count($items), '?'));
        $catalogString = "($place_holders)";
        $query = "SELECT * FROM catalog WHERE id IN $catalogString";
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare($query);
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute($items);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

    public function getItemsByCoupleParameters(string $price, string $name): array
    {
        $parametersArray = [];

        $insertString = "%$name%";

        if  ($price !== '') {
            $priceArray = explode('-', $price);
            array_unshift($parametersArray, $priceArray[0], $priceArray[1]);
        }
        // $priceString = 'price > 0';
        // if (price !== '') {
        //     $priceString = 'price BETWEEN ? AND ?';
        // }
        $priceString = ($price !== '') ? '(price BETWEEN ? AND ?)' : 'price > 0';

        if ($name !== '') {
            $nameString = 'AND name LIKE ?';
            array_push($parametersArray, $insertString);
        } else {
            $nameString = '';
        };

        $query = "SELECT * FROM catalog WHERE $priceString $nameString";
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare($query);
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute($parametersArray);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }

    public function getItemsByAllParameters(string $price, string $name, int $category): array
    {
        $parametersArray = [];

        $insertString = "%$name%";

        if  ($price !== '') {
            $priceArray = explode('-', $price);
            array_unshift($parametersArray, $priceArray[0], $priceArray[1]);
        }
        // $priceString = 'price > 0';
        // if (price !== '') {
        //     $priceString = 'price BETWEEN ? AND ?';
        // }
        $priceString = ($price !== '') ? '(price BETWEEN ? AND ?)' : 'price > 0';

        if ($name !== '') {
            $nameString = 'AND name LIKE ?';
            array_push($parametersArray, $insertString);
        } else {
            $nameString = '';
        };
        // $nameString = ($name !== '') ? 'AND name LIKE ?' : '';

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
        $catalogString = "AND category_id IN ($place_holders)";

        $query = "SELECT * FROM catalog WHERE $priceString $nameString $catalogString";
        // 1. Подготавливаем запрос
        $statement = $this->connection->prepare($query);
        // 2. Указываем тип данных
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        // 3. Отправляем запрос в БД
        $statement->execute($parametersArray);
        // 4. Указываем что сделать с данными после получения запроса
        $result = $statement->fetchAll();

        return $result;
    }
}


