<?php

    $configs = include($_SERVER['DOCUMENT_ROOT'] . '/config.php');  

    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\Login;
    use Controllers\Sessions\Register;

    $login = new Login();
    $register = new Register();

    $register->redirectUserIfLoggedIn();

    if(!empty($_POST)) {
        $loginError = $login->LogInUser();
    }

?>


<!DOCTYPE html>
<html>

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
            <h1 class="login-h1">Вход в личный кабинет</h1>
            <form class="login-form" method="POST">
                <div class="form-item">
                    <input class ="login-form-input" type="text" name="login" placeholder="Введите логин">
                </div>
                <div class="form-item">
                    <input class ="login-form-input" type="password" name="pass" placeholder="Введите пароль">
                </div>
                <div class="form-item">
                    <input class ="login-form-submit" type="submit" value="Войти">
                </div>
                <?=$loginError;?>
            </form>
        </div>
        
        <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\footer.php'); ?>
    </div>
</body>

</html>