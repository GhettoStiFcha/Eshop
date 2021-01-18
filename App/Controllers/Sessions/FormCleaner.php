<?php

namespace Controllers\Sessions;

class FormCleaner
{

    /**
     * Очистка данных от ненужных символов
     * @param $value данные из строки формы
     * @return очищенные данные из строки формы
     */
    function formClean($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        
        return $value;
    }

    /**
     * Проверка данных на их длину
     * @param $value данные из строки формы
     * @param $min минимальное количество символов
     * @param $max максимальное количество символов
     * @return результат проверки
     */
    function lengthCheck($value, $min, $max)
    {
        $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
        return !$result;
    }

    /**
     * Отправка данных в метод-уборщик и запись их в массив
     * @param string $pass пароль пользователя
     * @param string $login логин пользователя
     * @param string $name имя пользователя
     * @param string $surname фамилия пользователя
     * @param string $phone телефон пользователя
     * @param string $email адрес электронной почты пользователя
     * @return array массив с данными пользователя
     */
    public function cleaner(?string $pass = null, ?string $login = null, ?string $name = null, ?string $surname = null, ?int $phone = null, ?string $email = null)
    {
        $result = [];

        $pass = $this->formClean($pass);
        $login = $this->formClean($login);
        $name = $this->formClean($name);
        $surname = $this->formClean($surname);
        $phone = $this->formClean($phone);
        $email = $this->formClean($email);

        $result = [
            'pass' => $pass,
            'login' => $login,
            'name' => $name,
            'surname' => $surname,
            'phone' => $phone,
            'email' => $email
        ];

        return $result;

    }

    /**
     * Отправка данных в метод, который проверяет их на длину 
     * @param string $login логин пользователя
     * @param string $name имя пользователя
     * @param string $surname фамилия пользователя
     * @param string $phone телефон пользователя
     * @return результат проверки
     */
    public function cleanCheck(?string $login = null, ?string $name = null, ?string $surname = null, ?int $phone = null)
    {
        $result = false;
        if($this->lengthCheck($login, 1, 50) && $this->lengthCheck($name, 1, 30) && $this->lengthCheck($surname, 1, 50) && $this->lengthCheck($phone, 11, 14)) {
            $result = true; 
        }

        return $result;

    }
}   

