<?php

namespace Controllers\Sessions;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Sessions\UserCart;
use Controllers\Catalog\CatalogItems;

$item = new UserCart();

$cart = $item->getAllItems();
$cartItems = $item->getItemsIDs();

$catalog = new CatalogItems();

$jo = $catalog->getItemsByMultipleIDs($cartItems);

foreach($jo as $key => $value) {
    $id = $value['id'];
    foreach($cart as $index => $cartAmount) {
        if ((int)$id === (int)$cartAmount['id']) {
            $jo[$key]['amount'] = $cartAmount['amount'];
            break;
        } 
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Корзина</title>
</head>
<body>
    <div class="wrapper">
        <?php include('C:\xampp\htdocs\inc\header.php'); ?>
        <h1 class="default cart-h1">ВАША КОРЗИНА</h1>
        <div class="cart-alert default">Товары резервируются на ограниченное время</div>
        <div class="cart-box">
            <div class="words-line">
                <div class="word">ФОТО</div>
                <div class="word">НАИМЕНОВАНИЕ</div>
                <div class="word">РАЗМЕР</div>
                <div class="word">КОЛИЧЕСТВО</div>
                <div class="word">СТОИМОСТЬ</div>
                <div class="word">УДАЛИТЬ</div>
            </div>
            <?php if(empty($jo)): ?>
                <p>В корзине пока нет товаров</p>
            <?php else: ?>
                <?php foreach($jo as $key => $value): ?>
                <div><b><?=$value['name']?>(<?=$value['amount']?>):</b> <?=$value['price']?> руб.</div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php include('C:\xampp\htdocs\inc\footer.php'); ?>
        </div>
    </div>
</body>
</html>