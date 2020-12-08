<?php
    $configs = include($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    use Controllers\Sessions\UserData;
    $userData = new UserData();
    if(isset($_SESSION['user_id'])) {
        $userID = $userData->getUserDataById($_SESSION['user_id']);
        $loginBtn = $userID['name'];
        $loginLink = 'Account.php';
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
    <a class="header-logo" href="/pages/main"></a>
    <nav class="header-nav">
        <nav class="header-nav-item">
            <a href="/pages/catalog/?category=2&subcategory=&price=&productName=" class="header-nav-a">Женщинам</a>
            <a href="/pages/catalog/?category=1&subcategory=&price=&productName=" class="header-nav-a">Мужчинам</a>
            <a href="/pages/catalog/?category=3&subcategory=&price=&productName=" class="header-nav-a">Детям</a>
            <a href="/pages/catalog" class="header-nav-a">Новинки</a>
            <a href="#contacts" class="header-nav-a">О нас</a>
        </nav>
        <nav class="header-nav-item">
            <?php if ($loginBtn !== $userID['name']): ?>
            <a href="/Login/Registration.php" class="header-nav-a">Регистрация</a>  
            <?php endif; ?>
            <a href="/Login/<?=$loginLink?>" class="header-nav-a"><?=$loginBtn?></a>
            <a href="/Pages/Cart/" class="header-nav-a">Корзина(<?=$itemAmount?>)</a>
        </nav>
    </nav>
    <nav class="nav-close"></nav>
</header>