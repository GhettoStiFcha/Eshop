<?php

    error_reporting(0);

    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\UserData;
    use Controllers\Sessions\Order;

    $userData = new UserData();
    $order = new Order();

    if(isset($_SESSION['user_id'])) {
        $user = $userData->getUserDataById($_SESSION['user_id']);
    } else {
        header('location: ' . $_SERVER['REQUEST_SHEME'] . '/Login/Login.php');
    }

    $orderHistory = $order->getOrderHistory();
    

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Авторизация пользователя</title>
</head>
<body>
    <div class="wrapper">
        <?php include('C:\xampp\htdocs\inc\header.php'); ?>
        <h1 class="order-history-h1">ИСТОРИЯ ЗАКАЗОВ</h1>
        <?php if(empty($orderHistory)): ?>
            <p class="cart-empty">Вы пока что ничего не заказали</p>
        <?php else: ?>
            <?php foreach($orderHistory as $key => $singleOrder): ?>
                <div class="order-box">
                    <div class="words-line">
                        <div class="word">ФОТО</div>
                        <div class="word">НАИМЕНОВАНИЕ</div>
                        <div class="word">РАЗМЕР</div>
                        <div class="word">КОЛИЧЕСТВО</div>
                        <div class="word">СТОИМОСТЬ</div>
                        <div class="word">СТАТУС</div>
                    </div>
                    <p class="order-id">
                        Номер заказа: <?=$singleOrder[0]['order_id'];?>
                    </p>
                    <?php $totalPrice = 0?>
                    <?php foreach($singleOrder as $key => $value): ?>
                    <?php $orderStatus = $order->checkOrderStatus($value['order_id']); ?>
                        <div class="order-item-box">
                            <div class="cart-item" id="cartItem" data-productId="<?=$value['id']?>">
                                <div class="cart-item-div cart-item-pic" style="background-image: url(<?=$value['item_image_url']?>)"></div>
                                <div class="cart-item-div cart-item-text">
                                    <div class="cart-item-div cart-item-name"><?=$value['item_name']?></div>
                                    <div class="cart-item-div cart-item-article">арт. 123412</div>
                                </div>
                                <div class="cart-item-div cart-item-size w10"><?=$value['item_size']?></div>
                                <div class="cart-item-div cart-item-amount w10">
                                    <div class="cart-item-amount-text" id="item-<?=$value['id']?>"><?=$value['amount']?></div>
                                </div>
                                <div class="cart-item-div cart-item-price w10"><?=$value['item_price']?> руб.</div>
                                <?php if($orderStatus['activity'] == 1): ?>
                                    <div class="cart-item-div w10">В обработке</div>
                                <?php elseif($orderStatus['activity'] == 2): ?>
                                    <div class="cart-item-div w10">Доставляем</div>
                                <?php else: ?>
                                    <div class="cart-item-div w10">Завершен</div>
                                <?php endif; ?>
                                 
                            </div>
                        </div>
                        <?php $totalPrice += $value['item_price'];?>
                    <?php endforeach; ?>
                    <div class="cart-item-total-price">
                            Всего: <?=$totalPrice?> руб.
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php include('C:\xampp\htdocs\inc\footer.php'); ?>
    </div>
</body>