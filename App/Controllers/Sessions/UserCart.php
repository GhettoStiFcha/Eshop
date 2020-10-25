<?php

namespace Controllers\Sessions;

use Controllers\Sessions\CartInterface;

class UserCart implements CartInterface
{
    public function __construct()
    {
        session_start();
    }

    public function addItem(int $id): int
    {
        $issetID = false;
        $itemNumber = 0;
        $_SESSION['item'] = isset($_SESSION['item']) ?  $_SESSION['item'] : [];
        foreach($_SESSION['item'] as $index => $value) {
            if ($value['id'] === $id) {
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
                'amount' => 1
            ];
        }

        print_r($_SESSION['item']);
        // session_destroy();
        return count($_SESSION['item']);
        
    }

    public function removeItem(int $id): int
    {
        $issetID = false;
        $itemNumber = 0;
        $_SESSION['item'] = isset($_SESSION['item']) ?  $_SESSION['item'] : [];
        foreach($_SESSION['item'] as $index => $value) {
            if ($value['id'] === $id) {
                $issetID = true;
                $itemNumber = $index;
                break;
            }
        }
        if ($_SESSION['item'][$itemNumber]['amount'] === 1) {
            // $_SESSION['item'][$itemNumber] = '';
            unset($_SESSION['item'][$itemNumber]);
        } else if ($issetID) {
            $_SESSION['item'][$itemNumber]['amount']--;
        }

        print_r($_SESSION['item']);
        // session_destroy();
        return count($_SESSION['item']);
    }

    public function deleteItem(int $id)
    {
        $issetID = false;
        $itemNumber = 0;
        $_SESSION['item'] = isset($_SESSION['item']) ?  $_SESSION['item'] : [];
        foreach($_SESSION['item'] as $index => $value) {
            if ($value['id'] === $id) {
                $issetID = true;
                $itemNumber = $index;
                break;
            }
        }
        if ($issetID) {
            unset($_SESSION['item'][$itemNumber]);
        }
    }

    public function getItem(int $id): array
    {

    }

    public function getAllItems(): array
    {
        $result = [];
        if (!isset($_SESSION['item'])) {
            return $result;
        }

        return $_SESSION['item'];
    }

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