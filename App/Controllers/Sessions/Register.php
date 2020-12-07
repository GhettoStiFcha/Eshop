<?php

namespace Controllers\Sessions;

class Register
{
    public function cleaner(?string $pass = null, ?string $login = null, ?string $name = null, ?string $surname = null, ?int $phone = null, ?string $email = null)
    {
        $result = [];

        $pass = $fClean->formClean($pass);
        $login = $fClean->formClean($login);
        $name = $fClean->formClean($name);
        $surname = $fClean->formClean($surname);
        $phone = $fClean->formClean($phone);
        $email = $fClean->formClean($email);

        array_push($result, $pass, $login, $name, $surname, $phone, $email);

        return $result;
    }
}