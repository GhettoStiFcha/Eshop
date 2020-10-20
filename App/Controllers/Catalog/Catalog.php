<?php

namespace Controllers\Catalog;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Catalog\CatalogItems;

$item = new CatalogItems();
$categories = new Categories();

if ( !empty($_GET) && ($_GET['category'] != '')) {
    echo json_encode(
            [
                'items' => $item->getItemsByAllParameters(
                    $_GET['price'],
                    $_GET['productName'],
                    $_GET['category']
                ),

                'category' => $item->searchCategory($_GET['category'])
            ]
        );

} else if (!empty($_GET) && ($_GET['category'] === '')) {
    echo json_encode(
        [
            'items' => $item->getItemsByPrice(
                $_GET['min'], $_GET['max']
            ),

            'category' => $item->searchCategory($_GET['category'])
        ]
    );
} else if (isset ($_GET['from']) && isset($_GET['to']) ) {
    echo json_encode($item->getRangeItems($_GET['from'], $_GET['to']));
    
} else if (isset ($_GET['min']) && isset($_GET['max']) ) {
    echo json_encode($item->getItemsByPrice($_GET['min'], $_GET['max']));

} else if (isset ($_GET['productName']) ) {
    echo json_encode($item->getItemsByName($_GET['productName']));

} else {
    echo json_encode($item->getAllItems());
}