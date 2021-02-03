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
        $this->connection = MysqlConnection::connect();
        $this->email = $_POST['email'] ?? null;
        $this->userData = new UserData();
        $this->fClean = new FormCleaner();
        $this->email_validate = filter_var($this->email, FILTER_VALIDATE_EMAIL); 
    }

    /**
     * Проверка на существования эл.почты пользователя в базе данных
     * @param string $email эл.почта пользователя
     * @return результат проверки
     */
    public function emailCheck(string $email)
    {
        $query = "SELECT id FROM email WHERE email = ?";
        $statement = $this->connection->prepare($query);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$email]);
        $result = $statement->fetch();

        return $result;
    }

    /**
     * Запись email пользователя в базу данных
     * @return string Обозначение ошибки, которая могла возникнуть при ходе действий
     */
    public function sendEmail()
    {
        $dataError = '';
        $subject = 'Hello World';
        $message = 'message';

        if(empty($this->emailCheck($this->email))){
            if(!empty($this->email)) {
                if($this->email_validate) {
                    $this->userData->insertUserEmail($this->email);
                    $mailResult = mail($this->email, $subject, $message);
                } else {
                    $dataError = 'Данные введены неверно.';
                }
            }
        } else {
            $result = $this->userData->activityCheck($this->email);
            if ($result['activity'] == 0){
                $inclusion = $this->userData->emailInclusion($this->email);
            } else if($result['activity'] == 1) {
                echo "<script type='text/javascript'>alert('Вы уже подписаны!');</script>";  
            } else {
                $dataError = 'Упс... Что-то пошло не так. Попробуйте снова!';
            }
            if($inclusion){
                $mailResult = mail($this->email, $subject, $message);
            } else {
                $dataError = 'Упс... Что-то пошло не так. Попробуйте снова!';
            }
        }
        if($mailResult){
            header('Refresh:0');
        } else if ($result['activity'] == 1) {
            $dataError = '';
        } else {
            $dataError = 'Упс... Что-то пошло не так. Попробуйте снова!';
        }
        

        return $dataError;
    }
}