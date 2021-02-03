<?php

namespace Controllers\Sessions;

use \PDO;
use Database\MysqlConnection;

class UserData
{
    private $db;
    private $connection;
    private $lastInsertId;

    public function __construct()
    {
        $this->connection = MysqlConnection::connect();
        session_start();
    }

    /**
     * Запись данных пользователя в базу данных (регистрация)
     * @param string $login логин пользователя
     * @param string $pass пароль пользователя
     * @param string $name имя пользователя
     * @param string $surname фамилия пользователя
     * @param string $phone телефон пользователя
     * @param string $email адрес электронной почты пользователя
     * @return array массив с данными пользователя
     */
    public function insertUserData(?string $login = null, ?string $pass = null, ?string $name = null, ?string $surname = null, ?int $phone = null, ?string $email = null)
    {
        $query = "INSERT INTO users (`login`, `password`, `name`, `surname`, `phone_number`, `email`) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->execute([$login, $pass, $name, $surname, $phone, $email]);
        $this->lastInsertId = $this->connection->lastInsertId();

        return $result;
    }

    /**
     * Проверка логина пользователя на уникальность
     * @param string $login логин пользователя
     * @return результат проверки
     */
    public function isLoginUnique(?string $login = null)
    {
        $query = "SELECT * FROM users WHERE login = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$login]);
        $result = $statement->fetch();
        return $result;
    }

    /**
     * Добавление email пользователя в базу данных
     * @param string $email электронный адрес пользователя
     * @return результат добавления
     */
    public function insertUserEmail(?string $email = null)
    {
        $query = "INSERT INTO email (`email`) VALUES (?)";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->execute([$email]);

        return $result;
    }

    /**
     * Получение данных о пользователе
     * @param string $login логин пользователя
     * @param string $pass пароль пользователя
     * @return array массив с данными о пользователе
     */
    public function getUserData(?string $login = null, ?string $pass = null)
    {
        $query = "SELECT * FROM users WHERE login = ? AND password = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);   
        $statement->execute([$login, $pass]);
        $result = $statement->fetch();

        return $result;
    }

    /**
     * Получение данных о пользователе через идентификатор
     * @param string $id идентификатор пользователя
     * @return array массив с данными о пользователе
     */
    public function getUserDataById(?int $id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$id]);
        $result = $statement->fetch();

        return $result;
    }

    /**
     * Обращение к переменной
     */
    public function lastInsertId()
    {
        return $this->lastInsertId;
    }

    /**
     * Отключение рассылки для пользователя
     * @param string $email эл.почта пользователя
     * @return результат отключения
     */
    public function emailDestroy(string $email)
    {
        $query = "UPDATE email SET activity = '0' WHERE email = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->execute([$email]);

        return $result;
    }

    /**
     * Включение рассылки для пользователя
     * @param string $email эл.почта пользователя
     * @return результат отключения
     */
    public function emailInclusion(string $email)
    {
        $query = "UPDATE email SET activity = '1' WHERE email = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->execute([$email]);

        return $result;
    }

    /**
     * Определение активности рассылки для пользователя
     * @param string $email эл.почта пользователя
     * @return результат проверки
     */
    public function activityCheck(string $email)
    {
        $query = "SELECT activity FROM email WHERE email = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$email]);
        $result = $statement->fetch();

        return $result;
    }
}


