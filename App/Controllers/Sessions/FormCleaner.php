<?php

namespace Controllers\Sessions;

class FormCleaner
{

    function formClean($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        
        return $value;
    }

    function lengthCheck($value, $min, $max)
    {
        $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
        return !$result;
    }

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
        
        // array_push($result, $pass, $login, $name, $surname, $phone, $email);

        return $result;

    }

    public function cleanCheck(?string $login = null, ?string $name = null, ?string $surname = null, ?int $phone = null)
    {
        $result = false;
        if($this->lengthCheck($login, 1, 50) && $this->lengthCheck($name, 1, 30) && $this->lengthCheck($surname, 1, 50) && $this->lengthCheck($phone, 11, 14)) {
            $result = true; 
        }

        return $result;

    }
}   

