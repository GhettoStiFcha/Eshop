<?php

namespace Controllers\Sessions;

require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

use Controllers\Sessions\UserAccount;
use Controllers\Sessions\UserData;
use Controllers\Sessions\FormCleaner;

$user = new UserAccount();
$userData = new UserData();
$fClean = new FormCleaner();

if ($_GET['status'] === 'destroy') {
    echo json_encode($user->sessionDestroy());
} else if (!empty($_GET['email'])){
    $cleanEmail = $fClean->formClean($_GET['email']);
    $email_validate = filter_var($cleanEmail, FILTER_VALIDATE_EMAIL);
    if($email_validate){
        echo json_encode($userData->emailDestroy($cleanEmail));
    }
}
