<?php

namespace Controllers\Sessions;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Sessions\UserAccount;
use Controllers\Sessions\UserData;

$user = new UserAccount();
$userData = new UserData();

if ($_GET['status'] === 'destroy') {
    echo json_encode($user->sessionDestroy());
}