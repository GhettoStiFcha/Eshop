<?php

namespace Controllers\Sessions;

class UserAccount implements AccountInterface
{
    public function __construct()
    {
        session_start();
    }

    public function sessionDestroy()
    {

        session_destroy();
        
    }
}