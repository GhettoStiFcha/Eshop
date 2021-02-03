<?php

namespace Controllers\Sessions;

use \PDO;
use Database\MysqlConnection;
use Controllers\Sessions\UserData;
use Controllers\Sessions\FormCleaner;

class Register
{
    private $pass;
    private $passConfirm;
    private $login; 
    private $name;
    private $surname;
    private $phone;
    private $email;
    private $userData;
    private $fClean;

    public function __construct()
    {
        $this->pass = md5(md5($_POST['pass'] ?? null));
        $this->passConfirm = md5(md5($_POST['pass-confirm'] ?? null));
        $this->login = $_POST['login'] ?? null;
        $this->name = $_POST['name'] ?? null;
        $this->surname = $_POST['surname'] ?? null;
        $this->phone = $_POST['phone'] ?? null;
        $this->email = $_POST['email'] ?? null;
        $this->userData = new UserData();
        $this->fClean = new FormCleaner();
    }

    /**
     * Перенаправление пользователя, если он авторизован
     */
    public function redirectUserIfLoggedIn()
    {
        session_start();

        if (!empty($_SESSION['user_id'])) {
            header('location: ' . $_SERVER['REQUEST_SHEME'] . '/Login/Account.php');
        }
    }

    /**
     * Проверка данных и вызов метода для регитсрации пользователя
     * @param int $redirect вкл./выкл. перенаправление пользователя
     * @return string Обозначение ошибки, которая могла возникнуть при ходе действий
     */
    public function addUser($redirect)
    {
        $dataError = '';
    
        $result = $this->fClean->cleaner($this->pass, $this->login, $this->name, $this->surname, $this->phone, $this->email);
        $unique = $this->userData->isLoginUnique($result['login']);

        if(!empty($result) && ($this->pass === $this->passConfirm)) {
            $email_validate = filter_var($result['email'], FILTER_VALIDATE_EMAIL); 
            if(empty($unique)){
                if($this->fClean->cleanCheck($result['login'], $result['name'], $result['surname'], $result['phone']) && $email_validate) {
                    $registration = $this->userData->insertUserData($result['login'], $result['pass'], $result['name'], $result['surname'], $result['phone'], $result['email']);
                    if ($registration) { 
                        session_start();
                        $_SESSION['user_id'] = $this->userData->lastInsertId();
                        if($redirect){
                            header('location: ' . $_SERVER['REQUEST_SHEME'] . '/Login/Account.php');
                        }
                    } else {
                        $dataError = 'Упс... Произошла какая-то ошибка. Попробуйте снова!';
                    }
                } else {
                    $dataError = 'Данные введены неверно.';
                }
            } else {
                $dataError = 'Данный логин уже занят. Попробуйте другой!';
            }
        }

        return $dataError;
    }
}