<?php

namespace Absract;

use Contracts\VehicleInterface;

abstract class Vehicle implements VehicleInterface
{
    public function start(): void
    {
        echo 'Начинаем движение<br>';
    }
    public function stop(): void
    {
        echo 'Заканчиваем движение<br>';
    }
}