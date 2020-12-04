<?php

    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\UserData;
    use Controllers\Sessions\FormCleaner;

    $userData = new UserData();
    $fClean = new FormCleaner();
    
    print_r($userData->lastInsertId());

    error_reporting(0);
    $dataError = '';

    session_start();
    if (!empty($_SESSION['user_id'])) {
        header('location: ' . $_SERVER['REQUEST_SHEME'] . '/Login/Account.php');
    }

    if(!empty($_POST)) {
        $pass = md5(md5($_POST['pass']));
        $login = $_POST['login'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $user = $userData->getUserData($login, $pass);

        $pass = $fClean->formClean($pass);
        $lLogin = $fClean->formClean($login);
        $name = $fClean->formClean($name);
        $surname = $fClean->formClean($surname);
        $phone = $fClean->formClean($phone);
        $email = $fClean->formClean($email);

        if(!empty($login) && !empty($pass) && !empty($name) && !empty($surname) && !empty($phone) && !empty($email) && ($_POST['pass'] === $_POST['pass-confirm'])) {
            $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL); 
            if($fClean->lengthCheck($login, 1, 50) && $fClean->lengthCheck($name, 1, 30) && $fClean->lengthCheck($surname, 1, 50) && $fClean->lengthCheck($phone, 11, 14) && $email_validate) {
                $registration = $userData->insertUserData($login, $pass, $name, $surname, $phone, $email);
                if ($registration) {
                    
                    session_start();
                    $_SESSION['user_id'] = $userData->lastInsertId();
                    header('location: ' . $_SERVER['REQUEST_SHEME'] . '/Login/Account.php');
                } else {
                    echo "<script type='text/javascript'>console.log('Упс... Произошла какая-то ошибка. Попробуйте снова!');</script>";
                }
            } else {
                $dataError = 'Данные введены неверно.';
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