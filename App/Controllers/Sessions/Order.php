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
    private $userID;

    public function __construct()
    {
        $this->connection = MysqlConnection::connect();
        $this->fast_name = $_POST['fast_name'] ?? null;
        $this->fast_phone = $_POST['fast_phone'] ?? null;
        $this->userID = $_POST['user_id'] ?? null;
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
    public function addOrderItems(?int $id = null, ?string $item_name = null, ?string $size_name = null, ?int $amount = null, ?int $item_price = null, ?int $orderID = null, ?string $image_url = null)
    {
        $query = "INSERT INTO order_items (`item_id`, `item_name`, `item_size`, `amount`, `item_price`, `order_id`, `item_image_url`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->execute([$id, $item_name, $size_name, $amount, $item_price, $orderID, $image_url]);

        return $result;
    }

    /**
     * Поиск заказов, сделанных конкретным пользователем
     * @param int $userID идентификатор пользователя
     * @return array массив с заказами пользователя
     */
    public function checkUserOrders(int $userID)
    {
        $query = "SELECT id FROM orders WHERE user_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$userID]);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Поиск товаров, находящихся в заказе
     * @param int $orderID идентификатор заказа
     * @return array массив с заказами пользователя
     */
    public function checkOrderItems(int $orderID)
    {
        $query = "SELECT * FROM order_items WHERE order_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$orderID]);
        $result = $statement->fetchAll();

        return $result;
    }

    /**
     * Проверка статуса заказа
     * @param $orderID идентификатор заказа
     * @return array идентификатор статуса заказа
     */
    public function checkOrderStatus(int $orderID)
    {
        $query = "SELECT activity FROM orders WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$orderID]);
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
     * Проверка данных и вызов соотоветствующих методов для занесения заказа в базу данных
     * @param array $jo массив с товарами из корзины
     * @return string Обозначение ошибки или сообщения для пользователя
     */
    public function addOrder(array $jo)
    {
        $orderError = '';

        if(empty($this->fast_phone) && empty($this->userID)) {
            $dataError = $register->addUser(0);
            if(empty($dataError)){
                $orderDataError = $this->addRegistredUserOrder($_SESSION['user_id']);
            } else {
                $orderError = 'Упс... Произошла какая-то ошибка. Попробуйте снова!';
            }
        } else if(!empty($this->fast_name) && !empty($this->fast_phone)) {
            $name = $this->fClean->formClean($this->fast_name);
            $phone = $this->fClean->formClean($this->fast_phone);
            $orderDataError = $this->addRandomUserOrder($name, $phone);
        } else if(!empty($this->userID)) {
            $orderDataError = $this->addRegistredUserOrder($_SESSION['user_id']);
        }
        if($orderDataError){
            $orderID = $this->lastInsertId();
            foreach($jo as $key => $value){
                $this->addOrderItems($value['id'], $value['name'], $value['size'], $value['amount'], $value['price'], $orderID, $value['image_url']);
            }
            $orderError = 'Ваш заказ принят в обработку! В скором времени с Вами свяжется наш менеджер.';
        } else {
            $orderError = 'Упс... Произошла какая-то ошибка. Попробуйте снова!';
        }

        return $orderError;
    }

    /**
     * Получение истории заказов пользователя
     * @return array Массив товаров, заказанных пользователем
     */
    public function getOrderHistory()
    {
        $userOrders = $this->checkUserOrders($_SESSION['user_id']);

        $orderItems = [];
        foreach($userOrders as $key => $value){
            $orderItems[] = $this->checkOrderItems($value['id']);
        }   
    
        return $orderItems;

    }
}
