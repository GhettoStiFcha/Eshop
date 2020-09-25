<?php

    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\UserData;

    $userData = new UserData();
    $user = $userData->getUserData();

    if(!empty($_POST)) {

        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        // md5
        // sha256
        $pass = md5(md5($_POST['pass']));
        $login = $_POST['login'];
        
        echo md5(md5($_POST['pass']));


    }

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
        <h1 class="login-h1">Вход в личный кабинет</h1>
        <form action="" method="POST">
            <input type="text" name="login" placeholder="Введите логин">
            <input type="password" name="pass" placeholder="Введите пароль">
            <input type="submit" value="Войти">
        </form>
        <?php include('C:\xampp\htdocs\inc\footer.php'); ?>
    </div>
</body>

</html>