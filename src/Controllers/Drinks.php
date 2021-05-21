<?php

namespace Amirzibaee\DrinksMachine\Controllers;


/**
 * Class Drinks
 *
 */
class Drinks
{
    private $containers = [];

    public function __construct()
    {
        $this->readDatabase();
    }

    public function __destruct()
    {
        $this->writeDatabase();
    }


    /**
     * Read Redis
     *
     */
    private function readDatabase()
    {
        $containers = Database::get('containers');

        $this->containers = !empty($containers) ? unserialize($containers) : [];
    }

    /**
     * Update Redis
     *
     */
    private function writeDatabase()
    {
        Database::set('containers', serialize($this->containers));
    }


    /**
     * @param $key
     * @param $title
     * @param int $total
     * @param int $price
     * @return bool
     *
     */
    public function addContainer($key, $title, $total = 0, $price = 0)
    {
        if (isset($this->containers[$key])) {
            /** @TODO add error */
            return false;
        }

        $this->containers[$key] = [
            'title' => $title,
            'total' => $total,
            'price' => $price,
        ];

        $this->writeDatabase();

        return true;
    }


    /**
     * @param $key
     * @return bool
     *
     */
    public function removeContainer($key)
    {
        if (!isset($this->containers[$key])) {
            /** @TODO add error */
            return false;
        }

        unset($this->containers[$key]);

        $this->writeDatabase();

        return true;
    }


    /**
     * @param $key
     * @return false|mixed
     *
     */
    public function exist($key)
    {
        if(empty($this->containers[$key])){
            return false;
        }

        return $this->containers[$key]['price'];
    }


    /**
     * @param $key
     * @param $count
     * @return false
     *
     */
    public function minusDrink($key, $count)
    {
        if (!isset($this->containers[$key])) {
            /** @TODO add error */
            return false;
        }

        if ($count <= 0) {
            /** @TODO add error */
            return false;
        }

        if ($this->containers[$key]['total'] < $count) {
            /** @TODO add error */
            return false;
        }

        $this->containers[$key]['total'] -= $count;

        $this->writeDatabase();

    }


    /**
     * @param $key
     * @param $count
     * @return false
     *
     *
     */
    public function plusDrink($key, $count)
    {
        if (!isset($this->containers[$key])) {
            /** @TODO add error */
            return false;
        }

        $this->containers[$key]['total'] += $count;

        $this->writeDatabase();
    }


    /**
     * @param $key
     * @param null $title
     * @param null $total
     * @param null $price
     * @return false
     *
     *
     */
    public function updateContainer($key, $title = null, $total = null, $price = null)
    {
        if (!isset($this->containers[$key])) {
            /** @TODO add error */
            return false;
        }

        $this->containers[$key]['title'] = !empty($title) ? $title : $this->containers[$key]['title'];
        $this->containers[$key]['total'] = !empty($total) ? $total : $this->containers[$key]['total'];
        $this->containers[$key]['price'] = !empty($price) ? $price : $this->containers[$key]['price'];

        $this->writeDatabase();

    }
}