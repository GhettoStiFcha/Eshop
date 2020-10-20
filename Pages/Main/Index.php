<?php
    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\MainItems;

    $main = new MainItems();

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Главная страница</title>
</head>

<body>
    <div class="wrapper">
    <?php include('C:\xampp\htdocs\inc\header.php'); ?>
    <h1 class="default mainH1">НОВЫЕ ПОСТУПЛЕНИЯ ОСЕНИ</h1>
    <p class="default mainH1-down">Мы подготовили для Вас лучшие новинки сезона</p>
    <div class="main-btn-box">
        <a class="main-btn" href="/pages/catalog">ПОСМОТРЕТЬ НОВИНКИ</a>
    </div>
    <div class="main-grid"></div>
    

    <?php include('C:\xampp\htdocs\inc\footer.php'); ?>
    </div>

    <script src="/js/main.js"></script>
</body>

</html>