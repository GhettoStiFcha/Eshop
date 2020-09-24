<?php

namespace Controllers\Sessions;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Sessions\UserCart;

$item = new UserCart();

echo json_encode($item->removeItem($_GET['id']));
// echo json_encode($item->removeItem($_GET['id']));