<?php

namespace Controllers\Sessions;

use \PDO;
use Database\MysqlConnection;
use Controllers\Sessions\UserData;
use Controllers\Sessions\FormCleaner;

class Email
{
    private $email;
    private $userData;
    private $fClean;
    private $email_validate;

    public function __construct()
    {
        $this->email = $_POST['email'] ?? null;
        $this->userData = new UserData();
        $this->fClean = new FormCleaner();
        $this->email_validate = filter_var($this->email, FILTER_VALIDATE_EMAIL); 
    }

    /**
     * Запись email пользователя в базу данных
     * @return string Обозначение ошибки, которая могла возкинуть при ходе действий
     */
    public function sendEmail()
    {
        $dataError = '';

        if(!empty($this->email)) {
            if($this->email_validate) {
                $this->userData->insertUserEmail($this->email);  
                echo "<script type='text/javascript'>alert('Вы успешно подписались!');</script>";
            } else {
                $dataError = 'Данные введены неверно.';
            }
        }

        return $dataError;
    }
}