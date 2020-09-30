<?php

namespace Controllers\Sessions;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Sessions\UserData;

$user = new UserData();

if (!empty($_POST)) {
    echo json_encode($user->getUserData($_GET['login'], $_GET['pass']));
}
