<?php

namespace Controllers\Sessions;

use Controllers\Sessions\CartInterface;

class UserCart implements CartInterface
{
    public function __construct()
    {
        session_start();
    }

    /**
     * Добавление одной единицы товара в корзину
     * @param int $id идентификатор товара
     * @param int $size идентификатор размера товара
     * @return Значение количества товара в корзине
     */
    public function addItem(int $id, ?int $size): int
    {
        $issetID = false;
        $itemNumber = 0;
        $_SESSION['item'] = isset($_SESSION['item']) ?  $_SESSION['item'] : [];
        foreach($_SESSION['item'] as $index => $value) {
            if ($value['id'] === $id && $value['size_id'] === $size) {
                $issetID = true;
                $itemNumber = $index;
                break;
            }
        }
        if ($issetID) {
            $_SESSION['item'][$itemNumber]['amount']++;
        } else {
            $_SESSION['item'][] = [
                'id' => $id,
                'amount' => 1,
                'size_id' => $size
            ];
        }

        return $_SESSION['item'][$itemNumber]['amount'];
        
    }

    /**
     * Удаление одной единицы товара из корзины
     * @param int $id идентификатор товара
     * @param int $size идентификатор размера товара
     * @return Значение количества товара в корзине
     */
    public function removeItem(int $id, ?int $size): int
    {
        $issetID = false;
        $itemNumber = 0;
        $_SESSION['item'] = isset($_SESSION['item']) ?  $_SESSION['item'] : [];
        foreach($_SESSION['item'] as $index => $value) {
            if ($value['id'] === $id && $value['size_id'] === $size) {
                $issetID = true;
                $itemNumber = $index;
                break;
            }
        }
        if ($_SESSION['item'][$itemNumber]['amount'] === 1) {
            unset($_SESSION['item'][$itemNumber]);
        } else if ($issetID) {
            $_SESSION['item'][$itemNumber]['amount']--;
        }

        return $_SESSION['item'][$itemNumber]['amount'];
    }

    /**
     * Удаление товара из корзины
     * @param int $id идентификатор товара
     * @param int $size идентификатор размера товара
     * @return Результат удаления
     */
    public function deleteItem(int $id, ?int $size)
    {
        $issetID = false;
        $itemNumber = 0;
        $_SESSION['item'] = isset($_SESSION['item']) ?  $_SESSION['item'] : [];
        foreach($_SESSION['item'] as $index => $value) {
            if ($value['id'] === $id && $value['size_id'] === $size) {
                $issetID = true;
                $itemNumber = $index;
                break;
            }
        }
        if ($issetID) {
            unset($_SESSION['item'][$itemNumber]);
            return true;
        }
        return false;
    }

    /**
     * Получение всех данных о товаре в корзине
     * @return Массив с данными о товаре
     */
    public function getAllItems(): array
    {
        $result = [];
        if (!isset($_SESSION['item'])) {
            return $result;
        }

        return $_SESSION['item'];
    }

    /**
     * Получение всех товаров в корзине
     * @return Массив с идентификаторами товаров
     */
    public function getItemsIDs(): array
    {
        $item = $this->getAllItems();

        if (empty($item)) {
            return $item;
        }

        $result = [];
        
        foreach($item as $value) {
            array_push($result, $value['id']);
        }
        
        return $result;
    }

    
}