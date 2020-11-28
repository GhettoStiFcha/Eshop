<?php

namespace Controllers\Sessions;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Sessions\UserCart;
use Controllers\Catalog\CatalogItems;
use Controllers\Catalog\Sizes;
use Controllers\Breadcrumbs\Breadcrumbs; 

$item = new UserCart();
$size = new Sizes();

$cart = $item->getAllItems();
$cartItems = $item->getItemsIDs();

$catalog = new CatalogItems();

$place_holders = implode(',', array_fill(0, count($cartItems), '?'));
// print_r($place_holders . '<br>');

$jo = $catalog->getItemsByMultipleIDs($cartItems);

// print_r($cartItems);
// print_r($jo);

foreach($jo as $key => $value) { 
    $id = $value['id'];
    foreach($cart as $index => $cartAmount) {
        $filteredSize = $size->getSizes($cartAmount['size_id']);
        if ((int)$id === (int)$cartAmount['id']) {
            $jo[$key]['amount'] = $cartAmount['amount'];
            $jo[$key]['size'] = $filteredSize[0]['size'];
            $jo[$key]['size_id'] = $cartAmount['size_id'];
            break;
        }
    }
}

// print_r($jo);
// print_r($_SESSION);

$br = new Breadcrumbs;
$br->AddStep('/Pages/Main', 'Главная');
$br->AddStep(null, 'Корзина');

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
        <nav class="breadcrumbs">
            <?php $br->getHtml(); ?>
        </nav>
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
                        <div class="cart-item-div cart-item-pic" style="background-image: url(<?=$value['image_url']?>)"></div>
                        <div class="cart-item-div cart-item-text">
                            <div class="cart-item-div cart-item-name"><?=$value['name']?></div>
                            <div class="cart-item-div cart-item-article">арт. 123412</div>
                        </div>
                        <div class="cart-item-div cart-item-size w10"><?=$value['size']?></div>
                        <div class="cart-item-div cart-item-amount w10">
                            <div class="cart-item-amount-text" id="item-<?=$value['id']?>"><?=$value['amount']?></div>
                            <div class="cart-item-amount-button-box">
                                <div class="cart-item-amount-button" onclick="addAmount(<?=$value['id']?>,<?=$value['size_id']?>)">+</div>
                                <div class="cart-item-amount-button" onclick="removeAmount(<?=$value['id']?>,<?=$value['size_id']?>)">-</div>
                            </div>
                        </div>
                        <div class="cart-item-div cart-item-price w10"><?=$value['price']?> руб.</div>
                        <div class="cart-item-div cart-item-delete w10" onclick="deleteItemFromCart(<?=$value['id']?>,<?=$value['size_id']?>)"></div> 
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php include('C:\xampp\htdocs\inc\footer.php'); ?>
    </div>


    <script src="/js/addToCart.js"></script>
</body>
</html>