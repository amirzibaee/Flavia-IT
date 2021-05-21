<?php

require_once __DIR__ . '/vendor/autoload.php';

use Amirzibaee\DrinksMachine\Controllers\Database;
use Amirzibaee\DrinksMachine\Controllers\Machine;
use Amirzibaee\DrinksMachine\Controllers\Drinks;


/**
 * commented example
 *
 */
//
//Database::connect();
//
//$machine = new Machine;
//$drinks = new Drinks;
//
//$drinks->addContainer('pepsi', 'Pepsi', 10, 1);
//$drinks->addContainer('fanta', 'Fanta',10, 2);
//
//$out = $machine->getDrink('pepsi', ['2'=>1,'1'=>3]);
//
//
//var_dump($out);
//
//var_dump(unserialize(Database::get('monies')));
//var_dump(unserialize(Database::get('containers')));