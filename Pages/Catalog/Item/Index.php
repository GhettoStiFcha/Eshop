<?php
    // print_r($_GET['id'])
?>
<?php
    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Catalog\CatalogItems;

    $catalog = new CatalogItems();
    $item = $catalog->getItem($_GET['id']);

    // print_r($rootCategories);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Товар</title>
</head>

<body>
    <div class="wrapper">
        <?php include('C:\xampp\htdocs\inc\header.php'); ?>
        <nav class="breadcrumbs">
            <li class="breadcrumbs-item">
                <a href="/pages/catalog" class="breadcrumbs-link">Каталог</a>
            </li>
            <li class="breadcrumbs-item">
                <a href="" class="breadcrumbs-link">Мужчинам</a>
            </li>
            <li class="breadcrumbs-item">
                <a href="" class="breadcrumbs-link"><?=$item['name']?></a>
            </li>
        </nav>
        <section class="item">
            <div class="item-image" style="background-image: url(<?=$item['image_url']?>)"></div>
            <div class="item-title"><?=$item['name']?></div>
            <div class="item-article">Артикул: 355655</div>
            <div class="item-price"><?=$item['price']?> руб.</div>
            <div class="item-discription">
                Отличные кроссовки из водонепроницаемого материала. Отлично подходят для любой погоды. 
                Приятно сидят на ноге, стильные и комфортные.
            </div>
            <div class="item-size-box">
                <div class="item-size">41</div>
                <div class="item-size">42</div>
                <div class="item-size">43</div>
                <div class="item-size">44</div>
            </div>
            <div class="btn card-btn" onclick="addItemToCart(<?=$item['id']?>)">Добавить в корзину</div>
            <div class="btn card-btn" onclick="removeItemFromCart(<?=$item['id']?>)">Удалить из корзины</div>
        </section>
            
        <?php include('C:\xampp\htdocs\inc\footer.php'); ?>
    </div>

    <script src="/js/addToCart.js"></script>
</body>

</html>