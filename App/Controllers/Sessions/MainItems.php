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

    /**
     * Получение всех изображений для главной страницы
     * @returns array массив ссылок на изображения
     */
    public function getAllItems(): array
    {
        $statement = $this->connection->prepare('SELECT * FROM images');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Поиск подкатегорий, относящихся к родительской категории товара
     * @param $category категория-родитель
     * @return array массив категорий
     */
    public function searchCategory($category)
    {
        $query = "SELECT * FROM categories WHERE parent_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$category]);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Получение всех товаров категории-родителя
     * @param $category категория-родитель
     * @return array массив идентификаторов товаров
     */
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
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($category);
        $result = $statement->fetchAll();

        return $result;
    }
}