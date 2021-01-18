<?php
    require($_SERVER['DOCUMENT_ROOT'] ."/vendor/autoload.php");

    use Controllers\Sessions\Email;

    $email = new Email();

    $dataError = '';

    if(!empty($_POST)) {
       $dataError = $email->sendEmail();
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