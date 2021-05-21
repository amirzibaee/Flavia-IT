<?php

namespace Amirzibaee\DrinksMachine\Controllers;

use Predis;

class Database
{
    static private $client;

    static public function connect()
    {
        self::$client = new Predis\Client('tcp://127.0.0.1:6379');
    }

    static public function set($key, $value)
    {
        return self::$client->set($key, $value);
    }

    static public function get($key)
    {
        return self::$client->get($key);
    }
}