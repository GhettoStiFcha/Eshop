<?php

    error_reporting(0);

    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\UserCart;
    use Controllers\Catalog\CatalogItems;
    use Controllers\Catalog\Sizes;
    use Controllers\Breadcrumbs\Breadcrumbs;
    use Controllers\Sessions\Register;
    use Controllers\Sessions\Order;


    $item = new UserCart();
    $size = new Sizes();
    $register = new Register();
    $order = new Order();
    $br = new Breadcrumbs();

    $cart = $item->getAllItems();
    $cartItems = $item->getItemsIDs();

    $catalog = new CatalogItems();

    $uniqueArray = array_unique($cartItems);

    if (count($cartItems) != count($uniqueArray)) {
        foreach($cartItems as $key => $value) {
            $jo[] = $catalog->getItem($value);
        }
    } else {
        $jo = $catalog->getItemsByMultipleIDs($cartItems);
    }

    foreach($jo as $key => $value) { 
        $id = $value['id'];
        foreach($cart as $index => $cartAmount) {
            $filteredSize = $size->getSizes($cartAmount['size_id']);
            if ((int)$id === (int)$cartAmount['id']) {
                $jo[$key]['amount'] = $cartAmount['amount'];
                $jo[$key]['size'] = $filteredSize[0]['size'];
                $jo[$key]['size_id'] = $cartAmount['size_id'];
                unset($cart[$index]);
                break;
            }
        }
    }

    $orderError = '';

    if(!empty($_POST)){
        $orderError = $order->addOrder($jo);
        if($orderError = 'Ваш заказ принят в обработку! В скором времени с Вами свяжется наш менеджер.'){
            unset($_SESSION['item']);
            unset($jo);
        }
    };

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
                <p class="cart-empty">В корзине пока нет товаров</p>
            <?php else: ?>
                <?php foreach($jo as $key => $value): ?>
                <div>
                    <div class="cart-item" id="cartItem" data-productId="<?=$value['id']?>">
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
                <?php $totalPrice += $value['price'];?>
                <?php endforeach; ?>
                <div class="cart-item-total-price">
                    Всего: <?=$totalPrice?> руб.
                </div>
                <div class="cart-buy-buttons-box">
                    <?php if(empty($_SESSION['user_id'])): ?>
                        <div class="cart-buy-button" onclick="openOrderPopup('full')">Оформить заказ</div>
                        <div class="cart-buy-button" onclick="openOrderPopup('fast')">Купить в один клик</div>
                    <?php else: ?>
                        <div class="cart-buy-button" onclick="openOrderPopup('approve')">Купить</div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="words-line"></div>
            <p class="cart-error-sign"><?=$orderError?></p>
        </div>

            <div class="popup" id="fullOrderPopup">
                <div class="popup-inner">
                    <div class="popup-inner-close" onclick="closeOrderPopup('full')"></div>
                    <div class="popup-inner-text">Оформление заказа</div>
                    <form class="login-form" method="POST">
                        <div class="login-form-item-box">
                            <label for="login">Логин:</label>
                            <div class="form-item">
                                <input required pattern="[A-Za-z]{,50}" title="Длина логина не должна превышать 50 символов." class="login-form-input" type="text" name="login" maxlength=50 placeholder="vanya">
                            </div>
                        </div>
                        <div class="login-form-item-box">
                            <label for="password">Пароль:</label>
                            <div class="form-item">
                                <input required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}" title="Пароль должен состоять как минимум из 4 символов латиницы, в которых должна находится как минимум одна цифра и буква верхнего и нижнего регистра" class ="login-form-input" type="password" name="pass" placeholder="Пароль">
                            </div>
                        </div>
                        <div class="form-item">
                            <input required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,}" class="login-form-input" type="password" name="pass-confirm" placeholder="Повторите пароль">
                        </div>
                        <div class="login-form-item-box">
                            <label for="name">Ваше имя:</label>
                            <div class="form-item">
                                <input required pattern="[A-Za-zА-Яа-яЁё]{,30}" title="Не более чем 30 символов" class="login-form-input" type="text" name="name" placeholder="Иван">
                            </div>
                        </div>
                        <div class="login-form-item-box">
                            <label for="surname">Ваша фамилия:</label>
                            <div class="form-item">
                                <input required pattern="[A-Za-zА-Яа-яЁё]{,50}" title="Не более чем 50 символов" class="login-form-input" type="text" name="surname" placeholder="Иванов">
                            </div>
                        </div>
                        <div class="login-form-item-box">
                            <label for="email">Ваш email:</label>
                            <div class="form-item">
                                <input required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="login-form-input" type="email" name="email" placeholder="ivan@ivanmail.com">
                            </div>
                        </div>
                        <div class="login-form-item-box">
                            <label for="phone">Ваш номер телефона:</label>
                            <div class="form-item">
                                <input required pattern="[0-9]{11, 14}" title="Номер телефона не должен содержать буквы или символы" class="login-form-input" type="tel" name="phone" placeholder="79993210011">
                            </div>
                        </div>
                        <div class="form-item">
                            <input class ="login-form-submit" type="submit" value="Оформить заказ и зарегистрироваться">
                        </div>
                        <?=$dataError;?>
                    </form>
                </div>
            </div>

            <div class="popup" id="fastOrderPopup">
                <div class="popup-inner">
                    <div class="popup-inner-close" onclick="closeOrderPopup('fast')"></div>
                    <div class="popup-inner-text">Оформление заказа</div>
                    <form class="login-form" method="POST">
                        <div class="login-form-item-box">
                            <label for="name">Ваше имя:</label>
                            <div class="form-item">
                                <input required pattern="[A-Za-zА-Яа-яЁё]{,30}" title="Не более чем 30 символов" class="login-form-input" type="text" name="fast_name" placeholder="Иван">
                            </div>
                        </div>
                        <div class="login-form-item-box">
                            <label for="phone">Ваш номер телефона:</label>
                            <div class="form-item">
                                <input required pattern="[0-9]{11, 14}" title="Номер телефона не должен содержать буквы или символы" class="login-form-input" type="tel" name="fast_phone" placeholder="79993210011">
                            </div>
                        </div>
                        <div class="form-item">
                            <input class ="login-form-submit" type="submit" value="Купить в один клик">
                        </div>
                        <?=$dataError;?>
                    </form>
                </div>
            </div>

        <?php include('C:\xampp\htdocs\inc\footer.php'); ?>
    </div>


    <script src="/js/addToCart.js"></script>
</body>
</html>