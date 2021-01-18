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

    /**
     * Получение идентификаторов размеров товара
     * @param int $id идентификатор товара
     * @return array массив размеров
     */
    public function getItemSizes(?int $id): array
    {
        $statement = $this->connection->prepare('SELECT size_id FROM added_sizes WHERE product_id=?');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$id]);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Получение наименования размеров
     * @param int $sizeID идентификатор размера
     * @return array массив с наименованием размеров
     */
    public function getSizes(?int $sizeID): array
    {
        $statement = $this->connection->prepare('SELECT * FROM sizes WHERE id=?');
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$sizeID]);
        $result = $statement->fetchAll();

        return $result;
    }
}