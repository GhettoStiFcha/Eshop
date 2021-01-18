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

    /**
     * Получение конкретного товара
     * @param int $id идентификатор товара
     * @return array массив данных товара
     */
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

    /**
     * Получение всех товаров
     * @return array массив товаров
     */
    public function getAllItems()
    {
        $statement = $this->connection->prepare('SELECT * FROM catalog');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Получение товаров в диапазоне их идентификаторов
     * @param int $from начальный идентификатор товара
     * @param int $to конечный идентификатор товара
     * @return array массив товаров
     */
    public function getRangeItems(int $from, int $to): array
    {
        $statement = $this->connection->prepare('SELECT * FROM catalog WHERE id BETWEEN ? and ?');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$from, $to]);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Получение товаров в диапазоне их стоимости 
     * @param int $min минимальная стоимость товара
     * @param int $max максимальная стоимость товара
     * @return array массив товаров
     */
    public function getItemsByPrice(int $min, int $max): array
    {
        $statement = $this->connection->prepare('SELECT * FROM catalog WHERE price BETWEEN ? and ?');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$min, $max]);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Поиск товаров по их наименованию
     * @param string $name имя товара
     * @return array массив товаров
     */
    public function getItemsByName(string $name): array
    {
        $insertString = "%$name%";
        $statement = $this->connection->prepare('SELECT * FROM catalog WHERE name LIKE ?');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$insertString]);
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
     * Поиск товаров по нескольких идентификаторам
     * @param array $items массив идентификаторов
     * @return array массив товаров
     */
    public function getItemsByMultipleIDs(array $items): array
    {
        $place_holders = implode(',', array_fill(0, count($items), '?'));
        $catalogString = "($place_holders)";
        $query = "SELECT * FROM catalog WHERE id IN $catalogString";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($items);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Поиск товаров по подкатегориям
     * @param int $subcategory идентификатор подкатегории
     * @return array массив товаров
     */
    public function getItemsBySubcategory(int $subcategory)
    {
        $query = "SELECT * FROM catalog WHERE category_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$subcategory]);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Поиск товаров по нескольким фильтрам
     * @param string $price фильтр цены товара
     * @param string $name фильтр наименования товара
     * @return array массив товаров
     */
    public function getItemsByCoupleParameters(string $price, string $name): array
    {
        $parametersArray = [];

        $insertString = "%$name%";

        if  ($price !== '') {
            $priceArray = explode('-', $price);
            array_unshift($parametersArray, $priceArray[0], $priceArray[1]);
        }
        $priceString = ($price !== '') ? '(price BETWEEN ? AND ?)' : 'price > 0';

        if ($name !== '') {
            $nameString = 'AND name LIKE ?';
            array_push($parametersArray, $insertString);
        } else {
            $nameString = '';
        };

        $query = "SELECT * FROM catalog WHERE $priceString $nameString";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($parametersArray);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Поиск товаров по всем фильтрам, кроме подкатегории
     * @param string $price фильтр цены товара
     * @param string $name фильтр наименования товара
     * @param int $category идентификатор категории товара
     * @return array массив товаров
     */
    public function getItemsByAllParameters(string $price, string $name, int $category): array
    {
        $parametersArray = [];

        $insertString = "%$name%";

        if  ($price !== '') {
            $priceArray = explode('-', $price);
            array_unshift($parametersArray, $priceArray[0], $priceArray[1]);
        }
        $priceString = ($price !== '') ? '(price BETWEEN ? AND ?)' : 'price > 0';

        if ($name !== '') {
            $nameString = 'AND name LIKE ?';
            array_push($parametersArray, $insertString);
        } else {
            $nameString = '';
        };

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
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($parametersArray);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Поиск товаров по нескольким фильтрам
     * @param string $price фильтр цены товара
     * @param int $category идентификатор категории товара
     * @param int $subcategory идентификатор подкатегории товара
     * @return array массив товаров
     */
    public function getItemsByNonameParametersSub(string $price, int $category, int $subcategory): array
    {
        $parametersArray = [];

        if  ($price !== '') {
            $priceArray = explode('-', $price);
            array_unshift($parametersArray, $priceArray[0], $priceArray[1]);
        }

        $priceString = ($price !== '') ? '(price BETWEEN ? AND ?)' : 'price > 0';

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

        $subcategoryString = "AND category_id = $subcategory";

        $parametersArray = array_merge($parametersArray, $category);

        $place_holders = implode(',', array_fill(0, count($category), '?'));
        $catalogString = "AND category_id IN ($place_holders)";

        $query = "SELECT * FROM catalog WHERE $priceString $catalogString $subcategoryString";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($parametersArray);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Поиск товаров по нескольким фильтрам
     * @param string $name фильтр наименования товара
     * @param int $category идентификатор категории товара
     * @param int $subcategory идентификатор подкатегории товара
     * @return array массив товаров
     */
    public function getItemsByNopriceParametersSub(string $name, int $category, int $subcategory): array
    {
        $parametersArray = [];

        $insertString = "%$name%";

        if ($name !== '') {
            $nameString = 'name LIKE ?';
            array_push($parametersArray, $insertString);
        } else {
            $nameString = '';
        };

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

        $subcategoryString = "AND category_id = $subcategory";

        $parametersArray = array_merge($parametersArray, $category);

        $place_holders = implode(',', array_fill(0, count($category), '?'));
        $catalogString = "AND category_id IN ($place_holders)";

        $query = "SELECT * FROM catalog WHERE $nameString $catalogString $subcategoryString";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($parametersArray);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Поиск товаров по всем фильтрам
     * @param string $price фильтр цены товара
     * @param string $name фильтр наименования товара
     * @param int $category идентификатор категории товара
     * @param int $subcategory идентификатор подкатегории товара
     * @return array массив товаров
     */
    public function getItemsByAllParametersSub(string $price, string $name, int $category, int $subcategory): array
    {
        $parametersArray = [];

        $insertString = "%$name%";

        if  ($price !== '') {
            $priceArray = explode('-', $price);
            array_unshift($parametersArray, $priceArray[0], $priceArray[1]);
        }

        $priceString = ($price !== '') ? '(price BETWEEN ? AND ?)' : 'price > 0';

        if ($name !== '') {
            $nameString = 'AND name LIKE ?';
            array_push($parametersArray, $insertString);
        } else {
            $nameString = '';
        };

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

        $subcategoryString = "AND category_id = $subcategory";

        $parametersArray = array_merge($parametersArray, $category);

        $place_holders = implode(',', array_fill(0, count($category), '?'));
        $catalogString = "AND category_id IN ($place_holders)";

        $query = "SELECT * FROM catalog WHERE $priceString $nameString $catalogString $subcategoryString";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($parametersArray);
        $result = $statement->fetchAll();

        return $result;
    }
}


