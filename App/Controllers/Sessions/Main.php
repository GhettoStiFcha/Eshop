<?php

namespace Sessions\Main;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Sessions\MainItems;

$item = new MainItems();

if ( empty($_GET) ) {
    echo json_encode($item->getAllItems());
} else {
    print_r('123');
}