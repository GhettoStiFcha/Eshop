
<?php
    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Catalog\CatalogItems;
    use Controllers\Catalog\Sizes;
    use Controllers\Breadcrumbs\Breadcrumbs;

    $catalog = new CatalogItems();
    $item = $catalog->getItem($_GET['id']);

    $size = new Sizes();
    $getItemSize = $size->getItemSizes($_GET['id']);

    $filteredSizes = [];
    foreach($getItemSize as $index => $value){
        $filteredSizes[] = $size->getSizes($value['size_id']);
    }

    $br = new Breadcrumbs;
    $br->AddStep('/Pages/Main', 'Главная');
    $br->AddStep('/Pages/Catalog', 'Каталог');
    $br->AddStep(null, $item['name']);


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
        <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\header.php'); ?>
        <nav class="breadcrumbs">
            <?php $br->getHtml(); ?>
        </nav>
        <section class="item">
            <div class="item-image" style="background-image: url(<?=$item['image_url']?>)"></div>
            <div class="item-title"><?=$item['name']?></div>
            <div class="item-article">Артикул: <?=$item['article']?></div>
            <div class="item-price"><?=$item['price']?> руб.</div>
            <div class="item-description"><?=$item['description']?></div>
            <form class="item-size-box" id="itemSizes">
                <select name="size" class="input-box">
                    <option hidden>Выберите размер</option>
                    <?php foreach($filteredSizes as $index => $sizes): ?>
                        <?php foreach($sizes as $index => $value): ?>
                            <option class="item-size" value="<?=$value['id']?>"><?=$value['size']?></option>
                        <?php endforeach;?>
                    <?php endforeach;?> 
                </select>
                <div id="addButton" class="btn cart-btn" onclick="addItemToCart(<?=$item['id']?>);">Добавить в корзину</div>
                <div id="removeButton" class="btn cart-btn" onclick="removeItemFromCart(<?=$item['id']?>)">Удалить из корзины</div>
            </form>
        </section>
            
        <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\footer.php'); ?>
    </div>

    <script src="/js/addToCart.js"></script>
    <!-- <script src="/js/sizes.js"></script> -->
</body>

</html>