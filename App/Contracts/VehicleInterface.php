<?php

namespace Contracts;

interface VehicleInterface
{
    public function start(): void;
    public function stop(): void;
}