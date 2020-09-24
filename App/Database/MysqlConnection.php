<?php

namespace Database;

use Database\Interfaces\ConnectionInterface;
use \PDO;

class MysqlConnection implements ConnectionInterface
{
    private const HOST = "127.0.0.1";
    private const DB_NAME = "e-shop";
    private const PASSWORD = "";
    private const DB_USER = "root";

    public static function connect()
    {
        $connectString = sprintf(
            "mysql:host=%s;dbname=%s",
            self::HOST,
            self::DB_NAME
        );

        $db = new PDO(
            $connectString,
            self::DB_USER,
            self::PASSWORD
        );

        return $db;
    }
}
