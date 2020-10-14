<?php

namespace Controllers\Sessions;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Sessions\UserCart;

$item = new UserCart();

if ($_GET['status'] === 'add') {
    echo json_encode($item->addItem($_GET['id']));
} else if ($_GET['status'] === 'remove') {
    echo json_encode($item->removeItem($_GET['id']));
}



