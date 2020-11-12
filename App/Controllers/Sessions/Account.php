<?php

namespace Controllers\Sessions;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Sessions\UserAccount;

$user = new UserAccount();

if ($_GET['status'] === 'destroy') {
    echo json_encode($user->sessionDestroy());
}