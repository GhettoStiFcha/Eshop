<?php

namespace Controllers;

use Absract\Vehicle;

class Bycicle extends Vehicle
{
    public function pedal()
    {
        echo 'Крутим педали<br>';
    }
}