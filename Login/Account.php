<?php

    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\UserData;
    $userData = new UserData();

    if(isset($_SESSION['user_id'])) {
        $user = $userData->getUserDataById($_SESSION['user_id']);
    } else {
        header('location: ' . $_SERVER['REQUEST_SHEME'] . '/Login/Login.php');
    }

    $result = $userData->activityCheck($user['email']);

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
        <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\header.php'); ?>
        <div class="fullscreen">
            <div class="account-box">
                <div class="account-text-box">
                    <h1 class="account-h1">Личный кабинет</h1>
                    <div class="account-hello">
                        Доброго времени суток, <?=$user['name']?>!
                    </div>
                    <div class="account-phone">
                        Ваш телефон: <?=$user['phone_number']?>
                    </div>
                    <div class="account-email">
                        Ваш email: <?=$user['email']?>
                    </div>
                </div>
                <a href="/Login/OrderHistory.php" class="login-destroy-btn">
                        История заказов
                </a>
                <?php if($result['activity'] == 1): ?>
                    <div class="login-destroy-btn" onclick="openDestroyPopup('email')">
                        Отказаться от рассылки
                    </div>
                    <a href="/Login/Login.php" class="login-destroy-btn" onclick="sessionDestroy()">
                        Выйти
                    </a>
                <?php else: ?>
                    <a href="/Login/Login.php" class="login-destroy-btn" onclick="sessionDestroy()">
                        Выйти
                    </a>
                    <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\emailForm.php'); ?>
                <?php endif; ?>
                
            </div>
        </div>
        <p class="cart-error-sign"><?=$destroyError?></p>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\footer.php'); ?>
    </div>
    
    <div class="popup" id="emailDestroyPopup">
        <div class="popup-inner">
            <div class="popup-inner-text">Отказаться от рассылки?</div>
            <div class="destroy-form">
                <div class="login-destroy-btn" onclick="emailDestroy(`<?=$user['email']?>`, 'email')">
                    Да
                </div>
                <div class="login-destroy-btn" onclick="closeDestroyPopup('email')">
                    Нет
                </div>
            </div>  
        </div>
    </div>
    
    <script src="/js/account.js"></script>
</body>