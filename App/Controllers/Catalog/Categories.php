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

    /**
     * Получение родительских категорий
     * @return array массив категорий
     */
    public function getRootCategories(): array
    {
        $statement = $this->connection->prepare('SELECT * FROM categories WHERE parent_id=?');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$this->rootID]);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Получение подкатегорий
     * @param int $parent идентификатор родительской подкатегории
     * @return array массив подкатегорий
     */
    public function getChildCategories(int $parent): array
    {
        $statement = $this->connection->prepare('SELECT * FROM categories WHERE parent_id=?');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$parent]);
        $result = $statement->fetchAll();

        return $result;
    }

}