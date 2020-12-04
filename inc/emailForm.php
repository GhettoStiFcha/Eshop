<?php
    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\UserData;
    use Controllers\Sessions\FormCleaner;

    $userData = new UserData();
    $fClean = new FormCleaner();

    // error_reporting(0);
    $dataError = '';

    if(!empty($_POST)) {
        $email = $_POST['email'];
        $email = $fClean->formClean($email);

        if(!empty($email)) {
            $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL); 
            if($email_validate) {
                $userData->insertUserEmail($email);  
                echo "<script type='text/javascript'>alert('Вы успешно подписались!');</script>";
            } else {
                $dataError = 'Данные введены неверно.';
            }
        }
    }
?>

<div class="subscribe-form-box">
    <h2 class="email-uppertext">БУДЬ ВСЕГДА В КУРСЕ ВЫГОДНЫХ ПРЕДЛОЖЕНИЙ</h2>
    <p class="email-lowertext">подписывайся и следи за новинками и выгодными предложениями</p>
    <form method="POST" class="email-form" id="emailForm">
        <div class="email-form-item">
            <input required pattern="[^ @]+@[^ @]+.[a-z]+" name="email" class="email-form-input" type="email" placeholder="ivan@email.com">
        </div>
        <div class="email-form-item">
            <input name="submit" class="email-form-submit" type="submit" value="подписаться">
        </div>
    </form>
    <?=$dataError?>
</div>