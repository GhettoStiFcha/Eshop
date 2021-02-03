<?php

namespace Controllers\Sessions;

use \PDO;
use Database\MysqlConnection;
use Controllers\Sessions\UserData;

class Login
{
    private $pass;
    private $login;
    private $userData;
    private $user;

    public function __construct()
    {
        $this->pass = md5(md5($_POST['pass'] ?? null));
        $this->login = $_POST['login'] ?? null;
        $this->userData = new UserData();
    }

    /**
     * Авторизация пользователя
     * @return string Обозначение ошибки, которая могла возникнуть при ходе действий
     */
    public function LogInUser()
    {
        $loginError = '';

        $user = $this->userData->getUserData($this->login, $this->pass);

        if (!empty($user)) {
            $_SESSION['user_id'] = $user['id'];
            session_start();
            header('location: ' . $_SERVER['REQUEST_SHEME'] . '/Login/Account.php');
        } else {
            $loginError =  'Неверные имя пользователя или пароль.';
        }

        return $loginError;
    }
    
}