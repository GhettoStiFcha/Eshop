<?php
    $configs = include($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    use Controllers\Sessions\UserData;
    $userData = new UserData();
    if(isset($_SESSION['user_id'])) {
        $userID = $userData->getUserDataById($_SESSION['user_id']);
        $loginBtn = $userID['name'];
        $loginLink = 'Account.php';
        // print_r($user);
    } else {
        $loginBtn = 'Войти';
        $loginLink = 'Login.php';
    }

    if(!empty($_SESSION)) {
        $itemAmount = count($_SESSION['item']);
    } else {
        $itemAmount = '0';
    }
    
?>

<header class="header">
    <nav class="header-nav">
        <a class="header-logo" href="/pages/main"></a>
        <a href="/pages/catalog" class="header-nav-a">Женщинам</a>
        <a href="/pages/catalog" class="header-nav-a">Мужчинам</a>
        <a href="/pages/catalog" class="header-nav-a">Детям</a>
        <a href="/pages/catalog" class="header-nav-a">Новинки</a>
        <a href="#contacts" class="header-nav-a">О нас</a>
    </nav>
    <nav class="header-nav">
        <?php if ($loginBtn !== $userID['name']): ?>
        <a href="/Login/Registration.php" class="header-nav-a">Регистрация</a>  
        <?php endif; ?>
        <a href="/Login/<?=$loginLink?>" class="header-nav-a"><?=$loginBtn?></a>
        <a href="/Pages/Cart/" class="header-nav-a">Корзина(<?=$itemAmount?>)</a>
    </nav>
    
</header>