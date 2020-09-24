<?php

namespace Traits;

trait Tank
{
    public function openTank()
    {
        echo 'Открываем бак<br>';
    }

    public function closeTank()
    {
        echo 'Закрываем бак<br>';
    }

    public function fillTank()
    {
        echo 'Заправляем бак<br>';
    }
}
