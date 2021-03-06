<?php
    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Catalog\Categories;
    use Controllers\Catalog\CatalogItems;
    use Controllers\Breadcrumbs\Breadcrumbs;

    $categories = new Categories();
    $items = new CatalogItems();
    $rootCategories = $categories->getRootCategories();

    $br = new Breadcrumbs;
    $br->AddStep('/Pages/Main', 'Главная');
    $br->AddStep(null, 'Каталог');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Каталог товаров</title>
</head>

<body>
    <div class="wrapper">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\header.php'); ?>
        <nav class="breadcrumbs">
            <?php $br->getHtml(); ?>
        </nav>
        <h1 class="default">Каталог товаров</h1>
        <form class="default catalog-form" id="catalog">
            <div class="select-box">
                <select name="category">
                    <option hidden>Выберите категорию</option>
                    <?php foreach($rootCategories as $key => $value): ?>
                        <option value="<?=$value['id']?>"><?=$value['category_name']?></option>
                    <?php endforeach;?>
                </select>
                <select name="subcategory">
                    <option hidden>Выберите подкатегорию</option>
                </select>
                <select name="price">
                    <option hidden>Выберите стоимость</option>
                    <option value="0-6000">0-6000</option>
                    <option value="6000-12000">6000-12000</option>
                    <option value="12000-17000">12000-17000</option>
                    <option value="17000-20000">17000-20000</option>
                </select>
            </div>
            <input name="productName" placeholder="Поиск"> 
        </form>
        <div class="catalog"></div>
        
        <?php include($_SERVER['DOCUMENT_ROOT'] . '\inc\footer.php'); ?>
    </div>
    

    <script src="/js/catalog.js"></script>
</body>

</html>