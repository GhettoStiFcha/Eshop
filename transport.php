<?php

require('vendor/autoload.php');

// interface
// abstact class
// class
// trait

// abstract class
use Absract\Vehicle;

//class
use Controllers\Bycicle;
use Controllers\Truck;

$truck = new Truck();
$truck->openTank();
$truck->fillTank();
$truck->closeTank();
$truck->start();
$truck->stop();

echo '<br>';

$bycicle = new Bycicle();
$bycicle->start();
$bycicle->pedal();
$bycicle->stop();

// $vehicle = new Vehicle;
// $vehicle->start();