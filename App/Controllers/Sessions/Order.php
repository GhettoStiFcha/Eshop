<?php

namespace Controllers\Sessions;

use \PDO;
use Database\MysqlConnection;
use Controllers\Sessions\Register;
use Controllers\Sessions\FormCleaner;

class Order
{
    private $db;
    private $connection;
    private $lastInsertId;
    private $fast_name;
    private $fast_phone;
    private $register;
    private $fClean;

    public function __construct()
    {
        $this->connection = MysqlConnection::connect();
        $this->fast_name = $_POST['fast_name'] ?? null;
        $this->fast_phone = $_POST['fast_phone'] ?? null;
        $this->fClean = new FormCleaner();
        $this->register = new Register();
    }

    /**
     * Добавление заказа зарегистрированного пользователя в базу данных
     * @param int $user_id идентификатор пользователя
     * @return результат добавления
     */
    public function addRegistredUserOrder(?int $user_id)
    {
        $query = "INSERT INTO orders (`user_id`) VALUES (?)";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->execute([$user_id]);
        $this->lastInsertId = $this->connection->lastInsertId();

        return $result;
    }

    /**
     * Добавление заказа незарегистрированного пользователя в базу данных
     * @param string $name имя пользователя
     * @param string $phone телефон пользователя
     * @return результат добавления
     */
    public function addRandomUserOrder(?string $fast_name = null, ?int $fast_phone = null)
    {
        $query = "INSERT INTO orders (`user_name`, `user_phone`) VALUES (?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->execute([$fast_name, $fast_phone]);
        $this->lastInsertId = $this->connection->lastInsertId();

        return $result;
    }

    /**
     * Добавление товаров из заказа в базу данных
     * @param int $id идентификатор товара
     * @param string $item_name наименование товара
     * @param string $amount телефон пользователя
     * @param int $sizeID идентификатор размера товара
     * @param int $orderID идентификатор заказа
     * @return результат добавления
     */
    public function addOrderItems(?int $id = null, ?string $item_name = null, ?int $amount = null, ?int $sizeID = null, ?int $orderID = null)
    {
        $query = "INSERT INTO order_items (`item_id`, `item_name`, `amount`, `item_size_id`, `order_id`) VALUES (?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->execute([$id, $item_name, $amount, $sizeID, $orderID]);

        return $result;
    }

     /**
     * Обращение к переменной
     */
    public function lastInsertId()
    {
        return $this->lastInsertId;
    }

    public function addOrder(array $jo)
    {
        $orderError = '';

        if(empty($this->fast_phone)) {
            $dataError = $register->addUser(0);
            if(empty($dataError)){
                $orderDataError = $this->addRegistredUserOrder($_SESSION['user_id']);
            } else {
                $orderError = 'Упс... Произошла какая-то ошибка. Попробуйте снова!';
            }
        } else if(!empty($this->fast_name) && !empty($this->fast_phone)) {
            $orderDataError = $this->addRandomUserOrder($this->fast_name, $this->fast_phone);
        }
        if($orderDataError){
            $orderID = $this->lastInsertId();
            foreach($jo as $key => $value){
                $this->addOrderItems($value['id'], $value['name'], $value['amount'], $value['size_id'], $orderID);
            }
            $orderError = 'Ваш заказ принят в обработку! В скором времени с Вами свяжется наш менеджер.';
        } else {
            $orderError = 'Упс... Произошла какая-то ошибка. Попробуйте снова!';
        }

        return $orderError;
    }
}
