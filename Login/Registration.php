<?php
    error_reporting(0);

    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\Register;

    $register = new Register();

    $register->redirectUserIfLoggedIn();

    if(!empty($_POST)) {
        $dataError = $register->addUser(1);
    }
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Регистрация пользователя</title>
</head>

<body>
    <div class="wrapper">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\header.php'); ?>

        <div class="fullscreen">
            <h1 class="login-h1">Регистрация</h1>
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
                    <input class ="login-form-submit" type="submit" value="Зарегистрироваться">
                </div>
                <?=$dataError;?>
            </form>
        </div>

        <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\footer.php'); ?>
    </div>
    

    
    <script src="/js/account.js"></script>
</body>