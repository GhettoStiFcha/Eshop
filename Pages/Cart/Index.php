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
                <div>
                    <div class="cart-item" id="cartItem">
                        <div class="cart-item-div cart-item-pic" style="background-image: url(?)"></div>
                        <div class="cart-item-div cart-item-text">
                            <div class="cart-item-div cart-item-name"><?=$value['name']?></div>
                            <div class="cart-item-div cart-item-article">арт. 123412</div>
                        </div>
                        <div class="cart-item-div cart-item-size w10">M</div>
                        <div class="cart-item-div cart-item-amount w10">
                            <div class="cart-item-amount-text"><?=$value['amount']?></div>
                            <div class="cart-item-amount-button-box">
                                <div class="cart-item-amount-button" onclick="addItemToCart(<?=$value['id']?>)">+</div>
                                <div class="cart-item-amount-button" onclick="removeItemFromCart(<?=$value['id']?>)">-</div>
                            </div>
                        </div>
                        <div class="cart-item-div cart-item-price w10"><?=$value['price']?> руб.</div>
                        <div class="cart-item-div cart-item-delete w10" onclick="deleteItemFromCart(<?=$value['id']?>), document.getElementById('cartItem').style.display = 'none'"></div>   
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php include('C:\xampp\htdocs\inc\footer.php'); ?>
            <script src="/js/addToCart.js"></script>
        </div>
    </div>
</body>
</html>