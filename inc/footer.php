<?php
    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\MainItems;

    $main = new MainItems();

    $men = count($main->getItemsFromCatalog(1));
    $women = count($main->getItemsFromCatalog(2));
    $children = count($main->getItemsFromCatalog(3));
    $all = $men + $women + $children;

?>

<footer class="footer" id="contacts">
    <div class="footer-lside">
        <h2 class="footer-side-head">КОЛЛЕКЦИИ</h2>    
        <p class="footer-side-text">
            <a href="/pages/catalog/?category=2&subcategory=&price=&productName=">Женщинам (<?=$women?>)</a>
        </p>
        <p class="footer-side-text">
            <a href="/pages/catalog/?category=1&subcategory=&price=&productName=">Мужчинам (<?=$men?>)</a>
        </p>
        <p class="footer-side-text">
            <a href="/pages/catalog/?category=3&subcategory=&price=&productName=">Детям (<?=$children?>)</a>
        </p>
        <p class="footer-side-text">
            <a href="/pages/catalog/">Новинки (<?=$all?>)</a>
        </p>
    </div>
    <nav class="footer-box">
        <div class="footer-side-text-box"> 
            <h2 class="footer-side-head">МАГАЗИН</h2>   
            <p class="footer-side-text">
                <a href="#">О нас</a>
            </p>
            <p class="footer-side-text">
                <a href="#">Доставка</a>
            </p>
            <p class="footer-side-text">
                <a href="#">Работай с нами</a>
            </p>
            <p class="footer-side-text">
                <a href="#">Контакты</a>
            </p>
        </div>
    </nav>
    <div class="footer-rside">
        <div class="footer-side-box"> 
            <h2 class="footer-side-head">МЫ В СОЦИАЛЬНЫХ СЕТЯХ</h2>    
            <p class="footer-side-text">
                Сайт разработан inordic.ru
            </p>
            <p class="footer-side-text">
                2020 © Все права защищены
            </p>
            <div class="footer-social">
                <a href="https://twitter.com" class="footer-social-link tw"></a>
                <a href="https://facebook.com" class="footer-social-link fc"></a>
                <a href="https://instagram.com" class="footer-social-link inst"></a>
            </div>
        </div>
    </div>
</footer>